<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Api\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ProfileRequest;

class ProfileController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(ProfileRequest $request)
    {
        $success = true;
        DB::beginTransaction();

        try	{
            $oProfile = Profile::where('user_id', auth()->id())->first();

            if(!$oProfile) {
                $oProfile = Profile::create([
                    'language' => $request->language,
                ]);
            }

        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }

        if ($success === true) {
            DB::commit();

            return response()->json([
                'data' => $oProfile,
                'message' => 'Registro insertado correctamente',
            ], 200);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($nId = FALSE)
    {
        try {
            if (auth()->user())
                return response()->json(auth()->user()->profile, 200);
            else
                return response()->json(['message' => __('api.messages.notfound')], 404);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileRequest $request)
    {
        $success = true;
        DB::beginTransaction();

        try {
            auth()->user()->profile->update([
                                            'language' => $request->language
                                        ]);

            App::setLocale($request->language);

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
}
