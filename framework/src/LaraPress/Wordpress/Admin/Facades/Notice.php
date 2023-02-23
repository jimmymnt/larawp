<?php

namespace LaraPress\Wordpress\Admin\Facades;

use LaraPress\Support\Facades\Facade;

/**
 * @method static \LaraPress\Wordpress\Admin\Notice\Message notify($message, $type)
 *
 * @method static \LaraPress\Wordpress\Admin\Notice\Message error($message)
 * @method static \LaraPress\Wordpress\Admin\Notice\Message warning($message)
 * @method static \LaraPress\Wordpress\Admin\Notice\Message success($message)
 * @method static \LaraPress\Wordpress\Admin\Notice\Message info($message)
 *
 * @method static \LaraPress\Wordpress\Admin\Notice\NoticeManager addNotice(\LaraPress\Wordpress\Admin\Notice\Message $notice)
 */
class Notice extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'wp.admin.notice';
    }
}