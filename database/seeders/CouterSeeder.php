<?php

namespace Database\Seeders;

use App\Models\Counter;
use Database\Factories\CounterFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CouterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Counter::factory(5)->create();
    }
}
