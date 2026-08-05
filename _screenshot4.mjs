import { spawn } from "child_process";
import { writeFileSync } from "fs";
import net from "net";

const URL = "http://127.0.0.1:8000/login";
const OUT = "C:\\laragon\\www\\TimeBank\\.opencode\\screenshots";
const EDGE = "C:\\Program Files (x86)\\Microsoft\\Edge\\Application\\msedge.exe";
const DATA_DIR = "C:\\Users\\HP\\AppData\\Local\\Temp\\edge-cdp-screenshot";

function freePort() {
  return new Promise(r => { const s = net.createServer(); s.listen(0, () => { r(s.address().port); s.close(); }); });
}

let id = 0;
function cdpSend(ws, method, params = {}) {
  const myId = ++id;
  return new Promise((resolve, reject) => {
    const h = ev => { const m = JSON.parse(ev.data); if (m.id === myId) { ws.removeEventListener("message", h); m.error ? reject(m.error) : resolve(m.result); } };
    ws.addEventListener("message", h);
    ws.send(JSON.stringify({ id: myId, method, params }));
  });
}

async function capture(w, h, name) {
  const outFile = OUT + "\\" + name + ".png";
  const port = await freePort();
  console.log("Starting Edge on port " + port + " for " + name);
  const cp = spawn(EDGE, [
    "--remote-debugging-port=" + port,
    "--user-data-dir=" + DATA_DIR + "-" + name + "-" + Date.now(),
    "--no-first-run", "--disable-extensions", "--disable-default-apps",
    "--no-default-browser-check", "--disable-gpu", "--headless=new",
    "--window-size=" + w + "," + h,
    URL,
  ], { stdio: "ignore", detached: true });
  cp.unref();
  let wsUrl;
  for (let i = 0; i < 60; i++) {
    await new Promise(r => setTimeout(r, 500));
    try {
      const res = await fetch("http://127.0.0.1:" + port + "/json");
      const tabs = await res.json();
      const tab = tabs.find(t => t.url.includes("/login"));
      if (tab) { wsUrl = tab.webSocketDebuggerUrl; break; }
    } catch {}
  }
  if (!wsUrl) { console.error("FAIL: " + name); cp.kill(); return; }
  const ws = new WebSocket(wsUrl);
  await new Promise(r => { ws.addEventListener("open", r); });
  await new Promise(r => setTimeout(r, 500));
  await cdpSend(ws, "Emulation.setDeviceMetricsOverride", { width: w, height: h, deviceScaleFactor: 1, mobile: false });
  await cdpSend(ws, "Page.enable");
  await new Promise(r => setTimeout(r, 4000));
  const { data } = await cdpSend(ws, "Page.captureScreenshot", { format: "png", clip: { x: 0, y: 0, width: w, height: h, scale: 1 } });
  writeFileSync(outFile, Buffer.from(data, "base64"));
  console.log("OK: " + name + " (" + w + "x" + h + ")");
  ws.close();
  cp.kill();
}

await capture(1920, 1080, "desktop-1920x1080");
console.log("Done");
