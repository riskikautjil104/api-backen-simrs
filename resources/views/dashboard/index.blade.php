<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard API SIMRS - RSUD Dr. H. Chasan Boesoirie</title>
    <link rel="icon" type="image/png" href="{{ asset('icon/iconresmi.png') }}">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #e0f2fe 0%, #f0f9ff 40%, #ffffff 70%, #dbeafe 100%);
            color: #0f172a;
            height: 100vh;
            display: flex;
            overflow: hidden;
            position: relative;
        }

        /* 3D FLOATING BACKGROUND DECORATIONS */
        .bg-3d-scene {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: hidden;
            z-index: 1;
        }

        .dash-orb-1 {
            position: absolute;
            width: 420px;
            height: 420px;
            border-radius: 50%;
            background: radial-gradient(circle at 30% 30%, rgba(56, 189, 248, 0.35), rgba(2, 132, 199, 0.1) 70%, transparent 85%);
            top: -120px;
            right: -100px;
            animation: floatSlow 12s ease-in-out infinite;
        }

        .dash-orb-2 {
            position: absolute;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle at 70% 70%, rgba(2, 132, 199, 0.25), rgba(186, 230, 253, 0.15) 65%, transparent 85%);
            bottom: -150px;
            left: 180px;
            animation: floatSlow 15s ease-in-out infinite;
            animation-delay: -5s;
        }

        .dash-cube-1 {
            position: absolute;
            width: 80px;
            height: 80px;
            border-radius: 20px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.85), rgba(224, 242, 254, 0.5));
            border: 2px solid rgba(255, 255, 255, 0.9);
            box-shadow: 0 15px 35px rgba(2, 132, 199, 0.15), inset 0 2px 4px rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(8px);
            transform: rotate(20deg) skew(-8deg);
            top: 15%;
            right: 10%;
            animation: floatRotate 14s ease-in-out infinite;
        }

        .dash-cube-2 {
            position: absolute;
            width: 60px;
            height: 60px;
            border-radius: 16px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.8), rgba(186, 230, 253, 0.4));
            border: 1.5px solid rgba(255, 255, 255, 0.85);
            box-shadow: 0 12px 28px rgba(2, 132, 199, 0.12), inset 0 1px 3px rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(8px);
            transform: rotate(-15deg) skew(6deg);
            bottom: 12%;
            right: 20%;
            animation: floatRotate 11s ease-in-out infinite;
            animation-delay: -6s;
        }

        @keyframes floatSlow {
            0%, 100% { transform: translateY(0px) scale(1); }
            50% { transform: translateY(-20px) scale(1.03); }
        }

        @keyframes floatRotate {
            0%, 100% { transform: translateY(0px) rotate(20deg) skew(-8deg); }
            50% { transform: translateY(-25px) rotate(32deg) skew(-4deg); }
        }

        /* 3D FROSTED SIDEBAR */
        .sidebar {
            width: 270px;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(24px);
            border-right: 1px solid rgba(224, 242, 254, 0.9);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            user-select: none;
            box-shadow: 6px 0 25px rgba(2, 132, 199, 0.08);
            position: relative;
            z-index: 20;
            transition: width 0.28s cubic-bezier(0.2, 0, 0, 1);
        }
        .sidebar-brand {
            padding: 20px 18px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            border-bottom: 1px solid rgba(224, 242, 254, 0.8);
            background: transparent;
            position: relative;
            transition: padding 0.28s ease;
        }
        .sidebar-brand-left {
            display: flex;
            align-items: center;
            gap: 12px;
            overflow: hidden;
        }
        .sidebar-logo {
            width: 42px;
            height: 42px;
            min-width: 42px;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            border: 1.5px solid rgba(186, 230, 253, 0.95);
            box-shadow: 
                0 10px 20px rgba(2, 132, 199, 0.22),
                inset 0 1px 2px rgba(255, 255, 255, 0.9);
            transform: perspective(400px) rotateX(10deg);
            overflow: hidden;
            padding: 4px;
        }
        .sidebar-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
        }
        .sidebar-title {
            overflow: hidden;
            white-space: nowrap;
            transition: opacity 0.2s ease;
        }
        .sidebar-title h1 {
            font-size: 14px;
            font-weight: 800;
            color: #0369a1;
            line-height: 1.2;
            letter-spacing: -0.3px;
        }
        .sidebar-title p {
            font-size: 11px;
            color: #64748b;
        }
        .sidebar-toggle-btn {
            background: rgba(240, 249, 255, 0.9);
            border: 1px solid #bae6fd;
            color: #0284c7;
            width: 28px;
            height: 28px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(2, 132, 199, 0.1);
            transition: all 0.2s ease;
            flex-shrink: 0;
        }
        .sidebar-toggle-btn:hover {
            background: #0284c7;
            color: #ffffff;
            transform: scale(1.05);
        }
        .sidebar-toggle-btn svg {
            width: 15px;
            height: 15px;
            transition: transform 0.28s ease;
        }

        /* 3D USER BADGE CARD IN SIDEBAR */
        .sidebar-user {
            padding: 14px 16px;
            margin: 14px 14px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95), rgba(240, 249, 255, 0.85));
            border: 1px solid rgba(186, 230, 253, 0.8);
            border-radius: 14px;
            box-shadow: 0 8px 20px -4px rgba(2, 132, 199, 0.15), inset 0 1px 2px rgba(255, 255, 255, 1);
            transition: all 0.28s ease;
        }
        .sidebar-user-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .sidebar-user-name {
            font-size: 13px;
            font-weight: 700;
            color: #0c4a6e;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .role-pill {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            padding: 3px 9px;
            border-radius: 9999px;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 6px rgba(2, 132, 199, 0.2);
        }
        .role-superadmin {
            background: linear-gradient(135deg, #0284c7, #0369a1);
            color: #ffffff;
        }
        .role-pengakses {
            background: linear-gradient(135deg, #38bdf8, #0284c7);
            color: #ffffff;
        }
        .sidebar-device-status {
            font-size: 11px;
            color: #0284c7;
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 600;
        }
        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #10b981;
            box-shadow: 0 0 10px #10b981;
            flex-shrink: 0;
            animation: beaconPulse 2s infinite;
        }
        @keyframes beaconPulse {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        /* NAVIGATION MENU WITH 3D HOVER */
        .sidebar-menu {
            flex: 1;
            padding: 8px 12px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .menu-label {
            font-size: 10px;
            font-weight: 800;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            padding: 14px 10px 4px;
        }
        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            color: #475569;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            border-radius: 12px;
            transition: all 0.2s cubic-bezier(0.2, 0, 0, 1);
            position: relative;
        }
        .nav-item svg {
            width: 18px;
            height: 18px;
            stroke-width: 2;
            flex-shrink: 0;
            stroke: #64748b;
            transition: stroke 0.2s ease, transform 0.2s ease;
        }
        .nav-item:hover {
            background: rgba(240, 249, 255, 0.9);
            color: #0284c7;
            transform: translateX(4px);
        }
        .nav-item:hover svg {
            stroke: #0284c7;
            transform: scale(1.1);
        }
        .nav-item.active {
            background: linear-gradient(135deg, #0284c7, #0369a1);
            color: #ffffff;
            font-weight: 700;
            box-shadow: 0 8px 20px rgba(2, 132, 199, 0.35), 0 3px 0 #075985;
            transform: translateY(-1px);
        }
        .nav-item.active svg {
            stroke: #ffffff;
        }

        /* 3D PUSHABLE LOGOUT BUTTON */
        .sidebar-footer {
            padding: 16px;
            border-top: 1px solid rgba(224, 242, 254, 0.8);
            background: transparent;
            transition: padding 0.28s ease;
        }
        .btn-logout {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: linear-gradient(180deg, #ffffff 0%, #fee2e2 100%);
            color: #dc2626;
            border: 1px solid #fecaca;
            padding: 10px 14px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.12), 0 2px 0 #fca5a5;
            transition: all 0.15s ease;
        }
        .btn-logout:hover {
            background: linear-gradient(180deg, #fee2e2 0%, #fca5a5 100%);
            color: #b91c1c;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(239, 68, 68, 0.2), 0 3px 0 #fca5a5;
        }
        .btn-logout:active {
            transform: translateY(2px);
            box-shadow: 0 2px 6px rgba(239, 68, 68, 0.15), 0 1px 0 #fca5a5;
        }
        .btn-logout svg {
            width: 16px;
            height: 16px;
        }

        /* COLLAPSED SIDEBAR RULES (ICON-ONLY MODE) */
        .sidebar.collapsed {
            width: 76px;
        }
        .sidebar.collapsed .sidebar-brand {
            padding: 18px 12px 14px;
            justify-content: center;
        }
        .sidebar.collapsed .sidebar-brand-left {
            justify-content: center;
        }
        .sidebar.collapsed .sidebar-title,
        .sidebar.collapsed .sidebar-toggle-btn,
        .sidebar.collapsed .sidebar-user-name,
        .sidebar.collapsed .sidebar-device-status span:not(.status-dot),
        .sidebar.collapsed .menu-label,
        .sidebar.collapsed .nav-item span,
        .sidebar.collapsed .btn-logout span {
            display: none !important;
        }
        .sidebar.collapsed .sidebar-user {
            padding: 10px 6px;
            margin: 10px 8px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
        }
        .sidebar.collapsed .sidebar-user-top {
            justify-content: center;
            margin-bottom: 0;
        }
        .sidebar.collapsed .role-pill {
            padding: 2px 5px;
            font-size: 8px;
            letter-spacing: 0;
            text-align: center;
        }
        .sidebar.collapsed .sidebar-device-status {
            justify-content: center;
        }
        .sidebar.collapsed .nav-item {
            justify-content: center;
            padding: 12px 0;
            position: relative;
        }
        .sidebar.collapsed .nav-item:hover {
            transform: translateY(-2px);
        }
        .sidebar.collapsed .nav-item svg {
            width: 20px;
            height: 20px;
        }
        .sidebar.collapsed .nav-item:hover::after {
            content: attr(data-title);
            position: absolute;
            left: calc(100% + 14px);
            top: 50%;
            transform: translateY(-50%);
            background: #0369a1;
            color: #ffffff;
            font-size: 12px;
            font-weight: 700;
            padding: 6px 12px;
            border-radius: 8px;
            white-space: nowrap;
            box-shadow: 0 8px 20px rgba(2, 132, 199, 0.35);
            z-index: 1000;
            pointer-events: none;
            animation: tooltipSlide 0.15s ease-out;
        }
        @keyframes tooltipSlide {
            from { opacity: 0; transform: translateY(-50%) translateX(-6px); }
            to { opacity: 1; transform: translateY(-50%) translateX(0); }
        }
        .sidebar.collapsed .sidebar-footer {
            padding: 16px 10px;
        }
        .sidebar.collapsed .btn-logout {
            justify-content: center;
            padding: 10px 0;
            position: relative;
        }
        .sidebar.collapsed .btn-logout:hover::after {
            content: "Keluar Sistem";
            position: absolute;
            left: calc(100% + 14px);
            top: 50%;
            transform: translateY(-50%);
            background: #dc2626;
            color: #ffffff;
            font-size: 12px;
            font-weight: 700;
            padding: 6px 12px;
            border-radius: 8px;
            white-space: nowrap;
            box-shadow: 0 8px 20px rgba(220, 38, 38, 0.35);
            z-index: 1000;
            pointer-events: none;
            animation: tooltipSlide 0.15s ease-out;
        }

        /* MAIN WRAPPER */
        .main-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            height: 100vh;
            position: relative;
            z-index: 5;
        }

        /* 3D FROSTED TOPBAR */
        .topbar {
            height: 64px;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(224, 242, 254, 0.9);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            flex-shrink: 0;
            box-shadow: 0 4px 20px rgba(2, 132, 199, 0.04);
        }
        .topbar-title {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .topbar-toggle-btn {
            background: rgba(240, 249, 255, 0.95);
            border: 1px solid #bae6fd;
            color: #0284c7;
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 3px 8px rgba(2, 132, 199, 0.1), inset 0 1px 1px #ffffff;
            transition: all 0.2s cubic-bezier(0.2, 0, 0, 1);
            flex-shrink: 0;
        }
        .topbar-toggle-btn:hover {
            background: #0284c7;
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 6px 14px rgba(2, 132, 199, 0.25);
        }
        .topbar-toggle-btn:active {
            transform: translateY(1px);
        }
        .topbar-toggle-btn svg {
            width: 18px;
            height: 18px;
        }
        .topbar-title h2 {
            font-size: 16px;
            font-weight: 800;
            color: #0369a1;
            letter-spacing: -0.3px;
        }
        .topbar-badges {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .badge-device {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid #bae6fd;
            color: #0369a1;
            font-size: 11px;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 2px 8px rgba(2, 132, 199, 0.08);
        }
        .badge-security {
            background: rgba(240, 253, 244, 0.9);
            border: 1px solid #bbf7d0;
            color: #15803d;
            font-size: 11px;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 2px 8px rgba(34, 197, 94, 0.1);
        }
        /* ALERTS */
        .alert-box {
            margin: 20px 32px 0;
            padding: 14px 20px;
            border-radius: 12px;
            font-size: 13px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 14px rgba(2, 132, 199, 0.08);
        }
        .alert-success {
            background: rgba(240, 253, 244, 0.95);
            border: 1px solid #bbf7d0;
            color: #15803d;
        }
        .alert-error {
            background: rgba(254, 242, 242, 0.95);
            border: 1px solid #fecaca;
            color: #991b1b;
        }

        /* CONTENT AREA & SCROLL CONTAINER */
        .content-area {
            flex: 1;
            min-height: 0;
            overflow-y: auto;
            overflow-x: hidden;
            position: relative;
            display: flex;
            flex-direction: column;
        }

        /* 3D Modern Custom Scrollbar */
        .content-area::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        .content-area::-webkit-scrollbar-track {
            background: rgba(240, 249, 255, 0.7);
        }
        .content-area::-webkit-scrollbar-thumb {
            background: #bae6fd;
            border-radius: 6px;
        }
        .content-area::-webkit-scrollbar-thumb:hover {
            background: #0284c7;
        }

        /* Swagger full-height container override */
        .content-area-swagger {
            overflow: hidden !important;
            padding: 0 !important;
            display: flex !important;
            flex-direction: column !important;
            height: 100% !important;
            flex: 1 !important;
            min-height: 0 !important;
        }

        /* WELCOME HERO CARD (3D MODERN) */
        .welcome-hero-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(240, 249, 255, 0.92) 100%);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(186, 230, 253, 0.95);
            border-radius: 24px;
            padding: 34px 38px;
            margin-bottom: 30px;
            box-shadow: 
                0 20px 45px -10px rgba(2, 132, 199, 0.16),
                0 6px 16px -4px rgba(15, 23, 42, 0.05),
                inset 0 1px 2px rgba(255, 255, 255, 1);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 32px;
        }
        .welcome-hero-content {
            flex: 1;
            max-width: 620px;
            z-index: 2;
        }
        .welcome-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(224, 242, 254, 0.9);
            border: 1px solid #bae6fd;
            color: #0284c7;
            padding: 6px 14px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin-bottom: 14px;
            box-shadow: 0 2px 8px rgba(2, 132, 199, 0.1);
        }
        .welcome-hero-title {
            font-size: 26px;
            font-weight: 800;
            color: #0c4a6e;
            line-height: 1.25;
            letter-spacing: -0.6px;
            margin-bottom: 12px;
        }
        .welcome-hero-title span {
            background: linear-gradient(135deg, #0284c7, #0369a1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .welcome-hero-desc {
            font-size: 13.5px;
            line-height: 1.7;
            color: #334155;
            margin-bottom: 20px;
        }
        .welcome-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 24px;
        }
        .welcome-pill {
            background: #ffffff;
            border: 1px solid #bae6fd;
            border-radius: 10px;
            padding: 7px 12px;
            font-size: 11.5px;
            font-weight: 600;
            color: #0369a1;
            display: flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 2px 6px rgba(2, 132, 199, 0.06);
        }
        .welcome-pill code {
            font-family: monospace;
            background: #f0f9ff;
            color: #0284c7;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 11px;
            border: 1px solid #e0f2fe;
        }
        .welcome-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        /* 3D ILLUSTRATION CONTAINER & ANIMATIONS */
        .welcome-hero-art {
            flex-shrink: 0;
            width: 320px;
            height: 250px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2;
        }
        .art-svg {
            width: 100%;
            height: 100%;
            filter: drop-shadow(0 15px 25px rgba(2, 132, 199, 0.2));
        }

        @keyframes floatHub {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }
        @keyframes orbitFloat1 {
            0%, 100% { transform: translateY(0px) translateX(0px); }
            50% { transform: translateY(-6px) translateX(3px); }
        }
        @keyframes orbitFloat2 {
            0%, 100% { transform: translateY(0px) translateX(0px); }
            50% { transform: translateY(6px) translateX(-3px); }
        }
        @keyframes pulseRing {
            0% { transform: scale(0.9); opacity: 0.8; }
            50% { transform: scale(1.12); opacity: 0.3; }
            100% { transform: scale(0.9); opacity: 0.8; }
        }
        @keyframes streamFlow {
            from { stroke-dashoffset: 40; }
            to { stroke-dashoffset: 0; }
        }

        .anim-hub {
            animation: floatHub 5s ease-in-out infinite;
            transform-origin: center;
        }
        .anim-node-1 {
            animation: orbitFloat1 4s ease-in-out infinite;
            transform-origin: center;
        }
        .anim-node-2 {
            animation: orbitFloat2 4.5s ease-in-out infinite;
            animation-delay: -1.5s;
            transform-origin: center;
        }
        .anim-node-3 {
            animation: orbitFloat1 5.2s ease-in-out infinite;
            animation-delay: -2.5s;
            transform-origin: center;
        }
        .anim-node-4 {
            animation: orbitFloat2 4.8s ease-in-out infinite;
            animation-delay: -3.5s;
            transform-origin: center;
        }
        .anim-ring {
            animation: pulseRing 3.5s ease-in-out infinite;
            transform-origin: center;
        }
        .anim-stream {
            stroke-dasharray: 6 6;
            animation: streamFlow 2s linear infinite;
        }

        /* 3D INTERACTIVE CARDS GRID */
        .features-3d-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .feature-3d-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95), rgba(240, 249, 255, 0.88));
            backdrop-filter: blur(16px);
            border: 1px solid rgba(186, 230, 253, 0.85);
            border-radius: 18px;
            padding: 24px;
            box-shadow: 
                0 12px 28px -6px rgba(2, 132, 199, 0.1),
                inset 0 1px 2px rgba(255, 255, 255, 1);
            transition: all 0.25s cubic-bezier(0.2, 0, 0, 1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
        }
        .feature-3d-card:hover {
            transform: translateY(-5px);
            box-shadow: 
                0 20px 40px -8px rgba(2, 132, 199, 0.2),
                0 4px 12px rgba(15, 23, 42, 0.05);
            border-color: #38bdf8;
        }
        .feature-icon-wrapper {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
            border: 1px solid #7dd3fc;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0284c7;
            margin-bottom: 16px;
            box-shadow: 0 4px 14px rgba(2, 132, 199, 0.15);
        }
        .feature-icon-wrapper svg {
            width: 24px;
            height: 24px;
            stroke-width: 2.2;
        }
        .feature-title {
            font-size: 15px;
            font-weight: 800;
            color: #0c4a6e;
            margin-bottom: 8px;
            letter-spacing: -0.2px;
        }
        .feature-desc {
            font-size: 12.5px;
            line-height: 1.6;
            color: #475569;
            margin-bottom: 18px;
            flex: 1;
        }
        .feature-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #0284c7;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            transition: gap 0.2s ease;
        }
        .feature-btn:hover {
            color: #0369a1;
            gap: 10px;
        }
        .feature-btn svg {
            width: 14px;
            height: 14px;
            stroke-width: 2.5;
        }

        /* COPY TOAST NOTIFICATION */
        .toast-notify {
            position: fixed;
            bottom: 28px;
            right: 28px;
            background: linear-gradient(135deg, #0284c7, #0369a1);
            color: #ffffff;
            padding: 12px 22px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 700;
            box-shadow: 0 12px 28px rgba(2, 132, 199, 0.35);
            display: flex;
            align-items: center;
            gap: 8px;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.3s cubic-bezier(0.2, 0, 0, 1);
            pointer-events: none;
            z-index: 9999;
        }
        .toast-notify.show {
            opacity: 1;
            transform: translateY(0);
        }

        /* TAB: OVERVIEW */
        .overview-container {
            padding: 32px;
            max-width: 1200px;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(224, 242, 254, 0.95);
            border-radius: 18px;
            padding: 22px;
            box-shadow: 
                0 14px 30px -6px rgba(2, 132, 199, 0.12),
                0 4px 10px -2px rgba(15, 23, 42, 0.04),
                inset 0 1px 2px rgba(255, 255, 255, 1);
            transition: all 0.25s cubic-bezier(0.2, 0, 0, 1);
            position: relative;
        }
        .stat-card:hover {
            transform: translateY(-6px) scale(1.015);
            box-shadow: 
                0 22px 45px -8px rgba(2, 132, 199, 0.22),
                inset 0 1px 2px rgba(255, 255, 255, 1);
            border-color: #bae6fd;
        }
        .stat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 14px;
        }
        .stat-title {
            font-size: 12px;
            font-weight: 700;
            color: #0369a1;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }
        .stat-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #e0f2fe, #bae6fd);
            color: #0284c7;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 6px 14px rgba(2, 132, 199, 0.16), inset 0 1px 2px rgba(255, 255, 255, 0.8);
        }
        .stat-icon svg {
            width: 20px;
            height: 20px;
        }
        .stat-value {
            font-size: 24px;
            font-weight: 800;
            color: #0c4a6e;
            margin-bottom: 4px;
            letter-spacing: -0.5px;
        }
        .stat-desc {
            font-size: 12px;
            color: #64748b;
        }

        .section-card {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(224, 242, 254, 0.95);
            border-radius: 20px;
            padding: 26px;
            margin-bottom: 26px;
            box-shadow: 
                0 16px 36px -8px rgba(2, 132, 199, 0.12),
                inset 0 1px 2px rgba(255, 255, 255, 1);
        }
        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
            padding-bottom: 14px;
            border-bottom: 1px solid rgba(224, 242, 254, 0.8);
        }
        .section-title {
            font-size: 16px;
            font-weight: 800;
            color: #0369a1;
            letter-spacing: -0.3px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 18px;
        }
        .info-item {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9), rgba(240, 249, 255, 0.8));
            border: 1px solid rgba(186, 230, 253, 0.8);
            border-radius: 12px;
            padding: 16px 18px;
            box-shadow: 0 4px 12px rgba(2, 132, 199, 0.05), inset 0 1px 2px rgba(255, 255, 255, 1);
        }
        .info-item-label {
            font-size: 11px;
            font-weight: 700;
            color: #0284c7;
            text-transform: uppercase;
            margin-bottom: 4px;
            letter-spacing: 0.5px;
        }
        .info-item-val {
            font-size: 14px;
            font-weight: 700;
            color: #0c4a6e;
        }

        /* TAB: SWAGGER FULL HEIGHT */
        .swagger-container {
            width: 100%;
            height: 100%;
            flex: 1;
            min-height: 0;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .swagger-bar {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(224, 242, 254, 0.9);
            padding: 10px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 14px rgba(2, 132, 199, 0.04);
            flex-shrink: 0;
            z-index: 2;
        }
        .swagger-bar-text {
            font-size: 12px;
            font-weight: 600;
            color: #475569;
        }
        .swagger-bar-actions {
            display: flex;
            gap: 10px;
        }
        .btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: linear-gradient(180deg, #ffffff 0%, #f0f9ff 100%);
            color: #0369a1;
            border: 1px solid #bae6fd;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            box-shadow: 0 3px 8px rgba(2, 132, 199, 0.08), 0 2px 0 #bae6fd;
            transition: all 0.15s ease;
        }
        .btn-secondary:hover {
            background: #e0f2fe;
            color: #0284c7;
            transform: translateY(-1px);
        }
        .btn-secondary:active {
            transform: translateY(1px);
            box-shadow: 0 2px 4px rgba(2, 132, 199, 0.06);
        }
        .swagger-iframe {
            flex: 1;
            width: 100%;
            height: 100%;
            min-height: 0;
            border: none;
            background: #ffffff;
            display: block;
        }

        /* TAB: TUTORIAL / MAPPING GUIDE */
        .tutorial-container {
            padding: 32px;
            max-width: 1080px;
            margin: 0 auto;
        }
        .guide-box {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(224, 242, 254, 0.95);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 26px;
            box-shadow: 
                0 16px 36px -8px rgba(2, 132, 199, 0.12),
                inset 0 1px 2px rgba(255, 255, 255, 1);
        }
        .guide-box h3 {
            font-size: 17px;
            font-weight: 800;
            color: #0369a1;
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
            letter-spacing: -0.3px;
        }
        .guide-box h4 {
            font-size: 14px;
            font-weight: 700;
            color: #0284c7;
            margin: 20px 0 10px;
        }
        .guide-box p {
            font-size: 13px;
            line-height: 1.65;
            color: #334155;
            margin-bottom: 14px;
        }
        .guide-box ul, .guide-box ol {
            padding-left: 20px;
            font-size: 13px;
            line-height: 1.7;
            color: #334155;
            margin-bottom: 16px;
        }
        .guide-box li {
            margin-bottom: 6px;
        }
        .code-block {
            background: linear-gradient(145deg, #082f49, #0c4a6e);
            color: #f0f9ff;
            padding: 18px;
            border-radius: 12px;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-size: 12px;
            line-height: 1.6;
            overflow-x: auto;
            margin: 14px 0 18px;
            border: 1px solid #0284c7;
            box-shadow: 0 12px 28px -6px rgba(2, 132, 199, 0.2), inset 0 1px 1px rgba(255, 255, 255, 0.15);
        }
        .mapping-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin: 16px 0 22px;
        }
        .mapping-table th {
            background: rgba(240, 249, 255, 0.9);
            color: #0369a1;
            font-weight: 800;
            padding: 12px 16px;
            text-align: left;
            border-bottom: 2px solid #bae6fd;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 11px;
        }
        .mapping-table td {
            padding: 12px 16px;
            border-bottom: 1px solid #e0f2fe;
            color: #1e293b;
            vertical-align: top;
        }
        .mapping-table tr:hover {
            background: rgba(240, 249, 255, 0.7);
        }
        .tag-param {
            display: inline-block;
            background: #e0f2fe;
            color: #0369a1;
            font-family: monospace;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 6px;
            font-size: 11px;
            border: 1px solid #bae6fd;
        }
        .tag-postman {
            display: inline-block;
            background: #fef3c7;
            color: #92400e;
            font-family: monospace;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 6px;
            font-size: 11px;
        }

        /* TAB: USER MANAGEMENT (SUPERADMIN ONLY) */
        .users-container {
            padding: 32px;
            max-width: 1200px;
        }
        .table-responsive {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(224, 242, 254, 0.95);
            border-radius: 20px;
            overflow-x: auto;
            box-shadow: 
                0 16px 36px -8px rgba(2, 132, 199, 0.12),
                inset 0 1px 2px rgba(255, 255, 255, 1);
        }
        .users-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }
        .users-table th {
            background: rgba(240, 249, 255, 0.9);
            color: #0369a1;
            font-weight: 800;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.6px;
            padding: 16px 20px;
            text-align: left;
            border-bottom: 2px solid #bae6fd;
        }
        .users-table td {
            padding: 16px 20px;
            border-bottom: 1px solid #f0f7ff;
            color: #334155;
            vertical-align: middle;
        }
        .users-table tr:hover {
            background: rgba(240, 249, 255, 0.6);
        }
        .user-primary {
            font-weight: 700;
            color: #0f172a;
        }
        .user-sub {
            font-size: 11px;
            color: #64748b;
        }
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 9999px;
        }
        .status-active {
            background: #dcfce7;
            color: #15803d;
            box-shadow: 0 2px 6px rgba(34, 197, 94, 0.15);
        }
        .status-inactive {
            background: #fee2e2;
            color: #b91c1c;
            box-shadow: 0 2px 6px rgba(239, 68, 68, 0.15);
        }
        .actions-cell {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }
        .btn-action {
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 700;
            border: 1px solid transparent;
            cursor: pointer;
            transition: all 0.15s ease;
            background: transparent;
        }
        .btn-action-primary {
            background: linear-gradient(180deg, #0284c7 0%, #0369a1 100%);
            color: #ffffff;
            border: none;
            padding: 9px 18px;
            font-size: 13px;
            font-weight: 700;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            box-shadow: 
                0 8px 20px rgba(2, 132, 199, 0.35),
                0 3px 0 #075985,
                inset 0 1px 2px rgba(255, 255, 255, 0.4);
            transition: all 0.15s ease;
        }
        .btn-action-primary:hover {
            background: linear-gradient(180deg, #0369a1 0%, #075985 100%);
            transform: translateY(-2px);
            box-shadow: 
                0 10px 24px rgba(2, 132, 199, 0.4),
                0 4px 0 #075985;
        }
        .btn-action-primary:active {
            transform: translateY(2px);
            box-shadow: 
                0 3px 8px rgba(2, 132, 199, 0.25),
                0 1px 0 #075985;
        }
        .btn-action-warning {
            background: linear-gradient(180deg, #fef3c7 0%, #fde68a 100%);
            color: #92400e;
            border: 1px solid #fde68a;
            box-shadow: 0 2px 6px rgba(217, 119, 6, 0.15);
        }
        .btn-action-warning:hover {
            background: #fde68a;
            transform: translateY(-1px);
        }
        .btn-action-danger {
            background: linear-gradient(180deg, #fee2e2 0%, #fecaca 100%);
            color: #b91c1c;
            border: 1px solid #fecaca;
            box-shadow: 0 2px 6px rgba(239, 68, 68, 0.15);
        }
        .btn-action-danger:hover {
            background: #fecaca;
            transform: translateY(-1px);
        }
        .btn-action-info {
            background: linear-gradient(180deg, #e0f2fe 0%, #bae6fd 100%);
            color: #0369a1;
            border: 1px solid #bae6fd;
            box-shadow: 0 2px 6px rgba(2, 132, 199, 0.15);
        }
        .btn-action-info:hover {
            background: #bae6fd;
            transform: translateY(-1px);
        }

        /* 3D MODAL STYLES */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.45);
            backdrop-filter: blur(6px);
            z-index: 999;
            align-items: center;
            justify-content: center;
        }
        .modal.active {
            display: flex;
        }
        .modal-content {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            width: 100%;
            max-width: 480px;
            box-shadow: 
                0 30px 60px -12px rgba(2, 132, 199, 0.25),
                0 18px 36px -18px rgba(15, 23, 42, 0.15),
                inset 0 1px 2px rgba(255, 255, 255, 1);
            overflow: hidden;
            animation: modalFadeIn 0.2s cubic-bezier(0.2, 0, 0, 1);
        }
        @keyframes modalFadeIn {
            from { opacity: 0; transform: translateY(-16px) scale(0.97); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        .modal-header {
            padding: 20px 26px;
            border-bottom: 1px solid rgba(224, 242, 254, 0.8);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .modal-title {
            font-size: 16px;
            font-weight: 800;
            color: #0369a1;
            letter-spacing: -0.3px;
        }
        .btn-close {
            background: none;
            border: none;
            color: #94a3b8;
            font-size: 20px;
            cursor: pointer;
            padding: 4px;
            transition: color 0.15s ease;
        }
        .btn-close:hover {
            color: #0284c7;
        }
        .modal-body {
            padding: 26px;
        }
        .modal-footer {
            padding: 18px 26px;
            background: rgba(240, 249, 255, 0.7);
            border-top: 1px solid rgba(224, 242, 254, 0.8);
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }
        .form-group {
            margin-bottom: 18px;
        }
        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            color: #0369a1;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .form-input, .form-select {
            width: 100%;
            padding: 11px 14px;
            border: 1.5px solid #cbd5e1;
            border-radius: 10px;
            font-size: 13px;
            color: #0f172a;
            outline: none;
            background: #ffffff;
            transition: all 0.2s ease;
            box-shadow: inset 0 1px 3px rgba(15, 23, 42, 0.04);
        }
        .form-input:focus, .form-select:focus {
            border-color: #0284c7;
            box-shadow: 0 0 0 4px rgba(2, 132, 199, 0.16);
        }
    </style>
</head>
<body>

    <!-- 3D FLOATING BACKGROUND -->
    <div class="bg-3d-scene">
        <div class="dash-orb-1"></div>
        <div class="dash-orb-2"></div>
        <div class="dash-cube-1"></div>
        <div class="dash-cube-2"></div>
    </div>

    <!-- SIDEBAR -->
    <aside class="sidebar" id="mainSidebar">
        <div class="sidebar-brand">
            <div class="sidebar-brand-left">
                <div class="sidebar-logo">
                    <img src="{{ asset('icon/iconresmi.png') }}" alt="Logo RSUD Dr. H. Chasan Boesoirie">
                </div>
                <div class="sidebar-title">
                    <h1>SIMRS API HUB</h1>
                    <p>RSUD Dr. H. Chasan Boesoirie</p>
                </div>
            </div>
            <button type="button" id="sidebarToggleBtn" class="sidebar-toggle-btn" title="Kecilkan / Besarkan Sidebar" aria-label="Toggle Sidebar">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
            </button>
        </div>

        <div class="sidebar-user">
            <div class="sidebar-user-top">
                <span class="sidebar-user-name" title="{{ $user->name }}">{{ $user->name }}</span>
                <span class="role-pill {{ $user->isSuperAdmin() ? 'role-superadmin' : 'role-pengakses' }}">
                    {{ $user->role }}
                </span>
            </div>
            
        </div>

        <nav class="sidebar-menu">
            <div class="menu-label">Menu Utama</div>

            <a href="{{ route('dashboard', ['tab' => 'overview']) }}" class="nav-item {{ $activeTab === 'overview' ? 'active' : '' }}" data-title="Ringkasan Sistem">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <rect x="3" y="3" width="7" height="7"></rect>
                    <rect x="14" y="3" width="7" height="7"></rect>
                    <rect x="14" y="14" width="7" height="7"></rect>
                    <rect x="3" y="14" width="7" height="7"></rect>
                </svg>
                <span>Ringkasan Sistem</span>
            </a>

            <a href="{{ route('dashboard', ['tab' => 'swagger']) }}" class="nav-item {{ $activeTab === 'swagger' ? 'active' : '' }}" data-title="Dokumentasi Swagger">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <polyline points="16 18 22 12 16 6"></polyline>
                    <polyline points="8 6 2 12 8 18"></polyline>
                </svg>
                <span>Dokumentasi Swagger</span>
            </a>

            <a href="{{ route('dashboard', ['tab' => 'tutorial']) }}" class="nav-item {{ $activeTab === 'tutorial' ? 'active' : '' }}" data-title="Panduan Mapping Sistem">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                </svg>
                <span>Panduan Mapping Sistem</span>
            </a>

            @if($user->isSuperAdmin())
                <div class="menu-label">Administrasi</div>
                <a href="{{ route('dashboard', ['tab' => 'users']) }}" class="nav-item {{ $activeTab === 'users' ? 'active' : '' }}" data-title="Manajemen Pengguna">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                    <span>Manajemen Pengguna</span>
                </a>
            @endif
        </nav>

        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout" title="Keluar Sistem">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    <span>Keluar Sistem</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN WRAPPER -->
    <main class="main-wrapper">
        <!-- TOPBAR -->
        <header class="topbar">
            <div class="topbar-title">
                <button type="button" id="topbarToggleBtn" class="topbar-toggle-btn" title="Kecilkan / Besarkan Sidebar" aria-label="Toggle Sidebar">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </button>
                <h2>
                    @if($activeTab === 'overview') Ringkasan Sistem & Status Akun
                    @elseif($activeTab === 'swagger') Penjelajah Dokumentasi API (Swagger UI)
                    @elseif($activeTab === 'tutorial') Panduan Integrasi & Mapping Sistem Eksternal
                    @elseif($activeTab === 'users') Manajemen Akun Pengguna
                    @endif
                </h2>
            </div>
            <div class="topbar-badges">
          
                    <span>Proteksi 1 Perangkat: Aktif</span>
            
                <div class="badge-device">
                    <span>{{ $user->last_device ?? 'Browser Web' }}</span>
                </div>
            </div>
        </header>

        <!-- ALERTS -->
        @if(session('success'))
            <div class="alert-box alert-success">
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="alert-box alert-error">
                <span>{{ session('error') }}</span>
            </div>
        @endif
        @if(!empty($errors) && $errors->any())
            <div class="alert-box alert-error">
                <div style="width: 100%;">
                    <strong style="display: block; margin-bottom: 4px; font-weight: 700;">Gagal Menyimpan Data Pengguna:</strong>
                    <ul style="margin: 0; padding-left: 20px; font-size: 12px; line-height: 1.5;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- CONTENT AREA -->
        <div class="content-area {{ $activeTab === 'swagger' ? 'content-area-swagger' : '' }}">

            <!-- TAB 1: OVERVIEW / WELCOME SCREEN -->
            @if($activeTab === 'overview')
                <div class="overview-container">

                    <!-- 3D WELCOME HERO BANNER -->
                    <div class="welcome-hero-card">
                        <div class="welcome-hero-content">
                            
                              
                                
                          
                            <h1 class="welcome-hero-title">
                                Selamat Datang, <span>{{ $user->name }}</span>!
                            </h1>
                            <p class="welcome-hero-desc">
                                Selamat datang di portal resmi penghubung dan pengujian API RSUD Dr. H. Chasan Boesoirie Ternate (MediFirst 2000). Anda dapat langsung mengeksplorasi dokumentasi interaktif Swagger untuk uji coba endpoint atau mempelajari panduan integrasi sistem ke sistem.
                            </p>

                            <div class="welcome-pills">
                                <div class="welcome-pill">
                                    <span>Target Server:</span>
                                    <code>chasanboesoirie.id/service/medifirst2000/</code>
                                </div>
                                <div class="welcome-pill">
                                    <span>Header Wajib:</span>
                                    <code>X-AUTH-TOKEN</code>
                                </div>
                                <div class="welcome-pill">
                                    <span>Hak Akses:</span>
                                    <code>{{ strtoupper($user->role) }}</code>
                                </div>
                                <div class="welcome-pill">
                                    <span>Sesi:</span>
                                    <code>1 Perangkat Aktif</code>
                                </div>
                            </div>

                            <div class="welcome-actions">
                                <a href="{{ route('dashboard', ['tab' => 'swagger']) }}" class="btn-action-primary" style="text-decoration: none;">
                                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5">
                                        <polyline points="16 18 22 12 16 6"></polyline>
                                        <polyline points="8 6 2 12 8 18"></polyline>
                                    </svg>
                                    <span>Uji Coba di Swagger UI</span>
                                </a>
                                <a href="{{ route('dashboard', ['tab' => 'tutorial']) }}" class="btn-secondary" style="padding: 10px 16px; font-size: 13px;">
                                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                                    </svg>
                                    <span>Panduan Mapping Sistem</span>
                                </a>
                                <button type="button" class="btn-secondary" onclick="copyBaseUrl()" style="padding: 10px 16px; font-size: 13px;">
                                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                        <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                    </svg>
                                    <span>Salin Base URL</span>
                                </button>
                            </div>
                        </div>

                        <!-- 3D ANIMATED MEDICAL GATEWAY ILLUSTRATION -->
                        <div class="welcome-hero-art">
                            <svg class="art-svg" viewBox="0 0 380 280" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <defs>
                                    <linearGradient id="hubGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" stop-color="#38bdf8" />
                                        <stop offset="100%" stop-color="#0284c7" />
                                    </linearGradient>
                                    <linearGradient id="cardGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" stop-color="#ffffff" stop-opacity="0.95" />
                                        <stop offset="100%" stop-color="#f0f9ff" stop-opacity="0.88" />
                                    </linearGradient>
                                    <filter id="shadowGlow" x="-20%" y="-20%" width="140%" height="140%">
                                        <feDropShadow dx="0" dy="8" stdDeviation="10" flood-color="#0284c7" flood-opacity="0.22" />
                                    </filter>
                                </defs>

                                <!-- Circuit Stream Lines -->
                                <path d="M 75 75 Q 140 100 190 140" stroke="#7dd3fc" stroke-width="2.5" fill="none" class="anim-stream" />
                                <path d="M 305 75 Q 240 100 190 140" stroke="#7dd3fc" stroke-width="2.5" fill="none" class="anim-stream" />
                                <path d="M 75 215 Q 140 185 190 140" stroke="#7dd3fc" stroke-width="2.5" fill="none" class="anim-stream" />
                                <path d="M 305 215 Q 240 185 190 140" stroke="#7dd3fc" stroke-width="2.5" fill="none" class="anim-stream" />

                                <!-- Pulse Rings -->
                                <circle cx="190" cy="140" r="56" stroke="#bae6fd" stroke-width="1.5" fill="none" class="anim-ring" />
                                <circle cx="190" cy="140" r="76" stroke="#e0f2fe" stroke-width="1" fill="none" class="anim-ring" style="animation-delay: -1.5s;" />

                                <!-- Central 3D Hub Server -->
                                <g class="anim-hub">
                                    <polygon points="190,105 235,128 235,160 190,185 145,160 145,128" fill="url(#hubGrad)" filter="url(#shadowGlow)" />
                                    <polygon points="190,105 235,128 190,150 145,128" fill="#7dd3fc" />
                                    <polygon points="190,150 235,128 235,160 190,185" fill="#0284c7" />
                                    <polygon points="145,128 190,150 190,185 145,160" fill="#0369a1" />

                                    <!-- Hospital Cross Badge -->
                                    <circle cx="190" cy="140" r="14" fill="#ffffff" />
                                    <path d="M 190 132 L 190 148 M 182 140 L 198 140" stroke="#0284c7" stroke-width="3" stroke-linecap="round" />
                                    <circle cx="190" cy="115" r="4" fill="#10b981" />
                                </g>

                                <!-- Satellite Node 1 (CPPT SOAP) -->
                                <g class="anim-node-1" transform="translate(38, 48)">
                                    <rect width="74" height="46" rx="10" fill="url(#cardGrad)" stroke="#bae6fd" stroke-width="1.5" filter="url(#shadowGlow)" />
                                    <rect x="8" y="8" width="16" height="16" rx="4" fill="#e0f2fe" />
                                    <path d="M 12 16 L 20 16 M 12 12 L 20 12" stroke="#0284c7" stroke-width="1.5" stroke-linecap="round" />
                                    <text x="30" y="20" font-size="9" font-weight="bold" fill="#0369a1" font-family="sans-serif">CPPT</text>
                                    <text x="8" y="36" font-size="8" fill="#64748b" font-family="sans-serif">SOAP Medis</text>
                                </g>

                                <!-- Satellite Node 2 (EMR Transaksi) -->
                                <g class="anim-node-2" transform="translate(268, 48)">
                                    <rect width="74" height="46" rx="10" fill="url(#cardGrad)" stroke="#bae6fd" stroke-width="1.5" filter="url(#shadowGlow)" />
                                    <rect x="8" y="8" width="16" height="16" rx="4" fill="#e0f2fe" />
                                    <path d="M 13 14 L 19 14 M 13 18 L 19 18 M 16 11 L 16 21" stroke="#0284c7" stroke-width="1.5" stroke-linecap="round" />
                                    <text x="30" y="20" font-size="9" font-weight="bold" fill="#0369a1" font-family="sans-serif">EMR</text>
                                    <text x="8" y="36" font-size="8" fill="#64748b" font-family="sans-serif">Rekam Medis</text>
                                </g>

                                <!-- Satellite Node 3 (Farmasi & Resep) -->
                                <g class="anim-node-3" transform="translate(38, 192)">
                                    <rect width="74" height="46" rx="10" fill="url(#cardGrad)" stroke="#bae6fd" stroke-width="1.5" filter="url(#shadowGlow)" />
                                    <rect x="8" y="8" width="16" height="16" rx="4" fill="#e0f2fe" />
                                    <circle cx="16" cy="16" r="5" stroke="#0284c7" stroke-width="1.5" fill="none" />
                                    <text x="30" y="20" font-size="9" font-weight="bold" fill="#0369a1" font-family="sans-serif">Farmasi</text>
                                    <text x="8" y="36" font-size="8" fill="#64748b" font-family="sans-serif">E-Resep Obat</text>
                                </g>

                                <!-- Satellite Node 4 (Billing & Kasir) -->
                                <g class="anim-node-4" transform="translate(268, 192)">
                                    <rect width="74" height="46" rx="10" fill="url(#cardGrad)" stroke="#bae6fd" stroke-width="1.5" filter="url(#shadowGlow)" />
                                    <rect x="8" y="8" width="16" height="16" rx="4" fill="#e0f2fe" />
                                    <rect x="12" y="12" width="8" height="8" rx="2" stroke="#0284c7" stroke-width="1.5" fill="none" />
                                    <text x="30" y="20" font-size="9" font-weight="bold" fill="#0369a1" font-family="sans-serif">Tarif</text>
                                    <text x="8" y="36" font-size="8" fill="#64748b" font-family="sans-serif">Billing Pasien</text>
                                </g>

                                <!-- Floating Status Badges -->
                                <g transform="translate(145, 60)">
                                    <rect width="90" height="22" rx="6" fill="#10b981" />
                                    <text x="45" y="15" text-anchor="middle" font-size="10" font-weight="bold" fill="#ffffff" font-family="sans-serif">HTTP 200 OK</text>
                                </g>
                                <g transform="translate(138, 212)">
                                    <rect width="104" height="22" rx="6" fill="#0284c7" />
                                    <text x="52" y="15" text-anchor="middle" font-size="10" font-weight="bold" fill="#ffffff" font-family="sans-serif">X-AUTH-TOKEN</text>
                                </g>
                            </svg>
                        </div>
                    </div>

                    <!-- 3D FEATURE GRID -->
                    <div class="features-3d-grid">
                        <div class="feature-3d-card">
                            <div>
                                <div class="feature-icon-wrapper">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <polyline points="16 18 22 12 16 6"></polyline>
                                        <polyline points="8 6 2 12 8 18"></polyline>
                                    </svg>
                                </div>
                                <div class="feature-title">Eksplorasi Swagger UI</div>
                                <div class="feature-desc">
                                    Akses 11 modul layanan REST API lengkap dengan skema parameter, respon JSON, dan tombol uji coba langsung (Try it out) bebas hambatan CORS.
                                </div>
                            </div>
                            <a href="{{ route('dashboard', ['tab' => 'swagger']) }}" class="feature-btn">
                                <span>Buka Swagger API</span>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                            </a>
                        </div>

                        <div class="feature-3d-card">
                            <div>
                                <div class="feature-icon-wrapper">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                                    </svg>
                                </div>
                                <div class="feature-title">Panduan Mapping Bridging</div>
                                <div class="feature-desc">
                                    Pelajari struktur integrasi data SOAP CPPT (emrfk = 443), kamus tabel mapping database, serta implementasi kode server-to-server siap pakai.
                                </div>
                            </div>
                            <a href="{{ route('dashboard', ['tab' => 'tutorial']) }}" class="feature-btn">
                                <span>Pelajari Panduan</span>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                            </a>
                        </div>

                        <div class="feature-3d-card">
                            <div>
                                <div class="feature-icon-wrapper">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect>
                                        <rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect>
                                        <line x1="6" y1="6" x2="6.01" y2="6"></line>
                                        <line x1="6" y1="18" x2="6.01" y2="18"></line>
                                    </svg>
                                </div>
                                <div class="feature-title">Direct Hit Server Produksi</div>
                                <div class="feature-desc">
                                    Tembak langsung URL server produksi RSUD Dr. H. Chasan Boesoirie untuk integrasi backend-to-backend menggunakan header autentikasi X-AUTH-TOKEN.
                                </div>
                            </div>
                            <button type="button" onclick="copyBaseUrl()" class="feature-btn" style="background: none; border: none; cursor: pointer; padding: 0;">
                                <span>Salin Base URL Produksi</span>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                            </button>
                        </div>
                    </div>

                    <!-- STATS GRID -->
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-header">
                                <span class="stat-title">Database Sistem</span>
                                <div class="stat-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <ellipse cx="12" cy="5" rx="9" ry="3"></ellipse>
                                        <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path>
                                        <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="stat-value">MySQL</div>
                            <div class="stat-desc">Koneksi aktif ke database simrs_api</div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-header">
                                <span class="stat-title">Keamanan Sesi</span>
                                <div class="stat-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="stat-value">1 Perangkat</div>
                            <div class="stat-desc">Otomatis kick jika login di tempat lain</div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-header">
                                <span class="stat-title">Reverse Proxy SIMRS</span>
                                <div class="stat-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="2" y1="12" x2="22" y2="12"></line>
                                        <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="stat-value">Terhubung</div>
                            <div class="stat-desc">chasanboesoirie.id dengan auto-retry</div>
                        </div>

                        @if($user->isSuperAdmin())
                            <div class="stat-card">
                                <div class="stat-header">
                                    <span class="stat-title">Total Pengguna</span>
                                    <div class="stat-icon">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="9" cy="7" r="4"></circle>
                                        </svg>
                                    </div>
                                </div>
                                <div class="stat-value">{{ $totalUsers }} Akun</div>
                                <div class="stat-desc">{{ $activeSessionsCount }} perangkat sedang online</div>
                            </div>
                        @else
                            <div class="stat-card">
                                <div class="stat-header">
                                    <span class="stat-title">Hak Akses Anda</span>
                                    <div class="stat-icon">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                    </div>
                                </div>
                                <div class="stat-value">Pengakses API</div>
                                <div class="stat-desc">Akses penuh ke Swagger dan Panduan</div>
                            </div>
                        @endif
                    </div>

                    <div class="section-card">
                        <div class="section-header">
                            <span class="section-title">Informasi Akun & Perangkat Aktif</span>
                        </div>
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-item-label">Nama Pengguna</div>
                                <div class="info-item-val">{{ $user->name }} ({{ $user->username }})</div>
                            </div>
                            <div class="info-item">
                                <div class="info-item-label">Peran (Role)</div>
                                <div class="info-item-val">{{ strtoupper($user->role) }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-item-label">Perangkat yang Digunakan</div>
                                <div class="info-item-val">{{ $user->last_device ?? 'Browser Web' }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-item-label">Alamat IP Terhubung</div>
                                <div class="info-item-val">{{ $user->last_login_ip ?? request()->ip() }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-item-label">Waktu Login Terakhir</div>
                                <div class="info-item-val">{{ $user->last_login_at ? $user->last_login_at->format('d M Y - H:i:s') : 'Baru saja' }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-item-label">Aturan Multi-Device</div>
                                <div class="info-item-val" style="color: #0284c7;">Hanya 1 Perangkat Aktif Bersamaan</div>
                            </div>
                        </div>
                    </div>

                    <div class="section-card">
                        <div class="section-header">
                            <span class="section-title">Pintasan Cepat</span>
                        </div>
                        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                            <a href="{{ route('dashboard', ['tab' => 'swagger']) }}" class="btn-action-primary" style="text-decoration: none;">
                                Buka Dokumentasi Swagger
                            </a>
                            <a href="{{ route('dashboard', ['tab' => 'tutorial']) }}" class="btn-secondary" style="padding: 8px 14px; font-size: 12px;">
                                Baca Panduan Mapping Sistem
                            </a>
                            @if($user->isSuperAdmin())
                                <a href="{{ route('dashboard', ['tab' => 'users']) }}" class="btn-secondary" style="padding: 8px 14px; font-size: 12px;">
                                    Kelola Pengguna
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- TAB 2: SWAGGER EMBEDDED -->
            @if($activeTab === 'swagger')
                <div class="swagger-container">
                    <div class="swagger-bar">
                        <span class="swagger-bar-text">Swagger UI terhubung langsung dengan reverse proxy lokal untuk bypass CORS.</span>
                        <div class="swagger-bar-actions">
                            <button onclick="document.getElementById('swagger-frame').contentWindow.location.reload();" class="btn-secondary">
                                Muat Ulang Iframe
                            </button>
                            <a href="/api/documentation" target="_blank" class="btn-secondary">
                                Buka di Tab Baru
                            </a>
                        </div>
                    </div>
                    <iframe id="swagger-frame" src="/api/documentation" class="swagger-iframe"></iframe>
                </div>
            @endif

            <!-- TAB 3: TUTORIAL / MAPPING GUIDE -->
            @if($activeTab === 'tutorial')
                <div class="tutorial-container">
                    
                    <div class="guide-box">
                        <h3>1. Konsep Dasar & Arsitektur Bridging Antar-SIMRS</h3>
                        <p>
                            Dokumentasi ini disusun khusus bagi tim pengembang teknologi informasi rumah sakit, vendor SIMRS, atau pengembang aplikasi kesehatan yang ingin melakukan <strong>bridging (integrasi langsung server-to-server)</strong> dari sistem SIMRS mereka ke server pusat SIMRS Medifirst2000 di <strong>RSUD Dr. H. Chasan Boesoirie Ternate</strong>.
                        </p>
                        
                        <h4>Direct Hit Base URL (Produksi)</h4>
                        <p>
                            Untuk komunikasi antar-server (backend ke backend), sistem Anda dapat <strong>langsung menembak Base URL server pusat produksi</strong> berikut tanpa melalui proxy, karena komunikasi server tidak dibatasi oleh kebijakan CORS browser:
                        </p>
                        <div class="code-block">
# Base URL Server Pusat SIMRS RSUD Dr. H. Chasan Boesoirie (Direct Hit):
https://chasanboesoirie.id/service/medifirst2000/

# Alternatif URL Reverse Proxy (Khusus pengujian dari Frontend / Browser):
http://127.0.0.1:8000/service/medifirst2000/
                        </div>

                        <h4>Header HTTP Wajib</h4>
                        <p>Setiap request HTTP dari sistem SIMRS Anda wajib menyertakan header otorisasi JWT berikut:</p>
                        <div class="code-block">
X-AUTH-TOKEN: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJzdWIiOiJoaXMuamtuIn0...
Accept: application/json, */*
Content-Type: application/json
User-Agent: SIMRS-Bridging-Client/1.0 (Mozilla/5.0)
                        </div>
                        <p style="font-size: 12px; color: #64748b;">
                            <strong>Catatan Keamanan:</strong> Pastikan selalu menyertakan header <code>User-Agent</code> yang valid agar request dari server Anda tidak dicegat oleh sistem Firewall (WAF) server pusat.
                        </p>
                    </div>

                    <div class="guide-box">
                        <h3>2. Lima Skenario Utama Integrasi Data Pasien & Medis</h3>
                        <p>
                            Berikut adalah 5 alur endpoint yang digunakan untuk menyinkronkan data pasien, riwayat kunjungan, serta catatan medis elektronik (EMR/CPPT):
                        </p>

                        <h4>Alur A: Sinkronisasi Master Identitas Pasien</h4>
                        <p>Gunakan untuk mencari data pasien berdasarkan No Rekam Medis (No CM / No RM) atau Nama Lengkap:</p>
                        <ul>
                            <li><strong>Metode:</strong> <code>POST</code> atau <code>GET</code></li>
                            <li><strong>Endpoint:</strong> <code>https://chasanboesoirie.id/service/medifirst2000/emr/get-pasien-by-norm-nocm-nama</code></li>
                            <li><strong>Parameter Query:</strong> <span class="tag-param">norm</span>, <span class="tag-param">nocm</span>, atau <span class="tag-param">namapasien</span></li>
                            <li><strong>Data Kunci:</strong> <code>nocm</code> (Nomor Rekam Medis), <code>namapasien</code>, <code>tgllahir</code>, <code>jeniskelamin</code>, <code>alamatlengkap</code>.</li>
                        </ul>

                        <h4>Alur B: Menarik Riwayat Registrasi Kunjungan (Rajal / Ranap / IGD)</h4>
                        <p>Gunakan untuk mengetahui daftar kunjungan pasien di RSUD Dr. H. Chasan Boesoirie:</p>
                        <ul>
                            <li><strong>Metode:</strong> <code>GET</code></li>
                            <li><strong>Endpoint:</strong> <code>https://chasanboesoirie.id/service/medifirst2000/emr/get-riwayat-registrasirawatjalanranap</code></li>
                            <li><strong>Parameter Query:</strong> <span class="tag-param">nocm=...</span> (No RM Pasien)</li>
                            <li><strong>Data Kunci:</strong> <code>noregistrasi</code>, <code>tglregistrasi</code>, <code>namaruangan</code>, <code>namadokter</code>, <code>kelompokpasien</code> (BPJS/Umum).</li>
                        </ul>

                        <h4>Alur C: Menarik Daftar Dokumen Rekam Medis Elektronik (RME / CPPT)</h4>
                        <p>Gunakan untuk mendapatkan daftar dokumen EMR yang sudah diisi oleh tenaga medis:</p>
                        <ul>
                            <li><strong>Metode:</strong> <code>GET</code></li>
                            <li><strong>Endpoint:</strong> <code>https://chasanboesoirie.id/service/medifirst2000/emr/get-riwayatcppt-rajalranap</code></li>
                            <li><strong>Parameter Query:</strong> <span class="tag-param">nocm=...</span> (No RM Pasien)</li>
                            <li><strong>Data Kunci:</strong> <code>noemr</code> (Contoh: <code>MR2609/00016860</code>), <code>tglregistrasi</code>, <code>namaruangan</code>, <code>status</code>.</li>
                        </ul>

                        <h4>Alur D: Menarik Catatan SOAP CPPT Dokter & Perawat (Rawat Inap)</h4>
                        <p>Gunakan untuk mengekstrak seluruh rincian catatan SOAP, perkembangan kondisi, pemeriksaan fisik, dan instruksi terapi:</p>
                        <ul>
                            <li><strong>Metode:</strong> <code>GET</code></li>
                            <li><strong>Endpoint:</strong> <code>https://chasanboesoirie.id/service/medifirst2000/emr/get-emr-transaksi-detail</code></li>
                            <li><strong>Parameter Query:</strong> <span class="tag-param">noemr=MR2609/00016860</span> dan <span class="tag-param">emrfk=443</span></li>
                            <li><strong>Data Kunci:</strong> Subjektif (keluhan), Objektif (tanda vital tensi/nadi/suhu/respirasi), Asesmen (diagnosa), Plan (terapi/instruksi PPA), dan Nama Dokter Pengisi.</li>
                        </ul>

                        <h4>Alur E: Menarik Catatan Observasi Perawat & Aplosan Dinas (Shift Jaga)</h4>
                        <p>Gunakan untuk menarik catatan serah terima dinas perawat/bidan dan observasi berkala:</p>
                        <ul>
                            <li><strong>Metode:</strong> <code>GET</code></li>
                            <li><strong>Endpoint:</strong> <code>https://chasanboesoirie.id/service/medifirst2000/emr/get-emr-transaksi-detail</code></li>
                            <li><strong>Parameter Query:</strong> <span class="tag-param">noemr=MR2609/00016860</span> dan <span class="tag-param">emrfk=290007</span></li>
                            <li><strong>Data Kunci:</strong> Jam observasi, tindakan asuhan keperawatan, catatan serah terima pergantian shift dinas (Pagi/Sore/Malam).</li>
                        </ul>
                    </div>

                    <div class="guide-box">
                        <h3>3. Kamus Data & Rekomendasi Skema Database Bridging</h3>
                        <p>
                            Bila Anda menyimpan data hasil sinkronisasi ke database lokal SIMRS Anda (MySQL / PostgreSQL), gunakan rekomendasi pemetaan kolom berikut:
                        </p>
                        
                        <table class="mapping-table">
                            <thead>
                                <tr>
                                    <th>Field Respons SIMRS Pusat</th>
                                    <th>Tipe Data</th>
                                    <th>Rekomendasi Kolom SIMRS Lokal</th>
                                    <th>Penjelasan / Fungsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code>nocm</code></td>
                                    <td>VARCHAR(30)</td>
                                    <td><code>simrs_no_rm</code></td>
                                    <td>Nomor Rekam Medis unik pasien</td>
                                </tr>
                                <tr>
                                    <td><code>namapasien</code></td>
                                    <td>VARCHAR(150)</td>
                                    <td><code>nama_lengkap_pasien</code></td>
                                    <td>Nama lengkap pasien sesuai identitas</td>
                                </tr>
                                <tr>
                                    <td><code>noregistrasi</code></td>
                                    <td>VARCHAR(40)</td>
                                    <td><code>no_kunjungan_registrasi</code></td>
                                    <td>Nomor unik transaksi registrasi kunjungan</td>
                                </tr>
                                <tr>
                                    <td><code>noemr</code></td>
                                    <td>VARCHAR(40)</td>
                                    <td><code>no_dokumen_emr</code></td>
                                    <td>Nomor lembar dokumen elektronik CPPT/EMR</td>
                                </tr>
                                <tr>
                                    <td><code>emrfk</code></td>
                                    <td>INT</td>
                                    <td><code>id_template_form</code></td>
                                    <td>443 = CPPT New (SOAP), 290007 = Aplosan Perawat</td>
                                </tr>
                                <tr>
                                    <td><code>namaruangan</code></td>
                                    <td>VARCHAR(100)</td>
                                    <td><code>nama_unit_pelayanan</code></td>
                                    <td>Nama ruangan atau poliklinik perawatan</td>
                                </tr>
                                <tr>
                                    <td><code>namalengkap</code></td>
                                    <td>VARCHAR(150)</td>
                                    <td><code>nama_dokter_ppa</code></td>
                                    <td>Nama dokter spesialis / PPA penanggung jawab</td>
                                </tr>
                                <tr>
                                    <td><code>tglregistrasi</code></td>
                                    <td>DATETIME</td>
                                    <td><code>waktu_registrasi</code></td>
                                    <td>Waktu pendaftaran pasien</td>
                                </tr>
                            </tbody>
                        </table>

                        <h4>Format Struktur JSON Detail SOAP CPPT (emrfk = 443)</h4>
                        <p>Nilai medis detail dapat diurai (parse) dari objek <code>details</code> di dalam respons API:</p>
                        <div class="code-block">
{
  "subjective": details["keluhan_utama"] || details["anamnesis"] || "-",
  "vital_signs": {
    "tensi": details["tensi"] || details["tekanan_darah"],
    "nadi": details["nadi"],
    "respirasi": details["respirasi"],
    "suhu": details["suhu"],
    "spo2": details["spo2"],
    "kesadaran": details["kesadaran"]
  },
  "assessment": details["diagnosa_kerja"] || details["asesmen_medis"],
  "plan": details["terapi"] || details["instruksi_ppa"],
  "ppa_author": details["pegawaifk_nama"] || details["namalengkap"],
  "timestamp": details["tgl_verifikasi"] || details["tglinput"]
}
                        </div>
                    </div>

                    <div class="guide-box">
                        <h3>4. Contoh Kode Lengkap (Direct Hit ke Server SIMRS)</h3>
                        <p>Berikut adalah implementasi kode siap pakai yang langsung menembak ke URL server produksi SIMRS:</p>

                        <h4>Contoh PHP (Laravel HTTP Client / Guzzle)</h4>
                        <div class="code-block">
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SimrsChasanBoesoirieBridging
{
    protected string $baseUrl = 'https://chasanboesoirie.id/service/medifirst2000';
    protected string $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJzdWIiOiJoaXMuamtuIn0...';

    public function fetchPatientCppt(string $noEmr): ?array
    {
        try {
            $response = Http::withoutVerifying()
                ->withHeaders([
                    'X-AUTH-TOKEN' => $this->token,
                    'User-Agent'   => 'SIMRS-Bridging-Client/1.0',
                    'Accept'       => 'application/json',
                ])
                ->withOptions([
                    'force_ip_resolve' => 'v4', // Sangat penting: mencegah SSL EOF di Linux
                    'timeout'          => 35,
                    'connect_timeout'  => 15,
                ])
                ->retry(3, 200)
                ->get("{$this->baseUrl}/emr/get-emr-transaksi-detail", [
                    'noemr' => $noEmr,
                    'emrfk' => 443, // 443 = CPPT New SOAP Rawat Inap
                ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('SIMRS Bridging Error: ' . $response->body());
            return null;
        } catch (\Throwable $e) {
            Log::error('SIMRS Connection Exception: ' . $e->getMessage());
            return null;
        }
    }
}
                        </div>

                        <h4>Contoh Node.js / JavaScript (Axios)</h4>
                        <div class="code-block">
const axios = require('axios');
const https = require('https');

const simrsClient = axios.create({
    baseURL: 'https://chasanboesoirie.id/service/medifirst2000',
    headers: {
        'X-AUTH-TOKEN': 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9...',
        'User-Agent': 'SIMRS-Bridging-Client/1.0',
        'Accept': 'application/json'
    },
    timeout: 30000,
    httpsAgent: new https.Agent({
        rejectUnauthorized: false // Abaikan warning SSL mismatch
    })
});

async function getPatientHistory(noCm) {
    try {
        const response = await simrsClient.get('/emr/get-riwayatcppt-rajalranap', {
            params: { nocm: noCm }
        });
        return response.data;
    } catch (error) {
        console.error('Bridging SIMRS Error:', error.message);
        throw error;
    }
}
                        </div>

                        <h4>Contoh Python (Requests)</h4>
                        <div class="code-block">
import requests

BASE_URL = "https://chasanboesoirie.id/service/medifirst2000"
TOKEN = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9..."

headers = {
    "X-AUTH-TOKEN": TOKEN,
    "User-Agent": "SIMRS-Bridging-Client/1.0",
    "Accept": "application/json"
}

def sync_cppt_detail(no_emr):
    url = f"{BASE_URL}/emr/get-emr-transaksi-detail"
    params = {"noemr": no_emr, "emrfk": 443}
    
    # verify=False digunakan bila server bridging lokal belum menyimpan sertifikat perantara
    response = requests.get(url, headers=headers, params=params, verify=False, timeout=30)
    response.raise_for_status()
    return response.json()
                        </div>

                        <h4>Contoh cURL Langsung</h4>
                        <div class="code-block">
curl -k -X GET \
  'https://chasanboesoirie.id/service/medifirst2000/emr/get-emr-transaksi-detail?noemr=MR2609%2F00016860&emrfk=443' \
  -H 'X-AUTH-TOKEN: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJzdWIiOiJoaXMuamtuIn0...' \
  -H 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)' \
  -H 'Accept: application/json'
                        </div>
                    </div>

                    <div class="guide-box">
                        <h3>5. Rekomendasi Best Practices & Penanganan Masalah Teknis</h3>
                        <ul>
                            <li>
                                <strong>Penyelesaian Error SSL Unexpected EOF:</strong> Jika server Linux Anda mengalami galat <code>SSL: Unexpected EOF</code> saat memanggil <code>https://chasanboesoirie.id</code>, konfigurasikan cURL/Guzzle dengan opsi <code>CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4</code> (memaksa resolusi alamat IP IPv4).
                            </li>
                            <li>
                                <strong>Bug Backend Medifirst2000 pada Endpoint <code>emr/get-cppt</code>:</strong> Hindari mengirim parameter <code>noregistrasifk</code> ke endpoint <code>emr/get-cppt</code> karena dapat memicu galat internal <code>missing table rm</code> di server pusat. Gunakan kombinasi <code>emr/get-riwayatcppt-rajalranap</code> dan <code>emr/get-emr-transaksi-detail</code> yang telah teruji 100% stabil.
                            </li>
                            <li>
                                <strong>Strategi Antrean Asinkronus (Queue / Background Sync):</strong> Disarankan untuk tidak memanggil penarikan data secara sinkron saat petugas membuka form. Jalankan sinkronisasi via background worker (Job Queue) atau cron berkala agar performa antarmuka pengguna SIMRS Anda tetap cepat meskipun server pusat sedang melayani ribuan transaksi.
                            </li>
                            <li>
                                <strong>Penanganan 504 Gateway Timeout:</strong> Saat jam sibuk operasional rumah sakit (pagi hari), terapkan mekanisme retry otomatis sebanyak 3 kali dengan jeda eksponensial (200ms, 400ms, 800ms) untuk memastikan data berhasil ditarik tanpa memutus proses bridging.
                            </li>
                        </ul>
                    </div>

                </div>
            @endif

            <!-- TAB 4: USER MANAGEMENT (SUPERADMIN ONLY) -->
            @if($activeTab === 'users' && $user->isSuperAdmin())
                <div class="users-container">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <div>
                            <h3 style="font-size: 16px; font-weight: 700; color: #0f172a;">Daftar Akun & Pengendalian Sesi</h3>
                            <p style="font-size: 12px; color: #64748b;">Kelola akun pengguna, hak akses role, serta kendali pemutusan sesi perangkat aktif.</p>
                        </div>
                        <button onclick="openModal('modal-add-user')" class="btn-action-primary">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                            <span>Tambah Pengguna Baru</span>
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="users-table">
                            <thead>
                                <tr>
                                    <th>Pengguna</th>
                                    <th>Role</th>
                                    <th>Status Akun</th>
                                    <th>Perangkat Aktif & Sesi</th>
                                    <th>Login Terakhir</th>
                                    <th style="text-align: right;">Aksi Kontrol</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $u)
                                    <tr>
                                        <td>
                                            <div class="user-primary">{{ $u->name }}</div>
                                            <div class="user-sub">{{ $u->username }} &bull; {{ $u->email }}</div>
                                        </td>
                                        <td>
                                            <span class="role-pill {{ $u->isSuperAdmin() ? 'role-superadmin' : 'role-pengakses' }}">
                                                {{ $u->role }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($u->is_active)
                                                <span class="status-badge status-active">Aktif</span>
                                            @else
                                                <span class="status-badge status-inactive">Nonaktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($u->current_session_id)
                                                <div style="display: flex; align-items: center; gap: 6px;">
                                                    <span class="status-dot"></span>
                                                    <span style="font-size: 12px; font-weight: 600; color: #0f172a;">{{ $u->last_device ?? 'Browser Web' }}</span>
                                                </div>
                                                <div class="user-sub">IP: {{ $u->last_login_ip ?? '-' }}</div>
                                            @else
                                                <span style="font-size: 12px; color: #94a3b8;">Tidak ada sesi aktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div style="font-size: 12px; color: #334155;">
                                                {{ $u->last_login_at ? $u->last_login_at->format('d M Y, H:i') : '-' }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="actions-cell" style="justify-content: flex-end;">
                                                <!-- KICK SESSION BUTTON -->
                                                @if($u->current_session_id)
                                                    <form action="{{ route('users.terminate-session', $u->id) }}" method="POST" onsubmit="return confirm('Putus sesi perangkat aktif untuk {{ $u->username }}? Pengguna akan otomatis di-logout.');">
                                                        @csrf
                                                        <button type="submit" class="btn-action btn-action-warning" title="Putus Sesi Perangkat">
                                                            Putus Sesi
                                                        </button>
                                                    </form>
                                                @endif

                                                <!-- TOGGLE STATUS -->
                                                @if($u->id !== $user->id)
                                                    <form action="{{ route('users.toggle-status', $u->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn-action {{ $u->is_active ? 'btn-action-warning' : 'btn-action-info' }}">
                                                            {{ $u->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                                        </button>
                                                    </form>
                                                @endif

                                                <!-- RESET PASSWORD -->
                                                <button type="button" onclick="openResetModal({{ $u->id }}, '{{ $u->username }}')" class="btn-action btn-action-info">
                                                    Reset Password
                                                </button>

                                                <!-- DELETE -->
                                                @if($u->id !== $user->id)
                                                    <form action="{{ route('users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun {{ $u->username }}?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-action btn-action-danger">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

        </div>
    </main>

    <!-- MODAL ADD USER -->
    <div id="modal-add-user" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">Tambah Pengguna Baru</span>
                <button type="button" class="btn-close" onclick="closeModal('modal-add-user')">&times;</button>
            </div>
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-input" value="{{ old('name') }}" placeholder="Contoh: Budi Santoso" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-input" value="{{ old('username') }}" placeholder="Contoh: admin_baru" required pattern="[a-zA-Z0-9_\-]+" title="Hanya huruf, angka, minus (-), dan garis bawah (_), tanpa spasi">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Alamat Email</label>
                        <input type="email" name="email" class="form-input" value="{{ old('email') }}" placeholder="Contoh: admin@rsud.id" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kata Sandi Awal</label>
                        <input type="password" name="password" class="form-input" placeholder="Minimal 6 karakter" required minlength="6">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Peran (Role)</label>
                        <select name="role" class="form-select" required>
                            <option value="superadmin" {{ old('role') === 'superadmin' ? 'selected' : '' }}>Superadmin (Akses Penuh & Manajemen Pengguna)</option>
                            <option value="pengakses" {{ old('role') === 'pengakses' ? 'selected' : '' }}>Pengakses (Hanya Melihat & Menguji API)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" onclick="closeModal('modal-add-user')">Batal</button>
                    <button type="submit" class="btn-action-primary">Simpan Pengguna</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL RESET PASSWORD -->
    <div id="modal-reset-password" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">Reset Kata Sandi</span>
                <button type="button" class="btn-close" onclick="closeModal('modal-reset-password')">&times;</button>
            </div>
            <form id="form-reset-password" action="" method="POST">
                @csrf
                <div class="modal-body">
                    <p style="font-size: 13px; color: #64748b; margin-bottom: 14px;">
                        Mengatur ulang kata sandi untuk akun <strong id="reset-user-name" style="color: #0f172a;"></strong>. Sesi perangkat yang sedang aktif akan otomatis diputus.
                    </p>
                    <div class="form-group">
                        <label class="form-label">Kata Sandi Baru</label>
                        <input type="password" name="new_password" class="form-input" placeholder="Minimal 6 karakter" required minlength="6">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" onclick="closeModal('modal-reset-password')">Batal</button>
                    <button type="submit" class="btn-action-primary">Perbarui Sandi</button>
                </div>
            </form>
        </div>
    </div>

    <!-- TOAST NOTIFICATION -->
    <div id="copyToast" class="toast-notify">
        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5">
            <polyline points="20 6 9 17 4 12"></polyline>
        </svg>
        <span id="toastMessage">Base URL berhasil disalin ke clipboard!</span>
    </div>

    <script>
        // Modal functions
        function openModal(id) {
            document.getElementById(id).classList.add('active');
        }
        function closeModal(id) {
            document.getElementById(id).classList.remove('active');
        }
        function openResetModal(userId, username) {
            document.getElementById('reset-user-name').textContent = username;
            document.getElementById('form-reset-password').action = '/users/' + userId + '/reset-password';
            openModal('modal-reset-password');
        }
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.classList.remove('active');
            }
        };

        // Collapsible Sidebar Functions
        function toggleSidebar() {
            const sidebar = document.getElementById('mainSidebar');
            if (!sidebar) return;
            sidebar.classList.toggle('collapsed');
            const isCollapsed = sidebar.classList.contains('collapsed');
            localStorage.setItem('simrs_sidebar_collapsed', isCollapsed ? '1' : '0');
        }

        // Initialize sidebar state on load
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('mainSidebar');
            if (sidebar && localStorage.getItem('simrs_sidebar_collapsed') === '1') {
                sidebar.classList.add('collapsed');
            }

            const sidebarBtn = document.getElementById('sidebarToggleBtn');
            const topbarBtn = document.getElementById('topbarToggleBtn');

            if (sidebarBtn) sidebarBtn.addEventListener('click', toggleSidebar);
            if (topbarBtn) topbarBtn.addEventListener('click', toggleSidebar);

            @if(!empty($errors) && $errors->any())
                openModal('modal-add-user');
            @endif
        });

        // Copy Base URL to Clipboard
        function copyBaseUrl() {
            const url = 'https://chasanboesoirie.id/service/medifirst2000/';
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(url).then(showToast).catch(function() {
                    fallbackCopy(url);
                });
            } else {
                fallbackCopy(url);
            }
        }

        function fallbackCopy(text) {
            const textArea = document.createElement('textarea');
            textArea.value = text;
            textArea.style.position = 'fixed';
            textArea.style.left = '-999999px';
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            try {
                document.execCommand('copy');
                showToast();
            } catch (err) {}
            document.body.removeChild(textArea);
        }

        function showToast() {
            const toast = document.getElementById('copyToast');
            if (!toast) return;
            toast.classList.add('show');
            setTimeout(function() {
                toast.classList.remove('show');
            }, 2500);
        }
    </script>
</body>
</html>
