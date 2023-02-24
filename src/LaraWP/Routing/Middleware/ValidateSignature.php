<?php

namespace LaraWP\Routing\Middleware;

use Closure;
use LaraWP\Routing\Exceptions\InvalidSignatureException;

class ValidateSignature
{
    /**
     * Handle an incoming request.
     *
     * @param \LaraWP\Http\Request $request
     * @param \Closure $next
     * @param string|null $relative
     * @return \LaraWP\Http\Response
     *
     * @throws \LaraWP\Routing\Exceptions\InvalidSignatureException
     */
    public function handle($request, Closure $next, $relative = null)
    {
        if ($request->hasValidSignature($relative !== 'relative')) {
            return $next($request);
        }

        throw new InvalidSignatureException;
    }
}
