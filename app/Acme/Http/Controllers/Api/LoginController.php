<?php

namespace Acme\Http\Controllers\Api;

use JWTAuth;
use JWAuthException;
use Illuminate\Http\Request;

class LoginController extends ApiController
{

    /**
     * @SWG\Post(
     *   path="/login",
     *   summary="Login a user",
     *   tags={"Login"},
     *   operationId="loginUser",
     *   consumes={"multipart/form-data"},
     *   produces={"application/json"},
     * @SWG\Parameter(
     *     name="email",
     *     in="formData",
     *     description="This will serve as username",
     *     required=true,
     *     type="string"
     *   ),
     * @SWG\Parameter(
     *     name="password",
     *     in="formData",
     *     description="The user's password",
     *     required=true,
     *     type="string"
     *   ),
     * @SWG\Response(response=200, description="successful operation", @SWG\Schema(type="string")),
     * @SWG\Response(response=403, description="cannot authenticate"),
     * @SWG\Response(response=500, description="internal server error")
     * )
     */

    public function __invoke(Request $request)
    {
        $token = null;

        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'result' => 'error',
                    'message' => 'invalid_credentials'
                ], 401);
            }
        } catch (JWAuthException $e) {
            return response()->json([
                'result' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }


        return response()->json([
            'result' => 'success',
            'token' => $token
        ], 200);

        return $credentials;
    }
}
