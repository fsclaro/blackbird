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
                    <th style="width:18%">Endereço IP</th>
                    <td>{{ $log->ipaddress }}</td>
                </tr>

                <tr>
                    <th style="width:18%">User Agent</th>
                    <td>{{ $log->useragent }}</td>
                </tr>

                <tr>
                    <th style="width:18%">URL</th>
                    <td>{{ $log->url }}</td>
                </tr>

                <tr>
                    <th style="width:18%">Descrição</th>
                    <td>{{ $log->description }}</td>
                </tr>

                <tr>
                    <th style="width:18%">Detalhes</th>
                    <td>{{ $log->details }}</td>
                </tr>

                <tr>
                    <th style="width:18%">Usuário</th>
                    <td>{{ $log->user->name }}</td>
                </tr>

                <tr>
                    <th style="width:18%">Criado em</th>
                    <td>
                        @if($log->created_at)
                        {{ $log->created_at->format("d/m/Y H:i:s") }}
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <a href="{{ route('admin.logs.index') }}" class="btn btn-default"><i class="fas fa-fx fa-reply"></i> Voltar</a>
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
