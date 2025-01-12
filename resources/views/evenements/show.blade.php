@php
    \Carbon\Carbon::setLocale('fr');
@endphp

@extends('frontend.index')

@section('content')
    <div class="container py-4">
        <div class="row">
            <!-- Event Images Carousel -->
            <div class="col-12 mb-4">
                <div id="eventCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @forelse($evenement->images as $index => $image)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <img src="{{ Storage::url($image->path) }}" class="d-block w-100" alt="Event image"
                                    style="height: 400px; object-fit: cover;">
                            </div>
                        @empty
                            <div class="carousel-item active">
                                <div class="d-block w-100 bg-secondary" style="height: 400px;">
                                    <div class="d-flex align-items-center justify-content-center h-100">
                                        <span class="text-white">Aucune image disponible</span>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                    @if ($evenement->images->count() > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#eventCarousel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#eventCarousel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    @endif
                </div>
            </div>

            <!-- Event Details -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title h2 mb-4">{{ $evenement->nom }}</h1>

                        <div class="mb-4">
                            <h5 class="text-muted mb-3">Description</h5>
                            <p class="card-text">{{ $evenement->description }}</p>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5 class="text-muted mb-3">Date et heure</h5>
                                <p class="mb-2">
                                    <i class='bx bx-calendar me-2'></i>
                                    Début: {{ $evenement->date_debut->format('d/m/Y H:i') }}
                                    <span class="text-muted ml-2">({{ $evenement->date_debut->diffForHumans() }})</span>
                                </p>
                                <p>
                                    <i class='bx bx-calendar me-2'></i>
                                    Fin: {{ $evenement->date_fin->format('d/m/Y H:i') }}
                                    <span class="text-muted ml-2">({{ $evenement->date_fin->diffForHumans() }})</span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h5 class="text-muted mb-3">Enregistré par</h5>
                                <p>
                                    <i class='bx bx-user me-2'></i>
                                    {{ $evenement->createdBy->name }}
                                </p>
                            </div>
                        </div>

                        @if ($evenement->lieu)
                            <div class="mb-4">
                                <h5 class="text-muted mb-3">Lieu</h5>
                                <p>
                                    <i class='bx bx-map me-2'></i>
                                    {{ $evenement->lieu }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Tickets Section -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Tickets disponibles</h5>
                    </div>
                    <div class="card-body">
                        @foreach ($evenement->typeTickets as $type)
                            <div class="type-option mb-3 p-3 border rounded">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0">{{ $type->nom }}</h6>
                                    <span class="badge bg-primary">{{ number_format($type->prix, 0, ',', ' ') }}
                                        CFA</span>
                                </div>
                                <h6 class="mb-0 text-muted w-100 text-center">{{ $type->tickets->count() }} vendus</h6>
                                <!-- <button class="btn btn-primary w-100"> -->
                                <!--     Acheter -->
                                <!-- </button> -->
                            </div>
                        @endforeach

                        <div class="text-center mt-3">
                            <small class="text-muted">
                                {{ number_format($evenement->nombre_tickets, 0, ',', ' ') }} places disponibles au total
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        .ticket-option {
            transition: all 0.3s ease;
        }

        .ticket-option:hover {
            background-color: #f8f9fa;
            transform: translateY(-2px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection
