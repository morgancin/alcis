<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use App\Models\Api\PriceList;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Http\Resources\PriceListResource;
use App\Http\Requests\Api\PriceListRequest;

class PriceListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try	{
            $pageSize = $request->page_size ?? 20;

            //@var \App\Models\Api\PriceList
            $oPrices_lists = PriceList::with(['products'])
                                        ->paginate($pageSize);

            if($oPrices_lists->count() > 0)
                return PriceListResource::collection($oPrices_lists);
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
    public function store(PriceListRequest $request)
    {
        $success = true;
        DB::beginTransaction();

        try	{
            //@var \App\Models\PriceList
            PriceList::create([
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PriceListRequest $request, $id)
    {
        $success = true;
        DB::beginTransaction();

        try {
            //@var \App\Models\Api\PriceList
            $oPrice_list = PriceList::findOrFail($id);

            $oPrice_list->update([
                "name" => (($request->name) ? $request->name : null),
                "account_id" => (($request->account_id) ? $request->account_id : null),
                "active" => (($request->active) ? $request->active : false)
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
            //@var \App\Models\Api\PriceList
            $oPrices_list = PriceList::findOrFail($id);

            if ($oPrices_list !== null)
                //return new PriceListResource($oPrices_list);
                return (new PriceListResource($oPrices_list->loadMissing(['products'])));
            else
                return response()->json(['message' => __('api.messages.notfound')], Response::HTTP_NO_CONTENT);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
