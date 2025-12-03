<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserObserver
{
    public function creating(User $user)
    {
        $user->password = Hash::make($user->password);
        $user->verified_code = random_int(100000, 900000); // mt_rand(100000,900000);
    }
}
