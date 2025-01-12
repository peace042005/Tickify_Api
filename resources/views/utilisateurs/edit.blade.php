@extends('frontend.index')

@section('content')
    <div class="container">
        <form action="{{ route('utilisateurs.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Modifier l'utilisateur</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ old('name', $user->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="prenom" class="form-label">Prénom</label>
                        <input type="text" class="form-control" id="prenom" name="prenom"
                            value="{{ old('prenom', $user->prenom) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ old('email', $user->email) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="role_id" class="form-label">Rôle</label>
                        <select class="form-control" id="role_id" name="role_id" required>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}"
                                    {{ $role->id == old('role_id', $user->role_id) ? 'selected' : '' }}>{{ $role->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                </div>
            </div>

        </form>
    </div>
@endsection
