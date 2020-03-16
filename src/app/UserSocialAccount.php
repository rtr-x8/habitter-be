<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSocialAccount extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'provider', 'account_id'
    ];

    /**
     * User
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
