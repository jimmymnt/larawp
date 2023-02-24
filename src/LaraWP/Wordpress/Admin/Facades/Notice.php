<?php

namespace LaraWP\Wordpress\Admin\Facades;

use LaraWP\Support\Facades\Facade;

/**
 * @method static \LaraWP\Wordpress\Admin\Notice\Message notify($message, $type)
 *
 * @method static \LaraWP\Wordpress\Admin\Notice\Message error($message)
 * @method static \LaraWP\Wordpress\Admin\Notice\Message warning($message)
 * @method static \LaraWP\Wordpress\Admin\Notice\Message success($message)
 * @method static \LaraWP\Wordpress\Admin\Notice\Message info($message)
 *
 * @method static \LaraWP\Wordpress\Admin\Notice\NoticeManager addNotice(\LaraWP\Wordpress\Admin\Notice\Message $notice)
 */
class Notice extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'wp.admin.notice';
    }
}