<?php

namespace App\Http\Controllers\Api;

use DB;
use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index()
    {
        try	{
            //@var \App\Models\User
            $oUsers = User::whereRole('leader')
                            ->get();

            return response()->json($oUsers, 200);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function listCompanies()
    {
        try	{
            //@var \App\Models\User
            $oUsers = User::whereRole('company')
                        ->get();

            return response()->json($oUsers, 200);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function listCompaniesUsers($user_id = false)
    {
        try	{
            //@var \App\Models\User
            $oUsers = User::where('parent_id', $user_id)
                        ->where('role', 'usercompany')
                        ->get();

            return response()->json($oUsers, 200);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
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
                'name' => 'required|string',
                'email' => 'required|email|string|unique:users,email',
                'role' => 'required',
                'parent_id' => 'nullable|int',
                'password' => [
                    'required',
                    'confirmed',
                    Password::min(8)->mixedCase()->numbers()->symbols()
                ]
            ]);

            //@var \App\Models\User $user
            $oUser = User::create([
                                    'role' => $data['role'],
                                    'name' => $data['name'],
                                    'email' => $data['email'],
                                    'password' => bcrypt($data['password']),
                                    'parent_id' => (isset($data['parent_id'])) ? $data['parent_id'] : null,
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
                'result' => $oUser,
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
    public function show($id)
    {
        try	{
            //@var \App\Models\User
            $oUser = User::findOrFail($id);

            return response()->json($oUser, 200);

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
    public function update(Request $request, $id)
    {
        $success = true;
        DB::beginTransaction();

        try	{
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

            //@var \App\Models\User
            $oUser = User::findOrFail($id);

            $oUser->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'parent_id' => (isset($data['parent_id'])) ? $data['parent_id'] : null,
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
                'result' => $oUser,
                'message' => 'Registro editado correctamente',
            ], 200);
        }
    }
}
