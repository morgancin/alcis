<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Api\Lead;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Http\Resources\LeadResource;
use App\Http\Requests\Api\LeadRequest;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try	{
            //@var \App\Models\Api\Lead
            $oLeads = Lead::all();

            if($oLeads->count() > 0)
                return LeadResource::collection($oLeads);
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
    public function store(LeadRequest $request)
    {
        $success = true;
        DB::beginTransaction();

        try	{
            //@var \App\Models\Lead
            $oLead = Lead::create([
                                    "email" => $request->email,
                                    "comments" => $request->comments,
                                    "last_name" => $request->last_name,
                                    "first_name" => $request->first_name,
                                    "account_id" => $request->account_id,
                                    "second_last_name" => $request->second_last_name,
                                    "prospecting_mean_id" => $request->prospecting_mean_id
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = FALSE)
    {
        try {
            //@var \App\Models\Api\Lead
            $oLead = Lead::find($id);

            if ($oLead !== null)
                return new LeadResource($oLead);
            else
                return response()->json(['message' => __('api.messages.notfound')], Response::HTTP_NO_CONTENT);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
