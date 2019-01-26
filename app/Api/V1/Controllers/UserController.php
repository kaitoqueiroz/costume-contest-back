<?php

namespace App\Api\V1\Controllers;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Controllers\Controller;
use App\Api\V1\Requests\LoginRequest;
use App\Api\V1\Requests\UpdateRequest;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Auth;
use DB;
use App\User;
use App\UserCostume;

class UserController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt.auth', []);
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $user = User::find(Auth::guard()->user()->id);
        $user->costume = $user->costume;
        return response()->json($user);
    }

    /**
     * Update User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request)
    {
        DB::beginTransaction();

        try{
            $user = User::find(Auth::guard()->user()->id);
            $user->name = $request->input('name');
            $user->save();
            $costume = UserCostume::where('user_id', $user->id)->first();
            if(!$costume){
                $costume = new UserCostume();
                User::find($user->id)->costume()->save($costume);
            }
            $costume->name = $request->input('costume_name');

            if($request->file('photo')){
                Storage::delete($costume->photo);
                $path = $request->file('photo', 'local')->store('');
                $costume->photo = $path ?? null;
            }
            User::find($user->id)->costume()->save($costume);
        }
        catch(\Exception $e)
        {
           DB::rollback();
           throw $e;
        }

        DB::commit();

        return response()->json([
            'status' => 'ok'
        ], 200);
    }

    /**
     * List User Ranking
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ranking()
    {
        $users = UserCostume::where('photo', '!=', null)
            ->with(['user', 'user.votes' => function($query){
                return $query->where('vote', 1);
            }])
            ->get();
        return response()->json($users, 200);
    }
}
