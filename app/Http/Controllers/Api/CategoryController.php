<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Api\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\Api\CategoryRequest;
use App\Http\Resources\SubCategoryResource;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($category_id = false)
    {
        try {
            //@var \App\Models\Api\Category
            $oCategories = Category::where('user_id', auth()->user()->id);
            $bSubCategories = false;

            if($category_id)
            {
                $bSubCategories = true;

                if($category_id == 'all')   //Get the subcategories
                    $oCategories->whereNotNull('category_id');
                else                        //Get the subcategories for the category
                    $oCategories->where('category_id', $category_id);
            }else                           //Get the categories
            {
                $oCategories->whereNull('category_id');
            }

            $oCategories = $oCategories->get();

            if ($oCategories->count() > 0)
            {
                if(!$bSubCategories) //Get the categories
                    return CategoryResource::collection($oCategories);
                else                //Get the sub categories or Get the sub categories for the category
                    return SubCategoryResource::collection($oCategories);
            }else
            {
                return response()->json(['message' => __('api.messages.notfound')], Response::HTTP_NOT_FOUND);
            }

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
    public function store(CategoryRequest $request)
    {
        $success = true;
        DB::beginTransaction();

        try	{
            //@var \App\Models\Product
            Category::create([
                "name" => $request->name,
                "order" => (($request->order) ? $request->order : null),
                "image" => (($request->image) ? $request->image : null),
                "active" => (($request->active) ? $request->active : null),
                "category_id" => (($request->category_id) ? $request->category_id : null),
                "category_group_id" => (($request->category_group_id) ? $request->category_group_id : null),
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
    public function update(CategoryRequest $request, $id)
    {
        $success = true;
        DB::beginTransaction();

        try {
            //@var \App\Models\Api\Category
            $oCategory = Category::findOrFail($id);

            $oCategory->update([
                "name" => $request->name,
                "order" => (($request->order) ? $request->order : null),
                "image" => (($request->image) ? $request->image : null),
                "active" => (($request->active) ? $request->active : null),
                "category_id" => (($request->category_id) ? $request->category_id : null),
                "category_group_id" => (($request->category_group_id) ? $request->category_group_id : null),
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
            //@var \App\Models\Api\Category
            $oCategory = Category::findOrFail($id);

            if ($oCategory !== null)
                return new CategoryResource($oCategory);
            else
                return response()->json(['message' => __('api.messages.notfound')], Response::HTTP_NOT_FOUND);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
