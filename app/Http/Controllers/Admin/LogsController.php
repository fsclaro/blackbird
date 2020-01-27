<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Logs;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class LogsController extends Controller
{
    /**
     * ---------------------------------------------------------------
     * Display a listing of the resource.
     * ---------------------------------------------------------------
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(Gate::allows('log_access') || Auth::user()->is_superadmin, 403);

        $logs = Logs::orderBy('created_at', 'desc')->get();

        return view('admin.logs.index', compact('logs'));
    }

    /**
     * ---------------------------------------------------------------
     * Display the specified resource.
     * ---------------------------------------------------------------
     *
     * @param  \App\Logs  $logs
     * @return \Illuminate\Http\Response
     */
    public function show(Logs $log)
    {
        abort_unless(Gate::allows('log_access') || Auth::user()->is_superadmin, 403);

        return view('admin.logs.show', compact('log'));
    }

    /**
     * ---------------------------------------------------------------
     * Remove the specified resource from storage.
     * ---------------------------------------------------------------
     *
     * @param  \App\Logs  $logs
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_unless(Gate::allows('log_access') || Auth::user()->is_superadmin, 403);

        try {
            $log = Logs::find($id);
            Logs::where('id', $id)->delete();

            Logs::registerLog('Excluiu um log de ID '.$log->id.' do sistema.');
            alert()->success('Log excluído com sucesso!')->toToast('top-end');
        } catch (\Throwable $th) {
            alert()->error('Este log não pode ser excluído')->toToast('top-end');
        }

        return back();
    }
}
