@extends('layouts.customer')

@section('title', $product->name)

@section('content')

<style>

    body{
        background:#f8fafc;
    }

    .detail-card{
        border:none;
        border-radius:30px;
        overflow:hidden;
        box-shadow:0 15px 40px rgba(0,0,0,.06);
    }

    .product-image{
        width:100%;
        height:500px;
        object-fit:contain;
        background:#f8fafc;
        padding:30px;
    }

    .price{
        font-size:2rem;
        font-weight:800;
        color:#8b5cf6;
    }

    .price-total{
        font-size:1.5rem;
        font-weight:800;
        color:#7c3aed;
        transition: all 0.3s ease;
    }

    .price-total.animating{
        transform: scale(1.05);
        color:#6d28d9;
    }

    .stock-badge{
        padding:10px 18px;
        border-radius:999px;
        font-weight:700;
        font-size:.9rem;
    }

    .qty-box{
        display:flex;
        align-items:center;
        gap:0;
        border:2px solid #e5e7eb;
        border-radius:16px;
        overflow:hidden;
        background:#fff;
    }

    .qty-btn{
        width:48px;
        height:55px;
        border:none;
        background:#f3f4f6;
        color:#374151;
        font-size:1.3rem;
        font-weight:700;
        cursor:pointer;
        transition:all .2s;
        display:flex;
        align-items:center;
        justify-content:center;
    }

    .qty-btn:hover{
        background:#8b5cf6;
        color:#fff;
    }

    .qty-input{
        width:60px;
        height:55px;
        border:none;
        border-left:1px solid #e5e7eb;
        border-right:1px solid #e5e7eb;
        text-align:center;
        font-size:1.1rem;
        font-weight:700;
        outline:none;
        background:#fff;
    }

    .btn-cart{
        height:55px;
        border-radius:16px;
        font-weight:700;
        background:#8b5cf6;
        border:none;
        color:#fff;
        transition:all .25s;
    }

    .btn-cart:hover{
        background:#7c3aed;
        transform:translateY(-2px);
        box-shadow:0 8px 20px rgba(139,92,246,.3);
        color:#fff;
    }

    .btn-cart:disabled{
        opacity:.6;
        transform:none;
        box-shadow:none;
    }

    .related-card{
        border:none;
        border-radius:24px;
        overflow:hidden;
        box-shadow:0 10px 25px rgba(0,0,0,.05);
        transition:.3s;
        height:100%;
    }

    .related-card:hover{
        transform:translateY(-5px);
    }

    .related-image{
        height:220px;
        object-fit:contain;
        background:#f8fafc;
        padding:20px;
    }

    .subtotal-label{
        background:linear-gradient(135deg, #f5f3ff, #ede9fe);
        border-radius:16px;
        padding:16px 20px;
        margin-top:16px;
        border:1px solid #ddd6fe;
    }

    .toast-msg{
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

    .toast-msg.show{
        transform:translateX(0);
    }

    .toast-msg.success{ background:#10b981; }
    .toast-msg.error{ background:#ef4444; }

</style>

<!-- TOAST -->
<div class="toast-msg" id="toastMsg"></div>

<div class="container py-4">

    <!-- DETAIL -->
    <div class="card detail-card mb-5">

        <div class="row g-0">

            <!-- IMAGE -->
            <div class="col-lg-6">

                @if($product->image)

                    <img src="{{ asset('storage/' . $product->image) }}"
                         class="product-image"
                         alt="{{ $product->name }}">

                @else

                    <img src="https://via.placeholder.com/600x600?text=No+Image"
                         class="product-image"
                         alt="No Image">

                @endif

            </div>

            <!-- CONTENT -->
            <div class="col-lg-6">

                <div class="p-4 p-lg-5">

                    <!-- CATEGORY -->
                    <span class="badge rounded-pill px-3 py-2 mb-3" style="background:#8b5cf6;color:#fff;">
                        {{ $product->category->name }}
                    </span>

                    <!-- NAME -->
                    <h1 class="fw-bold mb-3">
                        {{ $product->name }}
                    </h1>

                    <!-- PRICE -->
                    <div class="price mb-2" id="basePrice">
                        {{ $product->formatted_price }}
                    </div>

                    <!-- SUBTOTAL -->
                    <div class="subtotal-label" id="subtotalBox">
                        <small class="text-muted">Total Harga</small>
                        <div class="price-total" id="totalPrice">
                            {{ $product->formatted_price }}
                        </div>
                    </div>

                    <!-- STOCK -->
                    <div class="my-4">

                        @if($product->stock > 0)

                            <span class="badge bg-success stock-badge">
                                <i class="bi bi-check-circle me-1"></i>
                                Stock tersedia : {{ $product->stock }}
                            </span>

                        @else

                            <span class="badge bg-danger stock-badge">
                                Stock habis
                            </span>

                        @endif

                    </div>

                    <!-- DESCRIPTION -->
                    <div class="mb-5">

                        <h5 class="fw-bold mb-3">
                            Deskripsi Produk
                        </h5>

                        <p class="text-muted lh-lg">
                            {{ $product->description }}
                        </p>

                    </div>

                    <!-- ACTION -->
                    @if($product->stock > 0)

                        <form action="{{ route('customer.cart.store') }}"
                              method="POST"
                              id="addToCartForm">

                            @csrf

                            <input type="hidden"
                                   name="product_id"
                                   value="{{ $product->id }}">

                            <div class="d-flex gap-3 align-items-center flex-wrap">

                                <!-- QTY -->
                                <div class="qty-box">

                                    <button type="button" class="qty-btn" id="qtyMinus">
                                        <i class="bi bi-dash"></i>
                                    </button>

                                    <input type="number"
                                           name="qty"
                                           id="qtyInput"
                                           value="1"
                                           min="1"
                                           max="{{ $product->stock }}"
                                           class="qty-input"
                                           readonly>

                                    <button type="button" class="qty-btn" id="qtyPlus">
                                        <i class="bi bi-plus"></i>
                                    </button>

                                </div>

                                <!-- BUTTON -->
                                <button type="submit"
                                        class="btn btn-cart px-4 flex-grow-1"
                                        id="addToCartBtn">

                                    <i class="bi bi-cart-plus-fill me-2"></i>
                                    Tambah ke Keranjang

                                </button>

                            </div>

                        </form>

                    @endif

                    <!-- BACK -->
                    <div class="mt-4">

                        <a href="{{ route('customer.shop.index') }}"
                           class="btn btn-outline-dark rounded-pill px-4">

                            <i class="bi bi-arrow-left me-2"></i>
                            Kembali Belanja

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- RELATED PRODUCTS -->
    @if($relatedProducts->count() > 0)

        <div class="mb-4">

            <h2 class="fw-bold">
                Produk Terkait
            </h2>

            <p class="text-muted">
                Produk lain yang mungkin Anda suka
            </p>

        </div>

        <div class="row">

            @foreach($relatedProducts as $item)

                <div class="col-md-6 col-lg-3 mb-4">

                    <div class="card related-card">

                        @if($item->image)

                            <img src="{{ asset('storage/' . $item->image) }}"
                                 class="related-image"
                                 alt="{{ $item->name }}">

                        @else

                            <img src="https://via.placeholder.com/400x300?text=No+Image"
                                 class="related-image"
                                 alt="No Image">

                        @endif

                        <div class="card-body">

                            <h6 class="fw-bold mb-2">
                                {{ $item->name }}
                            </h6>

                            <div class="fw-bold mb-3" style="color:#8b5cf6;">
                                {{ $item->formatted_price }}
                            </div>

                            <a href="{{ route('customer.shop.show', $item) }}"
                               class="btn w-100 rounded-pill" style="background:#0f172a;color:#fff;">

                                View Detail

                            </a>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    @endif

</div>

@endsection

@section('scripts')
<script>
(function(){
    const basePrice = {{ $product->price }};
    const maxStock = {{ $product->stock }};
    const productId = {{ $product->id }};

    const qtyInput = document.getElementById('qtyInput');
    const qtyMinus = document.getElementById('qtyMinus');
    const qtyPlus = document.getElementById('qtyPlus');
    const totalPrice = document.getElementById('totalPrice');
    const addToCartForm = document.getElementById('addToCartForm');
    const addToCartBtn = document.getElementById('addToCartBtn');
    const toast = document.getElementById('toastMsg');

    function formatRupiah(num){
        return 'Rp ' + num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function updatePrice(){
        const qty = parseInt(qtyInput.value) || 1;
        const total = basePrice * qty;
        totalPrice.textContent = formatRupiah(total);
        totalPrice.classList.add('animating');
        setTimeout(() => totalPrice.classList.remove('animating'), 300);
    }

    function showToast(msg, type){
        toast.textContent = msg;
        toast.className = 'toast-msg ' + type + ' show';
        setTimeout(() => toast.classList.remove('show'), 3000);
    }

    qtyMinus.addEventListener('click', function(){
        let val = parseInt(qtyInput.value) || 1;
        if(val > 1){
            qtyInput.value = val - 1;
            updatePrice();
        }
    });

    qtyPlus.addEventListener('click', function(){
        let val = parseInt(qtyInput.value) || 1;
        if(val < maxStock){
            qtyInput.value = val + 1;
            updatePrice();
        }
    });

    qtyInput.addEventListener('input', function(){
        let val = parseInt(this.value);
        if(isNaN(val) || val < 1) val = 1;
        if(val > maxStock) val = maxStock;
        this.value = val;
        updatePrice();
    });

    addToCartForm.addEventListener('submit', function(e){
        e.preventDefault();
        const qty = parseInt(qtyInput.value) || 1;
        const token = document.querySelector('meta[name="csrf-token"]')?.content
                   || document.querySelector('input[name="_token"]').value;

        addToCartBtn.disabled = true;
        addToCartBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menambahkan...';

        fetch('{{ route("customer.cart.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': token,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: 'product_id=' + productId + '&qty=' + qty
        })
        .then(res => {
            if(res.redirected){
                showToast('Produk ditambahkan ke keranjang!', 'success');
                setTimeout(() => window.location.reload(), 1500);
                return;
            }
            return res.text();
        })
        .then(() => {})
        .catch(err => {
            showToast('Gagal menambahkan ke keranjang', 'error');
        })
        .finally(() => {
            addToCartBtn.disabled = false;
            addToCartBtn.innerHTML = '<i class="bi bi-cart-plus-fill me-2"></i>Tambah ke Keranjang';
        });
    });

})();
</script>
@endsection
