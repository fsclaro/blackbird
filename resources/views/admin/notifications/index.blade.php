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

        <div class="float-left">
            <div class="dropdown">
                <button class="btn btn-info btn-flat btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bolt"></i> Ações
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#" onclick="proccess(1);"><i class="fas fa-fw fa-check text-success"></i> Marcar Como LIDO</a>
                    <a class="dropdown-item" href="#" onclick="proccess(2);"><i class="fas fa-fw fa-times text-red"></i> Marcar Como NÃO LIDO</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" onclick="proccess(3);"><i class="fas fa-fw fa-trash text-danger"></i> Excluir Selecionados</a>
                </div>
            </div>
        </div>

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
                        <th>
                            <input type="checkbox" class="checkbox" name="chk-notifications" id="chk-notifications" onchange="changeCheckbox();">
                        </th>
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
                        <td class="align-middle">
                            <input type="checkbox" name="ids[]" id="ids[]" class="checkbox" value="{{ $notification->id }}">
                        </td>
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
                            @if(Auth::user()->is_superadmin || Auth::user()->can("notification_show"))
                            <a class="btn btn-xs btn-primary" href="{{ route('admin.notifications.show', $notification->id) }}">
                                <i class="fas fa-fw fa-eye"></i>
                            </a>
                            @endif

                            @if(Auth::user()->is_superadmin || Auth::user()->can("notification_delete"))
                            <a href="javascript;" onclick="deleteRecord(event,{{ $notification->id }});" id="deleteRecord" class="btn btn-xs btn-danger">
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
        $("#notification-table").DataTable({
            lengthMenu: [
                [5, 10, 20, 50, 100, 200, -1],
                [5, 10, 20, 50, 100, 200, "Todos"]
            ],
            language: {
                url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json",
            },
            columns: [
                { orderable: false, searchable: false }, // checkbox
                { width: "40px" }, // id
                null, // title
                null, // is_read
                null, // created_at
                null, // updated_at
                { orderable: false, searchable: false, width: "90px" }, // actions buttons
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

    function changeCheckbox() {
        var checkBox = document.getElementById('chk-notifications');
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

        // mark all read
        if (type == 1) {
            mark_read(arrIds);
        }

        // mark all unread
        if (type == 2) {
            mark_unread(arrIds);
        }

        // delete notifications
        if (type == 3) {
            delete_notifications(arrIds);
        }
    }

    function mark_read(data) {
        var url = "{{ route('admin.notifications.read') }}";
        var token = "{{ csrf_token() }}";

        Swal.fire({
            type: 'warning',
            title: 'Você tem certeza?',
            text: 'Esta ação mudará o status de todas notificações selecionadas.',
            showCancelButton: true,
            confirmButtonText: 'Sim - Marcar como LIDO',
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
                            text: 'Os status das notificações foram alteradas.',
                            showConfirmButton: false,
                            timer: 1500,
                        });
                        location.reload();
                    },
                    error: function() {
                        Swal.fire({
                            type: 'error',
                            title: 'Falhou',
                            text: 'Houve um problema. Os status das notificações não foram alteradas.',
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

    function mark_unread(data) {
        var url = "{{ route('admin.notifications.unread') }}";
        var token = "{{ csrf_token() }}";

        Swal.fire({
            type: 'warning',
            title: 'Você tem certeza?',
            text: 'Esta ação mudará o status de todas as notificações selecionadas.',
            showCancelButton: true,
            confirmButtonText: 'Sim - Marcar como NÃO LIDO',
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
                            text: 'Os status das notificações foram alteradas.',
                            showConfirmButton: false,
                            timer: 1500,
                        });
                        location.reload();
                    },
                    error: function() {
                        Swal.fire({
                            type: 'error',
                            title: 'Falhou',
                            text: 'Houve um problema. Os status das notificações não foram alteradas.',
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

    function delete_notifications(data) {
        var url = "{{ route('admin.notifications.deleteall') }}";
        var token = "{{ csrf_token() }}";

        Swal.fire({
            type: 'warning',
            title: 'Você tem certeza?',
            text: 'Esta ação EXCLUIRÁ todas as notificações selecionadas.',
            showCancelButton: true,
            confirmButtonText: 'Sim - Excluir as notificações',
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
                            text: 'As notificações foram excluídas.',
                            showConfirmButton: false,
                            timer: 1500,
                        });
                        location.reload();
                    },
                    error: function() {
                        Swal.fire({
                            type: 'error',
                            title: 'Falhou',
                            text: 'Houve um problema. As notificações não foram excluídas.',
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
