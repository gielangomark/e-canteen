<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        {!! app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']) !!}

        <style>
            body { font-family: 'Inter', sans-serif; }
            .gradient-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
            .auth-input {
                background: rgba(255,255,255,0.06);
                border: 1px solid rgba(255,255,255,0.1);
                color: #e2e8f0;
                transition: all 0.3s;
            }
            .auth-input:hover {
                background: rgba(255,255,255,0.09);
                border-color: rgba(255,255,255,0.18);
            }
            .auth-input:focus {
                background: rgba(255,255,255,0.1);
                border-color: rgba(129,140,248,0.6);
                box-shadow: 0 0 0 3px rgba(129,140,248,0.15), 0 0 20px rgba(129,140,248,0.1);
                outline: none;
            }
            .auth-input::placeholder { color: rgba(148,163,184,0.4); }
            .glow-btn {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                box-shadow: 0 4px 25px rgba(99,102,241,0.35);
                transition: all 0.3s;
            }
            .glow-btn:hover {
                box-shadow: 0 6px 35px rgba(99,102,241,0.5);
                transform: translateY(-2px);
            }
            @keyframes float { 0%,100% { transform: translateY(0) rotate(0deg); } 50% { transform: translateY(-25px) rotate(5deg); } }
            @keyframes float-r { 0%,100% { transform: translateY(0) rotate(0deg); } 50% { transform: translateY(-18px) rotate(-4deg); } }
            @keyframes float-s { 0%,100% { transform: translateY(0) scale(1); } 50% { transform: translateY(-12px) scale(1.05); } }
            @keyframes orbit { 0% { transform: rotate(0deg) translateX(120px) rotate(0deg); } 100% { transform: rotate(360deg) translateX(120px) rotate(-360deg); } }
            @keyframes orbit-2 { 0% { transform: rotate(0deg) translateX(200px) rotate(0deg); } 100% { transform: rotate(-360deg) translateX(200px) rotate(360deg); } }
            @keyframes drift-x { 0%,100% { transform: translateX(0) translateY(0); } 25% { transform: translateX(60px) translateY(-30px); } 50% { transform: translateX(10px) translateY(-60px); } 75% { transform: translateX(-50px) translateY(-20px); } }
            @keyframes drift-diag { 0%,100% { transform: translate(0,0) rotate(0deg); } 33% { transform: translate(40px,-50px) rotate(120deg); } 66% { transform: translate(-30px,-20px) rotate(240deg); } }
            @keyframes morph { 0%,100% { border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; } 25% { border-radius: 58% 42% 35% 65% / 62% 48% 52% 38%; } 50% { border-radius: 40% 60% 55% 45% / 55% 35% 65% 45%; } 75% { border-radius: 65% 35% 50% 50% / 40% 60% 40% 60%; } }
            @keyframes pulse-glow { 0%,100% { opacity: 0.3; transform: scale(1); } 50% { opacity: 0.7; transform: scale(1.3); } }
            @keyframes rise { 0% { transform: translateY(100vh) scale(0); opacity:0; } 10% { opacity:1; } 90% { opacity:1; } 100% { transform: translateY(-20vh) scale(1); opacity:0; } }
            @keyframes slide-up { from { opacity:0; transform:translateY(40px); } to { opacity:1; transform:translateY(0); } }
            .float-1 { animation: float 7s ease-in-out infinite; }
            .float-2 { animation: float-r 9s ease-in-out infinite; }
            .float-3 { animation: float-s 6s ease-in-out infinite; }
            .orbit { animation: orbit 25s linear infinite; }
            .orbit-2 { animation: orbit-2 35s linear infinite; }
            .drift-1 { animation: drift-x 20s ease-in-out infinite; }
            .drift-2 { animation: drift-diag 25s ease-in-out infinite; }
            .morph { animation: morph 12s ease-in-out infinite; }
            .pulse-glow { animation: pulse-glow 4s ease-in-out infinite; }
            .rise-1 { animation: rise 15s linear infinite; }
            .rise-2 { animation: rise 20s linear infinite 5s; }
            .rise-3 { animation: rise 18s linear infinite 10s; }
            .slide-up { animation: slide-up 0.7s ease-out forwards; }
            .slide-up-2 { animation: slide-up 0.7s ease-out 0.15s forwards; opacity: 0; }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex items-center justify-center p-4 relative overflow-hidden" style="background: linear-gradient(140deg, #0f172a 0%, #1e1b4b 40%, #312e81 70%, #1e1b4b 100%);">

            <!-- Large gradient orbs -->
            <div class="absolute top-[-200px] left-[-100px] w-[500px] h-[500px] rounded-full float-1" style="background: radial-gradient(circle, rgba(99,102,241,0.2) 0%, transparent 70%);"></div>
            <div class="absolute bottom-[-150px] right-[-100px] w-[600px] h-[600px] rounded-full float-2" style="background: radial-gradient(circle, rgba(139,92,246,0.15) 0%, transparent 70%);"></div>
            <div class="absolute top-[40%] left-[60%] w-[300px] h-[300px] rounded-full float-3" style="background: radial-gradient(circle, rgba(79,70,229,0.12) 0%, transparent 70%);"></div>

            <!-- Morphing blobs -->
            <div class="absolute top-[10%] right-[15%] w-[250px] h-[250px] morph drift-1" style="background: linear-gradient(135deg, rgba(99,102,241,0.08), rgba(139,92,246,0.06)); filter: blur(1px);"></div>
            <div class="absolute bottom-[10%] left-[10%] w-[200px] h-[200px] morph drift-2" style="background: linear-gradient(225deg, rgba(79,70,229,0.06), rgba(168,85,247,0.05)); filter: blur(1px); animation-delay: -5s;"></div>

            <!-- Decorative floating elements -->
            <div class="absolute top-16 left-[12%] w-20 h-20 rounded-2xl rotate-12 float-1 border border-indigo-400/20 bg-indigo-500/5 backdrop-blur-sm"></div>
            <div class="absolute top-[25%] right-[8%] w-14 h-14 rounded-full float-2 border border-purple-400/20 bg-purple-500/5 backdrop-blur-sm"></div>
            <div class="absolute bottom-[15%] left-[8%] w-16 h-16 rounded-xl -rotate-12 float-3 border border-blue-400/15 bg-blue-500/5 backdrop-blur-sm"></div>
            <div class="absolute bottom-[30%] right-[12%] w-10 h-10 rounded-lg rotate-45 float-1 bg-gradient-to-br from-indigo-500/15 to-purple-500/15 border border-indigo-400/10"></div>

            <!-- Drifting glass panels -->
            <div class="absolute top-[60%] left-[5%] w-24 h-24 rounded-2xl drift-1 border border-indigo-300/10 bg-white/[0.02] backdrop-blur-sm" style="transform-origin: center;"></div>
            <div class="absolute top-[8%] right-[5%] w-16 h-16 rounded-xl drift-2 border border-purple-300/10 bg-white/[0.02] backdrop-blur-sm" style="animation-delay: -8s;"></div>

            <!-- Orbiting dots -->
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-0 h-0">
                <div class="orbit">
                    <div class="w-2 h-2 bg-indigo-400/40 rounded-full shadow-lg shadow-indigo-400/20"></div>
                </div>
            </div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-0 h-0">
                <div class="orbit-2">
                    <div class="w-1.5 h-1.5 bg-purple-400/30 rounded-full shadow-lg shadow-purple-400/15"></div>
                </div>
            </div>

            <!-- Rising particles -->
            <div class="absolute left-[20%] w-1 h-1 bg-indigo-400/40 rounded-full rise-1"></div>
            <div class="absolute left-[50%] w-1.5 h-1.5 bg-purple-400/30 rounded-full rise-2"></div>
            <div class="absolute left-[75%] w-1 h-1 bg-blue-400/35 rounded-full rise-3"></div>
            <div class="absolute left-[35%] w-0.5 h-0.5 bg-violet-400/40 rounded-full rise-2" style="animation-delay: 3s;"></div>
            <div class="absolute left-[85%] w-1 h-1 bg-indigo-300/25 rounded-full rise-1" style="animation-delay: 7s;"></div>
            <div class="absolute left-[10%] w-0.5 h-0.5 bg-purple-300/30 rounded-full rise-3" style="animation-delay: 2s;"></div>

            <!-- Pulsing glow spots -->
            <div class="absolute top-[30%] left-[25%] w-3 h-3 bg-indigo-500/30 rounded-full pulse-glow" style="filter: blur(4px);"></div>
            <div class="absolute bottom-[20%] right-[22%] w-4 h-4 bg-purple-500/20 rounded-full pulse-glow" style="filter: blur(5px); animation-delay: -2s;"></div>
            <div class="absolute top-[70%] right-[35%] w-2.5 h-2.5 bg-violet-500/25 rounded-full pulse-glow" style="filter: blur(3px); animation-delay: -3.5s;"></div>

            <!-- Glowing accent dots -->
            <div class="absolute top-[18%] right-[25%] w-2 h-2 bg-indigo-400/50 rounded-full shadow-lg shadow-indigo-500/30"></div>
            <div class="absolute bottom-[25%] left-[20%] w-1.5 h-1.5 bg-purple-400/50 rounded-full shadow-lg shadow-purple-500/30"></div>
            <div class="absolute top-[55%] left-[15%] w-1.5 h-1.5 bg-blue-400/40 rounded-full shadow-lg shadow-blue-500/20"></div>
            <div class="absolute bottom-[45%] right-[18%] w-2 h-2 bg-violet-400/40 rounded-full shadow-lg shadow-violet-500/20"></div>

            <!-- Subtle star sparkles -->
            <svg class="absolute top-[12%] left-[35%] w-5 h-5 text-indigo-300/30 float-3" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L13.09 8.26L18 6L14.74 10.91L21 12L14.74 13.09L18 18L13.09 15.74L12 22L10.91 15.74L6 18L9.26 13.09L3 12L9.26 10.91L6 6L10.91 8.26L12 2Z"/></svg>
            <svg class="absolute bottom-[18%] right-[30%] w-4 h-4 text-purple-300/25 float-1" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L13.09 8.26L18 6L14.74 10.91L21 12L14.74 13.09L18 18L13.09 15.74L12 22L10.91 15.74L6 18L9.26 13.09L3 12L9.26 10.91L6 6L10.91 8.26L12 2Z"/></svg>
            <svg class="absolute top-[65%] right-[40%] w-3 h-3 text-blue-300/20 float-2" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L13.09 8.26L18 6L14.74 10.91L21 12L14.74 13.09L18 18L13.09 15.74L12 22L10.91 15.74L6 18L9.26 13.09L3 12L9.26 10.91L6 6L10.91 8.26L12 2Z"/></svg>
            <!-- Moving line traces -->
            <svg class="absolute top-0 left-0 w-full h-full pointer-events-none" style="opacity: 0.04;">
                <line x1="10%" y1="0" x2="30%" y2="100%" stroke="url(#line-grad)" stroke-width="1">
                    <animate attributeName="x1" values="10%;25%;10%" dur="20s" repeatCount="indefinite"/>
                    <animate attributeName="x2" values="30%;15%;30%" dur="20s" repeatCount="indefinite"/>
                </line>
                <line x1="70%" y1="0" x2="90%" y2="100%" stroke="url(#line-grad)" stroke-width="1">
                    <animate attributeName="x1" values="70%;85%;70%" dur="25s" repeatCount="indefinite"/>
                    <animate attributeName="x2" values="90%;75%;90%" dur="25s" repeatCount="indefinite"/>
                </line>
                <line x1="45%" y1="0" x2="55%" y2="100%" stroke="url(#line-grad2)" stroke-width="0.5">
                    <animate attributeName="x1" values="45%;55%;45%" dur="18s" repeatCount="indefinite"/>
                    <animate attributeName="x2" values="55%;40%;55%" dur="18s" repeatCount="indefinite"/>
                </line>
                <defs>
                    <linearGradient id="line-grad" x1="0" y1="0" x2="0" y2="1">
                        <stop offset="0%" stop-color="transparent"/>
                        <stop offset="50%" stop-color="#818cf8"/>
                        <stop offset="100%" stop-color="transparent"/>
                    </linearGradient>
                    <linearGradient id="line-grad2" x1="0" y1="0" x2="0" y2="1">
                        <stop offset="0%" stop-color="transparent"/>
                        <stop offset="50%" stop-color="#a78bfa"/>
                        <stop offset="100%" stop-color="transparent"/>
                    </linearGradient>
                </defs>
            </svg>

            <div class="w-full max-w-md relative z-10">
                <!-- Logo -->
                <div class="text-center mb-8 slide-up">
                    <a href="/" class="inline-flex items-center gap-3 group">
                        <div class="w-12 h-12 gradient-primary rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-500/30 group-hover:shadow-indigo-500/50 group-hover:scale-105 transition-all">
                            <span class="text-xl">🍽️</span>
                        </div>
                        <span class="text-2xl font-extrabold text-white">E-Canteen</span>
                    </a>
                </div>

                <!-- Card -->
                <div class="rounded-3xl p-8 slide-up-2" style="background: rgba(15,23,42,0.6); border: 1px solid rgba(99,102,241,0.15); backdrop-filter: blur(40px); -webkit-backdrop-filter: blur(40px); box-shadow: 0 25px 60px rgba(0,0,0,0.3), inset 0 1px 0 rgba(255,255,255,0.05);">
                    {{ $slot }}

                </div>

                <p class="text-center text-xs text-indigo-300/30 mt-8">&copy; {{ date('Y') }} E-Canteen &middot; Kantin Digital Sekolah</p>
            </div>
        </div>
    </body>
</html>
