<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'                => 1,
                'name'              => 'Hobbes',
                'email'             => 'hrochester@pulsovital.com',
                'password'          => bcrypt('gppass313'),
                'remember_token'    => null,
                'lastname'          => '',
                'phone'             => '',
                'social_linkedin'   => '',
                'government_number' => '',
                'passport'          => '',
            ],
        ];

        User::insert($users);
    }
}
