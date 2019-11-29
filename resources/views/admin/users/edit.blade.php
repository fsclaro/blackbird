@extends('adminlte::page')

@section('title', 'Vulcano')

@section('content_header')
<span style="font-size:20px"> <i class="fas fa-fw fa-user"></i> Editar dados do Usuário</span>
{{ Breadcrumbs::render('users_edit') }}
@stop

@section('content')
<form method="post" action="{{ route('admin.users.update', [$user->id]) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <input type="hidden" name="id" id="id" value="{{ $user->id }}">

    <div class="panel panel-default">
        <div class="panel-heading">
            Dados do usuário
        </div>

        <div class="panel-body">
            <!-- lado esquerdo -->
            <div class="col-sm-3">
                <div class="image text-center">
                    <label for="foto">Foto do Usuário</label>
                    <br />

                    @php $canDeleteAvatar = false; @endphp

                    @if($user->getAvatar($user->id))
                    @php $canDeleteAvatar = true; @endphp
                    <img src="{{ $user->getAvatar($user->id) }}" id="img-avatar" name="img-avatar" width="120px" class="img-circle" alt="Foto do perfil" title="Foto do perfil">
                    @else
                    @if (Gravatar::exists($user->email))
                    <img src="{{ Gravatar::get($user->email) }}" id="img-avatar" name="img-avatar" width="120px" class="img-circle" alt="Foto do perfil" title="Foto do perfil">
                    @else
                    <img src="{{ asset('img/avatar/no-photo.png') }}" id="img-avatar" name="img-avatar" width="120px" class="img-circle" alt="Foto do perfil" title="Foto do perfil">
                    @endif
                    @endif

                    <div class="row">&nbsp;</div>

                    <div class="btn-group-sm center-block" role="group">
                        <div class="btn btn-success div-avatar">
                            <input type="file" id="avatar" name="avatar" class="input-avatar" onchange="changeAvatar(event);">
                            <span><i class="fas fa-fx fa-camera"></i> Nova Foto</span>
                        </div>

                        @if($canDeleteAvatar)
                        <a href="{{ route('admin.users.delete.avatar', $user) }}" class="btn btn-danger"><i class="fas fa-fx fa-trash"></i> Excluir Foto</a>
                        @endif
                    </div>
                </div>
            </div> <!-- col-sm-3 -->

            <!-- lado direito -->
            <div class="col-sm-9">
                <div class="row">
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }} col-md-8">
                        <label for="name">Nome do Usuário
                            <span class="text-red">*</span>
                        </label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($user) ? $user->name : '') }}">

                        @if($errors->has('name'))
                        <p class="help-block">
                            {{ $errors->first('name') }}
                        </p>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }} col-md-5">
                        <label for="title">Email
                            <span class="text-red">*</span>
                        </label>
                        <input type="text" id="email" name="email" class="form-control" value="{{ old('email', isset($user) ? $user->email : '') }}">

                        @if($errors->has('email'))
                        <p class="help-block">
                            {{ $errors->first('email') }}
                        </p>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="form-group {{ $errors->has('active') ? 'has-error' : '' }} col-md-5">
                        <label for="active">Ativar o usuário?
                            <span class="text-red">*</span>
                        </label>

                        <select id="active" name="active" class="form-control">
                            <option>Selecione uma das opções...</option>
                            <option value=0 @if($user->active==0) selected @endif>Não - O usuário não poderá acessar o sistema</option>
                            <option value=1 @if($user->active==1) selected @endif>Sim - O usuário poderá acessar o sistema</option>
                        </select>

                        @if($errors->has('active'))
                        <p class="help-block">
                            {{ $errors->first('active') }}
                        </p>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }} col-md-5">
                        <label for="title">Senha</label>
                        <input type="password" id="password" name="password" class="form-control" value="" placeholder="A senha deve ter pelo menos 8 caracteres">
                        <small class="text-info">Deixe o campo da senha em branco caso não queira alterá-la</small>

                        @if($errors->has('password'))
                        <p class="help-block">
                            @endif
                            {{ $errors->first('password') }}
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group {{ $errors->has('active') ? 'has-error' : '' }} col-md-4">
                        <label for="skin">Aparência da Interface</label>
                        <select id="skin" name="skin" class="form-control">
                            <option value=>Selecione uma das opções...</option>
                            @foreach($skins as $key => $caption)
                            <option value="{{ $key }}" @if($user->skin == $key) selected @endif>{{ $caption }}</option>
                            @endforeach
                        </select>

                        @if($errors->has('active'))
                        <p class="help-block">
                            {{ $errors->first('active') }}
                        </p>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="form-group {{ $errors->has('roles') ? 'has-error' : '' }} col-md-12">
                        <label for="roles">Papéis
                            <span class="text-red">*</span>
                            <a class="btn btn-primary btn-sm" id="select-all" onclick="return selectAll();"><i class="fas fa-fx fa-check-double"></i> Selecionar Todos</a>
                            <a class="btn btn-danger btn-sm" id="deselect-all" onclick="return deselectAll();"><i class="fas fa-fx fa-undo"></i> Desmarcar Todos</a>
                        </label>

                        <select name="roles[]" id="roles" class="select2 form-control" multiple="multiple">
                            @foreach($roles as $id => $roles)
                            <option value="{{ $id }}" {{ (in_array($id, old('roles', [])) || isset($user) && $user->roles->contains($id)) ? 'selected' : '' }}>
                                {{ $roles }}
                            </option>
                            @endforeach
                        </select>

                        @if($errors->has('roles'))
                        <p class="help-block">
                            {{ $errors->first('roles') }}
                        </p>
                        @endif
                    </div>
                </div>
            </div> <!-- col-sm-9 -->
        </div> <!-- panel-body -->

        <div class="panel-footer">
            <a href="{{ route('admin.users.index') }}" class="btn btn-default"><i class="fas fa-fx fa-reply"></i> Voltar</a>
            <button type="submit" class="btn btn-success"><i class="fas fa-fx fa-save"></i> Salvar</button>
        </div> <!-- panel-footer -->
    </div> <!-- panel panel-default -->
</form>
@stop

@section('css')
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

<style>
    .div-avatar {
        position: relative;
        overflow: hidden;
    }

    .input-avatar {
        position: absolute;
        font-size: 20px;
        opacity: 0;
        right: 0;
        top: 0;
    }
</style>
@stop

@section('js')
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<script>
    $(function() {
        $("#roles").select2({
            placeholder: "Selecione pelo menos um papel para este usuário",
            allowClear: true,
        });
    });

    function selectAll() {
        let select = document.getElementById('roles');
        let options = new Array();

        for (let index = 0; index < select.length; index++) {
            options[index] = select.options[index].value;
        }
        $("#roles").val(options);
        $("#roles").trigger("change");
    }

    function deselectAll() {
        $("#roles").val('');
        $("#roles").trigger("change");
    }

    function changeAvatar(e) {
        var selectedFile = e.target.files[0];
        var reader = new FileReader();
        var imgTag = document.getElementById("img-avatar");

        imgTag.title = selectedFile.name;

        reader.onload = function(e) {
            imgTag.src = e.target.result;
        }
        reader.readAsDataURL(selectedFile);
    }
</script>
@stop
