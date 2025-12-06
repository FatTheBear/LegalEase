@if(isset($_layout) && $_layout === 'layouts.guest')
    @extends('layouts.guest')
@else
    @extends('layouts.app')
@endif

@section('title', 'Home')

@section('content')
<style>
    :root {
        --primary: #3a4b41;
        --secondary: #E6CFA7;
    }
    
    /* Hide auth content for guests */
    @if(!auth()->check())
        .hero-section,
        .card-search,
        h2:not(.section-title),
        .list-group,
        .row.row-cols-1.row-cols-md-3 {
            display: none !important;
        }
    @endif
    
    /* ==================== HERO SECTION ==================== */
    .hero {
        min-height: 100vh;
        background: linear-gradient(135deg, var(--primary) 0%, #2d3d33 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: white;
        padding: 2rem;
    }
    
    .hero-content h1 {
        font-size: 3.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        text-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }
    
    .hero-content p {
        font-size: 1.3rem;
        margin-bottom: 2rem;
        opacity: 0.95;
    }
    
    .btn-get-started {
        background: var(--secondary);
        color: var(--primary);
        padding: 1rem 2.5rem;
        border: none;
        border-radius: 50px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    
    .btn-get-started:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        background: #d9ba8b;
    }
    
    /* ==================== SERVICES SECTION ==================== */
    .services {
        padding: 5rem 2rem;
        background: white;
    }
    
    .services-container {
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .section-title {
        text-align: center;
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: var(--primary);
    }
    
    .section-subtitle {
        text-align: center;
        font-size: 1.1rem;
        color: #666;
        margin-bottom: 3rem;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }
    
    .services-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
    }
    
    .service-card {
        background: var(--secondary);
        padding: 2rem;
        border-radius: 12px;
        text-align: center;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }
    
    .service-card:hover {
        transform: translateY(-5px);
        border-color: var(--primary);
        box-shadow: 0 10px 30px rgba(58, 75, 65, 0.2);
    }
    
    .service-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
    }
    
    .service-card h3 {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
        color: var(--primary);
    }
    
    .service-card p {
        color: #555;
        line-height: 1.8;
    }
    
    /* ==================== FAQ SECTION ==================== */
    .faq {
        padding: 5rem 2rem;
        background: var(--secondary);
    }
    
    .faq-container {
        max-width: 800px;
        margin: 0 auto;
    }
    
    .faq-item {
        background: white;
        margin-bottom: 1.5rem;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .faq-question {
        padding: 1.5rem;
        background: var(--secondary);
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.3s ease;
    }
    
    .faq-question:hover {
        background: #d9ba8b;
    }
    
    .faq-question h4 {
        font-size: 1.1rem;
        color: var(--primary);
        margin: 0;
        font-weight: 600;
    }
    
    .faq-toggle {
        font-size: 1.5rem;
        color: var(--primary);
        transition: transform 0.3s ease;
    }
    
    .faq-item.active .faq-toggle {
        transform: rotate(180deg);
    }
    
    .faq-answer {
        padding: 1.5rem;
        display: none;
        color: #666;
        line-height: 1.8;
        background: white;
    }
    
    .faq-item.active .faq-answer {
        display: block;
    }
    
    /* Beige card styling for lawyers */
    .card-lawyer {
        background-color: #E6CFA7 !important;
        border: none !important;
    }
    
    .card-lawyer .card-body {
        background-color: #E6CFA7;
        color: #333;
    }
    
    .card-lawyer .card-title {
        font-weight: 600;
        color: #2d2d2d;
    }
    
    .card-lawyer .card-text {
        color: #555;
    }
    
    .card-lawyer .text-muted {
        color: #666 !important;
    }
    
    .card-lawyer .btn-book {
        background-color: #3a4b41 !important;
        border-color: #3a4b41 !important;
        color: white !important;
        font-weight: 500;
    }
    
    .card-lawyer .btn-book:hover {
        background-color: #2d3d33 !important;
        border-color: #2d3d33 !important;
    }
    
    /* Search card styling */
    .card-search {
        background-color: #E6CFA7 !important;
        border: none !important;
    }
    
    .card-search .form-select {
        border: 1px solid #999;
        background-color: white;
    }
    
    .card-search .btn {
        background-color: #3a4b41 !important;
        border-color: #3a4b41 !important;
        color: #E6CFA7 !important;
        font-weight: 500;
    }
    
    .card-search .btn:hover {
        background-color: #2d3d33 !important;
    }
    
    /* Hero Find Lawyer button */
    .hero-section .btn-primary {
        background-color: #3a4b41 !important;
        border-color: #3a4b41 !important;
        color: #E6CFA7 !important;
    }
    
    .hero-section .btn-primary:hover {
        background-color: #2d3d33 !important;
        border-color: #2d3d33 !important;
    }

    /* ==================== RESPONSIVE ==================== */
    @media (max-width: 768px) {
        .hero-content h1 {
            font-size: 2rem;
        }
        
        .hero-content p {
            font-size: 1rem;
        }
        
        .section-title {
            font-size: 2rem;
        }
        
        .services-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<!-- Landing Page Section - Only show for guests -->
@guest
<!-- ==================== HERO SECTION ==================== -->
<section class="hero" id="hero">
    <div class="hero-content">
        <h1>Welcome to LegalEase</h1>
        <p>Connect with experienced lawyers and manage your legal services with ease</p>
        <a href="{{ route('login') }}" class="btn-get-started">Get Started</a>
    </div>
</section>

<!-- ==================== SERVICES SECTION ==================== -->
<section class="services" id="services">
    <div class="services-container">
        <h2 class="section-title">Featured Legal Services</h2>
        <p class="section-subtitle">Explore the key services offered by our platform</p>
        
        <div class="services-grid">
            <!-- Service 1 -->
            <div class="service-card">
                <div class="service-icon">⚖️</div>
                <h3>Legal Consultation</h3>
                <p>Connect with experienced lawyers for professional legal advice on various matters</p>
            </div>
            
            <!-- Service 2 -->
            <div class="service-card">
                <div class="service-icon">📋</div>
                <h3>Document Review</h3>
                <p>Get expert review and guidance on legal documents and contracts</p>
            </div>
            
            <!-- Service 3 -->
            <div class="service-card">
                <div class="service-icon">🤝</div>
                <h3>Case Management</h3>
                <p>Efficiently manage and track legal cases with our comprehensive platform</p>
            </div>
        </div>
    </div>
</section>

<!-- ==================== FAQ SECTION ==================== -->
<section class="faq" id="faq">
    <div class="faq-container">
        <h2 class="section-title">Frequently Asked Questions</h2>
        <p class="section-subtitle">Find answers to common questions</p>
        
        @forelse($faqs as $faq)
        <div class="faq-item">
            <div class="faq-question" onclick="toggleFaq(this)">
                <h4>{{ $faq->question }}</h4>
                <span class="faq-toggle">▼</span>
            </div>
            <div class="faq-answer">
                {{ $faq->answer }}
            </div>
        </div>
        @empty
        <div style="text-align: center; padding: 2rem; color: #999;">
            <p>No FAQs available at the moment</p>
        </div>
        @endforelse
    </div>
</section>

<script>
    function toggleFaq(element) {
        const faqItem = element.parentElement;
        faqItem.classList.toggle('active');
    }
    
    // Smooth scroll for "Get Started" button
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href !== '#') {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            }
        });
    });
</script>
@else
    {{-- Hero Section --}}
    <div class="row align-items-center mb-5 hero-section">
        <div class="col-md-6">
            <h1 class="display-4 fw-bold">Welcome to LegalEase</h1>
            
            <p class="lead">Connect with verified lawyers quickly, securely, and conveniently.</p>
            
            <a href="{{ route('lawyers.index') }}" class="btn btn-primary btn-lg me-2">Find a Lawyer</a>
        </div>
        <div class="col-md-6 text-center">
            <img src="/images/logohome1.png" alt="LegalEase" class="img-fluid rounded">
        </div>
    </div>

    {{-- Lawyer Search --}}
    <div class="card shadow mb-5 p-4 card-search">
        <form action="{{ route('home') }}" method="GET" class="row g-3 align-items-center">
            <div class="col-md-5">
                <select name="specialization" class="form-select">
                    <option value="">Select Specialization</option>
                    @foreach($specializations as $spec)
                        <option value="{{ $spec }}" {{ $spec == $specialization ? 'selected' : '' }}>{{ $spec }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-5">
                <select name="province" class="form-select">
                    <option value="">Select Province</option>
                    @foreach($provinces as $prov)
                        <option value="{{ $prov }}" {{ $prov == $province ? 'selected' : '' }}>{{ $prov }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-grid">
                <button class="btn btn-primary">Search</button>
            </div>
        </form>
    </div>

    {{-- Search Results / Featured Lawyers --}}
    @php $lawyersToShow = $searchResults ?? $featuredLawyers; @endphp
    @if($lawyersToShow)
        <h2 class="mb-4">{{ $searchResults ? 'Search Results' : 'Featured Lawyers' }}</h2>
        <div class="row row-cols-1 row-cols-md-3 g-4 mb-5">
            @forelse($lawyersToShow as $lawyer)
                <div class="col">
                    <div class="card h-100 shadow-sm card-lawyer">
                        <img src="{{ $lawyer->hasAvatar() ? $lawyer->getAvatarUrl() : '/images/default-lawyer.jpg' }}" class="card-img-top" alt="{{ $lawyer->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $lawyer->name }}</h5>
                            <p class="card-text">{{ $lawyer->lawyerProfile->specialization ?? 'General Lawyer' }}</p>
                            <p class="text-muted"><i class="bi bi-geo-alt"></i> {{ $lawyer->lawyerProfile->province ?? 'Nationwide' }}</p>
                            <p>
                                @php $avgRating = $lawyer->ratings->avg('rating'); @endphp
                                @if($avgRating)
                                    <i class="bi bi-star-fill text-warning"></i>
                                    {{ number_format($avgRating, 1) }}
                                @else
                                    <span class="text-muted">No Ratings Yet</span>
                                @endif
                            </p>
                            <a href="{{ route('lawyers.show', $lawyer->id) }}" class="btn btn-book w-100 btn-primary">Book Appointment</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="bi bi-emoji-frown" style="font-size: 4rem; color: #ccc;"></i>
                    <p class="text-muted mt-3">No lawyers found matching your criteria.</p>
                </div>
            @endforelse
        </div>
    @endif

    {{-- Announcements --}}
    <h2 class="mb-4">Legal Updates & Announcements</h2>
    <div class="list-group mb-5 ">
        @foreach($announcements as $announcement)
            <a href="{{ route('announcements.index') }}" class="list-group-item list-group-item-action btn-primary"
                       style="
                            background-color: #3A4B41; 
                            color: #FFD700; 
                            padding: 20px; 
                            border-radius: 12px; 
                            margin-bottom: 12px; 
                            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                            transition: 0.25s;
                        ">
                <div class="d-flex w-100 justify-content-between btn-primary">
                    <h5 class="mb-1">{{ $announcement->title }}</h5>
                    <small>{{ $announcement->created_at->format('d/m/Y') }}</small>
                </div>
                <p class="mb-1 text-truncate">{{ $announcement->content }}</p>
            </a>
            <br>
        @endforeach
    </div>
@endguest

@endsection
