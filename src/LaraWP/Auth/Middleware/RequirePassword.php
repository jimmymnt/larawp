<?php

namespace LaraWP\Auth\Middleware;

use Closure;
use LaraWP\Contracts\Routing\ResponseFactory;
use LaraWP\Contracts\Routing\UrlGenerator;

class RequirePassword
{
    /**
     * The response factory instance.
     *
     * @var \LaraWP\Contracts\Routing\ResponseFactory
     */
    protected $responseFactory;

    /**
     * The URL generator instance.
     *
     * @var \LaraWP\Contracts\Routing\UrlGenerator
     */
    protected $urlGenerator;

    /**
     * The password timeout.
     *
     * @var int
     */
    protected $passwordTimeout;

    /**
     * Create a new middleware instance.
     *
     * @param \LaraWP\Contracts\Routing\ResponseFactory $responseFactory
     * @param \LaraWP\Contracts\Routing\UrlGenerator $urlGenerator
     * @param int|null $passwordTimeout
     * @return void
     */
    public function __construct(ResponseFactory $responseFactory, UrlGenerator $urlGenerator, $passwordTimeout = null)
    {
        $this->responseFactory = $responseFactory;
        $this->urlGenerator = $urlGenerator;
        $this->passwordTimeout = $passwordTimeout ?: 10800;
    }

    /**
     * Handle an incoming request.
     *
     * @param \LaraWP\Http\Request $request
     * @param \Closure $next
     * @param string|null $redirectToRoute
     * @return mixed
     */
    public function handle($request, Closure $next, $redirectToRoute = null)
    {
        if ($this->shouldConfirmPassword($request)) {
            if ($request->expectsJson()) {
                return $this->responseFactory->json([
                    'message' => 'Password confirmation required.',
                ], 423);
            }

            return $this->responseFactory->redirectGuest(
                $this->urlGenerator->route($redirectToRoute ?? 'password.confirm')
            );
        }

        return $next($request);
    }

    /**
     * Determine if the confirmation timeout has expired.
     *
     * @param \LaraWP\Http\Request $request
     * @return bool
     */
    protected function shouldConfirmPassword($request)
    {
        $confirmedAt = time() - $request->session()->get('auth.password_confirmed_at', 0);

        return $confirmedAt > $this->passwordTimeout;
    }
}
