
@extends('layouts.customer')

@section('title', 'Keranjang Belanja')

@section('content')

<style>

    .cart-title{
        font-weight:800;
        color:#0f172a;
    }

    .cart-card{
        border:none;
        border-radius:28px;
        overflow:hidden;
        background:#fff;
        box-shadow:0 10px 30px rgba(15,23,42,.06);
    }

    .cart-header{
        padding:24px 28px;
        border-bottom:1px solid #eef2f7;
        background:#fff;
    }

    .cart-item{
        padding:24px 28px;
        border-bottom:1px solid #f1f5f9;
        transition: background .2s;
    }

    .cart-item:hover{
        background:#faf5ff;
    }

    .cart-item:last-child{
        border-bottom:none;
    }

    .product-image{
        width:90px;
        height:90px;
        border-radius:20px;
        object-fit:cover;
        background:#f8fafc;
        padding:8px;
    }

    .product-name{
        font-weight:700;
        color:#0f172a;
        margin-bottom:6px;
    }

    .product-stock{
        font-size:.9rem;
        color:#64748b;
    }

    .price{
        font-weight:700;
        color:#8b5cf6;
    }

    .item-subtotal{
        font-weight:800;
        color:#7c3aed;
    }

    .qty-box{
        display:flex;
        align-items:center;
        gap:0;
        border:2px solid #e5e7eb;
        border-radius:12px;
        overflow:hidden;
        background:#fff;
    }

    .qty-input{
        width:50px;
        border:none;
        border-left:1px solid #e5e7eb;
        border-right:1px solid #e5e7eb;
        text-align:center;
        min-height:42px;
        font-weight:700;
        outline:none;
    }

    .qty-btn{
        width:38px;
        height:42px;
        border:none;
        background:#f3f4f6;
        color:#374151;
        font-size:1rem;
        font-weight:700;
        cursor:pointer;
        transition:all .2s;
    }

    .qty-btn:hover{
        background:#8b5cf6;
        color:#fff;
    }

    .btn-update-qty{
        width:42px;
        height:42px;
        border:none;
        border-radius:12px;
        background:#8b5cf6;
        color:white;
        cursor:pointer;
        transition:all .2s;
    }

    .btn-update-qty:hover{
        background:#7c3aed;
        transform:scale(1.05);
    }

    .btn-delete{
        border:none;
        width:42px;
        height:42px;
        border-radius:12px;
        background:#ef4444;
        color:white;
    }

    .btn-delete:hover{
        background:#dc2626;
    }

    .summary-card{
        border:none;
        border-radius:28px;
        overflow:hidden;
        background:linear-gradient(135deg, #1e1b4b, #312e81);
        color:white;
        box-shadow:0 10px 30px rgba(99,102,241,.15);
        position:sticky;
        top:100px;
    }

    .summary-header{
        padding:24px 28px;
        border-bottom:1px solid rgba(255,255,255,.08);
    }

    .summary-body{
        padding:28px;
    }

    .summary-row{
        display:flex;
        justify-content:space-between;
        margin-bottom:18px;
        color:#c4b5fd;
    }

    .summary-total{
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-top:24px;
        padding-top:24px;
        border-top:1px solid rgba(255,255,255,.1);
    }

    .summary-total h4{
        margin:0;
        font-weight:800;
    }

    .checkout-btn{
        width:100%;
        border:none;
        border-radius:18px;
        background:#8b5cf6;
        color:white;
        padding:16px;
        font-weight:700;
        margin-top:24px;
        transition:.3s;
    }

    .checkout-btn:hover{
        background:#7c3aed;
        transform:translateY(-2px);
        box-shadow:0 8px 20px rgba(139,92,246,.3);
        color:#fff;
    }

    .secondary-btn{
        width:100%;
        border-radius:18px;
        padding:14px;
        font-weight:600;
    }

    .empty-cart{
        background:#fff;
        border-radius:32px;
        padding:90px 20px;
        text-align:center;
        box-shadow:0 10px 30px rgba(0,0,0,.05);
    }

    .empty-icon{
        width:130px;
        height:130px;
        margin:auto;
        border-radius:50%;
        background:#f5f3ff;
        color:#8b5cf6;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:55px;
    }

    @media(max-width:768px){

        .cart-item{
            padding:20px;
        }

        .product-image{
            width:75px;
            height:75px;
        }

    }

</style>

<!-- TOAST -->
<div class="toast-msg" id="toastMsg" style="position:fixed;top:90px;right:24px;z-index:99999;padding:14px 24px;border-radius:14px;font-weight:600;color:#fff;box-shadow:0 10px 30px rgba(0,0,0,.15);transform:translateX(120%);transition:transform .4s cubic-bezier(.68,-.55,.27,1.55);">
</div>

<div class="container py-4">

    <!-- TITLE -->
    <div class="mb-4">

        <h2 class="cart-title">
            <i class="bi bi-cart3 me-2"></i>
            Keranjang Belanja
        </h2>

        <p class="text-muted mb-0">
            Kelola produk yang ingin Anda beli
        </p>

    </div>

    @if($cart->cartItems->isEmpty())

        <!-- EMPTY -->
        <div class="empty-cart">

            <div class="empty-icon mb-4">
                <i class="bi bi-cart-x"></i>
            </div>

            <h3 class="fw-bold mb-3">
                Keranjang Masih Kosong
            </h3>

            <p class="text-muted mb-4">
                Yuk mulai belanja buku favorit Anda.
            </p>

            <a href="{{ route('customer.shop.index') }}"
               class="btn btn-lg rounded-pill px-5" style="background:#8b5cf6;color:#fff;">

                <i class="bi bi-grid me-2"></i>
                Mulai Belanja

            </a>

        </div>

    @else

        <div class="row g-4">

            <!-- LEFT -->
            <div class="col-lg-8">

                <div class="cart-card">

                    <div class="cart-header d-flex justify-content-between align-items-center">

                        <h5 class="fw-bold mb-0">
                            Produk Pilihan
                        </h5>

                        <span class="badge rounded-pill px-3 py-2" style="background:#8b5cf6;color:#fff;">
                            {{ $cart->total_items }} Item
                        </span>

                    </div>

                    @foreach($cart->cartItems as $item)

                        <div class="cart-item" id="cartItem{{ $item->id }}">

                            <div class="row align-items-center g-3">

                                <!-- IMAGE -->
                                <div class="col-md-2 col-3">

                                    @if($item->product->image)

                                        <img src="{{ asset('storage/' . $item->product->image) }}"
                                             class="product-image"
                                             alt="{{ $item->product->name }}">

                                    @else

                                        <img src="https://via.placeholder.com/300x300?text=No+Image"
                                             class="product-image">

                                    @endif

                                </div>

                                <!-- INFO -->
                                <div class="col-md-3 col-9">

                                    <div class="product-name">
                                        {{ $item->product->name }}
                                    </div>

                                    <div class="product-stock">
                                        Stock tersedia:
                                        {{ $item->product->stock }}
                                    </div>

                                </div>

                                <!-- PRICE -->
                                <div class="col-md-2">

                                    <div class="price">
                                        {{ $item->product->formatted_price }}
                                    </div>

                                </div>

                                <!-- QTY -->
                                <div class="col-md-3">

                                    <div class="d-flex align-items-center gap-2">

                                        <div class="qty-box">

                                            <button type="button"
                                                    class="qty-btn cart-qty-minus"
                                                    data-id="{{ $item->id }}"
                                                    data-max="{{ $item->product->stock }}">
                                                <i class="bi bi-dash"></i>
                                            </button>

                                            <input type="number"
                                                   value="{{ $item->qty }}"
                                                   min="1"
                                                   max="{{ $item->product->stock }}"
                                                   class="form-control qty-input cart-qty-input"
                                                   data-id="{{ $item->id }}"
                                                   data-price="{{ $item->product->price }}"
                                                   data-max="{{ $item->product->stock }}"
                                                   readonly>

                                            <button type="button"
                                                    class="qty-btn cart-qty-plus"
                                                    data-id="{{ $item->id }}"
                                                    data-max="{{ $item->product->stock }}">
                                                <i class="bi bi-plus"></i>
                                            </button>

                                        </div>

                                        <button type="button"
                                                class="btn-update-qty cart-update-btn"
                                                data-id="{{ $item->id }}"
                                                title="Update qty">

                                            <i class="bi bi-check-lg"></i>

                                        </button>

                                    </div>

                                </div>

                                <!-- DELETE -->
                                <div class="col-md-1 text-end">

                                    <button type="button"
                                            class="btn-delete cart-delete-btn"
                                            data-id="{{ $item->id }}"
                                            data-name="{{ $item->product->name }}">

                                        <i class="bi bi-trash"></i>

                                    </button>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>

            <!-- RIGHT -->
            <div class="col-lg-4">

                <div class="summary-card">

                    <div class="summary-header">

                        <h5 class="fw-bold mb-0">
                            Ringkasan Pesanan
                        </h5>

                    </div>

                    <div class="summary-body">

                        <div class="summary-row">

                            <span>Total Item</span>

                            <strong id="summaryTotalItems">{{ $cart->total_items }}</strong>

                        </div>

                        <div class="summary-row">

                            <span>Biaya Kirim</span>

                            <span>Checkout</span>

                        </div>

                        <div class="summary-total">

                            <h6>Total</h6>

                            <h4 id="summaryTotal">
                                Rp {{ number_format($cart->total, 0, ',', '.') }}
                            </h4>

                        </div>

                        <a href="{{ route('customer.checkout.index') }}"
                           class="btn checkout-btn">

                            <i class="bi bi-credit-card me-2"></i>
                            Checkout Sekarang

                        </a>

                        <a href="{{ route('customer.shop.index') }}"
                           class="btn btn-outline-light secondary-btn mt-3">

                            <i class="bi bi-arrow-left me-2"></i>
                            Lanjut Belanja

                        </a>

                        <button type="button"
                                class="btn btn-outline-danger secondary-btn mt-3"
                                id="clearCartBtn">

                            <i class="bi bi-trash me-2"></i>
                            Kosongkan Keranjang

                        </button>

                    </div>

                </div>

            </div>

        </div>

    @endif

</div>

@endsection

@section('scripts')
<script>
(function(){
    const csrfToken = document.querySelector('input[name="_token"]')
        ? document.querySelector('input[name="_token"]').value
        : '{{ csrf_token() }}';

    const toast = document.getElementById('toastMsg');

    function formatRupiah(num){
        return 'Rp ' + num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function showToast(msg, type){
        toast.textContent = msg;
        toast.style.transform = 'translateX(0)';
        toast.style.background = type === 'success' ? '#10b981' : '#ef4444';
        setTimeout(() => { toast.style.transform = 'translateX(120%)'; }, 3000);
    }

    function updateSummary(total, items){
        document.getElementById('summaryTotal').textContent = formatRupiah(total);
        document.getElementById('summaryTotalItems').textContent = items;
    }

    function updateItemSubtotal(id, qty, price){
        const itemEl = document.getElementById('cartItem' + id);
        if(itemEl){
            const priceEl = itemEl.querySelector('.price');
            const unitPrice = parseInt(priceEl.textContent.replace(/[^0-9]/g, ''));
        }
    }

    // +/- buttons
    document.querySelectorAll('.cart-qty-minus').forEach(btn => {
        btn.addEventListener('click', function(){
            const id = this.dataset.id;
            const input = document.querySelector('.cart-qty-input[data-id="' + id + '"]');
            let val = parseInt(input.value) || 1;
            if(val > 1){
                input.value = val - 1;
            }
        });
    });

    document.querySelectorAll('.cart-qty-plus').forEach(btn => {
        btn.addEventListener('click', function(){
            const id = this.dataset.id;
            const max = parseInt(this.dataset.max);
            const input = document.querySelector('.cart-qty-input[data-id="' + id + '"]');
            let val = parseInt(input.value) || 1;
            if(val < max){
                input.value = val + 1;
            }
        });
    });

    // Update qty via AJAX
    document.querySelectorAll('.cart-update-btn').forEach(btn => {
        btn.addEventListener('click', function(){
            const id = this.dataset.id;
            const input = document.querySelector('.cart-qty-input[data-id="' + id + '"]');
            const qty = parseInt(input.value) || 1;
            const btnEl = this;

            btnEl.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
            btnEl.disabled = true;

            fetch('/customer/cart/' + id, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: '_method=PUT&qty=' + qty
            })
            .then(res => res.json())
            .then(data => {
                if(data.success){
                    showToast('Qty berhasil diupdate!', 'success');
                    if(data.total !== undefined){
                        updateSummary(data.total, data.total_items);
                    }
                } else {
                    showToast(data.message || 'Gagal update', 'error');
                }
            })
            .catch(() => {
                showToast('Terjadi kesalahan', 'error');
            })
            .finally(() => {
                btnEl.innerHTML = '<i class="bi bi-check-lg"></i>';
                btnEl.disabled = false;
            });
        });
    });

    // Delete item
    document.querySelectorAll('.cart-delete-btn').forEach(btn => {
        btn.addEventListener('click', function(){
            if(!confirm('Hapus "' + this.dataset.name + '" dari keranjang?')) return;
            const id = this.dataset.id;
            const itemEl = document.getElementById('cartItem' + id);

            fetch('/customer/cart/' + id, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: '_method=DELETE'
            })
            .then(res => res.json())
            .then(data => {
                if(data.success){
                    itemEl.style.transition = 'all .3s';
                    itemEl.style.opacity = '0';
                    itemEl.style.transform = 'translateX(-30px)';
                    setTimeout(() => itemEl.remove(), 300);
                    showToast('Item dihapus!', 'success');
                    if(data.total !== undefined){
                        updateSummary(data.total, data.total_items);
                    }
                    if(data.empty){
                        setTimeout(() => location.reload(), 500);
                    }
                }
            })
            .catch(() => showToast('Gagal menghapus', 'error'));
        });
    });

    // Clear cart
    document.getElementById('clearCartBtn').addEventListener('click', function(){
        if(!confirm('Kosongkan seluruh keranjang?')) return;

        fetch('/customer/cart/clear', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: '_method=POST'
        })
        .then(res => res.json())
        .then(data => {
            if(data.success){
                showToast('Keranjang dikosongkan!', 'success');
                setTimeout(() => location.reload(), 500);
            }
        })
        .catch(() => showToast('Gagal mengosongkan', 'error'));
    });

})();
</script>
@endsection
