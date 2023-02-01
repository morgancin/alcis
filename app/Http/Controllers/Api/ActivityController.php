<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Api\Activity;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
//use Illuminate\Http\JsonResponse;
use App\Models\Api\ActivityResult;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\ActivityResource;
use App\Http\Requests\Api\ActivityRequest;
use App\Http\Requests\Api\ActivityRescheduleRequest;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //public function index(): JsonResponse
    public function index()
    {
        try	{
            //@var \App\Models\Api\Activity
            $oActivities = Activity::with(['client', 'activity_subject'])
                                    ->where('user_id', auth()->user()->id)
                                    ->get();

            if($oActivities->count() > 0)
                return ActivityResource::collection($oActivities);
            else
                return response()->json(['message' => __('api.messages.notfound')], Response::HTTP_NOT_FOUND);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ActivityRequest $request)
    {
        $success = true;
        DB::beginTransaction();

        try	{
            //@var \App\Models\Activity
            $oActivity = Activity::create([
                                            "activity_date" => date("Y-m-d"),
                                            "comments" => $request->comments,
                                            "client_id" => $request->client_id,
                                            "start_date" => $request->start_date,
                                            "start_time" => $request->start_time,
                                            "activity_subject_id" => $request->activity_subject_id,
                                        ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }

        if ($success === true) {
            DB::commit();

            //return new ActivityResource($oActivity);

            return response()->json([
                'message' => __('api.messages.added')
            ], 200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store_reschedule(ActivityRescheduleRequest $request, $id)
    {
        $success = true;
        DB::beginTransaction();

        try {
            //@var \App\Models\Api\Activity
            $oActivity = Activity::findOrFail($id);
            $oActivityResult = ActivityResult::findOrFail($request->activity_result_id);

            $oActivity->update([
                'end_date' => date("Y-m-d"),
                'end_time' => date("H:i:s"),
                'observations' => $request->observations,
                'activity_result_id' => $request->activity_result_id,
            ]);

            if($oActivityResult->tracking_type == 'activity')
            {
                Activity::create([
                                    "activity_date" => date("Y-m-d"),
                                    "comments" => $request->comments,
                                    "client_id" => $oActivity->client_id,
                                    "start_date" => $request->start_date,
                                    "start_time" => $request->start_time,
                                    "activity_subject_id" => $request->activity_subject_id,
                                ]);
            }

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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            //@var \App\Models\Api\Activity
            $oActivity = Activity::with(['client', 'activity_subject'])
                                ->findOrFail($id);

            if ($oActivity !== null)
                return new ActivityResource($oActivity);
            else
                return response()->json(['message' => __('api.messages.notfound')], Response::HTTP_NOT_FOUND);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
