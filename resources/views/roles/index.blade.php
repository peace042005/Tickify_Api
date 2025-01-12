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
            <h5 class="card-title">Role</h5>
            <p class="card-subtitle">
                Définir et gérer les rôles des utilisateurs pour contrôler les niveaux d'accès et les autorisations. Chaque
                rôle spécifie ce que les utilisateurs peuvent voir et faire au sein de la plateforme, garantissant ainsi une
                gestion sécurisée et organisée des capacités des utilisateurs.
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
        function deleteRole(url) {
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
            @foreach ($roles as $role)
                [
                    {{ $role->id }},
                    "{{ $role->nom }}",
                    "{{ $role->updated_at->diffForHumans() }}",
                    {
                        edit: "{{ route('roles.edit', $role->id) }}",
                        delete: "{{ route('roles.destroy', $role->id) }}"
                    }
                ],
            @endforeach
        ];

        new gridjs.Grid({
            columns: [
                "Identifiant",
                "Nom",
                "Dernière modification",
                {
                    name: "Actions",
                    formatter: (cell) => {
                        return gridjs.html(
                            `<div class="d-flex gap-2 justify-content-center">
                                <a href="${cell.edit}" class="btn btn-primary py-1"><i class="bx bx-pencil text-white"></i></a>
                                <button onclick="deleteRole('${cell.delete}')" class="btn btn-danger py-1"><i class="bx bx-trash text-white"></i></button>
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
