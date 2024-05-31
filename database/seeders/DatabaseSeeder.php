<?php

namespace Database\Seeders;

use Database\Seeders\EventSeeder;
use Database\Seeders\AttendeeSeeder;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        User::factory(1000)->create();

        $this->call(EventSeeder::class);
        $this->call(AttendeeSeeder::class);

    }
}
