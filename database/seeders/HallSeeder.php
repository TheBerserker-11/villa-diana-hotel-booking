<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hall;

class HallSeeder extends Seeder
{
    public function run(): void
    {
        Hall::insert([
            ['name' => 'Aspen Hall', 'max_capacity' => 500, 'price' => 70000],
            ['name' => 'Hunter Hall', 'max_capacity' => 100, 'price' => 45000],
            ['name' => 'Pool Area', 'max_capacity' => 50, 'price' => 20000],
            ['name' => 'Garden Venue', 'max_capacity' => 100, 'price' => 30000],
        ]);
    }
}

