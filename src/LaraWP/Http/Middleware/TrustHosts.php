<?php

namespace LaraWP\Http\Middleware;

use LaraWP\Contracts\Foundation\Application;
use LaraWP\Http\Request;

abstract class TrustHosts
{
    /**
     * The application instance.
     *
     * @var \LaraWP\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * Create a new middleware instance.
     *
     * @param \LaraWP\Contracts\Foundation\Application $app
     * @return void
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Get the host patterns that should be trusted.
     *
     * @return array
     */
    abstract public function hosts();

    /**
     * Handle the incoming request.
     *
     * @param \LaraWP\Http\Request $request
     * @param callable $next
     * @return \LaraWP\Http\Response
     */
    public function handle(Request $request, $next)
    {
        if ($this->shouldSpecifyTrustedHosts()) {
            Request::setTrustedHosts(array_filter($this->hosts()));
        }

        return $next($request);
    }

    /**
     * Determine if the application should specify trusted hosts.
     *
     * @return bool
     */
    protected function shouldSpecifyTrustedHosts()
    {
        return lp_config('app.env') !== 'local' &&
            !$this->app->runningUnitTests();
    }

    /**
     * Get a regular expression matching the application URL and all of its subdomains.
     *
     * @return string|null
     */
    protected function allSubdomainsOfApplicationUrl()
    {
        if ($host = parse_url($this->app['config']->get('app.url'), PHP_URL_HOST)) {
            return '^(.+\.)?' . preg_quote($host) . '$';
        }
    }
}
