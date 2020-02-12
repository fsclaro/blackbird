<?php

namespace App;

use Auth;
use Session;
use App\Helpers\Helpers;
use Illuminate\Database\Eloquent\Model;
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
        'is_read',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
    ];

    public function user()
    {
        return $this->BelongsTo(User::class);
    }

    /**
     * =================================================================
     * store a user activity.
     * =================================================================.
     *
     * @param string $title
     * @param string $details
     * @param string $url
     *
     * @return void
     */
    public static function storeActivity($title = null, $details = null, $url = null)
    {
        $ip = Helpers::getIP();
        $externalIp = Helpers::getExternalIP();
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        $user = Auth::user()->id;

        if (null == $url) {
            $url = url()->current();
        }

        Activity::create([
            'ipaddress' => $ip,
            'externalip' => $externalIp,
            'useragent' => $useragent,
            'url' => $url,
            'title' => $title,
            'details' => $details,
            'user_id' => $user,
            'is_read' => false,
        ]);
    }

    /**
     * =================================================================
     * return all activities for a user.
     * =================================================================.
     *
     * @param int $user_id
     *
     * @return void
     */
    public static function getActivities($user_id)
    {
        if (! isset($user_id)) {
            return;
        }

        $activity = Activity::where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return $activity;
    }

    /**
     * =================================================================
     * return activities for a authenticated user.
     * =================================================================.
     *
     * @param int $nroRecords
     *
     * @return void
     */
    public static function getUserActivities($nroRecords = null)
    {
        if ($nroRecords > 0) {
            $activities = Activity::where('user_id', Auth::user()->id)
                ->orderBy('created_at', 'desc')
                ->paginate($nroRecords);
        } else {
            $activities = Activity::where('user_id', Auth::user()->id)
                ->orderBy('created_at', 'desc')
                ->paginate(5);
        }

        Session::put('return_point', 'dashboard');

        return $activities;
    }

    /**
     * =================================================================
     * return only read activities for a user.
     * =================================================================.
     *
     * @param int $user_id
     *
     * @return void
     */
    public static function getActivitiesRead($user_id)
    {
        if (! isset($user_id)) {
            return;
        }

        $activities = Activity::where('user_id', $user_id)
            ->where('is_read', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return $activities;
    }

    /**
     * =================================================================
     * return only no read activities for a user.
     * =================================================================.
     *
     * @param int $user_id
     *
     * @return void
     */
    public static function getActivitiesNotReaded($user_id)
    {
        if (! isset($user_id)) {
            return;
        }

        $activities = Activity::where('user_id', $user_id)
            ->where('is_read', false)
            ->orderBy('created_at', 'desc')
            ->get();

        return $activities;
    }
}
