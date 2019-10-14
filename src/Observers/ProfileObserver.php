<?php
/**
 * ProfileObserver Observer
 * Listening to the Profile model events
 *
 * @author: tuanha
 * @last-mod: 13-Oct-2019
 */
namespace Bkstar123\BksCMS\AdminPanel\Observers;

use Bkstar123\BksCMS\AdminPanel\Profile;
use Bkstar123\LaravelUploader\Contracts\FileUpload;

class ProfileObserver
{
    /**
     * Listen to the Profile model deleted event.
     *
     * @param  \Bkstar123\BksCMS\AdminPanel\Profile $profile
     * @return void
     */
    public function deleted(Profile $profile)
    {
        $fileupload = app(FileUpload::class);
        $fileupload->delete($profile->avatar_disk, $profile->avatar_path);
    }
}
