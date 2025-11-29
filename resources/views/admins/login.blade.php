<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin Login – {{ config('app.name', 'UNA Navigator') }}</title>

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

            <!-- Left “info / brand” panel -->
            <div class="hidden md:flex flex-col bg-white/5 border border-white/10 backdrop-blur-lg rounded-2xl p-7 shadow-xl">
                <div class="flex items-center gap-3 mb-4">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-unaPrimary text-white shadow">
                        <span class="text-xl">🛡️</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-sm font-semibold tracking-wide text-slate-50">
                            UNA Navigator
                        </span>
                        <span class="text-[11px] text-slate-300">
                            Admin Control Panel
                        </span>
                    </div>
                </div>

                <p class="text-sm text-slate-200 leading-relaxed mb-4">
                    This area is restricted to system administrators. Use your assigned admin credentials
                    to review and maintain buildings, rooms, and accessibility data across campus.
                </p>

                <ul class="mt-1 space-y-2 text-[13px] text-slate-200/90">
                    <li class="flex items-center gap-2">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                        Manage building & floor configurations.
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="h-1.5 w-1.5 rounded-full bg-cyan-300"></span>
                        Update room types, availability, and metadata.
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="h-1.5 w-1.5 rounded-full bg-amber-300"></span>
                        Maintain accessibility information and amenities.
                    </li>
                </ul>

                <div class="mt-auto pt-4 text-[11px] text-slate-400">
                    If you are not an administrator, please use the standard user login instead.
                </div>
            </div>

            <!-- Right: Admin login form -->
            <div class="bg-white/5 border border-white/10 backdrop-blur-lg rounded-2xl p-7 sm:p-8 shadow-xl">
                <header class="mb-6">
                    <h1 class="text-xl font-semibold text-slate-50">Admin Login</h1>
                    <p class="text-xs text-slate-300 mt-1">
                        Sign in with your administrator credentials to continue.
                    </p>
                </header>

                <!-- Message area -->
                <div id="message" style="display:none;" class="mb-4 rounded-md px-3 py-2 text-xs"></div>

                <form id="loginFormElement" class="space-y-4">
                    @csrf
                    <div class="space-y-1.5">
                        <label for="email" class="text-xs font-medium text-slate-200">
                            Admin email
                        </label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            placeholder="admin@university.edu"
                            required
                            class="block w-full rounded-lg border border-white/20 bg-white/5 px-3 py-2 text-sm text-slate-100 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-unaPrimary focus:border-transparent"
                        >
                    </div>

                    <div class="space-y-1.5">
                        <label for="password" class="text-xs font-medium text-slate-200">
                            Password
                        </label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            placeholder="Enter your password"
                            required
                            class="block w-full rounded-lg border border-white/20 bg-white/5 px-3 py-2 text-sm text-slate-100 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-unaPrimary focus:border-transparent"
                        >
                    </div>

                    <!-- Google Authenticator code (hidden by default) -->
                    <div id="gaCodeDiv" style="display:none;" class="space-y-1.5">
                        <label for="ga_code" class="text-xs font-medium text-slate-200">
                            Google Authenticator code
                        </label>
                        <input
                            id="ga_code"
                            name="ga_code"
                            type="text"
                            maxlength="6"
                            placeholder="6-digit code"
                            class="block w-full rounded-lg border border-white/20 bg-white/5 px-3 py-2 text-sm text-slate-100 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-unaPrimary focus:border-transparent"
                        >
                        <p class="text-[11px] text-slate-400">
                            Open your Authenticator app and enter the current code for this admin account.
                        </p>
                    </div>

                    <button
                        type="submit"
                        class="inline-flex w-full items-center justify-center rounded-lg bg-unaPrimary px-4 py-2.5 text-sm font-medium text-white shadow hover:bg-unaPrimaryDark focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-1 focus-visible:ring-unaPrimary"
                    >
                        Sign in as Admin
                    </button>
                </form>

            </div>
        </div>
    </div>

    <script>
        document.getElementById('loginFormElement').addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const data = Object.fromEntries(formData);

            if (!data.ga_code || data.ga_code.trim() === '') {
                delete data.ga_code;
            }

            try {
                const response = await fetch('/api/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (result.status === 'login_ok') {
                    // 管理员登录成功,跳转到管理员主页
                    let target = '/admins/home';
                    
                    if (result.role === 'admin') {
                        target = '/admins/home';
                    } else {
                        showMessage('You are not an admin. Please use user login.', 'error');
                        return;
                    }

                    showMessage('Login successful! Redirecting...', 'success');
                    setTimeout(() => {
                        window.location.href = target;
                    }, 800);
                } else if (result.status === 'ga_required') {
                    document.getElementById('gaCodeDiv').style.display = 'block';
                    showMessage('Please enter your Google Authenticator code.', 'info');
                } else if (result.status === 'no_user') {
                    showMessage('User does not exist.', 'error');
                } else if (result.status === 'pass_fail') {
                    showMessage('Incorrect password.', 'error');
                } else {
                    showMessage('Login failed: ' + (result.message || 'Unknown error'), 'error');
                }
            } catch (error) {
                showMessage('Login failed: ' + error.message, 'error');
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
                    : type === 'info'
                    ? 'bg-sky-50 text-sky-700 border border-sky-200'
                    : 'bg-rose-50 text-rose-700 border border-rose-200');
        }
    </script>
</body>
</html>
