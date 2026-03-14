<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $title ?? 'Dashboard' }} - LMS SMKN 40 Jakarta</title>

    <link rel="stylesheet" href="{{ asset('skydash/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('skydash/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('skydash/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('skydash/vendors/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('skydash/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('skydash/css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('images/landing/Logo40.png') }}" />

    <style>
    /* ===========================================
       ROOT VARIABLES
    =========================================== */
    :root {
        --primary:       #4e73df;
        --primary-dark:  #224abe;
        --primary-light: #e8f0fe;
        --danger:        #e74a3b;
        --success:       #1cc88a;
        --sidebar-w:     238px;
        --sidebar-mini:  68px;
        --topbar-h:      62px;
        --radius:        12px;
        --shadow-xs:     0 1px 4px rgba(0,0,0,.06);
        --shadow-sm:     0 2px 10px rgba(0,0,0,.08);
        --shadow-md:     0 6px 24px rgba(0,0,0,.11);
        --shadow-lg:     0 12px 40px rgba(0,0,0,.15);
        --ease:          cubic-bezier(.4,0,.2,1);
        --trans:         .22s var(--ease);
    }

    /* ===========================================
       TOPBAR
    =========================================== */
    .navbar {
        height: var(--topbar-h) !important;
        background: #fff !important;
        border-bottom: 1px solid #eaecf4 !important;
        box-shadow: var(--shadow-xs) !important;
        padding: 0 !important;
        z-index: 1030 !important;
    }

    /* Brand wrapper */
    .navbar-brand-wrapper {
        width: var(--sidebar-w);
        height: var(--topbar-h);
        background: #fff;
        border-right: 1px solid #eaecf4;
        display: flex;
        align-items: center;
        padding: 0 18px;
        flex-shrink: 0;
        transition: width var(--trans);
        overflow: hidden;
    }

    .navbar-brand-wrapper .navbar-brand {
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        white-space: nowrap;
    }

    .navbar-brand-wrapper .navbar-brand img {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        object-fit: cover;
        flex-shrink: 0;
    }

    .brand-logo-text {
        font-size: 15px;
        font-weight: 700;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: -.2px;
        transition: opacity var(--trans), width var(--trans);
    }

    /* Mini brand (collapsed) */
    .navbar-brand-wrapper .navbar-brand.brand-logo-mini {
        display: none;
    }

    /* Menu wrapper */
    .navbar-menu-wrapper {
        flex: 1;
        height: var(--topbar-h);
        display: flex;
        align-items: center;
        padding: 0 18px;
        gap: 8px;
    }

    /* Sidebar toggle */
    .sidebar-toggler {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        border: none;
        background: transparent;
        color: #9fa3b1;
        font-size: 20px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all var(--trans);
        flex-shrink: 0;
    }
    .sidebar-toggler:hover {
        background: var(--primary-light);
        color: var(--primary);
    }

    /* Page title in topbar (mobile) */
    .topbar-page-title {
        font-size: 15px;
        font-weight: 600;
        color: #2d3748;
        display: none;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 180px;
    }

    /* Push nav items to the right */
    .navbar-menu-wrapper .navbar-nav-right {
        margin-left: auto;
        display: flex;
        align-items: center;
        gap: 4px;
        list-style: none;
        margin-bottom: 0;
        padding-left: 0;
    }

    /* Icon action button */
    .nav-icon-btn {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        border: 1px solid #eaecf4;
        background: #f8f9fc;
        color: #9fa3b1;
        font-size: 18px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all var(--trans);
        text-decoration: none;
        position: relative;
    }
    .nav-icon-btn:hover {
        background: var(--primary-light);
        border-color: #c5d5f8;
        color: var(--primary);
    }

    /* Notification badge dot */
    .nav-icon-btn .badge-dot {
        position: absolute;
        top: 8px;
        right: 8px;
        width: 7px;
        height: 7px;
        background: var(--danger);
        border-radius: 50%;
        border: 2px solid #fff;
    }

    /* Profile chip */
    .nav-profile-chip {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 4px 10px 4px 4px;
        border-radius: 999px;
        border: 1px solid #eaecf4;
        background: #f8f9fc;
        cursor: pointer;
        text-decoration: none;
        transition: all var(--trans);
    }
    .nav-profile-chip:hover {
        background: var(--primary-light);
        border-color: #c5d5f8;
    }

    .nav-profile-chip img {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
    }

    .nav-profile-info {
        display: flex;
        flex-direction: column;
        line-height: 1.25;
    }
    .nav-profile-name {
        font-size: 12.5px;
        font-weight: 600;
        color: #2d3748;
        white-space: nowrap;
    }
    .nav-profile-role {
        font-size: 10.5px;
        color: #adb5bd;
    }

    /* Shared dropdown card */
    .nav-dropdown-menu {
        border: none !important;
        border-radius: var(--radius) !important;
        box-shadow: var(--shadow-lg) !important;
        padding: 6px !important;
        min-width: 200px;
    }

    .nav-dropdown-menu .dropdown-header-block {
        padding: 8px 10px 10px;
        border-bottom: 1px solid #f0f0f3;
        margin-bottom: 4px;
    }

    .nav-dropdown-menu .dropdown-item {
        border-radius: 8px;
        padding: 9px 12px;
        font-size: 13px;
        color: #3d3d3d;
        display: flex;
        align-items: center;
        gap: 9px;
        transition: all var(--trans);
    }
    .nav-dropdown-menu .dropdown-item:hover {
        background: var(--primary-light);
        color: var(--primary);
    }
    .nav-dropdown-menu .dropdown-item i { font-size: 16px; }
    .nav-dropdown-menu .dropdown-divider { margin: 4px 0; border-color: #f0f0f3; }

    /* ===========================================
       SIDEBAR
    =========================================== */
    .sidebar {
        width: var(--sidebar-w) !important;
        background: #fff !important;
        border-right: 1px solid #eaecf4 !important;
        box-shadow: none !important;
        transition: width var(--trans) !important;
        overflow: hidden;
    }

    .sidebar .nav {
        padding: 10px 10px 80px !important;
        overflow-y: auto !important;
        overflow-x: hidden !important;
        max-height: calc(100vh - var(--topbar-h));
    }

    /* Scrollbar */
    .sidebar .nav::-webkit-scrollbar { width: 3px; }
    .sidebar .nav::-webkit-scrollbar-track { background: transparent; }
    .sidebar .nav::-webkit-scrollbar-thumb { background: #e0e3ed; border-radius: 4px; }

    /* Section label */
    .sidebar-label {
        font-size: 9.5px;
        font-weight: 700;
        letter-spacing: 1.1px;
        text-transform: uppercase;
        color: #b0b7c3;
        padding: 18px 12px 5px;
    }

    /* Nav item */
    .sidebar .nav-item {
        margin-bottom: 1px;
    }

    .sidebar .nav-item .nav-link {
        display: flex !important;
        align-items: center;
        gap: 10px;
        padding: 9px 12px !important;
        border-radius: 10px !important;
        color: #6b7280 !important;
        font-size: 13.5px !important;
        font-weight: 500 !important;
        white-space: nowrap;
        overflow: hidden;
        transition: all var(--trans) !important;
        text-decoration: none;
        position: relative;
    }

    .sidebar .nav-item .nav-link:hover {
        background: #f4f6fb !important;
        color: var(--primary) !important;
    }
    .sidebar .nav-item .nav-link:hover .menu-icon { color: var(--primary) !important; }

    /* Active */
    .sidebar .nav-item.active > .nav-link,
    .sidebar .nav-item .nav-link.active {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%) !important;
        color: #fff !important;
        box-shadow: 0 4px 14px rgba(78,115,223,.38) !important;
    }
    .sidebar .nav-item.active > .nav-link .menu-icon,
    .sidebar .nav-item .nav-link.active .menu-icon { color: #fff !important; }

    /* Icon */
    .sidebar .nav-link .menu-icon {
        font-size: 19px !important;
        width: 22px;
        text-align: center;
        flex-shrink: 0;
        color: #b0b7c3;
        transition: color var(--trans);
        line-height: 1;
    }

    .sidebar .nav-link .menu-title {
        font-size: 13.5px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        transition: opacity var(--trans), width var(--trans);
    }

    /* Logout button in sidebar */
    .sidebar .nav-item button.nav-link {
        width: 100%;
        text-align: left;
        border: none;
        background: transparent;
        cursor: pointer;
    }

    /* ===========================================
       SIDEBAR ICON-ONLY (COLLAPSED)
    =========================================== */
    .sidebar-icon-only .sidebar { width: var(--sidebar-mini) !important; }
    .sidebar-icon-only .sidebar .menu-title { display: none; }
    .sidebar-icon-only .sidebar .sidebar-label { display: none; }
    .sidebar-icon-only .sidebar .nav-link {
        justify-content: center;
        padding: 9px 0 !important;
    }
    .sidebar-icon-only .navbar-brand-wrapper { width: var(--sidebar-mini); }
    .sidebar-icon-only .navbar-brand-wrapper .brand-logo-text { display: none; }
    .sidebar-icon-only .main-panel { margin-left: var(--sidebar-mini) !important; }

    /* ===========================================
       MAIN PANEL
    =========================================== */
    .main-panel {
        background: #f4f6fb !important;
    }

    .content-wrapper {
        padding: 24px !important;
    }

    .footer {
        background: #fff;
        border-top: 1px solid #eaecf4;
        padding: 14px 24px !important;
    }
    .footer span { font-size: 12px; color: #adb5bd; }

    /* ===========================================
       MOBILE BOTTOM NAV — App style
    =========================================== */
    .mobile-bottom-nav {
        display: none;
        position: fixed;
        bottom: 0; left: 0; right: 0;
        z-index: 1050;
        background: rgba(255,255,255,0.96);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-top: 1px solid #eaecf4;
        box-shadow: 0 -4px 24px rgba(0,0,0,.09);
        padding-bottom: env(safe-area-inset-bottom, 0px);
        transition: transform .3s var(--ease);
    }

    .mobile-bottom-nav.hide {
        transform: translateY(105%);
    }

    .mobile-bottom-nav-track {
        display: flex;
        align-items: stretch;
        height: 62px;
        overflow-x: auto;
        overflow-y: hidden;
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
    }
    .mobile-bottom-nav-track::-webkit-scrollbar { display: none; }

    /* Tab item */
    .mobile-tab {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 3px;
        min-width: 64px;
        flex: 1;
        max-width: 84px;
        padding: 8px 6px;
        text-decoration: none;
        color: #adb5bd;
        position: relative;
        cursor: pointer;
        -webkit-tap-highlight-color: transparent;
        transition: color var(--trans);
        border: none;
        background: none;
        font-family: inherit;
    }

    .mobile-tab-icon {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all var(--trans);
    }

    .mobile-tab i {
        font-size: 21px;
        line-height: 1;
        transition: all var(--trans);
    }

    .mobile-tab span {
        font-size: 9.5px;
        font-weight: 600;
        letter-spacing: .2px;
        white-space: nowrap;
        max-width: 68px;
        overflow: hidden;
        text-overflow: ellipsis;
        text-align: center;
    }

    /* Active tab */
    .mobile-tab.active {
        color: var(--primary);
    }

    .mobile-tab.active .mobile-tab-icon {
        background: var(--primary-light);
    }

    .mobile-tab.active i {
        transform: translateY(-1px);
    }

    /* Top indicator line */
    .mobile-tab.active::after {
        content: '';
        position: absolute;
        top: 0; left: 50%;
        transform: translateX(-50%);
        width: 24px; height: 3px;
        background: linear-gradient(90deg, var(--primary), var(--primary-dark));
        border-radius: 0 0 4px 4px;
    }

    /* Tap feedback */
    .mobile-tab:active .mobile-tab-icon {
        transform: scale(.88);
    }

    /* "More" button */
    .mobile-tab-more {
        flex-shrink: 0;
    }

    /* ===========================================
       MORE DRAWER (slide up)
    =========================================== */
    .drawer-overlay {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 1055;
        background: rgba(0,0,0,.35);
        backdrop-filter: blur(3px);
        -webkit-backdrop-filter: blur(3px);
        animation: fadeIn .22s var(--ease);
    }
    @keyframes fadeIn { from { opacity:0; } to { opacity:1; } }

    .more-drawer {
        display: none;
        position: fixed;
        bottom: 0; left: 0; right: 0;
        z-index: 1060;
        background: #fff;
        border-radius: 22px 22px 0 0;
        box-shadow: 0 -8px 40px rgba(0,0,0,.15);
        padding: 0 16px calc(24px + env(safe-area-inset-bottom, 0px));
        transform: translateY(100%);
        transition: transform .32s var(--ease);
        max-height: 80vh;
        overflow-y: auto;
    }
    .more-drawer.open { transform: translateY(0); }

    .drawer-handle {
        width: 36px; height: 4px;
        background: #e3e6f0;
        border-radius: 2px;
        margin: 14px auto 18px;
    }

    .drawer-section-label {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #b0b7c3;
        margin-bottom: 10px;
        padding: 0 2px;
    }

    .drawer-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 8px;
        margin-bottom: 18px;
    }

    .drawer-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 14px 8px;
        border-radius: 14px;
        background: #f8f9fc;
        border: 1px solid #eaecf4;
        text-decoration: none;
        color: #5a5c69;
        transition: all var(--trans);
        -webkit-tap-highlight-color: transparent;
        cursor: pointer;
    }

    .drawer-item i {
        font-size: 23px;
        line-height: 1;
    }

    .drawer-item span {
        font-size: 10.5px;
        font-weight: 600;
        text-align: center;
        white-space: nowrap;
    }

    .drawer-item.active {
        background: var(--primary-light);
        border-color: #c5d5f8;
        color: var(--primary);
    }

    .drawer-item:active {
        transform: scale(.91);
    }

    /* Drawer logout row */
    .drawer-logout {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 13px 14px;
        border-radius: 12px;
        background: #fff5f5;
        border: 1px solid #fdd;
        color: var(--danger);
        cursor: pointer;
        font-size: 13.5px;
        font-weight: 600;
        width: 100%;
        text-align: left;
        transition: all var(--trans);
        margin-top: 4px;
    }
    .drawer-logout:active { transform: scale(.97); }
    .drawer-logout i { font-size: 20px; }

    /* ===========================================
       RESPONSIVE
    =========================================== */

    @media (max-width: 991px) {
        /* Hide sidebar completely on mobile */
        .sidebar {
            display: none !important;
        }

        /* Brand wrapper shrinks */
        .navbar-brand-wrapper {
            width: auto !important;
            min-width: unset !important;
            border-right: none !important;
            padding: 0 14px !important;
        }

        /* Main panel takes full width */
        .main-panel {
            margin-left: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
        }

        /* page-body-wrapper override for mobile */
        .container-fluid.page-body-wrapper {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        /* Show the bottom nav — override display:none */
        .mobile-bottom-nav {
            display: block !important;
        }

        /* Extra bottom padding for content so it's not behind bottom nav */
        .content-wrapper {
            padding: 14px !important;
            padding-bottom: calc(72px + env(safe-area-inset-bottom, 0px) + 12px) !important;
        }

        /* Show mobile page title, hide desktop profile name */
        .topbar-page-title { display: block; }
        .nav-profile-info  { display: none; }
        .navbar-menu-wrapper { padding: 0 10px; }
    }

    @media (max-width: 576px) {
        .content-wrapper { padding: 10px !important; padding-bottom: calc(72px + env(safe-area-inset-bottom, 0px) + 10px) !important; }
    }

    @media (prefers-reduced-motion: reduce) {
        *, ::before, ::after { transition: none !important; animation: none !important; }
    }

    /* profile arrow */
    .profile-arrow{
        font-size:14px;
        color:#adb5bd;
        margin-left:4px;
        transition:transform .2s ease;
    }

    .nav-profile-chip.show .profile-arrow{
        transform:rotate(180deg);
    }

    /* dropdown header */
    .dropdown-header-block{
        display:flex;
        align-items:center;
        gap:10px;
        padding:10px 12px 12px;
        border-bottom:1px solid #f0f0f3;
        margin-bottom:4px;
    }

    .dropdown-avatar{
        width:34px;
        height:34px;
        border-radius:50%;
        object-fit:cover;
        flex-shrink:0;
    }

    .dropdown-user{
        line-height:1.2;
    }

    .dropdown-name{
        font-size:13px;
        font-weight:600;
        color:#2d3748;
        margin:0;
    }

    .dropdown-email{
        font-size:11px;
        color:#9aa0ac;
        margin:0;
    }

    /* dropdown item improvement */
    .nav-dropdown-menu .dropdown-item{
        border-radius:8px;
        padding:9px 12px;
        font-size:13px;
        color:#3d3d3d;
        display:flex;
        align-items:center;
        gap:9px;
    }

    .nav-dropdown-menu .dropdown-item i{
        font-size:17px;
        width:18px;
        text-align:center;
    }

    /* logout style */
    .dropdown-logout{
        color:var(--danger);
    }

    .dropdown-logout:hover{
        background:#fff5f5;
        color:var(--danger);
    }
    </style>

    @stack('styles')
</head>

<body>
<div class="container-scroller">

{{-- ================================================
     TOPBAR
================================================ --}}
<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">

    {{-- Brand --}}
    <div class="navbar-brand-wrapper">
        <a class="navbar-brand brand-logo d-flex align-items-center" href="{{ route('dashboard') }}">
            <img src="{{ asset('images/landing/Logo40.png') }}" alt="Logo">
            <span class="brand-logo-text">LMS SMKN 40</span>
        </a>
    </div>

    {{-- Menu area --}}
    <div class="navbar-menu-wrapper">

        {{-- Sidebar toggle (desktop only) --}}
        <button class="sidebar-toggler d-none d-lg-flex" type="button" data-toggle="minimize" title="Toggle sidebar">
            <i class="mdi mdi-menu"></i>
        </button>

        {{-- Page title (mobile) --}}
        <span class="topbar-page-title ml-1">{{ $title ?? 'Dashboard' }}</span>

        {{-- Right side --}}
        <ul class="navbar-nav-right">

            {{-- Notifications --}}
            <li class="nav-item dropdown">
                <a class="nav-icon-btn" href="#" data-bs-toggle="dropdown" title="Notifikasi">
                    <i class="mdi mdi-bell-outline"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right nav-dropdown-menu">
                    <div class="dropdown-header-block">
                        <p class="mb-0 font-weight-bold" style="font-size:13px;color:#2d3748;">Notifikasi</p>
                    </div>
                    <div class="py-3 text-center">
                        <i class="mdi mdi-bell-sleep-outline" style="font-size:30px;color:#d1d3e2;"></i>
                        <p class="text-muted mb-0 mt-1" style="font-size:12px;">Tidak ada notifikasi</p>
                    </div>
                </div>
            </li>

            {{-- Profile --}}
                <li class="nav-item dropdown">
                    <a class="nav-profile-chip" href="#" data-bs-toggle="dropdown" id="profileDrop">
                        <img src="{{ auth()->user()->avatar_url }}" alt="avatar">

                        <div class="nav-profile-info">
                            <span class="nav-profile-name">
                                {{ Str::limit(auth()->user()->name, 16) }}
                            </span>

                            <span class="nav-profile-role">
                                @if(auth()->user()->hasRole('admin'))
                                    Admin
                                @elseif(auth()->user()->hasRole('instructor'))
                                    Guru
                                @else
                                    Siswa
                                @endif
                            </span>
                        </div>

                        <i class="mdi mdi-chevron-down profile-arrow"></i>
                    </a>

                    <div class="dropdown-menu dropdown-menu-end nav-dropdown-menu" aria-labelledby="profileDrop">

                        {{-- Header --}}
                        <div class="dropdown-header-block">
                            <img src="{{ auth()->user()->avatar_url }}" class="dropdown-avatar">

                            <div class="dropdown-user">
                                <p class="dropdown-name">{{ auth()->user()->name }}</p>
                                <p class="dropdown-email">{{ auth()->user()->email }}</p>
                            </div>
                        </div>

                        {{-- Menu --}}
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            <i class="mdi mdi-account-cog-outline"></i>
                            Profil
                        </a>

                        <div class="dropdown-divider"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item dropdown-logout">
                                <i class="mdi mdi-logout"></i>
                                Keluar
                            </button>
                        </form>

                    </div>
                </li>

        </ul>
    </div>
</nav>

{{-- ================================================
     PAGE BODY
================================================ --}}
<div class="container-fluid page-body-wrapper">

    {{-- ================================================
         SIDEBAR
    ================================================ --}}
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav flex-column">

            {{-- Dashboard --}}
            <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="mdi mdi-view-dashboard-outline menu-icon"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>

            @if(auth()->user()->hasRole('admin'))

            <span class="sidebar-label">Manajemen</span>
            <li class="nav-item {{ request()->routeIs(['classrooms.*']) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('classrooms.index') }}">
                    <i class="mdi mdi-google-classroom menu-icon"></i>
                    <span class="menu-title">Kelas</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs(['students.*']) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('students.index') }}">
                    <i class="mdi mdi-account-school-outline menu-icon"></i>
                    <span class="menu-title">Siswa</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs(['instructors.*']) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('instructors.index') }}">
                    <i class="mdi mdi-human-male-board menu-icon"></i>
                    <span class="menu-title">Management Guru</span>
                </a>
            </li>

            <span class="sidebar-label">Konten Belajar</span>
            <li class="nav-item {{ request()->routeIs(['courses.*']) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('courses.index') }}">
                    <i class="mdi mdi-library-outline menu-icon"></i>
                    <span class="menu-title">Mata Pelajaran</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs(['modules.*']) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('modules.index') }}">
                    <i class="mdi mdi-folder-outline menu-icon"></i>
                    <span class="menu-title">Modul</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs(['lessons.*']) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('lessons.index') }}">
                    <i class="mdi mdi-book-open-page-variant-outline menu-icon"></i>
                    <span class="menu-title">Materi</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs(['tasks.*']) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('tasks.index') }}">
                    <i class="mdi mdi-clipboard-check-outline menu-icon"></i>
                    <span class="menu-title">Tugas</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs(['quizzes.*','quiz.*']) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('quizzes.index') }}">
                    <i class="mdi mdi-file-question-outline menu-icon"></i>
                    <span class="menu-title">Kuis</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs(['exams.*']) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('exams.index') }}">
                    <i class="mdi mdi-fountain-pen-tip menu-icon"></i>
                    <span class="menu-title">Ujian</span>
                </a>
            </li>

            <span class="sidebar-label">Monitoring</span>
            <li class="nav-item {{ request()->routeIs(['attendance.*']) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('attendance.index') }}">
                    <i class="mdi mdi-note-check-outline menu-icon"></i>
                    <span class="menu-title">Absensi</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs(['enrollments.*']) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('enrollments.index') }}">
                    <i class="mdi mdi-chart-bar menu-icon"></i>
                    <span class="menu-title">Progress Siswa</span>
                </a>
            </li>

            <span class="sidebar-label">Lainnya</span>
            <li class="nav-item {{ request()->routeIs(['ebooks.*']) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('ebooks.index') }}">
                    <i class="mdi mdi-bookshelf menu-icon"></i>
                    <span class="menu-title">Perpustakaan</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs(['counseling.*']) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('counseling.index') }}">
                    <i class="mdi mdi-chat-outline menu-icon"></i>
                    <span class="menu-title">Konseling</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs(['testimonials.*']) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('testimonials.manage') }}">
                    <i class="mdi mdi-comment-alert-outline menu-icon"></i>
                    <span class="menu-title">Aduan Siswa</span>
                </a>
            </li>

            @elseif(auth()->user()->hasRole('instructor'))

            <span class="sidebar-label">Konten Belajar</span>
            <li class="nav-item {{ request()->routeIs(['courses.*']) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('courses.index') }}">
                    <i class="mdi mdi-library-outline menu-icon"></i>
                    <span class="menu-title">Mata Pelajaran</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs(['modules.*']) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('modules.index') }}">
                    <i class="mdi mdi-folder-outline menu-icon"></i>
                    <span class="menu-title">Modul</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs(['lessons.*']) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('lessons.index') }}">
                    <i class="mdi mdi-book-open-page-variant-outline menu-icon"></i>
                    <span class="menu-title">Materi</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs(['tasks.*']) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('tasks.index') }}">
                    <i class="mdi mdi-clipboard-check-outline menu-icon"></i>
                    <span class="menu-title">Tugas</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs(['quizzes.*','quiz.*']) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('quizzes.index') }}">
                    <i class="mdi mdi-file-question-outline menu-icon"></i>
                    <span class="menu-title">Kuis</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs(['exams.*']) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('exams.index') }}">
                    <i class="mdi mdi-fountain-pen-tip menu-icon"></i>
                    <span class="menu-title">Ujian</span>
                </a>
            </li>

            <span class="sidebar-label">Monitoring</span>
            <li class="nav-item {{ request()->routeIs(['attendance.*']) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('attendance.index') }}">
                    <i class="mdi mdi-note-check-outline menu-icon"></i>
                    <span class="menu-title">Absensi</span>
                </a>
            </li>
            <span class="sidebar-label">Lainnya</span>
            <li class="nav-item {{ request()->routeIs(['ebooks.*']) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('ebooks.index') }}">
                    <i class="mdi mdi-bookshelf menu-icon"></i>
                    <span class="menu-title">Perpustakaan</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs(['counseling.*']) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('counseling.index') }}">
                    <i class="mdi mdi-chat-outline menu-icon"></i>
                    <span class="menu-title">Konseling</span>
                </a>
            </li>

            @elseif(auth()->user()->hasRole('student'))

            <span class="sidebar-label">Belajar</span>
            <li class="nav-item {{ request()->routeIs(['courses.*']) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('courses.index') }}">
                    <i class="mdi mdi-library-outline menu-icon"></i>
                    <span class="menu-title">Mata Pelajaran</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs(['modules.*']) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('modules.index') }}">
                    <i class="mdi mdi-folder-outline menu-icon"></i>
                    <span class="menu-title">Modul</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs(['lessons.*']) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('lessons.index') }}">
                    <i class="mdi mdi-book-open-page-variant-outline menu-icon"></i>
                    <span class="menu-title">Materi</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs(['tasks.*']) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('tasks.index') }}">
                    <i class="mdi mdi-clipboard-check-outline menu-icon"></i>
                    <span class="menu-title">Tugas</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs(['quizzes.*','quiz.*']) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('quizzes.index') }}">
                    <i class="mdi mdi-file-question-outline menu-icon"></i>
                    <span class="menu-title">Kuis</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs(['exams.*']) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('exams.index') }}">
                    <i class="mdi mdi-fountain-pen-tip menu-icon"></i>
                    <span class="menu-title">Ujian</span>
                </a>
            </li>

            <span class="sidebar-label">Saya</span>
            <li class="nav-item {{ request()->routeIs(['enrollments.*']) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('enrollments.index') }}">
                    <i class="mdi mdi-trending-up menu-icon"></i>
                    <span class="menu-title">Progress Pelajaran</span>
                </a>
            </li>
            <span class="sidebar-label">Lainnya</span>
            <li class="nav-item {{ request()->routeIs(['ebooks.*']) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('ebooks.index') }}">
                    <i class="mdi mdi-bookshelf menu-icon"></i>
                    <span class="menu-title">Perpustakaan</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs(['counseling.*']) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('counseling.index') }}">
                    <i class="mdi mdi-chat-outline menu-icon"></i>
                    <span class="menu-title">Konseling</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs(['testimonials.*']) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('testimonials.create') }}">
                    <i class="mdi mdi-comment-alert-outline menu-icon"></i>
                    <span class="menu-title">Aduan</span>
                </a>
            </li>

            @endif

            {{-- Account --}}
            <span class="sidebar-label">Akun</span>
            <li class="nav-item {{ request()->routeIs(['profile.*']) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('profile.edit') }}">
                    <i class="mdi mdi-account-cog-outline menu-icon"></i>
                    <span class="menu-title">Profil Saya</span>
                </a>
            </li>
            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit" class="nav-link" style="color:#e74a3b !important;">
                        <i class="mdi mdi-logout menu-icon" style="color:var(--danger) !important;"></i>
                        <span class="menu-title" style="color:var(--danger) !important;">Keluar</span>
                    </button>
                </form>
            </li>

        </ul>
    </nav>
    {{-- /sidebar --}}

    {{-- ================================================
         MAIN PANEL
    ================================================ --}}
    <div class="main-panel">
        <div class="content-wrapper">
            @yield('content')
        </div>

        <footer class="footer">
            <div class="row">
                <div class="col-12 text-center text-md-right">
                    <span>© 2026 <strong>LMS SMKN 40 Jakarta</strong>. All rights reserved.</span>
                </div>
            </div>
        </footer>
    </div>

</div>
{{-- /page-body-wrapper --}}

{{-- ================================================
     MOBILE BOTTOM NAV
================================================ --}}
@php
/* Define primary tabs (always visible) */
$primaryTabs = [
    ['url' => route('dashboard'), 'icon' => 'mdi mdi-view-dashboard-outline', 'label' => 'Home', 'active' => request()->routeIs('dashboard')],
];

if(auth()->user()->hasRole('admin')) {
    $primaryTabs[] = ['url' => route('courses.index'),    'icon' => 'mdi mdi-library-outline',           'label' => 'Pelajaran', 'active' => request()->routeIs(['courses.*'])];
    $primaryTabs[] = ['url' => route('students.index'),   'icon' => 'mdi mdi-account-school-outline',     'label' => 'Siswa',     'active' => request()->routeIs(['students.*'])];
    $primaryTabs[] = ['url' => route('attendance.index'), 'icon' => 'mdi mdi-note-check-outline',         'label' => 'Absensi',   'active' => request()->routeIs(['attendance.*'])];
} elseif(auth()->user()->hasRole('instructor')) {
    $primaryTabs[] = ['url' => route('courses.index'), 'icon' => 'mdi mdi-library-outline',          'label' => 'Pelajaran', 'active' => request()->routeIs(['courses.*'])];
    $primaryTabs[] = ['url' => route('tasks.index'),   'icon' => 'mdi mdi-clipboard-check-outline',  'label' => 'Tugas',     'active' => request()->routeIs(['tasks.*'])];
    $primaryTabs[] = ['url' => route('attendance.index'), 'icon' => 'mdi mdi-note-check-outline',    'label' => 'Absensi',   'active' => request()->routeIs(['attendance.*'])];
} elseif(auth()->user()->hasRole('student')) {
    $primaryTabs[] = ['url' => route('courses.index'), 'icon' => 'mdi mdi-library-outline',         'label' => 'Pelajaran', 'active' => request()->routeIs(['courses.*'])];
    $primaryTabs[] = ['url' => route('tasks.index'),   'icon' => 'mdi mdi-clipboard-check-outline', 'label' => 'Tugas',     'active' => request()->routeIs(['tasks.*'])];
    $primaryTabs[] = ['url' => route('quizzes.index'), 'icon' => 'mdi mdi-file-question-outline',   'label' => 'Kuis',      'active' => request()->routeIs(['quizzes.*','quiz.*'])];
}

/* All other items go into "More" drawer */
$drawerItems = [];

if(auth()->user()->hasRole('admin')) {
    $drawerItems = [
        ['url' => route('classrooms.index'),    'icon' => 'mdi mdi-google-classroom',              'label' => 'Kelas',        'active' => request()->routeIs(['classrooms.*'])],
        ['url' => route('instructors.index'),   'icon' => 'mdi mdi-human-male-board',              'label' => 'Guru',         'active' => request()->routeIs(['instructors.*'])],
        ['url' => route('modules.index'),       'icon' => 'mdi mdi-folder-outline',                'label' => 'Modul',        'active' => request()->routeIs(['modules.*'])],
        ['url' => route('lessons.index'),       'icon' => 'mdi mdi-book-open-page-variant-outline','label' => 'Materi',       'active' => request()->routeIs(['lessons.*'])],
        ['url' => route('tasks.index'),         'icon' => 'mdi mdi-clipboard-check-outline',       'label' => 'Tugas',        'active' => request()->routeIs(['tasks.*'])],
        ['url' => route('quizzes.index'),       'icon' => 'mdi mdi-file-question-outline',         'label' => 'Kuis',         'active' => request()->routeIs(['quizzes.*','quiz.*'])],
        ['url' => route('exams.index'),         'icon' => 'mdi mdi-fountain-pen-tip',              'label' => 'Ujian',        'active' => request()->routeIs(['exams.*'])],
        ['url' => route('enrollments.index'),   'icon' => 'mdi mdi-chart-bar',                     'label' => 'Progress',     'active' => request()->routeIs(['enrollments.*'])],
        ['url' => route('ebooks.index'),        'icon' => 'mdi mdi-bookshelf',                     'label' => 'E-Book',       'active' => request()->routeIs(['ebooks.*'])],
        ['url' => route('counseling.index'),    'icon' => 'mdi mdi-chat-outline',                  'label' => 'Konseling',    'active' => request()->routeIs(['counseling.*'])],
        ['url' => route('testimonials.manage'), 'icon' => 'mdi mdi-comment-alert-outline',         'label' => 'Aduan',        'active' => request()->routeIs(['testimonials.*'])],
        ['url' => route('profile.edit'),        'icon' => 'mdi mdi-account-cog-outline',           'label' => 'Profil',       'active' => request()->routeIs(['profile.*'])],
    ];
} elseif(auth()->user()->hasRole('instructor')) {
    $drawerItems = [
        ['url' => route('modules.index'),    'icon' => 'mdi mdi-folder-outline',                'label' => 'Modul',     'active' => request()->routeIs(['modules.*'])],
        ['url' => route('lessons.index'),    'icon' => 'mdi mdi-book-open-page-variant-outline','label' => 'Materi',    'active' => request()->routeIs(['lessons.*'])],
        ['url' => route('quizzes.index'),    'icon' => 'mdi mdi-file-question-outline',         'label' => 'Kuis',      'active' => request()->routeIs(['quizzes.*','quiz.*'])],
        ['url' => route('exams.index'),      'icon' => 'mdi mdi-fountain-pen-tip',              'label' => 'Ujian',     'active' => request()->routeIs(['exams.*'])],
        ['url' => route('ebooks.index'),     'icon' => 'mdi mdi-bookshelf',                     'label' => 'E-Book',    'active' => request()->routeIs(['ebooks.*'])],
        ['url' => route('counseling.index'), 'icon' => 'mdi mdi-chat-outline',                  'label' => 'Konseling', 'active' => request()->routeIs(['counseling.*'])],
        ['url' => route('profile.edit'),     'icon' => 'mdi mdi-account-cog-outline',           'label' => 'Profil',    'active' => request()->routeIs(['profile.*'])],
    ];
} elseif(auth()->user()->hasRole('student')) {
    $drawerItems = [
        ['url' => route('modules.index'),       'icon' => 'mdi mdi-folder-outline',                'label' => 'Modul',     'active' => request()->routeIs(['modules.*'])],
        ['url' => route('lessons.index'),       'icon' => 'mdi mdi-book-open-page-variant-outline','label' => 'Materi',    'active' => request()->routeIs(['lessons.*'])],
        ['url' => route('exams.index'),         'icon' => 'mdi mdi-fountain-pen-tip',              'label' => 'Ujian',     'active' => request()->routeIs(['exams.*'])],
        ['url' => route('enrollments.index'),   'icon' => 'mdi mdi-trending-up',                   'label' => 'Progress',  'active' => request()->routeIs(['enrollments.*'])],
        ['url' => route('ebooks.index'),        'icon' => 'mdi mdi-bookshelf',                     'label' => 'E-Book',    'active' => request()->routeIs(['ebooks.*'])],
        ['url' => route('counseling.index'),    'icon' => 'mdi mdi-chat-outline',                  'label' => 'Konseling', 'active' => request()->routeIs(['counseling.*'])],
        ['url' => route('testimonials.create'), 'icon' => 'mdi mdi-comment-alert-outline',         'label' => 'Aduan',     'active' => request()->routeIs(['testimonials.*'])],
        ['url' => route('profile.edit'),        'icon' => 'mdi mdi-account-cog-outline',           'label' => 'Profil',    'active' => request()->routeIs(['profile.*'])],
    ];
}
@endphp

{{-- Bottom Tab Bar --}}
<div class="mobile-bottom-nav" id="mobileBottomNav">
    <div class="mobile-bottom-nav-track">

        @foreach($primaryTabs as $tab)
        <a href="{{ $tab['url'] }}"
           class="mobile-tab {{ $tab['active'] ? 'active' : '' }}"
           aria-label="{{ $tab['label'] }}">
            <div class="mobile-tab-icon">
                <i class="{{ $tab['icon'] }}"></i>
            </div>
            <span>{{ $tab['label'] }}</span>
        </a>
        @endforeach

        @if(count($drawerItems))
        <button class="mobile-tab mobile-tab-more" id="drawerOpenBtn" aria-label="Lebih banyak">
            <div class="mobile-tab-icon">
                <i class="mdi mdi-dots-grid"></i>
            </div>
            <span>Lainnya</span>
        </button>
        @endif

    </div>
</div>

{{-- More Drawer --}}
@if(count($drawerItems))
<div class="drawer-overlay" id="drawerOverlay"></div>

<div class="more-drawer" id="moreDrawer">
    <div class="drawer-handle"></div>

    <p class="drawer-section-label">Semua Menu</p>

    <div class="drawer-grid">
        @foreach($drawerItems as $item)
        <a href="{{ $item['url'] }}"
           class="drawer-item {{ $item['active'] ? 'active' : '' }}"
           aria-label="{{ $item['label'] }}">
            <i class="{{ $item['icon'] }}"></i>
            <span>{{ $item['label'] }}</span>
        </a>
        @endforeach
    </div>

    {{-- Logout in drawer --}}
    <form method="POST" action="{{ route('logout') }}" style="margin:0;">
        @csrf
        <button type="submit" class="drawer-logout">
            <i class="mdi mdi-logout"></i>
            Keluar dari Akun
        </button>
    </form>
</div>
@endif

</div>
{{-- /container-scroller --}}

{{-- ================================================
     SCRIPTS
================================================ --}}
<script src="{{ asset('skydash/vendors/js/vendor.bundle.base.js') }}"></script>
<script src="{{ asset('skydash/vendors/chart.js/chart.umd.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('skydash/js/template.js') }}"></script>

@stack('scripts')

<script>
/* ============ SWEETALERT FLASH ============ */
@if(session('success'))
    Swal.fire({ position:'center', icon:'success', title:"{{ session('success') }}", showConfirmButton:false, timer:1600 });
@endif
@if(session('error'))
    Swal.fire({ position:'center', icon:'error',   title:"{{ session('error') }}",   showConfirmButton:false, timer:2200 });
@endif
@if(session('info'))
    Swal.fire({ position:'center', icon:'info',    title:"{{ session('info') }}",    showConfirmButton:false, timer:1600 });
@endif

/* ============ DELETE CONFIRM ============ */
function confirmDelete(event, message = 'Data ini akan dihapus secara permanen!') {
    event.preventDefault();
    const form = event.target.closest('form');
    Swal.fire({
        title: 'Hapus data ini?',
        text: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e74a3b',
        cancelButtonColor: '#858796',
        confirmButtonText: '<i class="mdi mdi-delete mr-1"></i>Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then(r => { if (r.isConfirmed && form) form.submit(); });
}

/* ============ MOBILE BOTTOM NAV — auto-hide on scroll down ============ */
(function() {
    const nav = document.getElementById('mobileBottomNav');
    if (!nav) return;

    let lastY = 0, ticking = false;
    let hideTimer = null;

    window.addEventListener('scroll', () => {
        if (!ticking) {
            requestAnimationFrame(() => {
                const y = window.scrollY;
                const delta = y - lastY;

                if (delta > 8 && y > 160) {
                    nav.classList.add('hide');
                } else if (delta < -8) {
                    nav.classList.remove('hide');
                    clearTimeout(hideTimer);
                }
                lastY = y;
                ticking = false;
            });
            ticking = true;
        }
    }, { passive: true });

    /* hide when virtual keyboard opens (viewport shrink heuristic) */
    const baseH = window.innerHeight;
    window.addEventListener('resize', () => {
        if (window.innerHeight < baseH - 150) {
            nav.classList.add('hide');
        } else {
            nav.classList.remove('hide');
        }
    }, { passive: true });
})();

/* ============ MORE DRAWER ============ */
(function() {
    const openBtn  = document.getElementById('drawerOpenBtn');
    const drawer   = document.getElementById('moreDrawer');
    const overlay  = document.getElementById('drawerOverlay');

    if (!openBtn || !drawer) return;

    let startY = 0;

    function open() {
        overlay.style.display = 'block';
        drawer.style.display  = 'block';
        // Double rAF ensures display:block is painted before transition starts
        requestAnimationFrame(() => requestAnimationFrame(() => {
            overlay.style.opacity = '1';
            drawer.classList.add('open');
        }));
        document.body.style.overflow = 'hidden';
        try { if (navigator.vibrate) navigator.vibrate(8); } catch(_) {}
    }

    function close() {
        drawer.classList.remove('open');
        overlay.style.opacity = '0';
        document.body.style.overflow = '';
        setTimeout(() => {
            overlay.style.display = 'none';
            drawer.style.display  = 'none';
        }, 320);
    }

    openBtn.addEventListener('click', open);
    overlay.addEventListener('click', close);

    /* Swipe down to close */
    drawer.addEventListener('touchstart', e => { startY = e.touches[0].clientY; }, { passive:true });
    drawer.addEventListener('touchend', e => {
        if (e.changedTouches[0].clientY - startY > 70) close();
    }, { passive:true });

    /* Close drawer when a link inside is tapped */
    drawer.querySelectorAll('a').forEach(a => {
        a.addEventListener('click', () => close());
    });
})();

/* ============ TAP HAPTIC ============ */
document.querySelectorAll('.mobile-tab, .drawer-item').forEach(el => {
    el.addEventListener('pointerdown', () => {
        try { if (navigator.vibrate) navigator.vibrate(6); } catch(_) {}
    });
});
</script>

</body>
</html>