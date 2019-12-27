<?php

namespace App;

use Auth;
use Hash;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;

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

    public function logs()
    {
        return $this->hasMany('App\Logs');
    }

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

    public function myID()
    {
        return Auth::user()->id;
    }

    public function myName()
    {
        return Auth::user()->name;
    }

    public function myEmail()
    {
        return Auth::user()->email;
    }

    public function numRoles()
    {
        return Auth::user()->roles->count();
    }

    public function getEmailVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format').' '.config('panel.time_format')) : null;
    }

    public function setEmailVerifiedAtAttribute($value)
    {
        $this->attributes['email_verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format').' '.config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }
}
