<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Logs extends Model
{
    use SoftDeletes;

    protected $table = "logs";

    protected $fillable = [
        'ipaddress',
        'useragent',
        'url',
        'description',
        'details',
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public static function registerLog($url = null, $description = null, $details = null)
    {
        $ip = $_SERVER["REMOTE_ADDR"];
        $useragent = $_SERVER["HTTP_USER_AGENT"];
        $user = auth()->user()->id;

        Logs::create([
            'ipaddress' => $ip,
            'useragent' => $useragent,
            'url' => $url,
            'description' => $description,
            'details' => $details,
            'user_id' => $user,
            'created_at' => Carbon::now()
        ]);
    }

    public static function getUserLogs($nroRecords=null) {
        if($nroRecords > 0) {
            $logs = Logs::where('user_id', auth()->user()->id)
                ->orderBy('created_at', 'desc')
                ->take($nroRecords)
                ->get();
        } else {
            $logs = Logs::where('user_id', auth()->user()->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return $logs;
    }

}
