<?php
/**
 * InitAuth - reset authentication & authorization data
 *
 * @author: tuanha
 * @last-mod: 03-Nov-2019
 */
namespace Bkstar123\BksCMS\AdminPanel\Console\Commands;

use Illuminate\Console\Command;
use Bkstar123\BksCMS\AdminPanel\Database\Seeds\AdminPanelSeeder;
use Bkstar123\BksCMS\AdminPanel\Database\Seeds\PermissionsTableSeeder;

class InitAuth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bkscms:initAuth 
        {--scope= : Possible values: "permissions" or "all" to reset permissions only or all auth data (admins, roles, permissions)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset authentication/authorization data';

    /**
     * Hold the name of the user who runs this command
     *
     * @var string
     */
    protected $launcher;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->launcher = trim(shell_exec('whoami'));
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (!$this->isRoot()) {
            return;
        }
        $scope = $this->option('scope');
        switch ($scope) {
            case 'permissions':
                $this->info('Populating permissions data...');
                $this->call('db:seed', [
                    '--class' => PermissionsTableSeeder::class
                ]);
                $this->info('Permissions have been populated.');
                break;
            case 'all':
                $this->info('Rebuilding auth data...');
                $this->call('db:seed', [
                    '--class' => AdminPanelSeeder::class
                ]);
                $this->info('Auth data have been populated');
                break;
            default:
                $this->error("You must specify --scope option with either 'all' or 'permissions' values");
                break;
        }
    }

    /**
     * Check for the root privilege
     * Make sure only root user can run this command
     *
     * @return boolean
     */
    protected function isRoot()
    {
        if ($this->launcher != 'root') {
            $this->error("This command must only be run by root");
            return false;
        } else {
            return true;
        }
    }
}
