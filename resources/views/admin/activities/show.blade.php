@extends('adminlte::page')

@section('title', Session::has('brand_sistema') ? Session::get('brand_sistema') : config('adminlte.title'))

@section('content_header')
<span style="font-size:20px"> <i class="fas fa-flag"></i> Atividades</span>
{{ Breadcrumbs::render('activities_show') }}
@stop

@section('content')
<div class="card card-primary card-outline">
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th style="width:18%">ID</th>
                    <td>{{ $activity->id }}</td>
                </tr>

                <tr>
                    <th style="width:18%">Usuário</th>
                    <td>{{ $activity->user->name }}</td>
                </tr>

                <tr>
                    <th style="width:18%">Endereço IP</th>
                    <td>
                        <span class="text-blue">Local:</span> {{ $activity->ipaddress ?? "não definido" }} -
                        <span class="text-blue">Externo:</span> {{ $activity->externalip ?? "não definido" }}
                    </td>
                </tr>

                <tr>
                    <th style="width:18%">Navegador</th>
                    <td>{{ $activity->useragent }}</td>
                </tr>

                <tr>
                    <th style="width:18%">URL</th>
                    <td>{{ $activity->url }}</td>
                </tr>

                <tr>
                    <th style="width:18%">Título</th>
                    <td>{!! $activity->title !!}</td>
                </tr>

                @if(null != $activity->details)
                <tr>
                    <th style="width:18%">Detalhes</th>
                    <td>{!! $activity->details !!}</td>
                </tr>
                @endif

                <tr>
                    <th style="width:18%">Ocorrido em</th>
                    <td>
                        @if($activity->created_at)
                        {{ $activity->created_at->format("d/m/Y H:i:s") }}
                        @else
                        <span class="text-red">Informação não disponível</span>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        @if(Session::get('return_point') == 'admin')
        <a href="{{ route('admin.activities.index') }}" class="btn btn-default"><i class="fas fa-fw fa-reply"></i> Voltar</a>
        @elseif(Session::get('return_point') == 'user')
        <a href="{{ route('admin.activities.user') }}" class="btn btn-default"><i class="fas fa-fw fa-reply"></i> Voltar</a>
        @else
        <a href="{{ route('home') }}" class="btn btn-default"><i class="fas fa-fw fa-reply"></i> Voltar</a>
        @endif
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
