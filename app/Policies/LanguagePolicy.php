<?php

namespace App\Policies;

use App\Language;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LanguagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user is in the editors list.
     *
     * @param User $user
     * @param Language $language
     * @return bool
     */
    public function access(User $user, Language $language)
    {
        return $language->editors()->where('user_id', $user->id)->exists();
    }
}
