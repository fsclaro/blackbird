@extends('adminlte::page')

@section('title', Session::has('brand_sistema') ? Session::get('brand_sistema') : config('adminlte.title'))

@section('content_header')
<span style="font-size:20px"> <i class="fas fa-database"></i> Relação de Parâmetros</span>
{{ Breadcrumbs::render('settings_create') }}
@stop

@section('content')
<form method="post" action="{{ route('admin.settings.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="card card-primary card-outline">

        <div class="card-body">
            <div class="row">
                <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }} col-md-12">
                    <label for="description">Descrição do Parâmetro
                        <span class="text-red">*</span>
                    </label>
                    <input type="text" id="description" name="description" class="form-control" value="{{ old('description', isset($setting) ? $setting->description : '') }}">

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
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($setting) ? $setting->name : '') }}" placeholder="Se preferir, deixe em branco para que o sistema gere automaticamente">

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
                        <option value="text">Texto</option>
                        <option value="number">Número</option>
                        <option value="email">Email</option>
                        <option value="textarea">Área de Texto</option>
                        <option value="wysiwyg">Wysiwyg</option>
                        <option value="datepicker">Data/Hora</option>
                        <option value="radio">Rádio</option>
                        <option value="select">Seleção</option>
                        <option value="image">Imagem</option>
                        <option value="file">Arquivo</option>
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
                    <label for="dataenum">Radio / Seleção</label>
                    <input type="text" id="dataenum" name="dataenum" class="form-control" value="{{ old('dataenum', isset($setting) ? $setting->dataenum : '') }}" placeholder="Exemplo: valor1,valor2,valor3...">

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

            <div class="row">
                <div class="form-group {{ $errors->has('can_delete') ? 'has-error' : '' }} col-md-2">
                    <label for="can_delete">Pode ser Excluído?
                        <span class="text-red">*</span>
                    </label>

                    <select id="can_delete" name="can_delete" class="form-control">
                        <option value=>Selecione uma das opções...</option>
                        <option value=1>Sim</option>
                        <option value=0>Não</option>
                    </select>

                    @if($errors->has('can_delete'))
                    <small class="form-text text-red text-bold">
                        {{ $errors->first('can_delete') }}
                    </small>
                    @endif
                </div>
            </div>
        </div> <!-- panel-body -->

        <div class="card-footer">
            <a href="{{ route('admin.settings.index') }}" class="btn btn-default"><i class="fas fa-fw fa-reply"></i> Voltar</a>
            <button type="submit" class="btn btn-success"><i class="fas fa-fw fa-save"></i> Salvar</button>
        </div> <!-- panel-footer -->

    </div> <!-- panel panel-default -->
</form>
@stop

@section('footer')
@include('vendor.adminlte.footer')
@stop

@section('css')
@stop

@section('js')
<script>
    $(function() {
        $("#type").select2();
        $("#can_delete").select2();
    });
</script>
@stop
