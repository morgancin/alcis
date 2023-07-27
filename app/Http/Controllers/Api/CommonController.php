<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Helpers\Curp;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

use App\Http\Requests\Api\FetchCurpRequest;

class CommonController extends Controller
{
    public function fetchCp($nCp = false)
    {
        try	{
            if (is_numeric($nCp)) {
                $response = Http::get("https://api.copomex.com/query/info_cp/$nCp?type=simplified&token=pruebas");

                $response = $response->json("response");

                if($response)
                    return response()->json($response, Response::HTTP_OK);
                else
                    return response()->json(['message' => __('api.messages.notfound')], Response::HTTP_NO_CONTENT);

            }else{
                return response()->json(['message' => __('api.messages.controller.anexo.fetchcp')], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function fetchCurp(FetchCurpRequest $request)
    {
        try	{
            //$cGender = ($request->gender == 'male') ? 'H': (($request->gender == 'feminine') ? 'M' : null);
            //$oCurp = new Curp($request->first_name, $request->last_name, $request->second_last_name, $request->birth_date, $cGender, $request->birth_place);

            $cGender = ($request->query('gender') == 'male') ? 'H': (($request->query('gender') == 'feminine') ? 'M' : null);
            $oCurp = new Curp($request->query('first_name'), $request->query('last_name'), $request->query('second_last_name'), $request->query('birth_date'), $cGender, $request->query('birth_place'));

            $cCurp = $oCurp->curp;

            if($cCurp)
                return response()->json($cCurp, Response::HTTP_OK);
            else
                return response()->json(['message' => __('api.messages.notfound')], Response::HTTP_NO_CONTENT);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
