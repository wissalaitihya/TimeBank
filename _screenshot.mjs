import { spawn } from "child_process";
import { writeFileSync, mkdirSync } from "fs";
import net from "net";

const URL = "http://127.0.0.1:8000/login";
const OUT = "C:\\laragon\\www\\TimeBank\\.opencode\\screenshots";
const EDGE = "C:\\Program Files (x86)\\Microsoft\\Edge\\Application\\msedge.exe";
const DATA_DIR = "C:\\Users\\HP\\AppData\\Local\\Temp\\edge-cdp-screenshot";

const viewports = [
  { name: "desktop-1920x1080", w: 1920, h: 1080 },
  { name: "desktop-1440x900",  w: 1440, h: 900  },
  { name: "tablet-834x1112",   w: 834,  h: 1112 },
  { name: "mobile-390x844",    w: 390,  h: 844  },
];

mkdirSync(OUT, { recursive: true });

function freePort() {
  return new Promise((resolve) => {
    const s = net.createServer();
    s.listen(0, () => { resolve(s.address().port); s.close(); });
  });
}

let msgId = 0;
function cdpSend(ws, method, params = {}) {
  const id = ++msgId;
  return new Promise((resolve, reject) => {
    const handler = (ev) => {
      const msg = JSON.parse(ev.data);
      if (msg.id === id) {
        ws.removeEventListener("message", handler);
        if (msg.error) reject(new Error(JSON.stringify(msg.error)));
        else resolve(msg.result);
      }
    };
    ws.addEventListener("message", handler);
    ws.send(JSON.stringify({ id, method, params }));
  });
}

async function capture(vp) {
  const { w, h, name } = vp;
  const outFile = `${OUT}\\${name}.png`;
  const port = await freePort();

  const cp = spawn(EDGE, [
    `--remote-debugging-port=${port}`,
    `--user-data-dir=${DATA_DIR}-${name}`,
    "--no-first-run", "--disable-extensions", "--disable-default-apps",
    "--no-default-browser-check", "--disable-gpu", "--headless=new",
    `--window-size=${w},${h}`,
    URL,
  ], { stdio: "ignore", detached: true });
  cp.unref();

  let wsUrl;
  for (let i = 0; i < 40; i++) {
    await new Promise((r) => setTimeout(r, 500));
    try {
      const res = await fetch(`http://127.0.0.1:${port}/json`);
      const tabs = await res.json();
      const tab = tabs.find((t) => t.url.includes("/login"));
      if (tab) { wsUrl = tab.webSocketDebuggerUrl; break; }
    } catch {}
  }
  if (!wsUrl) { console.error(`FAIL: ${name}`); cp.kill(); return; }

  const ws = new WebSocket(wsUrl);
  await new Promise((r, ok) => { ws.addEventListener("open", r); ws.addEventListener("error", ok); });
  await new Promise((r) => setTimeout(r, 500));

  await cdpSend(ws, "Emulation.setDeviceMetricsOverride", {
    width: w, height: h, deviceScaleFactor: 1, mobile: false,
  });
  await cdpSend(ws, "Page.enable");
  await new Promise((r) => setTimeout(r, 3500));

  const { data } = await cdpSend(ws, "Page.captureScreenshot", {
    format: "png", clip: { x: 0, y: 0, width: w, height: h, scale: 1 },
  });
  writeFileSync(outFile, Buffer.from(data, "base64"));
  console.log(`OK: ${name} (${w}x${h})`);

  ws.close();
  cp.kill();
}

for (const vp of viewports) await capture(vp);
console.log("All done");
