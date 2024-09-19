<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{ $title }}
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BREADCRUMB -->
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
            </ol>
        </nav>
    </div>
    <!-- /BREADCRUMB -->

    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
            <div class="widget-content widget-content-area br-8">
                <div class="m-3">
                    @if (session('status'))
                        <div class="alert alert-{{ session('status.type') }} alert-dismissible fade show"
                            role="alert">
                            {!! session('status.message') !!}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="#" class="row g-3 needs-validation" novalidate
                    enctype="multipart/form-data">
                    @csrf

                    <div class="col-md-6">
                        <label for="vendor">Vendor
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="vendor" name="vendor"
                            value="{{ $product->vendor->name }}" disabled>
                    </div>

                    <div class="col-md-6">
                        <label for="name">Nama Produk
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ $product->name }}" disabled>
                    </div>

                    <div class="col-md-6">
                        <label for="price">Harga
                            <span class="text-danger">*</span>
                        </label>
                        <input type="number" class="form-control" id="price" name="price"
                            value="{{ $product->price }}" disabled>
                    </div>

                    <div class="col-md-6">
                        <label for="stock">Stok
                            <span class="text-danger">*</span>
                        </label>
                        <input type="number" class="form-control" id="stock" name="stock"
                            value="{{ $product->stock }}" disabled>
                    </div>

                    <div class="col-md-6">
                        <label for="unit_stock">Unit Produk
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="unit_stock" name="unit_stock"
                            value="{{ $product->unit_stock }}" disabled>
                    </div>

                    <div class="col-md-6">
                        <label for="category">Kategori
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="category" name="category"
                            value="{{ $product->category }}" disabled>
                    </div>

                    <div class="col-md-6">
                        <label for="description">Deskripsi
                            <span class="text-danger">*</span>
                        </label>
                        <textarea name="description" class="form-control" id="description" rows="3" disabled>{{ $product->description }}</textarea>
                    </div>

                    <div class="col-12 d-flex justify-content-end">
                        <a href="{{ route('product-catalog.index') }}" class="btn btn-outline-danger mx-1">
                            Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{ asset('plugins/global/vendors.min.js') }}"></script>

    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
