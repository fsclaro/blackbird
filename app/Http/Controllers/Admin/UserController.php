<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\UpdateProfileUserRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * ---------------------------------------------------------------
     * skins colors
     * ---------------------------------------------------------------.
     */
    protected $skins = [
        'blue' => 'Azul',
        'black' => 'Branco',
        'purple' => 'Púrpura',
        'yellow' => 'Laranja',
        'red' => 'Vermelho',
        'green' => 'Verde',
    ];

    /**
     * ---------------------------------------------------------------
     * index method
     * ---------------------------------------------------------------.
     */
    public function index()
    {
        abort_unless(\Gate::allows('user_access'), 403);

        $users = User::all();

        return view('admin.users.index', compact('users'));
    }

    /**
     * ---------------------------------------------------------------
     * create method
     * ---------------------------------------------------------------.
     */
    public function create()
    {
        abort_unless(\Gate::allows('user_create'), 403);

        $roles = Role::all()->pluck('title', 'id');
        $skins = $this->skins;

        return view('admin.users.create', compact('roles', 'skins'));
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
        abort_unless(\Gate::allows('user_create'), 403);

        try {
            $user = User::create($request->all());
            $user->roles()->sync($request->input('roles', []));

            if (isset($request['avatar'])) {
                $user->addMediaFromRequest('avatar')->toMediaCollection('avatars');
            }

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
        abort_unless(\Gate::allows('user_edit'), 403);

        $roles = Role::all()->pluck('title', 'id');

        $user->load('roles');
        $skins = $this->skins;

        return view('admin.users.edit', compact('roles', 'user', 'skins'));
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
        abort_unless(\Gate::allows('user_edit'), 403);

        try {
            $user->update($request->all());
            $user->roles()->sync($request->input('roles', []));

            $this->storeAvatar($request, $user);

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
        abort_unless(\Gate::allows('user_show'), 403);

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
        abort_unless(\Gate::allows('user_delete'), 403);

        try {
            $user->roles()->sync($request->input('roles', true));
            $user->delete();

            alert()->success('Usuário excluído com sucesso!')->toToast('top-end');
        } catch (\Throwable $th) {
            alert()->error('Houve algum problema e este usuário não pode ser excluído!')->toToast('top-end');
        }

        return redirect()->route('admin.users.index');
    }

    /**
     * ---------------------------------------------------------------
     * massdestroy method
     * ---------------------------------------------------------------.
     *
     * @param MassDestroyUserRequest $request
     */
    public function massDestroy(MassDestroyUserRequest $request)
    {
        User::whereIn('id', request('ids'))->delete();

        return response(null, 204);
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
                alert()->error('Houve algum problema e o avatar deste usuário não pode ser salvo no sistema!')->toToast('top-end');
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
        abort_unless(\Gate::allows('user_profile'), 403);

        $return_url = url()->previous();
        $skins = $this->skins;

        return view('admin.users.profile', compact('user', 'return_url', 'skins'));
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
        abort_unless(\Gate::allows('user_profile'), 403);

        try {
            $user->update($request->all());
            $this->storeAvatar($request, $user);

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
        abort_unless(\Gate::allows('user_access'), 403);

        $ids = $request->data;
        for ($i = 0; $i < count($ids); ++$i) {
            if (Auth::user()->id !== (int) $ids[$i]) {
                User::where('id', $ids[$i])->update(['active' => 1]);
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
        abort_unless(\Gate::allows('user_access'), 403);

        $ids = $request->data;
        for ($i = 0; $i < count($ids); ++$i) {
            if (Auth::user()->id !== (int) $ids[$i]) {
                User::where('id', $ids[$i])->update(['active' => 0]);
            }
        }
    }

    /**
     * deleteUsers method
     *
     * @param Request $request
     * @return void
     */
    public function deleteUsers(Request $request)
    {
        abort_unless(\Gate::allows('user_access'), 403);

        $ids = $request->data;
        for ($i = 0; $i < count($ids); ++$i) {
            if (Auth::user()->id !== (int) $ids[$i]) {
                User::where('id', $ids[$i])->delete();
            }
        }
    }
}
