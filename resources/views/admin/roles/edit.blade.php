@extends('adminlte::page')

@section('title', 'Blackbird')

@section('content_header')
<span style="font-size:20px"> <i class="fas fa-fw fa-user-tag"></i> Cadastro de Papéis</span>
{{ Breadcrumbs::render('roles_edit') }}
@stop

@section('content')
<form method="post" action="{{ route('admin.roles.update', [$role->id]) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <input type="hidden" name="id" id="id" value="{{ $role->id }}">

    <div class="card">
        <div class="card-header">
            <i class="fas fa-edit"></i> Edição dos dados de um papél
        </div>

        <div class="card-body">
            <div class="row">
                <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }} col-md-12">
                    <label for="title">Descrição do papel
                        <span class="text-red">*</span>
                    </label>
                    <input type="text" id="title" name="title" class="form-control" value="{{ old('title', isset($role) ? $role->title : '') }}">

                    @if($errors->has('title'))
                    <small class="form-text text-red text-bold">
                        {{ $errors->first('title') }}
                    </small>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="form-group {{ $errors->has('permissions') ? 'has-error' : '' }} col-md-9">
                    <label for="permissions">Permissões
                        <span class="text-red">*</span>
                        <a class="btn btn-flat btn-success btn-sm text-white" id="select-all" onclick="return selectAll();"><i class="fas fa-fw fa-check-double"></i> Selecionar Todas</a>
                        <a class="btn btn-flat btn-danger btn-sm text-white" id="deselect-all" onclick="return deselectAll();"><i class="fas fa-fw fa-undo"></i> Desmarcar Todas</a>
                    </label>
                    <select name="permissions[]" id="permissions" class="select2 form-control" multiple="multiple">
                        @foreach($permissions as $id => $permissions)
                        <option value="{{ $id }}" {{ (in_array($id, old('permissions', [])) || isset($role) && $role->permissions->contains($id)) ? 'selected' : '' }}>
                            {{ $permissions }}
                        </option>
                        @endforeach
                    </select>
                    @if($errors->has('permissions'))
                    <small class="form-text text-red text-bold">
                        {{ $errors->first('permissions') }}
                    </small>
                    @endif
                </div>
            </div>
        </div>

        <div class="card-footer">
            <a href="{{ route('admin.roles.index') }}" class="btn btn-flat btn-default"><i class="fas fa-fw fa-reply"></i> Voltar</a>
            <button type="submit" class="btn btn-flat btn-success"><i class="fas fa-fw fa-save"></i> Salvar</button>
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
