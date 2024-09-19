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

                <form method="POST" action="{{ route('vendor-registration.store') }}" class="row g-3 needs-validation"
                    novalidate enctype="multipart/form-data">
                    @csrf

                    <div class="col-md-6">
                        <label for="name">Nama Perusahaan
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>

                    <div class="col-md-6">
                        <label for="telephone">Telephone
                            <span class="text-danger">*</span>
                        </label>
                        <input type="number" class="form-control" max="15" id="telephone" name="telephone">
                    </div>

                    <div class="col-md-6">
                        <label for="business_field">Bidang Usaha
                            <span class="text-danger">*</span>
                        </label>
                        <select name="business_field" class="form-control" id="business_field"
                            style="font-size:15px; padding:.75rem 1.25rem; border: 1px solid #bfc9d4;">
                            <option disabled selected>Pilih bidang usaha</option>
                            @forelse ($businessFields as $businessField)
                                <option value="{{ $businessField }}"
                                    {{ $businessField === old('business_field') ? 'selected' : '' }}>
                                    {{ $businessField }}
                                </option>
                            @empty
                                <option>Tidak Ada Data</option>
                            @endforelse
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="npwp">NPWP
                            <span class="text-danger">*</span>
                        </label>
                        <input type="number" class="form-control" min="15" max="15" id="npwp"
                            name="npwp">
                    </div>

                    <div class="col-md-6">
                        <label for="address">Alamat Lengkap
                            <span class="text-danger">*</span>
                        </label>
                        <input type="address" class="form-control" id="address" name="address">
                    </div>

                    <div class="col-md-6">
                        <label for="website">Website
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="website" name="website">
                    </div>

                    <div class="col-md-6">
                        <label for="description">Deskripsi Perusahaan
                            <span class="text-danger">*</span>
                        </label>
                        <textarea name="description" class="form-control" id="description" rows="3">{{ old('description') }}</textarea>
                    </div>


                    <div class="col-12 d-flex justify-content-end">
                        <a href="{{ route('home') }}" class="btn btn-outline-danger mx-1">
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
            var dataSelect = ['business_field'];

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
