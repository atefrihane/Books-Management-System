<?php

use App\Modules\Role\Models\Role;
use App\Modules\User\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['name' => 'superadmin'],
            ['name' => 'admin'],
            ['name' => 'user'],
        ];
        Role::insert($roles);
        User::insert(
            [
                [
                    'email' => 'test@test.tn',
                    'password' => bcrypt('123456'),
                    'first_name' => 'Super',
                    'last_name' => 'Admin',
                    'active' => 1,
                    'role_id' => 1,
                    'country'=>'tunisia',
                    'email_verified_at' => Carbon::now(),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'email' => 'yalafa4762@emailhost99.com ',
                    'password' => bcrypt('123456'),
                    'first_name' => 'yala',
                    'last_name' => 'fa',
                    'active' => 1,
                    'role_id' => 3,
                    'country'=>'tunisia',
                    'email_verified_at' => Carbon::now(),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],

            ]
        );

    }
}
