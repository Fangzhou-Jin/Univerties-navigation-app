<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>University Navigation App (UNA)</title>

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
          <h2 class="main-header-title mb-0">University Navigation App</h2>
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
              <div class="col-sm-4 col-md-3">
                <label class="form-label mb-1 small text-muted">Building</label>
                <select id="buildingSelect" class="form-select form-select-sm"></select>
              </div>
              <div class="col-sm-3 col-md-2">
                <label class="form-label mb-1 small text-muted">Floor</label>
                <select id="floorSelect" class="form-select form-select-sm"></select>
              </div>
              <div class="col-sm-5 col-md-5 mt-2 mt-sm-0">
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

  const DATA = {
    buildings: [
      {
        id: 'A', name: 'Main Building A',
        amenities: { elevators: 3, accessibleRestrooms: 4, ramps: 2, stairs: 6 },
        floors: [
          {
            level: 0, label:'Ground', plan: {w:1000,h:560},
            rooms: [
              { id:'A001', name:'Info Desk', type:'service', x:30, y:30, w:160, h:90, free:true },
              { id:'A005', name:'Café', type:'service', x:210,y:30,w:200,h:120, free:false },
              { id:'A010', name:'Admin Office', type:'admin', x:30,y:140,w:160,h:90, free:true },
              { id:'A020', name:'Auditorium', type:'lecture', x:450,y:40,w:480,h:200, free:false },
              { id:'A030', name:'Comp Lab Intro', type:'lab', x:30,y:260,w:260,h:130, free:true },
              { id:'A040', name:'Makerspace', type:'lab', x:310,y:260,w:240,h:130, free:false },
            ]
          },
          {
            level: 1, label:'Floor 1', plan:{w:1000,h:560},
            rooms: [
              { id:'A101', name:'Lecture Hall 1', type:'lecture', x:30,y:40,w:300,h:160, free:true },
              { id:'A102', name:'Seminar Rm', type:'lecture', x:350,y:40,w:260,h:140, free:false },
              { id:'A111', name:'Admin Services', type:'admin', x:30,y:220,w:220,h:120, free:true },
              { id:'A121', name:'Networks Lab', type:'lab', x:270,y:220,w:250,h:140, free:false },
              { id:'A131', name:'AI Lab', type:'lab', x:540,y:220,w:260,h:140, free:true },
            ]
          },
          {
            level: 2, label:'Floor 2', plan:{w:1000,h:560},
            rooms: [
              { id:'A201', name:'Lecture Hall 2', type:'lecture', x:30,y:40,w:280,h:160, free:false },
              { id:'A212', name:'UX Studio', type:'lab', x:330,y:40,w:220,h:140, free:true },
              { id:'A231', name:'Dean Office', type:'admin', x:30,y:220,w:220,h:120, free:false },
              { id:'A241', name:'Project Lab', type:'lab', x:270,y:220,w:250,h:140, free:true },
            ]
          }
        ]
      },
      {
        id:'B', name:'Science Wing B',
        amenities:{ elevators:2, accessibleRestrooms:2, ramps:1, stairs:4 },
        floors:[
          {
            level:0, label:'Ground', plan:{w:1000,h:560},
            rooms:[
              { id:'B001', name:'Help Desk', type:'service', x:30,y:30,w:140,h:90, free:true },
              { id:'B010', name:'Chem Lab', type:'lab', x:180,y:30,w:300,h:160, free:false },
              { id:'B020', name:'Physics Lab', type:'lab', x:500,y:30,w:300,h:160, free:true },
              { id:'B030', name:'Lecture Room', type:'lecture', x:30,y:220,w:340,h:160, free:false },
            ]
          },
          {
            level:1, label:'Floor 1', plan:{w:1000,h:560},
            rooms:[
              { id:'B101', name:'Bio Lab', type:'lab', x:30,y:40,w:300,h:160, free:true },
              { id:'B115', name:'Admin Office', type:'admin', x:350,y:40,w:220,h:120, free:true },
              { id:'B131', name:'Lecture 1.31', type:'lecture', x:30,y:220,w:260,h:140, free:true },
            ]
          }
        ]
      }
    ]
  };

  const TYPE_COLOR = {
    lecture: '#a3c4f3',
    lab: '#b9fbc0',
    admin: '#ffd6a5',
    service: '#e0e0e0'
  };

  const qs = s => document.querySelector(s);
  const qsa = s => [...document.querySelectorAll(s)];

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

  let current = { buildingIdx: 0, floorIdx: 0, filter: 'all', query: '' };
  let favorites = new Set();

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
    const b = DATA.buildings[current.buildingIdx];
    const f = b.floors[current.floorIdx];
    return { b, f };
  }

  // Populate selects
  function populateBuildingSelect() {
    buildingSelect.innerHTML = DATA.buildings
      .map((b, i) => `<option value="${i}">${b.name}</option>`)
      .join('');
  }

  function populateFloorSelect() {
    const b = DATA.buildings[current.buildingIdx];
    floorSelect.innerHTML = b.floors
      .map((f, i) => `<option value="${i}">${f.label}</option>`)
      .join('');
  }

  // Rendering
  function renderAll() {
    renderMap();
    renderRooms();
    renderAccessibility();
  }

  function filteredRooms(rooms) {
    const q = (current.query || '').trim().toLowerCase();
    return rooms.filter(r => {
      const qMatch = !q || [r.id, r.name, r.type].join(' ').toLowerCase().includes(q);
      const typeMatch =
        (current.filter === 'all') ||
        (current.filter === 'free' ? r.free :
          current.filter === 'favorites' ? favorites.has(r.id) :
          r.type === current.filter);
      return qMatch && typeMatch;
    });
  }

  function renderMap() {
    const { b, f } = getCurrentContext();
    const rooms = filteredRooms(f.rooms);

    mapTitle.textContent = b.name;
    floorMeta.textContent = f.label;

    const BOX_W = 260;
    const BOX_H = 140;
    const GAP   = 24;
    const PADDING = 40;
    const MAX_COLS = 3;

    const colsUsed = Math.min(MAX_COLS, Math.max(rooms.length, 1));
    const rows = Math.max(1, Math.ceil(rooms.length / colsUsed));

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

    rooms.forEach((r, idx) => {
      const col = idx % colsUsed;
      const row = Math.floor(idx / colsUsed);

      const x = PADDING + col * (BOX_W + GAP);
      const y = PADDING + row * (BOX_H + GAP);

      const g = document.createElementNS('http://www.w3.org/2000/svg','g');
      g.setAttribute('filter','url(#shadow)');
      g.innerHTML = `
        <rect x="${x}" y="${y}" rx="8" ry="8"
              width="${BOX_W}" height="${BOX_H}"
              fill="${TYPE_COLOR[r.type] || '#e2e8f0'}"
              stroke="#0f172a" stroke-width="1"
              opacity="${(current.filter==='free' && !r.free) ? 0.25 : 1}"
              class="room-rect" data-id="${r.id}"/>
        <text x="${x+10}" y="${y+26}" font-size="16" font-weight="800" fill="#111827">${r.id}</text>
        <text x="${x+10}" y="${y+46}" font-size="13" fill="#334155">${r.name}</text>
        <text x="${x+10}" y="${y+BOX_H-12}" font-size="12" fill="${r.free?'#1f8b4c':'#b42323'}">
          ${r.free ? 'Free' : 'Occupied'}
        </text>
      `;
      g.style.cursor = 'pointer';
      g.addEventListener('click', () => openRoomPage(r.id));
      mapSvg.appendChild(g);
    });
  }

  function renderRooms() {
    const { b, f } = getCurrentContext();
    const rooms = filteredRooms(f.rooms);
    const count = rooms.length;

    if (count) {
      roomSummary.textContent = `${count} room${count !== 1 ? 's' : ''} found in ${b.name} — ${f.label}.`;
    } else {
      roomSummary.textContent = `No rooms found in ${b.name} — ${f.label} for the current filters.`;
      roomGrid.innerHTML = `<p class="text-muted">Try clearing search, changing room type filter, or switching building/floor.</p>`;
      return;
    }

    roomGrid.innerHTML = rooms.map(r => `
      <div class="col-md-4">
        <div class="card room-card h-100">
          <div class="card-body d-flex flex-column">
            <div class="d-flex justify-content-between align-items-start mb-1">
              <span class="room-id-badge">${r.id}</span>
              ${favorites.has(r.id) ? '<span class="room-tag"><i class="fa-solid fa-star me-1"></i>Favorite</span>' : ''}
            </div>
            <h6 class="mb-1 fw-bold">${r.name}</h6>
            <div class="text-muted small mb-2">
              <i class="fa-regular fa-building me-1"></i>${b.name} · ${f.label}
            </div>
            <div class="mb-2 d-flex flex-wrap gap-1">
              <span class="room-tag"><i class="fa-solid fa-tag me-1"></i>${r.type}</span>
              ${r.free ? '<span class="room-tag"><i class="fa-solid fa-circle-check me-1"></i>Free now</span>' : ''}
            </div>
            <div class="mb-3 small ${r.free ? 'status-ok' : 'status-busy'}">
              ${r.free ? 'Available' : 'Occupied'}
            </div>
            <div class="mt-auto d-flex flex-wrap gap-2">
              <button class="btn btn-sm btn-outline-primary" type="button" onclick="zoomTo('${r.id}')">
                <i class="fa-solid fa-magnifying-glass me-1"></i>Locate
              </button>
              <a class="btn btn-sm btn-outline-secondary" target="_blank" rel="noopener"
                 href="https://maps.google.com/?q=${encodeURIComponent(b.name)}">
                 <i class="fa-solid fa-route me-1"></i>Directions
              </a>
              <button class="btn btn-sm btn-outline-success" type="button" onclick="openRoomPage('${r.id}')">
                <i class="fa-solid fa-door-open me-1"></i>Room data
              </button>
              <button class="btn btn-sm btn-outline-warning fav-btn ${favorites.has(r.id)?'fav-active':''}"
                type="button"
                onclick="toggleFavorite('${r.id}')"
                aria-label="Toggle favorite for ${r.id} ${r.name}">
                <i class="fa-solid fa-star"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    `).join('');
  }

  function renderAccessibility() {
    const { b } = getCurrentContext();
    qs('#elevatorInfo').textContent = `${b.amenities.elevators} elevators across main cores.`;
    qs('#stairsInfo').textContent = `${b.amenities.stairs} staircases; ${b.amenities.ramps} ramps at entries.`;
    qs('#restroomInfo').textContent = `${b.amenities.accessibleRestrooms} accessible restrooms near elevator lobbies.`;
  }

  // Interactions
  buildingSelect.addEventListener('change', e => {
    current.buildingIdx = +e.target.value;
    current.floorIdx = 0;
    populateFloorSelect();
    floorSelect.value = 0;
    renderAll();
    const { b, f } = getCurrentContext();
    if (liveRegion) liveRegion.textContent = `Switched to ${b.name}, ${f.label}.`;
  });

  floorSelect.addEventListener('change', e => {
    current.floorIdx = +e.target.value;
    renderAll();
    const { b, f } = getCurrentContext();
    if (liveRegion) liveRegion.textContent = `Switched to ${b.name}, ${f.label}.`;
  });

  searchInput.addEventListener('input', e => {
    current.query = e.target.value;
    renderAll();
  });

  qs('#clearSearch').addEventListener('click', () => {
    current.query = '';
    searchInput.value = '';
    renderAll();
  });

  // Filters (sidebar)
  function updateFilterButtons() {
    qsa('#RoomsFilters [data-filter]').forEach(btn => {
      const active = btn.dataset.filter === current.filter;
      btn.classList.toggle('filter-btn-active', active);
    });
  }

  qsa('#RoomsFilters [data-filter]').forEach(btn => {
    btn.addEventListener('click', () => {
      current.filter = btn.dataset.filter;
      renderAll();
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

  // ===== Profile dropdown tab logic + demo handlers =====
  const profileTabButtons = document.querySelectorAll('[data-profile-tab]');
  const profileTabProfile = document.getElementById('profileTab-profile');
  const profileTabSettings = document.getElementById('profileTab-settings');

  profileTabButtons.forEach(btn => {
    btn.addEventListener('click', () => {
      const target = btn.getAttribute('data-profile-tab');

      profileTabButtons.forEach(b => b.classList.toggle('active', b === btn));

      if (target === 'profile') {
        profileTabProfile.classList.remove('d-none');
        profileTabSettings.classList.add('d-none');
      } else {
        profileTabSettings.classList.remove('d-none');
        profileTabProfile.classList.add('d-none');
      }
    });
  });

  function handleEditProfile() {
    alert('Edit profile (demo). Connect this to your backend later.');
  }

  function handleAccountSave() {
    alert('Account settings saved (demo). Connect this to your backend later.');
  }

  function handleDeleteAccount() {
    if (confirm('Are you sure you want to delete your account?')) {
      alert('Account deletion (demo). Connect this to your backend later.');
    }
  }

  // Initial bootstrap
  populateBuildingSelect();
  populateFloorSelect();
  renderAll();
  updateFilterButtons();
</script>
</body>
</html>
