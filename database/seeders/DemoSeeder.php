<?php

namespace Database\Seeders;

use App\Models\Evenement;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

/**
 * Données de démonstration : un compte de test et quatre événements
 * avec leurs images et leurs types de billets.
 */
class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::forceCreate([
            'role_id' => 2,
            'name' => 'Admin',
            'prenom' => 'Tickify',
            'email' => 'admin@tickify.test',
            'password' => Hash::make('password'),
        ]);

        User::forceCreate([
            'role_id' => 1,
            'name' => 'Démo',
            'prenom' => 'Utilisateur',
            'email' => 'demo@tickify.test',
            'password' => Hash::make('password'),
        ]);

        $events = [
            ['concert', 'Concert Live à Cotonou', 'Une soirée de concerts avec les artistes de la scène béninoise.', 'Palais des Congrès, Cotonou', 20, 150,
                [['Standard', 5000], ['VIP', 15000]]],
            ['festival', 'Festival Vodun', 'Trois jours de célébrations, de danses et de cultures traditionnelles.', 'Plage de Ouidah', 45, 400,
                [['Pass 1 jour', 3000], ['Pass 3 jours', 7500]]],
            ['conference', 'Tech Summit Bénin', 'Conférences et ateliers sur le numérique, l\'IA et l\'entrepreneuriat.', 'Sèmè City, Cotonou', 60, 200,
                [['Étudiant', 2000], ['Professionnel', 10000]]],
            ['match', 'Match de gala', 'Rencontre amicale entre les légendes du football béninois.', 'Stade de l\'Amitié, Cotonou', 75, 1000,
                [['Tribune', 1500], ['Tribune d\'honneur', 5000]]],
        ];

        foreach ($events as [$slug, $nom, $description, $lieu, $inDays, $places, $types]) {
            $evenement = Evenement::forceCreate([
                'nom' => $nom,
                'description' => $description,
                'lieu' => $lieu,
                'created_by' => $admin->id,
                'date_debut' => now()->addDays($inDays)->setTime(19, 0),
                'date_fin' => now()->addDays($inDays)->setTime(23, 0),
                'nombre_tickets' => $places,
            ]);

            foreach ($types as [$typeNom, $prix]) {
                $evenement->typeTickets()->create(['nom' => $typeNom, 'prix' => $prix]);
            }

            foreach ([1, 2] as $k) {
                $file = database_path("seeders/demo-images/{$slug}_{$k}.jpg");
                Storage::disk('public')->put("evenements/{$slug}_{$k}.jpg", File::get($file));
                $evenement->images()->create(['path' => "evenements/{$slug}_{$k}.jpg"]);
            }
        }
    }
}
