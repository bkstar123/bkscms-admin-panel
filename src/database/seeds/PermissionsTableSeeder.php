<?php
/**
 * PermissionsTableSeeder
 *
 * @author: tuanha
 * @last-mod: 02-Nov-2019
 */
namespace Bkstar123\BksCMS\AdminPanel\Database\Seeds;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
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
            DB::table('permissions')->truncate();
            DB::table('permission_role')->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            $permissions = config('bkstar123_bkscms_adminpanel.permissions');
            foreach ($permissions as $permission) {
                $permission['created_at'] = Carbon::now();
                $permission['updated_at'] = Carbon::now();
                DB::table('permissions')->insert($permission);
            }
        });
    }
}
