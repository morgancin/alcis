<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Api\Prospect,
    App\Models\Api\Activity,
    App\Models\Api\Pipeline,
    App\Models\Api\ProspectAddress;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ProspectRequest;
use App\Http\Requests\Api\ProspectActivityRequest;

use App\Http\Resources\ProspectResource;

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
                return ProspectResource::collection($oProspects);
            else
                return response()->json(['message' => __('api.messages.notfound')], Response::HTTP_NO_CONTENT);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /*
    public function store(ProspectRequest $request)
    {
        $success = true;
        DB::beginTransaction();

        try {
            $oPipeline = Pipeline::firstWhere('is_default', 1);

            //@var \App\Models\Api\Prospect
            Prospect::create([
                                "age" => ($request->age) ? $request->age : null,
                                "tax_id" => ($request->tax_id) ? $request->tax_id : null,
                                "type" => ($request->type) ? $request->type : null,
                                "curp" => ($request->curp) ? $request->curp : null,
                                "email" => ($request->email) ? $request->email : null,
                                "gender" => ($request->gender) ? $request->gender : null,
                                "priority" => ($request->priority) ? $request->priority : null,
                                "last_name" => ($request->last_name) ? $request->last_name : null,
                                "extension" => ($request->extension) ? $request->extension : null,
                                "first_name" => ($request->first_name) ? $request->first_name : null,
                                "company_id" => ($request->company_id) ? $request->company_id : null,
                                "birth_date" => ($request->birth_date) ? $request->birth_date : null,
                                "phone_home" => ($request->phone_home) ? $request->phone_home : null,
                                "profession" => ($request->profession) ? $request->profession : null,
                                "account_id" => ($request->account_id) ? $request->account_id : null,
                                "birth_place" => ($request->birth_place) ? $request->birth_place : null,
                                "phone_office" => ($request->phone_office) ? $request->phone_office : null,
                                "phone_mobile" => ($request->phone_mobile) ? $request->phone_mobile : null,
                                "potential_value" => ($request->potential_value) ? $request->potential_value : null,
                                "second_last_name" => ($request->second_last_name) ? $request->second_last_name : null,
                                "prospecting_mean_id" => ($request->prospecting_mean_id) ? $request->prospecting_mean_id : null,
                                "pipeline_stage_id" => (isset($oPipeline?->stages?->sortBy('sort_order')->first()->id)) ? $oPipeline?->stages?->sortBy('sort_order')->first()->id : null
                            ]);

        } catch (\Exception $e) {
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
    */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProspectActivityRequest $request)
    {
        $success = true;
        DB::beginTransaction();

        try {
            $oPipeline = Pipeline::firstWhere('is_default', 1);

            //@var \App\Models\Api\Prospect
            $oProspect = Prospect::create([
                                            "age" => ($request->age) ? $request->age : null,
                                            "email" => ($request->email) ? $request->email : null,
                                            "gender" => ($request->gender) ? $request->gender : null,
                                            "tax_id" => ($request->tax_id) ? $request->tax_id : null,
                                            "priority" => ($request->priority) ? $request->priority : null,
                                            "extension" => ($request->extension) ? $request->extension : null,
                                            "last_name" => ($request->last_name) ? $request->last_name : null,
                                            "tax_regime" => ($request->tax_regime) ? $request->tax_regime : null,
                                            "birth_date" => ($request->birth_date) ? $request->birth_date : null,
                                            "company_id" => ($request->company_id) ? $request->company_id : null,
                                            "first_name" => ($request->first_name) ? $request->first_name : null,
                                            "phone_home" => ($request->phone_home) ? $request->phone_home : null,
                                            "profession" => ($request->profession) ? $request->profession : null,
                                            "account_id" => ($request->account_id) ? $request->account_id : null,
                                            "birth_place" => ($request->birth_place) ? $request->birth_place : null,
                                            "phone_office" => ($request->phone_office) ? $request->phone_office : null,
                                            "phone_mobile" => ($request->phone_mobile) ? $request->phone_mobile : null,
                                            "population_reg" => ($request->population_reg) ? $request->population_reg : null,
                                            "potential_value" => ($request->potential_value) ? $request->potential_value : null,
                                            "second_last_name" => ($request->second_last_name) ? $request->second_last_name : null,
                                            "prospecting_mean_id" => ($request->prospecting_mean_id) ? $request->prospecting_mean_id : null,
                                            "pipeline_stage_id" => (isset($oPipeline?->stages?->sortBy('sort_order')->first()->id)) ? $oPipeline?->stages?->sortBy('sort_order')->first()->id : null
                                        ]);

            if ($request->has('zipcode') && $request->has('city') && $request->has('country'))
            {
                if ($request->zipcode && $request->city && $request->country)
                {
                    $oProspectAddress = ProspectAddress::create([
                        "prospect_id" => $oProspect->id,
                        "type" => ($request->type) ? $request->type : null,
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
            }

            $oActivity = Activity::create([
                "prospect_id" => $oProspect->id,
                "comments" => ($request->comments) ? $request->comments : null,
                "account_id" => ($request->account_id) ? $request->account_id : null,
                "activity_date" => ($request->activity_date) ? $request->activity_date : null,
                "activity_subject_id" => ($request->activity_subject_id) ? $request->activity_subject_id : null
            ]);

            ///SE PROGRAMA EJECUTA CRONJOB

        } catch (\Exception $e) {
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
        try {
            //@var \App\Models\Api\Prospect
            $oProspect = Prospect::findOrFail($id);

            if ($oProspect !== null)
                return new ProspectResource($oProspect);
            else
                return response()->json(['message' => __('api.messages.notfound')], Response::HTTP_NO_CONTENT);   //response()->json(['message' => __('api.messages.notfound')], 404);

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
    public function update(ProspectRequest $request, $id)
    {
        $success = true;
        DB::beginTransaction();

        try {
            //@var \App\Models\Api\Prospect
            $oProspect = Prospect::findOrFail($id);

            $oProspect->update([
                                "age" => ($request->age) ? $request->age : null,
                                "email" => ($request->email) ? $request->email : null,
                                "gender" => ($request->gender) ? $request->gender : null,
                                "tax_id" => ($request->tax_id) ? $request->tax_id : null,
                                "priority" => ($request->priority) ? $request->priority : null,
                                "extension" => ($request->extension) ? $request->extension : null,
                                "last_name" => ($request->last_name) ? $request->last_name : null,
                                "tax_regime" => ($request->tax_regime) ? $request->tax_regime : null,
                                "birth_date" => ($request->birth_date) ? $request->birth_date : null,
                                "company_id" => ($request->company_id) ? $request->company_id : null,
                                "first_name" => ($request->first_name) ? $request->first_name : null,
                                "phone_home" => ($request->phone_home) ? $request->phone_home : null,
                                "profession" => ($request->profession) ? $request->profession : null,
                                "account_id" => ($request->account_id) ? $request->account_id : null,
                                "birth_place" => ($request->birth_place) ? $request->birth_place : null,
                                "phone_office" => ($request->phone_office) ? $request->phone_office : null,
                                "phone_mobile" => ($request->phone_mobile) ? $request->phone_mobile : null,
                                "population_reg" => ($request->population_reg) ? $request->population_reg : null,
                                "potential_value" => ($request->potential_value) ? $request->potential_value : null,
                                "second_last_name" => ($request->second_last_name) ? $request->second_last_name : null,
                                "prospecting_mean_id" => ($request->prospecting_mean_id) ? $request->prospecting_mean_id : null
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
