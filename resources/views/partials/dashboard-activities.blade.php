<div class="col-md-9">
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
                <div class="tab-pane active" id="atividades">
                    @php
                        $logs = \App\Logs::getUserLogs(10);

                    @endphp
                </div>
                <div class="tab-pane" id="notificacoes">
                    Texto das notificações
                </div>
            </div>
        </div>
    </div>
</div>
