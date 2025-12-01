<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LegalEase')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/css/theme.css">

    <style>
        .navbar-glass {
            background: rgba(40, 62, 49, 0.95);
            backdrop-filter: blur(6px);
            transition: all 0.35s ease;
        }

        .navbar-glass.scrolled {
            background: rgba(46, 69, 56, 0.5); 
            backdrop-filter: blur(10px);
        }

        .navbar-glass .navbar-brand {
            color: #ffd700;
            font-size: 1.55rem;
            font-weight: 700;
        }

        .navbar-glass .nav-link {
            color: #fff;
            font-weight: 500;
            padding: 8px 16px;
            transition: 0.25s;
        }

        .navbar-glass .nav-link:hover {
            color: #ffd700;
        }

        .badge-notification {
            font-size: 0.65rem;
            font-weight: 600;
            background: #d90000;
        }

        .navbar-shadow {
            box-shadow: 0 3px 15px rgba(0,0,0,0.15);
        }

        body {
            padding-top: 76px;
        }

        .dropdown-menu-glass {
            margin-top: 23px !important;
            background: rgba(255, 255, 255, 0.6) !important;
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .dropdown-menu-glass .dropdown-item {
            color: #000000;
            background-color: transparent !important;
        }

        .dropdown-menu-glass .dropdown-item:hover,
        .dropdown-menu-glass .dropdown-item.bg-light.fw-medium {
            background-color: rgba(255, 255, 255, 0.6) !important;
            color: #ffd700;
        }

        .dropdown-menu-glass .text-muted,
        .dropdown-menu-glass .text-primary {
            color: #000000 !important;
        }

        .dropdown-menu-glass .text-primary {
            color: #ffd700 !important;
        }

        .notification-dropdown-menu {
            width: 360px !important;
        }

        .notification-item {
            padding: 12px !important;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            background-color: #f8f9fa;
        }

        .notification-item:hover {
            background-color: #e9ecef;
        }

        .notification-item.unread {
            background-color: #e7f3ff;
            font-weight: 500;
        }

        .notification-time {
            font-size: 0.75rem;
            color: #6c757d;
        }

        .notification-dropdown-divider {
            margin: 5px 0;
        }

        .notification-footer {
            padding: 10px;
            text-align: center;
            background-color: #f8f9fa;
        }

        .notification-footer a {
            color: #007bff;
            font-size: 0.9rem;
            text-decoration: none;
        }

        .notification-footer a:hover {
            text-decoration: underline;
        }

        /* ============ FOOTER STYLES ============ */
        :root {
            --primary: #3A4B41;
            --text-light: #FFFFFF;
            --radius: 6px;
        }

        .footer {
            background-color: var(--primary);
            color: var(--text-light);
            padding: 40px 20px;
            font-family: Arial, sans-serif;
            text-align: center;
        }

        .footer a {
            color: var(--text-light);
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        .footer-top {
            display: flex;
            flex-wrap: wrap;
            gap: 40px;
            justify-content: center;
            margin-bottom: 30px;
        }

        .footer-section {
            min-width: 200px;
            padding: 0 30px;
        }

        .footer-section h2 {
            margin-bottom: 10px;
        }

        .footer-section ul {
            list-style: none;
            padding: 0;
        }

        .footer-section ul li {
            margin-bottom: 6px;
        }

        .footer-section.newsletter form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .footer-section.newsletter input[type="email"] {
            padding: 8px;
            border-radius: var(--radius);
            border: none;
        }

        .footer-section.newsletter button {
            padding: 8px;
            border: none;
            border-radius: var(--radius);
            background-color: var(--text-light);
            color: var(--primary);
            cursor: pointer;
        }

        .footer-section.newsletter label {
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .footer-social {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 20px;
            font-size: 24px;
        }

        .footer-social a {
            color: var(--text-light);
        }

        .footer-social a:hover {
            color: #E6CFA7;
        }

        .footer-bottom {
            font-size: 12px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            padding-top: 15px;
        }

        .footer-bottom p {
            margin: 5px 0;
        }
    </style>

    @yield('extra-css')
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-glass fixed-top navbar-shadow">
        <div class="container-fluid px-3">
            <a class="navbar-brand" href="/">
                <i class="bi bi-briefcase-fill"></i> LegalEase
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('lawyers.index') }}">Lawyers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('announcements.index') }}">Announcements</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('faqs.index') }}">FAQ</a>
                    </li>
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register.choice') }}">Register</a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content (No wrapper - full width) -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-top">
            <div class="footer-section">
                <h2>LegalEase</h2>
                <ul>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Our Lawyers</a></li>
                    <li><a href="#">News & Updates</a></li>
                    <li><a href="#">Services</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h2>Client Support</h2>
                <ul>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">Consultation Booking</a></li>
                </ul>
            </div>
            <div class="footer-section newsletter">
                <h2>Subscribe for Legal Updates</h2>
                <form>
                    <input type="email" placeholder="Your email here">
                    <button type="submit">Subscribe</button>
                    <label>
                        <input type="checkbox">
                        By checking the box, you agree to receive updates from LegalEase.
                    </label>
                </form>
            </div>
        </div>
        <div class="footer-social">
            <a href="#"><i class="bi bi-facebook"></i></a>
            <a href="#"><i class="bi bi-instagram"></i></a>
            <a href="#"><i class="bi bi-twitter"></i></a>
            <a href="#"><i class="bi bi-linkedin"></i></a>
            <a href="#"><i class="bi bi-youtube"></i></a>
        </div>
        <div class="footer-bottom">
            <p>
                <a href="#">Terms of Service</a> |
                <a href="#">Privacy Policy</a> |
                <a href="#">Accessibility</a> |
                <a href="#">Client Rights</a>
            </p>
            <p>©2025 LegalEase, LLC. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navbar glass effect on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar-glass');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>

    @yield('extra-js')
</body>
</html>
