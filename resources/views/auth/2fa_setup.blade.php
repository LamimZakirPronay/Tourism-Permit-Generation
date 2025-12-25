<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security Setup | Tourism Permit System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            display: flex;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .setup-card {
            background: #ffffff;
            border: none;
            border-radius: 1.25rem;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }
        .step-badge {
            width: 28px;
            height: 28px;
            background: #0d6efd;
            color: white;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.9rem;
            flex-shrink: 0;
        }
        .qr-container {
            background: #ffffff;
            padding: 1rem;
            border-radius: 1rem;
            border: 1px solid #e2e8f0;
            display: inline-block;
        }
        .secret-box {
            background: #f1f5f9;
            border: 2px dashed #cbd5e1;
            border-radius: 0.75rem;
            padding: 1rem;
        }
        .secret-key {
            font-family: 'Courier New', monospace;
            font-size: 1.2rem;
            font-weight: 700;
            color: #1e293b;
            letter-spacing: 1px;
            word-break: break-all;
        }
        .btn-verify {
            padding: 0.8rem;
            font-weight: 600;
            border-radius: 0.75rem;
            background: #1e293b;
            border: none;
        }
        .btn-verify:hover { background: #334155; }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="text-center mb-4">
                <h2 class="fw-bold text-dark">Tourism Permit System</h2>
            </div>
            
            <div class="card setup-card">
                <div class="card-body p-4 p-lg-5">
                    <div class="text-center mb-4">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/f/f7/Microsoft_Authenticator_logo.svg" width="45" alt="MS Authenticator" class="mb-3">
                        <h4 class="fw-bold">Security Setup</h4>
                        <p class="text-muted small">Protect your account with Two-Factor Authentication.</p>
                    </div>

                    <div class="d-flex align-items-start mb-4">
                        <span class="step-badge mt-1">1</span>
                        <div class="ms-3 text-center w-100">
                            <h6 class="fw-bold mb-2 text-start">Scan QR Code</h6>
                            <div class="qr-container mb-2">
                                {!! $qrCodeSvg !!}
                            </div>
                            <p class="text-muted small mb-0">Open Authenticator and scan the code.</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-start mb-4">
                        <span class="step-badge mt-1">2</span>
                        <div class="ms-3 w-100">
                            <h6 class="fw-bold mb-2">Manual Entry (Backup)</h6>
                            <div class="secret-box text-center">
                                <span class="secret-key" id="secretKey">{{ $secret }}</span>
                                <div class="mt-2">
                                    <button type="button" class="btn btn-sm btn-link text-decoration-none p-0" onclick="copyKey(this)">
                                        <small class="fw-bold">Copy Secret Key</small>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-start">
                        <span class="step-badge mt-1">3</span>
                        <div class="ms-3 w-100">
                            <h6 class="fw-bold mb-3">Verify & Activate</h6>
                            <form action="{{ route('admin.2fa.verify') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <input type="text" 
                                           name="one_time_password" 
                                           class="form-control form-control-lg text-center fw-bold @error('one_time_password') is-invalid @enderror" 
                                           placeholder="000 000" 
                                           maxlength="6" 
                                           required 
                                           autocomplete="off"
                                           style="letter-spacing: 5px; font-size: 1.3rem;">
                                    
                                    @error('one_time_password')
                                        <div class="invalid-feedback text-center fw-bold">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                
                                <button type="submit" class="btn btn-verify btn-primary w-100 text-white shadow-sm">
                                    Activate Security
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-link text-decoration-none small text-muted">Logout and try later</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function copyKey(btn) {
        const text = document.getElementById('secretKey').innerText;
        const originalText = btn.innerHTML;
        
        navigator.clipboard.writeText(text).then(() => {
            btn.innerHTML = '<small class="text-success fw-bold">Copied!</small>';
            setTimeout(() => {
                btn.innerHTML = originalText;
            }, 2000);
        });
    }
</script>

</body>
</html>