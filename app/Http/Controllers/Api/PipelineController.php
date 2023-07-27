<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Api\Pipeline;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PriceRequest;
use App\Http\Resources\PipelineResource;

class PipelineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try	{
            //@var \App\Models\Api\Pipeline
            $oPipelines = Pipeline::with(['account', 'stages'])
                                    ->get();

            if($oPipelines->count() > 0)
                return PipelineResource::collection($oPipelines);
            else
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
    public function store(PriceRequest $request)
    {
        $success = true;
        DB::beginTransaction();

        try	{
            //@var \App\Models\Pipeline
            $oPipeline = Pipeline::create([
                                            "name" => (($request->name) ? $request->name : null),
                                            "account_id" => (($request->account_id) ? $request->account_id : null),
                                            "is_default" => (($request->is_default) ? $request->is_default : false),
                                            "active" => (($request->active) ? $request->active : false)
                                        ]);
            if($oPipeline)
            {
                if($request->stages)
                {
                    if(count($request->stages) > 0)
                    {
                        foreach($request->stages as $stage)
                        {
                            $aData[] = array(
                                            "pipeline_id" => $oPipeline->id,
                                            "name" => $stage['name'],
                                            "percentage" => $stage['percentage'],
                                            "sort_order" => (isset($stage['sort_order'])) ? $stage['sort_order'] : null,
                                            "created_at" => date("Y-m-d H:i:s"),
                                            "updated_at" => date("Y-m-d H:i:s")
                                        );
                        }

                        $oPipeline->stages()->insert($aData);
                    }
                }
            }

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
    /*
    public function update(PriceRequest $request, $id)
    {
        $success = true;
        DB::beginTransaction();

        try {
            //@var \App\Models\Api\Currency
            $oPrice = Pipeline::findOrFail($id);

            $oPrice->update([
                "price" => $request->price,
                "product_id" => $request->product_id,
                "currency_id" => $request->currency_id,
                "price_list_id" => $request->price_list_id,
            ]);

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
    */

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = FALSE)
    {
        try {
            //@var \App\Models\Api\Pipeline
            $oPrice = Pipeline::find($id);

            if ($oPrice !== null)
                return new PipelineResource($oPrice);
            else
                return response()->json(['message' => __('api.messages.notfound')], Response::HTTP_NO_CONTENT);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
