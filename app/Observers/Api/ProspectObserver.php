<?php

namespace App\Observers\Api;

use App\Models\Api\Prospect;
use App\Models\Api\ProspectAddress;

class ProspectObserver
{
    /**
     * Handle the Prospect "created" event.
     *
     * @param  \App\Models\Api\Prospect  $prospect
     * @return void
     */
    public function created(Prospect $prospect)
    {
        $aAdress = [];

        if(isset(request()->street))
        {
            if (!empty(request()->street))
            {
                $aAdress['street'] = request()->street;
            }
        }

        if(isset(request()->outdoor))
        {
            if (!empty(request()->outdoor))
            {
                $aAdress['outdoor'] = request()->outdoor;
            }
        }

        if(isset(request()->indoor))
        {
            if (!empty(request()->indoor))
            {
                $aAdress['indoor'] = request()->indoor;
            }
        }

        if(isset(request()->suburb))
        {
            if (!empty(request()->suburb))
            {
                $aAdress['suburb'] = request()->suburb;
            }
        }

        if(isset(request()->town))
        {
            if (!empty(request()->town))
            {
                $aAdress['town'] = request()->town;
            }
        }

        if(isset(request()->state))
        {
            if (!empty(request()->state))
            {
                $aAdress['state'] = request()->state;
            }
        }

        if(isset(request()->city))
        {
            if (!empty(request()->city))
            {
                $aAdress['city'] = request()->city;
            }
        }

        if(isset(request()->country))
        {
            if (!empty(request()->country))
            {
                $aAdress['country'] = request()->country;
            }
        }

        if(isset(request()->alias))
        {
            if (!empty(request()->alias))
            {
                $aAdress['alias'] = request()->alias;
            }
        }

        if(isset(request()->zipcode))
        {
            if (!empty(request()->zipcode))
            {
                $aAdress['zipcode'] = request()->zipcode;
            }
        }

        if(count($aAdress) > 0)
        {
            $aAdress['client_id'] = $prospect->id_client;

            ProspectAddress::create($aAdress);
        }
    }

    /**
     * Handle the Prospect "updated" event.
     *
     * @param  \App\Models\Api\Prospect  $prospect
     * @return void
     */
    /*
    public function updated(Prospect $prospect)
    {
        //
    }
    */

    /**
     * Handle the Prospect "deleted" event.
     *
     * @param  \App\Models\Api\Prospect  $prospect
     * @return void
     */
    /*
    public function deleted(Prospect $prospect)
    {
        //
    }
    */

    /**
     * Handle the Prospect "restored" event.
     *
     * @param  \App\Models\Api\Prospect  $prospect
     * @return void
     */
    /*
    public function restored(Prospect $prospect)
    {
        //
    }
    */

    /**
     * Handle the Prospect "force deleted" event.
     *
     * @param  \App\Models\Api\Prospect  $prospect
     * @return void
     */
    /*
    public function forceDeleted(Prospect $prospect)
    {
        //
    }
    */
}
