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
    public function store(AccountRequest $request)
    {
        $success = true;
        DB::beginTransaction();

        try	{
            //@var \App\Models\Account
            $oAccount = Account::create([
                                        "name" => $request->name,
                                    ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }

        if ($success === true) {
            DB::commit();

            //return new ActivityResource($oActivity);

            return response()->json([
                'message' => __('api.messages.added')
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
            //@var \App\Models\Api\Account
            $oAccount = Account::findOrFail($id);

            if ($oAccount !== null)
                return new AccountResource($oAccount);
            else
                return response()->json(['message' => __('api.messages.notfound')], Response::HTTP_NOT_FOUND);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
