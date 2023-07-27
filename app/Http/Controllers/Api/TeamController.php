<?php

namespace App\Http\Controllers\Api;

use Exception,
    Illuminate\Support\Facades\DB;

use Illuminate\Http\Request,
    Illuminate\Http\Response;

use App\Http\Controllers\Controller;

use App\Http\Resources\TeamResource;
use App\Http\Requests\Api\TeamRequest;

use App\Models\Api\Team;

class TeamController extends Controller
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
            //@var \App\Models\Api\Team
            $oTeams = Team::get();

            if($oTeams->count() > 0)
                return TeamResource::collection($oTeams);
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
    public function store(TeamRequest $request)
    {
        $success = true;
        DB::beginTransaction();

        try	{
            //@var \App\Models\Account
            $oTeam = Team::create([
                                    "name" => ($request->name) ? $request->name : null,
                                    "active" => ($request->active) ? $request->active : false,
                                    "is_carousel" => ($request->is_carousel) ? $request->is_carousel : null
                                ])->load(['users', 'prospecting_sources']);

            if($request->users)
            {
                $aUsers = array();

                foreach($request->users as $user)
                {
                    $aUsers[] = array(
                                    'user_id' => $user['id']
                                );
                }

                if(count($aUsers) > 0)
                {
                    $oTeam->users()->attach($aUsers);
                }
            }

            if($request->prospecting_sources)
            {
                $aProspecting_sources = array();

                foreach($request->prospecting_sources as $prospecting_sources)
                {
                    $aProspecting_sources[] = array(
                                                    'prospecting_source_id' => $prospecting_sources['id']
                                                );
                }

                if(count($aProspecting_sources) > 0)
                {
                    $oTeam->prospecting_sources()->attach($aProspecting_sources);
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
    public function update(TeamRequest $request, $id)
    {
        $success = true;
        DB::beginTransaction();

        try {
            //@var \App\Models\Api\Team
            $oTeam = Team::with(['users', 'prospecting_sources'])
                            ->findOrFail($id);

            $oTeam->update([
                            "name" => ($request->name) ? $request->name : null,
                            "active" => ($request->active) ? $request->active : false,
                            "is_carousel" => ($request->is_carousel) ? $request->is_carousel : null
                        ]);

            if($request->users)
            {
                $aUsers = array();

                foreach($request->users as $user)
                {
                    $aUsers[] = array(
                                    'user_id' => $user['id']
                                );
                }

                if(count($aUsers) > 0)
                {
                    $oTeam->users()->detach();
                    $oTeam->users()->attach($aUsers);
                }
            }

            if($request->prospecting_sources)
            {
                $aProspecting_sources = array();

                foreach($request->prospecting_sources as $prospecting_sources)
                {
                    $aProspecting_sources[] = array(
                                                    'prospecting_source_id' => $prospecting_sources['id']
                                                );
                }

                if(count($aProspecting_sources) > 0)
                {
                    $oTeam->prospecting_sources()->detach();
                    $oTeam->prospecting_sources()->attach($aProspecting_sources);
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
            //@var \App\Models\Api\Team
            $oTeam = Team::findOrFail($id);

            if ($oTeam !== null)
                return new TeamResource($oTeam);
            else
                return response()->json(['message' => __('api.messages.notfound')], Response::HTTP_NO_CONTENT);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
