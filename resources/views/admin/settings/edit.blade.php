@extends('adminlte::page')

@section('title', 'Blackbird')

@section('content_header')
<span style="font-size:20px"> <i class="fas fa-database"></i> Relação de Parâmetros</span>
{{ Breadcrumbs::render('settings_edit') }}
@stop

@section('content')
<form method="post" action="{{ route('admin.settings.update', [$setting->id]) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="card">
        <div class="card-header">
            Edita os dados do parâmetro
        </div>

        <div class="card-body">
            <div class="row">
                <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }} col-md-12">
                    <label for="description">Descrição do Parâmetro
                        <span class="text-red">*</span>
                    </label>
                    <input type="text" id="description" name="description" class="form-control" value="{{ old('description', isset($setting) ? $setting->description : '') }}" placeholder="Se preferir, deixe em branco para que o sistema gere automáticamente">

                    @if($errors->has('description'))
                    <small class="form-text text-red text-bold">
                        {{ $errors->first('description') }}
                    </small>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }} col-md-12">
                    <label for="name">Slug</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($setting) ? $setting->name : '') }}">

                    @if($errors->has('name'))
                    <small class="form-text text-red text-bold">
                        {{ $errors->first('name') }}
                    </small>
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
                        <option value="text" @if($setting->type=="text") selected @endif>Texto</option>
                        <option value="number" @if($setting->type=="number") selected @endif>Número</option>
                        <option value="email" @if($setting->type=="email") selected @endif>Email</option>
                        <option value="textarea" @if($setting->type=="textarea") selected @endif>Área de Texto</option>
                        <option value="wysiwyg" @if($setting->type=="wysiwyg") selected @endif>Wysiwyg</option>
                        <option value="datepicker" @if($setting->type=="datepicker") selected @endif>Data/Hora</option>
                        <option value="radio" @if($setting->type=="radio") selected @endif>Rádio</option>
                        <option value="select" @if($setting->type=="select") selected @endif>Seleção</option>
                    </select>

                    @if($errors->has('type'))
                    <small class="form-text text-red text-bold">
                        {{ $errors->first('type') }}
                    </small>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="form-group {{ $errors->has('dataenum') ? 'has-error' : '' }} col-md-12">
                    <label for="dataenum">Rádio / Seleção</label>
                    <input type="text" id="dataenum" name="dataenum" class="form-control" value="{{ old('dataenum', isset($setting) ? $setting->dataenum : '') }}" placeholder="Exemplo: valor1:texto1,valor2:texto2,valor3:texto3...">

                    @if($errors->has('dataenum'))
                    <small class="form-text text-red text-bold">
                        {{ $errors->first('dataenum') }}
                    </small>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="form-group {{ $errors->has('helper') ? 'has-error' : '' }} col-md-12">
                    <label for="helper">Texto de Ajuda</label>
                    <input type="text" id="helper" name="helper" class="form-control" value="{{ old('helper', isset($setting) ? $setting->helper : '') }}" placeholder="Texto que será exibido abaixo do campo para orientações">

                    @if($errors->has('helper'))
                    <small class="form-text text-red text-bold">
                        {{ $errors->first('helper') }}
                    </small>
                    @endif
                </div>
            </div>
        </div> <!-- panel-body -->

        <div class="card-footer">
            <a href="{{ route('admin.settings.index') }}" class="btn btn-default"><i class="fas fa-fx fa-reply"></i> Voltar</a>
            <button type="submit" class="btn btn-success"><i class="fas fa-fx fa-save"></i> Salvar</button>
        </div>
    </div>
</form>
@stop

@section('footer')
@include('vendor.adminlte.footer')
@stop

@section('css')
@stop

@section('js')
@stop
