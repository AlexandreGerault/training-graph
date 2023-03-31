<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\Training\GameFactory;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        UserFactory::new()->create([
            'name' => 'Test User',
            'email' => 'alexandre@localhost',
        ]);

        GameFactory::new()->create([
            'name' => 'Counter Strike: Global Offensive',
            'description' => 'Very competitive FPS game',
        ]);
    }
}
