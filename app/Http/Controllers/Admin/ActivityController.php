<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Activity;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

use Session;

class ActivityController extends Controller
{
    /**
     * =================================================================
     * Display a listing of the resource.
     * =================================================================
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(Gate::allows('activity_access') || Auth::user()->is_superadmin, 403);

        $activities = Activity::orderBy('created_at', 'desc')->get();
        Session::put('return_point', 'admin');

        return view('admin.activities.index', compact('activities'));
    }


    /**
     * =================================================================
     * Display the specified resource.
     * =================================================================
     *
     * @param  \App\Activity  $activities

     * @return \Illuminate\Http\Response
     */
    public function show(Activity $activity)
    {
        abort_unless(Gate::allows('activity_show') || Auth::user()->is_superadmin, 403);

        $activity->update(['is_read' => 1]);

        return view('admin.activities.show', compact('activity'));
    }

    /**
     * =================================================================
     * Remove the specified resource from storage.
     * =================================================================
     *
     * @param  \App\Activity  $activities
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_unless(Gate::allows('activity_access') || Auth::user()->is_superadmin, 403);

        try {
            $activity = Activity::find($id);
            Activity::where('id', $id)->delete();

            Activity::storeActivity('Excluiu uma atividade de ID ' . $activity->id . ' do sistema.');
            alert()->success('Atividade excluída com sucesso!')->toToast('top-end');
        } catch (\Throwable $th) {
            alert()->error('Esta atividade não pode ser excluída')->toToast('top-end');
        }

        return back();
    }

    public function getAllUserActivities()
    {
        abort_unless(Gate::allows('activity_access') || Auth::user()->is_superadmin, 403);

        $activities = Activity::orderBy('created_at', 'desc')
            ->where('user_id', Auth::user()->id)
            ->get();

        Session::put('return_point', 'user');

        return view('admin.activities.index', compact('activities'));
    }

    /**
     * ---------------------------------------------------------------
     * change activities attribute is_read to true
     * ---------------------------------------------------------------.
     *
     * @param Request $request
     */
    public function readActivities(Request $request)
    {
        abort_unless(Gate::allows('activity_access') || Auth::user()->is_superadmin, 403);

        $ids = $request->data;
        for ($i = 0; $i < count($ids); $i++) {
            Activity::where('id', $ids[$i])->update(['is_read' => true]);
        }
    }

    /**
     * ---------------------------------------------------------------
     * change activities attribute is_read to false
     * ---------------------------------------------------------------.
     *
     * @param Request $request
     */
    public function unreadActivities(Request $request)
    {
        abort_unless(Gate::allows('activity_access') || Auth::user()->is_superadmin, 403);

        $ids = $request->data;
        for ($i = 0; $i < count($ids); $i++) {
            Activity::where('id', $ids[$i])->update(['is_read' => false]);
        }
    }

    /**
     * ---------------------------------------------------------------
     * delete activities from a user
     * ---------------------------------------------------------------
     *
     * @param Request $request
     *
     * @return void
     */
    public function deleteActivities(Request $request)
    {
        abort_unless(Gate::allows('activity_access') || Auth::user()->is_superadmin, 403);

        $ids = $request->data;

        $ids = $request->data;
        for ($i = 0; $i < count($ids); $i++) {
            Activity::where('id', $ids[$i])->delete();
            Activity::storeActivity('Excluiu a atividade de ID ' . $ids[$i]);
        }
    }



}
