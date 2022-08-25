<?php

namespace App\Observers\Api;

use App\Models\Api\Client;
use App\Models\Api\ClientAddress;

class ClientObserver
{
    /**
     * Handle the Client "created" event.
     *
     * @param  \App\Models\Api\Client  $client
     * @return void
     */
    public function created(Client $client)
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

        if(count($aAdress) > 0)
        {
            $aAdress['client_id'] = $client->id_client;

            ClientAddress::create($aAdress);
        }
    }

    /**
     * Handle the Client "updated" event.
     *
     * @param  \App\Models\Api\Client  $client
     * @return void
     */
    /*
    public function updated(Client $client)
    {
        //
    }
    */

    /**
     * Handle the Client "deleted" event.
     *
     * @param  \App\Models\Api\Client  $client
     * @return void
     */
    /*
    public function deleted(Client $client)
    {
        //
    }
    */

    /**
     * Handle the Client "restored" event.
     *
     * @param  \App\Models\Api\Client  $client
     * @return void
     */
    /*
    public function restored(Client $client)
    {
        //
    }
    */

    /**
     * Handle the Client "force deleted" event.
     *
     * @param  \App\Models\Api\Client  $client
     * @return void
     */
    /*
    public function forceDeleted(Client $client)
    {
        //
    }
    */
}
