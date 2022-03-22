<?php

namespace App\Policies;

use App\Models\Benefit;
use App\Models\User;
use App\Traits\adminActions;
use Illuminate\Auth\Access\HandlesAuthorization;

class BenefitPolicy
{
    use HandlesAuthorization, adminActions;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Benefit  $benefit
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Benefit $benefit)
    {
        return $user->isEditor();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Benefit  $benefit
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Benefit $benefit)
    {
        return $user->isEditor();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Benefit  $benefit
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Benefit $benefit)
    {
        return $user->isEditor();
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->isEditor();
    }
}
