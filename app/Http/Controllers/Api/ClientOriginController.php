<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Api\ClientOrigin;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClientOriginResource;
use App\Http\Requests\Api\ClientOriginRequest;
use App\Http\Resources\ClientOriginMediumsResource;

class ClientOriginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id_client_origin = false)
    {
        try {
            //@var \App\Models\Api\ClientOrigin
            $oClientOrigins = ClientOrigin::where('user_id', auth()->user()->id);
            $bOriginMedium = false;

            if($id_client_origin)
            {
                $bOriginMedium = true;

                if($id_client_origin == 'all')  //Get the mediums origins
                    $oClientOrigins->whereNotNull('client_origin_id');
                else                            //Get the mediums origins for the origin
                    $oClientOrigins->where('client_origin_id', $id_client_origin);
            }else                               //Get the origins
            {
                $oClientOrigins->whereNull('client_origin_id');
            }

            $oClientOrigins = $oClientOrigins->get();

            if ($oClientOrigins->count() > 0)
            {
                if(!$bOriginMedium) //Get the origins
                    return ClientOriginResource::collection($oClientOrigins);
                else                //Get the mediums origins or Get the mediums origins for the origin
                    return ClientOriginMediumsResource::collection($oClientOrigins);
            }else
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
    public function store(ClientOriginRequest $request)
    {
        $success = true;
        DB::beginTransaction();

        try {
            $aRegistro = array(
                                //'user_id' => auth()->user()->id,
                                'description' => $request->description,
                            );

            ////////ORIGINS MEDIUMS
            if($request->has('client_origin_id'))
            {
                $aRegistro['client_origin_id'] = $request->client_origin_id;
            }
            ////////////////////////////////

            //@var \App\Models\Api\ClientOrigin
            ClientOrigin::create($aRegistro);

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
    public function update(ClientOriginRequest $request, $id)
    {
        $success = true;
        DB::beginTransaction();

        try {
            //@var \App\Models\Api\ClientOrigin
            $oClientOrigin = ClientOrigin::findOrFail($id);

            $aRegistro = array(
                            'description' => $request->description,
                        );

            ////////ORIGINS MEDIUMS
            if($request->has('client_origin_id')){
                $aRegistro['client_origin_id'] = $request->client_origin_id;
            }
            ////////////////////////////////

            $oClientOrigin->update($aRegistro);

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
            //@var \App\Models\Api\ClientOrigin
            $oClientOrigin = ClientOrigin::findOrFail($id);

            if ($oClientOrigin !== null)
                return response()->json($oClientOrigin, Response::HTTP_OK);
            else
                return response()->json(['message' => __('api.messages.notfound')], Response::HTTP_NOT_FOUND);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
