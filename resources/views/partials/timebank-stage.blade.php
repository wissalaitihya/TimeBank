         {{-- Left visual area ~55% --}}
            <aside class="tbk-stage">
                {{-- Time markers at edges --}}
                <span class="tbk-time-marker tbk-time-marker--tl" aria-hidden="true">00h</span>
                <span class="tbk-time-marker tbk-time-marker--tr" aria-hidden="true">06h</span>
                <span class="tbk-time-marker tbk-time-marker--bl" aria-hidden="true">12h</span>
                <span class="tbk-time-marker tbk-time-marker--br" aria-hidden="true">18h</span>

                <header class="tbk-masthead">
                    <a href="{{ url('/') }}" class="tbk-logo" aria-label="TimeBank — accueil">
                        <svg class="tbk-logo-clock" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.7"/>
                            <path d="M12 3v2M12 19v2M3 12h2M19 12h2" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                            <path d="M12 7.2V12l3.1 1.9" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="12" cy="12" r="1.1" fill="currentColor"/>
                        </svg>
                        <span class="tbk-logo-word">Time<span class="tbk-logo-word--accent">Bank</span></span>
                    </a>
                </header>

                <div class="tbk-visual">
                    {{-- Orange ribbon — the sole visual identity --}}
                    <div class="tbk-ribbon" aria-hidden="true">
                       

                            {{-- Soft glow behind the ribbon --}}
                            <path class="tbk-ribbon-glow" d="M 420 -30 C 560 60 700 180 740 340 C 780 500 720 600 580 680 C 440 760 220 830 100 870 C 0 900 -40 770 60 690 C 180 600 400 530 580 550 C 760 570 860 420 800 280 C 740 140 600 20 440 -20" filter="url(#tbkRibbonGlow)" opacity="0.28"/>

                            {{-- Dark contour --}}
                            <path class="tbk-ribbon-contour" d="M 420 -30 C 560 60 700 180 740 340 C 780 500 720 600 580 680 C 440 760 220 830 100 870 C 0 900 -40 770 60 690 C 180 600 400 530 580 550 C 760 570 860 420 800 280 C 740 140 600 20 440 -20"/>

                            {{-- Main body --}}
                            <path class="tbk-ribbon-body" d="M 420 -30 C 560 60 700 180 740 340 C 780 500 720 600 580 680 C 440 760 220 830 100 870 C 0 900 -40 770 60 690 C 180 600 400 530 580 550 C 760 570 860 420 800 280 C 740 140 600 20 440 -20"/>

                            {{-- Dark inner core for loop shading --}}
                            <path class="tbk-ribbon-inner" d="M 100 870 C 0 900 -40 770 60 690 C 180 600 400 530 580 550 C 760 570 860 420 800 280"/>

                            {{-- Illuminated edge highlight --}}
                            <path class="tbk-ribbon-edge" d="M 420 -30 C 560 60 700 180 740 340 C 780 500 720 600 580 680 C 440 760 220 830 100 870 C 0 900 -40 770 60 690 C 180 600 400 530 580 550 C 760 570 860 420 800 280 C 740 140 600 20 440 -20"/>
                        </svg>
                    </div>

                    <h1 class="tbk-headline">
                        <span>Ton savoir</span>
                        <span>fait <em>avancer</em></span>
                        <span>quelqu&rsquo;un.</span>
                    </h1>

                    <p class="tbk-copy">
                        <span>&Eacute;change tes comp&eacute;tences.</span>
                        <span>Gagne du temps pour tes propres projets.</span>
                    </p>
                </div>
            </aside>