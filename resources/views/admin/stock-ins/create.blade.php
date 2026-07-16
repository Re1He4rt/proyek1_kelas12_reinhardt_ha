@extends('layouts.admin')

@section('title', 'Tambah Buku Masuk - MediaBook')

@section('content')

<style>

    body{
        background:#f8fafc;
    }

    .page-header{
        background: linear-gradient(135deg, #8b5cf6, #6d28d9);
        border-radius:28px;
        padding:35px;
        color:white;
        margin-bottom:30px;
        position:relative;
        overflow:hidden;
    }

    .page-header::before{
        content:'📚';
        position:absolute;
        font-size:10rem;
        opacity:0.08;
        top:-40px;
        right:20px;
        transform:rotate(15deg);
    }

    .page-header::after{
        content:'';
        position:absolute;
        width:250px;
        height:250px;
        border-radius:50%;
        background:rgba(255,255,255,.05);
        top:-120px;
        right:-80px;
    }

    .page-header h1{
        font-weight:800;
        font-family: 'Playfair Display', serif;
    }

    .page-header p{
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        font-size: 1.1rem;
        opacity: 0.85;
    }

    .modern-card{
        border:none;
        border-radius:28px;
        overflow:hidden;
        box-shadow:0 10px 35px rgba(15,23,42,.06);
        border: 1px solid #f1f5f9;
        transition: all 0.3s ease;
    }

    .modern-card:hover{
        box-shadow:0 15px 40px rgba(139,92,246,.08);
    }

    .card-header-modern{
        background: linear-gradient(135deg, #faf5ff, #f3e8ff);
        border-bottom:1px solid #ede9fe;
        padding:24px 30px;
    }

    .card-header-modern h4{
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        color: #5b21b6;
    }

    .card-body-modern{
        padding:35px;
    }

    .form-label{
        font-weight:700;
        color:#0f172a;
        margin-bottom:10px;
        font-size:0.9rem;
    }

    .form-control,
    .form-select{
        min-height:56px;
        border-radius:18px;
        border:1px solid #e2e8f0;
        padding-left:50px;
        font-weight:500;
        box-shadow:none !important;
        transition: all 0.3s ease;
        background: #fafafa;
    }

    .form-control:hover,
    .form-select:hover{
        border-color: #8b5cf6;
        background: white;
    }

    .form-control:focus,
    .form-select:focus{
        border-color:#8b5cf6;
        box-shadow: 0 0 0 3px rgba(139,92,246,.1) !important;
        background: white;
    }

    textarea.form-control{
        min-height:120px;
        padding-top:15px;
        padding-left:18px;
        resize: vertical;
    }

    .btn-modern{
        min-height:56px;
        border-radius:18px;
        font-weight:700;
        padding:0 32px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .btn-primary-modern{
        background: linear-gradient(135deg, #8b5cf6, #6d28d9);
        border:none;
        color:white;
        box-shadow: 0 4px 15px rgba(139,92,246,.25);
    }

    .btn-primary-modern:hover{
        background: linear-gradient(135deg, #6d28d9, #5b21b6);
        color:white;
        transform:translateY(-2px);
        box-shadow: 0 10px 30px rgba(139,92,246,.35);
    }

    .btn-secondary-modern{
        background:#f1f5f9;
        border:1px solid #e2e8f0;
        color:#0f172a;
    }

    .btn-secondary-modern:hover{
        background:#e2e8f0;
        transform:translateY(-2px);
    }

    .input-icon{
        position:relative;
    }

    .input-icon i{
        position:absolute;
        top:50%;
        left:18px;
        transform:translateY(-50%);
        color:#8b5cf6;
        z-index:10;
        font-size:1.1rem;
    }

    .input-icon .form-control,
    .input-icon .form-select{
        padding-left:50px;
    }

    .alert-danger-custom{
        border:none;
        border-radius:18px;
        padding:18px 22px;
        background: linear-gradient(135deg, #fef2f2, #fee2e2);
        color: #991b1b;
        border-left: 4px solid #ef4444;
        margin-bottom: 1.5rem;
    }

    .alert-danger-custom ul{
        margin-bottom: 0;
        padding-left: 20px;
    }

    .alert-danger-custom strong{
        display: block;
        margin-bottom: 4px;
    }

    /* Decorative helper text */
    .helper-text{
        font-family: 'Cormorant Garamond', serif;
        font-style: italic;
        font-size: 0.85rem;
        color: #94a3b8;
        margin-top: 6px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-header{
            padding:25px;
        }

        .page-header h1{
            font-size:1.5rem;
        }

        .card-body-modern{
            padding:20px;
        }

        .card-header-modern{
            padding:18px 20px;
        }

        .btn-modern{
            width:100%;
            justify-content:center;
        }

        .form-control,
        .form-select{
            min-height:48px;
            font-size:0.9rem;
        }
    }

</style>

<div class="container-fluid">

    <!-- HEADER - MEDIABOOK THEME -->
    <div class="page-header">

        <div class="position-relative" style="z-index:2;">

            <span class="badge px-3 py-2 rounded-pill mb-3" style="background: rgba(255,255,255,0.15); color: white; backdrop-filter: blur(10px);">
                📚 INVENTORY MANAGEMENT
            </span>

            <h1 class="mb-2" style="font-size: 2rem;">
                <i class="bi bi-arrow-down-circle-fill me-2"></i>
                Tambah Buku Masuk
            </h1>

            <p class="mb-0" style="opacity: 0.85;">
                Tambahkan stok buku baru ke dalam gudang MediaBook
            </p>

        </div>

    </div>

    <!-- ERROR - MEDIABOOK THEME -->
    @if($errors->any())

        <div class="alert-danger-custom">

            <strong>
                <i class="bi bi-exclamation-circle-fill me-2"></i>
                Terjadi Kesalahan:
            </strong>

            <ul>

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <!-- FORM - MEDIABOOK THEME -->
    <div class="card modern-card">

        <div class="card-header-modern">

            <h4 class="mb-0 fw-bold">
                <i class="bi bi-pencil-square me-2"></i>
                Form Buku Masuk
            </h4>

        </div>

        <div class="card-body-modern">

            <form action="{{ route('admin.stock-ins.store') }}"
                  method="POST">

                @csrf

                <div class="row">

                    <!-- PRODUCT -->
                    <div class="col-lg-6 mb-4">

                        <label class="form-label">
                            <i class="bi bi-book me-1"></i>
                            Buku
                        </label>

                        <div class="input-icon">

                            <i class="bi bi-book"></i>

                            <select name="product_id"
                                    class="form-select"
                                    required>

                                <option value="">
                                    Pilih Buku
                                </option>

                                @foreach($products as $product)

                                    <option value="{{ $product->id }}"
                                        {{ old('product_id') == $product->id ? 'selected' : '' }}>

                                        {{ $product->name }}
                                        @if(isset($product->author))
                                            - {{ $product->author }}
                                        @endif

                                    </option>

                                @endforeach

                            </select>

                        </div>

                        <div class="helper-text">
                            <i class="bi bi-info-circle me-1"></i>
                            Pilih judul buku yang akan ditambahkan stoknya
                        </div>

                    </div>

                    <!-- SUPPLIER / PENERBIT -->
                    <div class="col-lg-6 mb-4">

                        <label class="form-label">
                            <i class="bi bi-building me-1"></i>
                            Penerbit / Supplier
                        </label>

                        <div class="input-icon">

                            <i class="bi bi-building"></i>

                            <select name="supplier_id"
                                    class="form-select">

                                <option value="">
                                    Pilih Penerbit
                                </option>

                                @foreach($suppliers as $supplier)

                                    <option value="{{ $supplier->id }}"
                                        {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>

                                        {{ $supplier->name }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                        <div class="helper-text">
                            <i class="bi bi-info-circle me-1"></i>
                            Pilih penerbit atau supplier buku
                        </div>

                    </div>

                    <!-- QTY -->
                    <div class="col-lg-6 mb-4">

                        <label class="form-label">
                            <i class="bi bi-hash me-1"></i>
                            Jumlah Buku
                        </label>

                        <div class="input-icon">

                            <i class="bi bi-stack"></i>

                            <input type="number"
                                   name="qty"
                                   class="form-control"
                                   placeholder="Masukkan jumlah buku"
                                   value="{{ old('qty') }}"
                                   required
                                   min="1">

                        </div>

                        <div class="helper-text">
                            <i class="bi bi-info-circle me-1"></i>
                            Jumlah eksemplar buku yang masuk
                        </div>

                    </div>

                    <!-- DATE -->
                    <div class="col-lg-6 mb-4">

                        <label class="form-label">
                            <i class="bi bi-calendar3 me-1"></i>
                            Tanggal Masuk
                        </label>

                        <div class="input-icon">

                            <i class="bi bi-calendar-event"></i>

                            <input type="date"
                                   name="tanggal_masuk"
                                   class="form-control"
                                   value="{{ old('tanggal_masuk', date('Y-m-d')) }}"
                                   required>

                        </div>

                        <div class="helper-text">
                            <i class="bi bi-info-circle me-1"></i>
                            Tanggal buku masuk ke gudang
                        </div>

                    </div>

                    <!-- NOTES -->
                    <div class="col-12 mb-4">

                        <label class="form-label">
                            <i class="bi bi-chat-text me-1"></i>
                            Catatan / Keterangan
                        </label>

                        <textarea name="keterangan"
                                  class="form-control"
                                  placeholder="Tambahkan catatan jika diperlukan (contoh: dari penerbit Gramedia, batch ke-2)">{{ old('keterangan') }}</textarea>

                        <div class="helper-text">
                            <i class="bi bi-info-circle me-1"></i>
                            Catatan opsional untuk informasi tambahan
                        </div>

                    </div>

                </div>

                <!-- BUTTON -->
                <div class="d-flex gap-3 flex-wrap mt-2">

                    <button type="submit"
                            class="btn btn-modern btn-primary-modern">

                        <i class="bi bi-check-circle-fill"></i>
                        Simpan Buku Masuk

                    </button>

                    <a href="{{ route('admin.stock-ins.index') }}"
                       class="btn btn-modern btn-secondary-modern">

                        <i class="bi bi-arrow-left"></i>
                        Kembali

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

<!-- Tambahkan Font Google -->
<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,800;0,900;1,400;1,700&family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&display=swap');

    /* Required field asterisk */
    .form-label.required::after {
        content: ' *';
        color: #ef4444;
        font-weight: 700;
    }
</style>

@endsection
