<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Skill;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = [
            // Backend
            ['nom' => 'Laravel',       'categorie' => 'Backend'],
            ['nom' => 'PHP',           'categorie' => 'Backend'],
            ['nom' => 'Node.js',       'categorie' => 'Backend'],
            ['nom' => 'Python',        'categorie' => 'Backend'],
            ['nom' => 'Java',          'categorie' => 'Backend'],
            ['nom' => 'Symfony',       'categorie' => 'Backend'],
            ['nom' => 'Express.js',    'categorie' => 'Backend'],
            ['nom' => 'REST API',      'categorie' => 'Backend'],

            // Frontend
            ['nom' => 'Vue.js',        'categorie' => 'Frontend'],
            ['nom' => 'React',         'categorie' => 'Frontend'],
            ['nom' => 'JavaScript',    'categorie' => 'Frontend'],
            ['nom' => 'TypeScript',    'categorie' => 'Frontend'],
            ['nom' => 'Tailwind CSS',  'categorie' => 'Frontend'],
            ['nom' => 'CSS',           'categorie' => 'Frontend'],
            ['nom' => 'HTML',          'categorie' => 'Frontend'],
            ['nom' => 'Alpine.js',     'categorie' => 'Frontend'],

            // DevOps
            ['nom' => 'Docker',        'categorie' => 'DevOps'],
            ['nom' => 'Git',           'categorie' => 'DevOps'],
            ['nom' => 'GitHub Actions','categorie' => 'DevOps'],
            ['nom' => 'Linux',         'categorie' => 'DevOps'],
            ['nom' => 'Nginx',         'categorie' => 'DevOps'],

            // Database
            ['nom' => 'MySQL',         'categorie' => 'Database'],
            ['nom' => 'PostgreSQL',    'categorie' => 'Database'],
            ['nom' => 'MongoDB',       'categorie' => 'Database'],
            ['nom' => 'Redis',         'categorie' => 'Database'],
            ['nom' => 'SQLite',        'categorie' => 'Database'],

            // Mobile
            ['nom' => 'Flutter',       'categorie' => 'Mobile'],
            ['nom' => 'React Native',  'categorie' => 'Mobile'],

            // Other
            ['nom' => 'Algorithmie',   'categorie' => 'Other'],
            ['nom' => 'UML',           'categorie' => 'Other'],
        ];



        foreach ($skills as $skill) {
            Skill::firstOrCreate(
                ['nom' => $skill['nom']],
                ['categorie' => $skill['categorie']]
            );
        }
    }
}
