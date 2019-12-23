<?php

namespace App\Policies;

use App\Content;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user is in the editors list.
     *
     * @param User $user
     * @param Content $content
     * @return bool
     */
    public function access(User $user, Content $content)
    {
        return $content->editors()->where('user_id', $user->id)->exists();
    }
}
