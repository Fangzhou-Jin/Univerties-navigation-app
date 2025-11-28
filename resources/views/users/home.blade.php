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
          <a href="#mapSection" class="nav-link active">
            <i class="fa-solid fa-location-dot me-2"></i> Map
          </a>
          <a href="#roomsSection" class="nav-link">
            <i class="fa-solid fa-door-open me-2"></i> Rooms
          </a>
          <a href="#accessibilitySection" class="nav-link">
            <i class="fa-solid fa-wheelchair-move me-2"></i> Accessibility
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
          <button class="btn btn-sm filter-btn w-100" type="button" data-filter="lecture">
            <i class="fa-solid fa-person-chalkboard me-2"></i> Lecture
          </button>
          <button class="btn btn-sm filter-btn w-100" type="button" data-filter="lab">
            <i class="fa-solid fa-flask me-2"></i> Lab
          </button>
          <button class="btn btn-sm filter-btn w-100" type="button" data-filter="admin">
            <i class="fa-solid fa-briefcase me-2"></i> Admin
          </button>
          <button class="btn btn-sm filter-btn w-100" type="button" data-filter="service">
            <i class="fa-solid fa-mug-saucer me-2"></i> Service
          </button>
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
              <span class="profile-avatar">U</span>
              <span class="d-none d-sm-inline">Profile</span>
              <span class="ms-1"><i class="fa-solid fa-caret-down"></i></span>
            </button>

            <!-- PROFILE DROPDOWN WITH TABS -->
            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="profileMenuButton">
    <!-- Header with user info -->
    <li class="dropdown-header small">
        <div class="fw-semibold">My account</div>
        <div class="text-muted">placeholder@example.com</div>
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

      <!-- Map + Controls -->
      <section id="mapSection" class="mb-4">
        <div class="card mb-3">
          <div class="card-body">
            <div class="row g-2 align-items-center">
              <div class="col-sm-4 col-md-2">
                <label class="form-label mb-1 small text-muted">University</label>
                <select id="universitySelect" class="form-select form-select-sm"></select>
              </div>
              <div class="col-sm-4 col-md-3">
                <label class="form-label mb-1 small text-muted">Building</label>
                <select id="buildingSelect" class="form-select form-select-sm"></select>
              </div>
              <div class="col-sm-3 col-md-2">
                <label class="form-label mb-1 small text-muted">Floor</label>
                <select id="floorSelect" class="form-select form-select-sm"></select>
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
                <span class="badge rounded-pill text-bg-light">
                  <i class="fa-solid fa-building me-1"></i>
                  <span id="mapTitle">—</span>,
                  <span id="floorMeta">Floor —</span>
                </span>
              </div>
            </div>
          </div>
        </div>

        <div id="mapContainer" class="card mb-2">
          <div class="card-body p-0">
            <svg id="map" viewBox="0 0 1000 560" role="img" aria-label="Floor plan"></svg>
          </div>
          <div class="card-footer small">
            <span class="me-3"><span class="badge" style="background:#a3c4f3;">&nbsp;</span> Lecture</span>
            <span class="me-3"><span class="badge" style="background:#b9fbc0;">&nbsp;</span> Lab</span>
            <span class="me-3"><span class="badge" style="background:#ffd6a5;">&nbsp;</span> Admin</span>
            <span class="me-3"><span class="badge" style="background:#e0e0e0;">&nbsp;</span> Service</span>
            <span class="me-3"><span class="badge" style="background:#bbf7d0;">&nbsp;</span> Free now</span>
          </div>
        </div>
        <div id="liveRegion" class="visually-hidden" aria-live="polite"></div>
      </section>

      <!-- Rooms -->
      <section id="roomsSection" class="mb-4">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <h4 class="mb-0 fw-bold"><i class="fa-solid fa-door-open me-2"></i>Rooms</h4>
        </div>
        <div id="roomSummary" class="mb-2"></div>
        <div id="roomGrid" class="row g-3"></div>
      </section>

      <!-- Accessibility -->
      <section id="accessibilitySection" class="mb-4">
        <h4 class="fw-bold mb-3"><i class="fa-solid fa-wheelchair-move me-2"></i>Accessibility</h4>
        <div class="row g-3">
          <div class="col-md-4">
            <div class="card h-100">
              <div class="card-body">
                <h6 class="fw-bold mb-2"><i class="fa-solid fa-elevator me-2"></i>Elevators</h6>
                <p id="elevatorInfo" class="mb-0">—</p>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card h-100">
              <div class="card-body">
                <h6 class="fw-bold mb-2"><i class="fa-solid fa-stairs me-2"></i>Stairs & ramps</h6>
                <p id="stairsInfo" class="mb-0">—</p>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card h-100">
              <div class="card-body">
                <h6 class="fw-bold mb-2"><i class="fa-solid fa-restroom me-2"></i>Accessible restrooms</h6>
                <p id="restroomInfo" class="mb-0">—</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Contact -->
      <section id="contactSection" class="mb-3">
        <h4 class="fw-bold mb-3"><i class="fa-solid fa-envelope me-2"></i>Contact campus support</h4>
        <div class="card">
          <div class="card-body">
            <form onsubmit="event.preventDefault(); alert('This is a static demo. Connect this form to your backend or PHP mail.');">
              <div class="mb-3">
                <label class="form-label">Subject</label>
                <input type="text" class="form-control" placeholder="Subject">
              </div>
              <div class="mb-3">
                <label class="form-label">Message</label>
                <textarea class="form-control" rows="4" placeholder="Describe your issue or question"></textarea>
              </div>
              <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" placeholder="you@example.edu">
              </div>
              <button type="submit" class="btn btn-primary" style="background:var(--accent); border-color:var(--accent); color:#000;">
                <i class="fa-solid fa-paper-plane me-1"></i>Send
              </button>
            </form>
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
    rooms: []
  };

  const TYPE_COLOR = {
    lecture: '#a3c4f3',
    lab: '#b9fbc0',
    admin: '#ffd6a5',
    service: '#e0e0e0'
  };

  const qs = s => document.querySelector(s);
  const qsa = s => [...document.querySelectorAll(s)];

  const universitySelect = qs('#universitySelect');
  const buildingSelect = qs('#buildingSelect');
  const floorSelect = qs('#floorSelect');
  const roomGrid = qs('#roomGrid');
  const roomSummary = qs('#roomSummary');
  const mapSvg = qs('#map');
  const mapTitle = qs('#mapTitle');
  const floorMeta = qs('#floorMeta');
  const searchInput = qs('#searchInput');
  const liveRegion = qs('#liveRegion');
  const darkToggleBtn = qs('#darkToggleBtn');

  let current = { 
    universityId: null, 
    buildingId: null, 
    floorNumber: null, 
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

  async function fetchRooms(filters = {}) {
    try {
      const params = new URLSearchParams();
      
      if (filters.university_id) params.append('university_id', filters.university_id);
      if (filters.building_id) params.append('building_id', filters.building_id);
      if (filters.floor_number !== null && filters.floor_number !== undefined) {
        params.append('floor_number', filters.floor_number);
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
    const currentUniversity = DATA.universities.find(u => u.id_university_una == current.universityId);
    const currentBuilding = DATA.buildings.find(b => b.id_building_una == current.buildingId);
    const currentFloor = DATA.floors.find(f => f.floor_number == current.floorNumber);
    
    return { 
      university: currentUniversity, 
      building: currentBuilding, 
      floor: currentFloor,
      rooms: DATA.rooms 
    };
  }

  // Populate selects
  async function populateUniversitySelect() {
    const universities = await fetchUniversities();
    universitySelect.innerHTML = '<option value="">选择大学...</option>' + 
      universities.map(u => `<option value="${u.id_university_una}">${u.university_name_una}</option>`).join('');
    
    // Auto-select first university if available
    if (universities.length > 0) {
      current.universityId = universities[0].id_university_una;
      universitySelect.value = current.universityId;
      await populateBuildingSelect();
    }
  }

  async function populateBuildingSelect() {
    if (!current.universityId) {
      buildingSelect.innerHTML = '<option value="">请先选择大学</option>';
      return;
    }
    
    const buildings = await fetchBuildingsByUniversity(current.universityId);
    buildingSelect.innerHTML = '<option value="">选择建筑...</option>' + 
      buildings.map(b => `<option value="${b.id_building_una}">${b.building_name_una || b.building_code_una}</option>`).join('');
    
    // Auto-select first building if available
    if (buildings.length > 0) {
      current.buildingId = buildings[0].id_building_una;
      buildingSelect.value = current.buildingId;
      await populateFloorSelect();
    }
  }

  async function populateFloorSelect() {
    if (!current.buildingId) {
      floorSelect.innerHTML = '<option value="">请先选择建筑</option>';
      return;
    }
    
    const floors = await fetchFloorsByBuilding(current.buildingId);
    floorSelect.innerHTML = '<option value="">选择楼层...</option>' + 
      floors.map(f => `<option value="${f.floor_number}">${f.floor_label}</option>`).join('');
    
    // Auto-select first floor if available
    if (floors.length > 0) {
      current.floorNumber = floors[0].floor_number;
      floorSelect.value = current.floorNumber;
      await renderAll();
    }
  }

  // Rendering
  async function renderAll() {
    // Fetch rooms with current filters
    await fetchRooms({
      university_id: current.universityId,
      building_id: current.buildingId,
      floor_number: current.floorNumber,
      search_query: current.query
    });
    
    renderMap();
    renderRooms();
    renderAccessibility();
  }

  function getRoomType(roomTypeId) {
    // Map room type IDs to type names
    // You may need to adjust these based on your actual room_types_una table
    const typeMap = {
      1: 'lecture',
      2: 'lab',
      3: 'admin',
      4: 'service'
    };
    return typeMap[roomTypeId] || 'service';
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
      const typeMatch =
        (current.filter === 'all') ||
        (current.filter === 'free' ? isFree :
          current.filter === 'favorites' ? favorites.has(roomId) :
          roomType === current.filter);
      return qMatch && typeMatch;
    });
  }

  function renderMap() {
    const { building, floor, rooms } = getCurrentContext();
    const displayRooms = filteredRooms(rooms);

    if (building) {
      mapTitle.textContent = building.building_name_una || building.building_code_una || '—';
    }
    if (floor) {
      floorMeta.textContent = floor.floor_label || '—';
    }

    const BOX_W = 260;
    const BOX_H = 140;
    const GAP   = 24;
    const PADDING = 40;
    const MAX_COLS = 3;

    const colsUsed = Math.min(MAX_COLS, Math.max(displayRooms.length, 1));
    const rows = Math.max(1, Math.ceil(displayRooms.length / colsUsed));

    const totalW = PADDING * 2 + colsUsed * BOX_W + (colsUsed - 1) * GAP;
    const totalH = PADDING * 2 + rows * BOX_H + (rows - 1) * GAP;

    mapSvg.setAttribute('viewBox', `0 0 ${totalW} ${totalH}`);
    mapSvg.innerHTML = `
      <defs>
        <filter id="shadow" x="-20%" y="-20%" width="140%" height="140%">
          <feDropShadow dx="0" dy="2" stdDeviation="3" flood-opacity="0.2"/>
        </filter>
      </defs>
      <rect x="0" y="0" width="${totalW}" height="${totalH}" fill="transparent"/>
    `;

    displayRooms.forEach((r, idx) => {
      const col = idx % colsUsed;
      const row = Math.floor(idx / colsUsed);

      const x = PADDING + col * (BOX_W + GAP);
      const y = PADDING + row * (BOX_H + GAP);

      const roomType = getRoomType(r.id_room_type_una);
      const isFree = isRoomFree(r.id_availability_una);
      const roomId = r.room_number_una || '';
      const roomName = r.room_name_una || 'Unnamed';

      const g = document.createElementNS('http://www.w3.org/2000/svg','g');
      g.setAttribute('filter','url(#shadow)');
      g.innerHTML = `
        <rect x="${x}" y="${y}" rx="8" ry="8"
              width="${BOX_W}" height="${BOX_H}"
              fill="${TYPE_COLOR[roomType] || '#e2e8f0'}"
              stroke="#0f172a" stroke-width="1"
              opacity="${(current.filter==='free' && !isFree) ? 0.25 : 1}"
              class="room-rect" data-id="${roomId}"/>
        <text x="${x+10}" y="${y+26}" font-size="16" font-weight="800" fill="#111827">${roomId}</text>
        <text x="${x+10}" y="${y+46}" font-size="13" fill="#334155">${roomName}</text>
        <text x="${x+10}" y="${y+BOX_H-12}" font-size="12" fill="${isFree?'#1f8b4c':'#b42323'}">
          ${isFree ? 'Free' : 'Occupied'}
        </text>
      `;
      g.style.cursor = 'pointer';
      g.addEventListener('click', () => openRoomPage(roomId));
      mapSvg.appendChild(g);
    });
  }

  function renderRooms() {
    const { building, floor, rooms } = getCurrentContext();
    const displayRooms = filteredRooms(rooms);
    const count = displayRooms.length;

    const buildingName = building ? (building.building_name_una || building.building_code_una) : '—';
    const floorLabel = floor ? floor.floor_label : '—';

    if (count) {
      roomSummary.textContent = `${count} room${count !== 1 ? 's' : ''} found in ${buildingName} — ${floorLabel}.`;
    } else {
      roomSummary.textContent = `No rooms found in ${buildingName} — ${floorLabel} for the current filters.`;
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
          <div class="card-body d-flex flex-column">
            <div class="d-flex justify-content-between align-items-start mb-1">
              <span class="room-id-badge">${roomId}</span>
              ${favorites.has(roomId) ? '<span class="room-tag"><i class="fa-solid fa-star me-1"></i>Favorite</span>' : ''}
            </div>
            <h6 class="mb-1 fw-bold">${roomName}</h6>
            <div class="text-muted small mb-2">
              <i class="fa-regular fa-building me-1"></i>${buildingName} · ${floorLabel}
            </div>
            <div class="mb-2 d-flex flex-wrap gap-1">
              <span class="room-tag"><i class="fa-solid fa-tag me-1"></i>${roomType}</span>
              ${isFree ? '<span class="room-tag"><i class="fa-solid fa-circle-check me-1"></i>Free now</span>' : ''}
            </div>
            <div class="mb-3 small ${isFree ? 'status-ok' : 'status-busy'}">
              ${isFree ? 'Available' : 'Occupied'}
            </div>
            <div class="mt-auto d-flex flex-wrap gap-2">
              <button class="btn btn-sm btn-outline-primary" type="button" onclick="zoomTo('${roomId}')">
                <i class="fa-solid fa-magnifying-glass me-1"></i>Locate
              </button>
              <a class="btn btn-sm btn-outline-secondary" target="_blank" rel="noopener"
                 href="https://maps.google.com/?q=${encodeURIComponent(buildingName)}">
                 <i class="fa-solid fa-route me-1"></i>Directions
              </a>
              <button class="btn btn-sm btn-outline-success" type="button" onclick="openRoomPage('${roomId}')">
                <i class="fa-solid fa-door-open me-1"></i>Room data
              </button>
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

  function renderAccessibility() {
    const { building } = getCurrentContext();
    
    if (building && building.amenities) {
      qs('#elevatorInfo').textContent = `${building.amenities.elevators || 0} elevators across main cores.`;
      qs('#stairsInfo').textContent = `${building.amenities.stairs || 0} staircases; ${building.amenities.ramps || 0} ramps at entries.`;
      qs('#restroomInfo').textContent = `${building.amenities.accessibleRestrooms || 0} accessible restrooms near elevator lobbies.`;
    } else {
      // Default values when no building data available
      qs('#elevatorInfo').textContent = 'Information not available';
      qs('#stairsInfo').textContent = 'Information not available';
      qs('#restroomInfo').textContent = 'Information not available';
    }
  }

  // Interactions
  universitySelect.addEventListener('change', async (e) => {
    current.universityId = e.target.value || null;
    current.buildingId = null;
    current.floorNumber = null;
    
    if (current.universityId) {
      await populateBuildingSelect();
    } else {
      buildingSelect.innerHTML = '<option value="">请先选择大学</option>';
      floorSelect.innerHTML = '<option value="">请先选择建筑</option>';
      DATA.rooms = [];
      renderAll();
    }
  });

  buildingSelect.addEventListener('change', async (e) => {
    current.buildingId = e.target.value || null;
    current.floorNumber = null;
    
    if (current.buildingId) {
      await populateFloorSelect();
    } else {
      floorSelect.innerHTML = '<option value="">请先选择建筑</option>';
      DATA.rooms = [];
      renderAll();
    }
  });

  floorSelect.addEventListener('change', async (e) => {
    current.floorNumber = e.target.value || null;
    await renderAll();
    
    const { building, floor } = getCurrentContext();
    if (liveRegion && building && floor) {
      liveRegion.textContent = `Switched to ${building.building_name_una}, ${floor.floor_label}.`;
    }
  });

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
    const rect = mapSvg.querySelector(`.room-rect[data-id="${CSS.escape(id)}"]`);
    if (rect) {
      rect.animate([
        { transform: 'scale(1)' },
        { transform: 'scale(1.03)' },
        { transform: 'scale(1)' }
      ], { duration: 600, easing: 'ease-in-out' });
    }
    document.getElementById('mapSection').scrollIntoView({ behavior: 'smooth', block: 'start' });
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
