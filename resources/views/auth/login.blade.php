<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Portal API SIMRS - RSUD Dr. H. Chasan Boesoirie</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #e0f2fe 0%, #f0f9ff 40%, #ffffff 70%, #dbeafe 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            overflow-x: hidden;
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

        .floating-element {
            position: absolute;
            border-radius: 50%;
            filter: blur(1px);
            animation: floatSlow 8s ease-in-out infinite;
        }

        .orb-1 {
            width: 320px;
            height: 320px;
            background: radial-gradient(circle at 30% 30%, rgba(56, 189, 248, 0.45), rgba(2, 132, 199, 0.15) 70%, transparent 85%);
            top: -60px;
            left: -80px;
            box-shadow: 0 20px 60px rgba(2, 132, 199, 0.2);
            animation-duration: 9s;
        }

        .orb-2 {
            width: 380px;
            height: 380px;
            background: radial-gradient(circle at 70% 70%, rgba(2, 132, 199, 0.35), rgba(186, 230, 253, 0.2) 65%, transparent 85%);
            bottom: -100px;
            right: -100px;
            box-shadow: 0 25px 70px rgba(2, 132, 199, 0.15);
            animation-duration: 11s;
            animation-delay: -3s;
        }

        .cube-3d {
            position: absolute;
            width: 90px;
            height: 90px;
            border-radius: 20px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9), rgba(224, 242, 254, 0.6));
            border: 2px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 20px 40px rgba(2, 132, 199, 0.2), inset 0 2px 6px rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(8px);
            transform: rotate(25deg) skew(-10deg);
            animation: floatRotate 10s ease-in-out infinite;
        }

        .cube-top-right {
            top: 15%;
            right: 12%;
            animation-duration: 12s;
        }

        .cube-bottom-left {
            bottom: 12%;
            left: 10%;
            width: 70px;
            height: 70px;
            animation-duration: 8s;
            animation-delay: -4s;
        }

        .ring-3d {
            position: absolute;
            width: 140px;
            height: 140px;
            border-radius: 50%;
            border: 8px solid rgba(2, 132, 199, 0.18);
            border-top-color: rgba(2, 132, 199, 0.55);
            top: 25%;
            left: 8%;
            transform: rotateX(60deg) rotateY(20deg);
            animation: spinSlow 20s linear infinite;
        }

        @keyframes floatSlow {
            0%, 100% { transform: translateY(0px) scale(1); }
            50% { transform: translateY(-24px) scale(1.04); }
        }

        @keyframes floatRotate {
            0%, 100% { transform: translateY(0px) rotate(25deg) skew(-10deg); }
            50% { transform: translateY(-30px) rotate(40deg) skew(-6deg); }
        }

        @keyframes spinSlow {
            from { transform: rotateX(60deg) rotateY(20deg) rotateZ(0deg); }
            to { transform: rotateX(60deg) rotateY(20deg) rotateZ(360deg); }
        }

        /* 3D PERSPECTIVE WRAPPER */
        .perspective-container {
            perspective: 1200px;
            z-index: 10;
            width: 100%;
            max-width: 440px;
        }

        /* 3D GLASS CARD */
        .login-card-3d {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.95);
            border-radius: 24px;
            padding: 36px 32px 30px;
            box-shadow: 
                0 30px 60px -12px rgba(2, 132, 199, 0.22),
                0 18px 36px -18px rgba(15, 23, 42, 0.12),
                inset 0 1px 2px rgba(255, 255, 255, 1);
            transform-style: preserve-3d;
            transition: transform 0.2s cubic-bezier(0.2, 0, 0, 1), box-shadow 0.2s ease;
            position: relative;
        }

        /* 3D EMBLEM BADGE */
        .emblem-wrapper {
            display: flex;
            justify-content: center;
            margin-bottom: 18px;
            transform: translateZ(40px);
        }

        .emblem-3d {
            width: 68px;
            height: 68px;
            background: linear-gradient(145deg, #0284c7, #0369a1);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 26px;
            font-weight: 800;
            letter-spacing: 0.5px;
            box-shadow: 
                0 16px 32px rgba(2, 132, 199, 0.38),
                inset 0 3px 6px rgba(255, 255, 255, 0.55),
                inset 0 -3px 6px rgba(0, 0, 0, 0.2);
            position: relative;
            transform: perspective(600px) rotateX(10deg);
            transition: transform 0.3s ease;
        }

        .emblem-3d::after {
            content: '';
            position: absolute;
            top: 4px;
            left: 10px;
            right: 10px;
            height: 40%;
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0.5), transparent);
            border-radius: 14px 14px 80px 80px;
            pointer-events: none;
        }

        .card-header-3d {
            text-align: center;
            margin-bottom: 24px;
            transform: translateZ(30px);
        }

        .hospital-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #e0f2fe;
            color: #0284c7;
            border: 1px solid #bae6fd;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.6px;
            padding: 4px 12px;
            border-radius: 9999px;
            text-transform: uppercase;
            margin-bottom: 10px;
            box-shadow: 0 2px 8px rgba(2, 132, 199, 0.1);
        }

        .title-3d {
            font-size: 22px;
            font-weight: 800;
            color: #0369a1;
            letter-spacing: -0.5px;
            margin-bottom: 4px;
        }

        .subtitle-3d {
            font-size: 13px;
            color: #64748b;
        }

        /* ALERTS */
        .alert-3d {
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 12px;
            line-height: 1.5;
            margin-bottom: 20px;
            transform: translateZ(25px);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .alert-danger-3d {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #b91c1c;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.1);
        }

        .alert-success-3d {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #15803d;
            box-shadow: 0 4px 12px rgba(34, 197, 94, 0.1);
        }

        /* FORM ELEMENTS WITH 3D DEPTH */
        .form-group-3d {
            margin-bottom: 18px;
            transform: translateZ(25px);
        }

        .label-3d {
            display: block;
            font-size: 12px;
            font-weight: 700;
            color: #0369a1;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-wrapper-3d {
            position: relative;
        }

        .input-3d {
            width: 100%;
            padding: 12px 16px;
            background: #ffffff;
            border: 1.5px solid #cbd5e1;
            border-radius: 12px;
            font-size: 14px;
            color: #0f172a;
            outline: none;
            transition: all 0.2s ease;
            box-shadow: inset 0 2px 4px rgba(15, 23, 42, 0.04);
        }

        .input-3d:focus {
            border-color: #0284c7;
            background: #ffffff;
            box-shadow: 
                0 0 0 4px rgba(2, 132, 199, 0.18),
                0 4px 12px rgba(2, 132, 199, 0.1);
            transform: translateY(-1px);
        }

        .form-check-3d {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            color: #475569;
            margin-bottom: 22px;
            transform: translateZ(20px);
            cursor: pointer;
            user-select: none;
        }

        .form-check-3d input {
            accent-color: #0284c7;
            width: 15px;
            height: 15px;
            cursor: pointer;
        }

        /* 3D PUSHABLE BUTTON */
        .btn-submit-3d {
            width: 100%;
            padding: 13px 20px;
            background: linear-gradient(180deg, #0284c7 0%, #0369a1 100%);
            color: #ffffff;
            border: none;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 0.5px;
            cursor: pointer;
            position: relative;
            transform: translateZ(35px);
            box-shadow: 
                0 8px 24px rgba(2, 132, 199, 0.35),
                0 4px 0 #075985,
                inset 0 1px 2px rgba(255, 255, 255, 0.4);
            transition: all 0.15s ease;
        }

        .btn-submit-3d:hover {
            background: linear-gradient(180deg, #0369a1 0%, #075985 100%);
            transform: translateZ(35px) translateY(-2px);
            box-shadow: 
                0 12px 28px rgba(2, 132, 199, 0.4),
                0 5px 0 #075985,
                inset 0 1px 2px rgba(255, 255, 255, 0.4);
        }

        .btn-submit-3d:active {
            transform: translateZ(35px) translateY(2px);
            box-shadow: 
                0 4px 12px rgba(2, 132, 199, 0.3),
                0 1px 0 #075985;
        }

        /* 3D SECURITY FOOTER BADGE */
        .card-footer-3d {
            margin-top: 24px;
            padding-top: 18px;
            border-top: 1px solid #e0f2fe;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 11px;
            color: #64748b;
            transform: translateZ(20px);
        }

        .pulse-beacon {
            width: 8px;
            height: 8px;
            background: #10b981;
            border-radius: 50%;
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            animation: beaconPulse 2s infinite;
        }

        @keyframes beaconPulse {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }
    </style>
</head>
<body>

    <!-- 3D FLOATING BACKGROUND -->
    <div class="bg-3d-scene">
        <div class="floating-element orb-1"></div>
        <div class="floating-element orb-2"></div>
        <div class="cube-3d cube-top-right"></div>
        <div class="cube-3d cube-bottom-left"></div>
        <div class="ring-3d"></div>
    </div>

    <!-- 3D PERSPECTIVE CONTAINER -->
    <div class="perspective-container">
        <div class="login-card-3d" id="card3d">
            
            <div class="emblem-wrapper">
                <div class="emblem-3d">RS</div>
            </div>

            <div class="card-header-3d">
                <div class="hospital-chip">
                    <span>RSUD Dr. H. Chasan Boesoirie</span>
                </div>
                <h1 class="title-3d">SIMRS API PORTAL</h1>
                <p class="subtitle-3d">Masuk untuk mengakses Swagger & Panduan Bridging API</p>
            </div>

            @if(session('success'))
                <div class="alert-3d alert-success-3d">
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(!empty($errors) && $errors->any())
                <div class="alert-3d alert-danger-3d">
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="form-group-3d">
                    <label class="label-3d">Username / Email</label>
                    <div class="input-wrapper-3d">
                        <input type="text" name="login" class="input-3d" value="{{ old('login') }}" placeholder="Masukkan username atau email" required autofocus autocomplete="username">
                    </div>
                </div>

                <div class="form-group-3d">
                    <label class="label-3d">Kata Sandi</label>
                    <div class="input-wrapper-3d">
                        <input type="password" name="password" class="input-3d" placeholder="Masukkan kata sandi akun" required autocomplete="current-password">
                    </div>
                </div>

                <label class="form-check-3d">
                    <input type="checkbox" name="remember">
                    <span>Ingat sesi masuk di perangkat ini</span>
                </label>

                <button type="submit" class="btn-submit-3d">
                    Masuk ke Sistem API
                </button>
            </form>

            <div class="card-footer-3d">
                <span class="pulse-beacon"></span>
                <span>Proteksi 1 Akun 1 Perangkat &bull; JWT Auth Secured</span>
            </div>

        </div>
    </div>

    <script>
        // Interactive 3D Card Parallax on Mouse Move
        const card = document.getElementById('card3d');
        const container = document.querySelector('.perspective-container');

        if (window.matchMedia('(pointer: fine)').matches) {
            window.addEventListener('mousemove', (e) => {
                const rect = card.getBoundingClientRect();
                const cardX = rect.left + rect.width / 2;
                const cardY = rect.top + rect.height / 2;

                const deltaX = (e.clientX - cardX) / (window.innerWidth / 2);
                const deltaY = (e.clientY - cardY) / (window.innerHeight / 2);

                const rotateY = deltaX * 12; // tilt angle max 12 deg
                const rotateX = -deltaY * 12;

                card.style.transform = `rotateX(${rotateX.toFixed(2)}deg) rotateY(${rotateY.toFixed(2)}deg)`;
            });

            window.addEventListener('mouseleave', () => {
                card.style.transform = 'rotateX(0deg) rotateY(0deg)';
            });
        }
    </script>

</body>
</html>
