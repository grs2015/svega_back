<?php

namespace App\Policies;

use App\Models\Main;
use App\Models\User;
use App\Traits\adminActions;
use Illuminate\Auth\Access\HandlesAuthorization;

class MainPolicy
{
    use HandlesAuthorization, adminActions;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(?User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Main  $main
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(?User $user, Main $main)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Main  $main
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Main $main)
    {
        return $user->isEditor();
    }


}
