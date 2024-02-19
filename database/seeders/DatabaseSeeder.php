<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('123456'),
            'type' => 1
        ]);

        Event::create([
            'name' => 'Event 1',
            'name_arabic' => 'امتحان',
            'date' => '2024-02-14',
            'date_arabic' => '١٢-٠٩-٢٠٢٣',
            'venue' => 'Test Stadium',
            'venue_arabic' => 'ملعب الاختبار',
            'status' => 1
        ]);
    }
}
