<?php
/**
 * RolesTableSeeder
 *
 * @author: tuanha
 * @last-mod: 02-Nov-2019
 */
namespace Bkstar123\BksCMS\AdminPanel\Database\Seeds;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
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
            DB::table('roles')->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            DB::table('roles')->insert([
                'role' => 'superadmins',
                'description' => 'This role has a super privilege to do everything. You should only grant it to the site developer team',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            DB::table('roles')->insert([
                'role' => 'administrators',
                'description' => 'This role should only be granted to the site administrators',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        });
    }
}
