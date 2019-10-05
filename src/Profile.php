<?php
/**
 * @author: tuanha
 * @last-mod: 05-Oct-2019
 */
namespace Bkstar123\BksCMS\AdminPanel;

use Bkstar123\BksCMS\AdminPanel\Admin;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'avatar_url', 'avatar_path', 'avatar_disk', 'mobile', 'slack_webhook_url'
    ];

    /**
     * A profile belongs to an admin
     *
     * @return @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
