@extends('layouts.guest')

@section('title', 'Home')

@section('content')
<style>
    :root {
        --primary: #3a4b41;
        --secondary: #E6CFA7;
    }
    
    /* ==================== HERO SECTION ==================== */
    .hero {
        min-height: 100vh;
        background-image: linear-gradient(135deg, rgba(58, 75, 65, 0.7), rgba(45, 61, 51, 0.7)), 
                          url('https://wallpapers.com/images/hd/monochrome-lawyer-scales-ouqsj5h0cf9421u8.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: white;
        padding: 0;
        margin: 0;
        position: relative;
        width: 100%;
        height: 100vh;
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

@endsection
