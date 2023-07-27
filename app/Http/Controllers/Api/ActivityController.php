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
    public function index(Request $request)
    {
        try	{
            //@var \App\Models\Api\Activity
            $oActivities = Activity::with(['prospect', 'activity_subject']);

            if($request->query('user_id'))
                $oActivities->where('created_user_id', $request->query('user_id'));

            if($request->query('activity_date'))
                $oActivities->whereDate('activity_date', date("Y-m-d", strtotime($request->query('activity_date'))));

            $oActivities = $oActivities->orderBy('activity_date', 'DESC')
                                        ->get();

            if($oActivities->count() > 0)
            {
                return ActivityResource::collection($oActivities);
            }else
            {
                return response()->json([
                    'success' => true,
                    'message' => 'No content',
                    'errors' => [],
                    'data' => [],
                ], Response::HTTP_ACCEPTED);
                //return response()->json(['message' => __('api.messages.notfound')], Response::HTTP_NO_CONTENT);
            }

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
    public function store(ActivityRequest $request)
    {
        $success = true;
        DB::beginTransaction();

        try	{
            //@var \App\Models\Activity
            $oActivity = Activity::create([
                                            //"start_date" => $request->start_date,
                                            //"start_time" => $request->start_time,
                                            "comments" => $request->comments,
                                            "account_id" => $request->account_id,
                                            "prospect_id" => $request->prospect_id,
                                            "activity_subject_id" => $request->activity_subject_id,
                                            "activity_date" => ($request->start_date.' '.$request->start_time),
                                        ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if ($success === true) {
            DB::commit();

            //return new ActivityResource($oActivity);

            return response()->json([
                'message' => __('api.messages.added')
            ], Response::HTTP_OK);
        }
    }
    */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //public function store($id = FALSE, ActivityRescheduleRequest $request)
    public function store(ActivityRequest $request)
    {
        $success = true;
        DB::beginTransaction();

        try {
            //$request->last_activity_id
            //$request->activity_result_id
            //$request->activity_observations   /* Pendiente */
            //$request->activity_subject_id
            //$request->comments
            //$request->activity_date

            if($request->has('last_activity_id') && $request->has('activity_result_id'))
            {
                $oActivity = Activity::findOrFail($request->last_activity_id);

                if($oActivity !== null)
                {
                    $oActivityResult = ActivityResult::findOrFail($request->activity_result_id);

                    if($oActivityResult !== null)
                    {
                        $oActivity->update([
                                            'end_date' => date("Y-m-d H:i:s"),
                                            'observations' => $request->activity_observations,
                                            'activity_result_id' => $request->activity_result_id,
                                            'pipeline_stage_id' => $oActivityResult->pipeline_stage_id
                                        ]);

                        $oActivity?->prospect->update([
                                                        'pipeline_stage_id' => $oActivityResult->pipeline_stage_id
                                                    ]);

                        if($oActivityResult->is_tracking)
                        {
                            Activity::create([
                                                "prospect_id" => $oActivity->id,
                                                "account_id" => $oActivity->account_id,
                                                "prospect_id" => $oActivity->prospect_id,
                                                "comments" => ($request->comments) ? $request->comments : null,
                                                "activity_date" => ($request->activity_date) ? $request->activity_date : null,   //($request->start_date.' '.$request->start_time),
                                                "activity_subject_id" => ($request->activity_subject_id) ? $request->activity_subject_id : null
                                            ]);
                        }
                    }
                }
            }

            /*
            //@var \App\Models\Api\Activity
            $oActivity = Activity::findOrFail($id);
            $oActivityResult = ActivityResult::findOrFail($request->activity_result_id);

            $oActivity->update([
                                //'end_time' => date("H:i:s"),
                                'end_date' => date("Y-m-d H:i:s"),
                                'observations' => $request->observations,
                                'activity_result_id' => $request->activity_result_id,
                            ]);


            */

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
            ], Response::HTTP_CREATED);
        }
    }

    public function store_end_activity($id = FALSE, ActivityRequest $request)
    {
        $success = true;
        DB::beginTransaction();

        try {
            //@var \App\Models\Api\Activity
            $oActivity = Activity::findOrFail($id);
            $oActivityResult = ActivityResult::findOrFail($request->activity_result_id);

            $oActivity->update([
                                //'end_time' => date("H:i:s"),
                                'end_date' => date("Y-m-d H:i:s"),
                                'observations' => $request->observations,
                                'activity_result_id' => $request->activity_result_id,
                            ]);

            if($oActivityResult->tracking_type == 'activity')
            {
                Activity::create([
                                    //"activity_date" => date("Y-m-d"),
                                    //"start_date" => $request->start_date,
                                    //"start_time" => $request->start_time,
                                    "comments" => $request->comments,
                                    "account_id" => $request->account_id,
                                    "prospect_id" => $oActivity->prospect_id,
                                    "activity_subject_id" => $request->activity_subject_id,
                                    "activity_date" => ($request->start_date.' '.$request->start_time),
                                ]);
            }

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
            ], Response::HTTP_CREATED);
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
            $oActivity = Activity::with(['prospect', 'activity_subject'])
                                ->findOrFail($id);

            if ($oActivity !== null)
                return new ActivityResource($oActivity);
            else
                return response()->json(['message' => __('api.messages.notfound')], Response::HTTP_NO_CONTENT);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
