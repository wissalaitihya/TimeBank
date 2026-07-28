<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Skill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\hash;
use PhpParser\NodeVisitor\FirstFindingVisitor;

class UserSeeder extends Seeder
{
    
    public function run(): void
    {
        $user1 = User::FirstOrCreate([
            'email' => 'wissal@timebank.com',
        ],
        [
          'name' => 'Wissal',
          'password' => Hash::make('password'),
          'bio'   => 'Développeur Laravel passionné.',
          'niveau'        => 'intermediaire',
          'solde_heures'  => 2.00,
          'statut_compte' => 'actif',
        ]);

         $laravel = Skill::where('nom', 'Laravel')->first();
         $css     = Skill::where('nom', 'CSS')->first();

        if ($laravel) {
            $user1->skills()->syncWithoutDetaching([
                $laravel->id => [
                    'niveau' => 'intermediaire',
                    'source' => 'manuel',
                ],
            ]);
        }

        if ($css) {
            $user1->skills()->syncWithoutDetaching([
                $css->id => [
                    'niveau' => 'debutant',
                    'source' => 'manuel',
                ],
            ]);
        }

        // Test user 2 — Sara
        $user2 = User::firstOrCreate(
            ['email' => 'sara@timebank.test'],
            [
                'name'          => 'Sara',
                'password'      => Hash::make('password'),
                'bio'           => 'Développeuse Frontend CSS et Tailwind.',
                'niveau'        => 'senior',
                'solde_heures'  => 5.00,
                'statut_compte' => 'actif',
            ]
        );

        $tailwind = Skill::where('nom', 'Tailwind CSS')->first();

        if ($tailwind) {
            $user2->skills()->syncWithoutDetaching([
                $tailwind->id => [
                    'niveau' => 'expert',
                    'source' => 'manuel',
                ],
            ]);
        }
    }
}
