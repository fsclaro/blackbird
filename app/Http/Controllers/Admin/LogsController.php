<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Logs;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Logs  $logs
     * @return \Illuminate\Http\Response
     */
    public function edit(Logs $logs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Logs  $logs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Logs $logs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Logs  $logs
     * @return \Illuminate\Http\Response
     */
    public function destroy(Logs $logs)
    {
        abort_unless(\Gate::allows('log_access'), 403);

        $logs->delete();

        return back();
    }
}
