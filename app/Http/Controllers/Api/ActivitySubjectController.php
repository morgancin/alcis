<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Api\ActivitySubject;
use App\Http\Controllers\Controller;
use App\Http\Resources\ActivitySubjectResource;
use App\Http\Requests\Api\ActivitySubjectRequest;

class ActivitySubjectController extends Controller
{
    public function index(Request $request)
    {
        try	{
            //@var \App\Models\Api\ActivitySubject
            $oActivitySubjects = ActivitySubject::with(['activities', 'activity_type']);

            if($request->query('activity_type_id'))
                $oActivitySubjects->where('activity_type_id', $request->query('activity_type_id'));

            $oActivitySubjects = $oActivitySubjects->get();

            if($oActivitySubjects->count() > 0)
                return ActivitySubjectResource::collection($oActivitySubjects);
            else
                return response()->json(['message' => __('api.messages.notfound'), 'data' => []], Response::HTTP_NO_CONTENT);

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
    public function store(ActivitySubjectRequest $request)
    {
        $success = true;
        DB::beginTransaction();

        try {
            //@var \App\Models\Api\ActivitySubject
            ActivitySubject::create([
                "name" => (($request->name) ? $request->name : null),
                "activity_type_id" => (($request->activity_type_id) ? $request->activity_type_id : null),
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
    public function update($id = FALSE, ActivitySubjectRequest $request)
    {
        $success = true;
        DB::beginTransaction();

        try {
            //@var \App\Models\Api\ActivitySubject
            $oActivitySubject = ActivitySubject::findOrFail($id);

            $oActivitySubject->update([
                "name" => (($request->name) ? $request->name : null),
                "activity_type_id" => (($request->activity_type_id) ? $request->activity_type_id : null),
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
            //@var \App\Models\Api\ActivitySubject
            $oActivitySubjects = ActivitySubject::findOrFail($id);

            if ($oActivitySubjects !== null)
                return new ActivitySubjectResource($oActivitySubjects);
            else
                return response()->json(['message' => __('api.messages.notfound')], Response::HTTP_NO_CONTENT);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
