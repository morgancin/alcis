<?php

namespace App\Observers\Api;

use App\Models\User;
use App\Models\Api\ClientAddress;

class UserObserver
{
    /**
     * Handle the Client "created" event.
     *
     * @param  \App\Models\Api\Client  $client
     * @return void
     */
    public function created(User $user)
    {
        if(isset(request()->street))
        {
            if (request()->role !== 'userleader' && request()->role !== 'usercompany')
            {
                $user->profile->create([
                    'language' => 'en'
                ]);
            }
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
