<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LegalEase')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-wrapper {
            display: flex;
            width: 100%;
            height: 100vh;
            border-radius: 0;
            overflow: hidden;
            box-shadow: none;
        }

        .auth-form-section {
            flex: 1;
            background: #fff;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .auth-form-section > div {
            width: 100%;
            max-width: 546px;
        }

        .auth-bg-section {
            flex: 1;
            background: #3a4b41;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            padding: 50px;
        }

        .auth-bg-section h2 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #fff;
        }

        .auth-bg-section p {
            font-size: 16px;
            line-height: 1.6;
            opacity: 0.9;
        }

        .auth-bg-section .logo {
            font-size: 60px;
            margin-bottom: 30px;
        }

        .form-control {
            border: 1px solid #ddd;
            padding: 14px 18px;
            font-size: 18px;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #3a4b41;
            box-shadow: 0 0 0 0.2rem rgba(58, 75, 65, 0.15);
            background-color: #f9f9f9;
        }

        .btn-primary {
            background: #3a4b41;
            border: none;
            padding: 14px 26px;
            font-weight: 600;
            border-radius: 6px;
            font-size: 19px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: #2d3a31;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(58, 75, 65, 0.3);
        }

        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 9px;
            font-size: 18px;
        }

        .auth-title {
            font-size: 36px;
            font-weight: 700;
            color: #2d3a31;
            margin-bottom: 10px;
        }

        .auth-subtitle {
            font-size: 18px;
            color: #666;
            margin-bottom: 30px;
        }}

        .password-input-wrapper {
            position: relative;
            width: 100%;
        }

        .password-input-wrapper input {
            padding-right: 40px;
        }

        .password-input-wrapper i {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            cursor: pointer;
            transition: color 0.2s;
            pointer-events: all;
        }

        .password-input-wrapper i:hover {
            color: #3a4b41;
        }

        .auth-divider {
            margin: 20px 0;
            color: #ddd;
        }

        .social-login {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .social-btn {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: #f9f9f9;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            color: #666;
        }

        .social-btn:hover {
            background: #3a4b41;
            color: white;
            border-color: #3a4b41;
        }

        .auth-link {
            color: #3a4b41;
            text-decoration: none;
            font-weight: 600;
        }

        .auth-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .auth-wrapper {
                flex-direction: column;
                height: auto;
                max-width: 100%;
                border-radius: 0;
            }

            .auth-form-section {
                padding: 40px 25px;
            }

            .auth-bg-section {
                min-height: 250px;
                padding: 30px 20px;
            }

            .auth-bg-section h2 {
                font-size: 24px;
            }

            .auth-wrapper {
                margin: 0;
                border-radius: 0;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-wrapper">
            <div class="auth-form-section">
                @yield('content')
            </div>
            <div class="auth-bg-section">
                @yield('sidebar')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>