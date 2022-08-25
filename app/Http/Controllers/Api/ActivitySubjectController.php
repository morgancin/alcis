<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use App\Models\Api\ActivitySubject;
use App\Http\Controllers\Controller;

class ActivitySubjectController extends Controller
{
    public function __invoke($id_activity_type = false)
    {
        try	{
            //@var \App\Models\Api\ActivitySubject
            $oActivitySubjects = ActivitySubject::where('activity_type_id', $id_activity_type)
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
}
