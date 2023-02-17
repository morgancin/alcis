<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;

use Exception;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserRequest;

class UserController extends Controller
{
    public function index()
    {
        try	{
            //@var \App\Models\User
            $oUsers = User::with('accounts')->get();

            if($oUsers->count() > 0)
                return response()->json($oUsers, 200);
            else
                return response()->json(['message' => 'No se encontraron registros'], 404);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /*
    public function list_companies()
    {
        try	{
            //@var \App\Models\User
            $oUsers = User::whereRole('company')
                        ->get();

            if($oUsers->count() > 0)
                return response()->json($oUsers, 200);
            else
                return response()->json(['message' => 'No se encontraron registros'], 404);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function list_users_companies()
    {
        try	{
            //@var \App\Models\User
            $oUsers = User::where('parent_id', auth()->user()->id)
                            ->where('role', 'usercompany')
                            ->get();

            if($oUsers->count() > 0)
                return response()->json($oUsers, 200);
            else
                return response()->json(['message' => 'No se encontraron registros'], 404);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    */

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
                                    'name' => $data['name'],
                                    'email' => $data['email'],
                                    'password' => bcrypt($data['password']),
                                ]);

        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }

        if ($success === true) {
            DB::commit();

            return response()->json([
                'data' => $oUser,
                'message' => 'Registro insertado correctamente',
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        try	{
            //@var \App\Models\User
            $oUser = User::findOrFail(auth()->user()->id);

            if($oUser !== null)
                return response()->json($oUser, 200);
            else
                return response()->json(['message' => 'No se encontraron registros'], 404);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
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
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }

        if ($success === true) {
            DB::commit();

            return response()->json([
                'data' => $oUser,
                'message' => 'Registro editado correctamente',
            ], 200);
        }
    }
}
