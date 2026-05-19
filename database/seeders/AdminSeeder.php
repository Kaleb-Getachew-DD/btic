<?php
// FILE: database/seeders/AdminSeeder.php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(['email' => 'admin@ddu.edu.et'], [
            'name'     => 'Super Administrator',
            'password' => Hash::make('Admin@2024!'),
            'role'     => 'super_admin',
            'is_active'=> true,
        ]);

        User::updateOrCreate(['email' => 'manager@btic.ddu.edu.et'], [
            'name'     => 'BTIC Manager',
            'password' => Hash::make('Manager@2024!'),
            'role'     => 'admin',
            'is_active'=> true,
        ]);

        User::updateOrCreate(['email' => 'editor@btic.ddu.edu.et'], [
            'name'     => 'Content Editor',
            'password' => Hash::make('Editor@2024!'),
            'role'     => 'editor',
            'is_active'=> true,
        ]);
    }
}
