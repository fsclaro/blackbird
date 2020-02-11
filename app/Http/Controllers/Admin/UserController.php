<?php

namespace App\Http\Controllers\Admin;

use Session;
use App\Activity;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UpdateProfileUserRequest;

class UserController extends Controller
{
    /**
     * ---------------------------------------------------------------
     * index method
     * ---------------------------------------------------------------.
     */
    public function index()
    {
        abort_unless(Gate::allows('user_access') || Auth::user()->is_superadmin, 403);

        $users = User::all();

        Session::put('return_path', route('admin.users.index'));

        return view('admin.users.index', compact('users'));
    }

    /**
     * ---------------------------------------------------------------
     * create method
     * ---------------------------------------------------------------.
     */
    public function create()
    {
        abort_unless(Gate::allows('user_create') || Auth::user()->is_superadmin, 403);

        $roles = Role::all()->pluck('title', 'id');

        return view('admin.users.create', compact('roles'));
    }

    /**
     * ---------------------------------------------------------------
     * store method
     * ---------------------------------------------------------------.
     *
     * @param StoreUserRequest $request
     */
    public function store(StoreUserRequest $request)
    {
        abort_unless(Gate::allows('user_create') || Auth::user()->is_superadmin, 403);

        try {
            $user = User::create($request->all());
            $user->roles()->sync($request->input('roles', []));

            $details = $this->prepareDetailsNew($user);

            if (isset($request['avatar'])) {
                $user->addMediaFromRequest('avatar')->toMediaCollection('avatars');
            }

            Activity::storeActivity('Cadastrou o usuário ' . $user->name . ' no sistema.', $details);
            alert()->success('Usuário criado com sucesso!')->toToast('top-end');
        } catch (\Throwable $th) {
            alert()->error('Ocorreu algum problema na inclusão deste usuário!')->toToast('top-end');
        }

        return redirect()->route('admin.users.index');
    }

    /**
     * ---------------------------------------------------------------
     * edit method
     * ---------------------------------------------------------------.
     *
     * @param User $user
     */
    public function edit(User $user)
    {
        abort_unless(Gate::allows('user_edit') || Auth::user()->is_superadmin, 403);

        $roles = Role::all()->pluck('title', 'id');

        $user->load('roles');
        $this->saveUser($user);

        return view('admin.users.edit', compact('roles', 'user'));
    }

    /**
     * ---------------------------------------------------------------
     * update method
     * ---------------------------------------------------------------.
     *
     * @param UpdateUserRequest $request
     * @param User              $user
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        abort_unless(Gate::allows('user_edit') || Auth::user()->is_superadmin, 403);

        try {
            $user->update($request->all());
            $user->roles()->sync($request->input('roles', []));

            $this->storeAvatar($request, $user);

            $details = $this->prepareDetailsUpdate($this->getUser(), $user);

            Activity::storeActivity('Atualizou os dados do usuário ' . $user->name, $details);
            alert()->success('Dados do usuário alterado com sucesso!')->toToast('top-end');
        } catch (\Throwable $th) {
            alert()->error('Houve algum problema na alteração deste usuário!')->toToast('top-end');
        }

        return redirect()->route('admin.users.index');
    }

    /**
     * ---------------------------------------------------------------
     * show method
     * ---------------------------------------------------------------.
     *
     * @param User $user
     */
    public function show(User $user)
    {
        abort_unless(Gate::allows('user_show') || Auth::user()->is_superadmin, 403);

        $user->load('roles');

        return view('admin.users.show', compact('user'));
    }

    /**
     * ---------------------------------------------------------------
     * destroy method
     * ---------------------------------------------------------------.
     *
     * @param Request $request
     * @param User    $user
     */
    public function destroy(Request $request, User $user)
    {
        abort_unless(Gate::allows('user_delete') || Auth::user()->is_superadmin, 403);

        try {
            $user->roles()->sync($request->input('roles', true));
            $user->delete();

            Activity::storeActivity('Excluiu o usuário ' . $user->name);
            alert()->success('Usuário excluído com sucesso!')->toToast('top-end');
        } catch (\Throwable $th) {
            alert()->error('Houve algum problema e este usuário não pode ser excluído!')->toToast('top-end');
        }

        return redirect()->route('admin.users.index');
    }

    /**
     * ---------------------------------------------------------------
     * storeAvatar method
     * ---------------------------------------------------------------.
     *
     * @param Request $request
     * @param User    $user
     */
    public function storeAvatar(Request $request, User $user)
    {
        if (isset($request['avatar'])) {
            try {
                $avatar = $user->getFirstMedia('avatars');
                if ($avatar) {
                    $avatar->delete();
                }
                $avatar = $user->addMediaFromRequest('avatar')->toMediaCollection('avatars');

                alert()->success('O avatar deste usuário foi salvo com sucesso!')->toToast('top-end');
            } catch (\Throwable $th) {
                alert()
                    ->error('Houve algum problema e o avatar deste usuário não pode ser salvo no sistema!')
                    ->toToast('top-end');
            }
        }
    }

    /**
     * ---------------------------------------------------------------
     * deleteAvatar method
     * ---------------------------------------------------------------.
     *
     * @param User $user
     */
    public function deleteAvatar(User $user)
    {
        $avatar = $user->getFirstMedia('avatars');
        if ($avatar) {
            try {
                $avatar->delete();
                alert()->success('O avatar deste usuário foi excluído com sucesso!')->toToast('top-end');
            } catch (\Throwable $th) {
                alert()->error('Houve um problema e o avatar deste usuário não pode ser excluído!')->toToast('top-end');
            }
        }

        return redirect()->back();
    }

    /**
     * ---------------------------------------------------------------
     * changeProfile
     * ---------------------------------------------------------------.
     *
     * @param User $user
     */
    public function changeProfile(User $user)
    {
        abort_unless(Gate::allows('user_profile') || Auth::user()->is_superadmin, 403);

        $return_url = url()->previous();

        return view('admin.users.profile', compact('user', 'return_url'));
    }

    /**
     * ---------------------------------------------------------------
     * updateProfile method
     * ---------------------------------------------------------------.
     *
     * @param UpdateProfileUserRequest $request
     * @param User                     $user
     */
    public function updateProfile(UpdateProfileUserRequest $request, User $user)
    {
        abort_unless(Gate::allows('user_profile') || Auth::user()->is_superadmin, 403);

        try {
            $user->update($request->all());
            $this->storeAvatar($request, $user);

            Activity::storeActivity('Atualizou os seus dados pessoais.');
            alert()->success('Perfil alterado com sucesso!')->toToast('top-end');
        } catch (\Throwable $th) {
            alert()->error('Houve um problema e o perfil deste usuário não pode ser alterado!')->toToast('top-end');
        }

        return redirect($request->return_url);
    }

    /**
     * ---------------------------------------------------------------
     * activeUsers method
     * ---------------------------------------------------------------.
     *
     * @param Request $request
     */
    public function activeUsers(Request $request)
    {
        abort_unless(Gate::allows('user_access') || Auth::user()->is_superadmin, 403);

        $ids = $request->data;
        for ($i = 0; $i < count($ids); $i++) {
            if (Auth::user()->id !== (int) $ids[$i]) {
                $user = User::find($ids[$i]);
                User::where('id', $ids[$i])
                    ->update([
                        'active' => 1,
                        'updated_at' => now(),
                    ]);
                Activity::storeActivity('Ativou o usuário ' . $user->name);
            }
        }
    }

    /**
     * ---------------------------------------------------------------
     * desactiveUsers method
     * ---------------------------------------------------------------.
     *
     * @param Request $request
     */
    public function desactiveUsers(Request $request)
    {
        abort_unless(Gate::allows('user_access') || Auth::user()->is_superadmin, 403);

        $ids = $request->data;
        for ($i = 0; $i < count($ids); $i++) {
            if (Auth::user()->id !== (int) $ids[$i]) {
                $user = User::find($ids[$i]);
                User::where('id', $ids[$i])->update(['active' => 0]);
                Activity::storeActivity('Desativou o usuário ' . $user->name);
            }
        }
    }

    /**
     * deleteUsers method.
     *
     * @param Request $request
     * @return void
     */
    public function deleteUsers(Request $request)
    {
        abort_unless(Gate::allows('user_access') || Auth::user()->is_superadmin, 403);

        $ids = $request->data;
        for ($i = 0; $i < count($ids); $i++) {
            if (Auth::user()->id !== (int) $ids[$i]) {
                $user = User::find($ids[$i]);
                User::where('id', $ids[$i])->delete();
                Activity::storeActivity('Excluiu o usuário ' . $user->name);
            }
        }
    }

    /**
     * =================================================================
     * prepara a linha de detalhes do registro na inclusão
     * =================================================================.
     *
     * @param array $new
     *
     * @return void
     */
    public function prepareDetailsNew($new)
    {
        $content = '';
        $roles = $new->roles;
        for ($i = 0; $i < count($roles); $i++) {
            $content .= "<span class='badge badge-primary'>" . $roles[$i]->title . '</span> ';
        }

        $fields[] = ['field' => 'ID', 'value' => $new->id];
        $fields[] = ['field' => 'Nome do Usuário', 'value' => $new->name];
        $fields[] = ['field' => 'Email', 'value' => $new->email];
        $fields[] = ['field' => 'Usuário Ativo?', 'value' => ($new->active == 1) ? 'Sim' : 'Não'];
        $fields[] = ['field' => 'Papéis', 'value' => $content];

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
                <td>' . $fields[$i]['field'] . '</td>
                <td>' . $fields[$i]['value'] . '</td>
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
     * @param array $old
     * @param array $new
     * @return void
     */
    public function prepareDetailsUpdate($old, $new)
    {
        $oldContent = '';
        $newContent = '';
        $oldRoles = $old->roles;
        for ($i = 0; $i < count($oldRoles); $i++) {
            $oldContent .= "<span class='badge badge-primary'>" . $oldRoles[$i]->title . '</span> ';
        }

        $newRoles = $new->roles;
        for ($i = 0; $i < count($newRoles); $i++) {
            $newContent .= "<span class='badge badge-primary'>" . $newRoles[$i]->title . '</span> ';
        }

        $fields[] = [
            'field' => 'ID',
            'oldvalue' => $old->id,
            'newvalue' => $new->id,
        ];
        $fields[] = [
            'field' => 'Nome do Usuário',
            'oldvalue' => $old->name,
            'newvalue' => $new->name,
        ];
        $fields[] = [
            'field' => 'Email',
            'oldvalue' => $old->email,
            'newvalue' => $new->email,
        ];
        $fields[] = [
            'field' => 'Usuário Ativo?',
            'oldvalue' => ($old->active == 1) ? 'Sim' : 'Não',
            'newvalue' => ($new->active == 1) ? 'Sim' : 'Não',
        ];
        $fields[] = [
            'field' => 'Papéis',
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

        for ($i = 0; $i < count($fields); $i++) {
            $content .= '
            <tr>
                <td>' . $fields[$i]['field'] . '</td>
                <td>' . $fields[$i]['oldvalue'] . '</td>
                <td>' . $fields[$i]['newvalue'] . '</td>
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
     * @param array $user
     * @return void
     */
    private function saveUser($user)
    {
        Session::put('user', $user);
    }

    /**
     * =================================================================
     * recupera os dados salvos do registro atual
     * =================================================================.
     *
     * @return void
     */
    private function getUser()
    {
        $r = Session::get('user');
        Session::forget('user');

        return $r;
    }

    /**
     * =================================================================
     * return user that never access the system
     * =================================================================
     *
     * @return void
     */
    public function neverAccess()
    {
        $users = User::whereNull('last_login')->get();

        Session::put('return_path', route('admin.users.neveraccess'));

        return view('admin.users.never_access', compact('users'));
    }
}
