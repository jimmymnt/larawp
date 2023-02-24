<?php

namespace LaraPress\Session\Middleware;

use Closure;
use LaraPress\Auth\AuthenticationException;
use LaraPress\Contracts\Auth\Factory as AuthFactory;

class AuthenticateSession
{
    /**
     * The authentication factory implementation.
     *
     * @var \LaraPress\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param \LaraPress\Contracts\Auth\Factory $auth
     * @return void
     */
    public function __construct(AuthFactory $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param \LaraPress\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->hasSession() || !$request->user()) {
            return $next($request);
        }

        if ($this->guard()->viaRemember()) {
            $passwordHash = explode('|', $request->cookies->get($this->auth->getRecallerName()))[2] ?? null;

            if (!$passwordHash || $passwordHash != $request->user()->getAuthPassword()) {
                $this->logout($request);
            }
        }

        if (!$request->session()->has('password_hash_' . $this->auth->getDefaultDriver())) {
            $this->storePasswordHashInSession($request);
        }

        if ($request->session()->get('password_hash_' . $this->auth->getDefaultDriver()) !== $request->user()->getAuthPassword()) {
            $this->logout($request);
        }

        return lp_tap($next($request), function () use ($request) {
            if (!is_null($this->guard()->user())) {
                $this->storePasswordHashInSession($request);
            }
        });
    }

    /**
     * Store the user's current password hash in the session.
     *
     * @param \LaraPress\Http\Request $request
     * @return void
     */
    protected function storePasswordHashInSession($request)
    {
        if (!$request->user()) {
            return;
        }

        $request->session()->put([
            'password_hash_' . $this->auth->getDefaultDriver() => $request->user()->getAuthPassword(),
        ]);
    }

    /**
     * Log the user out of the application.
     *
     * @param \LaraPress\Http\Request $request
     * @return void
     *
     * @throws \LaraPress\Auth\AuthenticationException
     */
    protected function logout($request)
    {
        $this->guard()->logoutCurrentDevice();

        $request->session()->flush();

        throw new AuthenticationException('Unauthenticated.', [$this->auth->getDefaultDriver()]);
    }

    /**
     * Get the guard instance that should be used by the middleware.
     *
     * @return \LaraPress\Contracts\Auth\Factory|\LaraPress\Contracts\Auth\Guard
     */
    protected function guard()
    {
        return $this->auth;
    }
}
