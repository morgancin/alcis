<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Api\Product,
    App\Models\Api\ProductImage;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;

use File,
    Illuminate\Support\Facades\Storage;

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
            $oProducts = Product::with(['category', 'price_lists', 'components', 'images']);

            if($category_id)
                $oProducts->where('category_id', $category_id);

            $oProducts = $oProducts->get();

            if ($oProducts->count() > 0)
                return ProductResource::collection($oProducts);
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
    public function store(ProductRequest $request)
    {
        $success = true;
        DB::beginTransaction();

        try	{
            //https://laracasts.com/discuss/channels/eloquent/insert-multiple-records-in-one-query
            //@var \App\Models\Product
            $oProduct = Product::create([
                "sku" => (($request->sku) ? $request->sku : null),
                "name" => (($request->name) ? $request->name : null),
                "quantity" => (($request->quantity) ? $request->quantity : null),
                "account_id" => (($request->account_id) ? $request->account_id : null),
                "category_id" => (($request->category_id) ? $request->category_id : null),
                "description" => (($request->description) ? $request->description : null),
                "active" => (($request->active) ? $request->active : false)
            ])->load('images');

            if($oProduct)
            {
                if($request->has("images"))
                {
                    foreach($request->images as $image)
                    {
                        $cSrc = $image['src'];
                        if(File::exists(storage_path("app/public/product_image_preview/$cSrc")))
                        {
                            $oProduct?->images()?->create([
                                "src" => $cSrc
                            ]);

                            Storage::move("public/product_image_preview/$cSrc", "public/products_images/$cSrc");
                        }
                    }
                }

                if($request->has("components"))
                {
                    $aRecords = array();
                    foreach($request->components as $components)
                    {
                        $aRecords[] = array(
                            "product_id" => $oProduct->id,
                            "name" => $components['name'],
                            "quantity" => $components['quantity']
                        );
                    }

                    if(count($aRecords) > 0)
                    {
                        $oProduct->components()->insert($aRecords);
                    }
                }

                if($request->has("price_lists"))
                {
                    $aRecords = array();
                    foreach($request->price_lists as $price_list)
                    {
                        $aRecords[] = array(
                            "price" => $price_list['price'],
                            "currency_id" => $price_list['currency_id'],
                            "price_list_id" => $price_list['price_list_id']
                        );
                    }

                    if(count($aRecords) > 0)
                    {
                        $oProduct->price_lists()->attach($aRecords);
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
    public function update(ProductRequest $request, $id)
    {
        $success = true;
        DB::beginTransaction();

        try {
            //@var \App\Models\Api\Product
            $oProduct = Product::with(['category', 'price_lists', 'components', 'images'])
                                ->findOrFail($id);

            $oProduct->update([
                "sku" => (($request->sku) ? $request->sku : null),
                "name" => (($request->name) ? $request->name : null),
                "quantity" => (($request->quantity) ? $request->quantity : null),
                "account_id" => (($request->account_id) ? $request->account_id : null),
                "category_id" => (($request->category_id) ? $request->category_id : null),
                "description" => (($request->description) ? $request->description : null),
                "active" => (($request->active) ? $request->active : false)
            ]);

            if($oProduct)
            {
                if($request->has("images"))
                {
                    foreach($request->images as $image)
                    {
                        $cSrc = $image['src'];
                        if(File::exists(storage_path("app/public/product_image_preview/$cSrc")))
                        {
                            $oProduct?->images()?->create([
                                "src" => $cSrc
                            ]);

                            Storage::move("public/product_image_preview/$cSrc", "public/products_images/$cSrc");
                        }
                    }
                }
                /*
                if($request->has("components"))
                {
                    $aRecords = array();
                    foreach($request->components as $components)
                    {
                        $aRecords[] = array(
                                            "product_id" => $oProduct->id,
                                            "name" => $components['name'],
                                            "quantity" => $components['quantity']
                                        );
                    }

                    //if(count($aRecords) > 0)
                    //{
                        //$oProduct->components()->insert($aRecords);
                    //}
                }
                */

                if($request->has("price_lists"))
                {
                    $aRecords = array();
                    foreach($request->price_lists as $price_list)
                    {
                        $aRecords[] = array(
                            "price" => $price_list['price'],
                            "currency_id" => $price_list['currency_id'],
                            "price_list_id" => $price_list['price_list_id']
                        );
                    }

                    if(count($aRecords) > 0)
                    {
                        $oProduct->price_lists()->detach();
                        $oProduct->price_lists()->attach($aRecords);
                    }
                }
            }

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
            //@var \App\Models\Api\Product
            $oProduct = Product::with(['category', 'price_lists', 'components', 'images'])
                                ->findOrFail($id);

            if ($oProduct !== null)
                return new ProductResource($oProduct);
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
     * @return \Illuminate\Http\Response
     */
    public function uploadProductImage(Request $request)
    {
        try {
            $file = $request->file('file');
            $file_name = uniqid().$file->getClientOriginalName();

            $file->storeAs("public/product_image_preview/", $file_name);

            return response()->json([
                'data' => ['src' => $file_name],
                'message' => __('api.messages.added_image')
            ], Response::HTTP_OK);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     * @return \Illuminate\Http\Response
     */
    public function deleteProductImage($image_src = false)
    {
        try {
            if($image_src)
            {
                if(File::exists(storage_path("app/public/product_image_preview/$image_src")))
                {
                    Storage::delete("public/product_image_preview/$image_src");

                }elseif(File::exists(storage_path("app/public/products_images/$image_src")))
                {
                    $oProductImage = ProductImage::where('src', $image_src)
                                                ->first();
                    if($oProductImage)
                    {
                        $oProductImage->delete();
                        Storage::delete("public/products_images/$image_src");
                    }
                }

                return response()->json([
                    'data' => [],
                    'message' => __('api.messages.deleted_image')
                ], Response::HTTP_OK);
            }

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
