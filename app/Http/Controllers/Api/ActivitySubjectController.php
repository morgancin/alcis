<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Api\ActivitySubject;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Api\ActivitySubjectRequest;
class ActivitySubjectController extends Controller
{
    public function index($id_activity_type = false)
    {
        try	{
            //@var \App\Models\Api\ActivitySubject
            $oActivitySubjects = ActivitySubject::where('user_id', auth()->user()->id)
                                            ->where('activity_type_id', $id_activity_type)
                                            ->get();

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
                //'user_id' => $request->user_id,
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
    public function update(ActivitySubjectRequest $request, $id)
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
    public function show($id)
    {
        try {
            //@var \App\Models\Api\Client
            $oActivitySubjects = ActivitySubject::findOrFail($id);

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
