@extends('adminlte::page')

@section('title', 'Blackbird')

@section('content_header')
<span style="font-size:20px"> <i class="fas fa-database"></i> Relação de Parâmetros</span>
{{ Breadcrumbs::render('settings_access') }}
@stop

@section('content')

<div class="row">
    @widget('SettingsCount')
</div>

<div class="card">
    <div class="card-header">

        <div class="float-right">
            <a class="btn btn-primary btn-flat btn-sm" href="{{ route('admin.settings.index') }}">
                <i class="fas fa-sync"></i> Atualizar a Tela
            </a>

            @can('setting_create')
            <a class="btn btn-success btn-flat btn-sm" href="{{ route('admin.settings.create') }}">
                <i class="fas fa-plus-circle"></i> Adicionar Novo Parâmetro
            </a>
            @endcan
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable" id="setting-table">
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
                    @foreach($settings as $key => $setting)
                    <tr data-entry-id="{{ $setting->id }}">
                        <td>{{ $setting->id }}</td>
                        <td>{{ $setting->description }}</td>
                        <td>{{ $setting->name }}</td>
                        <td>
                            @if($setting->type == "text") Texto @endif
                            @if($setting->type == "number") Número @endif
                            @if($setting->type == "email") Email @endif
                            @if($setting->type == "textarea") Área de Texto @endif
                            @if($setting->type == "wysiwyg") Wysiwyg @endif
                            @if($setting->type == "datepicker") Data/Hora @endif
                            @if($setting->type == "radio") Rádio @endif
                            @if($setting->type == "select") Seleção @endif
                        </td>
                        <td class="text-left">
                            @can("setting_show")
                            <a class="btn btn-xs btn-primary" href="{{ route('admin.settings.show', $setting->id) }}">
                                <i class="fas fa-fw fa-eye"></i>
                            </a>
                            @endcan

                            @can("setting_edit")
                            <a class="btn btn-xs btn-warning" href="{{ route('admin.settings.edit', $setting->id) }}">
                                <i class="fas fa-fw fa-pencil-alt"></i>
                            </a>
                            @endcan

                            @can("setting_delete")
                            <a href="javascript;" onclick="deleteRecord(event,{{ $setting->id }});" id="deleteRecord" class="btn btn-xs btn-danger">
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
        $("#setting-table").DataTable({
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
        var url = "{{ url('admin/settings') }}" + '/' + id;

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
