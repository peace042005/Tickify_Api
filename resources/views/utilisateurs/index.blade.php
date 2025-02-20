@php
    \Carbon\Carbon::setLocale('fr');
@endphp

@extends('frontend.index')

@section('css')
    <link href="{{ asset('assets/vendor/gridjs/theme/mermaid.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Succès!',
                    text: "{{ session('success') }}",
                    timer: 900,
                    showConfirmButton: false
                });
            });
        </script>
    @endif

    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <h5 class="card-title mb-0">Utilisateurs</h5>
                <a href="{{ route('utilisateurs.create') }}" class="btn btn-primary">
                    <i class="bx bx-plus me-1"></i>
                    Ajouter un utilisateur
                </a>
            </div>
            <p class="card-subtitle mb-3">
                Voir les utilisateurs inscrits sur l'application
            </p>
        </div>
        <div class="card-body">
            <div>
                <div id="table-gridjs"></div>
            </div>
        </div>
    </div>

    <!-- Hidden form for delete action -->
    <form id="delete-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endsection

@section('js')
    <script src="{{ asset('assets/vendor/gridjs/gridjs.umd.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function deleteEvent(url) {
            Swal.fire({
                title: 'Êtes-vous sûr?',
                text: "Cette action est irréversible!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, supprimer!',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('delete-form');
                    form.action = url;
                    form.submit();
                }
            });
        }

        // Conversion du tableau php en tableau js
        const data = [
            @foreach ($users as $user)
                [
                    {{ $user->id }},
                    "{{ $user->name }}",
                    "{{ $user->prenom ?? '' }}",
                    "{{ $user->email }}",
                    "{{ $user->role->nom ?? 'Non assigné' }}",
                    "{{ $user->created_at->diffForHumans() }}",
                    {
                        view: "{{ route('utilisateurs.show', $user->id) }}",
                        edit: "{{ route('utilisateurs.edit', $user->id) }}",
                        delete: "{{ route('utilisateurs.destroy', $user->id) }}"
                    }
                ],
            @endforeach
        ];

        new gridjs.Grid({
            columns: [
                "Identifiant",
                "Nom",
                "Prenom",
                "Email",
                "Rôle",
                "Création",
                {
                    name: "Actions",
                    formatter: (cell) => {
                        return gridjs.html(
                            `<div class="d-flex gap-2 justify-content-center">
                                <a href="${cell.view}" class="btn btn-info py-1"><i class="bx bx-show text-white"></i></a>
                                <a href="${cell.edit}" class="btn btn-primary py-1"><i class="bx bx-pencil text-white"></i></a>
                                <button onclick="deleteEvent('${cell.delete}')" class="btn btn-danger py-1"><i class="bx bx-trash text-white"></i></button>
                            </div>`
                        );
                    },
                }
            ],
            data: data,
            pagination: {
                enabled: true,
                limit: 5
            },
            search: true,
            sort: true
        }).render(document.getElementById("table-gridjs"));
    </script>
@endsection
