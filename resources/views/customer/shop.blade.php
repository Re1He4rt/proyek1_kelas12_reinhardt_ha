@extends('layouts.customer')

@section('title', 'Belanja Buku - MediaBook')

@section('content')

<div class="container py-4 shop-page">

<style>
    /* =============================
       GLOBAL RESET & BASE STYLES
       ============================= */
    * {
        box-sizing: border-box;
    }

    html,
    body {
        background: #f8fafc;
        overflow-x: hidden !important;
        width: 100%;
        margin: 0;
        padding: 0;
    }

    img {
        max-width: 100%;
        height: auto;
        display: block;
    }

    /* =============================
       HERO SECTION - TEMA BUKU
       ============================= */
    .shop-hero {
        background: linear-gradient(135deg, #f5f3ff, #ede9fe);
        border-radius: 32px;
        overflow: hidden;
        position: relative;
    }

    .shop-hero::before {
        content: '📚';
        position: absolute;
        font-size: 12rem;
        opacity: 0.06;
        top: -60px;
        right: -20px;
        transform: rotate(15deg);
    }

    .shop-hero::after {
        content: '📖';
        position: absolute;
        font-size: 8rem;
        opacity: 0.05;
        bottom: -30px;
        left: -30px;
        transform: rotate(-10deg);
    }

    .hero-image {
        max-height: 340px;
        width: 100%;
        object-fit: cover;
        border-radius: 24px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, .15);
    }

    .hero-title {
        color: #0f172a;
    }

    .hero-subtitle {
        color: #475569;
    }

    /* =============================
       FILTER SECTION
       ============================= */
    .filter-card {
        border: none;
        border-radius: 28px;
        overflow: hidden;
        box-shadow: 0 10px 35px rgba(0, 0, 0, .05);
    }

    .search-input,
    .form-select {
        min-height: 54px;
        border-radius: 16px;
        border: 1px solid #dbe4ee;
        padding-left: 16px;
        font-weight: 500;
    }

    .search-input:focus,
    .form-select:focus {
        border-color: #8b5cf6;
        box-shadow: 0 0 0 0.2rem rgba(139,92,246,.15);
    }

    .btn-modern {
        border-radius: 16px;
        min-height: 54px;
        font-weight: 600;
        background: #8b5cf6;
        border: none;
        color: #fff;
    }

    .btn-modern:hover {
        background: #7c3aed;
    }

    /* =============================
       PRODUCT GRID & CARD FIXES
       ============================= */
    .row {
        --bs-gutter-x: 1.5rem;
        margin-left: auto !important;
        margin-right: auto !important;
        width: 100%;
        max-width: 100%;
    }

    .col-lg-4,
    .col-md-6 {
        display: flex;
        overflow: visible;
        min-width: 0;
        max-width: 100%;
    }

    .product-card {
        width: 100%;
        max-width: 100%;
        min-width: 0;
        border: none;
        border-radius: 28px;
        overflow: hidden;
        background: #fff;
        height: 100%;
        transition: .35s ease;
        box-shadow: 0 10px 30px rgba(15, 23, 42, .06);
        display: flex;
        flex-direction: column;
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 50px rgba(139, 92, 246, .12);
    }

    /* =============================
       PRODUCT IMAGE WRAPPER
       ============================= */
    .product-image-wrapper {
        position: relative;
        width: 100%;
        height: 260px;
        background: #faf5ff;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        flex-shrink: 0;
        border-bottom: 1px solid #ede9fe;
    }

    .product-image {
        width: auto;
        height: auto;
        max-width: 100%;
        max-height: 200px;
        object-fit: contain;
        object-position: center;
        display: block;
        transition: .35s ease;
    }

    .product-card:hover .product-image {
        transform: scale(1.05);
    }

    /* =============================
       CATEGORY BADGE - GENRE BUKU
       ============================= */
    .category-badge {
        position: absolute;
        top: 16px;
        left: 16px;
        background: rgba(139, 92, 246, .9);
        color: #fff;
        padding: 6px 14px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
        z-index: 5;
        backdrop-filter: blur(4px);
        letter-spacing: 0.3px;
    }

    /* =============================
       PRODUCT BODY
       ============================= */
    .book-author {
        color: #64748b;
        font-size: 0.85rem;
    }

    .price-text {
        color: #8b5cf6;
        font-size: 1.35rem;
        font-weight: 800;
    }

    .stock-box {
        background: #f8fafc;
        border-radius: 16px;
        padding: 14px 16px;
    }

    /* =============================
       PRODUCT ACTION BUTTONS
       ============================= */
    .product-action {
        display: flex;
        gap: 12px;
        align-items: center;
        width: 100%;
    }

    .detail-btn {
        flex: 1;
        border: none;
        border-radius: 16px;
        background: #0f172a;
        color: white;
        font-weight: 700;
        padding: 14px 18px;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: .25s ease;
        min-width: 0;
    }

    .detail-btn:hover {
        background: #1e1b4b;
        color: white;
    }

    .cart-btn {
        width: 56px;
        height: 56px;
        border: none;
        border-radius: 16px;
        background: #8b5cf6;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: .25s ease;
        font-size: 20px;
        flex-shrink: 0;
        cursor: pointer;
    }

    .cart-btn:hover {
        background: #0f172a;
        transform: translateY(-2px);
    }

    /* =============================
       EMPTY STATE
       ============================= */
    .empty-state {
        background: #fff;
        border-radius: 30px;
        padding: 80px 20px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0, 0, 0, .05);
    }

    .empty-icon {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: #f5f3ff;
        color: #8b5cf6;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: auto;
        font-size: 50px;
    }

    /* =============================
       PAGINATION
       ============================= */
    .pagination {
        gap: 8px;
    }

    .page-link {
        border: none;
        border-radius: 12px !important;
        padding: 10px 16px;
        color: #0f172a;
        font-weight: 600;
        box-shadow: 0 4px 10px rgba(0, 0, 0, .05);
    }

    .page-link:hover {
        background: #8b5cf6;
        color: white;
    }

    .page-item.active .page-link {
        background: #8b5cf6;
        color: white;
    }

    .page-item.disabled .page-link {
        opacity: .5;
    }

    .pagination-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 40px;
    }

    /* =============================
       QUANTITY SELECTOR (SHOP)
       ============================= */
    .shop-qty-box{
        display:flex;
        align-items:center;
        gap:0;
        border:2px solid #e5e7eb;
        border-radius:14px;
        overflow:hidden;
        background:#fff;
        height:46px;
    }

    .shop-qty-btn{
        width:38px;
        height:46px;
        border:none;
        background:#f3f4f6;
        color:#374151;
        font-size:1.1rem;
        font-weight:700;
        cursor:pointer;
        transition:all .2s;
        display:flex;
        align-items:center;
        justify-content:center;
    }

    .shop-qty-btn:hover{
        background:#8b5cf6;
        color:#fff;
    }

    .shop-qty-input{
        width:44px;
        height:46px;
        border:none;
        border-left:1px solid #e5e7eb;
        border-right:1px solid #e5e7eb;
        text-align:center;
        font-size:.95rem;
        font-weight:700;
        outline:none;
        background:#fff;
    }

    .shop-add-cart-btn{
        height:46px;
        width:46px;
        border:none;
        border-radius:14px;
        background:#8b5cf6;
        color:white;
        display:flex;
        align-items:center;
        justify-content:center;
        cursor:pointer;
        transition:all .25s;
        flex-shrink:0;
        font-size:1.1rem;
    }

    .shop-add-cart-btn:hover{
        background:#7c3aed;
        transform:translateY(-2px);
        box-shadow:0 6px 16px rgba(139,92,246,.3);
    }

    .shop-add-cart-btn:disabled{
        opacity:.6;
        transform:none;
        box-shadow:none;
    }

    .shop-toast{
        position:fixed;
        top:90px;
        right:24px;
        z-index:99999;
        padding:14px 24px;
        border-radius:14px;
        font-weight:600;
        color:#fff;
        box-shadow:0 10px 30px rgba(0,0,0,.15);
        transform:translateX(120%);
        transition:transform .4s cubic-bezier(.68,-.55,.27,1.55);
    }

    .shop-toast.show{
        transform:translateX(0);
    }

    .shop-toast.success{ background:#10b981; }
    .shop-toast.error{ background:#ef4444; }

    /* =============================
       RESPONSIVE
       ============================= */
    @media (max-width: 768px) {
        .shop-hero {
            padding: 35px !important;
        }

        .product-action {
            flex-direction: column;
        }

        .shop-qty-box{
            width:100%;
        }

        .shop-add-cart-btn{
            width:100%;
        }
    }

    .shop-page{
        overflow-x:hidden;
    }

    .shop-page .row{
        max-width:100%;
    }

    /* Book icon decoration */
    .book-icon-decoration {
        font-size: 2rem;
    }

</style>

<!-- TOAST -->
<div class="shop-toast" id="shopToast"></div>

<!-- HERO - TEMA BUKU -->
<section class="mb-5">

    <div class="shop-hero p-5">

        <div class="row align-items-center">

            <div class="col-lg-7">

                <span class="badge px-4 py-2 rounded-pill mb-3" style="background: #8b5cf6; color: white;">
                    📚 TOKO BUKU ONLINE TERPERCAYA
                </span>

                <h1 class="fw-bold display-5 mb-3 hero-title">
                    Temukan Buku <br>Impian Anda
                </h1>

                <p class="fs-5 mb-4 hero-subtitle">
                    Koleksi lengkap buku berkualitas dari berbagai genre dan penerbit ternama.
                    Dari fiksi hingga pengembangan diri, semuanya tersedia untuk Anda.
                </p>

                <div class="d-flex gap-3 flex-wrap">

                    <a href="#products"
                       class="btn btn-primary btn-lg rounded-pill px-4" style="background: #8b5cf6; border: none;">

                        <i class="bi bi-book-fill me-2"></i>
                        Mulai Membaca

                    </a>

                    <a href="{{ route('home') }}"
                       class="btn btn-outline-dark btn-lg rounded-pill px-4">

                        <i class="bi bi-house-door-fill me-2"></i>
                        Kembali Home

                    </a>

                </div>

            </div>

            <div class="col-lg-5 text-center mt-4 mt-lg-0">

                <img src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?q=80&w=1200"
                     class="hero-image"
                     alt="Koleksi Buku">

            </div>

        </div>

    </div>

</section>

<!-- FILTER - TETAP SAMA STRUKTURNYA -->
<section class="mb-5">

    <div class="card filter-card">

        <div class="card-body p-4 p-lg-5">

            <div class="mb-4">

                <h3 class="fw-bold mb-1">
                    Cari Buku
                </h3>

                <p class="text-muted mb-0">
                    Temukan buku sesuai genre atau judul favorit Anda
                </p>

            </div>

            <form method="GET"
                  action="{{ route('customer.shop.index') }}">

                <div class="row g-3 align-items-end">

                    <div class="col-lg-5">

                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               class="form-control search-input"
                               placeholder="Cari judul buku atau penulis...">

                    </div>

                    <div class="col-lg-4">

                        <select name="category"
                                class="form-select">

                            <option value="">
                                Semua Genre
                            </option>

                            @foreach($categories as $category)

                                <option value="{{ $category->id }}"
                                    {{ request('category') == $category->id ? 'selected' : '' }}>

                                    {{ $category->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-lg-3">

                        <button class="btn btn-primary btn-modern w-100">

                            <i class="bi bi-search me-2"></i>
                            Cari Buku

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

</section>

<!-- PRODUCTS - TAMPILAN BUKU -->
<section id="products">

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">

        <div>

            <h2 class="fw-bold mb-1">
                📖 Koleksi Buku
            </h2>

            <p class="text-muted mb-0">
                Menampilkan {{ $products->count() }} buku tersedia
            </p>

        </div>

    </div>

    @if($products->count() > 0)

        <div class="row gx-4 gy-4">

            @foreach($products as $product)

                <div class="col-md-6 col-lg-4">
                    <div class="product-card">

                        <!-- IMAGE -->
                        <div class="product-image-wrapper">

                            <span class="category-badge">
                                📚 {{ $product->category->name }}
                            </span>

                            @if($product->image)

                                <img src="{{ asset('storage/' . $product->image) }}"
                                     class="img-fluid product-image"
                                     alt="{{ $product->name }}">

                            @else

                                <img src="https://via.placeholder.com/400x500?text=Cover+Buku"
                                     class="img-fluid product-image"
                                     alt="Cover Buku">

                            @endif

                        </div>

                        <!-- BODY -->
                        <div class="p-4">

                            <h5 class="fw-bold mb-1">
                                {{ $product->name }}
                            </h5>

                            @if(isset($product->author))
                                <p class="book-author mb-2">
                                    <i class="bi bi-pencil-fill me-1"></i>
                                    {{ $product->author }}
                                </p>
                            @endif

                            @if(isset($product->publisher))
                                <p class="text-muted small mb-3">
                                    <i class="bi bi-building me-1"></i>
                                    {{ $product->publisher }}
                                    @if(isset($product->year))
                                        · {{ $product->year }}
                                    @endif
                                </p>
                            @endif

                            <p class="text-muted small mb-3" style="min-height: 40px;">
                                {{ \Illuminate\Support\Str::limit($product->description ?? 'Buku berkualitas untuk menambah wawasan Anda.', 80) }}
                            </p>

                            <div class="mb-4">

                                <span class="price-text">
                                    {{ $product->formatted_price }}
                                </span>

                            </div>

                            <!-- STOCK -->
                            <div class="stock-box d-flex justify-content-between align-items-center mb-4">

                                <div>

                                    <small class="text-muted d-block">
                                        Stok Tersedia
                                    </small>

                                    <strong>
                                        {{ $product->stock }}
                                    </strong>

                                </div>

                                @if($product->stock > 0)

                                    <span class="badge rounded-pill px-3 py-2" style="background: #8b5cf6; color: white;">
                                        Tersedia
                                    </span>

                                @else

                                    <span class="badge bg-danger rounded-pill px-3 py-2">
                                        Habis
                                    </span>

                                @endif

                            </div>

                            <!-- BUTTON -->
                            <div class="mt-3">

                                <div class="product-action">

                                    <!-- DETAIL -->
                                    <a href="{{ route('customer.shop.show', $product) }}"
                                       class="detail-btn">

                                        <i class="bi bi-eye-fill me-2"></i>
                                        Detail

                                    </a>

                                    <!-- CART WITH QTY -->
                                    @if($product->stock > 0)

                                        <form action="{{ route('customer.cart.store') }}"
                                              method="POST"
                                              class="shop-add-cart-form"
                                              data-product-id="{{ $product->id }}"
                                              data-product-price="{{ $product->price }}"
                                              data-max-stock="{{ $product->stock }}">

                                            @csrf

                                            <input type="hidden"
                                                   name="product_id"
                                                   value="{{ $product->id }}">

                                            <div class="d-flex gap-2 align-items-center">

                                                <div class="shop-qty-box">

                                                    <button type="button"
                                                            class="shop-qty-btn shop-qty-minus">
                                                        <i class="bi bi-dash"></i>
                                                    </button>

                                                    <input type="number"
                                                           name="qty"
                                                           value="1"
                                                           min="1"
                                                           max="{{ $product->stock }}"
                                                           class="shop-qty-input"
                                                           readonly>

                                                    <button type="button"
                                                            class="shop-qty-btn shop-qty-plus">
                                                        <i class="bi bi-plus"></i>
                                                    </button>

                                                </div>

                                                <button type="submit"
                                                        class="shop-add-cart-btn">

                                                    <i class="bi bi-cart-plus-fill"></i>

                                                </button>

                                            </div>

                                        </form>

                                    @else

                                        <button class="shop-add-cart-btn bg-secondary"
                                                disabled
                                                style="flex:0 0 auto;width:46px;">

                                            <i class="bi bi-cart-x-fill"></i>

                                        </button>

                                    @endif

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

        <!-- PAGINATION -->
        @if($products->hasPages())

            <div class="pagination-wrapper">

                {{ $products->onEachSide(1)->links('pagination::bootstrap-5') }}

            </div>

        @endif

    @else

        <!-- EMPTY -->
        <div class="empty-state">

            <div class="empty-icon mb-4">

                <i class="bi bi-book"></i>

            </div>

            <h3 class="fw-bold mb-3">
                Buku Tidak Ditemukan
            </h3>

            <p class="text-muted mb-4">
                Coba gunakan kata kunci lain atau pilih genre berbeda.
            </p>

            <a href="{{ route('customer.shop.index') }}"
               class="btn btn-primary btn-modern px-4">

                Reset Filter

            </a>

        </div>

    @endif

</section>
</div>

@endsection

@section('scripts')
<script>
(function(){
    const toast = document.getElementById('shopToast');
    if(!toast) return;

    function showToast(msg, type){
        toast.textContent = msg;
        toast.className = 'shop-toast ' + type + ' show';
        setTimeout(() => toast.classList.remove('show'), 3000);
    }

    document.querySelectorAll('.shop-qty-minus').forEach(btn => {
        btn.addEventListener('click', function(){
            const form = this.closest('form');
            const input = form.querySelector('.shop-qty-input');
            let val = parseInt(input.value) || 1;
            if(val > 1){
                input.value = val - 1;
            }
        });
    });

    document.querySelectorAll('.shop-qty-plus').forEach(btn => {
        btn.addEventListener('click', function(){
            const form = this.closest('form');
            const input = form.querySelector('.shop-qty-input');
            const max = parseInt(input.getAttribute('max')) || 100;
            let val = parseInt(input.value) || 1;
            if(val < max){
                input.value = val + 1;
            }
        });
    });

    document.querySelectorAll('.shop-add-cart-form').forEach(form => {
        form.addEventListener('submit', function(e){
            e.preventDefault();
            const btn = this.querySelector('.shop-add-cart-btn');
            const input = this.querySelector('.shop-qty-input');
            const qty = parseInt(input.value) || 1;
            const productId = this.querySelector('input[name="product_id"]').value;
            const token = document.querySelector('input[name="_token"]').value;

            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';

            fetch('{{ route("customer.cart.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': token,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: 'product_id=' + productId + '&qty=' + qty
            })
            .then(res => res.json())
            .then(data => {
                if(data.success){
                    showToast('Ditambahkan ke keranjang!', 'success');
                } else {
                    showToast(data.message || 'Gagal menambahkan', 'error');
                }
            })
            .catch(() => {
                showToast('Terjadi kesalahan', 'error');
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = '<i class="bi bi-cart-plus-fill"></i>';
            });
        });
    });
})();
</script>
@endsection
