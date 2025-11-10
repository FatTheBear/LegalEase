<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kiểm tra Email - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container-fluid vh-100 d-flex align-items-center justify-content-center">
        <div class="row justify-content-center w-100">
            <div class="col-lg-5 col-md-7 col-sm-9">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-5 text-center">
                        <div class="mb-4">
                            <i class="fas fa-envelope-circle-check display-1 text-success mb-3"></i>
                            <h2 class="fw-bold text-dark">Kiểm tra Email của bạn!</h2>
                        </div>
                        
                        <div class="alert alert-info mb-4">
                            <p class="mb-0">
                                <strong>Đăng ký thành công!</strong><br>
                                Chúng tôi đã gửi email xác thực đến: <br>
                                <span class="text-primary fw-bold">{{ $email ?? 'email của bạn' }}</span>
                            </p>
                        </div>

                        <p class="text-muted mb-4">
                            Vui lòng kiểm tra hộp thư đến (và cả thư mục spam) để tìm email xác thực. 
                            Click vào link trong email để kích hoạt tài khoản của bạn.
                        </p>

                        <div class="d-grid gap-3 mb-4">
                            <a href="{{ route('login') }}" class="btn btn-primary btn-lg rounded-pill">
                                <i class="fas fa-sign-in-alt me-2"></i>Đến trang đăng nhập
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-outline-secondary btn-lg rounded-pill">
                                <i class="fas fa-user-plus me-2"></i>Đăng ký lại
                            </a>
                        </div>

                        <hr>

                        <div class="text-muted small">
                            <p class="mb-1">
                                <i class="fas fa-clock me-1"></i> Email có thể mất vài phút để đến
                            </p>
                            <p class="mb-0">
                                <i class="fas fa-question-circle me-1"></i> Không nhận được email? Kiểm tra thư mục spam
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>