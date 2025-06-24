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
            ['name' => 'TypeScript', 'type' => 'Frontend'],
            ['name' => 'Vue.js', 'type' => 'Frontend'],
            ['name' => 'React', 'type' => 'Frontend'],
            ['name' => 'Angular', 'type' => 'Frontend'],
            ['name' => 'TailwindCSS', 'type' => 'Frontend'],
            ['name' => 'Bootstrap', 'type' => 'Frontend'],
            ['name' => 'Responsive Design', 'type' => 'Frontend'],

            // Backend
            ['name' => 'PHP', 'type' => 'Backend'],
            ['name' => 'Laravel', 'type' => 'Backend'],
            ['name' => 'Node.js', 'type' => 'Backend'],
            ['name' => 'Express.js', 'type' => 'Backend'],
            ['name' => 'Python', 'type' => 'Backend'],
            ['name' => 'Django', 'type' => 'Backend'],
            ['name' => 'REST API', 'type' => 'Backend'],
            ['name' => 'GraphQL', 'type' => 'Backend'],
            ['name' => 'Authentication', 'type' => 'Backend'],
            ['name' => 'API Integration', 'type' => 'Backend'],
            ['name' => 'Payment Gateway', 'type' => 'Backend'],
            ['name' => 'E-commerce', 'type' => 'Backend'],

            // Database
            ['name' => 'MySQL', 'type' => 'Database'],
            ['name' => 'PostgreSQL', 'type' => 'Database'],
            ['name' => 'SQLite', 'type' => 'Database'],
            ['name' => 'MongoDB', 'type' => 'Database'],

            // DevOps/Tools
            ['name' => 'Docker', 'type' => 'DevOps'],
            ['name' => 'Git', 'type' => 'DevOps'],
            ['name' => 'GitHub Actions', 'type' => 'DevOps'],
            ['name' => 'CI/CD', 'type' => 'DevOps'],
            ['name' => 'AWS', 'type' => 'DevOps'],
            ['name' => 'DigitalOcean', 'type' => 'DevOps'],

            // General
            ['name' => 'Unit Testing', 'type' => 'General'],
            ['name' => 'SaaS', 'type' => 'General'],
            ['name' => 'Mobile App', 'type' => 'General'],
            ['name' => 'Cloud', 'type' => 'General'],
        ];

        foreach ($skills as $skill) {
            Skill::create($skill);
        }
    }
}
