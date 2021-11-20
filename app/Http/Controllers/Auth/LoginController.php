<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(LoginRequest $request)
    {
        $user = User::whereEmail($request->email)->first();

        if (!$user || !Hash::check($request->password,$user->password))
        {
            return response('Credentials not matched!',Response::HTTP_UNAUTHORIZED);
        }

        $token = $user->createToken('api');

        return response(
            [
                'token' => $token->plainTextToken
            ]
        );
    }
}
