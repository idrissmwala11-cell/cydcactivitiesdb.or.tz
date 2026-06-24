<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'CYDC') }} - @yield('title', 'Dashboard')</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=20260621b">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v=20260621b">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=20260621b">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}?v=20260621b">

    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @media screen and (min-width: 769px) {
            :root {
                --sidebar-width: 256px;
            }

            html,
            body.admin-layout {
                font-size: 80%;
            }
        }

        @media print {
            html,
            body.admin-layout {
                font-size: 100%;
            }
        }

        table thead th {
            color: #ffffff !important;
            background-color: #111827 !important;
        }

        table tbody td {
            color: #1f2937 !important;
        }

        table tbody tr:hover td {
            background-color: #f9fafb;
            color: #111827 !important;
        }

        .bi,
        .bi::before {
            font-family: "bootstrap-icons" !important;
            font-style: normal !important;
            font-weight: normal !important;
            font-variant: normal !important;
            text-transform: none !important;
            line-height: 1 !important;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        #announcementDropdown .bi-bell,
        #announcementDropdown i {
            color: #111827 !important;
            font-size: 1.35rem !important;
            opacity: 1 !important;
            display: inline-block !important;
            visibility: visible !important;
        }

        #announcementDropdown {
            color: #111827 !important;
            width: 42px;
            height: 42px;
            border-radius: 999px;
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            overflow: visible;
        }

        #announcementUnreadBadge,
        .topbar-unread-badge {
            position: absolute;
            top: -0.2rem;
            right: -0.25rem;
            min-width: 1.25rem;
            height: 1.25rem;
            padding: 0 0.35rem;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.68rem;
            line-height: 1;
            font-weight: 800;
            color: #ffffff;
            background: #dc2626;
            border: 2px solid #ffffff;
            box-shadow: 0 4px 10px rgba(220, 38, 38, 0.3);
            z-index: 20;
        }

        .topbar-icon-link {
            width: 42px;
            height: 42px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            transition: all .2s ease;
        }

        .topbar-icon-link:hover {
            background: #ffffff;
            border-color: #cbd5e1;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.08);
        }

        .topbar-chat-link {
            width: auto;
            min-width: 74px;
            height: auto;
            padding: 0.45rem 0.7rem;
            flex-direction: column;
            gap: 0.2rem;
            text-decoration: none;
        }

        .topbar-chat-link svg {
            display: block;
        }

        .topbar-chat-label {
            font-size: 0.68rem;
            line-height: 1.1;
            font-weight: 600;
            color: #2563eb;
            text-align: center;
            white-space: nowrap;
        }

        .topbar-dashboard-message {
            display: flex;
            align-items: center;
            min-height: 52px;
            padding: 0.65rem 1rem;
            border-radius: 18px;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.08), rgba(99, 102, 241, 0.05));
            border: 1px solid rgba(37, 99, 235, 0.12);
            box-shadow: 0 10px 24px rgba(37, 99, 235, 0.08);
            position: relative;
            overflow: hidden;
            animation: topbarWelcomeFloat 4.8s ease-in-out infinite;
        }

        .topbar-dashboard-message::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg, transparent 0%, rgba(255,255,255,0.45) 32%, transparent 68%);
            transform: translateX(-140%);
            animation: topbarWelcomeShine 6s ease-in-out infinite;
            pointer-events: none;
        }

        .topbar-dashboard-message__content {
            position: relative;
            z-index: 1;
        }

        .topbar-dashboard-message__title {
            font-size: 1.08rem;
            font-weight: 800;
            color: #111827;
            line-height: 1.15;
            margin: 0;
            letter-spacing: -0.02em;
            animation: topbarWelcomeFadeUp 0.85s ease both;
            transform-style: preserve-3d;
            animation:
                topbarWelcomeFadeUp 0.85s ease both,
                topbarWelcomeFlip 5.5s ease-in-out infinite 1.1s;
        }

        .topbar-dashboard-message__title span {
            display: inline-block;
            color: #2563eb;
            text-shadow: 0 0 16px rgba(37, 99, 235, 0.16);
        }

        .topbar-dashboard-message__subtitle {
            font-size: 0.8rem;
            color: #6b7280;
            line-height: 1.2;
            margin-top: 0.26rem;
            animation: topbarWelcomeFadeUp 1s ease both;
        }

        @keyframes topbarWelcomeFadeUp {
            0% {
                opacity: 0;
                transform: translateY(12px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes topbarWelcomeShine {
            0%, 100% {
                transform: translateX(-140%);
            }
            45%, 60% {
                transform: translateX(140%);
            }
        }

        @keyframes topbarWelcomeFloat {
            0%, 100% {
                transform: translateY(0);
                box-shadow: 0 10px 24px rgba(37, 99, 235, 0.08);
            }
            50% {
                transform: translateY(-2px);
                box-shadow: 0 14px 30px rgba(37, 99, 235, 0.12);
            }
        }

        @keyframes topbarWelcomeFlip {
            0%, 100% {
                transform: perspective(800px) rotateX(0deg);
            }
            45% {
                transform: perspective(800px) rotateX(0deg);
            }
            50% {
                transform: perspective(800px) rotateX(12deg);
            }
            55% {
                transform: perspective(800px) rotateX(-10deg);
            }
            60% {
                transform: perspective(800px) rotateX(0deg);
            }
        }

        .sidebar-brand-logo {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.14);
            padding: 5px;
            flex-shrink: 0;
        }

        .sidebar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            border-right: 1px solid rgba(255,255,255,0.14);
            box-shadow: 20px 0 48px rgba(31, 41, 55, 0.28) !important;
            overflow: hidden;
        }

        .sidebar::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                linear-gradient(180deg, rgba(255,255,255,0.08), transparent 16%, transparent 84%, rgba(255,255,255,0.05)),
                repeating-linear-gradient(
                    180deg,
                    rgba(255,255,255,0.03) 0,
                    rgba(255,255,255,0.03) 1px,
                    transparent 1px,
                    transparent 18px
                );
            pointer-events: none;
            opacity: 0;
        }

        .sidebar-header {
            padding: 1.2rem 1rem 1rem !important;
            border-bottom: 1px solid rgba(255,255,255,0.12) !important;
            background: linear-gradient(180deg, rgba(255,255,255,0.08), rgba(255,255,255,0.02));
            backdrop-filter: blur(14px);
        }

        .sidebar-brand {
            width: 100%;
            padding: 0.35rem 0.45rem !important;
            border-radius: 0;
            background: transparent;
            box-shadow: none;
            font-weight: 700 !important;
            letter-spacing: 0.02em;
            display: block;
        }

        .sidebar-brand-text {
            display: flex;
            flex-direction: column;
            min-width: 0;
            line-height: 1.1;
            width: 100%;
        }

        .sidebar-brand-top {
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .sidebar-brand-title {
            font-size: 1.45rem;
            font-weight: 800;
            font-family: 'Inter', sans-serif;
            color: #ffffff;
            margin: 0;
            letter-spacing: -0.03em;
            line-height: 1;
            text-shadow: 0 4px 14px rgba(17, 24, 39, 0.18);
        }

        .sidebar-brand-subtitle {
            display: block;
            margin-top: 0.55rem;
            margin-left: 3.35rem;
            font-size: 0.68rem;
            font-weight: 600;
            line-height: 1.35;
            color: rgba(255,255,255,0.88);
            max-width: 205px;
            white-space: normal;
            letter-spacing: 0.01em;
            text-wrap: balance;
        }

        .sidebar-brand-logo {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            background: linear-gradient(135deg, rgba(255,255,255,0.96), rgba(255,255,255,0.82));
            padding: 4px;
            flex-shrink: 0;
            box-shadow:
                0 10px 24px rgba(17, 24, 39, 0.18),
                inset 0 1px 0 rgba(255,255,255,0.75);
        }

        .sidebar-nav {
            padding: 0.9rem 0.55rem 1.25rem !important;
        }

        .sidebar .nav-item {
            margin: 0.22rem 0 !important;
        }

        .sidebar .nav-link {
            margin: 0 !important;
            padding: 0.82rem 0.95rem !important;
            border-radius: 16px !important;
            font-weight: 600 !important;
            border: 1px solid rgba(255,255,255,0.03);
            transition: all .25s ease !important;
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(10px);
        }

        .sidebar .nav-link::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, rgba(255,255,255,0.12), transparent 62%);
            opacity: 0;
            transition: opacity .25s ease;
            pointer-events: none;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: linear-gradient(135deg, rgba(255,255,255,0.2), rgba(255,255,255,0.08)) !important;
            border-color: rgba(255,255,255,0.16) !important;
            transform: translateX(5px) scale(1.01);
            box-shadow:
                0 14px 26px rgba(37, 45, 96, 0.24),
                inset 0 1px 0 rgba(255,255,255,0.1);
        }

        .sidebar .nav-link:hover::after,
        .sidebar .nav-link.active::after {
            opacity: 1;
        }

        .sidebar .nav-link i {
            width: 24px !important;
            height: 24px !important;
            margin-right: 0.85rem !important;
            border-radius: 999px;
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgba(255,255,255,0.16), rgba(255,255,255,0.06));
            box-shadow:
                inset 0 1px 0 rgba(255,255,255,0.08),
                0 6px 12px rgba(17,24,39,0.12);
            font-size: 0.95rem !important;
        }

        .sidebar .sidebar-heading {
            padding: 0.8rem 0.45rem 0.35rem !important;
            margin-top: 1rem !important;
        }

        .sidebar .sidebar-heading span {
            letter-spacing: 0.18em !important;
            font-size: 0.68rem !important;
            font-weight: 700 !important;
            opacity: 0.82;
        }

        .sidebar .dropdown-toggle {
            border-left: 3px solid transparent !important;
        }

        .sidebar .dropdown-toggle.active {
            border-left-color: #ffffff !important;
        }

        .sidebar .dropdown-menu {
            padding: 0.55rem 0.35rem !important;
            margin: 0.35rem 0.1rem 0.15rem !important;
            border-radius: 18px !important;
            background: linear-gradient(180deg, rgba(17,24,39,0.2), rgba(255,255,255,0.07)) !important;
            border: 1px solid rgba(255,255,255,0.10) !important;
            box-shadow:
                inset 0 1px 0 rgba(255,255,255,0.08),
                0 18px 34px rgba(17,24,39,0.2) !important;
            backdrop-filter: blur(14px);
        }

        .sidebar .dropdown-menu .nav-link {
            padding: 0.72rem 0.9rem !important;
            border-radius: 14px !important;
            font-size: 0.84rem !important;
        }

        .sidebar .dropdown-menu .nav-link:hover,
        .sidebar .dropdown-menu .nav-link.active {
            background: linear-gradient(135deg, rgba(255,255,255,0.18), rgba(255,255,255,0.08)) !important;
            box-shadow: 0 10px 22px rgba(17,24,39,0.16);
        }

        .chat-drawer .offcanvas-header {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: #fff;
        }

        .chat-contact-item.active {
            background: #eff6ff;
            border-color: #bfdbfe;
        }

        .chat-message-bubble {
            max-width: 78%;
            border-radius: 18px;
            padding: 12px 14px;
            box-shadow: 0 6px 18px rgba(15, 23, 42, 0.08);
        }

        .chat-message-mine {
            background: #2563eb;
            color: #fff;
        }

        .chat-message-other {
            background: #fff;
            border: 1px solid #e5e7eb;
            color: #111827;
        }

        .app-auth-footer {
            margin-top: 0;
            background: #1e293b;
            color: white;
            border-top: 1px solid rgba(148, 163, 184, 0.18);
        }

        .app-auth-footer__inner {
            max-width: 100%;
            margin: 0 auto;
            padding: 0.9rem 1.5rem;
            text-align: center;
        }

        .app-auth-footer__inner p {
            margin: 0;
            color: #e2e8f0;
            font-size: 0.9rem;
            white-space: nowrap;
            display: inline-block;
            animation: appFooterTicker 40s linear infinite;
        }

        @keyframes appFooterTicker {
            0% { transform: translateX(-22%); }
            100% { transform: translateX(22%); }
        }

        .sidebar-backdrop {
            display: none;
        }

        @media screen and (max-width: 768px) {
            html,
            body {
                width: 100%;
                max-width: 100%;
                overflow-x: hidden;
            }

            body.mobile-sidebar-open {
                overflow: hidden;
            }

            .sidebar {
                position: fixed !important;
                top: 0;
                left: 0;
                width: min(86vw, 320px) !important;
                height: 100dvh !important;
                z-index: 1060;
                transform: translateX(-105%);
                transition: transform .25s ease;
                overflow-y: auto !important;
                -webkit-overflow-scrolling: touch;
                border-right: 0 !important;
                border-radius: 0 24px 24px 0;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .sidebar-header {
                position: sticky;
                top: 0;
                z-index: 2;
            }

            .sidebar-nav {
                padding-bottom: 5rem !important;
            }

            .sidebar .nav-link:hover,
            .sidebar .nav-link.active {
                transform: none;
            }

            .sidebar-backdrop {
                display: block;
                position: fixed;
                inset: 0;
                background: rgba(15, 23, 42, .48);
                opacity: 0;
                pointer-events: none;
                transition: opacity .2s ease;
                z-index: 1050;
                backdrop-filter: blur(2px);
            }

            .sidebar-backdrop.show {
                opacity: 1;
                pointer-events: auto;
            }

            .main-content {
                margin-left: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
            }

            .main-content > .navbar {
                position: sticky;
                top: 0;
                z-index: 1020;
                margin-bottom: 1rem !important;
            }

            .main-content > .navbar .container-fluid {
                gap: .55rem;
                flex-wrap: nowrap;
                align-items: center;
            }

            #sidebarToggle {
                width: 42px;
                height: 42px;
                border-radius: 12px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                color: #111827;
                background: #f8fafc;
                border: 1px solid #e5e7eb;
                text-decoration: none;
                flex-shrink: 0;
            }

            .navbar-nav.ms-auto {
                gap: .35rem;
                margin-left: auto !important;
                min-width: 0;
            }

            .navbar-nav .nav-item {
                margin-right: .35rem !important;
            }

            .topbar-icon-link,
            #announcementDropdown {
                width: 40px;
                height: 40px;
                min-width: 40px;
                padding: 0 !important;
            }

            .topbar-chat-link {
                min-width: 40px;
                gap: 0;
            }

            .topbar-chat-label,
            .topbar-dashboard-message__subtitle {
                display: none;
            }

            .topbar-dashboard-message {
                min-width: 0;
                flex: 1 1 auto;
                overflow: hidden;
            }

            .topbar-dashboard-message__title {
                max-width: 36vw;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }

            .dropdown-menu[aria-labelledby="announcementDropdown"] {
                width: min(92vw, 340px) !important;
            }

            .container-fluid.px-4 {
                padding-left: .85rem !important;
                padding-right: .85rem !important;
            }

            .card,
            .dashboard-card,
            .rounded-4 {
                border-radius: 16px !important;
            }

            .card-body {
                padding: 1rem !important;
            }

            .row.g-4 {
                --bs-gutter-x: .85rem;
                --bs-gutter-y: .85rem;
            }

            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .table-responsive table {
                min-width: 720px;
            }

            .btn,
            .form-control,
            .form-select {
                min-height: 42px;
            }

            .chat-drawer {
                width: min(100vw, 420px) !important;
            }
        }

    </style>

    <script src="{{ asset('js/search-test.js') }}"></script>
</head>
<body @class(['admin-layout' => auth()->check() && auth()->user()->role === 'admin'])>
@auth
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('dashboard') }}" class="sidebar-brand">
                <span class="sidebar-brand-text">
                    <span class="sidebar-brand-top">
                        <span class="sidebar-brand-title">CYDC</span>
                        <x-application-logo class="sidebar-brand-logo" />
                    </span>
                    <span class="sidebar-brand-subtitle">{{ __('ui.brand_subtitle') }}</span>
                </span>
            </a>
        </div>

        <div class="sidebar-nav">
            <ul class="nav flex-column">

                {{-- Dashboard --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2"></i>
                        <span>{{ __('ui.dashboard') }}</span>
                    </a>
                </li>

                {{-- Admin Panel --}}
                @if(auth()->user()->role === 'admin')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-gear"></i>
                            <span>{{ __('ui.admin_panel') }}</span>
                        </a>
                    </li>
                @endif

                {{-- Programs --}}
                <li class="nav-item">
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>{{ __('ui.programs') }}</span>
                    </h6>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home-visitation.*') ? 'active' : '' }}" href="{{ route('home-visitation.index') }}">
                        <i class="bi bi-house-door"></i>
                        <span>{{ __('ui.home_visitation') }}</span>
                    </a>
                </li>

                {{-- Program Day --}}
                <li class="nav-item dropdown-nav">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('submissions.*') || request()->routeIs('admin.masomo-ya-mtaala.*') || request()->routeIs('admin.masomo-ya-fani.*') || request()->routeIs('parents-information.*') || request()->routeIs('saving-groups.*') ? 'active' : '' }}"
                       href="#"
                       onclick="toggleDropdown(event, this)">
                        <i class="bi bi-calendar-event"></i>
                        <span>{{ __('ui.program_day') }}</span>
                        <i class="bi bi-chevron-down ms-auto dropdown-arrow"></i>
                    </a>

                    <ul class="dropdown-menu">
                        <li class="nav-item">
                            @if(auth()->user()->role === 'admin')
                                <a class="nav-link {{ request()->routeIs('admin.masomo-ya-mtaala.*') ? 'active' : '' }}"
                                   href="{{ route('admin.masomo-ya-mtaala.index') }}">
                                    <i class="bi bi-book me-2"></i>{{ __('ui.curriculum_studies') }}
                                </a>
                            @else
                                <a class="nav-link {{ request()->routeIs('submissions.masomo-ya-mtaala.*') ? 'active' : '' }}"
                                   href="{{ route('submissions.masomo-ya-mtaala.index') }}">
                                    <i class="bi bi-book me-2"></i>{{ __('ui.curriculum_studies') }}
                                </a>
                            @endif
                        </li>

                        <li class="nav-item">
                            @if(auth()->user()->role === 'admin')
                                <a class="nav-link {{ request()->routeIs('admin.masomo-ya-fani.*') ? 'active' : '' }}"
                                   href="{{ route('admin.masomo-ya-fani.index') }}">
                                    <i class="bi bi-pencil me-2"></i>{{ __('ui.vocational_skills') }}
                                </a>
                            @else
                                <a class="nav-link {{ request()->routeIs('submissions.masomo-ya-fani.*') ? 'active' : '' }}"
                                   href="{{ route('submissions.masomo-ya-fani.index') }}">
                                    <i class="bi bi-pencil me-2"></i>{{ __('ui.vocational_skills') }}
                                </a>
                            @endif
                        </li>

                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center {{ request()->routeIs('submissions.special-program.*') ? 'active fw-bold text-primary' : 'text-dark' }}"
                               href="{{ route('submissions.special-program.index') }}"
                               style="transition: all 0.3s ease;">
                                <i class="bi bi-star me-2 {{ request()->routeIs('submissions.special-program.*') ? 'text-warning' : '' }}"></i>
                                <span>{{ __('ui.special_program') }}</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('parents-information.*') ? 'active' : '' }}"
                               href="{{ route('parents-information.index') }}">
                                <i class="bi bi-people me-2"></i>{{ __('ui.parents') }}
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('saving-groups.*') ? 'active' : '' }}"
                               href="{{ route('saving-groups.index') }}">
                                <i class="bi bi-piggy-bank me-2"></i>{{ __('ui.savings_groups') }}
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Attendance --}}
                <li class="nav-item dropdown-nav">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('*-attendance.*') ? 'active' : '' }}"
                       href="#"
                       onclick="toggleDropdown(event, this)">
                        <i class="bi bi-calendar-check"></i>
                        <span>{{ __('ui.attendance') }}</span>
                        <i class="bi bi-chevron-down ms-auto dropdown-arrow"></i>
                    </a>

                    <ul class="dropdown-menu">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('skills-attendance.*') ? 'active' : '' }}" href="{{ route('skills-attendance.index') }}">
                                <i class="bi bi-tools me-2"></i>{{ __('ui.skills_attendance') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('curriculum-attendance.*') ? 'active' : '' }}" href="{{ route('curriculum-attendance.index') }}">
                                <i class="bi bi-journal-check me-2"></i>{{ __('ui.curriculum_attendance') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('talent-attendance.*') ? 'active' : '' }}" href="{{ route('talent-attendance.index') }}">
                                <i class="bi bi-star me-2"></i>{{ __('ui.talent_attendance') }}
                            </a>
                        </li>
                    </ul>
                </li>

{{-- School Information --}}
<li class="nav-item dropdown-nav">
    <a class="nav-link dropdown-toggle {{ request()->routeIs('school-info.*') ? 'active' : '' }}"
       href="#"
       onclick="toggleDropdown(event, this)">
        <i class="bi bi-building"></i>
        <span>{{ __('ui.school_information') }}</span>
        <i class="bi bi-chevron-down ms-auto dropdown-arrow"></i>
    </a>

    <ul class="dropdown-menu">

        {{-- PRIMARY --}}
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('school-info.primary.*') ? 'active' : '' }}"
               href="{{ route('school-info.primary.index') }}">
                <i class="bi bi-mortarboard me-2"></i>Primary
            </a>
        </li>

        {{-- SECONDARY --}}
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('school-info.secondary.*') ? 'active' : '' }}"
               href="{{ route('school-info.secondary.index') }}">
                <i class="bi bi-book me-2"></i>Secondary
            </a>
        </li>

        {{-- A LEVEL --}}
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('school-info.a-level.*') ? 'active' : '' }}"
               href="{{ route('school-info.a-level.index') }}">
                <i class="bi bi-bank me-2"></i>A Level
            </a>
        </li>

        {{-- UNIVERSITY --}}
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('school-info.university.*') ? 'active' : '' }}"
               href="{{ route('school-info.university.index') }}">
                <i class="bi bi-mortarboard-fill me-2"></i>University
            </a>
        </li>

        {{-- COLLEGE --}}
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('school-info.college.*') ? 'active' : '' }}"
               href="{{ route('school-info.college.index') }}">
                <i class="bi bi-award me-2"></i>College
            </a>
        </li>

        {{-- VOCATIONAL --}}
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('school-info.vocational-training.*') ? 'active' : '' }}"
               href="{{ route('school-info.vocational-training.index') }}">
                <i class="bi bi-tools me-2"></i>Vocational Training
            </a>
        </li>

        {{-- OTHERS --}}
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('school-info.others.*') ? 'active' : '' }}"
               href="{{ route('school-info.others.index') }}">
                <i class="bi bi-three-dots me-2"></i>Others
            </a>
        </li>

    </ul>
</li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('school-visitation.*') ? 'active' : '' }}"
                       href="{{ route('school-visitation.index') }}">
                        <i class="bi bi-building-check"></i>
                        <span>{{ __('ui.school_visitation') }}</span>
                    </a>
                </li>

                @if(config('features.local_sponsorship_visible'))
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('local-sponsorship.*') ? 'active' : '' }}"
                           href="{{ route('local-sponsorship.index') }}">
                            <i class="bi bi-heart"></i>
                            <span>{{ __('ui.local_sponsorship') }}</span>
                        </a>
                    </li>
                @endif

                <li class="nav-item dropdown-nav">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('exam-results.*') || request()->routeIs('form-two-results.*') ? 'active' : '' }}"
                       href="#"
                       onclick="toggleDropdown(event, this)">
                        <i class="bi bi-clipboard-data"></i>
                        <span>{{ __('ui.exam_results') }}</span>
                        <i class="bi bi-chevron-down ms-auto dropdown-arrow"></i>
                    </a>

                    <ul class="dropdown-menu">
                        @if(auth()->user()->canAccessFormTwoResults())
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('form-two-results.*') ? 'active' : '' }}"
                               href="{{ route('form-two-results.index') }}">
                                <i class="bi bi-file-earmark-spreadsheet me-2"></i>Results 2026
                            </a>
                        </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('exam-results.primary.*') ? 'active' : '' }}"
                               href="{{ route('exam-results.primary.index') }}">
                                <i class="bi bi-1-circle me-2"></i>Primary
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('exam-results.secondary.*') ? 'active' : '' }}"
                               href="{{ route('exam-results.secondary.index') }}">
                                <i class="bi bi-2-circle me-2"></i>Secondary
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('exam-results.a-level.*') ? 'active' : '' }}"
                               href="{{ route('exam-results.a-level.index') }}">
                                <i class="bi bi-3-circle me-2"></i>A Level
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('exam-results.college.*') ? 'active' : '' }}"
                               href="{{ route('exam-results.college.index') }}">
                                <i class="bi bi-mortarboard me-2"></i>College
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('exam-results.university.*') ? 'active' : '' }}"
                               href="{{ route('exam-results.university.index') }}">
                                <i class="bi bi-bank me-2"></i>University
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Leadership Information --}}
                <li class="nav-item dropdown-nav">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('center-leadership.*') || request()->routeIs('cluster-leadership.*') || request()->routeIs('base-leaders.*') || request()->routeIs('national-leadership.*') || request()->routeIs('out-of-ministry-leadership.*') ? 'active' : '' }}"
                       href="#"
                       onclick="toggleDropdown(event, this)">
                        <i class="bi bi-people-fill"></i>
                        <span>{{ __('ui.leadership_information') }}</span>
                        <i class="bi bi-chevron-down ms-auto dropdown-arrow"></i>
                    </a>

                    <ul class="dropdown-menu">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('center-leadership.*') ? 'active' : '' }}" href="{{ route('center-leadership.index') }}">
                                <i class="bi bi-geo-alt me-2"></i>Center
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('cluster-leadership.*') ? 'active' : '' }}" href="{{ route('cluster-leadership.index') }}">
                                <i class="bi bi-diagram-3 me-2"></i>Cluster
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('base-leaders.*') ? 'active' : '' }}" href="{{ route('base-leaders.index') }}">
                                <i class="bi bi-house me-2"></i>Base
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('national-leadership.*') ? 'active' : '' }}" href="{{ route('national-leadership.index') }}">
                                <i class="bi bi-flag me-2"></i>National
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('out-of-ministry-leadership.*') ? 'active' : '' }}" href="{{ route('out-of-ministry-leadership.index') }}">
                                <i class="bi bi-building me-2"></i>Out of CY Ministry
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Reports --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}">
                        <i class="bi bi-file-earmark-text me-2"></i>
                        <span>{{ __('ui.reports') }}</span>
                    </a>
                </li>
                
                @if(Auth::check() && Auth::user()->role === 'admin')
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.performance-report.*') ? 'active' : '' }}"
           href="{{ route('admin.performance-report.index') }}">
            📊 Center Performance Report
        </a>
    </li>
@endif

                {{-- Data Entry --}}
                @if(auth()->user()->role !== 'admin')
                    <li class="nav-item">
                        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                            <span>{{ __('ui.data_entry') }}</span>
                        </h6>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('talent-attendance.*') ? 'active' : '' }}" href="{{ route('talent-attendance.index') }}">
                            <i class="bi bi-calendar-check"></i>
                            <span>{{ __('ui.talent_attendance') }}</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('skills-attendance.*') ? 'active' : '' }}" href="{{ route('skills-attendance.index') }}">
                            <i class="bi bi-calendar2-check"></i>
                            <span>{{ __('ui.skills_attendance') }}</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('curriculum-attendance.*') ? 'active' : '' }}" href="{{ route('curriculum-attendance.index') }}">
                            <i class="bi bi-journal-check"></i>
                            <span>{{ __('ui.curriculum_attendance') }}</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('talents.*') ? 'active' : '' }}" href="{{ route('talents.index') }}">
                            <i class="bi bi-star"></i>
                            <span>{{ __('ui.talents_information') }}</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('skills-information.*') ? 'active' : '' }}" href="{{ route('skills-information.index') }}">
                            <i class="bi bi-tools"></i>
                            <span>{{ __('ui.skills_information') }}</span>
                        </a>
                    </li>

                    {{-- Improved Skills to Learn --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('skills-to-learn.videos') ? 'active' : '' }}"
                           href="{{ route('skills-to-learn.videos') }}">
                            <i class="bi bi-play-circle"></i>
                            <span>{{ __('ui.skills_to_learn') }}</span>
                        </a>
                    </li>
                @endif

                {{-- Admin Data Management --}}
                @if(auth()->user()->role === 'admin')
                    <li class="nav-item">
                        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                            <span>{{ __('ui.data_management') }}</span>
                        </h6>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.submissions.*') ? 'active' : '' }}"
                           href="{{ route('admin.submissions.index') }}">
                            <i class="bi bi-calendar-event"></i>
                            <span>{{ __('ui.manage_submissions') }}</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}"
                           href="{{ route('admin.announcements.index') }}">
                            <i class="bi bi-megaphone"></i>
                            <span>{{ __('ui.announcements') }}</span>
                        </a>
                    </li>

                    {{-- Improved Skills to Learn for Admin --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.skill-videos.*') ? 'active' : '' }}"
                           href="{{ route('admin.skill-videos.index') }}">
                            <i class="bi bi-camera-video"></i>
                            <span>{{ __('ui.skills_to_learn_videos') }}</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('talent-attendance.*') ? 'active' : '' }}" href="{{ route('talent-attendance.index') }}">
                            <i class="bi bi-calendar-check"></i>
                            <span>{{ __('ui.all_talent_attendance') }}</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('skills-attendance.*') ? 'active' : '' }}" href="{{ route('skills-attendance.index') }}">
                            <i class="bi bi-calendar2-check"></i>
                            <span>{{ __('ui.all_skills_attendance') }}</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('curriculum-attendance.*') ? 'active' : '' }}" href="{{ route('curriculum-attendance.index') }}">
                            <i class="bi bi-journal-check"></i>
                            <span>{{ __('ui.all_curriculum_data') }}</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('talents.*') ? 'active' : '' }}" href="{{ route('talents.index') }}">
                            <i class="bi bi-star"></i>
                            <span>{{ __('ui.all_talents_data') }}</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('skills-information.*') ? 'active' : '' }}" href="{{ route('skills-information.index') }}">
                            <i class="bi bi-tools"></i>
                            <span>{{ __('ui.all_skills_data') }}</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('parents-information.*') ? 'active' : '' }}" href="{{ route('parents-information.index') }}">
                            <i class="bi bi-people"></i>
                            <span>{{ __('ui.all_parents_data') }}</span>
                        </a>
                    </li>
                @endif

                {{-- Logout --}}
                <li class="nav-item mt-4">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>{{ __('ui.logout') }}</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>
    <div class="sidebar-backdrop" id="sidebarBackdrop" aria-hidden="true"></div>

    <div class="main-content" id="main-content">
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
            <div class="container-fluid">
                <button class="btn btn-link d-md-none" type="button" id="sidebarToggle">
                    <i class="bi bi-list"></i>
                </button>

                @if(auth()->user()->role !== 'admin' && request()->routeIs('dashboard'))
                    <div class="topbar-dashboard-message ms-2 ms-md-0">
                        <x-user-avatar :user="auth()->user()" :size="38" class="me-2" />
                        <div class="topbar-dashboard-message__content">
                            <p class="topbar-dashboard-message__title mb-0">
                                {{ __('ui.welcome_back') }}, <span>{{ auth()->user()->center_id ?? __('ui.no_center_id') }}</span>
                            </p>
                            <div class="topbar-dashboard-message__subtitle">
                                {{ __('ui.personal_dashboard') }}
                            </div>
                        </div>
                    </div>
                @endif

                <div class="navbar-nav ms-auto d-flex flex-row align-items-center">

                    {{-- Chat Button --}}
                    <div class="nav-item me-3">
                        <a class="nav-link position-relative px-0 topbar-icon-link topbar-chat-link"
                           href="#"
                           id="chatDrawerToggle"
                           data-bs-toggle="offcanvas"
                           data-bs-target="#chatDrawer"
                           aria-controls="chatDrawer"
                           title="Chat">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#2563eb" viewBox="0 0 16 16" aria-hidden="true">
                                <path d="M8 3a5 5 0 0 0-4.546 2.914A4.5 4.5 0 0 0 2 9.5c0 1.61.866 3.023 2.154 3.808.187.114.355.285.425.49l.35 1.022a.5.5 0 0 0 .73.27l1.166-.63a.996.996 0 0 1 .626-.105c.18.03.364.045.55.045 3.314 0 6-2.239 6-5s-2.686-5-6-5"/>
                                <path d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0m3 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m3 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                            </svg>
                            <span class="topbar-chat-label">{{ auth()->user()->role === 'admin' ? __('ui.chat_with_user') : __('ui.chat_with_admin') }}</span>

                            @if(($chatUnreadCount ?? 0) > 0)
                                <span class="topbar-unread-badge">
                                    {{ $chatUnreadCount > 99 ? '99+' : $chatUnreadCount }}
                                </span>
                            @endif
                        </a>
                    </div>

                    {{-- Notification Bell --}}
                    <div class="nav-item dropdown me-3">
                        <a class="nav-link position-relative px-2"
                           href="#"
                           id="announcementDropdown"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false">
                            <i class="bi bi-bell fs-5 text-dark"></i>

                            @if(($announcementCount ?? 0) > 0)
                                <span id="announcementUnreadBadge" class="topbar-unread-badge">
                                    {{ $announcementCount > 99 ? '99+' : $announcementCount }}
                                </span>
                            @endif
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow border-0"
                            aria-labelledby="announcementDropdown"
                            style="width: 320px;">
                            <li class="dropdown-header fw-bold">{{ __('ui.notifications') }}</li>

                            @forelse($latestAnnouncements ?? [] as $announcement)
                                <li>
                                    <a href="{{ route('announcements.show', $announcement->id) }}"
                                       class="dropdown-item border-bottom py-2"
                                       style="white-space: normal; text-decoration: none;">
                                        <div class="fw-semibold text-dark" style="word-break: break-word;">
                                            {{ $announcement->title }}
                                        </div>

                                        <div class="small text-muted" style="word-break: break-word;">
                                            {{ \Illuminate\Support\Str::limit($announcement->message, 80) }}
                                        </div>

                                        <div class="small text-secondary mt-1">
                                            {{ $announcement->created_at->format('d M Y H:i') }}
                                        </div>
                                    </a>
                                </li>
                            @empty
                                <li>
                                    <span class="dropdown-item-text text-muted px-3 py-2 d-block">
                                        No notifications available right now.
                                    </span>
                                </li>
                            @endforelse

                            <li><hr class="dropdown-divider"></li>

                            <li>
                                @if(auth()->user()->role === 'admin')
                                    <a class="dropdown-item text-center fw-semibold"
                                       href="{{ route('admin.announcements.index') }}">
                                        {{ __('ui.view_all_announcements') }}
                                    </a>
                                @else
                                    <span class="dropdown-item-text text-center text-muted d-block">
                                        {{ __('ui.latest_announcements') }}
                                    </span>
                                @endif
                            </li>
                        </ul>
                    </div>

                    {{-- Profile Dropdown --}}
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <x-user-avatar :user="auth()->user()" :size="32" class="border border-white shadow me-2" />

                            <span class="text-dark fw-semibold">
                                {{ auth()->user()->center_id ?? 'No Center ID' }}
                            </span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="bi bi-person me-2"></i>{{ __('ui.profile') }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#" onclick="alert('Settings feature is coming soon!')">
                                    <i class="bi bi-gear me-2"></i>{{ __('ui.settings') }}
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right me-2"></i>{{ __('ui.logout') }}
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </nav>

        <div class="container-fluid px-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{ $slot ?? '' }}
            @yield('content')
        </div>
    </div>

    <footer class="app-auth-footer">
        <div class="app-auth-footer__inner">
            <p>Developed and maintained by Idriss ICT Services. &copy; 2025 CYDC. All rights reserved.</p>
        </div>
    </footer>

    <div class="offcanvas offcanvas-end chat-drawer" tabindex="-1" id="chatDrawer" aria-labelledby="chatDrawerLabel" style="width: 420px;">
        <div class="offcanvas-header">
            <div>
                <h5 class="offcanvas-title mb-0" id="chatDrawerLabel">
                    <i class="bi bi-chat-dots me-2"></i>{{ __('ui.chat') }}
                </h5>
                <small class="opacity-75">{{ auth()->user()->role === 'admin' ? __('ui.chat_with_users') : __('ui.chat_with_admin_small') }}</small>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0">
            <div class="d-flex flex-column h-100">
                <div class="border-bottom p-3 bg-light">
                    <div class="small text-muted mb-2">{{ auth()->user()->role === 'admin' ? 'Choose a user' : 'Admin contact' }}</div>
                    <div id="chatContacts" class="d-flex flex-column gap-2"></div>
                </div>

                <div id="chatSelectedContact" class="px-3 py-2 border-bottom bg-white small text-muted">
                    Loading chat...
                </div>

                <div id="chatMessagesContainer" class="flex-grow-1 p-3" style="background:#f8fafc; overflow-y:auto; min-height:260px;"></div>

                <div class="border-top p-3 bg-white">
                    <form id="chatMessageForm">
                        <input type="hidden" id="chatRecipientId" name="recipient_id">
                        <label for="chatMessageInput" class="form-label small text-muted mb-1">Message</label>
                        <textarea id="chatMessageInput" name="message" rows="2" class="form-control mb-2" placeholder="Type your message here..."></textarea>
                        <div class="d-flex justify-content-between align-items-center gap-2">
                            <a href="{{ route('chat.index') }}" class="btn btn-light border">Open Full Chat</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send me-1"></i>Send
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="min-vh-100 d-flex align-items-center justify-content-center bg-light">
        {{ $slot ?? '' }}
        @yield('content')
    </div>
@endauth

<script>
    function closeSidebarDropdown(toggle, dropdownMenu) {
        dropdownMenu.classList.remove('show');
        toggle.classList.remove('active');
        toggle.setAttribute('aria-expanded', 'false');
    }

    function openSidebarDropdown(toggle, dropdownMenu) {
        document.querySelectorAll('.sidebar .dropdown-menu.show').forEach(function(menu) {
            if (menu !== dropdownMenu) {
                const otherToggle = menu.previousElementSibling;
                if (otherToggle) {
                    closeSidebarDropdown(otherToggle, menu);
                }
                menu.querySelectorAll('.nav-item').forEach(function(item) {
                    item.style.animation = 'none';
                    setTimeout(() => {
                        item.style.animation = '';
                    }, 50);
                });
            }
        });

        document.querySelectorAll('.sidebar .dropdown-toggle.active').forEach(function(otherToggle) {
            if (otherToggle !== toggle) {
                otherToggle.classList.remove('active');
                otherToggle.setAttribute('aria-expanded', 'false');
            }
        });

        dropdownMenu.classList.add('show');
        toggle.classList.add('active');
        toggle.setAttribute('aria-expanded', 'true');

        setTimeout(() => {
            dropdownMenu.querySelectorAll('.nav-item').forEach(function(item, index) {
                item.style.animationDelay = `${0.1 + (index * 0.05)}s`;
            });
        }, 10);
    }

    function toggleDropdown(e, element) {
        e.preventDefault();

        const dropdownMenu = element.nextElementSibling;
        const isCurrentlyOpen = dropdownMenu.classList.contains('show');

        if (!isCurrentlyOpen) {
            openSidebarDropdown(element, dropdownMenu);
        } else {
            closeSidebarDropdown(element, dropdownMenu);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.sidebar .dropdown-nav').forEach(function(dropdownNav) {
            const toggle = dropdownNav.querySelector('.dropdown-toggle');
            const dropdownMenu = dropdownNav.querySelector('.dropdown-menu');

            if (!toggle || !dropdownMenu) {
                return;
            }

            toggle.setAttribute('role', 'button');
            toggle.setAttribute('aria-expanded', 'false');
            toggle.setAttribute('tabindex', '0');

            toggle.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    toggleDropdown(e, this);
                }
            });

        });

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.dropdown-nav')) {
                document.querySelectorAll('.sidebar .dropdown-menu.show').forEach(function(menu) {
                    const toggle = menu.previousElementSibling;
                    if (toggle) {
                        closeSidebarDropdown(toggle, menu);
                    } else {
                        menu.classList.remove('show');
                    }
                });
                document.querySelectorAll('.sidebar .dropdown-toggle.active').forEach(function(toggle) {
                    toggle.classList.remove('active');
                    toggle.setAttribute('aria-expanded', 'false');
                });
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const sidebarBackdrop = document.getElementById('sidebarBackdrop');
        const mobileBreakpoint = window.matchMedia('(max-width: 768px)');

        function openMobileSidebar() {
            sidebar?.classList.add('show');
            sidebarBackdrop?.classList.add('show');
            document.body.classList.add('mobile-sidebar-open');
        }

        function closeMobileSidebar() {
            sidebar?.classList.remove('show');
            sidebarBackdrop?.classList.remove('show');
            document.body.classList.remove('mobile-sidebar-open');
        }

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function() {
                if (sidebar?.classList.contains('show')) {
                    closeMobileSidebar();
                } else {
                    openMobileSidebar();
                }
            });
        }

        sidebarBackdrop?.addEventListener('click', closeMobileSidebar);

        sidebar?.querySelectorAll('a.nav-link:not(.dropdown-toggle), button.nav-link').forEach(function(item) {
            item.addEventListener('click', function() {
                if (mobileBreakpoint.matches) {
                    closeMobileSidebar();
                }
            });
        });

        mobileBreakpoint.addEventListener?.('change', function(event) {
            if (! event.matches) {
                closeMobileSidebar();
            }
        });

        const collapseElements = document.querySelectorAll('[data-bs-toggle="collapse"]');
        collapseElements.forEach(element => {
            element.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    if (window.bootstrap && window.bootstrap.Collapse) {
                        new window.bootstrap.Collapse(target, {
                            toggle: true
                        });
                    } else {
                        target.classList.toggle('show');
                    }
                }
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const announcementDropdown = document.getElementById('announcementDropdown');
        const announcementMarkReadUrl = @json(route('announcements.mark-all-read'));
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        if (announcementDropdown && announcementMarkReadUrl) {
            announcementDropdown.addEventListener('show.bs.dropdown', async function () {
                try {
                    const response = await fetch(announcementMarkReadUrl, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    });

                    if (!response.ok) {
                        throw new Error('Failed to mark announcements as read');
                    }

                    const data = await response.json();
                    const badge = document.getElementById('announcementUnreadBadge');

                    if ((data.unread_count || 0) <= 0) {
                        badge?.remove();
                    } else if (badge) {
                        badge.textContent = data.unread_count > 99 ? '99+' : String(data.unread_count);
                    }
                } catch (error) {
                    console.error(error);
                }
            });
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        const drawer = document.getElementById('chatDrawer');
        const contactsEl = document.getElementById('chatContacts');
        const selectedContactEl = document.getElementById('chatSelectedContact');
        const messagesEl = document.getElementById('chatMessagesContainer');
        const formEl = document.getElementById('chatMessageForm');
        const recipientIdEl = document.getElementById('chatRecipientId');
        const messageInputEl = document.getElementById('chatMessageInput');
        const chatToggle = document.getElementById('chatDrawerToggle');

        if (!drawer || !contactsEl || !selectedContactEl || !messagesEl || !formEl || !recipientIdEl || !messageInputEl) {
            return;
        }

        const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        const dataUrl = @json(route('chat.data'));
        const sendUrl = @json(route('chat.store'));
        let selectedUserId = null;
        let pollTimer = null;
        let lastUnreadCount = 0;
        let lastMessageId = 0;
        let isDrawerOpen = false;

        function escapeHtml(value) {
            return String(value ?? '')
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", '&#039;');
        }

        function chatAvatar(person, size = 34) {
            const initials = escapeHtml(person.initials || person.sender_initials || 'U');
            const avatarUrl = person.avatar_url || person.sender_avatar_url;
            const isOnline = Boolean(person.is_online || person.sender_is_online);
            const image = avatarUrl
                ? `<img src="${escapeHtml(avatarUrl)}" alt="" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover" onerror="this.style.display='none'">`
                : '';
            const onlineDot = isOnline
                ? `<span title="Online" aria-label="Online" style="position:absolute;right:0;bottom:0;width:${Math.max(8, Math.round(size * .28))}px;height:${Math.max(8, Math.round(size * .28))}px;border-radius:999px;background:#22c55e;border:2px solid #fff;box-shadow:0 0 0 2px rgba(34,197,94,.18);z-index:2"></span>`
                : '';

            return `<span class="d-inline-flex align-items-center justify-content-center rounded-circle overflow-hidden flex-shrink-0" style="width:${size}px;height:${size}px;position:relative;background:linear-gradient(135deg,#0f766e,#2563eb);color:#fff;font-weight:700;font-size:${Math.max(10, Math.round(size * .34))}px"><span>${initials}</span>${image}${onlineDot}</span>`;
        }

        function playBeep() {
            try {
                const audioContext = new (window.AudioContext || window.webkitAudioContext)();
                const oscillator = audioContext.createOscillator();
                const gainNode = audioContext.createGain();
                oscillator.connect(gainNode);
                gainNode.connect(audioContext.destination);
                oscillator.type = 'sine';
                oscillator.frequency.value = 880;
                gainNode.gain.setValueAtTime(0.0001, audioContext.currentTime);
                gainNode.gain.exponentialRampToValueAtTime(0.08, audioContext.currentTime + 0.02);
                gainNode.gain.exponentialRampToValueAtTime(0.0001, audioContext.currentTime + 0.18);
                oscillator.start();
                oscillator.stop(audioContext.currentTime + 0.2);
            } catch (e) {
                console.warn('Chat beep failed', e);
            }
        }

        function updateTopbarBadge(count) {
            if (!chatToggle) return;
            let badge = chatToggle.querySelector('.badge');
            if (count > 0) {
                if (!badge) {
                    badge = document.createElement('span');
                    badge.className = 'topbar-unread-badge';
                    chatToggle.appendChild(badge);
                }
                badge.textContent = count > 99 ? '99+' : String(count);
            } else if (badge) {
                badge.remove();
            }
        }

        function renderContacts(contacts, selectedContact) {
            contactsEl.innerHTML = '';

            if (!contacts.length) {
                contactsEl.innerHTML = '<div class="text-muted small">No contacts available to chat with right now.</div>';
                return;
            }

            contacts.forEach(contact => {
                const item = document.createElement('button');
                item.type = 'button';
                item.className = `btn btn-light border text-start w-100 chat-contact-item ${selectedContact && selectedContact.id === contact.id ? 'active' : ''}`;
                item.innerHTML = `
                    <div class="d-flex justify-content-between align-items-start gap-2">
                        <div class="d-flex align-items-center gap-2">
                            ${chatAvatar(contact, 38)}
                            <div>
                                <div class="fw-semibold">${escapeHtml(contact.name)}</div>
                                <div class="small text-muted">${escapeHtml(contact.email)}</div>
                            </div>
                        </div>
                        ${contact.unread_count > 0 ? `<span class="badge bg-danger rounded-pill">${contact.unread_count > 99 ? '99+' : contact.unread_count}</span>` : ''}
                    </div>
                `;
                item.addEventListener('click', function () {
                    selectedUserId = contact.id;
                    loadChatData();
                });
                contactsEl.appendChild(item);
            });
        }

        function renderMessages(messages) {
            if (!messages.length) {
                messagesEl.innerHTML = '<div class="h-100 d-flex align-items-center justify-content-center text-muted">No messages yet. Start typing below.</div>';
                return;
            }

            messagesEl.innerHTML = messages.map(message => `
                <div class="d-flex mb-3 ${message.mine ? 'justify-content-end' : 'justify-content-start'}">
                    ${message.mine ? '' : `<span class="me-2 mt-1">${chatAvatar(message, 30)}</span>`}
                    <div class="chat-message-bubble ${message.mine ? 'chat-message-mine' : 'chat-message-other'}">
                        <div class="small ${message.mine ? 'text-white-50' : 'text-muted'} mb-1">${message.mine ? 'You' : escapeHtml(message.sender_name)}</div>
                        <div style="white-space: pre-wrap;">${escapeHtml(message.message)}</div>
                        <div class="small mt-2 ${message.mine ? 'text-white-50' : 'text-muted'}">${escapeHtml(message.created_at || '')}</div>
                    </div>
                    ${message.mine ? `<span class="ms-2 mt-1">${chatAvatar(message, 30)}</span>` : ''}
                </div>
            `).join('');

            messagesEl.scrollTop = messagesEl.scrollHeight;

            const latest = messages[messages.length - 1];
            if (latest && latest.id > lastMessageId) {
                if (lastMessageId !== 0 && !latest.mine) {
                    playBeep();
                }
                lastMessageId = latest.id;
            }
        }

        async function loadChatData() {
            try {
                const url = new URL(dataUrl, window.location.origin);
                if (selectedUserId) {
                    url.searchParams.set('user', selectedUserId);
                }

                const response = await fetch(url.toString(), {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error('Failed to load chat data');
                }

                const data = await response.json();

                if (data.selected_contact) {
                    selectedUserId = data.selected_contact.id;
                    recipientIdEl.value = data.selected_contact.id;
                    selectedContactEl.innerHTML = `<div class="d-flex align-items-center gap-2">${chatAvatar(data.selected_contact, 38)}<div><div class="fw-semibold text-dark">${escapeHtml(data.selected_contact.name)}</div><div class="small text-muted">${escapeHtml(data.selected_contact.email)}</div></div></div>`;
                } else {
                    selectedContactEl.textContent = 'No contact selected.';
                    recipientIdEl.value = '';
                }

                renderContacts(data.contacts || [], data.selected_contact || null);
                renderMessages(data.messages || []);

                if ((data.chat_unread_count || 0) > lastUnreadCount && !isDrawerOpen) {
                    playBeep();
                }

                lastUnreadCount = data.chat_unread_count || 0;
                updateTopbarBadge(lastUnreadCount);
            } catch (error) {
                console.error(error);
                selectedContactEl.textContent = 'Failed to load chat.';
            }
        }

        async function sendMessage(event) {
            event.preventDefault();
            const message = messageInputEl.value.trim();
            const recipientId = recipientIdEl.value;

            if (!message || !recipientId) {
                return;
            }

            try {
                const response = await fetch(sendUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        recipient_id: recipientId,
                        message
                    })
                });

                if (!response.ok) {
                    throw new Error('Failed to send message');
                }

                messageInputEl.value = '';
                await loadChatData();
            } catch (error) {
                console.error(error);
                alert('Failed to send message. Please try again.');
            }
        }

        function startPolling() {
            stopPolling();
            pollTimer = window.setInterval(loadChatData, 7000);
        }

        function stopPolling() {
            if (pollTimer) {
                window.clearInterval(pollTimer);
                pollTimer = null;
            }
        }

        drawer.addEventListener('shown.bs.offcanvas', function () {
            isDrawerOpen = true;
            loadChatData();
            startPolling();
        });

        drawer.addEventListener('hidden.bs.offcanvas', function () {
            isDrawerOpen = false;
            stopPolling();
        });

        formEl.addEventListener('submit', sendMessage);

        loadChatData();
        startPolling();
    });
</script>
</body>
</html>
