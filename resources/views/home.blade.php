<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{ $title }}
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        @vite(['resources/scss/light/assets/widgets/modules-widgets.scss'])

        @vite(['resources/scss/dark/assets/widgets/modules-widgets.scss'])
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <div class="row layout-top-spacing">
        <div class="m-3">
            @if (session('status'))
                <div class="alert alert-{{ session('status.type') }} alert-dismissible fade show" role="alert">
                    {!! session('status.message') !!}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>

        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
            @if (Auth::user()->roles->first()->name == 'buyer')
                <div class="widget widget-card-two">
                    <div class="widget-content">
                        <div class="media">
                            <div class="w-img">
                                <img src="{{ Vite::asset('resources/images/g-8.png') }}" alt="vendor">
                            </div>
                            <div class="media-body">
                                <h6>Vendor</h6>
                                <p class="meta-date-time">Daftar perubahan akun sebagai Vendor</p>
                            </div>
                        </div>

                        <div class="card-bottom-section">
                            <a href="{{ $urlVendorRegistaration }}" class="btn">Pengajuan Vendor</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>

    </div>

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        @vite(['resources/assets/js/widgets/modules-widgets.js'])
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
