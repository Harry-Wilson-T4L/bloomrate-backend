<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            ContentSeeder::class,
            InterestSeeder::class,
            StatusSeeder::class
        ]);

        Country::truncate();
        $countries_path = 'app/developer_docs/countries.sql';
        DB::unprepared(file_get_contents($countries_path));
        
        State::truncate();
        $states_path = 'app/developer_docs/states.sql';
        DB::unprepared(file_get_contents($states_path));
        
        City::truncate();
        $cities_path = 'app/developer_docs/cities.sql';
        DB::unprepared(file_get_contents($cities_path));
        
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
