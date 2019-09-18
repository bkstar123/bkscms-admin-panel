<?php
/**
 * @author: tuanha
 * @last-mod: 02-Sept-2019
 */
namespace Bkstar123\BksCMS\AdminPanel;

use Illuminate\Notifications\Notifiable;
use Bkstar123\BksCMS\Utilities\Traits\FullTextSearch;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Bkstar123\BksCMS\AdminPanel\Notifications\ResetPassword as ResetPasswordNotification;

class Admin extends Authenticatable
{
    use Notifiable, FullTextSearch;

    const ACTIVE = true;

    const INACTIVE = false;

    /**
     * The columns of the full text index
     */
    protected $searchable = [
        'username',
        'name',
        'email'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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
}
