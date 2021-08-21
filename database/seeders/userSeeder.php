<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(
            [
                'name' => 'Administrator',
            ],
        );
        role::create(
            [
                'name' => 'operatorForklift',
            ],
        );
        User::create([
            "name" => "Qhurma",
            "email" => "Qhurma@gmail.com",
            "phone_number" => "085733296961",
            "password" =>  bcrypt('12345'),
            "role" => 1,
        ]);
    }
}
