<?php

namespace Database\Seeders;

use App\Models\Content;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Content::truncate();

        Content::create([
            'content' => '<p>This is dummy privacy policy.</p>',
            'type'    => 'pp'
        ]);

        Content::create([
            'content' => '<p>This is dummy terms and conditions.</p>',
            'type'    => 'tc'
        ]);

        Content::create([
            'content' => '<p>This is dummy about us.</p>',
            'type'    => 'au'
        ]);
    }
}
