<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('skills')->truncate();

        $skills = [
            // Frontend
            ['name' => 'HTML5', 'type' => 'Frontend'],
            ['name' => 'CSS3', 'type' => 'Frontend'],
            ['name' => 'JavaScript', 'type' => 'Frontend'],
            ['name' => 'Vue.js', 'type' => 'Frontend'],
            ['name' => 'React', 'type' => 'Frontend'],
            ['name' => 'Angular', 'type' => 'Frontend'],
            ['name' => 'Tailwind CSS', 'type' => 'Frontend'],
            ['name' => 'Bootstrap', 'type' => 'Frontend'],

            // Backend
            ['name' => 'PHP', 'type' => 'Backend'],
            ['name' => 'Laravel', 'type' => 'Backend'],
            ['name' => 'Node.js', 'type' => 'Backend'],
            ['name' => 'Express.js', 'type' => 'Backend'],
            ['name' => 'Python', 'type' => 'Backend'],
            ['name' => 'Django', 'type' => 'Backend'],

            // Database
            ['name' => 'MySQL', 'type' => 'Database'],
            ['name' => 'PostgreSQL', 'type' => 'Database'],
            ['name' => 'SQLite', 'type' => 'Database'],
            ['name' => 'MongoDB', 'type' => 'Database'],
        ];

        foreach ($skills as $skill) {
            Skill::create($skill);
        }
    }
}
