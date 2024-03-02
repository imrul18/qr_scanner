<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\MasterSetting;
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

        MasterSetting::create([
            'key' => 'organizationName',
            'label' => 'Apple wallet Organization Name',
            'value' => 'Test Company'
        ]);

        MasterSetting::create([
            'key' => 'passTypeIdentifier',
            'label' => 'Apple wallet Pass Type Identifier',
            'value' => 'pass.event.ticket.demo'
        ]);

        MasterSetting::create([
            'key' => 'teamIdentifier',
            'label' => 'Apple wallet Team Identifier',
            'value' => 'JQ6475PC63'
        ]);
        MasterSetting::create([
            'key' => 'certificatePassword',
            'label' => 'Apple wallet Certificate Password',
            'value' => '123456'
        ]);
        MasterSetting::create([
            'key' => 'certificatePath',
            'type' => 2,
            'label' => 'Apple wallet Certificate',
            'value' => 'public/files/Certificates.p12'
        ]);
    }
}
