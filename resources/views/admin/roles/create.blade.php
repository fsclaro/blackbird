@extends('adminlte::page')

@section('title', 'Blackbird')

@section('content_header')
<span style="font-size:20px"> <i class="fas fa-fw fa-user-tag"></i> Adicionar Novo Papel</span>
{{ Breadcrumbs::render('roles_create') }}
@stop

@section('content')
<form method="post" action="{{ route('admin.roles.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="panel panel-default">
        <div class="panel-heading">
            Cadastramento de um novo papel
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }} col-md-12">
                    <label for="title">Descrição do papel
                        <span class="text-red">*</span>
                    </label>
                    <input type="text" id="title" name="title" class="form-control" value="{{ old('title', isset($role) ? $role->title : '') }}">

                    @if($errors->has('title'))
                    <p class="help-block">
                        {{ $errors->first('title') }}
                    </p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="form-group {{ $errors->has('permissions') ? 'has-error' : '' }} col-md-12">
                    <label for="permissions">Permissões
                        <span class="text-red">*</span>
                        <a class="btn btn-success btn-sm" id="select-all" onclick="return selectAll();"><i class="fas fa-fx fa-check-double"></i> Selecionar Todas</a>
                        <a class="btn btn-danger btn-sm" id="deselect-all" onclick="return deselectAll();"><i class="fas fa-fx fa-undo"></i> Desmarcar Todas</a>
                    </label>
                    <select name="permissions[]" id="permissions" class="select2 form-control" multiple="multiple">
                        @foreach($permissions as $id => $permissions)
                        <option value="{{ $id }}" {{ (in_array($id, old('permissions', [])) || isset($role) && $role->permissions->contains($id)) ? 'selected' : '' }}>
                            {{ $permissions }}
                        </option>
                        @endforeach
                    </select>
                    @if($errors->has('permissions'))
                    <p class="help-block">
                        {{ $errors->first('permissions') }}
                    </p>
                    @endif
                </div>

            </div>
        </div>

        <div class="panel-footer">
            <a href="{{ route('admin.roles.index') }}" class="btn btn-default"><i class="fas fa-fx fa-reply"></i> Voltar</a>
            <button type="submit" class="btn btn-success"><i class="fas fa-fx fa-save"></i> Salvar</button>
        </div>
    </div>
</form>
@stop

@section('css')
@stop

@section('js')
<script>
    $(function() {
        $("#permissions").select2({
            placeholder: "Selecione pelo menos uma permissão",
            allowClear: true,
        });
    });

    function selectAll() {
        let select = document.getElementById('permissions');
        let options = new Array();

        for (let index = 0; index < select.length; index++) {
            options[index] = select.options[index].value;
        }
        $("#permissions").val(options);
        $("#permissions").trigger("change");
    }

    function deselectAll() {
        $("#permissions").val('');
        $("#permissions").trigger("change");
    }
</script>
@stop
