<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Api\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Requests\Api\ProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($category_id = false)
    {
        try {
            //@var \App\Models\Api\Product
            $oProducts = Product::with(['category', 'prices.prices_list']);

            if($category_id)
                $oProducts->where('category_id', $category_id);

            $oProducts = $oProducts->get();

            if ($oProducts->count() > 0)
                return ProductResource::collection($oProducts);
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
    public function store(ProductRequest $request)
    {
        $success = true;
        DB::beginTransaction();

        try	{
            //@var \App\Models\Product
            Product::create([
                "sku" => $request->sku,
                "name" => $request->name,
                "quantity" => $request->quantity,
                "description" => $request->description,
                "category_id" => $request->category_id,
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
    public function update(ProductRequest $request, $id)
    {
        $success = true;
        DB::beginTransaction();

        try {
            //@var \App\Models\Api\Currency
            $oProduct = Product::findOrFail($id);

            $oProduct->update([
                "sku" => $request->sku,
                "name" => $request->name,
                "quantity" => $request->quantity,
                "description" => $request->description,
                "category_id" => $request->category_id,
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
            //@var \App\Models\Api\Product
            $oProduct = Product::findOrFail($id);

            if ($oProduct !== null)
                return new ProductResource($oProduct);
            else
                return response()->json(['message' => __('api.messages.notfound')], Response::HTTP_NOT_FOUND);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
