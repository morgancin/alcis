<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Api\PaymentMethod;
use App\Http\Resources\PaymentMethodResource;
use App\Http\Requests\Api\PaymentMethodRequest;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            //@var \App\Models\Api\PaymentMethod
            $oPaymentMethods = PaymentMethod::get();

            if ($oPaymentMethods->count() > 0)
                return PaymentMethodResource::collection($oPaymentMethods);
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
    public function store(PaymentMethodRequest $request)
    {
        $success = true;
        DB::beginTransaction();

        try {
            //@var \App\Models\Api\PaymentMethod
            $oPaymentMethod = PaymentMethod::create([
                                                    "code" => $request->code,
                                                    "name" => $request->name,
                                                    "type" => $request->type,
                                                    "active" => $request->active
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
    public function update(PaymentMethodRequest $request, $id)
    {
        $success = true;
        DB::beginTransaction();

        try {
            //@var \App\Models\Api\PaymentMethod
            $oPaymentMethod = PaymentMethod::findOrFail($id);

            $oPaymentMethod->update([
                                    "code" => $request->code,
                                    "name" => $request->name,
                                    "type" => $request->type,
                                    "active" => $request->active
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
            //@var \App\Models\Api\PaymentMethod
            $oPaymentMethod = PaymentMethod::findOrFail($id);

            if ($oPaymentMethod !== null)
                return new PaymentMethodResource($oPaymentMethod);
            else
                return response()->json(['message' => __('api.messages.notfound')], Response::HTTP_NO_CONTENT);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
