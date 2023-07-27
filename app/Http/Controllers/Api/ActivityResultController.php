<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Api\ActivityResult;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Http\Resources\ActivityResultResource;
use App\Http\Requests\Api\ActivityResultRequest;

class ActivityResultController extends Controller
{
    public function index()
    {
        try	{
            //@var \App\Models\Api\ActivityResult
            $oActivityResults = ActivityResult::get();

            if($oActivityResults->count() > 0)
                return ActivityResultResource::collection($oActivityResults);
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
    public function store(ActivityResultRequest $request)
    {
        $success = true;
        DB::beginTransaction();

        try {
            //@var \App\Models\Api\ActivityResult
            ActivityResult::create([
                "name" => (($request->name) ? $request->name : null),
                "is_tracking" => (($request->is_tracking) ? $request->is_tracking : false),
                "activity_type_id" => (($request->activity_type_id) ? $request->activity_type_id : null),
                "pipeline_stage_id" => (($request->pipeline_stage_id) ? $request->pipeline_stage_id : null),
                "active" => (($request->active) ? $request->active : false)
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ActivityResultRequest $request, $id)
    {
        $success = true;
        DB::beginTransaction();

        try {
            //@var \App\Models\Api\ActivityResult
            $oActivityResult = ActivityResult::findOrFail($id);

            $oActivityResult->update([
                "name" => (($request->name) ? $request->name : null),
                "is_tracking" => (($request->is_tracking) ? $request->is_tracking : false),
                "activity_type_id" => (($request->activity_type_id) ? $request->activity_type_id : null),
                "pipeline_stage_id" => (($request->pipeline_stage_id) ? $request->pipeline_stage_id : null),
                "active" => (($request->active) ? $request->active : false)
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            //@var \App\Models\Api\ActivityResult
            $oActivityResult = ActivityResult::findOrFail($id);

            if ($oActivityResult !== null)
                return new ActivityResultResource($oActivityResult);

            else
                return response()->json(['message' => __('api.messages.notfound')], Response::HTTP_NO_CONTENT);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
