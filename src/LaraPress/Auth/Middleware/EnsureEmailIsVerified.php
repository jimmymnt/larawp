<?php

namespace LaraPress\Auth\Middleware;

use Closure;
use LaraPress\Contracts\Auth\MustVerifyEmail;
use LaraPress\Support\Facades\Redirect;
use LaraPress\Support\Facades\URL;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param \LaraPress\Http\Request $request
     * @param \Closure $next
     * @param string|null $redirectToRoute
     * @return \LaraPress\Http\Response|\LaraPress\Http\RedirectResponse|null
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
