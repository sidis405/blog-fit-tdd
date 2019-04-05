<?php

namespace Acme\Http\Controllers\Api;

use JWTAuth;
use Illuminate\Http\Request;

class MeController extends ApiController
{
    public function __invoke(Request $request)
    {
        $token = $request->token;

        $user = JWTAuth::toUser($token);

        return response()->json([
            'result' => 'success',
            'user' => $user,
        ]);
    }
}
