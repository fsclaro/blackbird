<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Permission;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Http\Requests\MassDestroyPermissionRequest;

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

            alert()->success('Permissão criada com sucesso!')->toToast('top-end');
        } catch (\Throwable $th) {
            alert()->error('Ocorreu um erro.Este registro não pode ser criado!')->toToast('top-end');
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

            alert()->success('Permissão alterada com sucesso!')->toToast('top-end');
        } catch (\Throwable $th) {
            alert()->error('Ocorreu um erro. Este registro não pode ser alterado!')->toToast('top-end');
        }

        return redirect()->route('admin.permissions.index');
    }

    public function destroy(Permission $permission)
    {
        abort_unless(\Gate::allows('permission_delete'), 403);

        try {
            $permission->delete();
            alert()->success('Permissão excluída com sucesso!')->toToast('top-end');
        } catch (\Throwable $th) {
            alert()->error('Esta permissão não pode ser excluída')->toToast('top-end');
        }

        return back();
    }

    public function massDestroy(MassDestroyPermissionRequest $request)
    {
        Permission::whereIn('id', request('ids'))->delete();

        return response(null, 204);
    }
}
