<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use App\Models\Api\ClientOrigin;
use App\Http\Controllers\Controller;

class ClientOriginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            //@var \App\Models\Api\ClientOrigin
            $oClientOrigins = ClientOrigin::whereNull('parent_id_client_medium')
                                            ->get();

            if ($oClientOrigins->count() > 0)
                return response()->json($oClientOrigins, 200);
            else
                return response()->json(['message' => 'No se encontraron registros'], 404);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function listOriginsMedium($id_client_origin = false)
    {
        try {
            //@var \App\Models\Api\ClientOrigin
            $oClientOriginsMediums = ClientOrigin::where('parent_id_client_medium', $id_client_origin)
                                            ->get();

            if ($oClientOriginsMediums->count() > 0)
                return response()->json($oClientOriginsMediums, 200);
            else
                return response()->json(['message' => 'No se encontraron registros'], 404);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
