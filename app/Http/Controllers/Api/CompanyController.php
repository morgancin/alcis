<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Api\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserRequest;
use App\Http\Resources\CompanyResource;
use App\Http\Requests\Api\CompanyRequest;
use Illuminate\Validation\Rules\Password;

class CompanyController extends Controller
{
    public function index()
    {
        try	{
            //@var \App\Models\Company
            $oCompanies = Company::get();

            if($oCompanies->count() > 0)
                return CompanyResource::collection($oCompanies);
            else
                return response()->json(['message' => 'No se encontraron registros'], Response::HTTP_NO_CONTENT);

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
    public function store(CompanyRequest $request)
    {
        $success = true;
        DB::beginTransaction();

        try	{
            //@var \App\Models\Company $user
            $oCompany = Company::create([
                                        'name' => $request->name,
                                        'phone' =>$request->phone,
                                        'tax_id' =>$request->tax_id,
                                        'address' =>$request->address,
                                        'website' =>$request->website,
                                        'comments' =>$request->comments,
                                        'potential_value' =>$request->potential_value,
                                    ]);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if ($success === true) {
            DB::commit();

            return new CompanyResource($oCompany);

            /*
            return response()->json([
                'message' => __('api.messages.added')
            ], Response::HTTP_OK);
            */
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
                return new CompanyResource($oCompany);
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
                                'phone' =>$request->phone,
                                'tax_id' =>$request->tax_id,
                                'address' =>$request->address,
                                'website' =>$request->website,
                                'comments' =>$request->comments,
                                'potential_value' =>$request->potential_value,
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
                'data' => $oCompany,
                'message' => 'Registro editado correctamente',
            ], Response::HTTP_OK);
        }
    }
}
