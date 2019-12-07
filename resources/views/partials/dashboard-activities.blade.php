<div class="col-md-8">
    <div class="card card-warning card-outline">
        <div class="card-header p-2">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link active" href="#atividades" data-toggle="tab">10 Últimas Atividades</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#notificacoes" data-toggle="tab">Notificações</a>
                </li>
            </ul>
        </div>

        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane active text-muted" id="atividades">
                    @php $logs = \App\Logs::getUserLogs(10); @endphp
                    @foreach($logs as $log)
                    <small>
                        <i class="fas fa-clock"></i> {{ $log->created_at->format("d/m/Y - H:i:s") }}
                        - <span class="text-bold">IP </span>{{ $log->ipaddress }}
                    </small>

                    <p>{!! $log->description !!}</p>
                    <hr>
                    @endforeach
                </div>
                <div class="tab-pane" id="notificacoes">
                    Texto das notificações
                </div>
            </div>
        </div>
    </div>
</div>
