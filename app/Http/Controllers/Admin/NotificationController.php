<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Logs;
use App\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class NotificationController extends Controller
{
    public function index()
    {
        abort_unless(Gate::allows('notification_access') || Auth::user()->is_superadmin, 403);

        $notifications = Notification::where('user_id', Auth::user()->id)->get();

        return view('admin.notifications.index', compact('notifications'));
    }

    public function show($id)
    {
        abort_unless(Gate::allows('notification_show') || Auth::user()->is_superadmin, 403);

        $notification = Notification::find($id);

        $this->updateIsReadAttribute($notification);

        return view('admin.notifications.show', compact('notification'));
    }

    public function destroy($id)
    {
        abort_unless(Gate::allows('notification_delete') || Auth::user()->is_superadmin, 403);

        try {
            Notification::where('id', $id)->delete();

            Logs::registerLog('Excluiu uma notificação do sistema.');
            alert()->success('Notificação excluída com sucesso!')->toToast('top-end');
        } catch (\Throwable $th) {
            alert()->error('Esta notificação não pode ser excluída')->toToast('top-end');
        }

        Logs::registerLog('Excluiu a notificação ID '.$id);

        return back();
    }

    public function updateIsReadAttribute(Notification $notification)
    {
        if (! $notification->is_read) {
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

    public function storeNotification(array $users_id, $title, $content, $icon = null, $url = null)
    {
        for ($i = 0; $i < count($users_id); $i++) {
            Notification::create([
                'user_id' => $users_id[$i],
                'title' => $title,
                'content' => $content,
                'icon' => $icon,
                'url' => $url,
                'is_read' => false,
                'created_at' => now(),
            ]);
        }
    }

    public function read(Request $request)
    {
        abort_unless(Gate::allows('notification_access') || Auth::user()->is_superadmin, 403);

        $ids = $request->data;
        for ($i = 0; $i < count($ids); $i++) {
            Notification::where('id', $ids[$i])
                ->update([
                    'is_read' => true,
                    'updated_at' => now(),
                ]);
            Logs::registerLog('Mudou o status da notificação ID '.$ids[$i].' para LIDO');
        }
    }

    public function unread(Request $request)
    {
        abort_unless(Gate::allows('notification_access') || Auth::user()->is_superadmin, 403);

        $ids = $request->data;
        for ($i = 0; $i < count($ids); $i++) {
            Notification::where('id', $ids[$i])
                ->update([
                    'is_read' => false,
                    'updated_at' => now(),
                ]);
            Logs::registerLog('Mudou o status da notificação ID '.$ids[$i].' para NÃO LIDO');
        }
    }

    public function deleteall(Request $request)
    {
        abort_unless(Gate::allows('notification_access') || Auth::user()->is_superadmin, 403);

        $ids = $request->data;
        for ($i = 0; $i < count($ids); $i++) {
            Notification::where('id', $ids[$i])
                ->update([
                    'deleted_at' => now(),
                ]);
            Logs::registerLog('Excluiu a notificação ID '.$ids[$i]);
        }
    }
}
