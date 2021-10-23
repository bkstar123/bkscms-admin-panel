<?php
/**
 * AdminRoleTableSeeder
 *
 * @author: tuanha
 * @last-mod: 24-05-2017
 */
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminRoleTableSeeder extends Seeder
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
            DB::table('admin_role')->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            DB::table('admin_role')->insert([
                'admin_id' => 1,
                'role_id' => 1,
            ]);
            DB::table('admin_role')->insert([
                'admin_id' => 2,
                'role_id' => 2,
            ]);
        });
    }
}
