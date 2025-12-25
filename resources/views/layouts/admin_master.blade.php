<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - @yield('title', 'Tourism Permit')</title>
    
    {{-- Fonts & Bootstrap --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #1e293b; }
        /* Clean Dark Header Style */
        .navbar { background: #0f172a !important; padding: 0.8rem 0; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .navbar-brand { font-size: 1.25rem; letter-spacing: -0.025em; }
        
        /* Global utility classes for all admin pages */
        .main-card { background: #ffffff; border-radius: 1rem; overflow: hidden; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .btn-dashboard { background: #f1f5f9; color: #475569; font-weight: 600; border-radius: 8px; padding: 0.5rem 1rem; border: none; transition: 0.2s; }
        .btn-dashboard:hover { background: #e2e8f0; color: #1e293b; }
        .btn-add { background: #1e293b; color: white; font-weight: 600; border-radius: 8px; padding: 0.5rem 1.25rem; border: none; transition: 0.2s; }
        .btn-add:hover { background: #0f172a; color: white; opacity: 0.9; }
    </style>
    @yield('styles')
</head>
<body>
    
    {{-- The Global Clean Header --}}
    <nav class="navbar navbar-dark mb-4 shadow-sm">
        <div class="container">
            {{-- Branding only --}}
            <a class="navbar-brand fw-bold" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-compass me-2 text-primary"></i>Tourism Admin Panel
            </a>
            
            {{-- User Welcome & Logout --}}
            <div class="d-flex align-items-center">
                @auth
                    <span class="text-white-50 me-3 small d-none d-md-inline">Welcome, {{ auth()->user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm rounded-pill px-3">Logout</button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Main Content Section --}}
    <div class="container pb-5">
        @yield('content')
    </div>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>