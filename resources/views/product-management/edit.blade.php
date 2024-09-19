<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{ $title }}
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        <link rel="stylesheet" href="{{ asset('plugins/slim-select/slimselect.css') }}">
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

                <form method="POST" action="{{ route('product-management.update', $product->id) }}"
                    class="row g-3 needs-validation" novalidate enctype="multipart/form-data">
                    @csrf

                    <div class="col-md-6">
                        <label for="name">Nama Produk
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ $product->name }}">
                    </div>

                    <div class="col-md-6">
                        <label for="price">Harga
                            <span class="text-danger">*</span>
                        </label>
                        <input type="number" class="form-control" id="price" name="price"
                            value="{{ $product->price }}">
                    </div>

                    <div class="col-md-6">
                        <label for="stock">Stok
                            <span class="text-danger">*</span>
                        </label>
                        <input type="number" class="form-control" max="10" id="stock" name="stock"
                            value="{{ $product->stock }}">
                    </div>

                    <div class="col-md-6">
                        <label for="unit_stock">Unit Produk
                            <span class="text-danger">*</span>
                        </label>
                        <select name="unit_stock" class="form-control" id="unit_stock"
                            style="font-size:15px; padding:.75rem 1.25rem; border: 1px solid #bfc9d4;">
                            <option disabled selected>Pilih unit produk</option>
                            @forelse ($unitProducts as $unitProduct)
                                <option value="{{ $unitProduct }}"
                                    {{ $unitProduct === $product->unit_stock ? 'selected' : '' }}>
                                    {{ $unitProduct }}
                                </option>
                            @empty
                                <option>Tidak Ada Data</option>
                            @endforelse
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="category">Kategori
                            <span class="text-danger">*</span>
                        </label>
                        <select name="category" class="form-control" id="category"
                            style="font-size:15px; padding:.75rem 1.25rem; border: 1px solid #bfc9d4;">
                            <option disabled selected>Pilih kategori</option>
                            @forelse ($categoryProducts as $categoryProduct)
                                <option value="{{ $categoryProduct }}"
                                    {{ $categoryProduct === $product->category ? 'selected' : '' }}>
                                    {{ $categoryProduct }}
                                </option>
                            @empty
                                <option>Tidak Ada Data</option>
                            @endforelse
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="description">Deskripsi
                            <span class="text-danger">*</span>
                        </label>
                        <textarea name="description" class="form-control" id="description" rows="3">{{ $product->description }}</textarea>
                    </div>


                    <div class="col-12 d-flex justify-content-end">
                        <a href="{{ route('product-management.index') }}" class="btn btn-outline-danger mx-1">
                            Batal
                        </a>
                        <button class="btn btn-primary mx-1" name="action" value="submit" type="submit">
                            Kirim
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{ asset('plugins/global/vendors.min.js') }}"></script>

        <script src="{{ asset('plugins/slim-select/slimselect.min.js') }}"></script>
        <script>
            var dataSelect = ['unit_stock', 'category'];

            dataSelect.forEach(function(data) {
                new SlimSelect({
                    select: '#' + data,
                    settings: {
                        searchText: 'Tidak ditemukan.',
                        searchPlaceholder: 'Cari data',
                        openPosition: 'down',
                    }
                });
            });
        </script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
