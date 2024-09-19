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
        @if ($vendor->status == 'review')
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="widget-content widget-content-area br-8">
                    <div class="m-3">
                        <div class="alert alert-info }} alert-dismissible fade show" role="alert">
                            Silahkan klik button Accepted jika data perusahaan sudah lengkap dan telah disetujui sesuai dengan kebijakan yang sudah ada.
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('vendor-review.update', $vendor->id) }}"
                        class="row g-3 needs-validation" novalidate enctype="multipart/form-data">
                        @csrf

                        <div class="col-12 d-flex justify-content-end">
                            <button class="btn btn-primary mx-1" name="action" value="submit" type="submit">
                                Accepted
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

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
                        <label for="name">Nama Perusahaan
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ $vendor->name }}" disabled>
                    </div>

                    <div class="col-md-6">
                        <label for="telephone">Telephone
                            <span class="text-danger">*</span>
                        </label>
                        <input type="number" class="form-control" id="telephone" name="telephone"
                            value="{{ $vendor->telephone }}" disabled>
                    </div>

                    <div class="col-md-6">
                        <label for="business_field">Bidang Usaha
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="business_field" name="business_field"
                            value="{{ $vendor->business_field }}" disabled>
                    </div>

                    <div class="col-md-6">
                        <label for="npwp">NPWP
                            <span class="text-danger">*</span>
                        </label>
                        <input type="number" class="form-control" id="npwp" name="npwp"
                            value="{{ $vendor->npwp }}" disabled>
                    </div>

                    <div class="col-md-6">
                        <label for="address">Alamat Lengkap
                            <span class="text-danger">*</span>
                        </label>
                        <input type="address" class="form-control" id="address" name="address"
                            value="{{ $vendor->address }}" disabled>
                    </div>

                    <div class="col-md-6">
                        <label for="website">Website
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="website" name="website"
                            value="{{ $vendor->website }}" disabled>
                    </div>

                    <div class="col-md-6">
                        <label for="description">Deskripsi Perusahaan
                            <span class="text-danger">*</span>
                        </label>
                        <textarea name="description" class="form-control" id="description" rows="3" disabled>{{ $vendor->description }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label for="status">Status
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="status" name="status"
                            value="{{ $vendor->status }}" disabled>
                    </div>

                    <div class="col-12 d-flex justify-content-end">
                        <a href="{{ route('vendor-review.index') }}" class="btn btn-outline-danger mx-1">
                            Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="row layout-top-spacing">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <h5>4 Komentar Terakhir</h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
            <div class="row mt-2 mx-2">
                @forelse ($vendorRegistrationReviews as $vendorRegistrationReview)
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 mb-6">
                        <div class="card style-2 mb-md-0 mb-5 mt-3">
                            <div class="card-body px-0 pb-0">
                                <div class="row">
                                    <div>
                                        <small>Komentar : {{ $vendorRegistrationReview['comment'] }}</small>
                                        <br>
                                        <small>Reviewer :
                                            {{ $vendorRegistrationReview['reviewer_id'] }}</small>
                                    </div>
                                </div>
                                <hr class="my-3" style="border-top: dashed 0.1rem;">
                                <div class="row">
                                    <div style="width: 65%;">
                                        <small>{{ $vendorRegistrationReview['created_at']->format('l, d/m/Y') }}</small>
                                    </div>
                                    <div style="width: 35%;">
                                        <small>{{ $vendorRegistrationReview['created_at']->format('H:i') }} WIB</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    Komentar sebelumnya tidak ada
                @endforelse
            </div>
        </div>

        @if ($vendor->status == 'opened' || $vendor->status == 'review')
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

                    <form method="POST" action="{{ route('vendor-review.store', $vendor->id) }}"
                        class="row g-3 needs-validation" novalidate enctype="multipart/form-data">
                        @csrf

                        <div class="col-md-6">
                            <label for="comment">Komentar
                                <span class="text-danger">*</span>
                            </label>
                            <textarea name="comment" class="form-control" id="comment" rows="3">{{ old('comment') }}</textarea>
                        </div>

                        <div class="col-12 d-flex justify-content-end">
                            <button class="btn btn-primary mx-1" name="action" value="submit" type="submit">
                                Kirim
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{ asset('plugins/global/vendors.min.js') }}"></script>

    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
