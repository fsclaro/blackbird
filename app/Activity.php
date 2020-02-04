<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'ipaddress',
        'externalip',
        'useragent',
        'url',
        'title',
        'details',
        'user_id',
        'is_read'
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at'
    ];

    public function users() {
        return $this->BelongsTo(User:class);
    }
}
