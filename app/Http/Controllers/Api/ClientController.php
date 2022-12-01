<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Api\Client;
use App\Models\Api\Activity;
use Illuminate\Http\Request;
use App\Models\Api\ClientAddress;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ClientRequest;
use App\Http\Requests\Api\ClientActivityRequest;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            //@var \App\Models\Api\Client
            $oClients = Client::where('user_id', auth()->user()->id)
                ->get();

            if ($oClients->count() > 0)
                return response()->json($oClients, 200);
            else
                return response()->json(['message' => __('api.messages.notfound')], 404);

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

        try {
            //@var \App\Models\Api\Client
            Client::create([
                //"user_id" => auth()->user()->id,
                "rfc" => $request->rfc,
                "age" => $request->age,
                "curp" => $request->curp,
                "email" => $request->email,
                "gender" => $request->gender,
                "last_name" => $request->last_name,
                "extension" => $request->extension,
                "first_name" => $request->first_name,
                "birth_date" => $request->birth_date,
                "phone_home" => $request->phone_home,
                "profession" => $request->profession,
                "birth_place" => $request->birth_place,
                "phone_office" => $request->phone_office,
                "phone_mobile" => $request->phone_mobile,
                "second_last_name" => $request->second_last_name,
                "service_priority" => $request->service_priority,
                "client_medium_origin_id" => $request->client_medium_origin_id
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
                'message' => __('api.messages.added')
            ], 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //Create Store ClientActivity
    public function store_client_activity(ClientActivityRequest $request)
    {
        $success = true;
        DB::beginTransaction();

        try {
            //@var \App\Models\Api\Client
            $oClient = Client::create([
                            "rfc" => $request->rfc,
                            "age" => $request->age,
                            "curp" => $request->curp,
                            "email" => $request->email,
                            "gender" => $request->gender,
                            "last_name" => $request->last_name,
                            "extension" => $request->extension,
                            "first_name" => $request->first_name,
                            "birth_date" => $request->birth_date,
                            "phone_home" => $request->phone_home,
                            "profession" => $request->profession,
                            "birth_place" => $request->birth_place,
                            "phone_office" => $request->phone_office,
                            "phone_mobile" => $request->phone_mobile,
                            "second_last_name" => $request->second_last_name,
                            "service_priority" => $request->service_priority,
                            "client_medium_origin_id" => $request->client_medium_origin_id
                        ]);

            if ($request->has('zipcode') && $request->has('city'))
            {
                $oClientAddress = ClientAddress::create([
                    "client_id" => $oClient->id,
                    "city" => ($request->city) ? $request->city : null,
                    "town" => ($request->town) ? $request->town : null,
                    "state" => ($request->state) ? $request->state : null,
                    "alias" => ($request->alias) ? $request->alias : null,
                    "street" => ($request->street) ? $request->street : null,
                    "indoor" => ($request->indoor) ? $request->indoor : null,
                    "suburb" => ($request->suburb) ? $request->suburb : null,
                    "outdoor" => ($request->outdoor) ? $request->outdoor : null,
                    "country" => ($request->country) ? $request->country : null,
                    "zipcode" => ($request->zipcode) ? $request->zipcode : null,
                ]);
            }

            $oActivity = Activity::create([
                "client_id" => $oClient->id,
                "comments" => $request->comments,
                "end_date" => $request->end_date,
                "end_time" => $request->end_time,
                "start_time" => $request->start_time,
                "start_date" => $request->start_date,
                "activity_date" => $request->activity_date,
                "activity_type_id" => $request->activity_type_id,
                "activity_subject_id" => $request->activity_subject_id,
            ]);

            ///SE PROGRAMA EJECUTA CRONJOB

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }

        if ($success === true) {
            DB::commit();

            return response()->json([
                'message' => __('api.messages.added')
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
        try {
            //@var \App\Models\Api\Client
            $oClient = Client::findOrFail($id);

            if ($oClient !== null)
                return response()->json($oClient, 200);
            else
                return response()->json(['message' => __('api.messages.notfound')], 404);

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
    public function update(ClientRequest $request, $id)
    {
        $success = true;
        DB::beginTransaction();

        try {
            //@var \App\Models\Api\Client
            $oClient = Client::findOrFail($id);

            $oClient->update([
                //"user_id" => auth()->user()->id,

                "age" => $request->age,
                "rfc" => $request->rfc,
                "curp" => $request->curp,
                "email" => $request->email,
                "gender" => $request->gender,
                "extension" => $request->extension,
                "last_name" => $request->last_name,
                "first_name" => $request->first_name,
                "birth_date" => $request->birth_date,
                "phone_home" => $request->phone_home,
                "profession" => $request->profession,
                "birth_place" => $request->birth_place,
                "phone_office" => $request->phone_office,
                "phone_mobile" => $request->phone_mobile,
                "second_last_name" => $request->second_last_name,
                "service_priority" => $request->service_priority,
                "client_medium_origin_id" => $request->client_medium_origin_id,
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
                'message' => __('api.messages.updated')
            ], 200);
        }
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
