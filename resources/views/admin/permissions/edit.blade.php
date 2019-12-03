@extends('adminlte::page')

@section('title', 'Blackbird')

@section('content_header')
<span style="font-size:20px"> <i class="fas fa-fw fa-key"></i> Edita a Permissão</span>
{{ Breadcrumbs::render('permissions_edit') }}
@stop

@section('content')
<form method="post" action="{{ route('admin.permissions.update', [$permission->id]) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="panel panel-default">
        <div class="panel-heading">
            Edita a permissão
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }} col-md-12">
                    <label for="title">Título da permissão
                        <span class="text-red">*</span>
                    </label>
                    <input type="text" id="title" name="title" class="form-control" value="{{ old('title', isset($permission) ? $permission->title : '') }}">

                    @if($errors->has('title'))
                    <p class="help-block">
                        {{ $errors->first('title') }}
                    </p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }} col-md-12">
                    <label for="slug">Slug</label>
                    <input type="text" id="slug" name="slug" class="form-control" value="{{ old('slug', isset($permission) ? $permission->slug : '') }}">

                    @if($errors->has('slug'))
                    <p class="help-block">
                        {{ $errors->first('slug') }}
                    </p>
                    @endif
                </div>
            </div>
        </div>

        <div class="panel-footer">
            <a href="{{ route('admin.permissions.index') }}" class="btn btn-default"><i class="fas fa-fx fa-reply"></i> Voltar</a>
            <button type="submit" class="btn btn-success"><i class="fas fa-fx fa-save"></i> Salvar</button>
        </div>
    </div>
</form>
@stop

@section('css')
@stop

@section('js')
@stop
