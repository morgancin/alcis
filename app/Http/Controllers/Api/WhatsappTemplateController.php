<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Models\Api\WhatsappTemplate;
use App\Http\Resources\WhatsappTemplateResource;
use App\Http\Requests\Api\WhatsappTemplateRequest;

class WhatsappTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            //@var \App\Models\Api\WhatsappTemplate
            $oWhatsappTemplates = WhatsappTemplate::all();

            if ($oWhatsappTemplates->count() > 0)
                return WhatsappTemplateResource::collection($oWhatsappTemplates);
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
    public function store(WhatsappTemplateRequest $request)
    {
        $success = true;
        DB::beginTransaction();

        try {
            //@var \App\Models\Api\WhatsappTemplate
            $oWhatsappTemplate = WhatsappTemplate::create([
                                                            "raw_value" => $request->raw_value,
                                                            "table_name" => $request->table_name,
                                                            "replace_type" => $request->replace_type,
                                                            "table_column" => $request->table_column,
                                                            "template_name" => $request->template_name,
                                                            "dynamic_index" => $request->dynamic_index
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
    public function update(WhatsappTemplateRequest $request, $id)
    {
        $success = true;
        DB::beginTransaction();

        try {
            //@var \App\Models\Api\WhatsappTemplate
            $oWhatsappTemplate = WhatsappTemplate::findOrFail($id);

            $oWhatsappTemplate->update([
                                        "raw_value" => $request->raw_value,
                                        "table_name" => $request->table_name,
                                        "replace_type" => $request->replace_type,
                                        "table_column" => $request->table_column,
                                        "template_name" => $request->template_name,
                                        "dynamic_index" => $request->dynamic_index
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            //@var \App\Models\Api\WhatsappTemplate
            $oWhatsappTemplate = WhatsappTemplate::findOrFail($id);

            if ($oWhatsappTemplate !== null)
                return new WhatsappTemplateResource($oWhatsappTemplate);
            else
                return response()->json(['message' => __('api.messages.notfound')], Response::HTTP_NO_CONTENT);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
