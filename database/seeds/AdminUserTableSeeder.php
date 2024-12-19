<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $salt = md5(uniqid(microtime(),true));
        $password = md5(md5('123456').$salt);
        DB::table('admin_user')->insert([
            [
                'id' =>1,
                'username' => 'admin',
                'password' => $password,
                'salt' => $salt
            ],
        ]);
    }
}
