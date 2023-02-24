<?php

namespace LaraPress\Support\Facades;

use LaraPress\Contracts\Routing\ResponseFactory as ResponseFactoryContract;

/**
 * @method static \LaraPress\Http\JsonResponse json(string|array $data = [], int $status = 200, array $headers = [], int $options = 0)
 * @method static \LaraPress\Http\JsonResponse jsonp(string $callback, string|array $data = [], int $status = 200, array $headers = [], int $options = 0)
 * @method static \LaraPress\Http\RedirectResponse redirectGuest(string $path, int $status = 302, array $headers = [], bool|null $secure = null)
 * @method static \LaraPress\Http\RedirectResponse redirectTo(string $path, int $status = 302, array $headers = [], bool|null $secure = null)
 * @method static \LaraPress\Http\RedirectResponse redirectToAction(string $action, mixed $parameters = [], int $status = 302, array $headers = [])
 * @method static \LaraPress\Http\RedirectResponse redirectToIntended(string $default = '/', int $status = 302, array $headers = [], bool|null $secure = null)
 * @method static \LaraPress\Http\RedirectResponse redirectToRoute(string $route, mixed $parameters = [], int $status = 302, array $headers = [])
 * @method static \LaraPress\Http\Response make(array|string $content = '', int $status = 200, array $headers = [])
 * @method static \LaraPress\Http\Response noContent($status = 204, array $headers = [])
 * @method static \LaraPress\Http\Response view(string $view, array $data = [], int $status = 200, array $headers = [])
 * @method static \Symfony\Component\HttpFoundation\BinaryFileResponse download(\SplFileInfo|string $file, string|null $name = null, array $headers = [], string|null $disposition = 'attachment')
 * @method static \Symfony\Component\HttpFoundation\BinaryFileResponse file($file, array $headers = [])
 * @method static \Symfony\Component\HttpFoundation\StreamedResponse stream(\Closure $callback, int $status = 200, array $headers = [])
 * @method static \Symfony\Component\HttpFoundation\StreamedResponse streamDownload(\Closure $callback, string|null $name = null, array $headers = [], string|null $disposition = 'attachment')
 *
 * @see \LaraPress\Contracts\Routing\ResponseFactory
 */
class Response extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return ResponseFactoryContract::class;
    }
}
