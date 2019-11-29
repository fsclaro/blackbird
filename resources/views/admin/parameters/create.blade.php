@extends('adminlte::page')

@section('title', 'Vulcano')

@section('content_header')
<span style="font-size:20px"> <i class="fas fa-fw fa-database"></i> Adicionar Novo Parâmetro</span>
{{ Breadcrumbs::render('parameters_create') }}
@stop

@section('content')
<form method="post" action="{{ route('admin.parameters.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="panel panel-default">
        <div class="panel-heading">
            Cadastramento de um novo parâmetro
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }} col-md-12">
                    <label for="description">Descrição do Parâmetro
                        <span class="text-red">*</span>
                    </label>
                    <input type="text" id="description" name="description" class="form-control" value="{{ old('description', isset($parameter) ? $parameter->description : '') }}">

                    @if($errors->has('description'))
                    <p class="help-block">
                        {{ $errors->first('description') }}
                    </p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }} col-md-12">
                    <label for="name">Slug</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($parameter) ? $parameter->name : '') }}" placeholder="Se preferir, deixe em branco para que o sistema gere automáticamente">

                    @if($errors->has('name'))
                    <p class="help-block">
                        {{ $errors->first('name') }}
                    </p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }} col-md-4">
                    <label for="type">Tipo de Parâmetro
                        <span class="text-red">*</span>
                    </label>

                    <select id="type" name="type" class="form-control">
                        <option value=>Selecione uma das opções...</option>
                        <option value="text">Texto</option>
                        <option value="number">Número</option>
                        <option value="email">Email</option>
                        <option value="textarea">Área de Texto</option>
                        <option value="wysiwyg">Wysiwyg</option>
                        <option value="datepicker">Data/Hora</option>
                        <option value="radio">Rádio</option>
                        <option value="select">Seleção</option>
                    </select>

                    @if($errors->has('type'))
                    <p class="help-block">
                        {{ $errors->first('type') }}
                    </p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="form-group {{ $errors->has('dataenum') ? 'has-error' : '' }} col-md-12">
                    <label for="dataenum">Radio / Seleção</label>
                    <input type="text" id="dataenum" name="dataenum" class="form-control" value="{{ old('dataenum', isset($parameter) ? $parameter->dataenum : '') }}" placeholder="Exemplo: valor1,valor2,valor3...">

                    @if($errors->has('dataenum'))
                    <p class="help-block">
                        {{ $errors->first('dataenum') }}
                    </p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="form-group {{ $errors->has('helper') ? 'has-error' : '' }} col-md-12">
                    <label for="helper">Texto de Ajuda</label>
                    <input type="text" id="helper" name="helper" class="form-control" value="{{ old('helper', isset($parameter) ? $parameter->helper : '') }}" placeholder="Texto que será exibido abaixo do campo para orientações">

                    @if($errors->has('helper'))
                    <p class="help-block">
                        {{ $errors->first('helper') }}
                    </p>
                    @endif
                </div>
            </div>
        </div> <!-- panel-body -->

        <div class="panel-footer">
            <a href="{{ route('admin.parameters.index') }}" class="btn btn-default"><i class="fas fa-fx fa-reply"></i> Voltar</a>
            <button type="submit" class="btn btn-success"><i class="fas fa-fx fa-save"></i> Salvar</button>
        </div> <!-- panel-footer -->

    </div> <!-- panel panel-default -->
</form>
@stop

@section('css')
@stop

@section('js')
@stop
