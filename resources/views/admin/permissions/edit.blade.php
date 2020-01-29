@extends('adminlte::page')

@section('title', Session::has('brand_sistema') ? Session::get('brand_sistema') : config('adminlte.title'))

@section('content_header')
<span style="font-size:20px"> <i class="fas fa-key"></i> Cadastro de Permissões</span>
{{ Breadcrumbs::render('permissions_edit') }}
@stop

@section('content')
<form method="post" action="{{ route('admin.permissions.update', [$permission->id]) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="card card-primary card-outline">
        <div class="card-body">
            <div class="row">
                <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }} col-md-12">
                    <label for="title">Título da permissão
                        <span class="text-red">*</span>
                    </label>
                    <input type="text" id="title" name="title" class="form-control" value="{{ old('title', isset($permission) ? $permission->title : '') }}">

                    @if($errors->has('title'))
                    <small class="form-text text-red text-bold">
                        {{ $errors->first('title') }}
                    </small>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }} col-md-12">
                    <label for="slug">Slug</label>
                    <input type="text" id="slug" name="slug" class="form-control" value="{{ old('slug', isset($permission) ? $permission->slug : '') }}">

                    @if($errors->has('slug'))
                    <small class="form-text text-red text-bold">
                        {{ $errors->first('slug') }}
                    </small>
                    @endif
                </div>
            </div>
        </div>

        <div class="card-footer">
            <a href="{{ route('admin.permissions.index') }}" class="btn btn-default"><i class="fas fa-fw fa-reply"></i> Voltar</a>
            <button type="submit" class="btn btn-success"><i class="fas fa-fw fa-save"></i> Salvar</button>
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
