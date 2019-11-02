<?php
/**
 * AdminsTableSeeder
 *
 * @author: tuanha
 * @last-mod: 02-Nov-2019
 */
namespace Bkstar123\BksCMS\AdminPanel\Database\Seeds;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::table('admins')->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            DB::table('admins')->insert([
                'name' => 'Super Administrator',
                'username' => 'superadmin',
                'email' => 'superadmin@example.com',
                'password' => bcrypt('superadmin1@'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            DB::table('admins')->insert([
                'name' => 'Administrator',
                'username' => 'administrator',
                'email' => 'administrator@example.com',
                'password' => bcrypt('administrator1@'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        });
    }
}
