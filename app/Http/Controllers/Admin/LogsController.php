<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Logs;

class LogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(\Gate::allows('log_access'), 403);

        $logs = Logs::orderBy('created_at', 'desc')->get();

        return view('admin.logs.index', compact('logs'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Logs  $logs
     * @return \Illuminate\Http\Response
     */
    public function show(Logs $log)
    {
        abort_unless(\Gate::allows('log_access'), 403);

        return view('admin.logs.show', compact('log'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Logs  $logs
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_unless(\Gate::allows('log_access'), 403);

        try {
            Logs::where('id', $id)->delete();
            Logs::registerLog('Excluiu um log do sistema.');
            alert()->success('Log excluído com sucesso!')->toToast('top-end');
        } catch (\Throwable $th) {
            alert()->error('Este log não pode ser excluído')->toToast('top-end');
        }

        return back();
    }
}
