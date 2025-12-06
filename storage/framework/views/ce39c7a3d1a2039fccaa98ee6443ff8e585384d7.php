<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'LegalEase'); ?></title>

    <link rel="icon" type="image/png" href="<?php echo e(asset('images/logohome.png')); ?>">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <link rel="stylesheet" href="/css/theme.css">

    <style>
        /* ========================= NAVBAR GLASS EFFECT ========================= */
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
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .navbar-brand-logo {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ffd700, #e6cfa7);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            font-weight: 700;
            color: #3a4b41;
            box-shadow: 0 2px 8px rgba(255,215,0,0.3);
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

        footer {
            background: linear-gradient(to right, #a86f20, #603207);
            color: #fff;
        }

        footer a {
            color: #ffd700;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }
        
        /* ========================= CUSTOM DROPDOWN GLASS EFFECT ========================= */
        .dropdown-menu-glass {
            margin-top: 23px !important; /* Tăng khoảng cách so với navbar */
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
            max-width: 90vw !important;
        }
    </style>

    <?php echo $__env->yieldContent('styles'); ?>
</head>

<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg navbar-glass navbar-shadow fixed-top">
        <div class="container">
            <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
                <div class="navbar-brand-logo">
                    <i class="bi bi-scale-balanced"></i>
                </div>
                <span>LegalEase</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">

                    <!-- Link chính -->
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('/')); ?>">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(route('lawyers.index')); ?>">Lawyers</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(route('appointments.index')); ?>">Appointments</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(route('announcements.index')); ?>">Announcements</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(route('faqs.index')); ?>">FAQ</a></li>

                    <?php if(auth()->guard()->check()): ?>
                        <!-- Notifications -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle position-relative d-flex align-items-center"
                               href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-bell fs-5"></i>
                                <span class="ms-1 d-none d-lg-inline">Notifications</span>
                                <?php
                                    $unread = Auth::user()->notifications()->where('is_read', false)->count();
                                ?>
                                <?php if($unread > 0): ?>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill badge-notification">
                                        <?php echo e($unread > 99 ? '99+' : $unread); ?>

                                    </span>
                                <?php endif; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow dropdown-menu-glass notification-dropdown-menu">
                                <?php
                                    $latestNotif = Auth::user()->notifications()->latest()->first();
                                ?>
                                <?php if($latestNotif): ?>
                                    <li>
                                        <a class="dropdown-item py-3 <?php echo e($latestNotif->is_read ? '' : 'bg-light fw-medium'); ?>"
                                           href="<?php echo e(route('notifications.index')); ?>">
                                            <div class="fw-semibold"><?php echo e($latestNotif->title); ?></div>
                                            <div class="small text-muted"><?php echo e(Str::limit($latestNotif->message, 40)); ?></div>
                                            <div class="small text-muted mt-1"><?php echo e($latestNotif->created_at->diffForHumans()); ?></div>
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider my-1"></li>
                                    <li class="text-center">
                                        <a class="dropdown-item text-primary fw-medium" href="<?php echo e(route('notifications.index')); ?>">
                                            View all notifications
                                        </a>
                                    </li>
                                <?php else: ?>
                                    <li><div class="dropdown-item text-center text-muted py-4">No notifications yet</div></li>
                                <?php endif; ?>
                            </ul>
                        </li>

                        <!-- Dashboard link ra ngoài cùng -->
                        <?php if(auth()->user()->role === 'admin'): ?>
                            <li class="nav-item"><a class="nav-link fw-semibold" href="<?php echo e(route('admin.dashboard')); ?>">Admin Dashboard</a></li>
                        <?php elseif(auth()->user()->role === 'lawyer'): ?>
                            <li class="nav-item"><a class="nav-link fw-semibold" href="<?php echo e(route('lawyer.dashboard')); ?>">Lawyer Dashboard</a></li>
                        <?php elseif(auth()->user()->role === 'customer'): ?>
                            <li class="nav-item"><a class="nav-link fw-semibold" href="<?php echo e(route('customer.dashboard')); ?>">My Dashboard</a></li>
                        <?php endif; ?>
                    <?php endif; ?>

                    <!-- User dropdown -->
                    <?php if(auth()->guard()->guest()): ?>
                        <li class="nav-item"><a class="nav-link" href="<?php echo e(route('login')); ?>">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo e(route('register.choice')); ?>">Register</a></li>
                    <?php else: ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i> <?php echo e(Auth::user()->name); ?>

                            </a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-glass"> 
                                <li>
                                    <form action="<?php echo e(route('logout')); ?>" method="POST"><?php echo csrf_field(); ?>
                                        <button class="dropdown-item text-danger">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>

                </ul>
            </div>
        </div>
    </nav>

    <main class="container mt-4 mb-5">
        <div class="content-wrapper shadow-sm p-4 rounded-3 bg-white">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </main>

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
        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.querySelector('.navbar-glass');
            const toggleNavbarOpacity = () => {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            };
            window.addEventListener('scroll', toggleNavbarOpacity);
            toggleNavbarOpacity();
        });
    </script>
    <?php echo $__env->make('components.chat-live', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>
</html>

<style>
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

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<?php /**PATH G:\firstlaravel_demo\LegalEase\resources\views/layouts/app.blade.php ENDPATH**/ ?>