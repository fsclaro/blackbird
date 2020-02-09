@extends('adminlte::page')

@section('title', Session::has('brand_sistema') ? Session::get('brand_sistema') : config('adminlte.title'))

@section('content_header')
<span style="font-size:20px"> <i class="fas fa-fw fa-users"></i> Usuários que nunca acessaram o sistema</span>
{{ Breadcrumbs::render('users_never_access') }}
@stop

@section('content')

<div class="card card-primary card-outline">
    <div class="card-header">
        <div class="float-right">
            <a class="btn btn-primary btn-flat btn-sm" href="{{ route('admin.users.neveraccess') }}">
                <i class="fas fa-sync"></i> Atualizar a Tela
            </a>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover datatable" id="users-table">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Nome do Usuário</th>
                        <th>Email</th>
                        <th>Papel</th>
                        <th>Ativo?</th>
                        <th>Cadastrado em</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $key => $user)
                    <tr data-entry-id="{{ $user->id }}">
                        <td class="align-middle">
                            {{ $user->id }}
                        </td>

                        <td class="align-middle">
                            @if($user->getAvatar($user->id))
                                <img src="{{ $user->getAvatar($user->id) }}" width="48px" class="img-circle" alt="User Image">
                            @else
                                @if (Gravatar::exists($user->email))
                                    <img src="{{ Gravatar::get($user->email) }}" class="img-circle" width="48px" alt="User Image">
                                @else
                                    <img src="{{ asset('img/avatares/Others/no-photo.png') }}" width="48px" class="img-circle" alt="User Image">
                                @endif
                            @endif

                            {{ $user->name }}
                        </td>
                        <td class="align-middle">
                            {{ $user->email }}
                        </td>

                        <td class="align-middle">
                            @foreach($user->roles as $key => $role)
                                @if($role->title == 'SuperAdmin')
                                    <span class="badge badge-primary">{{ $role->title }}&nbsp;</span>
                                @elseif($role->title == 'Admin')
                                    <span class="badge badge-danger">{{ $role->title }}&nbsp;</span>
                                @else
                                    <span class="badge badge-secondary">{{ $role->title }}&nbsp;</span>
                                @endif
                            @endforeach
                        </td>

                        <td class="align-middle">
                            <span class="badge badge-{{ App\User::ACTIVE_COLOR[$user->active]}}">{{ App\User::ACTIVE_STATUS[$user->active] }}</span>
                        </td>

                        <td class="align-middle">
                            {{ $user->created_at->format('d/m/Y - H:i:s') }}
                        </td>

                        <td class="text-left align-middle">
                            @if(
                                (Auth::user()->is_superadmin    && !$user->is_superadmin) ||
                                (Auth::user()->can('user_show') && !$user->is_superadmin)
                            )
                            <a class="btn btn-xs btn-primary" href="{{ route('admin.users.show', $user->id) }}">
                                <i class="fas fa-fw fa-eye"></i>
                            </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div> <!-- card-body -->

    <div class="card-footer">
        <a href="{{ route('home') }}" class="btn btn-flat btn-default">
            <i class="fas fa-fw fa-reply"></i> Voltar
        </a>
    </div> <!-- card-footer -->
</div>
@stop

@section('footer')
@include('vendor.adminlte.footer')
@stop

@section('css')
@stop

@section('js')
<script>
    $(function() {
        $("#users-table").DataTable({
            lengthMenu: [
                [10, 20, 50, 100, 200, -1],
                [10, 20, 50, 100, 200, "Todos"]
            ],
            language: {
                url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json",
            },
            columns: [
                null, // id
                null, // nome do usuário
                null, // email
                null, // papéis
                null, // ativo
                null, // created_at
                { orderable: false, searchable: false }, // actions
            ],
        });
    });
</script>
@stop
