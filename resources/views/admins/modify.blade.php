<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UNA Admin Panel</title>

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
    </style>
</head>

<body class="bg-unaBgDark text-slate-50 min-h-screen flex">

    <!-- BACKGROUND GLOW -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute -top-40 -left-32 h-80 w-80 rounded-full bg-unaPrimary/40 blur-3xl"></div>
        <div class="absolute -bottom-32 -right-32 h-72 w-72 rounded-full bg-cyan-400/30 blur-3xl"></div>
    </div>

    <!-- SIDEBAR -->
    <aside class="relative z-20 w-64 bg-white/5 backdrop-blur-md border-r border-white/10 p-6 flex flex-col">
        <div>
            <div class="mb-6">
                <div class="h-12 w-12 flex items-center justify-center rounded-xl bg-unaPrimary text-white shadow">
                    🛠️
                </div>
                <h2 class="text-xl font-bold mt-3">Admin Panel</h2>
            </div>

            <nav class="space-y-2 text-sm">
                <button onclick="showSection('dashboard')" class="w-full text-left px-3 py-2 rounded-lg hover:bg-white/10 bg-white/10">
                    🏠 Dashboard
                </button>

                <button onclick="showSection('users')" class="w-full text-left px-3 py-2 rounded-lg hover:bg-white/10">
                    👥 Users
                </button>

                <button onclick="showSection('universities')" class="w-full text-left px-3 py-2 rounded-lg hover:bg-white/10">
                    🏫 Universities
                </button>
            </nav>
        </div>

        <!-- BOTTOM SECTION -->
        <div class="mt-auto space-y-3">
            <button id="darkToggle" class="w-full px-3 py-2 rounded-lg bg-white/10 hover:bg-white/20 text-sm">
                🌙 Dark Mode
            </button>
            
            <button onclick="window.location.href='/intro'" class="w-full flex items-center justify-center gap-2 rounded-lg bg-red-600/20 px-4 py-2 text-sm text-white hover:bg-red-600/30 border border-red-600/30">
                🚪 Logout
            </button>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="relative z-10 flex-1 p-8 overflow-y-auto">

        <!-- Header with back button -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold">Admin Control Panel</h1>
                <p class="text-sm text-slate-400 mt-1">Manage university data, users, and system settings</p>
            </div>
            <a href="{{ url('/admins/home') }}" class="flex items-center gap-2 rounded-lg bg-white/10 px-4 py-2 text-sm text-white hover:bg-white/20 border border-white/10">
                <i class="fa-solid fa-arrow-left"></i>
                Back to Home
            </a>
        </div>

        <!-- DASHBOARD SECTION -->
        <section id="dashboard" class="section">
            <h2 class="text-xl font-bold mb-4">📊 Overview Statistics</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white/5 backdrop-blur-md p-6 rounded-xl border border-white/10 hover:border-unaPrimary/50 transition-all">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-3xl">👥</span>
                        <span class="text-xs bg-blue-500/20 text-blue-300 px-2 py-1 rounded">Active</span>
                    </div>
                    <h3 class="font-semibold text-sm text-slate-400">Total Users</h3>
                    <p class="text-3xl font-bold mt-2">—</p>
                </div>

                <div class="bg-white/5 backdrop-blur-md p-6 rounded-xl border border-white/10 hover:border-unaPrimary/50 transition-all">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-3xl">🏢</span>
                        <span class="text-xs bg-green-500/20 text-green-300 px-2 py-1 rounded">Live</span>
                    </div>
                    <h3 class="font-semibold text-sm text-slate-400">Total Buildings</h3>
                    <p class="text-3xl font-bold mt-2">—</p>
                </div>

                <div class="bg-white/5 backdrop-blur-md p-6 rounded-xl border border-white/10 hover:border-unaPrimary/50 transition-all">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-3xl">🚪</span>
                        <span class="text-xs bg-purple-500/20 text-purple-300 px-2 py-1 rounded">Mapped</span>
                    </div>
                    <h3 class="font-semibold text-sm text-slate-400">Total Rooms</h3>
                    <p class="text-3xl font-bold mt-2">—</p>
                </div>

                <div class="bg-white/5 backdrop-blur-md p-6 rounded-xl border border-white/10 hover:border-unaPrimary/50 transition-all">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-3xl">🟢</span>
                        <span class="text-xs bg-orange-500/20 text-orange-300 px-2 py-1 rounded">Real-time</span>
                    </div>
                    <h3 class="font-semibold text-sm text-slate-400">Free / Occupied</h3>
                    <p class="text-2xl font-bold mt-2">— / —</p>
                </div>
            </div>
        </section>

        <!-- USERS SECTION -->
        <section id="users" class="section hidden">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold">👥 User Management</h2>
                    <p class="text-sm text-slate-400 mt-1">Manage user accounts and permissions</p>
                </div>
                <button class="px-4 py-2 bg-unaPrimary hover:bg-unaPrimaryDark rounded-lg text-white font-semibold transition-all">
                    <i class="fa-solid fa-user-plus me-2"></i>Add New User
                </button>
            </div>

            <div class="bg-white/5 backdrop-blur-md p-6 rounded-xl border border-white/10">
                <div class="mb-4 flex gap-3">
                    <input type="text" placeholder="Search users..." class="flex-1 px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:border-unaPrimary">
                    <button class="px-4 py-2 bg-white/10 hover:bg-white/20 rounded-lg">
                        <i class="fa-solid fa-filter"></i> Filter
                    </button>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-white/10 text-left">
                                <th class="py-3 px-2">Email</th>
                                <th class="py-3 px-2">Name</th>
                                <th class="py-3 px-2">Role</th>
                                <th class="py-3 px-2">Status</th>
                                <th class="py-3 px-2 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-white/5">
                                <td class="py-3 px-2 text-slate-300">user@example.com</td>
                                <td class="py-3 px-2">John Doe</td>
                                <td class="py-3 px-2"><span class="bg-blue-500/20 text-blue-300 px-2 py-1 rounded text-xs">User</span></td>
                                <td class="py-3 px-2"><span class="bg-green-500/20 text-green-300 px-2 py-1 rounded text-xs">Active</span></td>
                                <td class="py-3 px-2 text-right">
                                    <button class="px-2 py-1 bg-unaPrimary/20 hover:bg-unaPrimary/30 rounded text-xs mr-1">Edit</button>
                                    <button class="px-2 py-1 bg-red-600/20 hover:bg-red-600/30 rounded text-xs">Delete</button>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-400">
                                    <i class="fa-solid fa-database text-3xl mb-2"></i>
                                    <p>Connect to database to load users</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- UNIVERSITIES SECTION -->
        <section id="universities" class="section hidden">
            <div class="mb-6">
                <h2 class="text-2xl font-bold">🏫 University Data Management</h2>
                <p class="text-sm text-slate-400 mt-1">Manage buildings, floors, rooms, and accessibility information</p>
            </div>

            <!-- TABS -->
            <div class="flex space-x-2 mb-6 text-sm border-b border-white/10 pb-2">
                <button onclick="showUniTab('buildings')" class="tab-btn bg-unaPrimary text-white px-4 py-2 rounded-t-lg font-semibold">
                    <i class="fa-solid fa-building me-1"></i>Buildings
                </button>
                <button onclick="showUniTab('floors')" class="tab-btn px-4 py-2 rounded-t-lg hover:bg-white/10">
                    <i class="fa-solid fa-layer-group me-1"></i>Floors
                </button>
                <button onclick="showUniTab('rooms')" class="tab-btn px-4 py-2 rounded-t-lg hover:bg-white/10">
                    <i class="fa-solid fa-door-open me-1"></i>Rooms
                </button>
                <button onclick="showUniTab('access')" class="tab-btn px-4 py-2 rounded-t-lg hover:bg-white/10">
                    <i class="fa-solid fa-wheelchair me-1"></i>Accessibility
                </button>
            </div>

            <!-- BUILDINGS TAB -->
            <div id="tab-buildings" class="uni-tab">
                <div class="bg-white/5 backdrop-blur-md p-6 rounded-xl border border-white/10">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h3 class="font-bold text-lg">Buildings</h3>
                            <p class="text-sm text-slate-400">Add, edit, or remove campus buildings</p>
                        </div>
                        <button class="px-4 py-2 bg-unaPrimary hover:bg-unaPrimaryDark rounded-lg font-semibold transition-all">
                            <i class="fa-solid fa-plus me-2"></i>Add Building
                        </button>
                    </div>

                    <div class="space-y-3">
                        <div class="bg-white/10 p-4 rounded-lg flex items-center justify-between hover:bg-white/15 transition-all">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-unaPrimary/20 rounded-lg flex items-center justify-center">
                                    <i class="fa-solid fa-building text-unaPrimary text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold">Building A</h4>
                                    <p class="text-xs text-slate-400">Main Building • 3 Floors • 24 Rooms</p>
                                </div>
                            </div>
                            <div class="space-x-2">
                                <button class="px-3 py-1.5 bg-unaPrimary/20 hover:bg-unaPrimary/30 rounded-md text-sm">
                                    <i class="fa-solid fa-edit me-1"></i>Edit
                                </button>
                                <button class="px-3 py-1.5 bg-red-600/20 hover:bg-red-600/30 rounded-md text-sm">
                                    <i class="fa-solid fa-trash me-1"></i>Delete
                                </button>
                            </div>
                        </div>
                        
                        <div class="bg-white/10 p-4 rounded-lg flex items-center justify-between hover:bg-white/15 transition-all">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-unaPrimary/20 rounded-lg flex items-center justify-center">
                                    <i class="fa-solid fa-building text-unaPrimary text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold">Building B</h4>
                                    <p class="text-xs text-slate-400">Science Wing • 2 Floors • 15 Rooms</p>
                                </div>
                            </div>
                            <div class="space-x-2">
                                <button class="px-3 py-1.5 bg-unaPrimary/20 hover:bg-unaPrimary/30 rounded-md text-sm">
                                    <i class="fa-solid fa-edit me-1"></i>Edit
                                </button>
                                <button class="px-3 py-1.5 bg-red-600/20 hover:bg-red-600/30 rounded-md text-sm">
                                    <i class="fa-solid fa-trash me-1"></i>Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FLOORS TAB -->
            <div id="tab-floors" class="uni-tab hidden">
                <div class="bg-white/5 backdrop-blur-md p-6 rounded-xl border border-white/10">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h3 class="font-bold text-lg">Floors</h3>
                            <p class="text-sm text-slate-400">Manage building floors and their layouts</p>
                        </div>
                        <button class="px-4 py-2 bg-unaPrimary hover:bg-unaPrimaryDark rounded-lg font-semibold transition-all">
                            <i class="fa-solid fa-plus me-2"></i>Add Floor
                        </button>
                    </div>
                    
                    <div class="mb-4">
                        <label class="text-sm text-slate-400 mb-2 block">Select Building</label>
                        <select class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none focus:border-unaPrimary">
                            <option>Building A</option>
                            <option>Building B</option>
                        </select>
                    </div>
                    
                    <div class="text-center py-12 text-slate-400">
                        <i class="fa-solid fa-layer-group text-4xl mb-3"></i>
                        <p>Select a building to manage its floors</p>
                    </div>
                </div>
            </div>

            <!-- ROOMS TAB -->
            <div id="tab-rooms" class="uni-tab hidden">
                <div class="bg-white/5 backdrop-blur-md p-6 rounded-xl border border-white/10">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h3 class="font-bold text-lg">Rooms</h3>
                            <p class="text-sm text-slate-400">Manage campus rooms and their details</p>
                        </div>
                        <button class="px-4 py-2 bg-unaPrimary hover:bg-unaPrimaryDark rounded-lg font-semibold transition-all">
                            <i class="fa-solid fa-plus me-2"></i>Add Room
                        </button>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-3 mb-4">
                        <div>
                            <label class="text-sm text-slate-400 mb-2 block">Building</label>
                            <select class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none focus:border-unaPrimary">
                                <option>Building A</option>
                                <option>Building B</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-sm text-slate-400 mb-2 block">Floor</label>
                            <select class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none focus:border-unaPrimary">
                                <option>Ground Floor</option>
                                <option>Floor 1</option>
                                <option>Floor 2</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="text-center py-12 text-slate-400">
                        <i class="fa-solid fa-door-open text-4xl mb-3"></i>
                        <p>Select building and floor to manage rooms</p>
                    </div>
                </div>
            </div>

            <!-- ACCESSIBILITY TAB -->
            <div id="tab-access" class="uni-tab hidden">
                <div class="bg-white/5 backdrop-blur-md p-6 rounded-xl border border-white/10">
                    <div class="mb-4">
                        <h3 class="font-bold text-lg">Accessibility</h3>
                        <p class="text-sm text-slate-400">Update accessibility data and features for buildings</p>
                    </div>
                    
                    <div class="mb-4">
                        <label class="text-sm text-slate-400 mb-2 block">Select Building</label>
                        <select class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none focus:border-unaPrimary">
                            <option>Building A</option>
                            <option>Building B</option>
                        </select>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-white/5 p-4 rounded-lg border border-white/10">
                            <div class="flex items-center gap-3 mb-3">
                                <i class="fa-solid fa-elevator text-2xl text-unaPrimary"></i>
                                <h4 class="font-semibold">Elevators</h4>
                            </div>
                            <input type="number" placeholder="Number of elevators" class="w-full px-3 py-2 bg-white/5 border border-white/10 rounded text-white text-sm">
                        </div>
                        
                        <div class="bg-white/5 p-4 rounded-lg border border-white/10">
                            <div class="flex items-center gap-3 mb-3">
                                <i class="fa-solid fa-restroom text-2xl text-unaPrimary"></i>
                                <h4 class="font-semibold">Restrooms</h4>
                            </div>
                            <input type="number" placeholder="Accessible restrooms" class="w-full px-3 py-2 bg-white/5 border border-white/10 rounded text-white text-sm">
                        </div>
                        
                        <div class="bg-white/5 p-4 rounded-lg border border-white/10">
                            <div class="flex items-center gap-3 mb-3">
                                <i class="fa-solid fa-person-walking-with-cane text-2xl text-unaPrimary"></i>
                                <h4 class="font-semibold">Ramps</h4>
                            </div>
                            <input type="number" placeholder="Number of ramps" class="w-full px-3 py-2 bg-white/5 border border-white/10 rounded text-white text-sm">
                        </div>
                    </div>
                    
                    <div class="mt-4 flex justify-end">
                        <button class="px-6 py-2 bg-unaPrimary hover:bg-unaPrimaryDark rounded-lg font-semibold transition-all">
                            <i class="fa-solid fa-save me-2"></i>Save Changes
                        </button>
                    </div>
                </div>
            </div>

        </section>

    </main>

    <!-- JAVASCRIPT -->
    <script>
        // Sidebar navigation
        function showSection(section) {
            // Update sections
            document.querySelectorAll('.section').forEach(s => s.classList.add('hidden'));
            document.getElementById(section).classList.remove('hidden');
            
            // Update active nav button
            document.querySelectorAll('nav button').forEach(btn => {
                btn.classList.remove('bg-white/10');
            });
            event.target.classList.add('bg-white/10');
        }

        // University tabs
        function showUniTab(tab) {
            // Hide all tabs
            document.querySelectorAll('.uni-tab').forEach(t => t.classList.add('hidden'));
            
            // Reset all tab buttons
            document.querySelectorAll('.tab-btn').forEach(b => {
                b.classList.remove('bg-unaPrimary', 'text-white');
                b.classList.add('hover:bg-white/10');
            });

            // Show selected tab
            document.getElementById('tab-' + tab).classList.remove('hidden');
            
            // Highlight active tab button
            event.target.classList.add('bg-unaPrimary', 'text-white');
            event.target.classList.remove('hover:bg-white/10');
        }

        // Dark Mode Toggle
        let isDark = false;
        document.getElementById('darkToggle').addEventListener('click', () => {
            isDark = !isDark;
            if (isDark) {
                document.body.classList.add('bg-black');
                document.getElementById('darkToggle').innerHTML = '☀️ Light Mode';
            } else {
                document.body.classList.remove('bg-black');
                document.getElementById('darkToggle').innerHTML = '🌙 Dark Mode';
            }
        });

        // Initialize: Show dashboard by default
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelector('nav button').classList.add('bg-white/10');
        });
    </script>

</body>
</html>

