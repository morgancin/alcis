<?php

namespace App\Observers\Api;

use App\Models\User;
use App\Models\Api\Profile;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        if(isset(request()->role))
        {
            if (request()->role !== 'userleader' && request()->role !== 'usercompany')
            {
                Profile::create([
                    'language' => 'en',
                    'user_id' => $user->id,
                ]);
            }
        }
    }
}
