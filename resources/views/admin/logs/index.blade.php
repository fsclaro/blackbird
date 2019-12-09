@extends('adminlte::page')

@section('title', 'Blackbird')

@section('content_header')
<span style="font-size:20px"> <i class="fas fa-flag"></i> Logs de Atividades</span>
{{ Breadcrumbs::render('logs_access') }}
@stop

@section('content')
<div class="row">
    @widget('LogsCount')
</div>

<div class="card">
    <div class="card-header">
        <div class="float-right">
            <a class="btn btn-flat btn-primary btn-sm" href="{{ route('admin.logs.index') }}">
                <i class="fas fa-sync"></i> Atualizar a Tela
            </a>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover datatable" id="logs-table">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>IP</th>
                        <th>Usuário</th>
                        <th>Descrição</th>
                        <th>Data</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $key => $log)
                    <tr data-entry-id="{{ $log->id }}">
                        <td>
                            {{ $log->id }}
                        </td>
                        <td>
                            {{ $log->ipaddress }}
                        </td>
                        <td>
                            {{ $log->user->name }}
                        </td>
                        <td>
                            {!! $log->description !!}
                        </td>
                        <td>
                            @if($log->created_at)
                            {{ $log->created_at->format('d/m/Y H:i') }}
                            @else
                            <span class="badge badge-danger">Data não definida</span>
                            @endif
                        </td>
                        <td class="text-left">
                            @can("log_show")
                            <a class="btn btn-xs btn-primary" href="{{ route('admin.logs.show', $log->id) }}">
                                <i class="fas fa-fw fa-eye"></i>
                            </a>
                            @endcan

                            @can("log_delete")
                            <a href="javascript;" onclick="deleteRecord(event,{{ $log->id }});" id="deleteRecord" class="btn btn-xs btn-danger">
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
        $("#logs-table").DataTable({
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
                null, // ipaddress
                null, // description
                null, // user name
                null, // date
                {
                    orderable: false,
                    searchable: false,
                    width: "90px"
                }, // actions buttons
            ],
            order: [
                [4, "desc"]
            ]
        });
    });

    function deleteRecord(e, id) {
        e.preventDefault();

        var dataId = id;
        var token = "{{ csrf_token() }}";
        var url = "{{ url('admin/logs') }}" + '/' + id;

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
