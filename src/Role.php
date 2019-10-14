<?php
/**
 * Role Eloquent Model
 *
 * @author: tuanha
 * @last-mod: 14-Oct-2019
 */
namespace Bkstar123\BksCMS\AdminPanel;

use Bkstar123\BksCMS\AdminPanel\Admin;
use Illuminate\Database\Eloquent\Model;
use Bkstar123\MySqlSearch\Traits\MySqlSearch;

class Role extends Model
{
    use MySqlSearch;

    const ENABLED = true;

    const DISABLED = false;

    /**
     * List of columns for search enabling
     *
     * @var array
     */
    public static $mysqlSearchable = ['role', 'description'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role', 'description',
    ];

    /**
     * The admins that own the role
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function admins()
    {
        return $this->belongsToMany(Admin::class);
    }

    /**
     * The permissions that belong to the role
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    // public function permissions()
    // {
    //     return $this->belongsToMany(Permission::class, 'permissions_roles');
    // }

    /**
     * Scope a query to only include enabled roles.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEnabled($query)
    {
        return $query->where('status', static::ENABLED);
    }
}