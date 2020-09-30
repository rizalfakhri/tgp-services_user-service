<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Auth\Events\Registered;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name'     => 'Admin',
                'email'    => 'admin@tgp.com',
                'password' => bcrypt(111111)
            ],
            [
                'name'     => 'Dev',
                'email'    => 'dev@tgp.com',
                'password' => bcrypt(111111)
            ],
            [
                'name'     => 'Customer',
                'email'    => 'customer@tgp.com',
                'password' => bcrypt(111111)
            ],
        ];

        foreach($users as $user) {

            $createdUser = User::updateOrCreate(
                ['email' => $user['email']],
                $user
            );

            // Test purposes only
            if( $createdUser->email == 'admin@tgp.com' ) {
                $createdUser->assignRole('admin');
            }
            else
            {
                $createdUser->assignRole('user');
            }

            event(
                new Registered($createdUser)
            );

        }
    }
}
