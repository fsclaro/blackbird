@extends('adminlte::page')

@section('title', 'Vulcano')

@section('content_header')
<span style="font-size:20px"> <i class="fas fa-fw fa-database"></i> Exibe detalhes do Parâmetro</span>
{{ Breadcrumbs::render('parameters_show') }}
@stop

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        Detalhes do parâmetro
    </div>
    <div class="panel-body">
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th class="col-sm-2">
                        ID
                    </th>
                    <td>
                        {{ $parameter->id }}
                    </td>
                </tr>
                <tr>
                    <th class="col-sm-2">
                        Descrição do Parâmetro
                    </th>
                    <td>
                        {{ $parameter->description }}
                    </td>
                </tr>
                <tr>
                    <th class="col-sm-2">
                        Slug do Parâmetro
                    </th>
                    <td>
                        {{ $parameter->name }}
                    </td>
                </tr>

                <tr>
                    <th class="col-sm-2">
                        Tipo de Parâmetro
                    </th>
                    <td>
                        @if($parameter->type == "text") Texto @endif
                        @if($parameter->type == "number") Número @endif
                        @if($parameter->type == "email") Email @endif
                        @if($parameter->type == "textarea") Área de Texto @endif
                        @if($parameter->type == "wysiwyg") Wysiwyg @endif
                        @if($parameter->type == "datepicker") Data/Hora @endif
                        @if($parameter->type == "radio") Rádio @endif
                        @if($parameter->type == "select") Seleção @endif
                    </td>
                </tr>

                <tr>
                    <th class="col-sm-2">
                        Rádio / Seleção
                    </th>
                    <td>
                        {{ $parameter->dataenum }}
                    </td>
                </tr>

                <tr>
                    <th class="col-sm-2">
                        Texto de Ajuda
                    </th>
                    <td>
                        {{ $parameter->helper }}
                    </td>
                </tr>

                <tr>
                    <th class="col-sm-2">
                        Criado em
                    </th>
                    <td>
                        {{ $parameter->created_at->format("d/m/Y H:i:s") }}
                    </td>
                </tr>
                <tr>
                    <th class="col-sm-2">
                        Atualizado em
                    </th>
                    <td>
                        {{ $parameter->updated_at->format("d/m/Y H:i:s") }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="panel-footer">
        <a href="{{ route('admin.parameters.index') }}" class="btn btn-default"><i class="fas fa-fx fa-reply"></i> Voltar</a>
    </div>
</div>
@stop

@section('css')
@stop

@section('js')
@stop
