<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Permission;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Logs;

class PermissionController extends Controller
{
    public function index()
    {
        abort_unless(Gate::allows('permission_access'), 403);

        $permissions = Permission::all();

        return view('admin.permissions.index', compact('permissions'));
    }

    public function create()
    {
        abort_unless(\Gate::allows('permission_create'), 403);

        return view('admin.permissions.create');
    }

    public function store(StorePermissionRequest $request)
    {
        abort_unless(\Gate::allows('permission_create'), 403);

        try {
            $permission = Permission::create($request->all());

            Logs::registerLog('Cadastrou uma nova permissão no sistema.');
            alert()->success('Permissão criada com sucesso!')->toToast('top-end');
        } catch (\Throwable $th) {
            alert()->error('Ocorreu um erro. Este registro não pode ser criado!')->toToast('top-end');
        }

        return redirect()->route('admin.permissions.index');
    }

    public function show(Permission $permission)
    {
        abort_unless(\Gate::allows('permission_show'), 403);

        return view('admin.permissions.show', compact('permission'));
    }

    public function edit(Permission $permission)
    {
        abort_unless(\Gate::allows('permission_edit'), 403);

        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        abort_unless(\Gate::allows('permission_edit'), 403);

        try {
            $permission->update($request->all());
            $permission->save();

            Logs::registerLog('Alterou dados de uma permissão do sistema.');
            alert()->success('Permissão alterada com sucesso!')->toToast('top-end');
        } catch (\Throwable $th) {
            alert()->error('Ocorreu um erro. Este registro não pode ser alterado!')->toToast('top-end');
        }

        return redirect()->route('admin.permissions.index');
    }

    public function destroy($id)
    {
        abort_unless(\Gate::allows('permission_delete'), 403);

        try {
            Permission::where('id', $id)->delete();

            Logs::registerLog('Excluiu uma permissão do sistema.');
            alert()->success('Permissão excluída com sucesso!')->toToast('top-end');
        } catch (\Throwable $th) {
            alert()->error('Esta permissão não pode ser excluída')->toToast('top-end');
        }

        return back();
    }
}
