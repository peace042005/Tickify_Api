@extends('frontend.index')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Modifier le rôle</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('roles.update', $role->id) }}" method="POST" class="needs-validation" novalidate>
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nom" class="form-label">Nom du rôle</label>
                    <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom"
                        name="nom" value="{{ old('nom', $role->nom) }}" required>
                    @error('nom')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                    <a href="{{ route('roles.index') }}" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (() => {
            'use strict'

            // Fetch all the forms we want to apply custom validation styles to
            const form = document.querySelector('.needs-validation')

            // Add real-time validation
            const nomInput = document.querySelector('#nom')
            nomInput.addEventListener('input', function() {
                if (this.value.length < 3) {
                    this.classList.add('is-invalid')
                    this.classList.remove('is-valid')
                } else {
                    this.classList.remove('is-invalid')
                    this.classList.add('is-valid')
                }
            })

            // Handle form submission
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            })
        })()
    </script>
@endsection
