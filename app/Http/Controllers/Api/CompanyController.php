<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;

use Exception;
use App\Models\Api\Company;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserRequest;

class CompanyController extends Controller
{
    public function index()
    {
        try	{
            //@var \App\Models\Company
            $oCompanies = Company::get();

            if($oCompanies->count() > 0)
                return response()->json($oCompanies, 200);
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
            //@var \App\Models\Company
            $oCompanies = Company::get();

            if($oCompanies->count() > 0)
                return response()->json($oCompanies, 200);
            else
                return response()->json(['message' => 'No se encontraron registros'], 404);

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
            ]);

            //@var \App\Models\Company $user
            $oCompany = Company::create([
                                    'name' => $data['name'],
                                    'email' => $data['email'],
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
                'data' => $oCompany,
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
    public function show($nId = FALSE)
    {
        try	{
            //@var \App\Models\Company
            $oCompany = Company::findOrFail($nId);

            if($oCompany !== null)
                return response()->json($oCompany, 200);
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
                'user_id' => 'nullable|int',
                'password' => [
                    'required',
                    'confirmed',
                    Password::min(8)->mixedCase()->numbers()->symbols()
                ]
            ]);
            */

            //@var \App\Models\Company
            //$oCompany = Company::findOrFail(auth()->user()->id);
            $oCompany = Company::findOrFail($nId);

            $oCompany->update([
                'name' => $request->name,
                'email' => $request->email,
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
                'data' => $oCompany,
                'message' => 'Registro editado correctamente',
            ], 200);
        }
    }
}
