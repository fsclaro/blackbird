<div class="col-lg-8">
    <div class="card card-warning card-outline">
        <div class="card-header p-2">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link active" href="#atividades" data-toggle="tab">Atividades</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#notificacoes" data-toggle="tab">Notificações</a>
                </li>
            </ul>
        </div>

        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane active text-muted" id="atividades">
                    @php
                    if(Session::has('nro_atividades')) {
                    $nro_registros = Session::get('nro_atividades');
                    } else {
                    $nro_registros = 5;
                    }
                    $logs = App\Logs::getUserLogs($nro_registros);
                    @endphp
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
                                            {{ $log->ipaddress }}
                                        </small>
                                        <br>
                                        <div class="float-left">
                                            <span>{!! $log->description !!}</span>
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
                            <div class="float-left">
                                @if($logs->total() == 1)
                                <span class="text-muted">Exite <span class="text-red text-bold">{{ $logs->total() }}</span> registro de atividade.</span>
                                @elseif($logs->total() > 1)
                                <span class="text-muted">Exitem um total de <span class="text-red text-bold">{{ $logs->total() }}</span> registros de atividades.</span>
                                @else
                                <span class="text-muted">Não existem registros de atividades no sistema.</span>
                                @endif
                            </div>
                            <div class="float-right">
                                {{ $logs->links() }}
                            </div>
                        </div>
                    </div> <!-- table-responsive -->
                </div> <!-- tab-pane -->

                <div class="tab-pane" id="notificacoes">
                    Ainda não existem notificações.
                </div>
            </div>
        </div>
    </div>
</div>
