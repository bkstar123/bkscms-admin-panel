<?php
/**
 * Permission Eloquent Model
 *
 * @author: tuanha
 * @last-mod: 20-Oct-2019
 */
namespace Bkstar123\BksCMS\AdminPanel;

use Bkstar123\BksCMS\AdminPanel\Role;
use Illuminate\Database\Eloquent\Model;
use Bkstar123\MySqlSearch\Traits\MySqlSearch;

class Permission extends Model
{
    use MySqlSearch;

    const ENABLED = true;

    const DISABLED = false;

    /**
     * List of columns for search enabling
     *
     * @var array
     */
    public static $mysqlSearchable = ['permission', 'description', 'alias'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'permission', 'description', 'alias',
    ];

    /**
     * The roles that own the permission
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Scope a query to only include enabled roles.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEnabled($query)
    {
        return $query->where('status', static::ENABLED);
    }
}
