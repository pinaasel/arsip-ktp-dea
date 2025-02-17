<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Arsip KTP') }}</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    <style>
        body {
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background: #f8f9fa;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        /* Wrapper */
        .wrapper {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background: #2B3467;
            color: #fff;
            z-index: 1050;
            transition: all 0.3s ease;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 250px;
            min-height: 100vh;
            background: #f8f9fa;
            padding: 20px;
        }

        /* Container */
        .container-fluid {
            width: 100%;
            padding-right: 30px;
            padding-left: 30px;
            margin-right: auto;
            margin-left: auto;
        }

        /* Card styles */
        .card {
            background: #fff;
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,.05);
            margin-bottom: 20px;
            width: 100%;
        }

        /* Navigation */
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 0.8rem 1.5rem;
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff;
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar .nav-link i {
            width: 24px;
            margin-right: 0.5rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                margin-left: -250px;
            }
            .sidebar.active {
                margin-left: 0;
            }
            .main-content {
                margin-left: 0;
                width: 100%;
                padding: 15px;
            }
            .container-fluid {
                padding-right: 15px;
                padding-left: 15px;
            }
        }

        /* Custom Colors */
        .bg-primary { background-color: #1a237e !important; }
        .bg-success { background-color: #2e7d32 !important; }
        .bg-info { background-color: #0288d1 !important; }
        .bg-warning { background-color: #f57f17 !important; }

        .text-primary { color: #1a237e !important; }

        /* Required field indicator */
        .required-field::after {
            content: " *";
            color: red;
        }
    </style>

    @stack('styles')
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h4 class="text-white mb-0 fw-bold">Arsip KTP</h4>
            </div>
            <div class="sidebar-menu">
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                        <a href="{{ route('admin.ktp.index') }}" class="nav-link {{ request()->routeIs('admin.ktp.*') && !request()->routeIs('admin.ktp.export-page') ? 'active' : '' }}">
                            <i class="fas fa-id-card me-2"></i> Data KTP
                        </a>
                        <a href="{{ route('admin.laporan.index') }}" class="nav-link {{ request()->routeIs('admin.laporan.*') && !request()->routeIs('admin.laporan.export-page') ? 'active' : '' }}">
                            <i class="fas fa-file-alt me-2"></i> Laporan
                        </a>
                        <a href="{{ route('admin.petugas.index') }}" class="nav-link {{ request()->routeIs('admin.petugas.*') ? 'active' : '' }}">
                            <i class="fas fa-users me-2"></i> Petugas
                        </a>
                        <a href="{{ route('admin.export.index') }}" class="nav-link {{ request()->routeIs('admin.export.*') ? 'active' : '' }}">
                            <i class="fas fa-file-export me-2"></i> Export Data
                        </a>
                    @elseif(auth()->user()->role === 'petugas')
                        <a href="{{ route('petugas.dashboard') }}" class="nav-link {{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                        <a href="{{ route('petugas.ktp.index') }}" class="nav-link {{ request()->routeIs('petugas.ktp.*') ? 'active' : '' }}">
                            <i class="fas fa-id-card me-2"></i> Data KTP
                        </a>
                        <a href="{{ route('petugas.tugas.index') }}" class="nav-link {{ request()->routeIs('petugas.tugas.*') ? 'active' : '' }}">
                            <i class="fas fa-tasks me-2"></i> Tugas
                        </a>
                        <a href="{{ route('petugas.export.index') }}" class="nav-link {{ request()->routeIs('petugas.export.*') ? 'active' : '' }}">
                            <i class="fas fa-file-export me-2"></i> Export Data
                        </a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-link" style="width: 100%; text-align: left; border: none; background: none;">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </button>
                    </form>
                @endauth
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="main-header d-flex justify-content-between align-items-center">
                <button class="btn d-md-none" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="d-flex align-items-center">
                    @auth
                        <span class="me-2">{{ auth()->user()->role === 'admin' ? 'Admin' : 'Petugas' }}</span>
                    @endauth
                </div>
            </div>

            @yield('content')
        </main>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <!-- Sidebar Toggle Script -->
    <script>
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
            document.querySelector('.main-content').classList.toggle('active');
        });
    </script>

    @include('components.notification-scripts')
    @stack('scripts')
</body>
</html>