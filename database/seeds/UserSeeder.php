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
                    'full_name' => 'Super Admin' ,
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
                    'full_name' => 'yala fala',
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
