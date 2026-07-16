@extends('layouts.customer')

@section('title', 'Home - MediaBook')

@section('content')

<style>
    html,
    body {
        overflow-x: hidden;
        background: #f8fafc;
    }

    body {
        background: #f8fafc;
        font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
    }

    .section-title {
        font-size: 2rem;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.02em;
    }

    .section-subtitle {
        color: #475569;
        font-size: 1rem;
        font-weight: 400;
    }

    /* HERO - NUANSA TOKO BUKU */
    .hero-section {
        background: linear-gradient(135deg, #f1f5f9 0%, #e6edf5 100%);
        position: relative;
        overflow: hidden;
        padding: 70px 0;
        margin-top: -24px;
        width: 100%;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .hero-section::before {
        content: '';
        position: absolute;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(139, 92, 246, 0.08) 0%, rgba(139, 92, 246, 0) 70%);
        border-radius: 50%;
        top: -150px;
        right: -100px;
        z-index: 0;
    }

    .hero-section::after {
        content: '';
        position: absolute;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(59, 130, 246, 0.06) 0%, rgba(59, 130, 246, 0) 70%);
        border-radius: 50%;
        bottom: -100px;
        left: -80px;
        z-index: 0;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        width: 100%;
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 32px;
    }

    .hero-badge {
        background: rgba(139, 92, 246, 0.12);
        color: #5b21b6;
        backdrop-filter: blur(4px);
        padding: 8px 18px;
        border-radius: 40px;
        display: inline-block;
        font-weight: 600;
        font-size: 0.85rem;
        margin-bottom: 24px;
        letter-spacing: 0.3px;
    }

    .hero-title {
        font-size: 3.5rem;
        font-weight: 800;
        line-height: 1.2;
        color: #0f172a;
        margin-bottom: 20px;
        letter-spacing: -0.02em;
    }

    .hero-title span {
        background: linear-gradient(135deg, #8b5cf6, #3b82f6);
        background-clip: text;
        -webkit-background-clip: text;
        color: transparent;
    }

    .hero-subtitle {
        color: #334155;
        font-size: 1.05rem;
        max-width: 580px;
        line-height: 1.7;
        margin-bottom: 36px;
    }

    .hero-btn {
        border-radius: 40px;
        padding: 12px 28px;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .hero-feature {
        background: white;
        border-radius: 24px;
        padding: 18px 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02), 0 1px 2px rgba(0, 0, 0, 0.03);
        border: 1px solid rgba(203, 213, 225, 0.6);
        transition: 0.2s ease;
    }

    .hero-feature-icon {
        width: 48px;
        height: 48px;
        border-radius: 28px;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #3b82f6;
        font-size: 22px;
        margin-bottom: 14px;
    }

    /* CATEGORY CARD - TEMA BUKU */
    .category-section {
        margin-top: 70px;
    }

    .category-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 32px;
        flex-wrap: wrap;
        gap: 20px;
    }

    .category-nav-btn {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: white;
        border: 1px solid #e2e8f0;
        color: #1e293b;
        transition: all 0.2s;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
    }

    .category-nav-btn:hover {
        background: #8b5cf6;
        border-color: #8b5cf6;
        color: white;
        transform: scale(1.02);
    }

    .category-slider {
        display: flex;
        gap: 24px;
        overflow-x: auto;
        scroll-behavior: smooth;
        padding-bottom: 12px;
    }

    .category-item {
        min-width: calc(33.333% - 16px);
        flex-shrink: 0;
    }

    .category-card {
        background: white;
        border-radius: 32px;
        padding: 32px 24px;
        transition: 0.25s ease;
        border: 1px solid #eef2ff;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.02);
        height: 100%;
        position: relative;
    }

    .category-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 30px -12px rgba(0, 0, 0, 0.1);
        border-color: #cbd5e1;
    }

    .category-icon {
        width: 70px;
        height: 70px;
        border-radius: 28px;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        margin-bottom: 24px;
        color: #0f172a;
    }

    .category-btn {
        border-radius: 40px;
        padding: 8px 24px;
        font-weight: 500;
        font-size: 0.9rem;
        background: #0f172a;
        border: none;
    }

    .category-btn:hover {
        background: #8b5cf6;
        transform: translateY(-2px);
    }

    /* PRODUCT CARD - GAYA BUKU */
    .product-section {
        margin-top: 80px;
        background: #ffffff;
        padding: 70px 0;
        border-top: 1px solid #eef2ff;
        border-bottom: 1px solid #eef2ff;
    }

    .product-content-wrapper {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 32px;
    }

    .product-card {
        border-radius: 28px;
        overflow: hidden;
        transition: 0.25s ease;
        background: white;
        border: 1px solid #edf2f7;
        box-shadow: 0 6px 14px rgba(0, 0, 0, 0.02);
        height: 100%;
    }

    .product-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 24px 36px -12px rgba(0, 0, 0, 0.12);
        border-color: #cbd5e1;
    }

    .product-image-wrapper {
        height: 220px;
        background: #fafcff;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px;
        border-bottom: 1px solid #f0f2f5;
    }

    .product-image {
        width: auto;
        max-height: 100%;
        object-fit: contain;
        transition: 0.2s;
    }

    .product-badge {
        background: #f1f5f9;
        color: #334155;
        padding: 5px 12px;
        border-radius: 40px;
        font-size: 0.7rem;
        font-weight: 600;
        letter-spacing: 0.3px;
    }

    .product-price {
        font-size: 1.3rem;
        font-weight: 800;
        color: #0f172a;
    }

    /* WHY US - NUANSA LEMBUT */
    .why-section {
        margin: 80px 0 60px;
    }

    .feature-card {
        background: white;
        border: 1px solid #edf2f9;
        border-radius: 32px;
        padding: 40px 28px;
        text-align: center;
        transition: 0.2s;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
    }

    .feature-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 30px -12px rgba(0, 0, 0, 0.08);
        border-color: #cbd5e6;
    }

    .feature-icon {
        width: 80px;
        height: 80px;
        margin: auto auto 24px;
        border-radius: 40px;
        background: #f1f5f9;
        color: #3b82f6;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 34px;
    }

    .container-custom {
        width: 100%;
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 32px;
    }

    /* Navbar brand styling (akan digunakan di layout) */
    .navbar-brand-custom {
        font-size: 1.5rem;
        font-weight: 800;
        background: linear-gradient(135deg, #8b5cf6, #3b82f6);
        background-clip: text;
        -webkit-background-clip: text;
        color: transparent;
        text-decoration: none;
    }

    @media (max-width: 992px) {
        .hero-title {
            font-size: 2.6rem;
        }
        .category-item {
            min-width: calc(50% - 12px);
        }
    }

    @media (max-width: 768px) {
        .hero-title {
            font-size: 2rem;
        }
        .category-item {
            min-width: 100%;
        }
        .hero-content,
        .container-custom,
        .product-content-wrapper {
            padding: 0 20px;
        }
    }
</style>

<!-- HERO SECTION BERTEMA BUKU -->
<section class="hero-section">
    <div class="hero-content">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="hero-badge">
                    📚 TOKO BUKU ONLINE TERPERCAYA
                </span>

                <h1 class="hero-title">
                    Temukan Dunia Ilmu <br>
                    Lewat <span>Bacaan Berkualitas</span>
                </h1>

                <p class="hero-subtitle">
                    Ribuan koleksi buku dari berbagai genre tersedia untuk Anda.
                    Dari fiksi hingga pengembangan diri, semuanya original dan
                    dikemas dengan pelayanan terbaik.
                </p>

                <div class="d-flex flex-wrap gap-3 mb-5">
                    <a href="{{ route('customer.shop.index') }}" class="btn btn-primary hero-btn"
                       style="background: #0f172a; border: none;">
                        <i class="bi bi-book-fill me-2"></i>
                        Mulai Membaca
                    </a>

                    <a href="#products" class="btn btn-outline-secondary hero-btn"
                       style="border-radius: 40px; border-color: #cbd5e1; color: #1e293b;">
                        <i class="bi bi-compass me-2"></i>
                        Jelajahi Koleksi
                    </a>
                </div>

                <!-- FEATURE UNTUK BUKU -->
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="hero-feature">
                            <div class="hero-feature-icon">
                                <i class="bi bi-stack"></i>
                            </div>
                            <h6 class="fw-bold mb-1">100% Buku Original</h6>
                            <small class="text-muted">Garansi keaslian setiap eksemplar</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="hero-feature">
                            <div class="hero-feature-icon">
                                <i class="bi bi-tags"></i>
                            </div>
                            <h6 class="fw-bold mb-1">Harga Ramah Kantong</h6>
                            <small class="text-muted">Promo & diskon setiap minggu</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="hero-feature">
                            <div class="hero-feature-icon">
                                <i class="bi bi-box-seam"></i>
                            </div>
                            <h6 class="fw-bold mb-1">Pengiriman ke Seluruh Indonesia</h6>
                            <small class="text-muted">Packing aman & tracking realtime</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CONTAINER UNTUK KATEGORI -->
<div class="container-custom">
    <section class="category-section">
        <div class="category-header">
            <div>
                <h2 class="section-title mb-2">📖 Pilih Genre Buku</h2>
                <p class="section-subtitle">Temukan bacaan favorit berdasarkan kategori</p>
            </div>
            <div class="category-nav-buttons">
                <button class="category-nav-btn" id="prevCategoryBtn"><i class="bi bi-chevron-left"></i></button>
                <button class="category-nav-btn" id="nextCategoryBtn"><i class="bi bi-chevron-right"></i></button>
            </div>
        </div>

        <div class="category-slider-container">
            <div class="category-slider" id="categorySlider">
                @foreach($categories as $category)
                    @php
                        $icon = 'bi-book';
                        $bgCard = '#ffffff';

                        if(str_contains(strtolower($category->name), 'fiksi')) {
                            $icon = 'bi-pen-fill';
                        } elseif(str_contains(strtolower($category->name), 'novel')) {
                            $icon = 'bi-journal-bookmark-fill';
                        } elseif(str_contains(strtolower($category->name), 'bisnis')) {
                            $icon = 'bi-bar-chart-steps';
                        } elseif(str_contains(strtolower($category->name), 'pengembangan diri')) {
                            $icon = 'bi-gem';
                        } elseif(str_contains(strtolower($category->name), 'sejarah')) {
                            $icon = 'bi-clock-history';
                        } elseif(str_contains(strtolower($category->name), 'sains')) {
                            $icon = 'bi-cpu';
                        } else {
                            $icon = 'bi-book-half';
                        }
                    @endphp
                    <div class="category-item">
                        <div class="category-card" style="background: {{ $bgCard }};">
                            <div class="category-icon">
                                <i class="bi {{ $icon }}"></i>
                            </div>
                            <h4 class="fw-bold mb-2">{{ $category->name }}</h4>
                            <p class="text-muted small mb-4">Koleksi terbaik untuk menambah wawasan</p>
                            <a href="{{ route('customer.shop.index', ['category' => $category->id]) }}"
                               class="btn btn-dark category-btn">
                                Lihat Buku
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>

<!-- PRODUK TERBARU (BUKU) DENGAN GAYA LEMBUT -->
<section class="product-section" id="products">
    <div class="product-content-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div>
                <h2 class="section-title mb-2">📚 Produk Buku Terbaru</h2>
                <p class="section-subtitle mb-0">Rilis terbaru & best seller pilihan editor</p>
            </div>
            <a href="{{ route('customer.shop.index') }}" class="btn btn-outline-dark rounded-pill px-4 py-2">
                Semua Buku
            </a>
        </div>

        <div class="row">
            @foreach($featuredProducts as $product)
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="product-card">
                        <div class="product-image-wrapper">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}"
                                     class="product-image"
                                     alt="{{ $product->name }}">
                            @else
                                <img src="https://via.placeholder.com/300x300?text=Cover+Buku"
                                     class="product-image"
                                     alt="Cover Buku">
                            @endif
                        </div>
                        <div class="card-body p-4">
                            <span class="product-badge d-inline-block mb-3">
                                {{ $product->category->name ?? 'Buku' }}
                            </span>
                            <h5 class="fw-bold mb-2">{{ $product->name }}</h5>
                            <p class="text-muted small" style="min-height: 45px;">
                                Buku inspiratif untuk perjalanan intelektual Anda.
                            </p>
                            <div class="product-price mb-3">
                                {{ $product->formatted_price }}
                            </div>
                            <a href="{{ route('customer.shop.show', $product) }}"
                               class="btn btn-dark w-100 rounded-pill">
                                Detail Buku
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- KENAPA MEMILIH KAMI (TEMA BUKU) -->
<div class="container-custom">
    <section class="why-section">
        <div class="text-center mb-5">
            <h2 class="section-title mb-3">✨ Kenapa Berbelanja Buku di Sini?</h2>
            <p class="section-subtitle">Kami memahami kebutuhan literasi Anda</p>
        </div>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-truck"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Pengiriman Cepat & Aman</h4>
                    <p class="text-muted mb-0">Buku sampai dengan plastik pelindung & bubble wrap</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-patch-check-fill"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Buku Original 100%</h4>
                    <p class="text-muted mb-0">Mitra resmi penerbit besar di Indonesia</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-chat-dots"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Rekomendasi Personal</h4>
                    <p class="text-muted mb-0">Tim kami siap membantu menemukan buku yang tepat</p>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- SCRIPT UNTUK CATEGORY SLIDER (TETAP SAMA) -->
<script>
    const slider = document.getElementById('categorySlider');
    const prevBtn = document.getElementById('prevCategoryBtn');
    const nextBtn = document.getElementById('nextCategoryBtn');

    if (slider && prevBtn && nextBtn) {
        prevBtn.addEventListener('click', () => {
            const scrollAmount = slider.clientWidth - 100;
            slider.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
        });

        nextBtn.addEventListener('click', () => {
            const scrollAmount = slider.clientWidth - 100;
            slider.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        });

        let autoSlide = setInterval(() => {
            const maxScroll = slider.scrollWidth - slider.clientWidth;
            if (slider.scrollLeft >= maxScroll - 10) {
                slider.scrollTo({ left: 0, behavior: 'smooth' });
            } else {
                const scrollAmount = slider.clientWidth - 100;
                slider.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            }
        }, 5000);

        const sliderContainer = document.querySelector('.category-slider-container');
        if (sliderContainer) {
            sliderContainer.addEventListener('mouseenter', () => clearInterval(autoSlide));
            sliderContainer.addEventListener('mouseleave', () => {
                autoSlide = setInterval(() => {
                    const maxScroll = slider.scrollWidth - slider.clientWidth;
                    if (slider.scrollLeft >= maxScroll - 10) {
                        slider.scrollTo({ left: 0, behavior: 'smooth' });
                    } else {
                        const scrollAmount = slider.clientWidth - 100;
                        slider.scrollBy({ left: scrollAmount, behavior: 'smooth' });
                    }
                }, 5000);
            });
        }

        function updateNavButtons() {
            const maxScroll = slider.scrollWidth - slider.clientWidth;
            prevBtn.style.opacity = slider.scrollLeft <= 10 ? '0.5' : '1';
            prevBtn.style.cursor = slider.scrollLeft <= 10 ? 'not-allowed' : 'pointer';
            nextBtn.style.opacity = slider.scrollLeft >= maxScroll - 10 ? '0.5' : '1';
            nextBtn.style.cursor = slider.scrollLeft >= maxScroll - 10 ? 'not-allowed' : 'pointer';
        }

        slider.addEventListener('scroll', updateNavButtons);
        updateNavButtons();
    }
</script>

@endsection
