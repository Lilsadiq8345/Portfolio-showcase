<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->truncate();
        DB::table('projects')->truncate();
        DB::table('project_skill')->truncate();

        $skills = Skill::all();

        // User 1
        $user1 = User::create([
            'name' => 'JohnDoe',
            'email' => 'john.doe@example.com',
            'password' => Hash::make('password'),
            'bio' => 'Backend developer passionate about scalable web apps and e-commerce.',
        ]);

        $project1 = $user1->projects()->create([
            'title' => 'E-commerce Platform',
            'description' => 'A full-featured e-commerce site built with Laravel and Vue.js.',
            'category' => 'Backend',
            'github_link' => 'https://github.com/johndoe/ecommerce',
            'live_link' => 'https://ecommerce.johndoe.com',
            'visibility' => 'public',
            'progress' => 85,
            'thumbnail' => 'https://placehold.co/400x200?text=E-commerce',
        ]);
        $project1->skills()->attach($skills->whereIn('name', ['Laravel', 'Vue.js', 'MySQL'])->pluck('id'));

        $project2 = $user1->projects()->create([
            'title' => 'Personal Blog',
            'description' => 'A simple, elegant blog for personal use.',
            'category' => 'Frontend',
            'github_link' => 'https://github.com/johndoe/blog',
            'visibility' => 'private',
            'progress' => 100,
        ]);
        $project2->skills()->attach($skills->whereIn('name', ['Vue.js', 'Tailwind CSS'])->pluck('id'));


        // User 2
        $user2 = User::create([
            'name' => 'JaneSmith',
            'email' => 'jane.smith@example.com',
            'password' => Hash::make('password'),
            'bio' => 'Fullstack engineer and data enthusiast. Loves building dashboards.',
        ]);

        $project3 = $user2->projects()->create([
            'title' => 'Task Management App',
            'description' => 'A Kanban-style task management application.',
            'category' => 'Backend',
            'github_link' => 'https://github.com/janesmith/tasks',
            'live_link' => 'https://tasks.janesmith.com',
            'visibility' => 'public',
            'progress' => 95,
            'thumbnail' => 'https://placehold.co/400x200?text=Task+App',
        ]);
        $project3->skills()->attach($skills->whereIn('name', ['PHP', 'React', 'PostgreSQL'])->pluck('id'));

        $project4 = $user2->projects()->create([
            'title' => 'Data Visualization Dashboard',
            'description' => 'A dashboard for visualizing complex datasets.',
            'category' => 'Database',
            'github_link' => 'https://github.com/janesmith/dashboard',
            'visibility' => 'public',
            'progress' => 70,
        ]);
        $project4->skills()->attach($skills->whereIn('name', ['Python', 'JavaScript', 'MongoDB'])->pluck('id'));
    }
}
