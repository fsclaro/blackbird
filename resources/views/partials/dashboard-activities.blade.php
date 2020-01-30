@php
    if(Session::has('nro_atividades')) {
        $nro_registros = Session::get('nro_atividades');
    } else {
        $nro_registros = 5;
    }
    $logs = App\Logs::getUserLogs($nro_registros);
@endphp

<div class="col-lg-8">
    <div class="card card-warning card-outline">
        <div class="card-header p-2">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link active" href="#atividades" data-toggle="tab">Atividades
                        @if($logs->total() > 0)
                        <span class="badge badge-warning badge-pill ml-1">{{ $logs->total() }}</span>
                        @endif
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#mensagens" data-toggle="tab">Mensagens</a>
                </li>
            </ul>
        </div>

        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane active text-muted" id="atividades">
                    <div class="table-responsible">
                        <table class="table table-striped table-condensed datatable" id="table-atividades">
                            <tbody>
                                @foreach($logs as $log)
                                <tr>
                                    <td>
                                        <small>
                                            <i class="fas fa-clock"></i>
                                            {{ $log->created_at->format("d/m/Y - H:i:s") }}
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <i class="fas fa-globe"></i>
                                            {{ $log->ipaddress }} @if($log->externalip) / {{ $log->externalip }} @endif
                                        </small>
                                        <br>
                                        <div class="float-left">
                                            <span>{!! $log->action !!}</span>
                                        </div>
                                        <div class="float-right">
                                            <a href="{{ route('admin.logs.show', $log->id) }}" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div>
                            <div class="float-right">
                                {{ $logs->links() }}
                            </div>
                        </div>
                    </div> <!-- table-responsive -->
                </div> <!-- tab-pane -->

                <div class="tab-pane" id="mensagens">
                    <div class="jumbotron">
                        <h2 class="display-9">Olá!! {{ auth()->user()->name }}</h2>
                        <p class="lead">Até o presente momento você não possui mensagens de outros usuários.</p>
                        <hr class="my-4">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
