<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            min-height: 100vh;
            background-color: #f0f0f0;
        }
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
        }
        .card {
            background: white;
            padding: 20px;
            margin: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
    </style>
</head>

<body>
    <nav style="background: white; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <div class="container" style="display: flex; justify-content: space-between; align-items: center;">
            <a href="/" style="font-weight: bold; text-decoration: none; color: #333; font-size: 1.2rem;">
                {{ config('app.name', 'Laravel') }}
            </a>
            <div style="display: flex; gap: 20px; align-items: center;">
                @guest
                    <a href="{{ route('login') }}" style="color: #333; text-decoration: none;">Se connecter</a>
                    <a href="{{ route('register') }}"
                       style="background: #4F46E5; color: white; padding: 8px 16px; border-radius: 4px; text-decoration: none;">
                        S'inscrire
                    </a>
                @else
                    <a href="/dashboard"
                       style="background: #4F46E5; color: white; padding: 8px 16px; border-radius: 4px; text-decoration: none;">
                        Dashboard
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" style="background: none; border: none; color: #333; cursor: pointer;">
                            Se déconnecter
                        </button>
                    </form>
                @endguest
            </div>
        </div>
    </nav>

    <main class="container" style="padding: 40px 0; text-align: center;">
        <h1 style="font-size: 2.5rem; margin-bottom: 30px; color: #333;">
            Bienvenue sur {{ config('app.name', 'Laravel') }}
        </h1>

        <p style="font-size: 1.1rem; color: #666; margin-bottom: 40px; max-width: 800px; margin-left: auto; margin-right: auto;">
            Page réservée pour l'administration de l'application mobile "{{ config('app.name', 'Laravel') }}"
            destiné aux utilisateurs pour la réservation de tickets pour événements
        </p>

        <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 20px; margin-bottom: 40px;">
            <div class="card" style="width: 300px;">
                <div style="font-size: 2rem; margin-bottom: 15px;">➕</div>
                <h3 style="margin: 0 0 10px 0; font-size: 1.2rem;">Ajoutez des événements</h3>
                <p style="color: #666; margin: 0;">Créez et gérez facilement de nouveaux événements en quelques clics.</p>
            </div>
            <div class="card" style="width: 300px;">
                <div style="font-size: 2rem; margin-bottom: 15px;">✏️</div>
                <h3 style="margin: 0 0 10px 0; font-size: 1.2rem;">Modifiez les événements existants</h3>
                <p style="color: #666; margin: 0;">Mettez à jour les détails de l'événement à tout moment.</p>
            </div>
            <div class="card" style="width: 300px;">
                <div style="font-size: 2rem; margin-bottom: 15px;">📱</div>
                <h3 style="margin: 0 0 10px 0; font-size: 1.2rem;">Suivez les modifications</h3>
                <p style="color: #666; margin: 0;">Voir les mises à jour en temps réel sur l'application mobile</p>
            </div>
        </div>

        @guest
        <div class="card" style="max-width: 600px; margin: 0 auto;">
            <h2 style="margin: 0 0 20px 0; font-size: 1.5rem;">Prêt à ajouter vos événements ?</h2>
            <div style="display: flex; gap: 15px; justify-content: center;">
                <a href="{{ route('register') }}"
                   style="background: #4F46E5; color: white; padding: 12px 24px; border-radius: 4px; text-decoration: none;">
                    Commencer
                </a>
                <a href="{{ route('login') }}"
                   style="border: 2px solid #4F46E5; color: #4F46E5; padding: 12px 24px; border-radius: 4px; text-decoration: none;">
                    Se connecter
                </a>
            </div>
        </div>
        @endguest
    </main>
</body>

</html>
