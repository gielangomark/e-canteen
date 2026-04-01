<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'E-Canteen') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />
        {!! app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']) !!}
        <style>
            body { font-family: 'Inter', sans-serif; margin: 0; overflow-x: hidden; }
            .gradient-primary { background: linear-gradient(135deg, #818cf8 0%, #6366f1 50%, #7c3aed 100%); }
            .float-animation { animation: float 6s ease-in-out infinite; }
            @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-20px); } }

            /* ===== INTRO OVERLAY ===== */
            #intro-overlay {
                position: fixed; inset: 0; z-index: 9999;
                background: #0a0e1a;
                display: flex; align-items: center; justify-content: center; flex-direction: column;
                overflow: hidden;
                transition: opacity 1.2s cubic-bezier(0.4, 0, 0.2, 1);
            }
            #intro-overlay.fade-out { opacity: 0; pointer-events: none; }

            /* Particle canvas */
            #particle-canvas {
                position: absolute; inset: 0; z-index: 0;
            }

            /* Radial glow */
            .intro-glow {
                position: absolute; width: 600px; height: 600px; border-radius: 50%;
                background: radial-gradient(circle, rgba(99,102,241,0.15) 0%, transparent 70%);
                top: 50%; left: 50%; transform: translate(-50%, -50%) scale(0);
                z-index: 1;
            }

            /* Orbiting rings */
            .intro-ring {
                position: absolute; border-radius: 50%; border: 1px solid rgba(129,140,248,0.1);
                top: 50%; left: 50%; transform: translate(-50%, -50%) scale(0);
                z-index: 1;
            }
            .intro-ring:nth-child(1) { width: 200px; height: 200px; }
            .intro-ring:nth-child(2) { width: 350px; height: 350px; }
            .intro-ring:nth-child(3) { width: 500px; height: 500px; }

            /* Main intro logo */
            .intro-logo-wrap {
                position: relative; z-index: 10;
                opacity: 0; transform: scale(0.3) rotate(-180deg);
            }
            .intro-logo {
                width: 120px; height: 120px; border-radius: 28px;
                background: linear-gradient(135deg, #818cf8 0%, #6366f1 40%, #7c3aed 100%);
                display: flex; align-items: center; justify-content: center;
                box-shadow: 0 0 0 0 rgba(99,102,241,0), 0 25px 80px rgba(99,102,241,0.3);
                position: relative;
                overflow: hidden;
            }
            .intro-logo svg { width: 70px; height: 70px; color: white; position: relative; z-index: 3; }

            /* Intro text */
            .intro-title {
                position: relative; z-index: 10;
                margin-top: 40px; text-align: center; opacity: 0; transform: translateY(30px);
            }
            .intro-title h1 {
                font-size: 3.5rem; font-weight: 800; color: white; margin: 0;
                background: linear-gradient(135deg, #c7d2fe, #818cf8, #a78bfa, #c4b5fd);
                background-size: 300% 300%;
                -webkit-background-clip: text; -webkit-text-fill-color: transparent;
                background-clip: text;
            }
            .intro-title p {
                font-size: 1.1rem; color: rgba(148,163,184,0.8); margin-top: 12px;
                letter-spacing: 4px; text-transform: uppercase; font-weight: 300;
            }

            /* Tagline */
            .intro-tagline {
                position: relative; z-index: 10;
                margin-top: 24px; opacity: 0; transform: translateY(20px);
            }
            .intro-tagline p {
                font-size: 1rem; color: rgba(148,163,184,0.6); font-weight: 400;
                text-align: center; max-width: 400px; line-height: 1.7;
            }

            /* Horizontal line reveal */
            .intro-line {
                position: relative; z-index: 10;
                width: 0; height: 1px; margin-top: 30px;
                background: linear-gradient(90deg, transparent, rgba(99,102,241,0.6), transparent);
            }

            /* Loading bar */
            .intro-progress {
                position: absolute; bottom: 60px; z-index: 10;
                width: 200px; height: 2px; background: rgba(255,255,255,0.05);
                border-radius: 2px; overflow: hidden;
            }
            .intro-progress-bar {
                width: 0%; height: 100%; border-radius: 2px;
                background: linear-gradient(90deg, #818cf8, #7c3aed);
            }

            /* Skip button */
            .intro-skip {
                position: absolute; bottom: 30px; z-index: 20;
                color: rgba(148,163,184,0.4); font-size: 0.8rem;
                cursor: pointer; letter-spacing: 2px; text-transform: uppercase;
                border: none; background: none; padding: 8px 16px;
                transition: color 0.3s;
            }
            .intro-skip:hover { color: rgba(148,163,184,0.8); }

            /* Floating food icons */
            .food-icon {
                position: absolute; z-index: 2; font-size: 1.6rem;
                opacity: 0; filter: grayscale(0.3);
            }

            /* Counter */
            .intro-counter {
                position: absolute; top: 40px; right: 50px; z-index: 10;
                font-size: 0.75rem; color: rgba(148,163,184,0.25);
                letter-spacing: 3px; font-variant-numeric: tabular-nums;
            }

            /* Main content hidden initially */
            .main-content {
                opacity: 0; transform: translateY(20px);
                transition: opacity 1s ease, transform 1s ease;
            }
            .main-content.visible {
                opacity: 1; transform: translateY(0);
            }
        </style>
    </head>
    <body class="font-sans antialiased" style="background: #0f172a;">

        <!-- ===== INTRO OVERLAY ===== -->
        <div id="intro-overlay">
            <canvas id="particle-canvas"></canvas>

            <!-- Radial glow -->
            <div class="intro-glow"></div>

            <!-- Orbiting rings -->
            <div class="intro-ring"></div>
            <div class="intro-ring"></div>
            <div class="intro-ring"></div>

            <!-- Floating food emojis -->
            <span class="food-icon" style="top:15%; left:10%;">🍜</span>
            <span class="food-icon" style="top:25%; right:12%;">🍛</span>
            <span class="food-icon" style="bottom:30%; left:8%;">☕</span>
            <span class="food-icon" style="bottom:20%; right:10%;">🥤</span>
            <span class="food-icon" style="top:45%; left:5%;">🍲</span>
            <span class="food-icon" style="top:35%; right:6%;">🧃</span>
            <span class="food-icon" style="bottom:40%; left:15%;">🍱</span>
            <span class="food-icon" style="bottom:15%; right:18%;">🥘</span>

            <!-- Logo -->
            <div class="intro-logo-wrap">
                <div class="intro-logo">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
            </div>

            <!-- Title -->
            <div class="intro-title">
                <h1>E-Canteen</h1>
                <p>Smart Food Ordering</p>
            </div>

            <!-- Decorative line -->
            <div class="intro-line"></div>

            <!-- Tagline -->
            <div class="intro-tagline">
                <p>Pesan makanan kantin dengan mudah dan cepat. Tanpa antre, langsung siap!</p>
            </div>

            <!-- Progress bar -->
            <div class="intro-progress">
                <div class="intro-progress-bar"></div>
            </div>

            <!-- Counter -->
            <div class="intro-counter">00:00</div>

            <!-- Skip -->
            <button class="intro-skip" onclick="skipIntro()">Lewati ▸</button>
        </div>

        <!-- ===== MAIN CONTENT ===== -->
        <div class="main-content min-h-screen flex flex-col items-center justify-center px-6">
            <!-- Logo -->
            <div class="float-animation mb-8">
                <div class="w-20 h-20 gradient-primary rounded-2xl flex items-center justify-center shadow-2xl shadow-indigo-500/30">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
            </div>

            <!-- Title -->
            <h1 class="text-5xl font-extrabold text-white mb-3 text-center">E-Canteen</h1>
            <p class="text-lg text-slate-400 mb-10 text-center max-w-md">Pesan makanan kantin dengan mudah dan cepat. Tanpa antre, langsung siap!</p>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 gradient-primary text-white font-semibold rounded-xl shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 hover:-translate-y-0.5 transition-all text-base">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Masuk Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 gradient-primary text-white font-semibold rounded-xl shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 hover:-translate-y-0.5 transition-all text-base">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                        Masuk
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 text-white font-semibold rounded-xl hover:bg-white/5 transition-all text-base" style="border: 1px solid rgba(99,102,241,0.3);">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                            Daftar
                        </a>
                    @endif
                @endauth
            </div>

            <!-- Footer -->
            <p class="mt-16 text-sm text-slate-600">&copy; {{ date('Y') }} E-Canteen. All rights reserved.</p>
        </div>

        <!-- ===== INTRO SCRIPT ===== -->
        <script>
        (function() {
            const INTRO_DURATION = 20000;
            const overlay = document.getElementById('intro-overlay');
            const mainContent = document.querySelector('.main-content');
            let introEnded = false;
            let startTime = performance.now();
            let animFrame;

            // ── Particle System ──
            const canvas = document.getElementById('particle-canvas');
            const ctx = canvas.getContext('2d');
            let particles = [];

            function resizeCanvas() {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
            }
            resizeCanvas();
            window.addEventListener('resize', resizeCanvas);

            class Particle {
                constructor() { this.reset(); }
                reset() {
                    this.x = Math.random() * canvas.width;
                    this.y = Math.random() * canvas.height;
                    this.size = Math.random() * 2 + 0.5;
                    this.speedX = (Math.random() - 0.5) * 0.5;
                    this.speedY = (Math.random() - 0.5) * 0.5;
                    this.opacity = Math.random() * 0.5 + 0.1;
                    this.hue = 230 + Math.random() * 40;
                }
                update() {
                    this.x += this.speedX;
                    this.y += this.speedY;
                    if (this.x < 0 || this.x > canvas.width) this.speedX *= -1;
                    if (this.y < 0 || this.y > canvas.height) this.speedY *= -1;
                }
                draw() {
                    ctx.beginPath();
                    ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                    ctx.fillStyle = `hsla(${this.hue}, 70%, 70%, ${this.opacity})`;
                    ctx.fill();
                }
            }

            for (let i = 0; i < 80; i++) particles.push(new Particle());

            function drawLines() {
                for (let i = 0; i < particles.length; i++) {
                    for (let j = i + 1; j < particles.length; j++) {
                        const dx = particles[i].x - particles[j].x;
                        const dy = particles[i].y - particles[j].y;
                        const dist = Math.sqrt(dx * dx + dy * dy);
                        if (dist < 120) {
                            ctx.beginPath();
                            ctx.moveTo(particles[i].x, particles[i].y);
                            ctx.lineTo(particles[j].x, particles[j].y);
                            ctx.strokeStyle = `rgba(99,102,241,${0.06 * (1 - dist / 120)})`;
                            ctx.lineWidth = 0.5;
                            ctx.stroke();
                        }
                    }
                }
            }

            function animateParticles() {
                if (introEnded) return;
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                particles.forEach(p => { p.update(); p.draw(); });
                drawLines();
                animFrame = requestAnimationFrame(animateParticles);
            }
            animateParticles();

            // ── Easing ──
            function easeOutCubic(t) { return 1 - Math.pow(1 - t, 3); }
            function easeOutBack(t) { const c = 1.7; return 1 + (c + 1) * Math.pow(t - 1, 3) + c * Math.pow(t - 1, 2); }
            function easeInOutQuart(t) { return t < 0.5 ? 8*t*t*t*t : 1-Math.pow(-2*t+2,4)/2; }

            // ── Timeline (ms) ──
            const glow = document.querySelector('.intro-glow');
            const rings = document.querySelectorAll('.intro-ring');
            const logoWrap = document.querySelector('.intro-logo-wrap');
            const logo = document.querySelector('.intro-logo');
            const titleEl = document.querySelector('.intro-title');
            const titleH1 = document.querySelector('.intro-title h1');
            const lineEl = document.querySelector('.intro-line');
            const tagline = document.querySelector('.intro-tagline');
            const progressBar = document.querySelector('.intro-progress-bar');
            const counter = document.querySelector('.intro-counter');
            const foodIcons = document.querySelectorAll('.food-icon');

            function animate(timestamp) {
                if (introEnded) return;
                const elapsed = timestamp - startTime;
                const progress = Math.min(elapsed / INTRO_DURATION, 1);

                // Progress bar
                progressBar.style.width = (progress * 100) + '%';

                // Counter
                const secs = Math.min(elapsed / 1000, 20).toFixed(1);
                const pad = secs < 10 ? '0' + secs : secs;
                counter.textContent = '00:' + pad;

                // Phase 1 (0-3s): Glow expands + rings appear
                if (elapsed < 3000) {
                    const t = easeOutCubic(elapsed / 3000);
                    glow.style.transform = `translate(-50%, -50%) scale(${t})`;
                    glow.style.opacity = t * 0.8;
                    rings.forEach((r, i) => {
                        const delay = i * 400;
                        const rt = Math.max(0, Math.min(1, (elapsed - delay) / 2000));
                        const et = easeOutCubic(rt);
                        r.style.transform = `translate(-50%, -50%) scale(${et})`;
                        r.style.opacity = et * 0.4;
                    });
                }

                // Phase 2 (2-5s): Logo spins in
                if (elapsed >= 2000 && elapsed < 5000) {
                    const t = easeOutBack(Math.min(1, (elapsed - 2000) / 2000));
                    logoWrap.style.opacity = t;
                    logoWrap.style.transform = `scale(${0.3 + 0.7 * t}) rotate(${-180 + 180 * t}deg)`;
                }
                if (elapsed >= 5000) {
                    logoWrap.style.opacity = 1;
                    logoWrap.style.transform = `scale(1) rotate(0deg)`;
                }

                // Phase 2b (4s): Logo pulse glow
                if (elapsed >= 4000 && elapsed < 6000) {
                    const t = (elapsed - 4000) / 2000;
                    logo.style.boxShadow = `0 0 ${60 * t}px ${20 * t}px rgba(99,102,241,${0.4 * t}), 0 25px 80px rgba(99,102,241,0.3)`;
                    const afterEl = logo;
                    afterEl.querySelector('svg').style.filter = `drop-shadow(0 0 ${10*t}px rgba(255,255,255,${0.3*t}))`;
                }

                // Phase 2c (4.5s): Sheen sweep
                if (elapsed >= 4500 && elapsed < 5500) {
                    const t = (elapsed - 4500) / 1000;
                    logo.style.setProperty('--sheen', (t * 300 - 100) + '%');
                }

                // Phase 3 (5-8s): Title slides up + gradient animation
                if (elapsed >= 5000 && elapsed < 8000) {
                    const t = easeOutCubic(Math.min(1, (elapsed - 5000) / 1500));
                    titleEl.style.opacity = t;
                    titleEl.style.transform = `translateY(${30 * (1 - t)}px)`;
                }
                if (elapsed >= 5000) {
                    const gradientT = ((elapsed - 5000) % 6000) / 6000;
                    titleH1.style.backgroundPosition = `${gradientT * 300}% 50%`;
                }

                // Phase 4 (7-9s): Line expands
                if (elapsed >= 7000 && elapsed < 9000) {
                    const t = easeInOutQuart(Math.min(1, (elapsed - 7000) / 1500));
                    lineEl.style.width = (t * 300) + 'px';
                }

                // Phase 5 (8-10s): Tagline fades in
                if (elapsed >= 8000 && elapsed < 10000) {
                    const t = easeOutCubic(Math.min(1, (elapsed - 8000) / 1500));
                    tagline.style.opacity = t;
                    tagline.style.transform = `translateY(${20 * (1 - t)}px)`;
                }

                // Phase 6 (3-14s): Food icons float in one by one
                foodIcons.forEach((icon, i) => {
                    const iconStart = 3000 + i * 1200;
                    if (elapsed >= iconStart && elapsed < iconStart + 2000) {
                        const t = easeOutCubic((elapsed - iconStart) / 2000);
                        icon.style.opacity = t * 0.5;
                        icon.style.transform = `translateY(${-30 * t}px) scale(${0.5 + 0.5 * t})`;
                    }
                    // Gentle floating after appear
                    if (elapsed >= iconStart + 2000) {
                        const floatT = (elapsed - iconStart - 2000) / 3000;
                        const yOff = Math.sin(floatT * Math.PI * 2) * 10;
                        icon.style.opacity = 0.4;
                        icon.style.transform = `translateY(${-30 + yOff}px) scale(1)`;
                    }
                });

                // Phase 7 (12-16s): Rings rotate slowly
                if (elapsed >= 3000) {
                    rings.forEach((r, i) => {
                        const angle = ((elapsed - 3000) / (80 + i * 30)) % 360;
                        const dir = i % 2 === 0 ? 1 : -1;
                        r.style.transform = `translate(-50%, -50%) scale(1) rotate(${angle * dir}deg)`;
                        r.style.borderColor = `rgba(129,140,248,${0.08 + Math.sin(elapsed/2000 + i) * 0.04})`;
                    });
                }

                // Phase 8 (14-16s): Logo breathes
                if (elapsed >= 14000) {
                    const breathe = Math.sin((elapsed - 14000) / 800) * 0.05 + 1;
                    logoWrap.style.transform = `scale(${breathe}) rotate(0deg)`;
                }

                // Phase 9 (17-19s): Everything starts to lift and prepare transition
                if (elapsed >= 17000 && elapsed < 19000) {
                    const t = easeInOutQuart((elapsed - 17000) / 2000);
                    // Subtle zoom
                    const scaleAll = 1 + t * 0.08;
                    glow.style.transform = `translate(-50%, -50%) scale(${scaleAll})`;
                    glow.style.opacity = 0.8 + t * 0.4;
                    // Brighten particles
                    particles.forEach(p => { p.opacity = Math.min(0.8, p.opacity + 0.001); });
                }

                // Phase 10 (19-20s): Flash + Fade out
                if (elapsed >= 19000) {
                    const t = (elapsed - 19000) / 1000;
                    overlay.style.background = `rgba(10,14,26,${1 - t * 0.3})`;
                    // White flash at 19.2s
                    if (elapsed >= 19200 && elapsed < 19600) {
                        const ft = (elapsed - 19200) / 400;
                        glow.style.background = `radial-gradient(circle, rgba(255,255,255,${0.3 * (1 - ft)}) 0%, transparent 70%)`;
                    }
                }

                if (elapsed >= INTRO_DURATION) {
                    endIntro();
                    return;
                }

                requestAnimationFrame(animate);
            }

            requestAnimationFrame(animate);

            function endIntro() {
                if (introEnded) return;
                introEnded = true;
                cancelAnimationFrame(animFrame);
                overlay.classList.add('fade-out');
                setTimeout(() => {
                    overlay.style.display = 'none';
                    mainContent.classList.add('visible');
                }, 1200);
            }

            window.skipIntro = function() {
                endIntro();
            };
        })();
        </script>
    </body>
</html>

