<?php

namespace App\Traits;

use App\Models\User;

trait adminActions {

    public function before(User $user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }
}
