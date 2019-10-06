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

class AdminProfileController extends Controller
{
    /**
     * Update a resource
     *
     * @param \Illuminate\Http\Request $request
     * @param \Bkstar123\BksCMS\AdminPanel\Admin $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
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
            'allowedExtensions' => ['jpg', 'png', 'jpeg'],
            'maxFileSize' => 5242880 // 5MB

        ]);
        if (!$res) {
            return response()->json([
                'error' => $fileupload->uploadError
            ], 422);
        }
        $data['avatar_url'] = $res['url'];
        $data['avatar_path'] = $res['path'];
        $data['avatar_disk'] = $res['disk'];
        $oldAvatar = auth()->guard('admins')->user()->getAvatar();
        auth()->guard('admins')->user()->profile()->updateOrCreate([
             'admin_id' => auth()->guard('admins')->id()
        ], $data);
        if ($oldAvatar['custom']) {
            $fileupload->delete($oldAvatar['avatar_disk'], $oldAvatar['avatar_path']);
        }
        return response()->json([
            'success' => "{$res['filename']} has been successfully uploaded",
            'data' => $res
        ], 200);
    }
}