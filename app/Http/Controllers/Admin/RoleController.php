<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use App\Permission;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Logs;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;

class RoleController extends Controller
{
    public function index()
    {
        abort_unless(\Gate::allows('role_access'), 403);

        $roles = Role::all();

        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        abort_unless(\Gate::allows('role_create'), 403);

        $permissions = Permission::all()->pluck('title', 'id');

        return view('admin.roles.create', compact('permissions'));
    }

    public function store(StoreRoleRequest $request)
    {
        abort_unless(\Gate::allows('role_create'), 403);

        try {
            $role = Role::create($request->all());
            $role->permissions()->sync($request->input('permissions', []));

            Logs::registerLog('Cadastrou novo papel no sistema.');
            alert()->success('Papel criado com sucesso!')->toToast('top-end');
        } catch (\Throwable $th) {
            alert()->error('Ocorreu um erro. Este registro não pode ser criado!')->toToast('top-end');
        }

        return redirect()->route('admin.roles.index');
    }

    public function show(Role $role)
    {
        abort_unless(\Gate::allows('role_show'), 403);

        $role->load('permissions');

        return view('admin.roles.show', compact('role'));
    }

    public function edit(Role $role)
    {
        abort_unless(\Gate::allows('role_edit'), 403);

        $permissions = Permission::all()->pluck('title', 'id');

        $role->load('permissions');

        return view('admin.roles.edit', compact('permissions', 'role'));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        abort_unless(\Gate::allows('role_edit'), 403);

        try {
            $role->update($request->all());
            $role->permissions()->sync($request->input('permissions', []));

            Logs::registerLog('Alterou dados de um papel do sistema.');
            alert()->success('Papel alterado com sucesso!')->toToast('top-end');
        } catch (\Throwable $th) {
            alert()->error('Ocorreu um erro. Este registro não pode ser alterado!')->toToast('top-end');
        }

        return redirect()->route('admin.roles.index');
    }

    public function destroy($id)
    {
        abort_unless(\Gate::allows('role_delete'), 403);

        try {
            $role = Role::find($id);
            Role::where('id', $id)->delete();

            Logs::registerLog('Excluiu o papel com o ID ' . $role->id . ' e nome ' . $role->title);
            alert()->success('Papel excluído com sucesso!')->toToast('top-end');
        } catch (\Throwable $th) {
            alert()->error('Este papel não pode ser excluído')->toToast('top-end');
        }

        return back();
    }


    public function clone(Request $request)
    {
        abort_unless(\Gate::allows('role_clone'), 403);

        $ids = $request->data;
        for ($i = 0; $i < count($ids); $i++) {
            $role = Role::find($ids[$i]);
            $permissions = $role->permissions;

            $newRole = [
                'title' => $role->title . " cópia",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];

            $role = Role::create($newRole);
            $role->permissions()->sync($permissions);

            Logs::registerLog('Clonou o papel <span class="text-red text-bold">' . $role->title .
                '</span> com o nome <span class="text-red text-bold">' . $role->title . " cópia</span>");
        }
    }

    public function deleteRoles(Request $request)
    {
        abort_unless(\Gate::allows('role_delete'), 403);

        $ids = $request->data;
        for ($i = 0; $i < count($ids); $i++) {
            $role = Role::find($ids[$i]);
            Role::where('id', $ids[$i])->delete();
            Logs::registerLog('Excluiu o papel <span class="text-red text-bold">' . $role->title . '</span>');
        }
    }


}
