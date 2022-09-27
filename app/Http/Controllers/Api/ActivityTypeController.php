<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use App\Models\Api\ActivityType;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ActivityTypeRequest;

class ActivityTypeController extends Controller
{
    public function index()
    {
        try	{
            //@var \App\Models\Api\ActivityType
            $oActivityTypes = ActivityType::where('user_id', auth()->user()->id)
                                            ->get();

            if($oActivityTypes->count() > 0)
                return response()->json($oActivityTypes, 200);
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
    public function store(ActivityTypeRequest $request)
    {
        $success = true;
        DB::beginTransaction();

        try {
            //@var \App\Models\Api\ActivityType
            ActivityType::create([
                'user_id' => auth()->user()->id,

                'type' => $request->type,
                'name' => $request->name,
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
    public function update(ActivityTypeRequest $request, $id)
    {
        $success = true;
        DB::beginTransaction();

        try {
            //@var \App\Models\Api\ActivityType
            $oActivityType = ActivityType::findOrFail($id);

            $oActivityType->update([
                'type' => $request->type,
                'name' => $request->name,
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
