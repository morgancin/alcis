<?php

namespace App\Http\Controllers\Api;

use Exception,
    Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request,
    Illuminate\Http\Response;

use App\Models\Api\Account;

use App\Http\Resources\AccountResource;
use App\Http\Requests\Api\AccountRequest;

//use App\Models\Api\Activity;
//use Illuminate\Http\JsonResponse;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //public function index(): JsonResponse
    public function index()
    {
        try	{
            //@var \App\Models\Api\Account
            $oAccounts = Account::get();

            if($oAccounts->count() > 0)
                return AccountResource::collection($oAccounts);
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
    public function store(AccountRequest $request)
    {
        $success = true;
        DB::beginTransaction();

        try	{
            //@var \App\Models\Account
            $oAccount = Account::create([
                                        "name" => ($request->name) ? $request->name : null,
                                        "tax_id" => ($request->tax_id) ? $request->tax_id : null,
                                        "website" => ($request->website) ? $request->website : null,
                                        "address" => ($request->address) ? $request->address : null,
                                        "active" => (($request->active) ? $request->active : false),
                                        "comments" => ($request->comments) ? $request->comments : null,
                                        "phone_office" => ($request->phone_office) ? $request->phone_office : null,
                                        "potential_value" => ($request->potential_value) ? $request->potential_value : null
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
    public function update(AccountRequest $request, $id)
    {
        $success = true;
        DB::beginTransaction();

        try {
            //@var \App\Models\Api\Account
            $oAccount = Account::findOrFail($id);

            $oAccount->update([
                "name" => ($request->name) ? $request->name : null,
                "tax_id" => ($request->tax_id) ? $request->tax_id : null,
                "website" => ($request->website) ? $request->website : null,
                "address" => ($request->address) ? $request->address : null,
                "active" => (($request->active) ? $request->active : false),
                "comments" => ($request->comments) ? $request->comments : null,
                "phone_office" => ($request->phone_office) ? $request->phone_office : null,
                "potential_value" => ($request->potential_value) ? $request->potential_value : null
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
            //@var \App\Models\Api\Account
            $oAccount = Account::findOrFail($id);

            if ($oAccount !== null)
                return new AccountResource($oAccount);
            else
                return response()->json(['message' => __('api.messages.notfound')], Response::HTTP_NO_CONTENT);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
