@extends('adminlte::page')

@section('title', Session::has('brand_sistema') ? Session::get('brand_sistema') : config('adminlte.title'))

@section('content_header')
<span style="font-size:20px"> <i class="fas fa-flag"></i> Atividades</span>
{{ Breadcrumbs::render('activities_access') }}
@stop

@section('content')
<div class="row">
    @widget('ActivitiesCount')
</div>

<div class="card card-primary card-outline">
    <div class="card-header">
        <div class="float-left">
            <div class="dropdown">
                <button class="btn btn-info btn-flat btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bolt"></i> Ações
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#" onclick="proccess(1);">
                        <i class="fas fa-fw fa-check text-success"></i> Marcar atividades como Lidas
                    </a>
                    <a class="dropdown-item" href="#" onclick="proccess(2);">
                        <i class="fas fa-fw fa-times text-red"></i> Marcar atividades como Não Lidas
                    </a>
                    @if(Auth::user()->is_superadmin)
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" onclick="proccess(3);"><i class="fas fa-fw fa-trash text-danger"></i> Excluir Selecionados</a>
                    @endif
                </div>
            </div>
        </div>

        <div class="float-right">
            <a class="btn btn-flat btn-primary btn-sm" href="{{ route('admin.activities.index') }}">
                <i class="fas fa-sync"></i> Atualizar a Tela
            </a>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover datatable" id="activities-table">
                <thead class="thead-light">
                    <tr>
                        <th>
                            <input type="checkbox" class="checkbox" name="chk-activities" id="chk-activities" onchange="changeCheckbox();">
                        </th>
                        <th>ID</th>
                        <th>IP</th>
                        <th>Usuário</th>
                        <th>Título</th>
                        <th>Data</th>
                        <th>Lida?</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($activities as $key => $activity)
                    <tr data-entry-id="{{ $activity->id }}">
                        <td class="align-middle">
                            <input type="checkbox" name="ids[]" id="ids[]" class="checkbox" value="{{ $activity->id }}">
                        </td>
                        <td class="align-middle"> {{ $activity->id }} </td>
                        <td class="align-middle">
                            {{ $activity->ipaddress }}
                        </td>
                        <td class="align-middle">
                            {{ $activity->user->name }}
                        </td>
                        <td class="align-middle">
                            {!! $activity->title !!}
                        </td>
                        <td class="align-middle">
                            @if($activity->created_at)
                            {{ $activity->created_at->format('d/m/Y H:i') }}
                            @else
                            <span class="badge badge-danger">Data não definida</span>
                            @endif
                        </td>
                        <td class="align-middle">
                            @if($activity->is_read == 1)
                                <span class="badge badge-success">Sim</span>
                            @else
                                <span class="badge badge-danger">Não</span>
                            @endif
                        </td>
                        <td class="text-left align-middle">
                            @if(Auth::user()->is_superadmin || Auth::user()->can("activity_show"))
                            <a class="btn btn-xs btn-primary" href="{{ route('admin.activities.show', $activity->id) }}">
                                <i class="fas fa-fw fa-eye"></i>
                            </a>
                            @endif

                            @if(Auth::user()->is_superadmin)
                            <a href="javascript;" onclick="deleteRecord(event,{{ $activity->id }});" id="deleteRecord"
                                class="btn btn-xs btn-danger">
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
    $(function () {
        $("#activities-table").DataTable({
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
                null, // ipaddress
                null, // description
                null, // user name
                null, // date
                null, // is_read
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
        var url = "{{ url('admin/activities') }}" + '/' + id;

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
                    success: function () {
                        Swal.fire({
                            type: 'success',
                            title: 'Sucesso',
                            text: 'O registro foi excluído com sucesso.',
                            showConfirmButton: false,
                            timer: 1500,
                        });
                        location.reload();
                    },
                    error: function () {
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
        var checkBox = document.getElementById('chk-activities');
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

        // change status to read
        if (type == 1) {
            changeToRead(arrIds);
        }

        // change status to unread
        if (type == 2) {
            changeToUnRead(arrIds);
        }

        // delete activities
        if (type == 3) {
            deleteActivities(arrIds);
        }
    }


    function changeToRead(data) {
        var url = "{{ route('admin.activities.read') }}";
        var token = "{{ csrf_token() }}";

        Swal.fire({
            type: 'warning',
            title: 'Você tem certeza?',
            text: 'Esta ação mudará o status de todas as atividades selecionadas.',
            showCancelButton: true,
            confirmButtonText: 'Sim - Altere as atividades',
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
                            text: 'Os status das atividades foram alteradas.',
                            showConfirmButton: false,
                            timer: 1500,
                        });
                        location.reload();
                    },
                    error: function() {
                        Swal.fire({
                            type: 'error',
                            title: 'Falhou',
                            text: 'Houve um problema. Os status das atividades não foram alteradas.',
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

    function changeToUnRead(data) {
        var url = "{{ route('admin.activities.unread') }}";
        var token = "{{ csrf_token() }}";

        Swal.fire({
            type: 'warning',
            title: 'Você tem certeza?',
            text: 'Esta ação mudará o status de todas as atividades selecionados.',
            showCancelButton: true,
            confirmButtonText: 'Sim - Altere as atividades',
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
                            text: 'Os status das atividades foram alteradas.',
                            showConfirmButton: false,
                            timer: 1500,
                        });
                        location.reload();
                    },
                    error: function() {
                        Swal.fire({
                            type: 'error',
                            title: 'Falhou',
                            text: 'Houve um problema. Os status das atividades não foram alteradas.',
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

    function deleteActivities(data) {
        var url = "{{ route('admin.activities.deleteactivities') }}";
        var token = "{{ csrf_token() }}";

        Swal.fire({
            type: 'warning',
            title: 'Você tem certeza?',
            text: 'Esta ação EXCLUIRÁ todas as atividades selecionadas.',
            showCancelButton: true,
            confirmButtonText: 'Sim - Excluir as atividades',
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
                            text: 'As atividades foram excluídas.',
                            showConfirmButton: false,
                            timer: 1500,
                        });
                        location.reload();
                    },
                    error: function() {
                        Swal.fire({
                            type: 'error',
                            title: 'Falhou',
                            text: 'Houve um problema. As atividades não foram excluídas.',
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
