@extends('adminlte::page')

@section('title', 'Blackbird')

@section('content_header')
<span style="font-size:20px"> <i class="fas fa-bell"></i> Relação de Notificações</span>
{{ Breadcrumbs::render('notifications_access') }}
@stop

@section('content')

<div class="row">
    @widget('NotificationsCount')
    @widget('NotificationsNotReadCount')
</div>

<div class="card">
    <div class="card-header">

        <div class="float-right">
            <a class="btn btn-primary btn-flat btn-sm" href="{{ route('admin.notifications.index') }}">
                <i class="fas fa-sync"></i> Atualizar a Tela
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-striped table-hover datatable" id="notification-table">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Lido?</th>
                        <th>Data da Notificação</th>
                        <th>Lida em</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($notifications as $key => $notification)
                    <tr data-entry-id="{{ $notification->id }}">
                        <td class="align-middle">{{ $notification->id }}</td>
                        <td class="align-middle">{{ $notification->title }}</td>

                        <td class="align-middle">
                            @if($notification->is_read)
                            <span class="badge badge-success">Sim</span>
                            @else
                            <span class="badge badge-danger">Não</span>
                            @endif
                        </td>

                        <td class="align-middle">
                            @if($notification->created_at)
                            {{ $notification->created_at->format("d/m/Y H:i:s") }}
                            @else
                            <span class="text-red">Não fornecida</span>
                            @endif
                        </td>

                        <td class="align-middle">
                            @if($notification->updated_at)
                            {{ $notification->updated_at->format("d/m/Y H:i:s") }}
                            @else
                            <span class="badge badge-danger">Ainda não lida</span>
                            @endif
                        </td>

                        <td class="text-left align-middle">
                            @can("notification_show")
                            <a class="btn btn-xs btn-primary" href="{{ route('admin.notifications.show', $notification->id) }}">
                                <i class="fas fa-fw fa-eye"></i>
                            </a>
                            @endcan

                            @can("notification_delete")
                            <a href="javascript;" onclick="deleteRecord(event,{{ $notification->id }});" id="deleteRecord" class="btn btn-xs btn-danger">
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
        $("#notification-table").DataTable({
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
                null, // is_read
                null, // created_at
                null, // updated_at
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
        var url = "{{ url('admin/notifications') }}" + '/' + id;

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
