<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
	/**
     * Determine whether the user can view the =users.
     *
     * @param  \App\Models\User  $currentUser
     * @param  user
     * @return mixed
     */
    public function view(User $currentUser, User $user)
    {
        //
		return $currentUser->id === $user->id;
    }
     public function update(User $currentUser, User $user)
    {
        return $currentUser->id === $user->id;
    }
}
