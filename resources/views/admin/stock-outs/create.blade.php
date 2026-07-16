@extends('layouts.admin')

@section('title', 'Tambah Stock Keluar')

@section('content')

<style>

    body{
        background:#f1f5f9;
    }

    .page-header{
        background:linear-gradient(135deg,#7f1d1d,#991b1b);
        border-radius:28px;
        padding:40px;
        color:white;
        margin-bottom:30px;
        position:relative;
        overflow:hidden;
    }

    .page-header::before{
        content:'';
        position:absolute;
        width:250px;
        height:250px;
        border-radius:50%;
        background:rgba(255,255,255,.05);
        top:-100px;
        right:-70px;
    }

    .page-header h1{
        font-weight:800;
    }

    .modern-card{
        border:none;
        border-radius:28px;
        overflow:hidden;
        box-shadow:0 10px 35px rgba(15,23,42,.08);
    }

    .card-header-modern{
        background:white;
        border-bottom:1px solid #e2e8f0;
        padding:24px 30px;
    }

    .card-body-modern{
        padding:35px;
    }

    .form-label{
        font-weight:700;
        color:#0f172a;
        margin-bottom:10px;
    }

    .form-control,
    .form-select{
        min-height:56px;
        border-radius:18px;
        border:1px solid #dbe4ee;
        padding-left:18px;
        font-weight:500;
        box-shadow:none !important;
    }

    .form-control:focus,
    .form-select:focus{
        border-color:#dc2626;
    }

    textarea.form-control{
        min-height:120px;
        padding-top:15px;
    }

    .btn-modern{
        min-height:56px;
        border-radius:18px;
        font-weight:700;
        padding:0 28px;
        transition:.25s ease;
    }

    .btn-danger-modern{
        background:#dc2626;
        border:none;
        color:white;
    }

    .btn-danger-modern:hover{
        background:#b91c1c;
        transform:translateY(-2px);
    }

    .btn-secondary-modern{
        background:#e2e8f0;
        border:none;
        color:#0f172a;
    }

    .btn-secondary-modern:hover{
        background:#cbd5e1;
    }

    .input-icon{
        position:relative;
    }

    .input-icon i{
        position:absolute;
        top:50%;
        left:18px;
        transform:translateY(-50%);
        color:#64748b;
        z-index:10;
    }

    .input-icon .form-control,
    .input-icon .form-select{
        padding-left:50px;
    }

    .alert{
        border:none;
        border-radius:18px;
        padding:18px 22px;
    }

    .warning-box{
        background:#fef2f2;
        border:1px solid #fecaca;
        color:#991b1b;
        padding:18px 20px;
        border-radius:18px;
        margin-bottom:25px;
    }

</style>

<div class="container-fluid">

    <!-- HEADER -->
    <div class="page-header">

        <div class="position-relative">

            <span class="badge bg-danger px-3 py-2 rounded-pill mb-3">
                INVENTORY MANAGEMENT
            </span>

            <h1 class="mb-2">
                Tambah Stock Keluar
            </h1>

            <p class="mb-0 text-light opacity-75">
                Kurangi stok produk dari inventory toko
            </p>

        </div>

    </div>

    <!-- ERROR -->
    @if($errors->any())

        <div class="alert alert-danger mb-4">

            <strong>
                Terjadi Kesalahan:
            </strong>

            <ul class="mb-0 mt-2">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <!-- WARNING -->
    <div class="warning-box">

        <i class="bi bi-exclamation-triangle-fill me-2"></i>

        Pastikan jumlah stock keluar tidak melebihi stock yang tersedia.

    </div>

    <!-- FORM -->
    <div class="card modern-card">

        <div class="card-header-modern">

            <h4 class="mb-0 fw-bold">
                Form Stock Keluar
            </h4>

        </div>

        <div class="card-body-modern">

            <form action="{{ route('admin.stock-outs.store') }}"
      method="POST">

    @csrf

    <div class="row">

        <!-- PRODUCT -->
        <div class="col-lg-6 mb-4">

            <label class="form-label">
                Produk
            </label>

            <div class="input-icon">

                <i class="bi bi-box-seam"></i>

                <select name="product_id"
                        class="form-select"
                        required>

                    <option value="">
                        Pilih Produk
                    </option>

                    @foreach($products as $product)

                        <option value="{{ $product->id }}">

                            {{ $product->name }}
                            (Stock: {{ $product->stock }})

                        </option>

                    @endforeach

                </select>

            </div>

        </div>

        <!-- QTY -->
        <div class="col-lg-6 mb-4">

            <label class="form-label">
                Jumlah Stock Keluar
            </label>

            <div class="input-icon">

                <i class="bi bi-arrow-up-right-circle"></i>

                <input type="number"
                       name="qty"
                       class="form-control"
                       placeholder="Masukkan jumlah stock keluar"
                       min="1"
                       required>

            </div>

        </div>

        <!-- ALASAN -->
        <div class="col-lg-6 mb-4">

            <label class="form-label">
                Alasan Stock Keluar
            </label>

            <div class="input-icon">

                <i class="bi bi-exclamation-circle"></i>

                <select name="alasan"
                        class="form-select"
                        required>

                    <option value="">
                        Pilih Alasan
                    </option>

                    <option value="rusak">
                        Barang Rusak
                    </option>

                    <option value="hilang">
                        Barang Hilang
                    </option>

                    <option value="kadaluarsa">
                        Kadaluarsa
                    </option>

                    <option value="lainnya">
                        Lainnya
                    </option>

                </select>

            </div>

        </div>

        <!-- DATE -->
        <div class="col-lg-6 mb-4">

            <label class="form-label">
                Tanggal Keluar
            </label>

            <div class="input-icon">

                <i class="bi bi-calendar-event"></i>

                <input type="date"
                       name="tanggal_keluar"
                       class="form-control"
                       value="{{ date('Y-m-d') }}"
                       required>

            </div>

        </div>

        <!-- NOTES -->
        <div class="col-12 mb-4">

            <label class="form-label">
                Keterangan
            </label>

            <textarea name="keterangan"
                      class="form-control"
                      placeholder="Tambahkan catatan stock keluar"></textarea>

        </div>

    </div>

    <!-- BUTTON -->
    <div class="d-flex gap-3 flex-wrap">

        <button type="submit"
                class="btn btn-modern btn-danger-modern">

            <i class="bi bi-check-circle-fill me-2"></i>
            Simpan Stock Keluar

        </button>

        <a href="{{ route('admin.stock-outs.index') }}"
           class="btn btn-modern btn-secondary-modern">

            <i class="bi bi-arrow-left me-2"></i>
            Kembali

        </a>

    </div>

</form>
        </div>

    </div>

</div>

@endsection