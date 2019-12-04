@extends('adminlte::page')

@section('title', 'Blackbird')

@section('content_header')
<span style="font-size:20px"> <i class="fas fa-fw fa-users"></i> Cadastro de Usuários</span>
{{ Breadcrumbs::render('users_profile') }}
@stop

@section('content')
<form method="post" action="{{ route('admin.users.update.profile', [$user->id]) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <input type="hidden" name="return_url" value="{{ $return_url }}">

    <div class="panel panel-default">

        <div class="panel-heading">
            Edita os dados do seu cadastro
        </div> <!-- panel-heading -->

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
                    @if (Gravatar::exists(Auth::user()->email))
                    <img src="{{ Gravatar::get(Auth::user()->email) }}" id="img-avatar" name="img-avatar" width="120px" class="img-circle" alt="Foto do perfil" title="Foto do perfil">
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
            </div>

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

            </div>
        </div> <!-- panel-body -->

        <div class="panel-footer">
            <a href="{{ $return_url }}" class="btn btn-default"><i class="fas fa-fx fa-reply"></i> Voltar</a>
            <button type="submit" class="btn btn-success"><i class="fas fa-fx fa-save"></i> Salvar</button>
        </div> <!-- panel-footer -->
    </div> <!-- panel pane-default -->
</form>
@stop

@section('css')
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
<script>
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
