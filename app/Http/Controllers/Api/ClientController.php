<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Api\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ClientRequest;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id = false)
    {
        try	{
            //@var \App\Models\Client
            $oClients = Client::where('user_id', $user_id)
                            ->get();

            return response()->json($oClients, 200);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request)
    {
        $success = true;
        DB::beginTransaction();

        try	{
            //@var \App\Models\Client
            Client::create([
                "rfc" => $request->rfc,
                "age" => $request->age,
                "curp" => $request->curp,
                "city" => $request->city,
                "email" => $request->email,
                "state" => $request->state,
                "gender" => $request->gender,
                "user_id" => $request->user_id,
                "lastname" => $request->lastname,
                "firstname" => $request->firstname,
                "extension" => $request->extension,
                "homephone" => $request->homephone,
                "profession" => $request->profession,
                "officephone" => $request->officephone,
                "mobilephone" => $request->mobilephone,
                "servicepriority" => $request->servicepriority,
                "prospectingorigin" => $request->prospectingorigin,
                "prospectingmedium" => $request->prospectingmedium,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }

        if ($success === true) {
            DB::commit();

            return response()->json([
                'message' => 'Registro insertado correctamente'
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
