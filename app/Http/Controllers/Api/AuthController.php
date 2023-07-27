<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Api\LoginRequest;

class AuthController extends Controller
{
    //public function login(Request $request)
    public function login(LoginRequest $request)
    {
        $credentials = $request->all();

        $remember = $credentials['remember'] ?? false;
        unset($credentials['remember']);

        if (!Auth::attempt($credentials, $remember)) {
            return response()->json([
                'error' => __('api.messages.controller.auth.error')
            ], 422);
        }
        $user = Auth::user();
        //$user->profile = $user->profile;
        $user['token'] = $user->createToken('main')->plainTextToken;
        $user['parents'] = $this->getRecursive($user->user_id);

        /////
        /*
        $start_time = microtime(true);
        if($this->getRecursive($user->user_id))
        {
            $end_time = microtime(true);
            $duration = $end_time - $start_time;

            echo " duration = ".$duration;
        }
        */
        ///////

        return response()->json([
            //'user' => $user,
            //'token' => $token
            'success' => true,
            'message' => 'Login Successful',
            'errors' => [],
            'data' => $user,
        ], Response::HTTP_OK);

        //return new UserResource($user);
    }

    public function logout()
    {
        /** @var User $user */
        $user = Auth::user();
        // Revoke the token that was used to authenticate the current request...
        $user->currentAccessToken()->delete();

        return response()->json([
            'success' => true
        ], Response::HTTP_OK);
    }

    // $this->getRecursive($user->user_id); //Así se invoca
    private function getRecursive($parent)
    {
        $oUsers = User::all();

        $result = [];
        foreach ($oUsers as $user) {
            if ($parent == $user->user_id)
            {
                $result[] = [
                            'id' => $user->id,
                            'name' => $user->name,
                            'childs' => $this->getRecursive($user->id)
                        ];
                    }
            }

        return $result;
    }
}
