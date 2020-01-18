<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notification;
use Auth;
use Gate;
use App\Logs;


class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(Gate::allows('notification_access'), 403);

        $notifications = Notification::where('user_id', Auth::user()->id)->get();

        return view('admin.notifications.index', compact('notifications'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_unless(\Gate::allows('notification_show'), 403);

        $notification = Notification::find($id);

        $this->updateIsReadAttribute($notification);

        return view('admin.notifications.show', compact('notification'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_unless(\Gate::allows('notification_delete'), 403);

        try {
            Notification::where('id', $id)->delete();

            Logs::registerLog('Excluiu uma notificação do sistema.');
            alert()->success('Notificação excluída com sucesso!')->toToast('top-end');
        } catch (\Throwable $th) {
            alert()->error('Esta notificação não pode ser excluída')->toToast('top-end');
        }

        return back();
    }


    public function updateIsReadAttribute(Notification $notification) {

        if(! $notification->is_read) {
            $record = [
                'id' => $notification->id,
                'user_id' => $notification->user_id,
                'title' => $notification->title,
                'content' => $notification->content,
                'icon' => $notification->icon,
                'url' => $notification->url,
                'is_read' => true,
                'created_at' => $notification->created_at,
                'updated_at' => now(),
            ];

            $notification->update($record);
        }
    }


    public function storeNotification(array $users_id, $title, $content, $icon = null, $url = null) {

        for($i=0; $i<count($users_id); $i++) {
            Notification::create([
                'user_id' => $users_id[$i],
                'title' => $title,
                'content' => $content,
                'icon' => $icon,
                'url' => $url,
                'is_read' => false,
                'created_at' => now()
            ]);
        }
    }
}
