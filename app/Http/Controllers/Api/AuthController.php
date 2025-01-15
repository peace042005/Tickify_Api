<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            // NOTE: Confirmed: Do not forget that we will need password and password_confirmation
        ]);

        // Créer l'utilisateur le rôle d'utilisateur
        $user = User::create([
            'name' => $fields['name'],
            'prenom' => $fields['prenom'],
            'email' => $fields['email'],
            'role_id' => 1,
            'password' => Hash::make($fields['password']),
        ]);

        // Ajouter le token d'authentification à l'utilisateur
        $token = $user->createToken($user->email);

        return [
            'user' => $user,
            'token' => $token->plainTextToken,
        ];
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'exists:users,email'],
            'password' => ['required'],
        ]);

        // Récupérer l'utilisateur dont l'email correspond
        // ->first() pour s'assurer que l'objet n'est pas un array
        $user = User::where('email', $fields['email'])->first();

        // Erreur si l'utilisateur n'existe pas ou si le mot de passe est incorrecte
        if (! $user || ! Hash::check($fields['password'], $user->password)) {
            return ['message' => 'Invalid credentials'];
        }

        // Ajouter le token d'authentification à l'utilisateur
        $token = $user->createToken($user->email);

        return [
            'user' => $user,
            'token' => $token->plainTextToken,
        ];
    }

    public function logout(Request $request)
    {
        // $request->user()->currentAccessToken()->delete();
        $request->user()->tokens()->delete();

        return [
            'message' => 'Successfully logged out',
        ];
    }
}
