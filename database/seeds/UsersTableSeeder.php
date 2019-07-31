<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1 super admin
        // 2 user 3, employer
        $u = new User;
        $u->name = 'wilmer c';
        $u->email = 'wilcor03@gmail.com';
        $u->profileType = 1;
        $u->password = bcrypt('03306080');
        $u->save();
    }
}
