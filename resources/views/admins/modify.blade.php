<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>UNA Admin Panel - Data Management</title>

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
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.6);
            backdrop-filter: blur(4px);
        }
        .modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .modal-content {
            max-height: 90vh;
            overflow-y: auto;
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
                <button onclick="showSection('dashboard')" class="nav-btn w-full text-left px-3 py-2 rounded-lg hover:bg-white/10 bg-white/10">
                    🏠 Dashboard
                </button>

                <button onclick="showSection('users')" class="nav-btn w-full text-left px-3 py-2 rounded-lg hover:bg-white/10">
                    👥 Users
                </button>

                <button onclick="showSection('universities')" class="nav-btn w-full text-left px-3 py-2 rounded-lg hover:bg-white/10">
                    🏫 Universities
                </button>

                <button onclick="showSection('buildings')" class="nav-btn w-full text-left px-3 py-2 rounded-lg hover:bg-white/10">
                    🏢 Buildings
                </button>

                <button onclick="showSection('rooms')" class="nav-btn w-full text-left px-3 py-2 rounded-lg hover:bg-white/10">
                    🚪 Rooms
                </button>
            </nav>
        </div>

        <!-- BOTTOM SECTION -->
        <div class="mt-auto space-y-3">
            <a href="{{ url('/admins/home') }}" class="w-full flex items-center justify-center gap-2 rounded-lg bg-white/10 px-4 py-2 text-sm text-white hover:bg-white/20 border border-white/10">
                <i class="fa-solid fa-arrow-left"></i>
                Back to Home
            </a>
            
            <button onclick="window.location.href='/intro'" class="w-full flex items-center justify-center gap-2 rounded-lg bg-red-600/20 px-4 py-2 text-sm text-white hover:bg-red-600/30 border border-red-600/30">
                🚪 Logout
            </button>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="relative z-10 flex-1 p-8 overflow-y-auto">

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold">Data Management Console</h1>
                <p class="text-sm text-slate-400 mt-1">Manage university data, users, and system settings</p>
            </div>
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
                    <p id="stat-users" class="text-3xl font-bold mt-2">—</p>
                </div>

                <div class="bg-white/5 backdrop-blur-md p-6 rounded-xl border border-white/10 hover:border-unaPrimary/50 transition-all">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-3xl">🏫</span>
                        <span class="text-xs bg-green-500/20 text-green-300 px-2 py-1 rounded">Live</span>
                    </div>
                    <h3 class="font-semibold text-sm text-slate-400">Total Universities</h3>
                    <p id="stat-universities" class="text-3xl font-bold mt-2">—</p>
                </div>

                <div class="bg-white/5 backdrop-blur-md p-6 rounded-xl border border-white/10 hover:border-unaPrimary/50 transition-all">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-3xl">🏢</span>
                        <span class="text-xs bg-purple-500/20 text-purple-300 px-2 py-1 rounded">Active</span>
                    </div>
                    <h3 class="font-semibold text-sm text-slate-400">Total Buildings</h3>
                    <p id="stat-buildings" class="text-3xl font-bold mt-2">—</p>
                </div>

                <div class="bg-white/5 backdrop-blur-md p-6 rounded-xl border border-white/10 hover:border-unaPrimary/50 transition-all">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-3xl">🚪</span>
                        <span class="text-xs bg-orange-500/20 text-orange-300 px-2 py-1 rounded">Real-time</span>
                    </div>
                    <h3 class="font-semibold text-sm text-slate-400">Total Rooms</h3>
                    <p id="stat-rooms" class="text-3xl font-bold mt-2">—</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white/5 backdrop-blur-md p-6 rounded-xl border border-white/10">
                    <h3 class="font-bold text-lg mb-4">🟢 Room Status</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-slate-300">Free Rooms</span>
                            <span id="stat-free-rooms" class="text-2xl font-bold text-green-400">—</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-300">Occupied Rooms</span>
                            <span id="stat-occupied-rooms" class="text-2xl font-bold text-red-400">—</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white/5 backdrop-blur-md p-6 rounded-xl border border-white/10">
                    <h3 class="font-bold text-lg mb-4">📈 Quick Actions</h3>
                    <div class="space-y-2">
                        <button onclick="showSection('users'); openAddModal('user')" class="w-full text-left px-4 py-2 bg-unaPrimary/20 hover:bg-unaPrimary/30 rounded-lg transition-all">
                            <i class="fa-solid fa-user-plus mr-2"></i>Add New User
                        </button>
                        <button onclick="showSection('universities'); openAddModal('university')" class="w-full text-left px-4 py-2 bg-unaPrimary/20 hover:bg-unaPrimary/30 rounded-lg transition-all">
                            <i class="fa-solid fa-plus mr-2"></i>Add New University
                        </button>
                        <button onclick="showSection('buildings'); openAddModal('building')" class="w-full text-left px-4 py-2 bg-unaPrimary/20 hover:bg-unaPrimary/30 rounded-lg transition-all">
                            <i class="fa-solid fa-building mr-2"></i>Add New Building
                        </button>
                        <button onclick="showSection('rooms'); openAddModal('room')" class="w-full text-left px-4 py-2 bg-unaPrimary/20 hover:bg-unaPrimary/30 rounded-lg transition-all">
                            <i class="fa-solid fa-door-open mr-2"></i>Add New Room
                        </button>
                    </div>
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
                <button onclick="openAddModal('user')" class="px-4 py-2 bg-unaPrimary hover:bg-unaPrimaryDark rounded-lg text-white font-semibold transition-all">
                    <i class="fa-solid fa-user-plus me-2"></i>Add New User
                </button>
            </div>

            <div class="bg-white/5 backdrop-blur-md p-6 rounded-xl border border-white/10">
                <div class="mb-4 flex gap-3">
                    <input id="search-users" type="text" placeholder="Search users..." class="flex-1 px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:border-unaPrimary">
                    <button onclick="loadUsers()" class="px-4 py-2 bg-white/10 hover:bg-white/20 rounded-lg">
                        <i class="fa-solid fa-refresh"></i> Refresh
                    </button>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-white/10 text-left">
                                <th class="py-3 px-2">Username</th>
                                <th class="py-3 px-2">Email</th>
                                <th class="py-3 px-2">Role</th>
                                <th class="py-3 px-2 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="users-table-body">
                            <tr>
                                <td colspan="4" class="py-8 text-center text-slate-400">
                                    <i class="fa-solid fa-spinner fa-spin text-3xl mb-2"></i>
                                    <p>Loading...</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- UNIVERSITIES SECTION -->
        <section id="universities" class="section hidden">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold">🏫 University Management</h2>
                    <p class="text-sm text-slate-400 mt-1">Manage university information</p>
                </div>
                <button onclick="openAddModal('university')" class="px-4 py-2 bg-unaPrimary hover:bg-unaPrimaryDark rounded-lg text-white font-semibold transition-all">
                    <i class="fa-solid fa-plus me-2"></i>Add New University
                </button>
            </div>

            <div class="bg-white/5 backdrop-blur-md p-6 rounded-xl border border-white/10">
                <div class="mb-4 flex gap-3">
                    <input id="search-universities" type="text" placeholder="Search universities..." class="flex-1 px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:border-unaPrimary">
                    <button onclick="loadUniversities()" class="px-4 py-2 bg-white/10 hover:bg-white/20 rounded-lg">
                        <i class="fa-solid fa-refresh"></i> Refresh
                    </button>
                </div>
                
                <div id="universities-grid" class="space-y-3">
                    <div class="py-8 text-center text-slate-400">
                        <i class="fa-solid fa-spinner fa-spin text-3xl mb-2"></i>
                        <p>Loading...</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- BUILDINGS SECTION -->
        <section id="buildings" class="section hidden">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold">🏢 Building Management</h2>
                    <p class="text-sm text-slate-400 mt-1">Manage campus building information</p>
                </div>
                <button onclick="openAddModal('building')" class="px-4 py-2 bg-unaPrimary hover:bg-unaPrimaryDark rounded-lg text-white font-semibold transition-all">
                    <i class="fa-solid fa-plus me-2"></i>Add New Building
                </button>
            </div>

            <div class="bg-white/5 backdrop-blur-md p-6 rounded-xl border border-white/10">
                <div class="mb-4 flex gap-3">
                    <select id="filter-university-buildings" class="px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none focus:border-unaPrimary">
                        <option value="">All Universities</option>
                    </select>
                    <input id="search-buildings" type="text" placeholder="Search buildings..." class="flex-1 px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:border-unaPrimary">
                    <button onclick="loadBuildings()" class="px-4 py-2 bg-white/10 hover:bg-white/20 rounded-lg">
                        <i class="fa-solid fa-refresh"></i> Refresh
                    </button>
                </div>
                
                <div id="buildings-grid" class="space-y-3">
                    <div class="py-8 text-center text-slate-400">
                        <i class="fa-solid fa-spinner fa-spin text-3xl mb-2"></i>
                        <p>Loading...</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ROOMS SECTION -->
        <section id="rooms" class="section hidden">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold">🚪 Room Management</h2>
                    <p class="text-sm text-slate-400 mt-1">Manage campus room information</p>
                </div>
                <button onclick="openAddModal('room')" class="px-4 py-2 bg-unaPrimary hover:bg-unaPrimaryDark rounded-lg text-white font-semibold transition-all">
                    <i class="fa-solid fa-plus me-2"></i>Add New Room
                </button>
            </div>

            <div class="bg-white/5 backdrop-blur-md p-6 rounded-xl border border-white/10">
                <div class="mb-4 grid grid-cols-1 md:grid-cols-4 gap-3">
                    <select id="filter-university-rooms" class="px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none focus:border-unaPrimary">
                        <option value="">All Universities</option>
                    </select>
                    <select id="filter-building-rooms" class="px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none focus:border-unaPrimary">
                        <option value="">All Buildings</option>
                    </select>
                    <input id="search-rooms" type="text" placeholder="Search rooms..." class="px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:border-unaPrimary">
                    <button onclick="loadRooms()" class="px-4 py-2 bg-white/10 hover:bg-white/20 rounded-lg">
                        <i class="fa-solid fa-refresh"></i> Refresh
                    </button>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-white/10 text-left">
                                <th class="py-3 px-2">Room Number</th>
                                <th class="py-3 px-2">Room Name</th>
                                <th class="py-3 px-2">Building</th>
                                <th class="py-3 px-2">Floor</th>
                                <th class="py-3 px-2">Type</th>
                                <th class="py-3 px-2">Status</th>
                                <th class="py-3 px-2 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="rooms-table-body">
                            <tr>
                                <td colspan="7" class="py-8 text-center text-slate-400">
                                    <i class="fa-solid fa-spinner fa-spin text-3xl mb-2"></i>
                                    <p>Loading...</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

    </main>

    <!-- MODALS -->
    <!-- User Modal -->
    <div id="user-modal" class="modal">
        <div class="modal-content bg-white/5 backdrop-blur-md p-8 rounded-xl border border-white/10 w-full max-w-md mx-4">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold" id="user-modal-title">Add User</h3>
                <button onclick="closeModal('user-modal')" class="text-slate-400 hover:text-white">
                    <i class="fa-solid fa-times text-2xl"></i>
                </button>
            </div>
            <form id="user-form" onsubmit="saveUser(event)">
                <input type="hidden" id="user-id">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm text-slate-400 mb-2">Username *</label>
                        <input type="text" id="user-username" required class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none focus:border-unaPrimary">
                    </div>
                    <div>
                        <label class="block text-sm text-slate-400 mb-2">Email *</label>
                        <input type="email" id="user-email" required class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none focus:border-unaPrimary">
                    </div>
                    <div>
                        <label class="block text-sm text-slate-400 mb-2">Password <span id="password-hint">(leave empty to keep current)</span></label>
                        <input type="password" id="user-password" class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none focus:border-unaPrimary">
                    </div>
                    <div>
                        <label class="block text-sm text-slate-400 mb-2">Role *</label>
                        <select id="user-role" required class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none focus:border-unaPrimary">
                            <option value="">Select role...</option>
                        </select>
                    </div>
                </div>
                <div class="mt-6 flex gap-3">
                    <button type="submit" class="flex-1 px-4 py-2 bg-unaPrimary hover:bg-unaPrimaryDark rounded-lg font-semibold transition-all">
                        <i class="fa-solid fa-save mr-2"></i>Save
                    </button>
                    <button type="button" onclick="closeModal('user-modal')" class="px-4 py-2 bg-white/10 hover:bg-white/20 rounded-lg transition-all">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- University Modal -->
    <div id="university-modal" class="modal">
        <div class="modal-content bg-white/5 backdrop-blur-md p-8 rounded-xl border border-white/10 w-full max-w-md mx-4">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold" id="university-modal-title">Add University</h3>
                <button onclick="closeModal('university-modal')" class="text-slate-400 hover:text-white">
                    <i class="fa-solid fa-times text-2xl"></i>
                </button>
            </div>
            <form id="university-form" onsubmit="saveUniversity(event)">
                <input type="hidden" id="university-id">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm text-slate-400 mb-2">University Name *</label>
                        <input type="text" id="university-name" required class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none focus:border-unaPrimary">
                    </div>
                    <div>
                        <label class="block text-sm text-slate-400 mb-2">City/Country *</label>
                        <input type="text" id="university-city" required class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none focus:border-unaPrimary">
                    </div>
                    <div>
                        <label class="block text-sm text-slate-400 mb-2">Population *</label>
                        <input type="number" id="university-population" required class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none focus:border-unaPrimary">
                    </div>
                    <div>
                        <label class="block text-sm text-slate-400 mb-2">Post Code *</label>
                        <input type="number" id="university-postcode" required class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none focus:border-unaPrimary">
                    </div>
                </div>
                <div class="mt-6 flex gap-3">
                    <button type="submit" class="flex-1 px-4 py-2 bg-unaPrimary hover:bg-unaPrimaryDark rounded-lg font-semibold transition-all">
                        <i class="fa-solid fa-save mr-2"></i>Save
                    </button>
                    <button type="button" onclick="closeModal('university-modal')" class="px-4 py-2 bg-white/10 hover:bg-white/20 rounded-lg transition-all">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Building Modal -->
    <div id="building-modal" class="modal">
        <div class="modal-content bg-white/5 backdrop-blur-md p-8 rounded-xl border border-white/10 w-full max-w-md mx-4">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold" id="building-modal-title">Add Building</h3>
                <button onclick="closeModal('building-modal')" class="text-slate-400 hover:text-white">
                    <i class="fa-solid fa-times text-2xl"></i>
                </button>
            </div>
            <form id="building-form" onsubmit="saveBuilding(event)">
                <input type="hidden" id="building-id">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm text-slate-400 mb-2">Building Code</label>
                        <input type="text" id="building-code" class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none focus:border-unaPrimary">
                    </div>
                    <div>
                        <label class="block text-sm text-slate-400 mb-2">Building Name</label>
                        <input type="text" id="building-name" class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none focus:border-unaPrimary">
                    </div>
                    <div>
                        <label class="block text-sm text-slate-400 mb-2">University *</label>
                        <select id="building-university" required class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none focus:border-unaPrimary">
                            <option value="">Select university...</option>
                        </select>
                    </div>
                </div>
                <div class="mt-6 flex gap-3">
                    <button type="submit" class="flex-1 px-4 py-2 bg-unaPrimary hover:bg-unaPrimaryDark rounded-lg font-semibold transition-all">
                        <i class="fa-solid fa-save mr-2"></i>Save
                    </button>
                    <button type="button" onclick="closeModal('building-modal')" class="px-4 py-2 bg-white/10 hover:bg-white/20 rounded-lg transition-all">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Room Modal -->
    <div id="room-modal" class="modal">
        <div class="modal-content bg-white/5 backdrop-blur-md p-8 rounded-xl border border-white/10 w-full max-w-md mx-4">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold" id="room-modal-title">Add Room</h3>
                <button onclick="closeModal('room-modal')" class="text-slate-400 hover:text-white">
                    <i class="fa-solid fa-times text-2xl"></i>
                </button>
            </div>
            <form id="room-form" onsubmit="saveRoom(event)">
                <input type="hidden" id="room-id">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm text-slate-400 mb-2">Room Number *</label>
                        <input type="text" id="room-number" required class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none focus:border-unaPrimary">
                    </div>
                    <div>
                        <label class="block text-sm text-slate-400 mb-2">Room Name</label>
                        <input type="text" id="room-name" class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none focus:border-unaPrimary">
                    </div>
                    <div>
                        <label class="block text-sm text-slate-400 mb-2">Floor Number</label>
                        <input type="number" id="room-floor" class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none focus:border-unaPrimary">
                    </div>
                    <div>
                        <label class="block text-sm text-slate-400 mb-2">University *</label>
                        <select id="room-university" required class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none focus:border-unaPrimary">
                            <option value="">Select university...</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm text-slate-400 mb-2">Building *</label>
                        <select id="room-building" required class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none focus:border-unaPrimary">
                            <option value="">Please select university first...</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm text-slate-400 mb-2">Room Type *</label>
                        <select id="room-type" required class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none focus:border-unaPrimary">
                            <option value="">Select type...</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm text-slate-400 mb-2">Availability *</label>
                        <select id="room-availability" required class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none focus:border-unaPrimary">
                            <option value="">Select status...</option>
                        </select>
                    </div>
                </div>
                <div class="mt-6 flex gap-3">
                    <button type="submit" class="flex-1 px-4 py-2 bg-unaPrimary hover:bg-unaPrimaryDark rounded-lg font-semibold transition-all">
                        <i class="fa-solid fa-save mr-2"></i>Save
                    </button>
                    <button type="button" onclick="closeModal('room-modal')" class="px-4 py-2 bg-white/10 hover:bg-white/20 rounded-lg transition-all">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script>
        // CSRF Token Setup
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // Global Data
        let allUniversities = [];
        let allBuildings = [];
        let allRooms = [];
        let allUsers = [];
        let allRoles = [];
        let allRoomTypes = [];
        let allAvailability = [];

        // Sidebar navigation
        function showSection(section) {
            document.querySelectorAll('.section').forEach(s => s.classList.add('hidden'));
            document.getElementById(section).classList.remove('hidden');
            
            document.querySelectorAll('.nav-btn').forEach(btn => {
                btn.classList.remove('bg-white/10');
            });
            event.target.classList.add('bg-white/10');

            // Load data when section is shown
            if (section === 'users') loadUsers();
            else if (section === 'universities') loadUniversities();
            else if (section === 'buildings') loadBuildings();
            else if (section === 'rooms') loadRooms();
        }

        // Modal functions
        function openAddModal(type) {
            const modalId = type + '-modal';
            document.getElementById(modalId).classList.add('active');
            document.getElementById(type + '-modal-title').textContent = 'Add ' + getTypeName(type);
            document.getElementById(type + '-form').reset();
            document.getElementById(type + '-id').value = '';
            
            if (type === 'user') {
                document.getElementById('password-hint').textContent = '';
                document.getElementById('user-password').required = true;
            }
        }

        function openEditModal(type, id) {
            const modalId = type + '-modal';
            document.getElementById(modalId).classList.add('active');
            document.getElementById(type + '-modal-title').textContent = 'Edit ' + getTypeName(type);
            
            if (type === 'user') {
                document.getElementById('password-hint').textContent = '(leave empty to keep current)';
                document.getElementById('user-password').required = false;
                const user = allUsers.find(u => u.id_user_una == id);
                if (user) {
                    document.getElementById('user-id').value = user.id_user_una;
                    document.getElementById('user-username').value = user.username_una;
                    document.getElementById('user-email').value = user.email_una;
                    document.getElementById('user-role').value = user.id_role_una;
                }
            } else if (type === 'university') {
                const uni = allUniversities.find(u => u.id_university_una == id);
                if (uni) {
                    document.getElementById('university-id').value = uni.id_university_una;
                    document.getElementById('university-name').value = uni.university_name_una;
                    document.getElementById('university-city').value = uni.city_country;
                    document.getElementById('university-population').value = uni.population;
                    document.getElementById('university-postcode').value = uni.post_code;
                }
            } else if (type === 'building') {
                const building = allBuildings.find(b => b.id_building_una == id);
                if (building) {
                    document.getElementById('building-id').value = building.id_building_una;
                    document.getElementById('building-code').value = building.building_code_una || '';
                    document.getElementById('building-name').value = building.building_name_una || '';
                    document.getElementById('building-university').value = building.id_university_una;
                }
            } else if (type === 'room') {
                const room = allRooms.find(r => r.id_room_una == id);
                if (room) {
                    document.getElementById('room-id').value = room.id_room_una;
                    document.getElementById('room-number').value = room.room_number_una;
                    document.getElementById('room-name').value = room.room_name_una || '';
                    document.getElementById('room-floor').value = room.floor_number_una || '';
                    document.getElementById('room-university').value = room.id_university_una;
                    
                    // Load buildings for this university
                    loadBuildingsForRoom(room.id_university_una, room.id_building_una);
                    
                    document.getElementById('room-type').value = room.id_room_type_una;
                    document.getElementById('room-availability').value = room.id_availability_una;
                }
            }
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('active');
        }

        function getTypeName(type) {
            const names = {
                'user': 'User',
                'university': 'University',
                'building': 'Building',
                'room': 'Room'
            };
            return names[type] || type;
        }

        // API calls
        async function fetchAPI(url, options = {}) {
            const defaultOptions = {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            };
            
            try {
                const response = await fetch(url, { ...defaultOptions, ...options });
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return await response.json();
            } catch (error) {
                console.error('API Error:', error);
                alert('Operation failed: ' + error.message);
                throw error;
            }
        }

        // Load Statistics
        async function loadStats() {
            try {
                const stats = await fetchAPI('/api/admin/stats');
                document.getElementById('stat-users').textContent = stats.users;
                document.getElementById('stat-universities').textContent = stats.universities;
                document.getElementById('stat-buildings').textContent = stats.buildings;
                document.getElementById('stat-rooms').textContent = stats.rooms;
                document.getElementById('stat-free-rooms').textContent = stats.free_rooms;
                document.getElementById('stat-occupied-rooms').textContent = stats.occupied_rooms;
            } catch (error) {
                console.error('Failed to load stats:', error);
            }
        }

        // Load Users
        async function loadUsers() {
            try {
                allUsers = await fetchAPI('/api/admin/users');
                renderUsers();
            } catch (error) {
                document.getElementById('users-table-body').innerHTML = `
                    <tr><td colspan="4" class="py-8 text-center text-red-400">
                        <i class="fa-solid fa-exclamation-triangle text-3xl mb-2"></i>
                        <p>加载失败</p>
                    </td></tr>`;
            }
        }

        function renderUsers() {
            const tbody = document.getElementById('users-table-body');
            const searchTerm = document.getElementById('search-users').value.toLowerCase();
            
            const filtered = allUsers.filter(u => 
                u.username_una.toLowerCase().includes(searchTerm) ||
                u.email_una.toLowerCase().includes(searchTerm)
            );

            if (filtered.length === 0) {
                tbody.innerHTML = `<tr><td colspan="4" class="py-8 text-center text-slate-400">
                    <i class="fa-solid fa-inbox text-3xl mb-2"></i>
                    <p>No users found</p>
                </td></tr>`;
                return;
            }

            tbody.innerHTML = filtered.map(user => `
                <tr class="border-b border-white/5 hover:bg-white/5">
                    <td class="py-3 px-2">${user.username_una}</td>
                    <td class="py-3 px-2 text-slate-300">${user.email_una}</td>
                    <td class="py-3 px-2">
                        <span class="bg-${user.role?.id_role_una == 2 ? 'red' : 'blue'}-500/20 text-${user.role?.id_role_una == 2 ? 'red' : 'blue'}-300 px-2 py-1 rounded text-xs">
                            ${user.role?.role_name_una || 'Unknown'}
                        </span>
                    </td>
                    <td class="py-3 px-2 text-right">
                        <button onclick="openEditModal('user', ${user.id_user_una})" class="px-2 py-1 bg-unaPrimary/20 hover:bg-unaPrimary/30 rounded text-xs mr-1">
                            <i class="fa-solid fa-edit"></i> Edit
                        </button>
                        <button onclick="deleteUser(${user.id_user_una})" class="px-2 py-1 bg-red-600/20 hover:bg-red-600/30 rounded text-xs">
                            <i class="fa-solid fa-trash"></i> Delete
                        </button>
                    </td>
                </tr>
            `).join('');
        }

        // Load Universities
        async function loadUniversities() {
            try {
                allUniversities = await fetchAPI('/api/admin/universities');
                renderUniversities();
                populateUniversitySelects();
            } catch (error) {
                document.getElementById('universities-grid').innerHTML = `
                    <div class="py-8 text-center text-red-400">
                        <i class="fa-solid fa-exclamation-triangle text-3xl mb-2"></i>
                        <p>加载失败</p>
                    </div>`;
            }
        }

        function renderUniversities() {
            const grid = document.getElementById('universities-grid');
            const searchTerm = document.getElementById('search-universities').value.toLowerCase();
            
            const filtered = allUniversities.filter(u => 
                u.university_name_una.toLowerCase().includes(searchTerm) ||
                u.city_country.toLowerCase().includes(searchTerm)
            );

            if (filtered.length === 0) {
                grid.innerHTML = `<div class="py-8 text-center text-slate-400">
                    <i class="fa-solid fa-inbox text-3xl mb-2"></i>
                    <p>No universities found</p>
                </div>`;
                return;
            }

            grid.innerHTML = filtered.map(uni => `
                <div class="bg-white/10 p-4 rounded-lg flex items-center justify-between hover:bg-white/15 transition-all">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-unaPrimary/20 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-university text-unaPrimary text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold">${uni.university_name_una}</h4>
                            <p class="text-xs text-slate-400">${uni.city_country} • Population: ${uni.population} • Postcode: ${uni.post_code}</p>
                        </div>
                    </div>
                    <div class="space-x-2">
                        <button onclick="openEditModal('university', ${uni.id_university_una})" class="px-3 py-1.5 bg-unaPrimary/20 hover:bg-unaPrimary/30 rounded-md text-sm">
                            <i class="fa-solid fa-edit me-1"></i>Edit
                        </button>
                        <button onclick="deleteUniversity(${uni.id_university_una})" class="px-3 py-1.5 bg-red-600/20 hover:bg-red-600/30 rounded-md text-sm">
                            <i class="fa-solid fa-trash me-1"></i>Delete
                        </button>
                    </div>
                </div>
            `).join('');
        }

        // Load Buildings
        async function loadBuildings() {
            try {
                allBuildings = await fetchAPI('/api/admin/buildings');
                renderBuildings();
            } catch (error) {
                document.getElementById('buildings-grid').innerHTML = `
                    <div class="py-8 text-center text-red-400">
                        <i class="fa-solid fa-exclamation-triangle text-3xl mb-2"></i>
                        <p>加载失败</p>
                    </div>`;
            }
        }

        function renderBuildings() {
            const grid = document.getElementById('buildings-grid');
            const searchTerm = document.getElementById('search-buildings').value.toLowerCase();
            const filterUni = document.getElementById('filter-university-buildings').value;
            
            let filtered = allBuildings.filter(b => {
                const nameMatch = (b.building_name_una || '').toLowerCase().includes(searchTerm) ||
                                (b.building_code_una || '').toLowerCase().includes(searchTerm);
                const uniMatch = !filterUni || b.id_university_una == filterUni;
                return nameMatch && uniMatch;
            });

            if (filtered.length === 0) {
                grid.innerHTML = `<div class="py-8 text-center text-slate-400">
                    <i class="fa-solid fa-inbox text-3xl mb-2"></i>
                    <p>No buildings found</p>
                </div>`;
                return;
            }

            grid.innerHTML = filtered.map(building => {
                const uni = allUniversities.find(u => u.id_university_una == building.id_university_una);
                return `
                    <div class="bg-white/10 p-4 rounded-lg flex items-center justify-between hover:bg-white/15 transition-all">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-unaPrimary/20 rounded-lg flex items-center justify-center">
                                <i class="fa-solid fa-building text-unaPrimary text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold">${building.building_name_una || building.building_code_una || 'Unnamed'}</h4>
                                <p class="text-xs text-slate-400">${uni?.university_name_una || 'Unknown University'} ${building.building_code_una ? '• Code: ' + building.building_code_una : ''}</p>
                            </div>
                        </div>
                        <div class="space-x-2">
                            <button onclick="openEditModal('building', ${building.id_building_una})" class="px-3 py-1.5 bg-unaPrimary/20 hover:bg-unaPrimary/30 rounded-md text-sm">
                                <i class="fa-solid fa-edit me-1"></i>Edit
                            </button>
                            <button onclick="deleteBuilding(${building.id_building_una})" class="px-3 py-1.5 bg-red-600/20 hover:bg-red-600/30 rounded-md text-sm">
                                <i class="fa-solid fa-trash me-1"></i>Delete
                            </button>
                        </div>
                    </div>
                `;
            }).join('');
        }

        // Load Rooms
        async function loadRooms() {
            try {
                allRooms = await fetchAPI('/api/admin/rooms');
                renderRooms();
            } catch (error) {
                document.getElementById('rooms-table-body').innerHTML = `
                    <tr><td colspan="7" class="py-8 text-center text-red-400">
                        <i class="fa-solid fa-exclamation-triangle text-3xl mb-2"></i>
                        <p>加载失败</p>
                    </td></tr>`;
            }
        }

        function renderRooms() {
            const tbody = document.getElementById('rooms-table-body');
            const searchTerm = document.getElementById('search-rooms').value.toLowerCase();
            const filterUni = document.getElementById('filter-university-rooms').value;
            const filterBuilding = document.getElementById('filter-building-rooms').value;
            
            let filtered = allRooms.filter(r => {
                const searchMatch = r.room_number_una.toLowerCase().includes(searchTerm) ||
                                  (r.room_name_una || '').toLowerCase().includes(searchTerm);
                const uniMatch = !filterUni || r.id_university_una == filterUni;
                const buildingMatch = !filterBuilding || r.id_building_una == filterBuilding;
                return searchMatch && uniMatch && buildingMatch;
            });

            if (filtered.length === 0) {
                tbody.innerHTML = `<tr><td colspan="7" class="py-8 text-center text-slate-400">
                    <i class="fa-solid fa-inbox text-3xl mb-2"></i>
                    <p>No rooms found</p>
                </td></tr>`;
                return;
            }

            tbody.innerHTML = filtered.map(room => {
                const building = allBuildings.find(b => b.id_building_una == room.id_building_una);
                return `
                    <tr class="border-b border-white/5 hover:bg-white/5">
                        <td class="py-3 px-2 font-semibold">${room.room_number_una}</td>
                        <td class="py-3 px-2">${room.room_name_una || '—'}</td>
                        <td class="py-3 px-2 text-slate-300">${building?.building_name_una || building?.building_code_una || '—'}</td>
                        <td class="py-3 px-2">${room.floor_number_una !== null ? 'Floor ' + room.floor_number_una : '—'}</td>
                        <td class="py-3 px-2">
                            <span class="bg-blue-500/20 text-blue-300 px-2 py-1 rounded text-xs">
                                ${room.room_type?.room_type_una || '—'}
                            </span>
                        </td>
                        <td class="py-3 px-2">
                            <span class="bg-${room.availability?.id_availability_una == 1 ? 'green' : 'red'}-500/20 text-${room.availability?.id_availability_una == 1 ? 'green' : 'red'}-300 px-2 py-1 rounded text-xs">
                                ${room.availability?.availability_una || '—'}
                            </span>
                        </td>
                        <td class="py-3 px-2 text-right">
                            <button onclick="openEditModal('room', ${room.id_room_una})" class="px-2 py-1 bg-unaPrimary/20 hover:bg-unaPrimary/30 rounded text-xs mr-1">
                                <i class="fa-solid fa-edit"></i>
                            </button>
                            <button onclick="deleteRoom(${room.id_room_una})" class="px-2 py-1 bg-red-600/20 hover:bg-red-600/30 rounded text-xs">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        // Save functions
        async function saveUser(event) {
            event.preventDefault();
            const id = document.getElementById('user-id').value;
            const data = {
                username_una: document.getElementById('user-username').value,
                email_una: document.getElementById('user-email').value,
                id_role_una: document.getElementById('user-role').value
            };
            
            const password = document.getElementById('user-password').value;
            if (password) {
                data.password_una = password;
            }

            try {
                if (id) {
                    await fetchAPI(`/api/admin/users/${id}`, {
                        method: 'PUT',
                        body: JSON.stringify(data)
                    });
                } else {
                    await fetchAPI('/api/admin/users', {
                        method: 'POST',
                        body: JSON.stringify(data)
                    });
                }
                closeModal('user-modal');
                loadUsers();
                loadStats();
                alert('Saved successfully!');
            } catch (error) {
                console.error('Save error:', error);
            }
        }

        async function saveUniversity(event) {
            event.preventDefault();
            const id = document.getElementById('university-id').value;
            const data = {
                university_name_una: document.getElementById('university-name').value,
                city_country: document.getElementById('university-city').value,
                population: parseInt(document.getElementById('university-population').value),
                post_code: parseInt(document.getElementById('university-postcode').value)
            };

            try {
                if (id) {
                    await fetchAPI(`/api/admin/universities/${id}`, {
                        method: 'PUT',
                        body: JSON.stringify(data)
                    });
                } else {
                    await fetchAPI('/api/admin/universities', {
                        method: 'POST',
                        body: JSON.stringify(data)
                    });
                }
                closeModal('university-modal');
                loadUniversities();
                loadStats();
                alert('Saved successfully!');
            } catch (error) {
                console.error('Save error:', error);
            }
        }

        async function saveBuilding(event) {
            event.preventDefault();
            const id = document.getElementById('building-id').value;
            const data = {
                building_code_una: document.getElementById('building-code').value || null,
                building_name_una: document.getElementById('building-name').value || null,
                id_university_una: document.getElementById('building-university').value
            };

            try {
                if (id) {
                    await fetchAPI(`/api/admin/buildings/${id}`, {
                        method: 'PUT',
                        body: JSON.stringify(data)
                    });
                } else {
                    await fetchAPI('/api/admin/buildings', {
                        method: 'POST',
                        body: JSON.stringify(data)
                    });
                }
                closeModal('building-modal');
                loadBuildings();
                loadStats();
                alert('Saved successfully!');
            } catch (error) {
                console.error('Save error:', error);
            }
        }

        async function saveRoom(event) {
            event.preventDefault();
            const id = document.getElementById('room-id').value;
            const floorValue = document.getElementById('room-floor').value;
            const data = {
                room_number_una: document.getElementById('room-number').value,
                room_name_una: document.getElementById('room-name').value || null,
                floor_number_una: floorValue ? parseInt(floorValue) : null,
                id_university_una: document.getElementById('room-university').value,
                id_building_una: document.getElementById('room-building').value,
                id_room_type_una: document.getElementById('room-type').value,
                id_availability_una: document.getElementById('room-availability').value
            };

            try {
                if (id) {
                    await fetchAPI(`/api/admin/rooms/${id}`, {
                        method: 'PUT',
                        body: JSON.stringify(data)
                    });
                } else {
                    await fetchAPI('/api/admin/rooms', {
                        method: 'POST',
                        body: JSON.stringify(data)
                    });
                }
                closeModal('room-modal');
                loadRooms();
                loadStats();
                alert('Saved successfully!');
            } catch (error) {
                console.error('Save error:', error);
            }
        }

        // Delete functions
        async function deleteUser(id) {
            if (!confirm('Are you sure you want to delete this user?')) return;
            try {
                await fetchAPI(`/api/admin/users/${id}`, { method: 'DELETE' });
                loadUsers();
                loadStats();
                alert('Deleted successfully!');
            } catch (error) {
                console.error('Delete error:', error);
            }
        }

        async function deleteUniversity(id) {
            if (!confirm('Are you sure you want to delete this university? This will also delete all related buildings and rooms!')) return;
            try {
                await fetchAPI(`/api/admin/universities/${id}`, { method: 'DELETE' });
                loadUniversities();
                loadStats();
                alert('Deleted successfully!');
            } catch (error) {
                console.error('Delete error:', error);
            }
        }

        async function deleteBuilding(id) {
            if (!confirm('Are you sure you want to delete this building? This will also delete all related rooms!')) return;
            try {
                await fetchAPI(`/api/admin/buildings/${id}`, { method: 'DELETE' });
                loadBuildings();
                loadStats();
                alert('Deleted successfully!');
            } catch (error) {
                console.error('Delete error:', error);
            }
        }

        async function deleteRoom(id) {
            if (!confirm('Are you sure you want to delete this room?')) return;
            try {
                await fetchAPI(`/api/admin/rooms/${id}`, { method: 'DELETE' });
                loadRooms();
                loadStats();
                alert('Deleted successfully!');
            } catch (error) {
                console.error('Delete error:', error);
            }
        }

        // Helper functions
        function populateUniversitySelects() {
            const selects = [
                document.getElementById('building-university'),
                document.getElementById('room-university'),
                document.getElementById('filter-university-buildings'),
                document.getElementById('filter-university-rooms')
            ];

            selects.forEach((select, index) => {
                const currentValue = select.value;
                const isFilter = index >= 2;
                
                select.innerHTML = (isFilter ? '<option value="">All Universities</option>' : '<option value="">Select university...</option>') +
                    allUniversities.map(u => `<option value="${u.id_university_una}">${u.university_name_una}</option>`).join('');
                
                if (currentValue) select.value = currentValue;
            });
        }

        async function loadBuildingsForRoom(universityId, selectedBuildingId = null) {
            const select = document.getElementById('room-building');
            const filtered = allBuildings.filter(b => b.id_university_una == universityId);
            
            select.innerHTML = '<option value="">Select building...</option>' +
                filtered.map(b => `<option value="${b.id_building_una}">${b.building_name_una || b.building_code_una}</option>`).join('');
            
            if (selectedBuildingId) {
                select.value = selectedBuildingId;
            }
        }

        // Event listeners
        document.getElementById('search-users')?.addEventListener('input', renderUsers);
        document.getElementById('search-universities')?.addEventListener('input', renderUniversities);
        document.getElementById('search-buildings')?.addEventListener('input', renderBuildings);
        document.getElementById('search-rooms')?.addEventListener('input', renderRooms);
        document.getElementById('filter-university-buildings')?.addEventListener('change', renderBuildings);
        document.getElementById('filter-university-rooms')?.addEventListener('change', () => {
            const uniId = document.getElementById('filter-university-rooms').value;
            const buildingSelect = document.getElementById('filter-building-rooms');
            
            if (uniId) {
                const filtered = allBuildings.filter(b => b.id_university_una == uniId);
                buildingSelect.innerHTML = '<option value="">All Buildings</option>' +
                    filtered.map(b => `<option value="${b.id_building_una}">${b.building_name_una || b.building_code_una}</option>`).join('');
            } else {
                buildingSelect.innerHTML = '<option value="">All Buildings</option>';
            }
            
            renderRooms();
        });
        document.getElementById('filter-building-rooms')?.addEventListener('change', renderRooms);

        document.getElementById('room-university')?.addEventListener('change', (e) => {
            loadBuildingsForRoom(e.target.value);
        });

        // Load initial data
        async function initializeApp() {
            try {
                // Load all reference data
                allRoles = await fetchAPI('/api/admin/roles');
                allRoomTypes = await fetchAPI('/api/admin/room-types');
                allAvailability = await fetchAPI('/api/admin/availability');
                
                // Populate role select
                const roleSelect = document.getElementById('user-role');
                roleSelect.innerHTML = '<option value="">Select role...</option>' +
                    allRoles.map(r => `<option value="${r.id_role_una}">${r.role_name_una}</option>`).join('');
                
                // Populate room type select
                const typeSelect = document.getElementById('room-type');
                typeSelect.innerHTML = '<option value="">Select type...</option>' +
                    allRoomTypes.map(t => `<option value="${t.id_room_type_una}">${t.room_type_una}</option>`).join('');
                
                // Populate availability select
                const availSelect = document.getElementById('room-availability');
                availSelect.innerHTML = '<option value="">Select status...</option>' +
                    allAvailability.map(a => `<option value="${a.id_availability_una}">${a.availability_una}</option>`).join('');
                
                // Load initial data
                await loadStats();
                await loadUniversities();
            } catch (error) {
                console.error('Initialization error:', error);
                alert('Initialization failed, please refresh the page');
            }
        }

        // Initialize when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initializeApp);
        } else {
            initializeApp();
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.classList.remove('active');
            }
        }
    </script>

</body>
</html>
