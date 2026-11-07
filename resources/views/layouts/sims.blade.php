<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'SIMS' }} | Student Information Management System</title>
    <style>
        :root { color-scheme: light; font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; color: #18243a; background: #f3f6fb; }
        * { box-sizing: border-box; }
        body { min-height: 100vh; margin: 0; }
        a { color: #3159ba; font-weight: 600; text-decoration: none; }
        a:hover { text-decoration: underline; }
        .topbar { height: 70px; display: flex; align-items: center; justify-content: space-between; padding: 0 max(24px, calc((100vw - 1120px) / 2)); background: #fff; border-bottom: 1px solid #e4eaf3; }
        .brand { display: flex; align-items: center; gap: 12px; color: #18243a; font-size: 15px; font-weight: 750; letter-spacing: -.02em; }
        .brand-mark { display: grid; width: 36px; height: 36px; place-items: center; border-radius: 11px; background: #3159ba; color: white; font-size: 14px; }
        .main { width: min(100% - 40px, 1120px); margin: 48px auto; }
        .auth-card { width: min(100%, 460px); margin: 48px auto; padding: 36px; border: 1px solid #e3e9f2; border-radius: 18px; background: #fff; box-shadow: 0 16px 40px #243b6410; }
        .eyebrow { margin: 0 0 9px; color: #5573bd; font-size: 12px; font-weight: 750; letter-spacing: .12em; text-transform: uppercase; }
        h1 { margin: 0; font-size: clamp(25px, 4vw, 32px); letter-spacing: -.04em; }
        .muted { margin: 9px 0 26px; color: #6b7890; font-size: 14px; line-height: 1.6; }
        .field { margin: 18px 0; }
        label { display: block; margin-bottom: 7px; font-size: 13px; font-weight: 650; }
        input, select, textarea { width: 100%; min-height: 46px; padding: 0 13px; border: 1px solid #d7dfeb; border-radius: 9px; background: white; color: #18243a; font: inherit; outline: none; }
        textarea { padding-top: 12px; resize: vertical; }
        input:focus, select:focus, textarea:focus { border-color: #5276d0; box-shadow: 0 0 0 3px #5276d022; }
        .error { margin: 6px 0 0; color: #b42318; font-size: 12px; }
        .button { display: inline-flex; min-height: 44px; align-items: center; justify-content: center; padding: 0 18px; border: 0; border-radius: 9px; background: #3159ba; color: white; font: inherit; font-size: 14px; font-weight: 700; cursor: pointer; }
        .button:hover { background: #27499a; }
        .button.full { width: 100%; margin-top: 6px; }
        .auth-footer { margin: 22px 0 0; color: #6b7890; font-size: 13px; text-align: center; }
        .alert { margin: 18px 0; padding: 12px 14px; border-radius: 9px; background: #edf7f0; color: #24623a; font-size: 13px; }
        .page-heading { display: flex; align-items: flex-end; justify-content: space-between; gap: 20px; margin-bottom: 28px; }
        .empty-state { display: grid; min-height: 280px; place-items: center; padding: 32px; border: 1px dashed #cbd5e4; border-radius: 16px; background: #fff; text-align: center; }
        .empty-icon { display: grid; width: 54px; height: 54px; margin: 0 auto 14px; place-items: center; border-radius: 16px; background: #eef2fc; color: #3159ba; font-size: 23px; }
        .empty-state h2 { margin: 0; font-size: 18px; }
        .empty-state p { max-width: 420px; margin: 8px auto 0; color: #6b7890; font-size: 14px; line-height: 1.6; }
        .summary-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 16px; margin-bottom: 22px; }
        .summary-card { padding: 20px 22px; border: 1px solid #e3e9f2; border-radius: 14px; background: #fff; }
        .summary-card .eyebrow { margin-bottom: 12px; }
        .summary-card strong { font-size: 28px; letter-spacing: -.04em; font-variant-numeric: tabular-nums; }
        .dashboard-chart-card { padding: 28px; border: 1px solid #e3e9f2; border-radius: 16px; background: #fff; box-shadow: 0 12px 32px #243b6408; }
        .chart-heading { display: flex; align-items: flex-end; justify-content: space-between; gap: 20px; }
        .chart-heading h2 { margin: 0; font-size: 20px; letter-spacing: -.025em; }
        .chart-note, .chart-caption { color: #6b7890; font-size: 13px; }
        .chart-note { margin: 0 0 3px; }
        .chart-legend { display: flex; flex-wrap: wrap; gap: 16px; margin: 24px 0 12px; }
        .legend-item { display: inline-flex; align-items: center; gap: 7px; color: #53627a; font-size: 12px; font-weight: 650; }
        .legend-swatch { width: 11px; height: 11px; border-radius: 3px; }
        .vertical-chart-figure { margin: 0; }
        .vertical-chart-scroll { overflow-x: auto; padding-bottom: 8px; }
        .vertical-chart { display: grid; grid-template-columns: 38px minmax(0, 1fr); gap: 10px; min-height: 290px; }
        .chart-y-axis { display: flex; flex-direction: column; justify-content: space-between; padding: 1px 0 31px; color: #7b879b; font-size: 11px; font-variant-numeric: tabular-nums; text-align: right; }
        .chart-plot { display: flex; align-items: stretch; justify-content: space-around; gap: 12px; min-width: 0; border-bottom: 1px solid #cfd7e4; background: repeating-linear-gradient(to top, transparent 0, transparent calc(25% - 1px), #edf0f5 calc(25% - 1px), #edf0f5 25%); }
        .chart-year-group { display: flex; flex: 1 0 72px; flex-direction: column; justify-content: flex-end; min-width: 72px; text-align: center; }
        .chart-year-bars { display: flex; flex: 1; align-items: flex-end; justify-content: center; gap: 5px; min-height: 0; }
        .chart-level-column { display: flex; width: min(18%, 25px); height: 100%; flex-direction: column; align-items: center; justify-content: flex-end; gap: 4px; }
        .chart-bar-value { min-height: 13px; color: #53627a; font-size: 10px; font-variant-numeric: tabular-nums; }
        .vertical-bar { width: 100%; min-height: 0; border-radius: 4px 4px 0 0; }
        .level-1 { background: #3159ba; }
        .level-2 { background: #7a61c9; }
        .level-3 { background: #16836e; }
        .level-4 { background: #e49b36; }
        .chart-year-label { padding: 9px 0 0; color: #3b4961; font-size: 12px; font-weight: 650; font-variant-numeric: tabular-nums; }
        .chart-caption { margin-top: 18px; }
        .chart-empty { display: grid; min-height: 180px; place-items: center; margin-top: 20px; border: 1px dashed #cbd5e4; border-radius: 12px; color: #6b7890; text-align: center; }
        .chart-empty p { margin: 0; padding: 20px; }
        .logout-form { margin: 0; }
        .text-button { padding: 8px 12px; border: 1px solid #d7dfeb; border-radius: 8px; background: #fff; color: #3b4961; font: inherit; font-size: 13px; font-weight: 650; cursor: pointer; }
        .topbar-actions { display:flex; align-items:center; gap:18px; }
        .table-card { overflow-x:auto; border:1px solid #e3e9f2; border-radius:14px; background:#fff; }
        table { width:100%; border-collapse:collapse; text-align:left; }
        th, td { padding:14px 16px; border-bottom:1px solid #edf0f5; font-size:13px; white-space:nowrap; }
        th { color:#6b7890; font-weight:700; background:#fafbfe; }
        tr:last-child td { border-bottom:0; }
        .actions { display:flex; align-items:center; gap:12px; }
        .inline-form { display:inline; margin:0; }
        .danger-link { color:#b42318; background:none; border:0; font:inherit; font-size:13px; font-weight:650; cursor:pointer; padding:0; }
        .toolbar { display:flex; gap:10px; align-items:center; }
        .toolbar input { width:min(300px, 50vw); }
        .form-card { max-width:700px; padding:28px; border:1px solid #e3e9f2; border-radius:16px; background:#fff; }
        .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:0 20px; }
        .form-grid dt { font-size:13px; font-weight:650; }
        .form-grid dd { margin:0; color:#53627a; font-size:14px; }
        .pagination { padding:16px; }
        .pagination nav { display:flex; justify-content:space-between; gap:14px; }
        .pagination p { margin:0; color:#6b7890; font-size:13px; }
        .pagination a, .pagination span { margin:0 4px; }
        .secondary-button { display:inline-flex; min-height:42px; align-items:center; padding:0 14px; border:1px solid #d7dfeb; border-radius:9px; color:#3b4961; background:#fff; font-size:14px; font-weight:650; }
        .topbar-nav { display:flex; align-items:center; gap:18px; }
        .topbar-nav a { padding:9px 12px; border-radius:9px; color:#53627a; font-size:13px; transition:background-color .15s ease, color .15s ease; }
        .topbar-nav a:hover { background:#f3f6fb; color:#243b78; text-decoration:none; }
        .topbar-nav a.active { background:#eaf0ff; color:#27499a; font-weight:750; }
        @media (max-width:700px) { .topbar { padding:0 16px; } .form-grid { grid-template-columns:1fr; } .page-heading { align-items:flex-start; flex-direction:column; } .toolbar { width:100%; } .toolbar input { flex:1; width:auto; } .summary-grid { gap:10px; } .summary-card { padding:16px; } .summary-card strong { font-size:24px; } }
        @media (max-width:600px) { .dashboard-chart-card { padding:22px 18px; } .chart-heading { align-items:flex-start; flex-direction:column; gap:8px; } .summary-grid { grid-template-columns:1fr; } .summary-card { display:flex; align-items:center; justify-content:space-between; } .summary-card .eyebrow { margin:0; } .summary-card strong { font-size:22px; } .vertical-chart { min-height:250px; } }
        @media (max-width: 600px) { .auth-card { margin: 20px auto; padding: 27px 22px; } .main { margin-top: 32px; } .topbar { height: 62px; } }
    </style>
</head>
<body>
    <header class="topbar">
        <a class="brand" href="{{ auth()->check() ? route('dashboard') : route('login') }}">
            <span class="brand-mark">S</span>
            <span>SIMS <span style="color:#7b879b;font-weight:500">· Student Information System</span></span>
        </a>
        @auth
            <div class="topbar-actions">
                <nav class="topbar-nav" aria-label="Main navigation">
                    <a href="{{ route('dashboard') }}" @class(['active' => request()->routeIs('dashboard')]) @if (request()->routeIs('dashboard')) aria-current="page" @endif>Dashboard</a>
                    <a href="{{ route('students.index') }}" @class(['active' => request()->routeIs('students.*')]) @if (request()->routeIs('students.*')) aria-current="page" @endif>Students</a>
                    <a href="{{ route('subjects.index') }}" @class(['active' => request()->routeIs('subjects.*')]) @if (request()->routeIs('subjects.*')) aria-current="page" @endif>Subjects</a>
                    <a href="{{ route('enrollments.index') }}" @class(['active' => request()->routeIs('enrollments.*')]) @if (request()->routeIs('enrollments.*')) aria-current="page" @endif>Enrollments</a>
                    @if (auth()->user()->role === 'administrator')
                        <a href="{{ route('users.index') }}" @class(['active' => request()->routeIs('users.*')]) @if (request()->routeIs('users.*')) aria-current="page" @endif>Users</a>
                    @endif
                </nav>
                <form class="logout-form" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-button" type="submit">Log out</button>
                </form>
            </div>
        @endauth
    </header>

    @yield('content')
</body>
</html>
