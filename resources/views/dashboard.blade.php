@extends('frontend.index')

@section('content')
    <!-- ========== Page Title Start ========== -->
    <div class="row">
        <div class="col-md-6 col-xl-3">
            <a href="{{ route('evenements.index') }}" class="card text-decoration-none">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <p class="text-muted mb-0 text-truncate">Événements</p>
                            <h3 class="text-dark mt-2 mb-0">Voir plus</h3>
                        </div>
                        <div class="col-6">
                            <div class="ms-auto avatar-md bg-soft-primary rounded">
                                <iconify-icon icon="solar:calendar-broken"
                                    class="fs-32 avatar-title text-primary"></iconify-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Users Card -->
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <p class="text-muted mb-0 text-truncate">Utilisateurs</p>
                            <h3 class="text-dark mt-2 mb-0">Voir plus</h3>
                        </div>

                        <div class="col-6">
                            <div class="ms-auto avatar-md bg-soft-primary rounded">
                                <iconify-icon icon="solar:user-bold" class="fs-32 avatar-title text-primary"></iconify-icon>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="chart05"></div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- Vector Map Js -->
    <script src="{{ asset('assets/vendor/jsvectormap/js/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jsvectormap/maps/world-merc.js') }}"></script>
    <script src="{{ asset('assets/vendor/jsvectormap/maps/world.js') }}"></script>

    <!-- Dashboard Js -->
    <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endsection
