<?php

namespace Database\Seeders;

use App\Models\Interest;
use Illuminate\Database\Seeder;

class InterestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Interest::query()->delete();

        $data = [
            [
                'title'      => 'Writing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'Blogging',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'Learning Languages',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'Photography',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'Travel',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'Sports',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'Reading',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'Making Music',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'Yoga',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'Art',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];
        Interest::insert($data);
    }
}
