<?php

namespace LaraWP\Broadcasting;

use LaraWP\Http\Request;
use LaraWP\Routing\Controller;
use LaraWP\Support\Facades\Broadcast;

class BroadcastController extends Controller
{
    /**
     * Authenticate the request for channel access.
     *
     * @param \LaraWP\Http\Request $request
     * @return \LaraWP\Http\Response
     */
    public function authenticate(Request $request)
    {
        if ($request->hasSession()) {
            $request->session()->reflash();
        }

        return Broadcast::auth($request);
    }
}
