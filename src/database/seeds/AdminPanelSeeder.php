<?php
/**
 * AdminPanelSeeder
 *
 * @author: tuanha
 * @last-mod: 02-Nov-2019
 */
namespace Bkstar123\BksCMS\AdminPanel\Database\Seeds;

use Illuminate\Database\Seeder;

class AdminPanelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(AdminRoleTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
    }
}
