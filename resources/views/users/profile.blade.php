<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - UNA</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    
    <!-- Tailwind -->
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
            font-family: "Instrument Sans", system-ui, sans-serif;
        }

        /* ===================== */
        /* LIGHT MODE VISIBILITY */
        /* ===================== */

        body.light-mode {
            background-color: #f3f4f6;   /* light grey background */
            color: #0f172a;              /* dark text */
        }

        body.light-mode .text-slate-300 {
            color: #4b5563 !important;
        }

        body.light-mode .text-slate-400 {
            color: #6b7280 !important;
        }

        /* Inputs / textareas: make text dark in light mode */
        body.light-mode input,
        body.light-mode textarea {
            color: #0f172a !important;
        }

        /* Cards that use translucent white in dark mode -> solid in light mode */
        body.light-mode .bg-white\/5 {
            background-color: rgba(255,255,255,0.96) !important;
        }

        body.light-mode .border-white\/10 {
            border-color: rgba(148,163,184,0.6) !important; /* slate-400-ish */
        }

        /* Back to Home button visibility in light mode */
        body.light-mode a[href*="users/home"] {
            color: #0f172a !important;
            background-color: #e5e7eb !important; /* slate-200 */
            border-color: #94a3b8 !important;     /* slate-400 */
        }

        /* Danger Zone visibility in light mode */
        body.light-mode .bg-red-900\/20 {
            background-color: #fee2e2 !important; /* red-100 */
            border-color: #ef4444 !important;     /* red-500 */
        }

        body.light-mode .text-red-400 {
            color: #dc2626 !important;            /* red-600 */
        }

        body.light-mode .text-red-300 {
            color: #b91c1c !important;            /* red-700 */
        }

        body.light-mode .bg-red-600\/20 {
            background-color: #fecaca !important; /* red-200 */
        }

        body.light-mode .border-red-600\/50 {
            border-color: #dc2626 !important;     /* red-600 */
        }
    </style>
</head>

<body class="bg-unaBgDark text-slate-50 min-h-screen">

    <!-- BACKGROUND GLOW -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute -top-40 -left-32 h-80 w-80 rounded-full bg-unaPrimary/40 blur-3xl"></div>
        <div class="absolute -bottom-32 -right-32 h-72 w-72 rounded-full bg-cyan-400/30 blur-3xl"></div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="relative z-10 min-h-screen p-6">
        <div class="max-w-4xl mx-auto">
            
            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold">User Profile</h1>
                    <p class="text-sm text-slate-400 mt-1">Manage your account information and settings</p>
                </div>
                <a href="{{ url('/users/home') }}" class="flex items-center gap-2 rounded-lg bg-white/10 px-4 py-2 text-sm text-white hover:bg-white/20 border border-white/10">
                    <i class="fa-solid fa-arrow-left"></i>
                    Back to Home
                </a>
            </div>

            <!-- Profile Information Card -->
            <div class="bg-white/5 backdrop-blur-md rounded-xl border border-white/10 p-6 mb-6">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-20 h-20 rounded-full bg-unaPrimary flex items-center justify-center text-2xl font-bold">
                        {{ strtoupper(substr($user->username_una ?? 'U', 0, 1)) }}
                    </div>
                    <div>
                        <h2 class="text-xl font-bold">{{ $user->username_una ?? 'User Account' }}</h2>
                        <p class="text-sm text-slate-400">{{ $user->role->role_name_una ?? 'Standard User' }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-xs font-medium text-slate-400 mb-2 block">Username</label>
                        <div class="flex items-center gap-2">
                            <input 
                                type="text" 
                                id="displayUsername" 
                                value="{{ $user->username_una ?? '' }}" 
                                readonly
                                class="flex-1 px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none"
                            >
                            <i class="fa-solid fa-user text-unaPrimary"></i>
                        </div>
                    </div>

                    <div>
                        <label class="text-xs font-medium text-slate-400 mb-2 block">Email Address</label>
                        <div class="flex items-center gap-2">
                            <input 
                                type="email" 
                                id="displayEmail" 
                                value="{{ $user->email_una ?? '' }}" 
                                readonly
                                class="flex-1 px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none"
                            >
                            <i class="fa-solid fa-envelope text-unaPrimary"></i>
                        </div>
                    </div>

                    <div>
                        <label class="text-xs font-medium text-slate-400 mb-2 block">Password</label>
                        <div class="flex items-center gap-2">
                            <input 
                                type="password" 
                                id="displayPassword" 
                                value="••••••••" 
                                readonly
                                class="flex-1 px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none"
                            >
                            <i class="fa-solid fa-lock text-unaPrimary"></i>
                        </div>
                    </div>

                    <div>
                        <label class="text-xs font-medium text-slate-400 mb-2 block">Role</label>
                        <div class="px-4 py-2 bg-white/5 border border-white/10 rounded-lg">
                            <span class="text-cyan-400 font-semibold">{{ $user->role->role_name_una ?? 'User' }}</span>
                        </div>
                    </div>

                    <div>
                        <label class="text-xs font-medium text-slate-400 mb-2 block">Account Status</label>
                        <div class="px-4 py-2 bg-white/5 border border-white/10 rounded-lg">
                            <span class="text-green-400 font-semibold">
                                <i class="fa-solid fa-circle-check me-1"></i>Active
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Profile Card -->
            <div class="bg-white/5 backdrop-blur-md rounded-xl border border-white/10 p-6 mb-6">
                <h3 class="text-lg font-bold mb-4">
                    <i class="fa-solid fa-user-pen me-2"></i>Edit Profile Information
                </h3>

                <form id="editProfileForm" class="space-y-4" action="{{ route('users.profile.update') }}" method="POST">
                    @csrf
                    <div>
                        <label class="text-xs font-medium text-slate-300 mb-2 block">Username</label>
                        <input 
                            type="text" 
                            id="newUsername" 
                            name="username"
                            value="{{ $user->username_una ?? '' }}"
                            placeholder="Enter username"
                            class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-unaPrimary focus:border-transparent"
                        >
                    </div>

                    <div>
                        <label class="text-xs font-medium text-slate-300 mb-2 block">New Email Address</label>
                        <input 
                            type="email" 
                            id="newEmail" 
                            name="email"
                            value="{{ $user->email_una ?? '' }}"
                            placeholder="Enter new email address"
                            class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-unaPrimary focus:border-transparent"
                        >
                    </div>

                    <div>
                        <label class="text-xs font-medium text-slate-300 mb-2 block">Current Password</label>
                        <input 
                            type="password" 
                            id="currentPassword" 
                            placeholder="Enter current password to confirm changes"
                            class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-unaPrimary focus:border-transparent"
                        >
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-medium text-slate-300 mb-2 block">New Password</label>
                            <input 
                                type="password" 
                                id="newPassword" 
                                placeholder="Enter new password"
                                class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-unaPrimary focus:border-transparent"
                            >
                        </div>

                        <div>
                            <label class="text-xs font-medium text-slate-300 mb-2 block">Confirm New Password</label>
                            <input 
                                type="password" 
                                id="confirmPassword" 
                                placeholder="Confirm new password"
                                class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-unaPrimary focus:border-transparent"
                            >
                        </div>
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button 
                            type="submit" 
                            class="px-6 py-2.5 bg-unaPrimary hover:bg-unaPrimaryDark rounded-lg font-semibold transition-all">
                            <i class="fa-solid fa-save me-2"></i>Save Changes
                        </button>
                        <button 
                            type="button" 
                            onclick="resetForm()"
                            class="px-6 py-2.5 bg-white/10 hover:bg-white/20 rounded-lg font-semibold transition-all">
                            <i class="fa-solid fa-rotate-left me-2"></i>Reset
                        </button>
                    </div>
                </form>
            </div>

            <!-- Danger Zone Card -->
            <div class="bg-red-900/20 backdrop-blur-md rounded-xl border border-red-500/30 p-6">
                <h3 class="text-lg font-bold text-red-400 mb-2">
                    <i class="fa-solid fa-triangle-exclamation me-2"></i>Danger Zone
                </h3>
                <p class="text-sm text-slate-300 mb-4">
                    Once you delete your account, there is no going back. Please be certain.
                </p>

                <button 
                    onclick="confirmDelete()"
                    class="px-6 py-2.5 bg-red-600/20 hover:bg-red-600/30 border border-red-600/50 rounded-lg font-semibold text-red-300 hover:text-red-200 transition-all">
                    <i class="fa-solid fa-trash me-2"></i>Delete Account
                </button>
            </div>

        </div>
    </div>

    <!-- Message Modal -->
    <div id="messageModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-xl p-6 max-w-md w-full">
            <div class="flex items-center gap-3 mb-4">
                <i id="modalIcon" class="text-2xl"></i>
                <h3 id="modalTitle" class="text-xl font-bold"></h3>
            </div>
            <p id="modalMessage" class="text-slate-300 mb-6"></p>
            <div class="flex gap-3">
                <button 
                    id="modalConfirm" 
                    class="flex-1 px-4 py-2 bg-unaPrimary hover:bg-unaPrimaryDark rounded-lg font-semibold">
                    Confirm
                </button>
                <button 
                    onclick="closeModal()" 
                    class="flex-1 px-4 py-2 bg-white/10 hover:bg-white/20 rounded-lg font-semibold">
                    Cancel
                </button>
            </div>
        </div>
    </div>

    <!-- Success/Error Toast -->
    <div id="toast" class="hidden fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg">
        <div class="flex items-center gap-2">
            <i id="toastIcon"></i>
            <span id="toastMessage"></span>
        </div>
    </div>

    <script>
        /* ===== THEME SYNC WITH HOME PAGE (una-dark) ===== */
        const STORAGE_DARK = 'una-dark';

        (function syncProfileTheme() {
            try {
                const isDark = localStorage.getItem(STORAGE_DARK) === '1';
                const body = document.body;

                if (isDark) {
                    body.classList.remove('light-mode');
                    body.classList.add('dark-mode');
                    body.classList.add('bg-unaBgDark', 'text-slate-50');
                    body.classList.remove('bg-slate-100', 'text-slate-900');
                    document.documentElement.classList.add('dark-mode');
                } else {
                    body.classList.add('light-mode');
                    body.classList.remove('dark-mode');
                    body.classList.add('bg-slate-100', 'text-slate-900');
                    body.classList.remove('bg-unaBgDark', 'text-slate-50');
                    document.documentElement.classList.remove('dark-mode');
                }
            } catch (e) {
                console.warn('Theme sync error on profile page:', e);
            }
        })();

        // Edit Profile Form Submission
        document.getElementById('editProfileForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const newUsername = document.getElementById('newUsername').value;
            const newEmail = document.getElementById('newEmail').value;
            const currentPassword = document.getElementById('currentPassword').value;
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            // Validation
            if (!newUsername || !newEmail) {
                showToast('Username and email are required', 'error');
                return;
            }

            // Only require current password if changing password
            if (newPassword && !currentPassword) {
                showToast('Please enter your current password to change password', 'error');
                return;
            }

            if (newPassword && newPassword !== confirmPassword) {
                showToast('New passwords do not match', 'error');
                return;
            }

            if (newPassword && newPassword.length < 6) {
                showToast('New password must be at least 6 characters', 'error');
                return;
            }

            // Create form data
            const formData = new FormData(this);
            if (newPassword) {
                formData.append('password', newPassword);
            }
            if (currentPassword) {
                formData.append('current_password', currentPassword);
            }

            // Send to backend
            fetch('{{ route("users.profile.update") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(data => {
                        throw new Error(data.message || 'Failed to update profile');
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showToast(data.message || 'Profile updated successfully!', 'success');
                    
                    // Update display fields
                    if (newUsername) {
                        document.getElementById('displayUsername').value = newUsername;
                        // Update avatar initial
                        const avatar = document.querySelector('.w-20.h-20.rounded-full');
                        if (avatar) {
                            avatar.textContent = newUsername.charAt(0).toUpperCase();
                        }
                        // Update name
                        const nameElement = document.querySelector('.text-xl.font-bold');
                        if (nameElement) {
                            nameElement.textContent = newUsername;
                        }
                    }
                    if (newEmail) {
                        document.getElementById('displayEmail').value = newEmail;
                    }

                    // Reset form
                    resetForm();
                    
                    // Reload page after 1 second to show updated data
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    showToast(data.message || 'Failed to update profile', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast(error.message || 'An error occurred. Please try again.', 'error');
            });
        });

        function resetForm() {
            document.getElementById('editProfileForm').reset();
        }

        function confirmDelete() {
            const modal = document.getElementById('messageModal');
            const modalIcon = document.getElementById('modalIcon');
            const modalTitle = document.getElementById('modalTitle');
            const modalMessage = document.getElementById('modalMessage');
            const modalConfirm = document.getElementById('modalConfirm');

            modalIcon.className = 'fa-solid fa-triangle-exclamation text-red-400 text-2xl';
            modalTitle.textContent = 'Delete Account';
            modalMessage.textContent = 'Are you absolutely sure? This action cannot be undone. All your data will be permanently deleted.';
            
            modalConfirm.onclick = function() {
                deleteAccount();
            };

            modal.classList.remove('hidden');
        }

        function deleteAccount() {
            // Here you would send delete request to your backend
            // For demo purposes, we'll just show a message and redirect
            showToast('Account deleted successfully', 'success');
            
            setTimeout(() => {
                window.location.href = '{{ url("/intro") }}';
            }, 2000);
        }

        function closeModal() {
            document.getElementById('messageModal').classList.add('hidden');
        }

        function showToast(message, type) {
            const toast = document.getElementById('toast');
            const toastIcon = document.getElementById('toastIcon');
            const toastMessage = document.getElementById('toastMessage');

            if (type === 'success') {
                toast.className = 'fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg bg-green-500/20 border border-green-500/50 text-green-300';
                toastIcon.className = 'fa-solid fa-circle-check';
            } else {
                toast.className = 'fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg bg-red-500/20 border border-red-500/50 text-red-300';
                toastIcon.className = 'fa-solid fa-circle-xmark';
            }

            toastMessage.textContent = message;
            toast.classList.remove('hidden');

            setTimeout(() => {
                toast.classList.add('hidden');
            }, 3000);
        }

        // Close modal when clicking outside
        document.getElementById('messageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>

</body>
</html>
