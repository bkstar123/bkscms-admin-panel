<?php
/**
 * @author: tuanha
 * @last-mod: 02-Sept-2019
 */
namespace Bkstar123\BksCMS\AdminPanel;

use Bkstar123\BksCMS\AdminPanel\Role;
use Bkstar123\BksCMS\AdminPanel\Profile;
use Illuminate\Notifications\Notifiable;
use Bkstar123\MySqlSearch\Traits\MySqlSearch;
use Bkstar123\BksCMS\AdminPanel\Traits\Authorizable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Bkstar123\BksCMS\AdminPanel\Notifications\ResetPassword as ResetPasswordNotification;
use Bkstar123\BksCMS\AdminPanel\Notifications\ResetPasswordWithQueuing as ResetPasswordNotificationWithQueuing;

class Admin extends Authenticatable
{
    use Notifiable, MySqlSearch, Authorizable;

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
        config('bkstar123_bkscms_adminpanel.useQueue') ?
            $this->notify(new ResetPasswordNotificationWithQueuing($token)) :
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

    /**
     * The roles that belong to the admin
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'admin_role');
    }

    /**
     * Scope a query to only include active admins.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', static::ACTIVE);
    }

    /**
     * Route notifications for the Slack channel.
     *
     * @return string
     */
    public function routeNotificationForSlack()
    {
        return $this->profile->slack_webhook_url ?? null;
    }

    /**
     * Get admin avatar - return either default or custom avatar
     *
     * @return string
     */
    public function getAvatar()
    {
        $hasCustomAvatar = isset($this->profile->avatar_url) && !empty($this->profile->avatar_url);
        return [
            'custom' => $hasCustomAvatar,
            'avatar_url' => $hasCustomAvatar ? $this->profile->avatar_url : '/cms-assets/img/default-avatar-160x160.jpg',
            'avatar_path' => $this->profile->avatar_path ?? '',
            'avatar_disk' => $this->profile->avatar_disk ?? ''
        ];
    }

    /**
     * Get all available roles & assigned roles for the given admin
     *
     * @return array
     */
    public function getRoles()
    {
        $assignedRoles = $this->roles()->enabled()->get()->pluck('role', 'id')->toArray();
        $allRoles = Role::enabled()->get()->pluck('role', 'id')->toArray();
        $currentAdmin = auth()->guard('admins')->user();
        if (!$currentAdmin->hasRole(Role::SUPERADMINS)) {
            unset($allRoles[Role::SUPERADMINS]);
            if (!$currentAdmin->hasRole(Role::ADMINISTRATORS)) {
                unset($allRoles[Role::ADMINISTRATORS]);
            }
        }
        $availableRoles = array_diff($allRoles, $assignedRoles);
        return [
            'available' => $availableRoles,
            'assigned' => $assignedRoles
        ];
    }
}
