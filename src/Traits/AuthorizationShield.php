<?php
/**
 * AuthorizationShield trait - use on controllers
 *
 * @author: tuanha
 * @last-mod: 20-Oct-2019
 */
namespace Bkstar123\BksCMS\AdminPanel\Traits;

use Illuminate\Support\Facades\Gate;

trait AuthorizationShield
{
    /**
     * Prevent an unauthorized admin from acting on the given resource
     *
     * @param string $ability
     * @param mixed $resource
     */
    protected function capabilityCheck($ability, $resource)
    {
        $this->authorize($ability, $resource);
    }

    /**
     * Check if the current admin can act on the given resource
     *
     * @param string $ability
     * @param mixed $resource
     * @return boolean
     */
    protected function isAllowedFor($ability, $resource)
    {
        return Gate::check($ability, $resource);
    }
}
