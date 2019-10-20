<?php
/**
 * AdminProfileController
 *
 * @author: tuanha
 * @last-mod: 06-Oct-2019
 */
namespace Bkstar123\BksCMS\AdminPanel\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Bkstar123\BksCMS\AdminPanel\Admin;
use Bkstar123\LaravelUploader\Contracts\FileUpload;
use Bkstar123\BksCMS\AdminPanel\Traits\AuthorizationShield;

class AdminProfileController extends Controller
{
    use AuthorizationShield;
    
    /**
     * Update a resource
     *
     * @param \Illuminate\Http\Request $request
     * @param \Bkstar123\BksCMS\AdminPanel\Admin $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        $this->capabilityCheck('update', $admin);
        try {
            $admin->profile()->updateOrCreate([
                'admin_id' => $admin->id
            ], $request->all(['mobile', 'slack_webhook_url']));
            flashing("The profile of $admin->name has been successfully updated")
                ->success()
                ->flash();
        } catch (Exception $e) {
            flashing("The submitted action failed to be executed due to some unknown error")
                ->error()
                ->flash();
        }
        return back();
    }

    /**
     * Handle avatar upload for the authenticated admin
     *
     * @param \Illuminate\Http\Request $request
     * @param \Bkstar123\LaravelUploader\Contracts\FileUpload $fileupload
     */
    public function uploadAvatar(Request $request, FileUpload $fileupload)
    {
        $res = $fileupload->handle($request, 'avatar', [
            'directory' => 'admin-avatars',
            'allowedExtensions' => config('bkstar123_bkscms_adminpanel.avatarAllowedExtensions'),
            'maxFileSize' => config('bkstar123_bkscms_adminpanel.avatarMaxSize')

        ]);
        if (!$res) {
            return response()->json([
                'error' => $fileupload->uploadError
            ], 422);
        }
        $data = [
            'avatar_url' => $res['url'],
            'avatar_path' => $res['path'],
            'avatar_disk' => $res['disk']
        ];
        $currentAvatar = auth()->guard('admins')->user()->getAvatar();
        auth()->guard('admins')->user()->profile()->updateOrCreate([
             'admin_id' => auth()->guard('admins')->id()
        ], $data);
        if ($currentAvatar['custom']) {
            $fileupload->delete($currentAvatar['avatar_disk'], $currentAvatar['avatar_path']);
        }
        return response()->json([
            'success' => "{$res['filename']} has been successfully uploaded",
            'data' => $res
        ], 200);
    }
}
