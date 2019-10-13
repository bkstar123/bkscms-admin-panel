<?php
/**
 * @author: tuanha
 * @last-mod: 02-Sept-2019
 */
namespace Bkstar123\BksCMS\AdminPanel;

use Bkstar123\BksCMS\AdminPanel\Profile;
use Illuminate\Notifications\Notifiable;
use Bkstar123\MySqlSearch\Traits\MySqlSearch;
use Bkstar123\LaravelUploader\Contracts\FileUpload;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Bkstar123\BksCMS\AdminPanel\Notifications\ResetPassword as ResetPasswordNotification;

class Admin extends Authenticatable
{
    use Notifiable, MySqlSearch;

    const ACTIVE = true;

    const INACTIVE = false;

    /**
     * List of columns for search enabling
     *
     * @var array
     */
    public static $mysqlSearchable = ['name', 'username', 'email'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     *
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        flashing('A reset password link has been sent')->success()->flash();
        $this->notify(new ResetPasswordNotification($token));
    }
    
    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'username';
    }

    /**
     * An admin has one profile
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function getAvatar()
    {
        $hasCustomAvatar = isset($this->profile->avatar_url) && !empty($this->profile->avatar_url);
        return [
            'custom' => $hasCustomAvatar ? true : false,
            'avatar_url' => $hasCustomAvatar ? $this->profile->avatar_url : '/img/default-avatar-160x160.jpg',
            'avatar_path' => $this->profile->avatar_path ?? '',
            'avatar_disk' => $this->profile->avatar_disk ?? ''
        ];
    }
}
