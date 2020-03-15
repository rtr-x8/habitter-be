<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSocialAccount extends Model
{
    /**
     * User
     */
    public function post()
    {
        return $this->belongsTo('App\User');
    }
}
