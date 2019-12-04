<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialIdentity extends Model
{
    use SoftDeletes;

    protected $table = 'social_identities';

    protected $fillable = [
        'user_id',
        'provider_name',
        'provider_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
