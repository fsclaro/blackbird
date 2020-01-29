<?php

namespace App;

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

    const ACTIVE_STATUS = [
        0 => 'Não',
        1 => 'Sim',
    ];

    const ACTIVE_COLOR = [
        0 => 'danger',
        1 => 'success',
    ];

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

    /**
     * -------------------------------------------------------------------
     * define relationship between user and logs
     * -------------------------------------------------------------------.
     *
     * @return void
     */
    public function logs()
    {
        return $this->hasMany(Logs::class);
    }

    /**
     * -------------------------------------------------------------------
     * define relationship between user and social identity
     * -------------------------------------------------------------------.
     *
     * @return void
     */
    public function identities()
    {
        return $this->hasMany(SocialIdentity::class);
    }

    /**
     * -------------------------------------------------------------------
     * define relationship between user and messages
     * -------------------------------------------------------------------.
     *
     * @return void
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * -------------------------------------------------------------------
     * define relationship between user and notifications
     * -------------------------------------------------------------------.
     *
     * @return void
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * -------------------------------------------------------------------
     * define relationship between user and roles
     * -------------------------------------------------------------------.
     *
     * @return void
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * -------------------------------------------------------------------
     * get user's avatar
     * -------------------------------------------------------------------.
     *
     * @param int $id
     *
     * @return void
     */
    public function getAvatar($id)
    {
        $avatar = User::find($id)->getMedia('avatars');

        if (count($avatar) <= 0) {
            return false;
        }

        $urlAvatar = $avatar[0]->getFullUrl();

        return $urlAvatar;
    }

    public function getMyRoleName()
    {
        $roles = self::roles()->first();

        if (null == $roles) {
            return false;
        }

        return $roles->title;
    }

    public function getMyRoleID()
    {
        $roles = self::roles()->first();

        if (null == $roles) {
            return false;
        }

        return $roles->id;
    }

    /**
     * -------------------------------------------------------------------
     * get the roles number of user authenticated
     * -------------------------------------------------------------------.
     *
     * @return void
     */
    public function numRoles()
    {
        return self::roles()->count();
    }

    /**
     * -------------------------------------------------------------------
     * get user id of user authenticated
     * -------------------------------------------------------------------.
     *
     * @return void
     */
    public function getMyID()
    {
        return self::id;
    }

    /**
     * -------------------------------------------------------------------
     * get user name of a user authenticated
     * -------------------------------------------------------------------.
     *
     * @return void
     */
    public function getMyName()
    {
        return $this->name;
    }

    /**
     * -------------------------------------------------------------------
     * get email of user authenticated
     * -------------------------------------------------------------------.
     *
     * @return void
     */
    public function getMyEmail()
    {
        return $this->email;
    }

    /**
     * -------------------------------------------------------------------
     * verify if user is superadmin
     * -------------------------------------------------------------------.
     *
     * @return void
     */
    public function isSuperAdmin()
    {
        return self::is_superadmin;
    }

    /**
     * -------------------------------------------------------------------
     * get datetime of email verificated
     * -------------------------------------------------------------------.
     *
     * @param [type] $value
     *
     * @return void
     */
    public function getEmailVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)
            ->format(config('panel.date_format').' '.config('panel.time_format')) : null;
    }

    /**
     * -------------------------------------------------------------------
     * set datetime for any email verificated
     * -------------------------------------------------------------------.
     *
     * @param [type] $value
     *
     * @return void
     */
    public function setEmailVerifiedAtAttribute($value)
    {
        $this->attributes['email_verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format').' '.
            config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    /**
     * -------------------------------------------------------------------
     * convert any password in your hashed version
     * -------------------------------------------------------------------.
     *
     * @param string $input
     *
     * @return void
     */
    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    /**
     * -------------------------------------------------------------------
     * notify the send password reset
     * -------------------------------------------------------------------.
     *
     * @param string $token
     *
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }
}
