<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Hash;
use DB;
use Str;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = [
            [
                'id' => (string) Str::orderedUuid(),
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('password')
            ],
        ];
        DB::table('users')->insert($data);
    }
}
