<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::query()->firstOrCreate([
            'last_name' => 'Super',
            'first_name' => 'Admin',
            'patronymic' => 'Forever',
            'email' => 'admin@test.test',
            'phone_number' => '+70000000000',
        ], [
            'last_name' => 'Super',
            'first_name' => 'Admin',
            'patronymic' => 'Forever',
            'email' => 'admin@test.test',
            'phone_number' => '+70000000000',
            'birthdate' => now()->modify('-23 years'),
            'password' => Hash::make('secret'),
        ]);

        User::query()->firstOrCreate([
            'last_name' => 'Second',
            'first_name' => 'User',
            'patronymic' => null,
            'email' => 'second@user.test',
            'phone_number' => '+70000000001',
        ], [
            'last_name' => 'Second',
            'first_name' => 'User',
            'patronymic' => null,
            'email' => 'second@user.test',
            'phone_number' => '+70000000001',
            'birthdate' => now()->modify('-23 years'),
            'password' => Hash::make('secret'),
        ]);

        User::factory()->count(20)->create();
    }
}
