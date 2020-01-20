@extends('adminlte::page')

@section('title', 'Blackbird')

@section('content_header')
<span style="font-size:20px"> <i class="fas fa-user-tag"></i> Cadastro de Papéis</span>
{{ Breadcrumbs::render('roles_access') }}
@stop

@section('content')
<div class="row">
    @widget('RolesCount')
</div>

<div class="card">
    <div class="card-header">
        <div class="float-left">
            <div class="dropdown">
                <button class="btn btn-info btn-flat btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bolt"></i> Ações
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#" onclick="process(1);"><i class="fas fa-fw fa-clone text-success"></i> Clonar Papéis</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" onclick="process(2);"><i class="fas fa-fw fa-user-tag text-danger"></i> Excluir Papéis</a>

                </div>
            </div>
        </div>

        <div class="float-right">
            <a class="btn btn-flat btn-primary btn-sm" href="{{ route('admin.roles.index') }}">
                <i class="fas fa-sync"></i> Atualizar a Tela
            </a>

            @can('role_create')
            <a class="btn btn-flat btn-success btn-sm" href="{{ route('admin.roles.create') }}">
                <i class="fas fa-plus-circle"></i> Adicionar Novo Papel
            </a>
            @endcan
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover datatable" id="roles-table">
                <thead class="thead-light">
                    <tr>
                        <th>
                            <input type="checkbox" class="checkbox" name="chk-roles" id="chk-roles" onchange="changeCheckbox();">
                        </th>

                        <th>ID</th>
                        <th>Papéis</th>
                        <th>Permissões</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $key => $role)
                    <tr data-entry-id="{{ $role->id }}">
                        <td class="align-middle">
                            <input type="checkbox" name="ids[]" id="ids[]" class="checkbox" value="{{ $role->id }}">
                        </td>

                        <td class="align-middle">
                            {{ $role->id }}
                        </td>
                        <td class="align-middle">
                            {{ $role->title }}
                        </td>
                        <td class="align-middle">
                            @foreach($role->permissions as $key => $permission)
                            <span class="badge badge-primary">{{ $permission->title }}&nbsp;</span>
                            @endforeach
                        </td>
                        <td class="text-left align-middle">
                            @can("role_show")
                            <a class="btn btn-xs btn-primary" href="{{ route('admin.roles.show', $role->id) }}">
                                <i class="fas fa-fw fa-eye"></i>
                            </a>
                            @endcan

                            @can("role_edit")
                            <a class="btn btn-xs btn-warning" href="{{ route('admin.roles.edit', $role->id) }}">
                                <i class="fas fa-fw fa-pencil-alt"></i>
                            </a>
                            @endcan

                            @can("role_delete")
                            <a href="javascript;" onclick="deleteRecord(event,{{ $role->id }});" id="deleteRecord" class="btn btn-xs btn-danger">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                            @endcan
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
        $("#roles-table").DataTable({
            lengthMenu: [
                [5, 10, 20, 50, 100, 200, -1],
                [5, 10, 20, 50, 100, 200, "Todos"]
            ],
            language: {
                url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json",
            },
            columns: [{
                    orderable: false,
                    searchable: false,
                }, // checkbox
                {
                    width: "40px"
                }, // id
                {
                    width: "200px"
                }, // title
                null, // permissions
                {
                    orderable: false,
                    searchable: false,
                    width: "90px"
                }, // actions buttons
            ],
            order: [
                [1, "asc"]
            ]
        });
    });

    function changeCheckbox() {
        var checkBox = document.getElementById('chk-roles');
        var allCheckBox = document.getElementsByName('ids[]');

        for (let i = 0; i < allCheckBox.length; i++) {
            allCheckBox[i].checked = checkBox.checked;
        }
    }

    function deleteRecord(e, id) {
        e.preventDefault();

        var dataId = id;
        var token = "{{ csrf_token() }}";
        var url = "{{ url('admin/roles') }}" + '/' + id;

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

    function process(type) {
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

        if (type == 1) {
            processClone(arrIds);
        }

        if (type == 2) {
            deleteRoles(arrIds);
        }
    }

    function processClone(data) {
        var url = "{{ route('admin.roles.clone') }}";
        var token = "{{ csrf_token() }}";

        Swal.fire({
            type: 'warning',
            title: 'Você tem certeza?',
            text: 'Esta ação clonará os papéis selecionados.',
            showCancelButton: true,
            confirmButtonText: 'Sim - Clone os papéis',
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
                            text: 'Os papéris foram clonados.',
                            showConfirmButton: false,
                            timer: 1500,
                        });
                        location.reload();
                    },
                    error: function() {
                        Swal.fire({
                            type: 'error',
                            title: 'Falhou',
                            text: 'Houve um problema. Os papéis não foram clonados.',
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

    function deleteRoles(data) {
        var url = "{{ route('admin.roles.deleteroles') }}";
        var token = "{{ csrf_token() }}";

        Swal.fire({
            type: 'warning',
            title: 'Você tem certeza?',
            text: 'Esta ação EXCLUIRÁ todos os papéis selecionados.',
            showCancelButton: true,
            confirmButtonText: 'Sim - Excluir os papéis',
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
                            text: 'Os papéis foram excluídos.',
                            showConfirmButton: false,
                            timer: 1500,
                        });
                        location.reload();
                    },
                    error: function() {
                        Swal.fire({
                            type: 'error',
                            title: 'Falhou',
                            text: 'Houve um problema. Os papéis não foram excluídos.',
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
