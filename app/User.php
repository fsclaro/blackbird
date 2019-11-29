<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Auth;

class User extends Authenticatable implements HasMedia
{
    use SoftDeletes, Notifiable, HasMediaTrait;

    protected $fillable = [
        'name',
        'email',
        'password',
        'active',
        'skin',
        'created_at',
        'updated_at',
        'deleted_at',
        'remember_token',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
        'email_verified_at',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function identities()
    {
        return $this->hasMany('App\SocialIdentity');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }


    public function getAvatar($id)
    {
        $avatar = User::find($id)->getMedia('avatars');

        if (count($avatar) <= 0) {
            return false;
        }

        $urlAvatar = $avatar[0]->getFullUrl();

        return $urlAvatar;
    }

    public function getRolesNames()
    {
        $roles = Auth::user()->roles;

        foreach ($roles as $key => $value) {
            $title[] = $value->title;
        }

        return $title;
    }

    public function getFirstRoleName()
    {
        $roles = Auth::user()->roles[0];

        return $roles->title;
    }
}
