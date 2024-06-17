<?php

namespace App\Tags;

use Statamic\Tags\Tags;
use Illuminate\Support\Facades\Auth;

class AuthTags extends Tags
{

    /**
     * The {{ auth:is_logged_in }} tag.
     *
     * @return bool
     */
    public function isLoggedIn()
    {

        return Auth::check();
    }

    /**
     * The {{ auth:user }} tag.
     *
     * @return array|null
     */
    public function user()
    {
        return Auth::user()->toArray();
    }
}
