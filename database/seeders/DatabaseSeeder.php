<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            SpecialistSeeder::class,
            ConsultationSeeder::class,
            TypeUserSeeder::class,
            ConfigPaymentSeeder::class,
            UserSeeder::class,
            DetailUserSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            RoleUserSeeder::class,
            PermissionRoleSeeder::class,

        ]);

    }
}
