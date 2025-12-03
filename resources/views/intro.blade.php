<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>UNA Navigator – Welcome</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Tailwind from CDN (no Vite needed here) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        unaPrimary: '#379eb0',         // your unique color
                        unaPrimaryDark: '#2b7f8d',
                        unaBgDark: '#050b10'
                    },
                    fontFamily: {
                        sans: ['Instrument Sans', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: "Instrument Sans", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI",
                sans-serif;
        }
    </style>
</head>
<body class="min-h-screen bg-unaBgDark text-slate-50 antialiased">
    <div class="relative min-h-screen overflow-hidden">
        <!-- Gradient background / blobs -->
        <div class="pointer-events-none absolute inset-0">
            <div class="absolute -top-40 -left-32 h-80 w-80 rounded-full bg-unaPrimary/40 blur-3xl"></div>
            <div class="absolute -bottom-32 -right-32 h-72 w-72 rounded-full bg-cyan-400/30 blur-3xl"></div>
        </div>

        <div class="relative z-10 flex min-h-screen flex-col">
            <!-- Top nav -->
            <header class="flex items-center justify-between px-6 sm:px-10 py-4">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-unaPrimary text-white shadow">
                        <span class="text-xl">🧭</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-sm font-semibold tracking-wide">
                            UNA Navigator
                        </span>
                        <span class="text-[11px] text-slate-300">
                            Universities Navigation Application
                        </span>
                    </div>
                </div>

                <nav class="hidden sm:flex items-center gap-4 text-xs text-slate-300">
                    <span class="opacity-80">Campus maps</span>
                    <span class="opacity-80">Rooms</span>
                    <span class="opacity-80">Accessibility</span>
                </nav>

                <div class="flex items-center gap-2 text-xs">
                    <a href="{{ url('/users/login') }}"
                       class="rounded-lg border border-white/20 bg-white/5 px-3 py-1.5 text-xs font-medium text-slate-50 hover:bg-white/10">
                        User Login
                    </a>
                    <a href="{{ url('/admins/login') }}"
                       class="hidden sm:inline-flex rounded-lg bg-unaPrimary px-3.5 py-1.5 text-xs font-medium text-white shadow hover:bg-unaPrimaryDark">
                        Admin Login
                    </a>
                </div>
            </header>

            <!-- Main hero content -->
            <main class="flex flex-1 items-center justify-center px-6 sm:px-10 py-10">
                <div class="grid w-full max-w-5xl grid-cols-1 md:grid-cols-2 gap-10 items-center">
                    <!-- Left: text -->
                    <div class="space-y-6">
                        <p class="inline-flex items-center gap-2 rounded-full bg-white/5 px-3 py-1 text-[11px] text-slate-200 border border-white/10">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                            Smart navigation for your university campus
                        </p>

                        <div class="space-y-3">
                            <h1 class="text-3xl sm:text-4xl font-semibold leading-tight">
                                Find your way around campus
                                <span class="text-unaPrimary">faster.</span>
                            </h1>
                            <p class="text-sm text-slate-300 leading-relaxed">
                                UNA Navigator helps you search buildings, rooms and services, check accessibility
                                and move between floors with an interactive campus map.
                            </p>
                        </div>

                        <div class="flex flex-wrap gap-3 items-center">
                                <a href="{{ url('/users/login') }}"
                                class="inline-flex items-center justify-center rounded-lg bg-unaPrimary px-4 py-2 text-sm font-medium text-white shadow hover:bg-unaPrimaryDark">
                                Enter app
                            </a>
                        </div>

                        <div class="flex flex-wrap gap-4 text-[11px] text-slate-300/90">
                            <div class="flex items-center gap-2">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                                Live room availability
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="h-1.5 w-1.5 rounded-full bg-cyan-300"></span>
                                Building & floor switching
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="h-1.5 w-1.5 rounded-full bg-amber-300"></span>
                                Accessibility information
                            </div>
                        </div>
                    </div>

                    <!-- Right: “illustration” style mockup -->
                    <div class="relative">
                        <div class="rounded-2xl border border-white/15 bg-white/5 backdrop-blur-md p-4 shadow-xl">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-unaPrimary/20 text-xl">🗺️</span>
                                    <div class="flex flex-col">
                                        <span class="text-xs font-medium text-slate-50">Campus map</span>
                                        <span class="text-[11px] text-slate-300">Building & floor overview</span>
                                    </div>
                                </div>
                                <span class="text-[11px] text-slate-300">LIVE</span>
                            </div>

                            <div class="h-40 rounded-xl bg-slate-900/60 border border-white/10 flex items-center justify-center text-slate-400 text-xs">
                                Interactive map preview
                            </div>

                            <div class="mt-4 grid grid-cols-2 gap-3 text-[11px]">
                                <div class="rounded-xl bg-slate-900/60 border border-white/10 p-3 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <span class="text-slate-100">Rooms</span>
                                        <span class="text-slate-400 text-[10px]">B1 · Floor 2</span>
                                    </div>
                                    <ul class="space-y-1 text-slate-300">
                                        <li>📚 Lecture Hall 201</li>
                                        <li>🧪 Lab 2.04</li>
                                        <li>💻 Computer Room 2.07</li>
                                    </ul>
                                </div>
                                <div class="rounded-xl bg-slate-900/60 border border-white/10 p-3 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <span class="text-slate-100">Accessibility</span>
                                        <span class="text-emerald-300 text-[10px]">Accessible</span>
                                    </div>
                                    <ul class="space-y-1 text-slate-300">
                                        <li>♿ Elevator access</li>
                                        <li>🚻 Accessible restrooms</li>
                                        <li>🪑 Quiet study zones</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- glow decoration -->
                        <div class="pointer-events-none absolute -bottom-8 -right-8 h-24 w-24 rounded-full bg-unaPrimary/40 blur-2xl"></div>
                    </div>
                </div>
            </main>

            <footer class="px-6 sm:px-10 pb-4 text-[11px] text-slate-500 flex justify-between items-center">
                <span>© {{ date('Y') }} UNA Navigator</span>
                <span class="hidden sm:inline">Built for your university campus navigation</span>
            </footer>
        </div>
    </div>
</body>
</html>
