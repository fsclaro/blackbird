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
        <div class="float-right">
            <a class="btn btn-flat btn-primary btn-sm" href="{{ route('admin.roles.index') }}">
                <i class="fas fa-sync"></i> Atualizar a Tela
            </a>

            @can('role_create')
            <a class="btn btn-flat btn-success btn-sm" href="{{ route('admin.roles.create') }}">
                <i class="fas fa-plus"></i> Adicionar Novo Papel
            </a>
            @endcan
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover datatable" id="roles-table">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Papéis</th>
                        <th>Permissões</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $key => $role)
                    <tr data-entry-id="{{ $role->id }}">
                        <td>
                            {{ $role->id }}
                        </td>
                        <td>
                            {{ $role->title }}
                        </td>
                        <td>
                            @foreach($role->permissions as $key => $permission)
                            <span class="badge badge-primary">{{ $permission->title }}&nbsp;</span>
                            @endforeach
                        </td>
                        <td class="text-left">
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
                [10, 20, 50, 100, 200, -1],
                [10, 20, 50, 100, 200, "Todos"]
            ],
            language: {
                url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json",
            },
            columns: [{
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
        });
    });

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
</script>
@stop
