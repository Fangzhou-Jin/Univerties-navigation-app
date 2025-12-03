<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Universities Navigation Application (UNA)</title>

  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

  <style>
    /* =============== Emerald Slate Theme (no orange) =============== */
    :root {
      --primary: #379eb0;        /* Emerald */
      --primary-dark: #07595a;
      --accent: #379eb0;         /* Teal Mint */
      --bg: #F4F9F9;
      --bg-strong: #1A1E23;
      --surface: #ffffff;
      --surface-strong: #111827;
      --text: #1F2933;
      --text-weak: #6B7280;
      --text-inverse: #F9FAFB;
      --muted: #D9E2EC;
      --muted-strong: #2B3547;
      --ok: #2ECC71;
      --busy: #E63946;
      --warn: #FFC857;
      --link: #1565C0;
    }

    * { box-sizing: border-box; }

    body {
      font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
      background: var(--bg);
      color: var(--text);
    }

    body.dark-mode {
      background: var(--bg-strong);
      color: var(--text-inverse);
    }

    a { color: var(--link); }
    a:hover { color: var(--link); text-decoration: underline; }

    /* =============== Layout =============== */
    .sidebar {
      min-height: 100vh;
      background: var(--primary);
      color: #fff;
      padding: 20px 15px;
    }

    body.dark-mode .sidebar {
      background: var(--primary-dark);
    }

    .sidebar-brand {
      font-weight: 900;
      letter-spacing: 0.06em;
    }

    .sidebar a.nav-link {
      color: #e5f5f6;
      border-radius: 8px;
      padding: 8px 10px;
      margin-bottom: 4px;
    }

    .sidebar a.nav-link:hover,
    .sidebar a.nav-link.active {
      background: rgba(255,255,255,0.16);
      color: #ffffff;
      text-decoration: none;
    }

    .sidebar hr {
      border-color: rgba(255,255,255,0.3);
    }

    .main-header-title {
      font-weight: 900;
      letter-spacing: .02em;
    }

    body.dark-mode .card {
      background: var(--surface-strong);
      color: var(--text-inverse);
      border-color: var(--muted-strong);
    }

    body.dark-mode .form-control,
    body.dark-mode .form-select {
      background-color: #020617;
      color: var(--text-inverse);
      border-color: var(--muted-strong);
    }

    /* =============== Map & Rooms =============== */
    #mapContainer svg {
      background: #E0ECF4;
      display: block;
      width: 100%;
      height: 380px;
    }

    body.dark-mode #mapContainer svg {
      background: #020617;
    }

    .room-card {
      transition: transform .15s ease, box-shadow .15s ease;
    }

    .room-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 22px rgba(15,23,42,0.18);
    }

    .room-id-badge {
      display: inline-block;
      padding: 4px 10px;
      border-radius: 999px;
      border: 1px solid var(--muted);
      font-weight: 700;
      background: #ffffff;
      font-size: 0.8rem;
    }

    body.dark-mode .room-id-badge {
      background: rgba(255,255,255,0.05);
      border-color: var(--muted-strong);
    }

    .room-tag {
      font-size: 0.75rem;
      padding: 3px 8px;
      border-radius: 999px;
      background: #E5F6F7;
      border: 1px solid #C4E4E7;
    }

    body.dark-mode .room-tag {
      background: rgba(255,255,255,0.06);
      border-color: var(--muted-strong);
    }

    .status-ok { color: var(--ok); font-weight: 700; }
    .status-busy { color: var(--busy); font-weight: 700; }

    /* Filter buttons in sidebar */
    .filter-btn {
      text-align: left;
      border-radius: 10px;
      margin-bottom: 6px;
      font-weight: 500;
    }

    .filter-btn-active {
      background: var(--accent) !important;
      color: #000 !important;
      border-color: var(--accent) !important;
    }

    /* Make filters visible in light/dark mode */
    html:not(.dark-mode) #RoomsFilters .filter-btn {
      background: #ffffff;
      color: #000;
      border-color: rgba(0,0,0,0.05);
    }

    body.dark-mode #RoomsFilters .filter-btn {
      background: transparent;
      color: #E5F5F6;
      border-color: rgba(255,255,255,0.35);
    }

    /* Favorite button */
    .fav-btn {
      border-radius: 999px;
      padding: 4px 8px;
      font-size: .85rem;
    }

    .fav-btn i { color: #9ca3af; }
    .fav-btn.fav-active i { color: var(--accent); }

    /* Room summary text */
    #roomSummary {
      font-size: 0.9rem;
      color: var(--text-weak);
    }

    body.dark-mode #roomSummary {
      color: #cbd5f5;
    }

    /* Empty filter message styling - unified color with roomSummary */
    .empty-filter-message {
      font-size: 0.9rem;
      color: var(--text-weak);
    }

    body.dark-mode .empty-filter-message {
      color: #cbd5f5;
    }

    /* Dark-mode toggle button */
    #darkToggleBtn {
      border-radius: 999px;
    }

    /* 1. Badge in map section */
    body.dark-mode #mapSection .badge {
      color: #ffffff !important;
      background-color: rgba(255,255,255,0.1) !important;
    }
    body.dark-mode #mapSection .badge i {
      color: #ffffff !important;
    }

    /* 2. "Building", "Floor", "Search" labels */
    body.dark-mode #mapSection .form-label {
      color: #ffffff !important;
    }

    /* 3. Search input placeholder */
    body.dark-mode #searchInput::placeholder {
      color: #d1d5db !important;
    }

    /* 4. Subtitle under main header */
    body.dark-mode .main-header-title + .text-muted {
      color: #d1d5db !important;
    }

    /* 5. Legend chip text */
    body.dark-mode #mapSection .card-footer span {
      color: #ffffff !important;
    }

    /* 6. Room card location text */
    body.dark-mode .room-card .text-muted.small {
      color: #e5e7eb !important;
    }

    /* 7. Room name */
    body.dark-mode .room-card h6 {
      color: #ffffff !important;
    }

    /* 8. Room tags */
    body.dark-mode .room-tag {
      color: #ffffff !important;
      border-color: rgba(255,255,255,0.3) !important;
    }

    /* 9. Contact section labels */
    body.dark-mode #contactSection .form-label {
      color: #ffffff !important;
    }

    /* 10. Contact placeholders */
    body.dark-mode #contactSection input::placeholder,
    body.dark-mode #contactSection textarea::placeholder {
      color: #d1d5db !important;
    }

    /* 11. Contact section text */
    body.dark-mode #contactSection .card {
      color: #ffffff !important;
    }

    /* 12. Small building icon in rooms list */
    body.dark-mode .room-card i.fa-building,
    body.dark-mode .room-card i.fa-regular.fa-building {
      color: #ffffff !important;
    }

    /* User profile avatar */
    .profile-avatar {
      width: 28px;
      height: 28px;
      border-radius: 999px;
      background: var(--primary);
      color: #fff;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 0.75rem;
      font-weight: 700;
    }

    /* Multi-select containers */
    #universitySelectContainer,
    #buildingSelectContainer,
    #floorSelectContainer {
      background-color: var(--surface) !important;
    }

    body.dark-mode #universitySelectContainer,
    body.dark-mode #buildingSelectContainer,
    body.dark-mode #floorSelectContainer {
      background-color: var(--surface-strong) !important;
      border-color: var(--muted-strong) !important;
    }

    .form-check-sm {
      font-size: 0.875rem;
    }

    .form-check-input:checked {
      background-color: var(--primary);
      border-color: var(--primary);
    }

/* Dark mode: make "Please select ..." text more visible */
    body.dark-mode #buildingSelectContainer .text-muted,
    body.dark-mode #floorSelectContainer .text-muted {
      color: #e5e7eb !important; /* lighter grey for better contrast */
    }


    body.light-mode a[href*="users/home"] {
    color: #0f172a !important;              /* dark text */
    background-color: #e5e7eb !important;  /* light grey button */
    border-color: #94a3b8 !important;      /* visible border */
}


body.light-mode .bg-red-900\/20 {
    background-color: #fee2e2 !important;   /* light red box */
    border-color: #ef4444 !important;       /* real red border */
}

body.light-mode .text-red-400 {
    color: #dc2626 !important;              /* strong red title */
}

body.light-mode .text-red-300 {
    color: #b91c1c !important;              /* stronger delete text */
}

body.light-mode .bg-red-600\/20 {
    background-color: #fecaca !important;   /* delete button */
}

body.light-mode .border-red-600\/50 {
    border-color: #dc2626 !important;
}

  </style>
</head>
<body>
<div class="container-fluid">
  <div class="row g-0">
    <!-- Sidebar -->
    <nav class="col-md-3 col-lg-2 sidebar d-flex flex-column">
      <div>
        <div class="d-flex align-items-center justify-content-between mb-3">
          <div>
            <div class="sidebar-brand text-uppercase small text-white-50">UNA</div>
            <h5 class="mb-0 fw-bold"><i class="fa-solid fa-map-location-dot me-2"></i>Navigator</h5>
          </div>
        </div>

        <div class="mt-3 mb-2">
          <a href="#roomsSection" class="nav-link active">
            <i class="fa-solid fa-door-open me-2"></i> Rooms
          </a>
          <a href="#contactSection" class="nav-link">
            <i class="fa-solid fa-envelope me-2"></i> Contact
          </a>
        </div>

        <hr>

        <!-- Filter buttons -->
        <div id="RoomsFilters">
          <h6 class="fw-bold mb-2 text-uppercase small text-white-50">Room Filters</h6>
          <button class="btn btn-sm filter-btn w-100 mb-1" type="button" data-filter="all">
            <i class="fa-solid fa-list me-2"></i> All
          </button>
          <!-- Room type buttons will be dynamically generated here -->
          <div id="roomTypeFilters"></div>
          <button class="btn btn-sm filter-btn w-100" type="button" data-filter="free">
            <i class="fa-solid fa-circle-check me-2"></i> Free now
          </button>
          <button class="btn btn-sm filter-btn w-100" type="button" data-filter="favorites">
            <i class="fa-solid fa-star me-2"></i> Favorites
          </button>
        </div>
      </div>

      <div class="mt-auto pt-3 small text-white-50">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <span>Dark mode</span>
          <button id="darkToggleBtn" class="btn btn-outline-light btn-sm">
            <i class="fa-solid fa-moon"></i>
          </button>
        </div>
        <div>© 2025 UNA</div>
      </div>
    </nav>

    <!-- Main content -->
    <main class="col-md-9 col-lg-10 p-4">
      <!-- Header -->
      <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <div>
          <h2 class="main-header-title mb-0">Universities Navigation Application</h2>
          <div class="text-muted small">Find buildings, switch floors, and locate rooms fast.</div>
        </div>

        <!-- User profile button (top-right) -->
        <div class="mt-3 mt-md-0">
          <div class="dropdown">
            <button
              class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-2"
              type="button"
              id="profileMenuButton"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              <span class="profile-avatar">{{ $user ? strtoupper(substr($user->username_una, 0, 1)) : 'U' }}</span>
              <span class="d-none d-sm-inline">Profile</span>
              <span class="ms-1"><i class="fa-solid fa-caret-down"></i></span>
            </button>

            <!-- PROFILE DROPDOWN WITH TABS -->
            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="profileMenuButton">
    <!-- Header with user info -->
    <li class="dropdown-header small">
        <div class="fw-semibold">{{ $user ? $user->username_una : 'My account' }}</div>
        <div class="text-muted">{{ $user ? $user->email_una : 'placeholder@example.com' }}</div>
    </li>

    <li><hr class="dropdown-divider"></li>

    <!-- My Profile: links to profile page -->
    <li>
        <a class="dropdown-item" href="{{ url('/users/profile') }}">
            <i class="fa-solid fa-user me-2"></i>
            My Profile
        </a>
    </li>

    <li><hr class="dropdown-divider"></li>

    <!-- Logout -->
    <li>
        <a class="dropdown-item text-danger" href="{{ url('/intro') }}">
            <i class="fa-solid fa-right-from-bracket me-2"></i>
            Logout
        </a>
    </li>
</ul>
          </div>
        </div>
      </div>

      <!-- Filters -->
      <section id="mapSection" class="mb-4">
        <div class="card mb-3">
          <div class="card-body">
            <div class="row g-2 align-items-start">
              <div class="col-sm-4 col-md-3">
                <label class="form-label mb-1 small text-muted">University</label>
                <div id="universitySelectContainer" class="border rounded p-2" style="max-height: 120px; overflow-y: auto; background-color: var(--surface);">
                  <div class="form-check form-check-sm">
                    <input class="form-check-input" type="checkbox" id="university-all" checked>
                    <label class="form-check-label small" for="university-all">All Universities</label>
                  </div>
                </div>
              </div>
              <div class="col-sm-4 col-md-3">
                <label class="form-label mb-1 small text-muted">Building</label>
                <div id="buildingSelectContainer" class="border rounded p-2" style="max-height: 120px; overflow-y: auto; background-color: var(--surface);">
                  <div class="form-check form-check-sm">
                    <input class="form-check-input" type="checkbox" id="building-all" checked>
                    <label class="form-check-label small" for="building-all">All Buildings</label>
                  </div>
                </div>
              </div>
              <div class="col-sm-4 col-md-2">
                <label class="form-label mb-1 small text-muted">Floor</label>
                <div id="floorSelectContainer" class="border rounded p-2" style="max-height: 120px; overflow-y: auto; background-color: var(--surface);">
                  <div class="form-check form-check-sm">
                    <input class="form-check-input" type="checkbox" id="floor-all" checked>
                    <label class="form-check-label small" for="floor-all">All Floors</label>
                  </div>
                </div>
              </div>
              <div class="col-sm-5 col-md-3 mt-2 mt-sm-0">
                <label class="form-label mb-1 small text-muted">Search</label>
                <div class="input-group input-group-sm">
                  <input id="searchInput" type="text" class="form-control" placeholder="Room or type (e.g., A101, lecture)…">
                  <button id="clearSearch" class="btn btn-outline-secondary" type="button">
                    <i class="fa-solid fa-eraser"></i>
                  </button>
                </div>
              </div>
              <div class="col-md-2 mt-2 mt-md-4 text-md-end">
                <!-- Floor & building badge removed -->
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Rooms -->
      <section id="roomsSection" class="mb-4">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <h4 class="mb-0 fw-bold"><i class="fa-solid fa-door-open me-2"></i>Rooms</h4>
        </div>
        <div id="roomSummary" class="mb-2"></div>
        <div id="roomGrid" class="row g-2"></div>
      </section>

      <!-- Contact -->
      <section id="contactSection" class="mb-3">
        <h4 class="fw-bold mb-3"><i class="fa-solid fa-envelope me-2"></i>Contact</h4>
        <div class="card">
          <div class="card-body">
            <p class="mb-0">
              <i class="fa-solid fa-envelope me-2"></i>
              <a href="mailto:xxxx@gmail.com">xxxx@gmail.com</a>
            </p>
          </div>
        </div>
      </section>
    </main>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
  /* ========== State & Data ========== */
  const STORAGE_DARK = 'una-dark';
  const STORAGE_FAVES = 'una-favorites';

  // Dynamic data from backend
  let DATA = {
    universities: [],
    buildings: [],
    floors: [],
    rooms: [],
    roomTypes: []
  };

  const TYPE_COLOR = {
    lecture: '#a3c4f3',
    lab: '#b9fbc0',
    admin: '#ffd6a5',
    service: '#e0e0e0'
  };

  const qs = s => document.querySelector(s);
  const qsa = s => [...document.querySelectorAll(s)];

  const universitySelectContainer = qs('#universitySelectContainer');
  const buildingSelectContainer = qs('#buildingSelectContainer');
  const floorSelectContainer = qs('#floorSelectContainer');
  const roomGrid = qs('#roomGrid');
  const roomSummary = qs('#roomSummary');
  const mapTitle = qs('#mapTitle');
  const floorMeta = qs('#floorMeta');
  const searchInput = qs('#searchInput');
  const darkToggleBtn = qs('#darkToggleBtn');

  let current = { 
    universityIds: [], 
    buildingIds: [], 
    floorNumbers: [], 
    filter: 'all', 
    query: '' 
  };
  let favorites = new Set();

  // API Functions
  async function fetchUniversities() {
    try {
      const response = await fetch('/api/public/universities');
      const data = await response.json();
      DATA.universities = data;
      return data;
    } catch (error) {
      console.error('Error fetching universities:', error);
      return [];
    }
  }

  async function fetchBuildingsByUniversity(universityId) {
    try {
      const response = await fetch(`/api/public/buildings/university/${universityId}`);
      const data = await response.json();
      DATA.buildings = data;
      return data;
    } catch (error) {
      console.error('Error fetching buildings:', error);
      return [];
    }
  }

  async function fetchFloorsByBuilding(buildingId) {
    try {
      const response = await fetch(`/api/public/buildings/${buildingId}/floors`);
      const data = await response.json();
      DATA.floors = data;
      return data;
    } catch (error) {
      console.error('Error fetching floors:', error);
      return [];
    }
  }

  async function fetchAllFloors() {
    try {
      const response = await fetch('/api/public/floors');
      const data = await response.json();
      DATA.floors = data;
      return data;
    } catch (error) {
      console.error('Error fetching all floors:', error);
      return [];
    }
  }

  async function fetchRoomTypes() {
    try {
      const response = await fetch('/api/public/room-types');
      const data = await response.json();
      DATA.roomTypes = data;
      return data;
    } catch (error) {
      console.error('Error fetching room types:', error);
      return [];
    }
  }

  // Icon mapping for room types
  function getRoomTypeIcon(roomTypeName) {
    const iconMap = {
      'Seminar': 'fa-person-chalkboard',
      'Auditorium': 'fa-users',
      'Library': 'fa-book',
      'Laboratory': 'fa-flask',
      'Office': 'fa-briefcase',
      'Studio': 'fa-palette',
      'Others': 'fa-cube',
      'Lecture': 'fa-person-chalkboard',
      'Lab': 'fa-flask',
      'Admin': 'fa-briefcase',
      'Service': 'fa-mug-saucer'
    };
    
    // Try exact match first
    if (iconMap[roomTypeName]) {
      return iconMap[roomTypeName];
    }
    
    // Try case-insensitive match
    const lowerName = roomTypeName.toLowerCase();
    for (const [key, icon] of Object.entries(iconMap)) {
      if (key.toLowerCase() === lowerName) {
        return icon;
      }
    }
    
    // Default icon
    return 'fa-door-open';
  }

  // Populate room type filter buttons
  async function populateRoomTypeFilters() {
    const roomTypes = await fetchRoomTypes();
    const container = qs('#roomTypeFilters');
    
    if (!container || roomTypes.length === 0) {
      return;
    }
    
    const buttons = roomTypes.map(rt => {
      const icon = getRoomTypeIcon(rt.room_type_una);
      const filterValue = `type_${rt.id_room_type_una}`;
      return `
        <button class="btn btn-sm filter-btn w-100" type="button" data-filter="${filterValue}" data-room-type-id="${rt.id_room_type_una}">
          <i class="fa-solid ${icon} me-2"></i> ${rt.room_type_una}
        </button>
      `;
    }).join('');
    
    container.innerHTML = buttons;
    
    // Add event listeners to new buttons
    container.querySelectorAll('.filter-btn').forEach(btn => {
      btn.addEventListener('click', async () => {
        current.filter = btn.dataset.filter;
        await renderAll();
        updateFilterButtons();
      });
    });
  }

  async function fetchRooms(filters = {}) {
    try {
      const params = new URLSearchParams();
      
      if (filters.university_ids && filters.university_ids.length > 0) {
        filters.university_ids.forEach(id => params.append('university_id[]', id));
      }
      if (filters.building_ids && filters.building_ids.length > 0) {
        filters.building_ids.forEach(id => params.append('building_id[]', id));
      }
      if (filters.floor_numbers && filters.floor_numbers.length > 0) {
        filters.floor_numbers.forEach(num => params.append('floor_number[]', num));
      }
      // 将房间类型与可用状态也传给后端 RoomController::search
      if (filters.room_type_id) {
        params.append('room_type_id', filters.room_type_id);
      }
      if (filters.availability_id) {
        params.append('availability_id', filters.availability_id);
      }
      if (filters.search_query) params.append('search_query', filters.search_query);
      
      const response = await fetch(`/api/public/rooms/search?${params.toString()}`);
      const data = await response.json();
      DATA.rooms = data;
      return data;
    } catch (error) {
      console.error('Error fetching rooms:', error);
      return [];
    }
  }

  // Restore dark mode
  (function restoreDark() {
    if (localStorage.getItem(STORAGE_DARK) === '1') {
      document.body.classList.add('dark-mode');
      document.documentElement.classList.add('dark-mode');
    }
  })();

  // Restore favorites
  (function restoreFavs() {
    try {
      const raw = localStorage.getItem(STORAGE_FAVES);
      if (raw) {
        const arr = JSON.parse(raw);
        if (Array.isArray(arr)) favorites = new Set(arr);
      }
    } catch(e) {
      favorites = new Set();
    }
  })();

  function persistFavorites() {
    try {
      localStorage.setItem(STORAGE_FAVES, JSON.stringify([...favorites]));
    } catch(e){}
  }

  function getCurrentContext() {
    const selectedUniversities = DATA.universities.filter(u => current.universityIds.includes(String(u.id_university_una)));
    const selectedBuildings = DATA.buildings.filter(b => current.buildingIds.includes(String(b.id_building_una)));
    const selectedFloors = DATA.floors.filter(f => current.floorNumbers.includes(String(f.floor_number)));
    
    return { 
      universities: selectedUniversities,
      buildings: selectedBuildings,
      floors: selectedFloors,
      rooms: DATA.rooms 
    };
  }

  // Populate selects
  async function populateUniversitySelect() {
    const universities = await fetchUniversities();
    const allCheckbox = `<div class="form-check form-check-sm mb-1">
      <input class="form-check-input" type="checkbox" id="university-all" ${current.universityIds.length === 0 ? 'checked' : ''}>
      <label class="form-check-label small" for="university-all">All Universities</label>
    </div>`;
    
    const universityCheckboxes = universities.map(u => `
      <div class="form-check form-check-sm mb-1">
        <input class="form-check-input university-checkbox" type="checkbox" id="university-${u.id_university_una}" 
               value="${u.id_university_una}" ${current.universityIds.length === 0 || current.universityIds.includes(String(u.id_university_una)) ? 'checked' : ''}>
        <label class="form-check-label small" for="university-${u.id_university_una}">${u.university_name_una}</label>
      </div>
    `).join('');
    
    universitySelectContainer.innerHTML = allCheckbox + universityCheckboxes;
    
    // Add event listeners
    qs('#university-all').addEventListener('change', (e) => {
      const checked = e.target.checked;
      qsa('.university-checkbox').forEach(cb => cb.checked = checked);
      updateUniversitySelection();
    });
    
    qsa('.university-checkbox').forEach(cb => {
      cb.addEventListener('change', () => {
        const allChecked = [...qsa('.university-checkbox')].every(cb => cb.checked);
        qs('#university-all').checked = allChecked;
        updateUniversitySelection();
      });
    });
    
    // Auto-select all if available
    if (universities.length > 0 && current.universityIds.length === 0) {
      current.universityIds = universities.map(u => String(u.id_university_una));
      await populateBuildingSelect();
    }
  }
  
  function updateUniversitySelection() {
    const checkedBoxes = [...qsa('.university-checkbox:checked')];
    current.universityIds = checkedBoxes.map(cb => cb.value);
    
    // 当取消选择所有大学时，自动清空所有建筑选择
    if (current.universityIds.length === 0) {
      current.buildingIds = [];
    }
    
    populateBuildingSelect();
    // 楼层选择器独立，不需要在这里更新
  }

  async function populateBuildingSelect() {
    if (current.universityIds.length === 0) {
      buildingSelectContainer.innerHTML = '<div class="form-check form-check-sm"><label class="form-check-label small text-muted">Please select university first</label></div>';
      current.buildingIds = [];
      await renderAll();
      return;
    }
    
    // Fetch buildings for all selected universities
    const allBuildings = [];
    for (const uniId of current.universityIds) {
      const buildings = await fetchBuildingsByUniversity(uniId);
      allBuildings.push(...buildings);
    }
    
    // Remove duplicates
    const uniqueBuildings = Array.from(new Map(allBuildings.map(b => [b.id_building_una, b])).values());
    
    const allCheckbox = `<div class="form-check form-check-sm mb-1">
      <input class="form-check-input" type="checkbox" id="building-all" ${current.buildingIds.length === 0 ? 'checked' : ''}>
      <label class="form-check-label small" for="building-all">All Buildings</label>
    </div>`;
    
    const buildingCheckboxes = uniqueBuildings.map(b => `
      <div class="form-check form-check-sm mb-1">
        <input class="form-check-input building-checkbox" type="checkbox" id="building-${b.id_building_una}" 
               value="${b.id_building_una}" ${current.buildingIds.length === 0 || current.buildingIds.includes(String(b.id_building_una)) ? 'checked' : ''}>
        <label class="form-check-label small" for="building-${b.id_building_una}">
          ${(b.building_name_una || b.building_code_una) + (b.university && b.university.university_name_una ? ' (' + b.university.university_name_una + ')' : '')}
        </label>
      </div>
    `).join('');
    
    buildingSelectContainer.innerHTML = allCheckbox + buildingCheckboxes;
    
    // Add event listeners
    qs('#building-all').addEventListener('change', (e) => {
      const checked = e.target.checked;
      qsa('.building-checkbox').forEach(cb => cb.checked = checked);
      updateBuildingSelection();
    });
    
    qsa('.building-checkbox').forEach(cb => {
      cb.addEventListener('change', () => {
        const allChecked = [...qsa('.building-checkbox')].every(cb => cb.checked);
        qs('#building-all').checked = allChecked;
        updateBuildingSelection();
      });
    });
    
    // Auto-select all if available
    if (uniqueBuildings.length > 0 && current.buildingIds.length === 0) {
      current.buildingIds = uniqueBuildings.map(b => String(b.id_building_una));
      await renderAll();
    }
  }
  
  function updateBuildingSelection() {
    const checkedBoxes = [...qsa('.building-checkbox:checked')];
    current.buildingIds = checkedBoxes.map(cb => cb.value);
    // 楼层选择器独立，不需要在这里更新
    renderAll();
  }

  async function populateFloorSelect() {
    // 楼层选择器独立，获取所有楼层（不依赖于建筑选择）
    const allFloors = await fetchAllFloors();
    
    if (allFloors.length === 0) {
      floorSelectContainer.innerHTML = '<div class="form-check form-check-sm"><label class="form-check-label small text-muted">No floors available</label></div>';
      current.floorNumbers = [];
      await renderAll();
      return;
    }
    
    // 按楼层号排序
    allFloors.sort((a, b) => a.floor_number - b.floor_number);
    
    const allCheckbox = `<div class="form-check form-check-sm mb-1">
      <input class="form-check-input" type="checkbox" id="floor-all" ${current.floorNumbers.length === 0 ? 'checked' : ''}>
      <label class="form-check-label small" for="floor-all">All Floors</label>
    </div>`;
    
    const floorCheckboxes = allFloors.map(f => `
      <div class="form-check form-check-sm mb-1">
        <input class="form-check-input floor-checkbox" type="checkbox" id="floor-${f.floor_number}" 
               value="${f.floor_number}" ${current.floorNumbers.length === 0 || current.floorNumbers.includes(String(f.floor_number)) ? 'checked' : ''}>
        <label class="form-check-label small" for="floor-${f.floor_number}">${f.floor_label}</label>
      </div>
    `).join('');
    
    floorSelectContainer.innerHTML = allCheckbox + floorCheckboxes;
    
    // Add event listeners
    qs('#floor-all').addEventListener('change', (e) => {
      const checked = e.target.checked;
      qsa('.floor-checkbox').forEach(cb => cb.checked = checked);
      updateFloorSelection();
    });
    
    qsa('.floor-checkbox').forEach(cb => {
      cb.addEventListener('change', () => {
        const allChecked = [...qsa('.floor-checkbox')].every(cb => cb.checked);
        qs('#floor-all').checked = allChecked;
        updateFloorSelection();
      });
    });
    
    // Auto-select all if available
    if (allFloors.length > 0 && current.floorNumbers.length === 0) {
      current.floorNumbers = allFloors.map(f => String(f.floor_number));
      await renderAll();
    }
  }
  
  function updateFloorSelection() {
    const checkedBoxes = [...qsa('.floor-checkbox:checked')];
    current.floorNumbers = checkedBoxes.map(cb => cb.value);
    renderAll();
  }

  // Rendering
  async function renderAll() {
    // 如果所有筛选器都为空，不显示任何房间
    if (current.universityIds.length === 0 && current.buildingIds.length === 0 && current.floorNumbers.length === 0) {
      DATA.rooms = [];
      renderRooms();
      return;
    }

    // 如果 Building 或 Floor 中任意一个全部取消选择（长度为 0），则不显示任何房间
    // 要求：当 home page 的 floor 或 buildings 全部取消选择时，下方不显示任何房间
    if (current.buildingIds.length === 0 || current.floorNumbers.length === 0) {
      DATA.rooms = [];
      renderRooms();
      return;
    }

    // 根据当前 sidebar filter 计算要传给后端的 room_type_id / availability_id
    let roomTypeId = null;
    let availabilityId = null;
    
    if (current.filter.startsWith('type_')) {
      // Extract room type ID from filter (e.g., "type_1" -> 1)
      roomTypeId = parseInt(current.filter.replace('type_', ''));
    } else if (current.filter === 'free') {
      availabilityId = 1; // 假设 availability_una 表里 1 = Free
    }
    // all / favorites 不做后端类型过滤

    // Fetch rooms with current filters
    await fetchRooms({
      university_ids: current.universityIds,
      building_ids: current.buildingIds,
      floor_numbers: current.floorNumbers,
      search_query: current.query,
      room_type_id: roomTypeId,
      availability_id: availabilityId,
    });
    
    renderRooms();
  }

  function getRoomType(roomTypeId) {
    // Get room type name from DATA.roomTypes
    const roomType = DATA.roomTypes.find(rt => rt.id_room_type_una === roomTypeId);
    if (roomType) {
      return roomType.room_type_una.toLowerCase();
    }
    // Fallback for backward compatibility
    const typeMap = {
      1: 'seminar',
      2: 'auditorium',
      3: 'library',
      4: 'laboratory',
      5: 'office',
      6: 'studio',
      7: 'others'
    };
    return typeMap[roomTypeId] || 'others';
  }

  function isRoomFree(availabilityId) {
    // Map availability IDs to free status
    // You may need to adjust these based on your actual availability_una table
    // Assuming 1 = Free, 2 = Occupied
    return availabilityId === 1;
  }

  function filteredRooms(rooms) {
    const q = (current.query || '').trim().toLowerCase();
    return rooms.filter(r => {
      const roomType = getRoomType(r.id_room_type_una);
      const isFree = isRoomFree(r.id_availability_una);
      const roomId = r.room_number_una || '';
      const roomName = r.room_name_una || '';
      
      const qMatch = !q || [roomId, roomName, roomType].join(' ').toLowerCase().includes(q);
      // 类型 / Free 已经交给后端 search 接口处理，这里只对 favorites 做前端过滤
      const typeMatch =
        (current.filter !== 'favorites') ||
        (current.filter === 'favorites' && favorites.has(roomId));
      return qMatch && typeMatch;
    });
  }

  function renderRooms() {
    const { buildings, floors, rooms } = getCurrentContext();
    const displayRooms = filteredRooms(rooms);
    const count = displayRooms.length;

    // 检查是否所有筛选器都为空
    const allFiltersEmpty = current.universityIds.length === 0 && 
                           current.buildingIds.length === 0 && 
                           current.floorNumbers.length === 0;

    if (allFiltersEmpty) {
      // 当没有选择任何过滤器时，不显示额外提示文案，仅保持房间区域为空
      roomSummary.textContent = '';
      roomGrid.innerHTML = '';
      return;
    }

    const buildingNames = buildings.length > 0 
      ? buildings.map(b => b.building_name_una || b.building_code_una).join(', ')
      : '—';
    const floorLabels = floors.length > 0 
      ? floors.map(f => f.floor_label).join(', ')
      : '—';

    if (count) {
      roomSummary.textContent = `${count} room${count !== 1 ? 's' : ''} found.`;
    } else {
      roomSummary.textContent = `No rooms found for the current filters.`;
      roomGrid.innerHTML = `<p class="text-muted">Try clearing search, changing room type filter, or switching building/floor.</p>`;
      return;
    }

    roomGrid.innerHTML = displayRooms.map(r => {
      const roomType = getRoomType(r.id_room_type_una);
      const isFree = isRoomFree(r.id_availability_una);
      const roomId = r.room_number_una || '';
      const roomName = r.room_name_una || 'Unnamed';
      
      return `
      <div class="col-md-4">
        <div class="card room-card h-100">
          <div class="card-body d-flex flex-column p-3">
            <div class="d-flex justify-content-between align-items-start mb-1">
              <span class="room-id-badge">${roomId}</span>
              ${favorites.has(roomId) ? '<span class="room-tag"><i class="fa-solid fa-star me-1"></i>Favorite</span>' : ''}
            </div>
            <h6 class="mb-1 fw-bold">${roomName}</h6>
            <div class="text-muted small mb-1">
              <i class="fa-solid fa-school me-1"></i>${r.university?.university_name_una || '—'}
            </div>
            <div class="text-muted small mb-1">
              <i class="fa-regular fa-building me-1"></i>${r.building?.building_name_una || r.building?.building_code_una || '—'} · ${r.floor_number_una !== null && r.floor_number_una !== undefined ? 'Floor ' + r.floor_number_una : '—'}
            </div>
            <div class="mb-1 d-flex flex-wrap gap-1">
              <span class="room-tag"><i class="fa-solid fa-tag me-1"></i>${roomType}</span>
              ${isFree ? '<span class="room-tag"><i class="fa-solid fa-circle-check me-1"></i>Free now</span>' : ''}
            </div>
            <div class="mb-1 small ${isFree ? 'status-ok' : 'status-busy'}">
              ${isFree ? 'Available' : 'Occupied'}
            </div>
            ${r.directions_una ? `
            <div class="mb-1">
              <div class="text-muted small mb-0"><i class="fa-solid fa-location-dot me-1"></i>Room Direction:</div>
              <div class="small">${r.directions_una}</div>
            </div>
            ` : ''}
            <div class="mt-auto d-flex justify-content-end pt-1">
              <button class="btn btn-sm btn-outline-warning fav-btn ${favorites.has(roomId)?'fav-active':''}"
                type="button"
                onclick="toggleFavorite('${roomId}')"
                aria-label="Toggle favorite for ${roomId} ${roomName}">
                <i class="fa-solid fa-star"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    `;
    }).join('');
  }


  // Interactions - removed old select event listeners, now handled in populate functions

  searchInput.addEventListener('input', async (e) => {
    current.query = e.target.value;
    await renderAll();
  });

  qs('#clearSearch').addEventListener('click', async () => {
    current.query = '';
    searchInput.value = '';
    await renderAll();
  });

  // Filters (sidebar)
  function updateFilterButtons() {
    qsa('#RoomsFilters [data-filter]').forEach(btn => {
      const active = btn.dataset.filter === current.filter;
      btn.classList.toggle('filter-btn-active', active);
    });
  }

  qsa('#RoomsFilters [data-filter]').forEach(btn => {
    btn.addEventListener('click', async () => {
      current.filter = btn.dataset.filter;
      await renderAll();
      updateFilterButtons();
    });
  });

  function highlightRoomCard(id) {
    const el = qs(`#card-${CSS.escape(id)}`);
    // placeholder if you add IDs later
  }

  function zoomTo(id) {
    // Map removed, function kept for compatibility
  }

  function toggleFavorite(id) {
    if (favorites.has(id)) favorites.delete(id);
    else favorites.add(id);
    persistFavorites();
    renderAll();
  }

  function openRoomPage(id) {
    window.location.href = 'room.html?room=' + encodeURIComponent(id);
  }

  // Dark mode toggle
  darkToggleBtn.addEventListener('click', () => {
    document.body.classList.toggle('dark-mode');
    document.documentElement.classList.toggle('dark-mode');
    localStorage.setItem(STORAGE_DARK, document.body.classList.contains('dark-mode') ? '1' : '0');
  });

  // Initial bootstrap
  async function initializeApp() {
    await populateUniversitySelect();
    await populateFloorSelect(); // 独立初始化楼层选择器
    await populateRoomTypeFilters(); // 动态生成房间类型按钮
    updateFilterButtons();
  }

  // Start the app when DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeApp);
  } else {
    initializeApp();
  }
</script>
</body>
</html>
