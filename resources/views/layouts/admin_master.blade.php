<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta http-equiv="X-Frame-Options" content="DENY">

    {{-- Browser Tab Icon (Favicon) --}}
    @if(isset($siteSettings['favicon']) && $siteSettings['favicon'])
        <link rel="icon" type="image/png" href="{{ asset('storage/' . $siteSettings['favicon']) }}">
        <link rel="apple-touch-icon" href="{{ asset('storage/' . $siteSettings['favicon']) }}">
    @else
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @endif

    <title>
        @yield('title', 'Admin') | {{ $siteSettings['site_name'] ?? 'Tourism Permit' }}
    </title>
    
    {{-- Fonts & Bootstrap --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        :root {
            --admin-dark: #0f172a;
            --admin-accent: #3b82f6;
            --admin-bg: #f8fafc;
        }

        body { 
            font-family: 'Inter', sans-serif; 
            background-color: var(--admin-bg); 
            color: #1e293b; 
            user-select: none;
        }

        .navbar { 
            background: var(--admin-dark) !important; 
            padding: 0.7rem 0; 
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .navbar-brand img { 
            max-height: 35px; 
            width: auto; 
            margin-right: 12px; 
        }
    </style>
    @yield('styles')
</head>
<body oncontextmenu="return false;">
    
    <nav class="navbar navbar-dark mb-5 shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('admin.dashboard') }}">
                @if(isset($siteSettings['logo']) && $siteSettings['logo'])
                    <img src="{{ asset('storage/' . $siteSettings['logo']) }}" alt="Logo">
                @else
                    <i class="bi bi-shield-check me-2 text-primary"></i>
                @endif
                <span>{{ $siteSettings['site_name'] ?? 'Admin Panel' }}</span>
            </a>
            
            <div class="d-flex align-items-center">
                @auth
                    <div class="dropdown">
                        <button class="btn btn-link text-white text-decoration-none dropdown-toggle small" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i> {{ auth()->user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-2">
                            <li><a class="dropdown-item py-2" href="{{ route('admin.settings.edit') }}"><i class="bi bi-gear me-2"></i> Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="px-3 py-1">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm w-100 rounded-pill">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Anti-Inspect Scripts --}}
    <script>
        document.onkeydown = function(e) {
            if (e.keyCode == 123) return false;
            if (e.ctrlKey && e.shiftKey && (e.keyCode == 'I'.charCodeAt(0) || e.keyCode == 'J'.charCodeAt(0))) return false;
            if (e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) return false;
        };

        (function() {
            setInterval(function() {
                (function() {}.constructor("debugger")());
            }, 50);
        })();
    </script>

    @yield('scripts')
</body>
</html>