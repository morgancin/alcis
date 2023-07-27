<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Api\Pipeline;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Api\PipelineStage;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PriceRequest;
use App\Http\Resources\ProspectResource;
use App\Http\Resources\PipelineStageResource;

class PipelineStageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id_pipeline = false, $id_pipeline_stage = false)
    {
        try	{
            //@var \App\Models\Api\PipelineStage
            $oPipelineStages = PipelineStage::where('pipeline_id', $id_pipeline);

            if($id_pipeline_stage) {
                $oPipelineStages = $oPipelineStages->with('prospects')
                                                ->where('id', $id_pipeline_stage)
                                                ->first();
            }else{
                $oPipelineStages = $oPipelineStages->get();
            }

            if($oPipelineStages->count() > 0)
            {
                if(!$id_pipeline_stage)
                    return PipelineStageResource::collection($oPipelineStages);

                elseif($id_pipeline_stage)
                    return ProspectResource::collection($oPipelineStages->prospects);
            }else
            {
                return response()->json(['message' => __('api.messages.notfound')], Response::HTTP_NO_CONTENT);
            }

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
                                            "name" => $request->name,
                                            "account_id" => $request->account_id,
                                            "is_default" => $request->is_default,
                                        ]);

            $oPipeline->stages()->insert($request->stages);

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
    public function show($id)
    {
        try {
            //@var \App\Models\Api\PipelineStage
            $oPipelineStage = PipelineStage::findOrFail($id);

            if ($oPipelineStage !== null)
                return new PipelineStageResource($oPipelineStage);
            else
                return response()->json(['message' => __('api.messages.notfound')], Response::HTTP_NO_CONTENT);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
