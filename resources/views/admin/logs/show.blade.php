@extends('adminlte::page')

@section('title', 'Blackbird')

@section('content_header')
<span style="font-size:20px"> <i class="fas fa-flag"></i> Logs de Atividades</span>
{{ Breadcrumbs::render('logs_show') }}
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <i class="fas fa-eye"></i> Detalhes do log de atividade
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th style="width:18%">ID</th>
                    <td>{{ $log->id }}</td>
                </tr>

                <tr>
                    <th style="width:18%">Usuário</th>
                    <td>{{ $log->user->name }}</td>
                </tr>

                <tr>
                    <th style="width:18%">Endereço IP</th>
                    <td>
                        <span class="text-blue">Local:</span> {{ $log->ipaddress }} -
                        <span class="text-blue">Externo:</span> {{ $log->externalip ?? "não definido" }}
                    </td>
                </tr>

                <tr>
                    <th style="width:18%">Navegador</th>
                    <td>{{ $log->useragent }}</td>
                </tr>

                <tr>
                    <th style="width:18%">URL</th>
                    <td>{{ $log->url }}</td>
                </tr>

                <tr>
                    <th style="width:18%">Ação</th>
                    <td>{!! $log->action !!}</td>
                </tr>

                <tr>
                    <th style="width:18%">Detalhes</th>
                    <td>{!! $log->details !!}</td>
                </tr>


                <tr>
                    <th style="width:18%">Ocorrido em</th>
                    <td>
                        @if($log->created_at)
                        {{ $log->created_at->format("d/m/Y H:i:s") }}
                        @else
                        <span class="text-red">Informação não disponível</span>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <a href="{{ route('admin.logs.index') }}" class="btn btn-default"><i class="fas fa-fw fa-reply"></i> Voltar</a>
    </div>
</div>
@stop

@section('footer')
@include('vendor.adminlte.footer')
@stop

@section('css')
@stop

@section('js')
@stop
