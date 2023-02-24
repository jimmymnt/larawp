<?php

namespace LaraWP\Support\Facades;

use LaraWP\Http\Client\Factory;

/**
 * @method static \GuzzleHttp\Promise\PromiseInterface response($body = null, $status = 200, $headers = [])
 * @method static \LaraWP\Http\Client\Factory fake($callback = null)
 * @method static \LaraWP\Http\Client\PendingRequest accept(string $contentType)
 * @method static \LaraWP\Http\Client\PendingRequest acceptJson()
 * @method static \LaraWP\Http\Client\PendingRequest asForm()
 * @method static \LaraWP\Http\Client\PendingRequest asJson()
 * @method static \LaraWP\Http\Client\PendingRequest asMultipart()
 * @method static \LaraWP\Http\Client\PendingRequest async()
 * @method static \LaraWP\Http\Client\PendingRequest attach(string|array $name, string $contents = '', string|null $filename = null, array $headers = [])
 * @method static \LaraWP\Http\Client\PendingRequest baseUrl(string $url)
 * @method static \LaraWP\Http\Client\PendingRequest beforeSending(callable $callback)
 * @method static \LaraWP\Http\Client\PendingRequest bodyFormat(string $format)
 * @method static \LaraWP\Http\Client\PendingRequest contentType(string $contentType)
 * @method static \LaraWP\Http\Client\PendingRequest dd()
 * @method static \LaraWP\Http\Client\PendingRequest dump()
 * @method static \LaraWP\Http\Client\PendingRequest retry(int $times, int $sleep = 0, ?callable $when = null)
 * @method static \LaraWP\Http\Client\PendingRequest sink(string|resource $to)
 * @method static \LaraWP\Http\Client\PendingRequest stub(callable $callback)
 * @method static \LaraWP\Http\Client\PendingRequest timeout(int $seconds)
 * @method static \LaraWP\Http\Client\PendingRequest withBasicAuth(string $username, string $password)
 * @method static \LaraWP\Http\Client\PendingRequest withBody(resource|string $content, string $contentType)
 * @method static \LaraWP\Http\Client\PendingRequest withCookies(array $cookies, string $domain)
 * @method static \LaraWP\Http\Client\PendingRequest withDigestAuth(string $username, string $password)
 * @method static \LaraWP\Http\Client\PendingRequest withHeaders(array $headers)
 * @method static \LaraWP\Http\Client\PendingRequest withMiddleware(callable $middleware)
 * @method static \LaraWP\Http\Client\PendingRequest withOptions(array $options)
 * @method static \LaraWP\Http\Client\PendingRequest withToken(string $token, string $type = 'Bearer')
 * @method static \LaraWP\Http\Client\PendingRequest withUserAgent(string $userAgent)
 * @method static \LaraWP\Http\Client\PendingRequest withoutRedirecting()
 * @method static \LaraWP\Http\Client\PendingRequest withoutVerifying()
 * @method static array pool(callable $callback)
 * @method static \LaraWP\Http\Client\Response delete(string $url, array $data = [])
 * @method static \LaraWP\Http\Client\Response get(string $url, array|string|null $query = null)
 * @method static \LaraWP\Http\Client\Response head(string $url, array|string|null $query = null)
 * @method static \LaraWP\Http\Client\Response patch(string $url, array $data = [])
 * @method static \LaraWP\Http\Client\Response post(string $url, array $data = [])
 * @method static \LaraWP\Http\Client\Response put(string $url, array $data = [])
 * @method static \LaraWP\Http\Client\Response send(string $method, string $url, array $options = [])
 * @method static \LaraWP\Http\Client\ResponseSequence fakeSequence(string $urlPattern = '*')
 * @method static void assertSent(callable $callback)
 * @method static void assertSentInOrder(array $callbacks)
 * @method static void assertNotSent(callable $callback)
 * @method static void assertNothingSent()
 * @method static void assertSentCount(int $count)
 * @method static void assertSequencesAreEmpty()
 *
 * @see \LaraWP\Http\Client\Factory
 */
class Http extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Factory::class;
    }
}
