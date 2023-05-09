<?php

namespace App\Models\Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

/**
 * Class User.
 */
class User extends Authenticatable{
    public function generateApiToken()
    {
        $this->api_token = Str::random(60);
        $this->save();

        return $this->api_token;
    }
}
