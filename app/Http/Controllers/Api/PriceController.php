<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Api\Price;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PriceRequest;

class PriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try	{
            //@var \App\Models\Api\Price
            $oPrices = Price::get();

            if($oPrices->count() > 0)
                return response()->json($oPrices, Response::HTTP_OK);
            else
                return response()->json(['message' => __('api.messages.notfound')], Response::HTTP_NOT_FOUND);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
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
            //@var \App\Models\Price
            Price::create([
                "price" => $request->price,
                "product_id" => $request->product_id,
                "currency_id" => $request->currency_id,
                "price_list_id" => $request->price_list_id,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
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
    public function update(PriceRequest $request, $id)
    {
        $success = true;
        DB::beginTransaction();

        try {
            //@var \App\Models\Api\Currency
            $oPrice = Price::findOrFail($id);

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
            ], Response::HTTP_BAD_REQUEST);
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
            //@var \App\Models\Api\Price
            $oPrice = Price::findOrFail($id);

            if ($oPrice !== null)
                return response()->json($oPrice, Response::HTTP_OK);
            else
                return response()->json(['message' => __('api.messages.notfound')], Response::HTTP_NOT_FOUND);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
