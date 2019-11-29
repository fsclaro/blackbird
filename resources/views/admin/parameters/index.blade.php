@extends('adminlte::page')

@section('title', 'Vulcano')

@section('content_header')
<span style="font-size:20px"> <i class="fas fa-fw fa-database"></i> Relação de Parâmetros</span>
{{ Breadcrumbs::render('parameters_access') }}
@stop

@section('content')

<div class="row">
    @widget('ParametersCount')
</div>

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <div class="pull-right">
            <a class="btn btn-primary btn-sm" href="{{ route('admin.parameters.index') }}">
                <i class="glyphicon glyphicon-refresh"></i> Atualizar a Tela
            </a>

            @can('parameter_create')
            <a class="btn btn-success btn-sm" href="{{ route('admin.parameters.create') }}">
                <i class="fas fa-plus"></i> Adicionar Novo Parâmetro
            </a>
            @endcan
        </div>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable" id="parameter-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome do Parâmetro</th>
                        <th>Slug</th>
                        <th>Tipo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($parameters as $key => $parameter)
                    <tr data-entry-id="{{ $parameter->id }}">
                        <td>
                            {{ $parameter->id }}
                        </td>
                        <td>
                            {{ $parameter->description }}
                        </td>
                        <td>
                            {{ $parameter->name }}
                        </td>
                        <td>
                            @if($parameter->type == "text") Texto @endif
                            @if($parameter->type == "number") Número @endif
                            @if($parameter->type == "email") Email @endif
                            @if($parameter->type == "textarea") Área de Texto @endif
                            @if($parameter->type == "wysiwyg") Wysiwyg @endif
                            @if($parameter->type == "datepicker") Data/Hora @endif
                            @if($parameter->type == "radio") Rádio @endif
                            @if($parameter->type == "select") Seleção @endif
                        </td>
                        <td class="text-left">
                            @can("parameter_show")
                            <a class="btn btn-xs btn-primary" href="{{ route('admin.parameters.show', $parameter->id) }}">
                                <i class="fas fa-fx fa-eye"></i>
                            </a>
                            @endcan

                            @can("parameter_edit")
                            <a class="btn btn-xs btn-warning" href="{{ route('admin.parameters.edit', $parameter->id) }}">
                                <i class="fas fa-fx fa-pencil-alt"></i>
                            </a>
                            @endcan

                            @can("parameter_delete")
                            <a href="javascript;" onclick="deleteRecord(event,{{ $parameter->id }});" id="deleteRecord" class="btn btn-xs btn-danger">
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

@section('css')
@stop

@section('js')
<script>
    $(function() {
        $("#parameter-table").DataTable({
            lengthMenu: [
                [10, 20, 50, 100, 200, -1],
                [10, 20, 50, 100, 200, "Todos"]
            ],
            language: {
                url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json",
            },
            columns: [
                {
                    width: "40px"
                }, // id
                null, // description
                null, // slug
                null, // type
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
        var url = "{{ url('admin/parameters') }}" + '/' + id;

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
