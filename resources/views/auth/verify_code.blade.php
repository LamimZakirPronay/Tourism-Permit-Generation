<!DOCTYPE html>
<html>
<head>
    <title>Verify Code</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-header bg-dark text-white text-center"><h4>Enter 6-Digit Code</h4></div>
                    <div class="card-body">
                        <p class="text-center">Check your Mailtrap inbox for the login code.</p>
                        <form action="{{ route('verify.code.submit') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <input type="text" name="code" class="form-control text-center fs-2" placeholder="000000" maxlength="6" required>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Verify & Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>