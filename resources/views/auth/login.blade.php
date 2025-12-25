<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Tourism Permit System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: radial-gradient(circle at top right, #f8fafc, #e2e8f0);
            min-height: 100vh;
            display: flex;
            align-items: center;
            margin: 0;
        }
        .login-card {
            background: #ffffff;
            border: none;
            border-radius: 1.5rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            overflow: hidden;
        }
        .brand-logo {
            width: 60px;
            height: 60px;
            background: #0d6efd;
            color: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-weight: 800;
            font-size: 1.5rem;
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
        }
        .form-label {
            font-weight: 500;
            color: #475569;
            font-size: 0.9rem;
        }
        .form-control {
            padding: 0.75rem 1rem;
            border-radius: 10px;
            border: 1.5px solid #e2e8f0;
            transition: all 0.2s;
        }
        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
        }
        .btn-login {
            padding: 0.8rem;
            font-weight: 600;
            border-radius: 10px;
            background: #1e293b;
            border: none;
            color: white;
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            background: #0f172a;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .alert-custom {
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 500;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            
            <div class="card login-card">
                <div class="card-body p-4 p-md-5">
                    
                    <div class="text-center mb-4">
                        <div class="brand-logo">T</div>
                        <h3 class="fw-bold text-dark">Welcome Back</h3>
                        <p class="text-muted small">Admin Control Panel Access</p>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger alert-custom border-0 shadow-sm mb-4">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" 
                                   placeholder="admin@example.com" value="{{ old('email') }}" required autofocus>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between">
                                <label class="form-label">Password</label>
                            </div>
                            <input type="password" name="password" class="form-control" 
                                   placeholder="••••••••" required>
                        </div>

                        <button type="submit" class="btn btn-login w-100 shadow-sm mb-3">
                            Sign In
                        </button>
                    </form>

                </div>
            </div>
            
            <p class="text-center mt-4 text-muted small">
                Tourism Permit System &copy; {{ date('Y') }}
            </p>
            
        </div>
    </div>
</div>

</body>
</html>