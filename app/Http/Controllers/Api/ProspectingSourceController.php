<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use App\Models\Api\ProspectingSource;
use App\Http\Resources\ProspectingMeanResource;
use App\Http\Resources\ProspectingSourceResource;

use App\Http\Requests\Api\ProspectingMeanRequest;
use App\Http\Requests\Api\ProspectingSourceRequest;

class ProspectingSourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            //@var \App\Models\Api\ProspectingSource
            $oProspectingSource = new ProspectingSource;
            $bProspectingMean = false;

            if($request->query('account_id')) {
                $oProspectingSource = $oProspectingSource->where('account_id', $request->query('account_id'));
            }

            if($request->query('prospecting_source_id'))
            {
                $bProspectingMean = true;

                if($request->query('prospecting_source_id') == 'all')  //Get the prospecting means
                    $oProspectingSource = $oProspectingSource->whereNotNull('prospecting_source_id');
                else                            //Get the prospecting means for the prospecting source
                    $oProspectingSource = $oProspectingSource->where('prospecting_source_id', $request->query('prospecting_source_id'));
            }else                               //Get the origins
            {
                $oProspectingSource = $oProspectingSource->whereNull('prospecting_source_id');
            }

            $oProspectingSource = $oProspectingSource->get();

            if ($oProspectingSource->count() > 0)
            {
                if(!$bProspectingMean) //Get the origins
                    return ProspectingSourceResource::collection($oProspectingSource);
                else                //Get the mediums origins or Get the mediums origins for the origin
                    return ProspectingMeanResource::collection($oProspectingSource);
            }else
                return response()->json(['message' => __('api.messages.notfound')], Response::HTTP_NO_CONTENT);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProspectingSourceRequest $request)
    {
        $success = true;
        DB::beginTransaction();

        try {
            //@var \App\Models\Api\ProspectingSource
            ProspectingSource::create([
                "name" => (($request->name) ? $request->name : null),
                "account_id" => (($request->account_id) ? $request->account_id : null),
                "active" => (($request->active) ? $request->active : false)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if ($success === true) {
            DB::commit();

            return response()->json([
                'message' => __('api.messages.added')
            ], Response::HTTP_OK);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_prospecting_means(ProspectingMeanRequest $request)
    {
        $success = true;
        DB::beginTransaction();

        try {
            //@var \App\Models\Api\ProspectingSource
            ProspectingSource::create([
                "name" => (($request->name) ? $request->name : null),
                "account_id" => (($request->account_id) ? $request->account_id : null),
                "prospecting_source_id" => (($request->prospecting_source_id) ? $request->prospecting_source_id : null),
                "active" => (($request->active) ? $request->active : false)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if ($success === true) {
            DB::commit();

            return response()->json([
                'message' => __('api.messages.added')
            ], Response::HTTP_OK);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id = FALSE, ProspectingSourceRequest $request)
    {
        $success = true;
        DB::beginTransaction();

        try {
            //@var \App\Models\Api\ProspectingSource
            $oProspectingSource = ProspectingSource::findOrFail($id);

            $aRegistro = array(
                                "name" => (($request->name) ? $request->name : null),
                                "account_id" => (($request->account_id) ? $request->account_id : null),
                                "active" => (($request->active) ? $request->active : false)
                            );

            ////////ORIGINS MEDIUMS
            if($request->has('prospecting_source_id')){
                $aRegistro['prospecting_source_id'] = $request->prospecting_source_id;
            }
            ////////////////////////////////

            $oProspectingSource->update($aRegistro);

        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if ($success === true) {
            DB::commit();

            return response()->json([
                'message' => __('api.messages.updated')
            ], Response::HTTP_OK);
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
            //@var \App\Models\Api\ProspectingSource
            $oProspectingSource = ProspectingSource::findOrFail($id);

            if ($oProspectingSource !== null)
                return new ProspectingSourceResource($oProspectingSource);
            else
                return response()->json(['message' => __('api.messages.notfound')], Response::HTTP_NO_CONTENT);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_prospecting_means($id)
    {
        try {
            //@var \App\Models\Api\ProspectingSource
            $oProspectingSource = ProspectingSource::findOrFail($id);

            if ($oProspectingSource !== null)
                return new ProspectingMeanResource($oProspectingSource);
            else
                return response()->json(['message' => __('api.messages.notfound')], Response::HTTP_NO_CONTENT);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
