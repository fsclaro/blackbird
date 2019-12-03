@extends('adminlte::page')

@section('title', 'Blackbird')

@section('content_header')
<span style="font-size:20px"> <i class="fas fa-fw fa-key"></i> Exibe detalhes da Permissão</span>
{{ Breadcrumbs::render('permissions_show') }}
@stop

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        Detalhes da permissão
    </div>
    <div class="panel-body">
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th class="col-sm-2">
                        ID
                    </th>
                    <td>
                        {{ $permission->id }}
                    </td>
                </tr>
                <tr>
                    <th class="col-sm-2">
                        Título da Permissão
                    </th>
                    <td>
                        {{ $permission->title }}
                    </td>
                </tr>
                <tr>
                    <th class="col-sm-2">
                        Slug da Permissão
                    </th>
                    <td>
                        {{ $permission->slug }}
                    </td>
                </tr>
                <tr>
                    <th class="col-sm-2">
                        Criado em
                    </th>
                    <td>
                        {{ $permission->created_at->format("d/m/Y H:i:s") }}
                    </td>
                </tr>
                <tr>
                    <th class="col-sm-2">
                        Atualizado em
                    </th>
                    <td>
                        {{ $permission->updated_at->format("d/m/Y H:i:s") }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="panel-footer">
        <a href="{{ route('admin.permissions.index') }}" class="btn btn-default"><i class="fas fa-fx fa-reply"></i> Voltar</a>
    </div>
</div>
@stop

@section('css')
@stop

@section('js')
@stop
