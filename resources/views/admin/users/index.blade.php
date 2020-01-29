@extends('adminlte::page')

@section('title', Session::has('brand_sistema') ? Session::get('brand_sistema') : config('adminlte.title'))

@section('content_header')
<span style="font-size:20px"> <i class="fas fa-fw fa-users"></i> Cadastro de Usuários</span>
{{ Breadcrumbs::render('users_access') }}
@stop

@section('content')
<div class="row">
    @widget('UsersActivesCount')
    @widget('UsersInactivesCount')
</div>

<div class="card card-primary card-outline">
    <div class="card-header">
        <div class="float-left">
            <div class="dropdown">
                <button class="btn btn-info btn-flat btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bolt"></i> Ações
                </button>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#" onclick="proccess(1);"><i class="fas fa-fw fa-check text-success"></i> Ativar Selecionados</a>
                    <a class="dropdown-item" href="#" onclick="proccess(2);"><i class="fas fa-fw fa-times text-red"></i> Desativar Selecionados</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" onclick="proccess(3);"><i class="fas fa-fw fa-trash text-danger"></i> Excluir Selecionados</a>
                </div>

            </div>
        </div>

        <div class="float-right">

            <a class="btn btn-primary btn-flat btn-sm" href="{{ route('admin.users.index') }}">
                <i class="fas fa-sync"></i> Atualizar a Tela
            </a>

            @if(Auth::user()->is_superadmin || Auth::user()->can('user_create'))
            <a class="btn btn-success btn-flat btn-sm" href="{{ route('admin.users.create') }}">
                <i class="fas fa-plus-circle"></i> Adicionar Novo Usuário
            </a>
            @endif

        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover datatable" id="users-table">
                <thead class="thead-light">
                    <tr>
                        <th>
                            <input type="checkbox" class="checkbox" name="chk-users" id="chk-users" onchange="changeCheckbox();">
                        </th>
                        <th>ID</th>
                        <th>Nome do Usuário</th>
                        <th>Email</th>
                        <th>Papel</th>
                        <th>Ativo?</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $key => $user)
                    <tr data-entry-id="{{ $user->id }}">
                        <td class="align-middle">
                            @if($user->id != Auth::user()->id && !$user->is_superadmin)
                            <input type="checkbox" name="ids[]" id="ids[]" class="checkbox" value="{{ $user->id }}">
                            @endif
                        </td>

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
                                    <img src="{{ asset('img/avatares/no-photo.png') }}" width="48px" class="img-circle" alt="User Image">
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

                        <td class="text-left align-middle">
                            @if(
                                (Auth::user()->is_superadmin    && !$user->is_superadmin) ||
                                (Auth::user()->can('user_show') && !$user->is_superadmin)
                            )
                            <a class="btn btn-xs btn-primary" href="{{ route('admin.users.show', $user->id) }}">
                                <i class="fas fa-fw fa-eye"></i>
                            </a>
                            @endif

                            @if(
                                (Auth::user()->is_superadmin && !$user->is_superadmin) ||
                                (Auth::user()->can('user_edit') && !$user->is_superadmin && Auth::user()->id != $user->id)
                            )
                                <a class="btn btn-xs btn-warning" href="{{ route('admin.users.edit', $user->id) }}">
                                    <i class="fas fa-fw fa-pencil-alt"></i>
                                </a>
                            @endif

                            @if(
                                (Auth::user()->is_superadmin && !$user->is_superadmin) ||
                                (Auth::user()->can('user_delete') && !$user->is_superadmin && Auth::user()->id != $user->id)
                            )
                            <a href="javascript;" onclick="deleteRecord(event,{{ $user->id }});" id="deleteRecord" class="btn btn-xs btn-danger">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
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
                { orderable: false, searchable: false }, // checkbox
                null, // id
                null, // nome do usuário
                null, // email
                null, // papéis
                null, // ativo
                { orderable: false, searchable: false }, // actions
            ],
            order: [
                [1, "asc"]
            ]
        });
    });

    function deleteRecord(e, id) {
        e.preventDefault();

        var dataId = id;
        var token = "{{ csrf_token() }}";
        var url = "{{ url('admin/users') }}" + '/' + id;

        Swal.fire({
            type: 'warning',
            title: 'Você tem certeza?',
            text: 'Esta ação não poderá ser desfeita no futuro.',
            showCancelButton: true,
            confirmButtonText: 'Sim - Exclua este registro',
            cancelButtonText: 'Não - Cancele esta ação',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            focusCancel: true,
            width: '35rem',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _token: token,
                        _method: 'DELETE',
                    },
                    success: function() {
                        Swal.fire({
                            type: 'success',
                            title: 'Sucesso',
                            text: 'O registro foi excluído com sucesso.',
                            showConfirmButton: false,
                            timer: 1500,
                        });
                        location.reload();
                    },
                    error: function() {
                        Swal.fire({
                            type: 'error',
                            title: 'Falhou',
                            text: 'Houve um problema. O registro não foi excluído.',
                            timer: 2500,
                        });
                    }
                })
            } else {
                Swal.fire({
                    type: 'error',
                    title: 'Cancelado',
                    text: 'Operação de exclusão cancelada.',
                    showConfirmButton: false,
                    timer: 1500,
                });
            }
        });
    };

    function changeCheckbox() {
        var checkBox = document.getElementById('chk-users');
        var allCheckBox = document.getElementsByName('ids[]');

        for (let i = 0; i < allCheckBox.length; i++) {
            allCheckBox[i].checked = checkBox.checked;
        }
    }

    function proccess(type) {
        var ids = document.getElementsByName('ids[]');

        var count = 0;
        var arrIds = new Array();
        for (let i = 0; i < ids.length; i++) {
            if (ids[i].checked) {
                arrIds[count] = ids[i].value;
                count++;
            }
        }

        if (count == 0) {
            Swal.fire({
                type: 'error',
                title: 'Opps.',
                text: 'Você não selecionou nenhuma linha.',
                showConfirmButton: TextTrackCue,
                timer: 3000,
            });

            return;
        }

        // active users
        if (type == 1) {
            active_users(arrIds);
        }

        // deactive users
        if (type == 2) {
            desactive_users(arrIds);
        }

        // delete users
        if (type == 3) {
            delete_users(arrIds);
        }
    }


    function active_users(data) {
        var url = "{{ route('admin.users.active') }}";
        var token = "{{ csrf_token() }}";

        Swal.fire({
            type: 'warning',
            title: 'Você tem certeza?',
            text: 'Esta ação mudará o status de todos os usuários selecionados.',
            showCancelButton: true,
            confirmButtonText: 'Sim - Ative os usuários',
            cancelButtonText: 'Não - Cancele esta ação',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            focusCancel: true,
            width: '35rem',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _token: token,
                        _method: "POST",
                        data: data,
                    },
                    success: function() {
                        Swal.fire({
                            type: 'success',
                            title: 'Sucesso',
                            text: 'Os status dos usuários foram alterados.',
                            showConfirmButton: false,
                            timer: 1500,
                        });
                        location.reload();
                    },
                    error: function() {
                        Swal.fire({
                            type: 'error',
                            title: 'Falhou',
                            text: 'Houve um problema. Os status dos usuários não foram alterados.',
                            timer: 2500,
                        });
                    }
                })
            } else {
                Swal.fire({
                    type: 'error',
                    title: 'Cancelado',
                    text: 'Operação cancelada.',
                    showConfirmButton: false,
                    timer: 1500,
                });
            }
        });
    }

    function desactive_users(data) {
        var url = "{{ route('admin.users.desactive') }}";
        var token = "{{ csrf_token() }}";

        Swal.fire({
            type: 'warning',
            title: 'Você tem certeza?',
            text: 'Esta ação mudará o status de todos os usuários selecionados.',
            showCancelButton: true,
            confirmButtonText: 'Sim - Desative os usuários',
            cancelButtonText: 'Não - Cancele esta ação',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            focusCancel: true,
            width: '35rem',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _token: token,
                        _method: "POST",
                        data: data,
                    },
                    success: function() {
                        Swal.fire({
                            type: 'success',
                            title: 'Sucesso',
                            text: 'Os status dos usuários foram alterados.',
                            showConfirmButton: false,
                            timer: 1500,
                        });
                        location.reload();
                    },
                    error: function() {
                        Swal.fire({
                            type: 'error',
                            title: 'Falhou',
                            text: 'Houve um problema. Os status dos usuários não foram alterados.',
                            timer: 2500,
                        });
                    }
                })
            } else {
                Swal.fire({
                    type: 'error',
                    title: 'Cancelado',
                    text: 'Operação cancelada.',
                    showConfirmButton: false,
                    timer: 1500,
                });
            }
        });
    }

    function delete_users(data) {
        var url = "{{ route('admin.users.deleteusers') }}";
        var token = "{{ csrf_token() }}";

        Swal.fire({
            type: 'warning',
            title: 'Você tem certeza?',
            text: 'Esta ação EXCLUIRÁ todos os usuários selecionados.',
            showCancelButton: true,
            confirmButtonText: 'Sim - Excluir os usuários',
            cancelButtonText: 'Não - Cancele esta ação',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            focusCancel: true,
            width: '35rem',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _token: token,
                        _method: "POST",
                        data: data,
                    },
                    success: function() {
                        Swal.fire({
                            type: 'success',
                            title: 'Sucesso',
                            text: 'Os usuários foram excluídos.',
                            showConfirmButton: false,
                            timer: 1500,
                        });
                        location.reload();
                    },
                    error: function() {
                        Swal.fire({
                            type: 'error',
                            title: 'Falhou',
                            text: 'Houve um problema. Os usuários não foram excluídos.',
                            timer: 2500,
                        });
                    }
                })
            } else {
                Swal.fire({
                    type: 'error',
                    title: 'Cancelado',
                    text: 'Operação cancelada.',
                    showConfirmButton: false,
                    timer: 1500,
                });
            }
        });
    }
</script>
@stop
