<?php

namespace App\Policies;

use App\User;
use App\ViewNewPhytos1;
use Illuminate\Auth\Access\HandlesAuthorization;

class ViewNewPhytos1Policy
{
    use HandlesAuthorization;


    public function before($user, $ability)
    {
        if ($user->id_right == 2 || $user->id_right == 3)
            return true;
    }

    /**
     * Determine whether the user can view the viewNewSamples.
     *
     * @param  \App\User  $user
     * @param  \App\ViewNewSamples  $viewNewSamples
     * @return mixed
     */
    public function view(User $user)//, ViewNewSamples $viewNewSamples
    {
        //
        if ($user->id_right == 1 || $user->id_right == 4)
            return true;
    }

    /**
     * Determine whether the user can create viewNewSamples.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        /**
        if($user->right == 1)
            return true;
        else
            return false;
         */
        //
    }

    /**
     * Determine whether the user can update the viewNewSamples.
     *
     * @param  \App\User  $user
     * @param  \App\ViewNewSamples  $viewNewSamples
     * @return mixed
     */
    public function update(User $user)//, ViewNewSamples $viewNewSamples
    {
        if ($user->id_right == 4)
            return true;
        //
    }

    /**
     * Determine whether the user can delete the viewNewSamples.
     *
     * @param  \App\User  $user
     * @param  \App\ViewNewSamples  $viewNewSamples
     * @return mixed
     */
    public function delete(User $user, ViewNewPhytos1 $viewNewPhytos1)
    {
        //
    }
}
