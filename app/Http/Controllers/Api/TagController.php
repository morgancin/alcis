<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Api\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TagRequest;
class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type = null)
    {
        try {
            //@var \App\Models\Api\Tag
            $oTags = Tag::where('user_id', auth()->user()->id);

            if($type !== 'all')
                $oTags->where('type', $type);

            $oTags = $oTags->get();

            if ($oTags->count() > 0)
                return response()->json($oTags, 200);
            else
                return response()->json(['message' => __('api.messages.notfound')], 404);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagRequest $request)
    {
        $success = true;
        DB::beginTransaction();

        try {
            //@var \App\Models\Api\Tag
            $oTag = Tag::create([
                                    //"user_id" => auth()->user()->id,
                                    "name" => $request->name,
                                    "type" => $request->type,
                                ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }

        if ($success === true) {
            DB::commit();

            return response()->json([
                'message' => __('api.messages.added')
            ], 200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TagRequest $request, $id)
    {
        $success = true;
        DB::beginTransaction();

        try {
            //@var \App\Models\Api\Client
            $oTag = Tag::findOrFail($id);

            $oTag->update([
                            "name" => $request->name,
                            "type" => $request->type,
                        ]);

        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }

        if ($success === true) {
            DB::commit();

            return response()->json([
                'message' => __('api.messages.updated')
            ], 200);
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
            //@var \App\Models\Api\Tag
            $oTag = Tag::findOrFail($id);

            if ($oTag !== null)
                return response()->json($oTag, Response::HTTP_OK);
            else
                return response()->json(['message' => __('api.messages.notfound')], Response::HTTP_NOT_FOUND);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
