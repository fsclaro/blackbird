@extends('adminlte::page')

@section('title', 'Blackbird')

@section('content_header')
<span style="font-size:20px"> <i class="fas fa-fw fa-database"></i> Edita o Parâmetro</span>
{{ Breadcrumbs::render('parameters_edit') }}
@stop

@section('content')
<form method="post" action="{{ route('admin.parameters.update', [$parameter->id]) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="panel panel-default">
        <div class="panel-heading">
            Edita o parâmetro
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }} col-md-12">
                    <label for="description">Descrição do Parâmetro
                        <span class="text-red">*</span>
                    </label>
                    <input type="text" id="description" name="description" class="form-control" value="{{ old('description', isset($parameter) ? $parameter->description : '') }}" placeholder="Se preferir, deixe em branco para que o sistema gere automáticamente">

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
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($parameter) ? $parameter->name : '') }}">

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
                        <option value="text" @if($parameter->type=="text") selected @endif>Texto</option>
                        <option value="number" @if($parameter->type=="number") selected @endif>Número</option>
                        <option value="email" @if($parameter->type=="email") selected @endif>Email</option>
                        <option value="textarea" @if($parameter->type=="textarea") selected @endif>Área de Texto</option>
                        <option value="wysiwyg" @if($parameter->type=="wysiwyg") selected @endif>Wysiwyg</option>
                        <option value="datepicker" @if($parameter->type=="datepicker") selected @endif>Data/Hora</option>
                        <option value="radio" @if($parameter->type=="radio") selected @endif>Rádio</option>
                        <option value="select" @if($parameter->type=="select") selected @endif>Seleção</option>
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
                    <label for="dataenum">Rádio / Seleção</label>
                    <input type="text" id="dataenum" name="dataenum" class="form-control" value="{{ old('dataenum', isset($parameter) ? $parameter->dataenum : '') }}" placeholder="Exemplo: valor1:texto1,valor2:texto2,valor3:texto3...">

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
        </div>
    </div>
</form>
@stop

@section('css')
@stop

@section('js')
@stop
