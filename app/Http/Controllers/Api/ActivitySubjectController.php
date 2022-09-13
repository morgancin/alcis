<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Api\ActivitySubject;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ActivitySubjectRequest;

class ActivitySubjectController extends Controller
{
    public function index($id_user = false, $id_activity_type = false)
    {
        try	{
            //@var \App\Models\Api\ActivitySubject
            $oActivitySubjects = ActivitySubject::where('user_id', $id_user)
                                            ->where('activity_type_id', $id_activity_type)
                                            ->get();

            if($oActivitySubjects->count() > 0)
                return response()->json($oActivitySubjects, 200);
            else
                return response()->json(['message' => 'No se encontraron registros'], 404);

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
                'user_id' => $request->user_id,
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
                'message' => 'Registro insertado correctamente'
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
                'message' => 'Registro actualizado correctamente'
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