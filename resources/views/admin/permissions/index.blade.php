@extends('adminlte::page')

@section('title', 'Blackbird')

@section('content_header')
<span style="font-size:20px"> <i class="fas fa-key"></i> Cadastro de Permissões</span>
{{ Breadcrumbs::render('permissions_access') }}
@stop

@section('content')

<div class="row">
    @widget('PermissionsCount')
</div>

<div class="card">
    <div class="card-header">
        <div class="float-right">
            <a class="btn btn-flat btn-primary btn-sm" href="{{ route('admin.permissions.index') }}">
                <i class="fas fa-sync"></i> Atualizar a Tela
            </a>

            @if(Auth::user()->is_superadmin || Auth::user()->can('permission_create'))
            <a class="btn btn-flat btn-success btn-sm" href="{{ route('admin.permissions.create') }}">
                <i class="fas fa-plus-circle"></i> Adicionar Nova Permissão
            </a>
            @endif
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-striped table-hover datatable" id="permission-table">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Título da Permissão</th>
                        <th>Slug</th>
                        <th>Nº de Papéis</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($permissions as $key => $permission)
                    <tr data-entry-id="{{ $permission->id }}">
                        <td class="align-middle">
                            {{ $permission->id }}
                        </td>
                        <td class="align-middle">
                            {{ $permission->title }}
                        </td>
                        <td class="align-middle">
                            {{ $permission->slug }}
                        </td>
                        <td class="align-middle">
                            {{ $permission->roles()->count() }}
                        </td>
                        <td class="text-left align-middle">
                            @if((Auth::user()->is_superadmin || Auth::user()->can("permission_show")) && $permission->id != 1)
                            <a class="btn btn-xs btn-primary" href="{{ route('admin.permissions.show', $permission->id) }}">
                                <i class="fas fa-fw fa-eye"></i>
                            </a>
                            @endif

                            @if((Auth::user()->is_superadmin || Auth::user()->can("permission_edit")) && $permission->id != 1)
                            <a class="btn btn-xs btn-warning" href="{{ route('admin.permissions.edit', $permission->id) }}">
                                <i class="fas fa-fw fa-pencil-alt"></i>
                            </a>
                            @endif

                            @if(
                                (Auth::user()->is_superadmin || Auth::user()->can("permission_delete")) &&
                                $permission->id != 1 && $permission->roles()->count() == 0
                            )
                            <a href="javascript;" onclick="deleteRecord(event,{{ $permission->id }});" id="deleteRecord" class="btn btn-xs btn-danger">
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
        $("#permission-table").DataTable({
            lengthMenu: [
                [5, 10, 20, 50, 100, 200, -1],
                [5, 10, 20, 50, 100, 200, "Todos"]
            ],
            language: {
                url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json",
            },
            columns: [{
                    width: "40px"
                }, // id
                null, // title
                null, // slug
                null, // roles number
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
        var url = "{{ url('admin/permissions') }}" + '/' + id;

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
