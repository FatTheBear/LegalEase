<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LegalEase')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        /* ===================== NAVBAR ===================== */
        .navbar-custom {
            background: linear-gradient(90deg, #4b6cb7, #182848);
        }
        .navbar-custom .nav-link {
            color: #fff;
            font-weight: 500;
            transition: color 0.2s;
        }
        .navbar-custom .nav-link:hover {
            color: #ffd700;
        }
        .navbar-custom .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: #ffd700;
        }
        .badge-notification {
            font-size: 0.65rem;
            font-weight: 600;
        }

        /* ===================== FOOTER ===================== */
        footer {
            background: linear-gradient(to right, #4b6cb7, #182848);
            color: #fff;
        }
        footer a {
            color: #ffd700;
            text-decoration: none;
        }
        footer a:hover {
            text-decoration: underline;
        }
        .footer-links a {
            margin: 0 10px;
        }
    </style>
    @yield('styles')
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-custom shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">LegalEase</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('lawyers.index') }}">Lawyers</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('appointments.index') }}">Appointments</a></li>

                    <!-- NOTIFICATION DROPDOWN -->
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle position-relative d-flex align-items-center" 
                               href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-bell fs-5"></i>
                                <span class="ms-1 d-none d-lg-inline">Notifications</span>

                                @php
                                    $unreadCount = Auth::user()->notifications()->where('is_read', false)->count();
                                @endphp
                                @if($unreadCount > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger badge-notification">
                                        {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                                        <span class="visually-hidden">unread notifications</span>
                                    </span>
                                @endif
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow" style="width: 340px;">
                                @php
                                    $recentNotifs = Auth::user()->notifications()->latest()->take(6)->get();
                                @endphp
                                @if($recentNotifs->count() > 0)
                                    @foreach($recentNotifs as $notif)
                                        <li>
                                            <a class="dropdown-item py-3 {{ $notif->is_read ? '' : 'bg-light fw-medium' }}" 
                                               href="{{ route('notifications.index') }}">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0">
                                                        @if(!$notif->is_read)
                                                            <i class="bi bi-circle-fill text-primary me-2" style="font-size: 0.6rem;"></i>
                                                        @endif
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <div class="fw-semibold">{{ $notif->title }}</div>
                                                        <div class="small text-muted">{{ Str::limit($notif->message, 70) }}</div>
                                                        <div class="text-muted small mt-1">{{ $notif->created_at->diffForHumans() }}</div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider my-1"></li>
                                    @endforeach
                                    <li class="text-center">
                                        <a class="dropdown-item text-primary fw-medium" href="{{ route('notifications.index') }}">
                                            View all notifications
                                        </a>
                                    </li>
                                @else
                                    <li><div class="dropdown-item text-center text-muted py-4">No notifications yet</div></li>
                                @endif
                            </ul>
                        </li>
                    @endauth
                    {{-- announcement --}}
                    <li class="nav-item"><a class="nav-link" href="{{ route('announcements.index') }}">Announcements</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('faqs.index') }}">FAQ</a></li>

                    <!-- USER MENU -->
                    @guest
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                        <li class="nav-item"><a class="nav-link btn btn-outline-warning btn-sm px-3 ms-2" href="{{ route('register.choice') }}">Register</a></li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @if(auth()->user()->role === 'admin')
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
                                @elseif(auth()->user()->role === 'lawyer')
                                    <li><a class="dropdown-item" href="{{ route('lawyer.dashboard') }}">Lawyer Dashboard</a></li>
                                @elseif(auth()->user()->role === 'customer')
                                    <li><a class="dropdown-item" href="{{ route('customer.dashboard') }}">My Dashboard</a></li>
                                @endif
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile Settings</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Flash Message -->
    @if(session('success'))
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <!-- MAIN CONTENT -->
    <main class="container mt-4 mb-5">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="mt-auto py-5">
        <div class="container text-center">
            <div class="mb-3 footer-links">
                <a href="{{ url('/') }}">Home</a> |
                <a href="{{ route('lawyers.index') }}">Lawyers</a> |
                <a href="{{ route('appointments.index') }}">Appointments</a> |
                <a href="{{ route('faqs.index') }}">FAQ</a>
            </div>
            <small>© {{ date('Y') }} LegalEase — Nền tảng tư vấn pháp lý trực tuyến uy tín</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
