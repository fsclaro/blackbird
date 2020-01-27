@extends('adminlte::page')

@section('title', Session::has('brand_sistema') ? Session::get('brand_sistema') : config('adminlte.title'))

@section('content_header')
<span style="font-size:20px"> <i class="fas fa-database"></i> Relação de Parâmetros</span>
{{ Breadcrumbs::render('settings_show') }}
@stop

@section('content')
<div class="card">
    <div class="card-header">
        Detalhes do parâmetro
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th style="width:21%">ID</th>
                    <td>{{ $setting->id }}</td>
                </tr>
                <tr>
                    <th style="width:21%">Descrição do Parâmetro</th>
                    <td>{{ $setting->description }}</td>
                </tr>
                <tr>
                    <th style="width:21%">Slug do Parâmetro</th>
                    <td>{{ $setting->name }}</td>
                </tr>

                <tr>
                    <th style="width:21%">Tipo de Parâmetro</th>
                    <td>
                        @if($setting->type == "text") Texto @endif
                        @if($setting->type == "number") Número @endif
                        @if($setting->type == "email") Email @endif
                        @if($setting->type == "textarea") Área de Texto @endif
                        @if($setting->type == "wysiwyg") Wysiwyg @endif
                        @if($setting->type == "datepicker") Data/Hora @endif
                        @if($setting->type == "radio") Rádio @endif
                        @if($setting->type == "select") Seleção @endif
                        @if($setting->type == "image") Imagem @endif
                        @if($setting->type == "file") Arquivo @endif
                    </td>
                </tr>

                <tr>
                    <th style="width:21%">Rádio / Seleção</th>
                    <td>{{ $setting->dataenum }}</td>
                </tr>

                <tr>
                    <th style="width:21%">Valor/Conteúdo</th>
                    <td>{!! $setting->content !!}</td>
                </tr>

                <tr>
                    <th style="width:21%">Texto de Ajuda</th>
                    <td>{{ $setting->helper }}</td>
                </tr>

                <tr>
                    <th style="width:21%">Pode ser excluído?</th>
                    <td>
                        @if($setting->can_delete)
                        <span class="badge badge-success">Sim</span>
                        @else
                        <span class="badge badge-danger">Não</span>
                        @endif
                    </td>
                </tr>

                <tr>
                    <th style="width:21%">Criado em</th>
                    <td>
                        @if($setting->created_at)
                        {{ $setting->created_at->format("d/m/Y H:i:s") }}
                        @else
                        <span class="text-red">Informação não disponível</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th style="width:21%">Atualizado em</th>
                    <td>
                        @if($setting->updated_at)
                        {{ $setting->updated_at->format("d/m/Y H:i:s") }}
                        @else
                        <span class="text-red">Informação não disponível</span>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <a href="{{ route('admin.settings.index') }}" class="btn btn-default"><i class="fas fa-fw fa-reply"></i> Voltar</a>
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
