<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\Api\UserRequest;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index()
    {
        try	{
            //@var \App\Models\User
            $oUsers = User::with('accounts')->get();

            if($oUsers->count() > 0)
                return UserResource::collection($oUsers);
            else
                return response()->json(['message' => 'No se encontraron registros'], Response::HTTP_NO_CONTENT);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function roles()
    {
        try	{
            $aData = array('admin', 'user');

            return response()->json([
                'success' => true,
                'message' => 'Successful',
                'errors' => [],
                'data' => $aData,
            ], Response::HTTP_OK);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function permissions()
    {
        try	{
            $aData = array('user_create', 'user_edit', 'user_show', 'user_delete', 'user_access', 'company_create', 'company_edit', 'company_show', 'company_delete', 'company_access');

            //return response()->json($aData, Response::HTTP_OK);

            return response()->json([
                'success' => true,
                'message' => 'Successful',
                'errors' => [],
                'data' => $aData,
            ], Response::HTTP_OK);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $success = true;
        DB::beginTransaction();

        try	{
            $data = $request->validate([
                'accounts' => 'required',
                'name' => 'required|string',
                'email' => 'required|email|string|unique:users,email',
                'password' => [
                    'required',
                    'confirmed',
                    Password::min(8)->mixedCase()->numbers()->symbols()
                ]
            ]);

            //@var \App\Models\User $user
            $oUser = User::create([
                                    "name" => (($data['name']) ? $data['name'] : null),
                                    "email" => (($data['email']) ? $data['email'] : null),
                                    "password" => bcrypt($data['password']),
                                    "active" => (($request->active) ? $request->active : false)
                                ])->load('accounts');

            $oUser->accounts()->attach($data['accounts']);

        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if ($success === true) {
            DB::commit();

            return response()->json([
                'message' => __('api.messages.added')
            ], Response::HTTP_OK);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try	{
            //@var \App\Models\User
            $oUser = User::findOrFail($id);

            if($oUser !== null)
                return new UserResource($oUser);
            else
                return response()->json(['message' => 'No se encontraron registros'], Response::HTTP_NO_CONTENT);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($nId = FALSE, UserRequest $request)
    {
        $success = true;
        DB::beginTransaction();

        try	{
            /*
            $data = $request->validate([
                'name' => 'required|string',
                'email' => 'required',
                'parent_id' => 'nullable|int',
                'password' => [
                    'required',
                    'confirmed',
                    Password::min(8)->mixedCase()->numbers()->symbols()
                ]
            ]);
            */

            //@var \App\Models\User
            //$oUser = User::findOrFail(auth()->user()->id);
            $oUser = User::findOrFail($nId);

            $oUser->update([
                "name" => (($request->name) ? $request->name : null),
                "email" => (($request->email) ? $request->email : null),
                "password" => bcrypt($request->password),
                "active" => (($request->active) ? $request->active : false)
            ]);

        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if ($success === true) {
            DB::commit();

            return response()->json([
                'message' => __('api.messages.updated')
            ], Response::HTTP_OK);
        }
    }
}
