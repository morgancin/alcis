<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Api\ActivitySubject;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ActivitySubjectRequest;

class ActivitySubjectController extends Controller
{
    public function index($activity_type_id = false)
    {
        try	{
            //@var \App\Models\Api\ActivitySubject
            $oActivitySubjects = new ActivitySubject;

            /*
            $oActivitySubjects = ActivitySubject::whereHas('activity_type', function($q) {
                                                    $q->where('user_id', auth()->user()->id);
                                                });
            */

            if($activity_type_id)
                $oActivitySubjects->where('activity_type_id', $activity_type_id);

            $oActivitySubjects = $oActivitySubjects->get();

            if($oActivitySubjects->count() > 0)
                return response()->json($oActivitySubjects, 200);
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
    public function store(ActivitySubjectRequest $request)
    {
        $success = true;
        DB::beginTransaction();

        try {
            //@var \App\Models\Api\ActivitySubject
            ActivitySubject::create([
                'name' => $request->name,
                'activity_type_id' => $request->activity_type_id,
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
                'name' => $request->name,
                'activity_type_id' => $request->activity_type_id,
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($activity_type_id = FALSE, $id = FALSE)
    {
        try {
            //@var \App\Models\Api\ActivitySubject
            if($id) {
                $oActivitySubjects = ActivitySubject::findOrFail($id);

            }elseif($activity_type_id) {
                $oActivitySubjects = ActivitySubject::where('activity_type_id', $activity_type_id)->get();
                /*
                $oActivitySubjects = ActivitySubject::whereHas('activity_type', function($q) {
                    $q->where('user_id', auth()->user()->id);
                })->where('activity_type_id', $activity_type_id)
                ->get();
                */
            }

            //$oActivitySubjects->where('activity_type_id', $activity_type_id);

            if ($oActivitySubjects !== null)
                return response()->json($oActivitySubjects, Response::HTTP_OK);
            else
                return response()->json(['message' => __('api.messages.notfound')], Response::HTTP_NOT_FOUND);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
