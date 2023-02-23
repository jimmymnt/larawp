<?php

namespace LaraPress\Routing\Middleware;

use Closure;
use LaraPress\Routing\Exceptions\InvalidSignatureException;

class ValidateSignature
{
    /**
     * Handle an incoming request.
     *
     * @param \LaraPress\Http\Request $request
     * @param \Closure $next
     * @param string|null $relative
     * @return \LaraPress\Http\Response
     *
     * @throws \LaraPress\Routing\Exceptions\InvalidSignatureException
     */
    public function handle($request, Closure $next, $relative = null)
    {
        if ($request->hasValidSignature($relative !== 'relative')) {
            return $next($request);
        }

        throw new InvalidSignatureException;
    }
}
