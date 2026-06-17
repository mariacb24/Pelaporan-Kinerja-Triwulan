<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BPM') | Sistem Kinerja BPM</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <style>
        :root {
            --bpm-primary: #2563EB;
            --bpm-secondary: #1E293B;
            --bpm-success: #10B981;
            --bpm-danger: #EF4444;
            --bpm-warning: #F59E0B;
            --sidebar-w: 255px;
        }
        * { box-sizing: border-box; }
        body { font-family: 'Segoe UI', system-ui, sans-serif; background: #F1F5F9; font-size: 14px; color: #1E293B; }

        /* ── Sidebar ── */
        #sidebar {
            width: var(--sidebar-w); min-height: 100vh;
            background: var(--bpm-secondary);
            position: fixed; top: 0; left: 0; z-index: 1000;
            display: flex; flex-direction: column;
            transition: transform .3s ease;
            overflow-y: auto;
        }
        .sb-brand { padding: 14px 16px; background: rgba(0,0,0,.25); border-bottom: 1px solid rgba(255,255,255,.08); flex-shrink: 0; }
        .sb-logo { width: 34px; height: 34px; background: var(--bpm-primary); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; font-size: 14px; flex-shrink: 0; }
        .sb-title { color: #fff; font-size: 11.5px; font-weight: 600; line-height: 1.3; }
        .sb-sub { color: rgba(255,255,255,.4); font-size: 9.5px; }
        .sb-sec { color: rgba(255,255,255,.3); font-size: 9px; text-transform: uppercase; letter-spacing: .08em; padding: 10px 16px 3px; margin-top: 4px; }
        .sb-nav { padding: 6px 0 16px; flex: 1; }
        .sb-link { display: flex; align-items: center; gap: 9px; color: rgba(255,255,255,.65); padding: 7px 16px; margin: 1px 8px; border-radius: 7px; cursor: pointer; font-size: 12.5px; text-decoration: none; transition: all .15s; }
        .sb-link:hover, .sb-link.active { background: var(--bpm-primary); color: #fff; }
        .sb-link i { font-size: 15px; width: 17px; text-align: center; flex-shrink: 0; }

        /* ── Main ── */
        #main { margin-left: var(--sidebar-w); min-height: 100vh; display: flex; flex-direction: column; }
        .topbar { background: #fff; border-bottom: 1px solid #E2E8F0; padding: 10px 24px; display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; z-index: 100; }
        .tb-title { font-weight: 600; font-size: 13px; color: #374151; }
        .page-body { flex: 1; padding: 20px 24px; }

        /* ── Cards ── */
        .card { border: none; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,.07); }
        .stat-card { border-left: 4px solid var(--bpm-primary); }
        .card-header-bpm { font-weight: 600; font-size: 13px; color: #374151; margin-bottom: 14px; }

        /* ── Table ── */
        .table { font-size: 13px; }
        .table th { background: #F8FAFC; font-weight: 600; color: #64748B; font-size: 11.5px; text-transform: uppercase; letter-spacing: .03em; border-bottom-width: 1px; }
        .table td { vertical-align: middle; }

        /* ── Badges ── */
        .badge-draft        { background: #94A3B8; color: #fff; }
        .badge-menunggu     { background: #F59E0B; color: #fff; }
        .badge-terverifikasi{ background: #10B981; color: #fff; }
        .badge-ditolak      { background: #EF4444; color: #fff; }
        .badge-tersedia     { background: #D1FAE5; color: #065F46; }
        .badge-tidak        { background: #FEE2E2; color: #991B1B; }
        .badge-lengkap      { background: #D1FAE5; color: #065F46; }
        .badge-proses       { background: #FEF3C7; color: #92400E; }
        .badge-tidak_lengkap{ background: #FEE2E2; color: #991B1B; }

        /* ── Avatar ── */
        .avatar { width: 30px; height: 30px; border-radius: 50%; background: var(--bpm-primary); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700; flex-shrink: 0; }

        /* ── Pct colors ── */
        .pct-high { color: #10B981; font-weight: 600; }
        .pct-mid  { color: #F59E0B; font-weight: 600; }
        .pct-low  { color: #EF4444; font-weight: 600; }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            #sidebar { transform: translateX(-100%); }
            #sidebar.show { transform: translateX(0); }
            #main { margin-left: 0; }
        }

        /* Batasi ukuran semua Bootstrap Icon */
        .bi {
            font-size: inherit;
        }

        /* Khusus chevron di topbar */
        .topbar .bi-chevron-down,
        .topbar .bi-chevron-left,
        .topbar .bi-chevron-right {
            font-size: 11px !important;
        }
    </style>
    @stack('styles')
</head>
<body>

<!-- Sidebar -->
<nav id="sidebar">
    <div class="sb-brand">
        <div class="d-flex align-items-center gap-2">
            <div class="sb-logo">BPM</div>
            <div>
                <div class="sb-title">Sistem Kinerja BPM</div>
                <div class="sb-sub">Badan Penjaminan Mutu</div>
            </div>
        </div>
    </div>
    <div class="sb-nav">
        <div class="sb-sec">Utama</div>
        <a href="{{ route('dashboard') }}" class="sb-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i>Dashboard
        </a>

        @if(auth()->user()->canInput())
        <div class="sb-sec">Pelaporan Kinerja</div>
        <a href="{{ route('realisasi.create') }}" class="sb-link {{ request()->routeIs('realisasi.create') ? 'active' : '' }}">
            <i class="bi bi-pencil-square"></i>Input Realisasi
        </a>
        <a href="{{ route('laporan.draft') }}" class="sb-link {{ request()->routeIs('laporan.draft') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-text"></i>Draft Laporan
        </a>
        @endif
        <a href="{{ route('laporan.final') }}" class="sb-link {{ request()->routeIs('laporan.final') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-check"></i>Laporan Final
        </a>

        <div class="sb-sec">Indikator Kinerja</div>
        <a href="{{ route('indikator.index') }}" class="sb-link {{ request()->routeIs('indikator.*') ? 'active' : '' }}">
            <i class="bi bi-list-check"></i>Daftar Indikator
        </a>

        <div class="sb-sec">Dokumen Mutu</div>
        <a href="{{ route('dokumen.website.index') }}" class="sb-link {{ request()->routeIs('dokumen.website.*') ? 'active' : '' }}">
            <i class="bi bi-globe"></i>Dokumen Website
        </a>
        <a href="{{ route('dokumen.spmi.index') }}" class="sb-link {{ request()->routeIs('dokumen.spmi.*') ? 'active' : '' }}">
            <i class="bi bi-folder2-open"></i>Dokumen SPMI
        </a>
        <a href="{{ route('pedoman.index') }}" class="sb-link {{ request()->routeIs('pedoman.*') ? 'active' : '' }}">
            <i class="bi bi-book"></i>Pedoman dan SOP
        </a>

        <div class="sb-sec">Akreditasi</div>
        <a href="{{ route('akreditasi.index') }}" class="sb-link {{ request()->routeIs('akreditasi.*') ? 'active' : '' }}">
            <i class="bi bi-award"></i>Data Akreditasi
        </a>

        <div class="sb-sec">Survei & Kepuasan</div>
        <a href="{{ route('survei.index') }}" class="sb-link {{ request()->routeIs('survei.*') ? 'active' : '' }}">
            <i class="bi bi-clipboard-data"></i>Survei Kepuasan
        </a>
        <a href="{{ route('kepuasan.index') }}" class="sb-link {{ request()->routeIs('kepuasan.*') ? 'active' : '' }}">
            <i class="bi bi-bar-chart"></i>Hasil Survei
        </a>

        @if(auth()->user()->isAdmin())
        <div class="sb-sec">Manajemen Pengguna</div>
        <a href="{{ route('users.index') }}" class="sb-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i>User
        </a>
        <a href="{{ route('roles.index') }}" class="sb-link {{ request()->routeIs('roles.*') ? 'active' : '' }}">
            <i class="bi bi-shield-check"></i>Role
        </a>
        @endif
    </div>
</nav>

<!-- Main -->
<div id="main">
    <div class="topbar">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-sm btn-light d-md-none border-0" id="sidebarToggle">
                <i class="bi bi-list fs-5"></i>
            </button>
            <span class="tb-title">@yield('page-title', 'Dashboard')</span>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge" style="background:#EFF6FF;color:#1D4ED8;font-size:10px">
                {{ auth()->user()->role->display_name }}
            </span>
            <div class="dropdown">
                <button class="btn btn-sm d-flex align-items-center gap-2 border-0" data-bs-toggle="dropdown">
                    <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    <span class="d-none d-md-inline text-muted" style="font-size:12px">{{ auth()->user()->name }}</span>
                    <i class="bi bi-chevron-down text-muted" style="font-size:10px"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" style="font-size:13px">
                    <li><h6 class="dropdown-header">{{ auth()->user()->email }}</h6></li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="page-body">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show py-2 mb-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button>
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show py-2 mb-3" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @yield('content')
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Sidebar toggle (mobile)
    document.getElementById('sidebarToggle')?.addEventListener('click', () => {
        document.getElementById('sidebar').classList.toggle('show');
    });

    // CSRF for AJAX
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

    // Delete confirmation
    document.querySelectorAll('.btn-hapus').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');
            Swal.fire({
                title: 'Hapus Data?',
                text: 'Data yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then(result => { if (result.isConfirmed) form.submit(); });
        });
    });

    // DataTable init
    if ($('.dt-table').length) {
        $('.dt-table').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json',
            },
            pageLength: 15,
            responsive: true,
        });
    }
</script>
@stack('scripts')
</body>
</html>
