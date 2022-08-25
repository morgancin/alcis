<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class AnexoController extends Controller
{
    public function fetchCp($nCp = false)
    {
        try	{
            $response = Http::get("https://api.copomex.com/query/info_cp/$nCp?type=simplified&token=pruebas");

            $response = $response->json("response");

            if($response)
                return response()->json($response, 200);
            else
                return response()->json(['message' => 'No se encontraron registros'], 404);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function fetchCurp()
    {
        try	{
            $cCurp = '';

            return response()->json($cCurp, 200);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
