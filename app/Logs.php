<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Logs extends Model
{
    use SoftDeletes;

    protected $table = 'logs';

    protected $fillable = [
        'ipaddress',
        'externalip',
        'useragent',
        'url',
        'useragent',
        'title',
        'details',
        'user_id',
        'is_read',
        'created_at',
        'updated_at',
        'deleted_at',
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

    /**
     * =================================================================
     * return a local ip.
     * =================================================================
     *
     * @return void
     */
    public static function getIP()
    {
        //se possível, obtém o endereço ip da máquina do cliente
        if (! empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (! empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            //verifica se o ip está passando pelo proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return $ip;
    }

    /**
     * =================================================================
     * return a external ip.
     * =================================================================
     *
     * @return void
     */
    public static function getExternalIP()
    {
        return file_get_contents(env('EXTERNAL_IP'));
    }

    /**
     * =================================================================
     * store a record log.
     * =================================================================
     *
     * @param string $title
     * @param string $details
     * @param string $url
     *
     * @return void
     */
    public static function registerLog($title = null, $details = null, $url = null)
    {
        $ip = self::getIP();
        $externalIp = self::getExternalIP();
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        $user = Auth::user()->id;

        if (null == $url) {
            $url = url()->current();
        }

        Logs::create([
            'ipaddress' => $ip,
            'externalip' => $externalIp,
            'useragent' => $useragent,
            'url' => $url,
            'action' => $title,
            'details' => $details,
            'user_id' => $user,
            'is_read' => false,
        ]);
    }

    /**
     * =================================================================
     * return logs for a authenticated user.
     * =================================================================
     *
     * @param int $nroRecords
     *
     * @return void
     */
    public static function getUserLogs($nroRecords = null)
    {
        if ($nroRecords > 0) {
            $logs = Logs::where('user_id', Auth::user()->id)
                ->orderBy('created_at', 'desc')
                ->paginate($nroRecords);
        } else {
            $logs = Logs::where('user_id', Auth::user()->id)
                ->orderBy('created_at', 'desc')
                ->paginate(5);
        }

        return $logs;
    }

    /**
     * =================================================================
     * return all logs for a user.
     * =================================================================
     *
     * @param int $user_id
     *
     * @return void
     */
    public static function getLogs($user_id)
    {
        if (! isset($user_id)) {
            return;
        }

        $logs = Logs::where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return $logs;
    }

    /**
     * return only read logs for a user.
     *
     * @param int $user_id
     *
     * @return void
     */
    public static function getLogsRead($user_id)
    {
        if (! isset($user_id)) {
            return;
        }

        $logs = Logs::where('user_id', $user_id)
            ->where('is_read', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return $logs;
    }

    /**
     * return only no read logs for a user.
     *
     * @param int $user_id
     *
     * @return void
     */
    public static function getLogsNotReaded($user_id)
    {
        if (! isset($user_id)) {
            return;
        }

        $logs = Logs::where('user_id', $user_id)
            ->where('is_read', false)
            ->orderBy('created_at', 'desc')
            ->get();

        return $logs;
    }
}
