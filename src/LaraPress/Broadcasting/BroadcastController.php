<?php

namespace LaraPress\Broadcasting;

use LaraPress\Http\Request;
use LaraPress\Routing\Controller;
use LaraPress\Support\Facades\Broadcast;

class BroadcastController extends Controller
{
    /**
     * Authenticate the request for channel access.
     *
     * @param \LaraPress\Http\Request $request
     * @return \LaraPress\Http\Response
     */
    public function authenticate(Request $request)
    {
        if ($request->hasSession()) {
            $request->session()->reflash();
        }

        return Broadcast::auth($request);
    }
}
