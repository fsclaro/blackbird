<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Session;
use App\Logs;
use App\Permission;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;

class PermissionController extends Controller
{
    public function index()
    {
        abort_unless(Gate::allows('permission_access') || Auth::user()->is_superadmin, 403);

        $permissions = Permission::all();

        return view('admin.permissions.index', compact('permissions'));
    }

    public function create()
    {
        abort_unless(Gate::allows('permission_create') || Auth::user()->is_superadmin, 403);

        return view('admin.permissions.create');
    }

    public function store(StorePermissionRequest $request)
    {
        abort_unless(Gate::allows('permission_create') || Auth::user()->is_superadmin, 403);

        try {
            $permission = Permission::create($request->all());

            $details = $this->prepareDetailsNew($permission);
            Logs::registerLog('Cadastrou uma nova permissão no sistema.', $details);
            alert()->success('Permissão criada com sucesso!')->toToast('top-end');
        } catch (\Throwable $th) {
            alert()->error('Ocorreu um erro. Este registro não pode ser criado!')->toToast('top-end');
        }

        return redirect()->route('admin.permissions.index');
    }

    public function show(Permission $permission)
    {
        abort_unless(Gate::allows('permission_show') || Auth::user()->is_superadmin, 403);

        return view('admin.permissions.show', compact('permission'));
    }

    public function edit(Permission $permission)
    {
        abort_unless(Gate::allows('permission_edit') || Auth::user()->is_superadmin, 403);

        $this->savePermission($permission);

        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        abort_unless(Gate::allows('permission_edit') || Auth::user()->is_superadmin, 403);

        try {
            $permission->update($request->all());

            $details = $this->prepareDetailsUpdate($this->getPermission(), $permission);

            Logs::registerLog('Alterou dados de uma permissão do sistema.', $details);
            alert()->success('Permissão alterada com sucesso!')->toToast('top-end');
        } catch (\Throwable $th) {
            alert()->error('Ocorreu um erro. Este registro não pode ser alterado!')->toToast('top-end');
        }

        return redirect()->route('admin.permissions.index');
    }

    public function destroy($id)
    {
        abort_unless(Gate::allows('permission_delete') || Auth::user()->is_superadmin, 403);

        try {
            Permission::where('id', $id)->delete();

            Logs::registerLog('Excluiu uma permissão do sistema.');
            alert()->success('Permissão excluída com sucesso!')->toToast('top-end');
        } catch (\Throwable $th) {
            alert()->error('Esta permissão não pode ser excluída')->toToast('top-end');
        }

        return back();
    }

    public function prepareDetailsNew($newData)
    {
        $content = '';

        $fields[] = ['field' => 'ID', 'value' => $newData->id];
        $fields[] = ['field' => 'Descrição da Permissão', 'value' => $newData->title];
        $fields[] = ['field' => 'Slug', 'value' => $newData->slug];

        $content = '
            <table class="table table-striped" width="100%">
                <thead class="thead-light">
                    <th>Campo</th>
                    <th>Valor</th>
                </thead>
                <tbody>';
        for ($i = 0; $i < count($fields); $i++) {
            $content .= '
            <tr>
                <td>'.$fields[$i]['field'].'</td>
                <td>'.$fields[$i]['value'].'</td>
            </tr>';
        }
        $content .= '
                </tbody>
            </table>
        ';

        return $content;
    }

    /**
     * =================================================================
     * prepara a linha de detalhes do registro na operação de alteração
     * =================================================================.
     *
     * @param [type] $oldData
     * @param [type] $newData
     * @return void
     */
    public function prepareDetailsUpdate($oldData, $newData)
    {
        $fields[] = ['field' => 'ID', 'oldvalue' => $oldData->id, 'newvalue' => $newData->id];
        $fields[] = ['field' => 'Descrição da Permissão', 'oldvalue' => $oldData->title, 'newvalue' => $newData->title];
        $fields[] = ['field' => 'Slug', 'oldvalue' => $oldData->slug, 'newvalue' => $newData->slug];

        $content = '
            <table class="table table-striped" width="100%">
                <thead class="thead-light">
                    <th>Campo</th>
                    <th>Valor Anterior</th>
                    <th>Valor Novo</th>
                </thead>
                <tbody>';

        for ($i = 0; $i < count($fields); $i++) {
            $content .= '
            <tr>
                <td>'.$fields[$i]['field'].'</td>
                <td>'.$fields[$i]['oldvalue'].'</td>
                <td>'.$fields[$i]['newvalue'].'</td>
            </tr>';
        }
        $content .= '
                </tbody>
            </table>
        ';

        return $content;
    }

    /**
     * =================================================================
     * salva numa session os dados do registro atual
     * =================================================================.
     *
     * @param [type] $permission
     * @return void
     */
    private function savePermission($permission)
    {
        Session::put('permission', $permission);
    }

    /**
     * =================================================================
     * recupera os dados salvos do registro atual
     * =================================================================.
     *
     * @return void
     */
    private function getPermission()
    {
        $r = Session::get('permission');
        Session::forget('permission');

        return $r;
    }
}
