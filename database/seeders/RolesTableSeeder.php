<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentTime = Carbon::now();

        $roles = [
            ['nom' => 'Utilisateur', 'created_at' => $currentTime, 'updated_at' => $currentTime],
            ['nom' => 'Administrateur', 'created_at' => $currentTime, 'updated_at' => $currentTime],
        ];

        DB::table('roles')->insert($roles);
    }
}
