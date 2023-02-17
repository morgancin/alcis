<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Api\ActivityResult;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ActivityResultRequest;

class ActivityResultController extends Controller
{
    public function index()
    {
        try	{
            //@var \App\Models\Api\ActivityResult
            $oActivityResults = ActivityResult::get();

            /*
            $oActivityResults = ActivityResult::whereHas('activity_type', function($q) {
                                                    $q->where('user_id', auth()->user()->id);
                                                })
                                                ->get();
            */

            if($oActivityResults->count() > 0)
                return response()->json($oActivityResults, Response::HTTP_OK);
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
    public function store(ActivityResultRequest $request)
    {
        $success = true;
        DB::beginTransaction();

        try {
            //@var \App\Models\Api\ActivityResult
            ActivityResult::create([
                'name' => $request->name,
                'tracking_type' => $request->tracking_type,
                'activity_type_id' => $request->activity_type_id,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
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
                'name' => $request->name,
                'tracking_type' => $request->tracking_type,
                'activity_type_id' => $request->activity_type_id,
            ]);

        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
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
                return response()->json($oActivityResult, Response::HTTP_OK);
            else
                return response()->json(['message' => __('api.messages.notfound')], Response::HTTP_NOT_FOUND);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
