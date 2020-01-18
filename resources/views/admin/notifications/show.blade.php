@extends('adminlte::page')

@section('title', 'Blackbird')

@section('content_header')
<span style="font-size:20px"> <i class="fas fa-bell"></i> Relação de Notificações</span>
{{ Breadcrumbs::render('notifications_show') }}
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <i class="fas fa-eye"></i> Detalhes da notificação
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th style="width:18%">ID</th>
                    <td>{{ $notification->id }}</td>
                </tr>
                <tr>
                    <th style="width:18%">Título da Notificação</th>
                    <td>{{ $notification->title }}</td>
                </tr>
                <tr>
                    <th style="width:18%">Conteúdo</th>
                    <td>{!! $notification->content !!}</td>
                </tr>

                <tr>
                    <th style="width:18%">Ícone</th>
                    <td>{!! $notification->icon !!}</td>
                </tr>

                <tr>
                    <th style="width:18%">URL</th>
                    <td>{!! $notification->url !!}</td>
                </tr>

                <tr>
                    <th style="width:18%">Já foi lido?</th>
                    <td>
                    @if($notification->is_read)
                        <span class="badge badge-success">Sim</span>
                    @else
                        <span class="badge badge-danger">Não</span>
                    @endif
                    </td>
                </tr>

                <tr>
                    <th style="width:18%">Criado em</th>
                    <td>
                        @if($notification->created_at)
                        {{ $notification->created_at->format("d/m/Y H:i:s") }}
                        @else
                        <span class="text-red">Informação não disponível</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th style="width:18%">Lido em</th>
                    <td>
                        @if($notification->updated_at)
                        {{ $notification->updated_at->format("d/m/Y H:i:s") }}
                        @else
                        <span class="text-red">Esta notificação ainda não foi lida</span>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <a href="{{ route('admin.notifications.index') }}" class="btn btn-default"><i class="fas fa-fw fa-reply"></i> Voltar</a>
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
