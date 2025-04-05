<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OauthProvider extends Model
{
    protected $table = 'oauth_providers';

    protected $fillable = [
        'name',
        'icon',
        'client_id',
        'client_secret',
        'enabled',
    ];

    public function userSocialAccounts()
    {
        return $this->hasMany(UserSocialAccount::class);
    }
}