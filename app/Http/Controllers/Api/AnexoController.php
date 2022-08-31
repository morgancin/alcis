<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\Api\FetchCurpRequest;

use App\Helpers\Curp;

class AnexoController extends Controller
{
    public function fetchCp($nCp = false)
    {
        try	{
            if (is_numeric($nCp)) {
                $response = Http::get("https://api.copomex.com/query/info_cp/$nCp?type=simplified&token=pruebas");

                $response = $response->json("response");

                if($response)
                    return response()->json($response, 200);
                else
                    return response()->json(['message' => 'No se encontraron registros'], 404);

            }else{
                return response()->json(['message' => 'El dato código postal debe ser numérico'], 500);
            }

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function fetchCurp(FetchCurpRequest $request)
    {
        try	{
            $cGender = ($request->gender == 'male') ? 'H': (($request->gender == 'feminine') ? 'M' : null);

            $oCurp = new Curp($request->first_name, $request->last_name, $request->second_last_name, $request->birth_date, $cGender, $request->birth_place);
            $cCurp = $oCurp->curp;

            if($cCurp)
                return response()->json($cCurp, 200);
            else
                return response()->json(['message' => 'No se encontró registro'], 404);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
