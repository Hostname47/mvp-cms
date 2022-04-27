<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClapPolicy
{
    use HandlesAuthorization;

    public function clap(User $user, $data) {
        return true;
    }
}
