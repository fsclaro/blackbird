<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use App\Permission;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Logs;
use Gate;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;

class RoleController extends Controller
{
    /**
     * =================================================================
     * exibe a listagem de papéis
     * =================================================================
     *
     * @return void
     */
    public function index()
    {
        abort_unless(Gate::allows('role_access'), 403);

        $roles = Role::all();

        return view('admin.roles.index', compact('roles'));
    }

    /**
     * =================================================================
     * exibe o formulário de cadastramento
     * =================================================================
     *
     * @return void
     */
    public function create()
    {
        abort_unless(Gate::allows('role_create'), 403);

        $permissions = Permission::all()->pluck('title', 'id');

        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * =================================================================
     * grava os dados no banco
     *
     * @param StoreRoleRequest $request
     * @return void
     */
    public function store(StoreRoleRequest $request)
    {
        abort_unless(Gate::allows('role_create'), 403);

        try {
            $role = Role::create($request->all());
            $role->permissions()->sync($request->input('permissions', []));

            $details = $this->prepareDetailsNew($role);
            Logs::registerLog('Cadastrou novo papel no sistema.', $details);
            toast('Papel criado com sucesso!', 'success');
        } catch (\Throwable $th) {
            toast('Ocorreu um erro. Este registro não pode ser criado!', 'error');
        }

        return redirect()->route('admin.roles.index');
    }

    /**
     * =================================================================
     * exibe os detalhes do registro
     * =================================================================
     *
     * @param Role $role
     * @return void
     */
    public function show(Role $role)
    {
        abort_unless(Gate::allows('role_show'), 403);

        $role->load('permissions');

        return view('admin.roles.show', compact('role'));
    }

    /**
     * =================================================================
     * exibe a tela de alteração
     * =================================================================
     *
     * @param Role $role
     * @return void
     */
    public function edit(Role $role)
    {
        abort_unless(Gate::allows('role_edit'), 403);

        $permissions = Permission::all()->pluck('title', 'id');

        $role->load('permissions');

        $this->saveRole($role);

        return view('admin.roles.edit', compact('permissions', 'role'));
    }

    /**
     * =================================================================
     * grava as alterações do registro
     * =================================================================
     *
     * @param UpdateRoleRequest $request
     * @param Role $role
     * @return void
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        abort_unless(Gate::allows('role_edit'), 403);

        try {
            $role->update($request->all());
            $role->permissions()->sync($request->input('permissions', []));

            $details = $this->prepareDetailsUpdate($this->getRole(), $role);
            Logs::registerLog('Alterou dados de um papel do sistema.', $details);

            alert()->success('Papel alterado com sucesso!')->toToast('top-end');
        } catch (\Throwable $th) {
            alert()->error('Ocorreu um erro. Este registro não pode ser alterado!')->toToast('top-end');
        }

        return redirect()->route('admin.roles.index');
    }

    /**
     * =================================================================
     * exclui o registro
     * =================================================================
     *
     * @param [type] $id
     * @return void
     */
    public function destroy($id)
    {
        abort_unless(Gate::allows('role_delete'), 403);

        try {
            $role = Role::find($id);
            Role::where('id', $id)->delete();

            Logs::registerLog('Excluiu o papel com o ID '.$role->id.' e nome '.$role->title);
            alert()->success('Papel excluído com sucesso!')->toToast('top-end');
        } catch (\Throwable $th) {
            alert()->error('Este papel não pode ser excluído')->toToast('top-end');
        }

        return back();
    }

    /**
     * =================================================================
     * clona os registros selecionados
     * =================================================================
     *
     * @param Request $request
     * @return void
     */
    public function clone(Request $request)
    {
        abort_unless(Gate::allows('role_clone'), 403);

        $ids = $request->data;
        for ($i = 0; $i < count($ids); ++$i) {
            $role = Role::find($ids[$i]);
            $permissions = $role->permissions;

            $newRole = [
                'title' => $role->title.' cópia',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            $role = Role::create($newRole);
            $role->permissions()->sync($permissions);

            Logs::registerLog('Clonou o papel <span class="text-red text-bold">'.$role->title.
                '</span> com o nome <span class="text-red text-bold">'.$role->title.' cópia</span>');
        }
    }

    /**
     * =================================================================
     * deleta em massa os registros selecionados
     * =================================================================
     *
     * @param Request $request
     * @return void
     */
    public function deleteRoles(Request $request)
    {
        abort_unless(Gate::allows('role_delete'), 403);

        $ids = $request->data;
        for ($i = 0; $i < count($ids); ++$i) {
            $role = Role::find($ids[$i]);
            Role::where('id', $ids[$i])->delete();
            Logs::registerLog('Excluiu o papel <span class="text-red text-bold">'.$role->title.'</span>');
        }
    }

    /**
     * =================================================================
     * prepara a linha de detalhes do registro na inclusão
     * =================================================================
     *
     * @param [type] $newRole
     * @return void
     */
    public function prepareDetailsNew($newRole)
    {
        $content = '';
        $permissions = $newRole->permissions;
        for ($i = 0; $i < count($permissions); ++$i) {
            $content .= "<span class='badge badge-primary'>".$permissions[$i]->title.'</span> ';
        }

        $fields[] = ['field' => 'ID', 'value' => $newRole->id];
        $fields[] = ['field' => 'Descrição do Papel', 'value' => $newRole->title];
        $fields[] = ['field' => 'Permissões', 'value' => $content];

        $content = '
            <table class="table table-striped" width="100%">
                <thead class="thead-light">
                    <th>Campo</th>
                    <th>Valor</th>
                </thead>
                <tbody>';
        for ($i = 0; $i < count($fields); ++$i) {
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
     * =================================================================
     *
     * @param [type] $oldRole
     * @param [type] $newRole
     * @return void
     */
    public function prepareDetailsUpdate($oldRole, $newRole)
    {
        $oldContent = '';
        $newContent = '';
        $oldPermissions = $oldRole->permissions;
        for ($i = 0; $i < count($oldPermissions); ++$i) {
            $oldContent .= "<span class='badge badge-primary'>".$oldPermissions[$i]->title.'</span> ';
        }

        $newPermissions = $newRole->permissions;
        for ($i = 0; $i < count($newPermissions); ++$i) {
            $newContent .= "<span class='badge badge-primary'>".$newPermissions[$i]->title.'</span> ';
        }

        $fields[] = [
            'field' => 'ID',
            'oldvalue' => $oldRole->id,
            'newvalue' => $newRole->id,
        ];
        $fields[] = [
            'field' => 'Descrição do Papel',
            'oldvalue' => $oldRole->title,
            'newvalue' => $newRole->title,
        ];
        $fields[] = [
            'field' => 'Permissões',
            'oldvalue' => $oldContent,
            'newvalue' => $newContent,
        ];

        $content = '
            <table class="table table-striped" width="100%">
                <thead class="thead-light">
                    <th>Campo</th>
                    <th>Valor Anterior</th>
                    <th>Valor Novo</th>
                </thead>
                <tbody>';

        for ($i = 0; $i < count($fields); ++$i) {
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
     * =================================================================
     *
     * @param [type] $role
     * @return void
     */
    private function saveRole($role)
    {
        Session::put('role', $role);
    }

    /**
     * =================================================================
     * recupera os dados salvos do registro atual
     * =================================================================
     *
     * @return void
     */
    private function getRole()
    {
        $r = Session::get('role');
        Session::forget('role');

        return $r;
    }
}
