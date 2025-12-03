<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Status::truncate();

        Status::create([
            'title'    => "I'm on Date",
            'emoji'    => "❤️"
        ]);

        Status::create([
            'title'    => "I'm on Vaction",
            'emoji'    => "☘️"
        ]);

        Status::create([
            'title'    => "Feeling Sad",
            'emoji'    => "😥"
        ]);

        Status::create([
            'title'    => "Motivated",
            'emoji'    => "😊"
        ]);

        Status::create([
            'title'    => "I'm Sleeping",
            'emoji'    => "😴"
        ]);

        Status::create([
            'title'    => "I'm Celebrating",
            'emoji'    => "🎉"
        ]);

        Status::create([
            'title'    => "It's my Birthday",
            'emoji'    => "🎂"
        ]);

        Status::create([
            'title'    => "Playing",
            'emoji'    => "🤾‍♂️"
        ]);
    }
}
