<?php
/**
 * ResetPasswordWithQueuing Notification
 *
 * @author: tuanha
 * @last-mod: 10-Nov-2019
 */
namespace Bkstar123\BksCMS\AdminPanel\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Bkstar123\BksCMS\AdminPanel\Notifications\ResetPassword;

class ResetPasswordWithQueuing extends ResetPassword implements ShouldQueue
{
    use Queueable;
}
