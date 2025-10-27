<!DOCTYPE html>
<html lang="ar" dir="rtl" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', $site_settings['site_name'] ?? env('APP_NAME','متجرنا'))</title>

    <!-- Tailwind (Dev CDN) - للإنتاج يُفضّل البناء عبر CLI/PostCSS -->
   @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Fonts / Icons -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- AOS CSS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <style>
    :root {
        --primary: #2563eb;
        --primary-dark: #1e40af;
        --secondary: #7c3aed;
        --accent: #f59e0b;
        --success: #10b981;
        --danger: #ef4444;
        --sidebar-width: 280px;
        --header-h: 64px;
        --radius-sm: 0.5rem;
        --radius-md: 0.75rem;
        --radius-lg: 1rem;
        --shadow-sm: 0 1px 3px 0 rgb(0 0 0 / 0.1);
        --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
        --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1);
    }

    * {
        font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        box-sizing: border-box;
    }

    html {
        scroll-behavior: smooth;
        -webkit-text-size-adjust: 100%;
    }

    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
    }

    body {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        color: #0f172a;
        line-height: 1.6;
        overflow-x: hidden;
    }

    /* Safe area for mobile */
    .safe-area {
        padding-left: env(safe-area-inset-left);
        padding-right: env(safe-area-inset-right);
        padding-bottom: env(safe-area-inset-bottom);
    }

    /* ========== HEADER STYLES ========== */
    .topbar {
        backdrop-filter: saturate(180%) blur(20px);
        background: rgba(255, 255, 255, 0.92);
        border-bottom: 1px solid rgba(0, 0, 0, 0.08);
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
    }

    .topbar.scrolled {
        background: rgba(255, 255, 255, 0.98);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
    }

    /* Logo animation */
    .logo-container {
        position: relative;
        transition: transform 0.3s ease;
    }

    .logo-container:hover {
        transform: scale(1.05) rotate(-2deg);
    }

    .logo-container::after {
        content: '';
        position: absolute;
        inset: -3px;
        background: linear-gradient(45deg, var(--primary), var(--secondary));
        border-radius: 50%;
        opacity: 0;
        z-index: -1;
        transition: opacity 0.3s ease;
    }

    .logo-container:hover::after {
        opacity: 0.3;
        animation: pulse 2s infinite;
    }

    /* Search bar enhancement */
    .search-bar {
        transition: all 0.3s ease;
    }

    .search-bar:focus-within {
        box-shadow: 0 8px 24px rgba(37, 99, 235, 0.15);
        transform: translateY(-2px);
    }

    /* ========== SIDEBAR STYLES ========== */
    .app-sidebar {
        width: var(--sidebar-width);
        background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
        border-left: 1px solid rgba(0, 0, 0, 0.06);
        box-shadow: 4px 0 24px rgba(0, 0, 0, 0.04);
    }

    .sidebar-link {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        padding: 0.75rem 1rem;
        border-radius: var(--radius-md);
        color: #475569;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.2s ease;
        position: relative;
        overflow: hidden;
    }

    .sidebar-link::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: var(--primary);
        transform: scaleY(0);
        transition: transform 0.2s ease;
    }

    .sidebar-link:hover {
        background: linear-gradient(90deg, rgba(37, 99, 235, 0.08), transparent);
        color: var(--primary-dark);
        transform: translateX(-4px);
    }

    .sidebar-link:hover::before {
        transform: scaleY(1);
    }

    .sidebar-active {
        background: linear-gradient(90deg, rgba(37, 99, 235, 0.12), rgba(124, 58, 237, 0.08));
        color: var(--primary);
        box-shadow: 0 4px 16px rgba(37, 99, 235, 0.15);
        font-weight: 700;
    }

    .sidebar-active::before {
        transform: scaleY(1);
    }

    .sidebar-scroll::-webkit-scrollbar {
        width: 6px;
    }

    .sidebar-scroll::-webkit-scrollbar-track {
        background: transparent;
    }

    .sidebar-scroll::-webkit-scrollbar-thumb {
        background: rgba(15, 23, 42, 0.15);
        border-radius: 8px;
    }

    .sidebar-scroll::-webkit-scrollbar-thumb:hover {
        background: rgba(15, 23, 42, 0.25);
    }

    /* ========== MOBILE NAVIGATION ========== */
    .mobile-nav {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 60;
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        border-top: 1px solid rgba(0, 0, 0, 0.08);
        box-shadow: 0 -4px 24px rgba(0, 0, 0, 0.08);
        padding: 0.5rem 0;
    }

    .mobile-nav a {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.25rem;
        padding: 0.6rem 0.25rem;
        color: #64748b;
        text-decoration: none;
        font-size: 0.7rem;
        font-weight: 600;
        transition: all 0.2s ease;
        position: relative;
    }

    .mobile-nav a i {
        font-size: 1.25rem;
        transition: all 0.2s ease;
    }

    .mobile-nav a.active {
        color: var(--primary);
    }

    .mobile-nav a.active i {
        transform: scale(1.15);
    }

    .mobile-nav a::before {
        content: '';
        position: absolute;
        top: -2px;
        left: 50%;
        transform: translateX(-50%) scaleX(0);
        width: 40px;
        height: 3px;
        background: var(--primary);
        border-radius: 0 0 4px 4px;
        transition: transform 0.2s ease;
    }

    .mobile-nav a.active::before {
        transform: translateX(-50%) scaleX(1);
    }

    /* ========== BADGES ========== */
    .badge {
        background: linear-gradient(135deg, var(--danger) 0%, #dc2626 100%);
        color: #fff;
        border-radius: 999px;
        padding: 0 6px;
        font-size: 10px;
        line-height: 18px;
        min-width: 18px;
        text-align: center;
        font-weight: 700;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.4);
        animation: badge-pulse 2s infinite;
    }

    @keyframes badge-pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }

    /* ========== CONTAINERS ========== */
    .container-page {
        max-width: 1400px;
        margin-inline: auto;
        padding-inline: 1.25rem;
    }

    @media (min-width: 640px) {
        .container-page {
            padding-inline: 1.5rem;
        }
    }

    @media (min-width: 1024px) {
        .container-page {
            padding-inline: 2rem;
        }
    }

    @media (min-width: 1024px) {
        main.content {
            padding-left: calc(var(--sidebar-width) + 2rem);
        }
    }

    /* ========== BUTTONS & CHIPS ========== */
    .chip {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.6rem 1rem;
        border-radius: 999px;
        background: #f1f5f9;
        color: #1f2937;
        font-weight: 700;
        font-size: 0.85rem;
        transition: all 0.2s ease;
        white-space: nowrap;
        border: 2px solid transparent;
    }

    .chip:hover {
        background: #e2e8f0;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .chip.is-active {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        color: #fff;
        box-shadow: 0 8px 24px rgba(37, 99, 235, 0.3);
        border-color: var(--primary);
    }

    .chip-select {
        padding: 0.55rem 0.9rem;
        border-radius: 999px;
        background: #ffffff;
        border: 2px solid #e5e7eb;
        font-size: 0.85rem;
        font-weight: 600;
        color: #374151;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .chip-select:hover {
        border-color: var(--primary);
        box-shadow: var(--shadow-md);
    }

    .chip-select:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    /* ========== CARDS & PRODUCT ITEMS ========== */
    .product-card {
        background: #ffffff;
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(0, 0, 0, 0.04);
    }

    .product-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 24px 48px rgba(0, 0, 0, 0.12);
        border-color: rgba(37, 99, 235, 0.2);
    }

    .product-image-wrapper {
        position: relative;
        overflow: hidden;
        padding-top: 100%;
        background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
    }

    .product-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .product-card:hover .product-image {
        transform: scale(1.1);
    }

    .product-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        background: linear-gradient(135deg, var(--danger), #dc2626);
        color: white;
        padding: 0.4rem 0.8rem;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 700;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
        animation: badge-bounce 2s infinite;
    }

    @keyframes badge-bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-4px); }
    }

    .product-info {
        padding: 1.25rem;
    }

    .product-title {
        font-size: 1rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.5rem;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        transition: color 0.2s ease;
    }

    .product-card:hover .product-title {
        color: var(--primary);
    }

    .rating-stars {
        color: #fbbf24;
        font-size: 0.9rem;
        display: flex;
        gap: 0.15rem;
    }

    .price-wrapper {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-top: 0.75rem;
        flex-wrap: wrap;
    }

    .price-current {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--success);
    }

    .price-old {
        font-size: 1rem;
        color: #94a3b8;
        text-decoration: line-through;
    }

    .discount-badge {
        background: linear-gradient(135deg, #fecaca, #fca5a5);
        color: #991b1b;
        padding: 0.25rem 0.6rem;
        border-radius: 999px;
        font-size: 0.7rem;
        font-weight: 700;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: var(--radius-md);
        border: none;
        font-weight: 700;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 16px rgba(37, 99, 235, 0.3);
        position: relative;
        overflow: hidden;
    }

    .btn-primary::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .btn-primary:hover::before {
        width: 300px;
        height: 300px;
    }

    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 32px rgba(37, 99, 235, 0.4);
    }

    .btn-primary:active {
        transform: translateY(-1px);
    }

    .btn-secondary {
        background: #f1f5f9;
        color: #334155;
        padding: 0.75rem 1.5rem;
        border-radius: var(--radius-md);
        border: 2px solid #e2e8f0;
        font-weight: 700;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-secondary:hover {
        background: #e2e8f0;
        border-color: var(--primary);
        color: var(--primary);
        transform: translateY(-2px);
    }

    /* ========== FOOTER ENHANCEMENT ========== */
    footer {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        position: relative;
        overflow: hidden;
    }

    footer::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    }

    footer h3 {
        position: relative;
        display: inline-block;
    }

    footer h3::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 0;
        width: 40px;
        height: 3px;
        background: linear-gradient(90deg, var(--accent), var(--primary));
        border-radius: 999px;
    }

    footer a {
        transition: all 0.2s ease;
        display: inline-block;
    }

    footer a:hover {
        transform: translateX(-4px);
        color: var(--accent) !important;
    }

    /* ========== ANIMATIONS ========== */
    @keyframes pulse {
        0%, 100% { opacity: 0.3; transform: scale(1); }
        50% { opacity: 0.5; transform: scale(1.05); }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideInRight {
        from {
            transform: translateX(100%);
        }
        to {
            transform: translateX(0);
        }
    }

    .animate-fade-in-up {
        animation: fadeInUp 0.6s ease-out;
    }

    /* ========== TOAST NOTIFICATIONS ========== */
    .toast {
        position: fixed;
        top: 1rem;
        right: 1rem;
        z-index: 100;
        min-width: 300px;
        max-width: 500px;
        padding: 1rem 1.25rem;
        border-radius: var(--radius-lg);
        box-shadow: 0 16px 48px rgba(0, 0, 0, 0.2);
        backdrop-filter: blur(10px);
        animation: slideInRight 0.3s ease-out;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .toast.success {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }

    .toast.error {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
    }

    .toast.info {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
    }

    /* ========== FORM INPUTS ========== */
    input[type="text"],
    input[type="email"],
    input[type="password"],
    input[type="search"],
    textarea,
    select {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #e2e8f0;
        border-radius: var(--radius-md);
        font-size: 0.95rem;
        transition: all 0.2s ease;
        background: white;
    }

    input:focus,
    textarea:focus,
    select:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
    }

    /* ========== GRID LAYOUTS ========== */
    .grid-products {
        display: grid;
        gap: 1.5rem;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    }

    @media (max-width: 640px) {
        .grid-products {
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 1rem;
        }
    }

    /* ========== RESPONSIVE UTILITIES ========== */
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }

    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    /* Hide scrollbar on mobile */
    @media (max-width: 768px) {
        body::-webkit-scrollbar {
            display: none;
        }
    }

    /* ========== LOADING STATES ========== */
    .skeleton {
        background: linear-gradient(90deg, #f1f5f9 25%, #e2e8f0 50%, #f1f5f9 75%);
        background-size: 200% 100%;
        animation: loading 1.5s infinite;
    }

    @keyframes loading {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }

    /* ========== ACCESSIBILITY ========== */
    .sr-only:not(:focus):not(:active) {
        clip: rect(0 0 0 0);
        clip-path: inset(50%);
        height: 1px;
        overflow: hidden;
        position: absolute;
        white-space: nowrap;
        width: 1px;
    }

    /* ========== DARK MODE SUPPORT (Optional) ========== */
    @media (prefers-color-scheme: dark) {
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: #f1f5f9;
        }

        .topbar {
            background: rgba(15, 23, 42, 0.92);
            border-bottom-color: rgba(255, 255, 255, 0.08);
        }

        .app-sidebar {
            background: linear-gradient(180deg, #1e293b, #0f172a);
            border-left-color: rgba(255, 255, 255, 0.08);
        }

        .sidebar-link {
            color: #cbd5e1;
        }

        .sidebar-link:hover {
            background: rgba(59, 130, 246, 0.15);
            color: #93c5fd;
        }

        .product-card {
            background: #1e293b;
            border-color: rgba(255, 255, 255, 0.08);
        }

        .product-title {
            color: #f1f5f9;
        }
    }

    /* ========== PRINT STYLES ========== */
    @media print {
        .topbar,
        .app-sidebar,
        .mobile-nav,
        footer {
            display: none;
        }

        main.content {
            padding-left: 0;
        }
    }
</style>

    @stack('styles')
</head>
<body class="safe-area antialiased" x-data="{ sidebarOpen:false, searchOpen:false }" @keydown.window.escape="sidebarOpen=false; searchOpen=false">

@php
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Storage;

    $user = auth()->user();

    // Logo
    $logoUrl = $site_settings_urls['logo'] ?? null;
    if (!$logoUrl) {
        if (Storage::disk('public')->exists('images/default-logo.png')) {
            $logoUrl = asset('storage/images/default-logo.png');
        } else {
            $logoUrl = asset('images/default-logo.png');
        }
    }

    // Avatar
    $avatarUrl = asset('storage/images/default-avatar.png');
    if ($user && $user->avatar) {
        $ua = $user->avatar;
        if (Str::startsWith($ua, ['http://','https://'])) {
            $avatarUrl = $ua;
        } elseif (Storage::disk('public')->exists(ltrim($ua, '/'))) {
            $avatarUrl = asset('storage/' . ltrim($ua, '/'));
        }
    } elseif (!empty($site_settings_urls['avatar'])) {
        $sa = $site_settings_urls['avatar'];
        if (Str::startsWith($sa, ['http://','https://'])) {
            $avatarUrl = $sa;
        } elseif (Storage::disk('public')->exists(ltrim($sa, '/'))) {
            $avatarUrl = asset('storage/' . ltrim($sa, '/'));
        }
    }

    // Currency
    $currency = $site_settings['currency'] ?? \App\Models\Setting::getValue('currency') ?? 'EGP';
    $currencyRate = (float) ($site_settings['currency_rate'] ?? \App\Models\Setting::getValue('currency_rate') ?? 1);
    if ($currencyRate <= 0) $currencyRate = 1.0;
    $currencySymbol = $currency === 'EGP' ? 'ج.م' : ($currency === 'USD' ? '$' : $currency);

    // Cart count
    $cart = session('cart', []);
    $cartServerCount = 0;
    if (is_array($cart)) {
        foreach ($cart as $ci) { $cartServerCount += (int) ($ci['quantity'] ?? 0); }
    }
@endphp

<a href="#main" class="sr-only focus:not-sr-only focus:absolute focus:top-2 focus:right-2 focus:bg-white focus:text-blue-700 focus:rounded-md focus:px-3 focus:py-2">تخطي إلى المحتوى</a>

<!-- Header -->
<header class="topbar fixed inset-x-0 top-0 z-50 shadow-sm border-b border-slate-100">
    <div class="container-page">
        <div class="flex items-center justify-between h-16">
            <!-- Menu + Brand -->
            <div class="flex items-center gap-3">
                <button @click="sidebarOpen = true" class="md:hidden p-2 rounded-lg text-slate-700 hover:bg-slate-100" aria-label="القائمة">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm overflow-hidden ring-1 ring-slate-100">
                        <img src="{{ $logoUrl }}" alt="logo" class="w-full h-full object-cover" onerror="this.onerror=null;this.src='{{ asset('storage/images/default-logo.png') }}'">
                    </div>
                    <div class="hidden sm:block">
                        <div class="text-base md:text-lg font-extrabold text-slate-800">{{ $site_settings['site_name'] ?? config('app.name') }}</div>
                        <div class="text-[11px] text-slate-500">{{ $site_settings['site_description'] ?? '' }}</div>
                    </div>
                </a>
            </div>

            <!-- Search (desktop) -->
            <form action="{{ route('products.index') }}" method="GET" class="hidden md:flex items-center bg-slate-100 rounded-full px-3 py-1.5 w-96 max-w-[45vw] ring-1 ring-transparent focus-within:ring-blue-500">
                <i class="fas fa-search text-slate-400"></i>
                <input name="q" class="bg-transparent outline-none px-2 text-sm text-slate-700 placeholder-slate-400 w-full" placeholder="ابحث عن منتج..." value="{{ request('q') }}">
                <button class="text-slate-500 px-1.5 hover:text-blue-600" aria-label="بحث"><i class="fas fa-arrow-left"></i></button>
            </form>

            <!-- Actions -->
            <div class="flex items-center gap-2 sm:gap-4">
                <button @click="searchOpen = true" class="md:hidden p-2 rounded-lg text-slate-700 hover:bg-slate-100" aria-label="بحث">
                    <i class="fas fa-search text-lg"></i>
                </button>

                <a href="{{ route('cart.view') }}" class="relative hidden md:inline-flex items-center gap-2 text-slate-700 hover:text-blue-700">
                    <i class="fas fa-shopping-cart text-lg"></i>
                    <span id="cart-count" class="badge ml-1">{{ $cartServerCount }}</span>
                </a>

                <div x-data="{ open:false }" class="relative">
                    <button @click="open=!open" class="flex items-center gap-2 rounded-lg px-2 py-1 hover:bg-slate-100">
                        <div class="w-8 h-8 rounded-full overflow-hidden ring-1 ring-slate-200">
                            <img src="{{ $avatarUrl }}" alt="avatar" class="object-cover w-full h-full" onerror="this.onerror=null;this.src='{{ asset('storage/images/default-avatar.png') }}'">
                        </div>
                        <span class="hidden sm:inline text-sm text-slate-700">{{ $user->name ?? 'ضيف' }}</span>
                        <i class="fas fa-chevron-down text-xs text-slate-400"></i>
                    </button>

                    <div x-show="open" @click.away="open=false" x-transition
                         class="absolute right-0 mt-2 w-52 bg-white border border-slate-100 rounded-xl shadow-lg py-2 text-right">
                        @auth
                            <a href="{{ route('profile') }}" class="block px-4 py-2 hover:bg-slate-50 text-sm">حسابي</a>
                            @if($user && $user->hasRole([\App\Models\User::ROLE_SELLER]))
                                <a href="{{ route('seller.dashboard') }}" class="block px-4 py-2 hover:bg-slate-50 text-sm">لوحة البائع</a>
                            @endif
                            @if($user && $user->hasRole([\App\Models\User::ROLE_ADMIN, \App\Models\User::ROLE_MANAGER]))
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-slate-50 text-sm">لوحة التحكم</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-right px-4 py-2 text-sm hover:bg-slate-50">تسجيل الخروج</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="block px-4 py-2 hover:bg-slate-50 text-sm">تسجيل الدخول</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile bottom bar -->
    <nav class="mobile-nav md:hidden">
        <div class="flex items-center justify-between container-page">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                <i class="fa-solid fa-house text-base"></i>
                <span>الرئيسية</span>
            </a>
            <a href="{{ route('products.index') }}" class="{{ request()->is('products*') ? 'active' : '' }}">
                <i class="fa-solid fa-boxes-stacked text-base"></i>
                <span>المنتجات</span>
            </a>
            <a href="{{ route('cart.view') }}" class="relative {{ request()->routeIs('cart.view') ? 'active' : '' }}">
                <i class="fa-solid fa-cart-shopping text-base"></i>
                <span>السلة</span>
                <span id="cart-count-2" class="absolute -top-1 -left-2 badge">{{ $cartServerCount }}</span>
            </a>
            @auth
            <a href="{{ route('orders.index') }}" class="{{ request()->is('orders*') ? 'active' : '' }}">
                <i class="fa-solid fa-receipt text-base"></i>
                <span>الطلبات</span>
            </a>
            <a href="{{ route('profile') }}" class="{{ request()->routeIs('profile') ? 'active' : '' }}">
                <i class="fa-solid fa-user text-base"></i>
                <span>حسابي</span>
            </a>
            @else
            <a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'active' : '' }}">
                <i class="fa-solid fa-user text-base"></i>
                <span>دخول</span>
            </a>
            @endauth
        </div>
    </nav>
</header>

<!-- Mobile search sheet -->
<div class="fixed inset-0 bg-black/30 backdrop-blur-sm z-40 hidden" :class="searchOpen ? 'block' : 'hidden'" @click.self="searchOpen=false">
    <div class="container-page pt-[72px]">
        <form action="{{ route('products.index') }}" method="GET" class="w-full bg-white border border-slate-200 rounded-2xl shadow-xl p-3">
            <div class="flex items-center gap-2">
                <i class="fas fa-search text-slate-400"></i>
                <input name="q" class="flex-1 bg-transparent outline-none px-1 text-slate-800 placeholder-slate-400" placeholder="ابحث عن منتج..." autofocus>
                <button class="px-3 py-1.5 rounded-lg bg-slate-100" type="button" @click="searchOpen=false">إلغاء</button>
            </div>
        </form>
    </div>
</div>

<div class="flex pt-16">
    @if(!request()->routeIs('home'))
        <!-- Sidebar overlay (mobile) -->
        <div class="fixed inset-0 bg-black/30 backdrop-blur-sm z-40 md:hidden" x-show="sidebarOpen" x-cloak @click="sidebarOpen=false"></div>

        <aside class="app-sidebar fixed inset-y-0 right-0 z-50 transform transition-transform duration-200 ease-in-out md:translate-x-0 md:static md:block"
               :class="sidebarOpen ? 'translate-x-0' : 'translate-x-full md:translate-x-0'">
            <div class="h-16 flex items-center justify-between px-4 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <img src="{{ $logoUrl }}" alt="logo" class="w-10 h-10 rounded-full object-cover ring-1 ring-slate-100" onerror="this.onerror=null;this.src='{{ asset('storage/images/default-logo.png') }}'">
                    <div>
                        <div class="text-sm font-extrabold text-slate-800">{{ $site_settings['site_name'] ?? config('app.name') }}</div>
                        <div class="text-[11px] text-slate-500">أهلاً {{ $user->name ?? 'ضيف' }}</div>
                    </div>
                </div>
                <button class="md:hidden p-2 text-slate-600" @click="sidebarOpen = false" aria-label="إغلاق">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <nav class="px-3 py-4 sidebar-scroll overflow-y-auto" style="height: calc(100vh - 64px);">
                <a href="{{ route('home') }}" class="sidebar-link {{ request()->routeIs('home') ? 'sidebar-active' : '' }}">
                    <i class="fas fa-home text-lg w-5"></i><span class="text-sm">الرئيسية</span>
                </a>
                <a href="{{ route('products.index') }}" class="sidebar-link {{ request()->is('products*') ? 'sidebar-active' : '' }}">
                    <i class="fas fa-box-open text-lg w-5"></i><span class="text-sm">المنتجات</span>
                </a>
                @if(auth()->check() && auth()->user()->hasRole([\App\Models\User::ROLE_ADMIN, \App\Models\User::ROLE_MANAGER]))
                    <a href="{{ route('categories.index') }}" class="sidebar-link {{ request()->is('categories*') ? 'sidebar-active' : '' }}">
                        <i class="fas fa-sitemap text-lg w-5"></i><span class="text-sm">الأقسام</span>
                    </a>
                @endif
                @auth
                    <a href="{{ route('orders.index') }}" class="sidebar-link {{ request()->is('orders*') ? 'sidebar-active' : '' }}">
                        <i class="fas fa-receipt text-lg w-5"></i><span class="text-sm">الطلبات</span>
                    </a>
                    @if(auth()->user()->hasRole([\App\Models\User::ROLE_SELLER]))
                        <a href="{{ route('seller.dashboard') }}" class="sidebar-link {{ request()->routeIs('seller.dashboard') ? 'sidebar-active' : '' }}">
                            <i class="fas fa-chart-line text-lg w-5"></i><span class="text-sm">لوحة البائع</span>
                        </a>
                    @endif
                    @if(auth()->user()->hasRole([\App\Models\User::ROLE_ADMIN, \App\Models\User::ROLE_MANAGER]))
                        <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'sidebar-active' : '' }}">
                            <i class="fas fa-tachometer-alt text-lg w-5"></i><span class="text-sm">لوحة التحكم</span>
                        </a>
                                         <a href="{{ route('shippings.index') }}" class="sidebar-link {{ request()->is('shippings*') ? 'sidebar-active' : '' }}">
                            <i class="fas fa-users-cog text-lg w-5"></i><span class="text-sm">اعدادات الشحن</span>
                        </a>
                        <a href="{{ route('users.index') }}" class="sidebar-link {{ request()->is('users*') ? 'sidebar-active' : '' }}">
                            <i class="fas fa-users-cog text-lg w-5"></i><span class="text-sm">المستخدمون</span>
                        </a>
                        <a href="{{ route('settings.index') }}" class="sidebar-link {{ request()->is('settings*') ? 'sidebar-active' : '' }}">
                            <i class="fas fa-cogs text-lg w-5"></i><span class="text-sm">إعدادات</span>
                        </a>
                    @endif
                @endauth

                <div class="border-t border-slate-100 my-3"></div>

                <a href="{{ route('cart.view') }}" class="sidebar-link {{ request()->routeIs('cart.view') ? 'sidebar-active' : '' }}">
                    <i class="fas fa-shopping-cart text-lg w-5"></i><span class="text-sm">سلة الشراء</span>
                    <span class="ml-auto badge" id="cart-count-2">{{ $cartServerCount }}</span>
                </a>

                <div class="mt-6 px-3 text-[11px] text-slate-400">
                    إصدار التطبيق: <strong class="text-slate-600">1.0</strong>
                </div>
            </nav>
        </aside>
    @endif

    <!-- Content -->
    <div class="flex-1 min-h-screen">
        <main id="main" class="content">
            <div class="container-page py-6 md:py-8">
                @yield('content')
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-slate-900 text-white mt-20 pb-24 md:pb-0">
            <div class="container-page py-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <h3 class="text-xl font-bold mb-4 text-yellow-400">{{ $site_settings['site_name'] ?? config('app.name') }}</h3>
                        <p class="text-slate-300 leading-relaxed">{{ $site_settings['site_description'] ?? 'تسوق أفضل المنتجات بأسعار منافسة' }}</p>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold mb-4">روابط سريعة</h3>
                        <ul class="space-y-2 text-slate-300">
                            <li><a href="{{ route('home') }}" class="hover:text-yellow-400">الرئيسية</a></li>
                            <li><a href="{{ route('products.index') }}" class="hover:text-yellow-400">المنتجات</a></li>
                            <li><a href="{{ route('categories.index') }}" class="hover:text-yellow-400">الأقسام</a></li>
                            <li><a href="{{ route('cart.view') }}" class="hover:text-yellow-400">سلة الشراء</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold mb-4">الأقسام</h3>
                        <ul class="space-y-2 text-slate-300">
                            <li><a href="{{ route('products.index', ['category' => 'electronics']) }}" class="hover:text-yellow-400">إلكترونيات</a></li>
                            <li><a href="{{ route('products.index', ['category' => 'fashion']) }}" class="hover:text-yellow-400">ملابس</a></li>
                            <li><a href="{{ route('products.index', ['category' => 'home']) }}" class="hover:text-yellow-400">منزل ومطبخ</a></li>
                            <li><a href="{{ route('products.index', ['category' => 'sports']) }}" class="hover:text-yellow-400">رياضة</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold mb-4">تواصل معنا</h3>
                        <ul class="space-y-3 text-slate-300">
                            <li><i class="fas fa-phone text-yellow-400 ml-2"></i> 123-456-7890</li>
                            <li><i class="fas fa-envelope text-yellow-400 ml-2"></i> info@example.com</li>
                            <li><i class="fas fa-map-marker-alt text-yellow-400 ml-2"></i> القاهرة، مصر</li>
                        </ul>
                    </div>
                </div>
                <hr class="border-slate-700 my-8">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-slate-400">
                    <p>&copy; {{ date('Y') }} {{ $site_settings['site_name'] ?? config('app.name') }}. جميع الحقوق محفوظة.</p>
                    <div class="flex gap-4">
                        <a href="#" class="hover:text-white">سياسة الخصوصية</a>
                        <a href="#" class="hover:text-white">الشروط والأحكام</a>
                        <a href="#" class="hover:text-white">سياسة الاسترجاع</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>

<!-- Alpine -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<script>
    // Currency globals
    window.AppCurrency = {
        rate: parseFloat("{{ $currencyRate }}") || 1,
        symbol: "{{ $currencySymbol }}"
    };

    // Cart badges sync
    function updateCartBadges(count){
        document.querySelectorAll('#cart-count, #cart-count-2').forEach(e => e && (e.textContent = count));
        localStorage.setItem('cart_count', count);
    }
    document.addEventListener('DOMContentLoaded', function(){
        const serverCount = parseInt("{{ $cartServerCount ?? 0 }}") || 0;
        const localCount = parseInt(localStorage.getItem('cart_count')) || 0;
        updateCartBadges(serverCount > 0 ? serverCount : localCount);
    });

    // AJAX helper
    async function ajaxPostJson(url, payload = {}) {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const res = await fetch(url, {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': token,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(payload)
        });
        const ct = res.headers.get('content-type') || '';
        return ct.includes('application/json') ? res.json() : { html: await res.text(), status: res.status };
    }

    // Add-to-cart convenience
    async function addToCartAjax(productId, quantity = 1) {
        try{
            const data = await ajaxPostJson('/cart/add', { product_id: productId, quantity });
            if (data && data.success) {
                const newCount = data.cart_count ?? (parseInt(localStorage.getItem('cart_count')||'0') + quantity);
                updateCartBadges(newCount);
                showToast(data.message || 'تم إضافة المنتج إلى السلة', 'success');
                return data;
            } else if (data && data.error) {
                showToast(data.error, 'error'); return data;
            } else if (data && data.html) {
                location.reload(); return data;
            } else {
                showToast('استجابة غير متوقعة', 'error');
            }
        } catch(e){
            console.error(e); showToast('حدث خطأ في الشبكة', 'error');
        }
    }

    // Toast
    function showToast(message, type='info'){
        const el = document.createElement('div');
        el.className = `fixed top-4 right-4 z-[70] px-4 py-3 rounded-xl shadow-xl text-white transition-all duration-300 translate-x-full
            ${type==='success'?'bg-emerald-600':type==='error'?'bg-rose-600':'bg-blue-600'}`;
        el.innerHTML = `<div class="flex items-center gap-2"><i class="fas ${type==='success'?'fa-check-circle':type==='error'?'fa-exclamation-circle':'fa-info-circle'}"></i><span>${message}</span></div>`;
        document.body.appendChild(el);
        requestAnimationFrame(()=> el.style.transform='translateX(0)');
        setTimeout(()=>{ el.style.transform='translateX(120%)'; setTimeout(()=>el.remove(), 240); }, 2600);
    }

    // Service worker (register only if exists)
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            fetch('/sw.js', { method: 'HEAD' }).then(res => {
                if (res.ok) navigator.serviceWorker.register('/sw.js').catch(console.warn);
            }).catch(()=>{});
        }, { passive: true });
    }
</script>

<!-- AOS -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (window.AOS) AOS.init({ once:true, duration:700, easing:'ease-out-cubic' });
    }, { passive: true });
</script>

@stack('scripts')
</body>
</html>
