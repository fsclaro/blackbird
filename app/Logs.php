<?php

namespace App;

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
        'action',
        'details',
        'user_id',
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

    public static function getIP()
    {
        //se possível, obtém o endereço ip da máquina do cliente
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            //verifica se o ip está passando pelo proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return $ip;
    }

    public static function getExternalIP()
    {
        return file_get_contents(env('EXTERNAL_IP'));
    }

    public static function prepareDetails($old = null, $new = null)
    {
        $content = null;

        if (null == $new) {
            foreach ($old->attributes as $key => $value) {
                $fields[] = [
                    'field' => $key,
                    'newValue' => $value,
                ];
            }
            $content = '
                <table class="table table-striped">
                    <thead>
                        <th>Campo</th>
                        <th>Valor</th>
                    </thead>
                    <tbody>';
            for ($i=0; $i < count($fields); $i++) {
                $content .= '
                <tr>
                    <td>' . $fields[$i]["field"] . '</td>
                    <td>' . $fields[$i]["newValue"] . '</td>
                </tr>';
            }
            $content .= '
                    </tbody>
                </table>
            ';
        } else {
            foreach ($old->attributes as $key => $value) {
                $fields[] = [
                    'field' => $key,
                    'newValue' => $value,
                ];
            }
            $content = '
                <table class="table table-striped">
                    <thead>
                        <th>Campo</th>
                        <th>Valor</th>
                    </thead>
                    <tbody>';
            for ($i=0; $i < count($fields); $i++) {
                $content .= '
                <tr>
                    <td>' . $fields[$i]["field"] . '</td>
                    <td>' . $fields[$i]["newValue"] . '</td>
                </tr>';
            }
            $content .= '
                    </tbody>
                </table>
            ';

        }

        return $content;
    }

    public static function registerLog($action = null, $details = null, $url = null)
    {
        $ip = self::getIP();
        $externalIp = self::getExternalIP();
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        $user = auth()->user()->id;

        if (null == $url) {
            $url = url()->current();
        }

        Logs::create([
            'ipaddress' => $ip,
            'externalip' => $externalIp,
            'useragent' => $useragent,
            'url' => $url,
            'action' => $action,
            'details' => $details,
            'user_id' => $user,
        ]);
    }

    public static function getUserLogs($nroRecords = null)
    {
        if ($nroRecords > 0) {
            $logs = Logs::where('user_id', auth()->user()->id)
                ->orderBy('created_at', 'desc')
                ->paginate($nroRecords);
        } else {
            $logs = Logs::where('user_id', auth()->user()->id)
                ->orderBy('created_at', 'desc')
                ->paginate(5);
        }

        return $logs;
    }
}
