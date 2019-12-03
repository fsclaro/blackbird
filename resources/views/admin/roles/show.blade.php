@extends('adminlte::page')

@section('title', 'Blackbird')

@section('content_header')
<span style="font-size:20px"> <i class="fas fa-fw fa-user-tag"></i> Exibe detalhes do Papel</span>
{{ Breadcrumbs::render('roles_show') }}
@stop

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        Detalhes do papel
    </div>
    <div class="panel-body">
        <table class="table table-bordered table-striped">
            <tbody>
            <tr>
                    <th class="col-sm-2">
                        ID
                    </th>
                    <td>
                        {{ $role->id }}
                    </td>
                </tr>
                <tr>
                    <th class="col-sm-2">
                        Descrição
                    </th>
                    <td>
                        {{ $role->title }}
                    </td>
                </tr>
                <tr>
                    <th class="col-sm-2">
                        Permissões
                    </th>
                    <td>
                        @foreach($role->permissions as $key => $permission)
                        <span class="label label-primary">{{ $permission->title }}</span>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th class="col-sm-2">
                        Criado em
                    </th>
                    <td>
                        {{ $role->created_at->format("d/m/Y H:i:s") }}
                    </td>
                </tr>
                <tr>
                    <th class="col-sm-2">
                        Atualizado em
                    </th>
                    <td>
                        {{ $role->updated_at->format("d/m/Y H:i:s") }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="panel-footer">
        <a href="{{ route('admin.roles.index') }}" class="btn btn-default"><i class="fas fa-fx fa-reply"></i> Voltar</a>
    </div>
</div>
@stop

@section('css')
@stop

@section('js')
@stop
