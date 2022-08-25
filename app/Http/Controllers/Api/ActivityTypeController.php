<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use App\Models\Api\ActivityType;
use App\Http\Controllers\Controller;

class ActivityTypeController extends Controller
{
    public function __invoke($id_user = false)
    {
        try	{
            //@var \App\Models\Api\ActivityType
            $oActivityTypes = ActivityType::where('user_id', $id_user)
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
}
