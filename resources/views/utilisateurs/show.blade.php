@extends('frontend.index')

@section('content')
    <div class="container py-4">
        <div class="row g-4">
            <!-- User Profile Card -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body text-center">
                        @if ($user->photo_profile)
                            <img src="{{ Storage::url($user->photo_profile) }}" class="rounded-circle mb-3"
                                alt="Profile Picture" style="width: 150px; height: 150px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center mx-auto mb-3"
                                style="width: 150px; height: 150px;">
                                <i class='bx bx-user' style="font-size: 4rem; color: white;"></i>
                            </div>
                        @endif

                        <h3 class="card-title mb-0">{{ $user->name }} {{ $user->prenom }}</h3>
                        <p class="text-muted">{{ $user->role->name }}</p>

                        <div class="border-top pt-3 mt-3">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3 text-start">
                                        <label class="text-muted small">Email</label>
                                        <div class="d-flex align-items-center">
                                            <i class='bx bx-envelope me-2'></i>
                                            {{ $user->email }}
                                        </div>
                                    </div>

                                    <div class="mb-3 text-start">
                                        <label class="text-muted small">Téléphone</label>
                                        <div class="d-flex align-items-center">
                                            <i class='bx bx-phone me-2'></i>
                                            {{ $user->telephone ?? 'Non renseigné' }}
                                        </div>
                                    </div>

                                    <div class="mb-3 text-start">
                                        <label class="text-muted small">Date de naissance</label>
                                        <div class="d-flex align-items-center">
                                            <i class='bx bx-calendar me-2'></i>
                                            @if ($user->date_naissance)
                                                {{ $user->date_naissance->format('d/m/Y') }}
                                            @else
                                                Non renseigné
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3 text-start">
                                        <label class="text-muted small">Sexe</label>
                                        <div class="d-flex align-items-center">
                                            <i class='bx bx-user me-2'></i>
                                            {{ $user->sexe ?? 'Non renseigné' }}
                                        </div>
                                    </div>

                                    <div class="text-start">
                                        <label class="text-muted small">Membre depuis</label>
                                        <div class="d-flex align-items-center">
                                            <i class='bx bx-time me-2'></i>
                                            {{ $user->created_at->format('d/m/Y') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tickets Card -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Mes Tickets</h5>
                    </div>
                    <div class="card-body">
                        @forelse($user->tickets as $ticket)
                            <div class="ticket-card mb-3 p-3 border rounded">
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <h6 class="mb-1">{{ $ticket->typeTicket->evenement->nom }}</h6>
                                        <span class="text-muted small">{{ $ticket->typeTicket->nom }}</span>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-muted small mb-1">Date</div>
                                        {{ $ticket->typeTicket->evenement->date_debut->format('d/m/Y H:i') }}
                                    </div>
                                    <div class="col-md-2">
                                        <div class="text-muted small mb-1">Prix</div>
                                        {{ number_format($ticket->typeTicket->prix, 0, ',', ' ') }} CFA
                                    </div>
                                    <div class="col-md-3">
                                        <span class="badge bg-{{ $ticket->status === 'valide' ? 'success' : 'warning' }}">
                                            {{ $ticket->status === 'valide' ? 'Valide' : 'En attente' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted py-4">
                                <i class='bx bx-ticket d-block mb-2' style="font-size: 3rem;"></i>
                                Aucun ticket acheté pour le moment
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        .ticket-card {
            transition: all 0.3s ease;
        }

        .ticket-card:hover {
            background-color: #f8f9fa;
            transform: translateX(5px);
        }
    </style>
@endsection
