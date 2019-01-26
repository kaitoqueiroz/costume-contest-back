<?php

namespace App\Api\V1\Controllers;

use Config;
use DB;
use App\User;
use App\UserCostume;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Controllers\Controller;
use App\Api\V1\Requests\SignUpRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SignUpController extends Controller
{
    public function signUp(SignUpRequest $request, JWTAuth $JWTAuth)
    {
        $user = new User($request->all());

        DB::beginTransaction();

        try{
            $user->save();
            $costume = new UserCostume();
            User::find($user->id)->costume()->save($costume);
        }
        catch(\Exception $e)
        {
           DB::rollback();
           throw $e;
        }

        DB::commit();

        if(!Config::get('boilerplate.sign_up.release_token')) {
            return response()->json([
                'status' => 'ok'
            ], 200);
        }

        $token = $JWTAuth->fromUser($user);
        return response()->json([
            'status' => 'ok',
            'token' => $token
        ], 200);
    }
}
