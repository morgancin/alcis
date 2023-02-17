<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Api\Prospect;
use App\Models\Api\Activity;
use Illuminate\Http\Request;
use App\Models\Api\ProspectAddress;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ProspectRequest;
use App\Http\Requests\Api\ProspectActivityRequest;

class ProspectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            //@var \App\Models\Api\Prospect
            $oProspects = new Prospect;

            if($request->query('account_id')) {
                $oProspects = $oProspects->where('account_id', $request->query('account_id'));
            }

            $oProspects = $oProspects->get();

            if ($oProspects->count() > 0)
                return response()->json($oProspects, 200);
            else
                return response()->json(['message' => __('api.messages.notfound')], 404);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*
    public function list_contacts_companies()
    {
        try {
            //@var \App\Models\Api\Prospect
            $oProspects = Prospect::where('user_id', auth()->user()->id)
                                //->whereNotNull('client_id')
                                ->whereType('company')
                                ->get();

            if ($oProspects->count() > 0)
                return response()->json($oProspects, 200);
            else
                return response()->json(['message' => __('api.messages.notfound')], 404);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProspectRequest $request)
    {
        $success = true;
        DB::beginTransaction();

        try {
            //@var \App\Models\Api\Prospect
            Prospect::create([
                "rfc" => $request->rfc,
                "age" => $request->age,
                "type" => $request->type,
                "curp" => $request->curp,
                "email" => $request->email,
                "gender" => $request->gender,
                "last_name" => $request->last_name,
                "extension" => $request->extension,
                "first_name" => $request->first_name,
                "birth_date" => $request->birth_date,
                "phone_home" => $request->phone_home,
                "profession" => $request->profession,
                "account_id" => $request->account_id,
                "birth_place" => $request->birth_place,
                "phone_office" => $request->phone_office,
                "phone_mobile" => $request->phone_mobile,
                "second_last_name" => $request->second_last_name,
                "service_priority" => $request->service_priority,
                "prospecting_mean_id" => $request->prospecting_mean_id
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
    public function store_prospect_and_activity(ProspectActivityRequest $request)
    {
        $success = true;
        DB::beginTransaction();

        try {
            //@var \App\Models\Api\Prospect
            $oProspect = Prospect::create([
                            "rfc" => $request->rfc,
                            "age" => $request->age,
                            "type" => $request->type,
                            "curp" => $request->curp,
                            "email" => $request->email,
                            "gender" => $request->gender,
                            "last_name" => $request->last_name,
                            "extension" => $request->extension,
                            "first_name" => $request->first_name,
                            "birth_date" => $request->birth_date,
                            "phone_home" => $request->phone_home,
                            "profession" => $request->profession,
                            "account_id" => $request->account_id,
                            "birth_place" => $request->birth_place,
                            "phone_office" => $request->phone_office,
                            "phone_mobile" => $request->phone_mobile,
                            "second_last_name" => $request->second_last_name,
                            "service_priority" => $request->service_priority,
                            "prospecting_mean_id" => $request->prospecting_mean_id
                        ]);

            if ($request->has('zipcode') && $request->has('city'))
            {
                $oProspectAddress = ProspectAddress::create([
                    "prospect_id" => $oProspect->id,
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
                "prospect_id" => $oProspect->id,
                "comments" => $request->comments,
                "activity_date" => date("Y-m-d"),
                "start_time" => $request->start_time,
                "start_date" => $request->start_date,
                "account_id" => $request->account_id,
                "activity_subject_id" => $request->activity_subject_id,
                //"end_date" => $request->end_date,
                //"end_time" => $request->end_time,
                //"activity_date" => $request->activity_date,
                //"activity_type_id" => $request->activity_type_id,
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
            //@var \App\Models\Api\Prospect
            $oProspect = Prospect::findOrFail($id);

            if ($oProspect !== null)
                return response()->json($oProspect, 200);
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
    public function update(ProspectRequest $request, $id)
    {
        $success = true;
        DB::beginTransaction();

        try {
            //@var \App\Models\Api\Prospect
            $oProspect = Prospect::findOrFail($id);

            $oProspect->update([
                "age" => $request->age,
                "rfc" => $request->rfc,
                "type" => $request->type,
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
                "prospecting_mean_id" => $request->prospecting_mean_id,
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
