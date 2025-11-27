<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>User Register – {{ config('app.name', 'UNA Navigator') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Tailwind from CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        unaPrimary: '#379eb0',
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
    <div class="relative min-h-screen overflow-hidden flex items-center justify-center px-4 sm:px-8">
        <!-- Gradient background / blobs -->
        <div class="pointer-events-none absolute inset-0">
            <div class="absolute -top-40 -left-32 h-80 w-80 rounded-full bg-unaPrimary/40 blur-3xl"></div>
            <div class="absolute -bottom-32 -right-32 h-72 w-72 rounded-full bg-cyan-400/30 blur-3xl"></div>
        </div>

        <div class="relative z-10 w-full max-w-5xl grid grid-cols-1 md:grid-cols-2 gap-8">

            <!-- Left "info / brand" panel -->
            <div class="hidden md:flex flex-col bg-white/5 border border-white/10 backdrop-blur-lg rounded-2xl p-7 shadow-xl">
                <div class="flex items-center gap-3 mb-4">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-unaPrimary text-white shadow">
                        <span class="text-xl">🧭</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-sm font-semibold tracking-wide text-slate-50">
                            UNA Navigator
                        </span>
                        <span class="text-[11px] text-slate-300">
                            Universities Navigation Application
                        </span>
                    </div>
                </div>

                <p class="text-sm text-slate-200 leading-relaxed mb-4">
                    Your UNA Navigator account lets you save favorites, quickly jump between rooms
                    and keep accessibility preferences synced across devices.
                </p>

                <ul class="mt-1 space-y-2 text-[13px] text-slate-200/90">
                    <li class="flex items-center gap-2">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                        Mark rooms as favorites
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="h-1.5 w-1.5 rounded-full bg-cyan-300"></span>
                        Keep recent searches handy
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="h-1.5 w-1.5 rounded-full bg-amber-300"></span>
                        Store accessibility settings
                    </li>
                </ul>

                <div class="mt-auto pt-4 text-[11px] text-slate-400">
                    You can adjust your preferences from the main page after signing in.
                </div>
            </div>

            <!-- Right: User registration form -->
            <div class="bg-white/5 border border-white/10 backdrop-blur-lg rounded-2xl p-7 sm:p-8 shadow-xl">
                <header class="mb-6">
                    <h1 class="text-xl font-semibold text-slate-50">Create Account</h1>
                    <p class="text-xs text-slate-300 mt-1">
                        Use your university email and set a secure password.
                        </p>
                </header>

                <!-- Message area -->
                <div id="message" style="display:none;" class="mb-4 rounded-md px-3 py-2 text-xs"></div>

                <!-- Step 1: base registration -->
                <div id="registerForm">
                    <form id="registerFormElement" class="space-y-4">
                        @csrf
                        <div class="space-y-1.5">
                            <label for="reg_email" class="text-xs font-medium text-slate-200">
                                University email
                            </label>
                            <input
                                id="reg_email"
                                name="email"
                                type="email"
                                placeholder="user@email.com"
                                required
                                class="block w-full rounded-lg border border-white/20 bg-white/5 px-3 py-2 text-sm text-slate-100 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-unaPrimary focus:border-transparent"
                            >
                        </div>

                        <div class="space-y-1.5">
                            <label for="reg_password" class="text-xs font-medium text-slate-200">
                                Password
                            </label>
                            <input
                                id="reg_password"
                                name="password"
                                type="password"
                                placeholder="Create a strong password"
                                required
                                class="block w-full rounded-lg border border-white/20 bg-white/5 px-3 py-2 text-sm text-slate-100 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-unaPrimary focus:border-transparent"
                            >
                            <p class="text-[11px] text-slate-400">
                                Use at least 8 characters, with a mix of letters and numbers.
                            </p>
                        </div>

                        <button
                            type="submit"
                            class="inline-flex w-full items-center justify-center rounded-lg bg-unaPrimary px-4 py-2.5 text-sm font-medium text-white shadow hover:bg-unaPrimaryDark focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-1 focus-visible:ring-unaPrimary"
                        >
                            Continue
                        </button>
                    </form>

                    <p class="mt-5 text-[11px] text-center text-slate-300">
                        Already have an account?
                        <a href="{{ url('/login') }}" class="font-medium text-unaPrimary hover:text-cyan-300">
                            Sign in
                        </a>
                    </p>
                </div>

                <!-- Step 2: GA verification -->
                <div id="gaVerifyForm" style="display:none;">
                    <h2 class="text-sm font-semibold mb-2 text-slate-50">Google Authenticator verification</h2>
                    <p class="text-xs text-slate-300 mb-3">
                        Scan the QR code below with your Google Authenticator app, or manually enter the secret key.
                    </p>

                    <!-- QR Code -->
                    <div class="mb-4 flex justify-center">
                        <div class="bg-white p-3 rounded-lg border border-white/20">
                            <img id="gaQRCode" src="" alt="QR Code" class="w-48 h-48">
                        </div>
                    </div>

                    <p class="mb-3 text-xs text-center text-slate-200">
                        <span class="font-semibold">Or enter manually:</span><br>
                        <span id="gaSecret" class="font-mono text-[11px] bg-white/10 px-2 py-1 rounded-md break-all text-slate-100 mt-1 inline-block"></span>
                    </p>

                    <form id="gaVerifyFormElement" class="space-y-4">
                        <input type="hidden" name="email" id="gaEmail">

                        <div class="space-y-1.5">
                            <label for="ga_code_verify" class="text-xs font-medium text-slate-200">
                                6-digit code
                            </label>
                            <input
                                id="ga_code_verify"
                                name="code"
                                type="text"
                                maxlength="6"
                                placeholder="Enter the code from your app"
                                required
                                class="block w-full rounded-lg border border-white/20 bg-white/5 px-3 py-2 text-sm text-slate-100 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-unaPrimary focus:border-transparent"
                            >
                        </div>

                        <button
                            type="submit"
                            class="inline-flex w-full items-center justify-center rounded-lg bg-unaPrimary px-4 py-2.5 text-sm font-medium text-white shadow hover:bg-unaPrimaryDark focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-1 focus-visible:ring-unaPrimary"
                        >
                            Verify & finish
                        </button>
                    </form>

                    <p class="mt-4 text-[11px] text-slate-400">
                        Make sure your phone's time is set automatically for Authenticator codes to work correctly.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Step 1: base registration
        document.getElementById('registerFormElement').addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const data = Object.fromEntries(formData);

            try {
                const response = await fetch('/api/register', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (result.status === 'need_ga_verify') {
                    document.getElementById('registerForm').style.display = 'none';
                    document.getElementById('gaVerifyForm').style.display = 'block';
                    document.getElementById('gaSecret').textContent = result.secret;
                    document.getElementById('gaEmail').value = data.email;
                    
                    // Generate QR code URL
                    const issuer = encodeURIComponent('UNA Navigator');
                    const account = encodeURIComponent(data.email);
                    const secret = result.secret;
                    const otpauthUrl = `otpauth://totp/${issuer}:${account}?secret=${secret}&issuer=${issuer}`;
                    const qrCodeUrl = `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${encodeURIComponent(otpauthUrl)}`;
                    document.getElementById('gaQRCode').src = qrCodeUrl;
                    
                    showMessage('Registration successful! Now verify with Google Authenticator.', 'success');
                } else {
                    showMessage('Registration failed: ' + (result.message || 'Unknown error'), 'error');
                }
            } catch (error) {
                showMessage('Registration failed: ' + error.message, 'error');
            }
        });

        // Step 2: GA verification
        document.getElementById('gaVerifyFormElement').addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const data = Object.fromEntries(formData);

            try {
                const response = await fetch('/api/ga/verify', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (result.status === 'ga_ok') {
                    showMessage('Verification successful! Redirecting to login page…', 'success');
                    setTimeout(() => {
                        window.location.href = '/login';
                    }, 1200);
                } else {
                    showMessage('Verification failed: Incorrect code.', 'error');
                }
            } catch (error) {
                showMessage('Verification failed: ' + error.message, 'error');
            }
        });

        function showMessage(msg, type) {
            const msgDiv = document.getElementById('message');
            msgDiv.textContent = msg;
            msgDiv.style.display = 'block';
            msgDiv.className =
                'mb-4 rounded-md px-3 py-2 text-xs ' +
                (type === 'success'
                    ? 'bg-emerald-50 text-emerald-700 border border-emerald-200'
                    : 'bg-rose-50 text-rose-700 border border-rose-200');
        }
    </script>
</body>
</html>
