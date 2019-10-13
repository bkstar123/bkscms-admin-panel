<?php
/**
 * AdminObserver.php
 * Listening to the Admin model events
 *
 * @author: tuanha
 * @last-mod: 13-Oct-2019
 */
namespace Bkstar123\BksCMS\AdminPanel\Observers;

use Illuminate\Support\Facades\DB;
use Bkstar123\BksCMS\AdminPanel\Admin;
use Bkstar123\LaravelUploader\Contracts\FileUpload;

class AdminObserver
{
    /**
     * Listen to the Admin model deleting event.
     *
     * @param  Bkstar123\BksCMS\AdminPanel\Admin $admin
     * @return void
     */
    public function deleting(Admin $admin)
    {
        DB::transaction(function () use ($admin) {
            $profile = $admin->profile;
            if (!is_null($profile)) {
                $profile->delete();
                $fileupload = app(FileUpload::class);
                $fileupload->delete($profile->avatar_disk, $profile->avatar_path);
            }
        });
    }
}
