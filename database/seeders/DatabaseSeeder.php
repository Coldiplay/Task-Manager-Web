<?php

namespace Database\Seeders;

use App\Models\comment;
use App\Models\project;
use App\Models\task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
//use LaravelSpectrum\Tests\Fixtures\Controllers\Product;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        project::factory(10)->create();
        task::factory(10)->create();
        comment::factory(100)->create();

//        User::factory()->create([
//            'name' => 'Test User',
//            'email' => 'test@example.com',
//        ]);
    }
}
