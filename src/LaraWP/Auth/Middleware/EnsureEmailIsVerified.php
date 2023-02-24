<?php

namespace LaraWP\Auth\Middleware;

use Closure;
use LaraWP\Contracts\Auth\MustVerifyEmail;
use LaraWP\Support\Facades\Redirect;
use LaraWP\Support\Facades\URL;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param \LaraWP\Http\Request $request
     * @param \Closure $next
     * @param string|null $redirectToRoute
     * @return \LaraWP\Http\Response|\LaraWP\Http\RedirectResponse|null
     */
    public function handle($request, Closure $next, $redirectToRoute = null)
    {
        if (!$request->user() ||
            ($request->user() instanceof MustVerifyEmail &&
                !$request->user()->hasVerifiedEmail())) {
            return $request->expectsJson()
                ? lp_abort(403, 'Your email address is not verified.')
                : Redirect::guest(URL::route($redirectToRoute ?: 'verification.notice'));
        }

        return $next($request);
    }
}
