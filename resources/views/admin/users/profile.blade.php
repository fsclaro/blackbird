@extends('adminlte::page')

@section('title', Session::has('brand_sistema') ? Session::get('brand_sistema') : config('adminlte.title'))

@section('content_header')
<span style="font-size:20px"> <i class="fas fa-fw fa-users"></i> Cadastro do Usuário</span>
{{ Breadcrumbs::render('users_profile') }}
@stop

@section('content')
<form method="post" action="{{ route('admin.users.update.profile', [$user->id]) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <input type="hidden" name="return_url" value="{{ $return_url }}">

    <div class="card">

        <div class="card-header">
            <i class="fas fa-user-edit"></i>Edição dos seus dados
        </div> <!-- panel-heading -->

        <div class="card-body">
            <div class="container-fluid">
                <div class="row">
                    <!-- lado esquerdo -->
                    <div class="col-md-3">
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
                                    <img src="{{ asset('img/avatares/no-photo.png') }}" id="img-avatar" name="img-avatar" width="120px" class="img-circle" alt="Foto do perfil" title="Foto do perfil">
                                @endif
                            @endif

                            <div class="row">&nbsp;</div>

                            <div class="btn-group-sm center-block" role="group">
                                <div class="btn btn-success div-avatar">
                                    <input type="file" id="avatar" name="avatar" class="input-avatar" onchange="changeAvatar(event);">
                                    <span><i class="fas fa-fw fa-camera"></i> Nova Foto</span>
                                </div>

                                @if($canDeleteAvatar)
                                <a href="{{ route('admin.users.delete.avatar', $user) }}" class="btn btn-danger"><i class="fas fa-fw fa-trash"></i> Excluir Foto</a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- lado direito -->
                    <div class="col-md-9">
                        <div class="row">
                            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }} col-md-8">
                                <label for="name">Nome do Usuário
                                    <span class="text-red">*</span>
                                </label>
                                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($user) ? $user->name : '') }}">

                                @if($errors->has('name'))
                                <p class="form-text text-red text-bold">
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
                                <p class="form-text text-red text-bold">
                                    {{ $errors->first('email') }}
                                </p>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }} col-md-6">
                                <label for="title">Senha</label>
                                <input type="password" id="password" name="password" class="form-control" value="" placeholder="A senha deve ter pelo menos 8 caracteres">
                                <small class="text-info">Deixe o campo da senha em branco caso não queira alterá-la</small>

                                @if($errors->has('password'))
                                <p class="form-text text-red text-bold">
                                    @endif
                                    {{ $errors->first('password') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- panel-body -->

        <div class="card-footer">
            <a href="{{ route('home') }}" class="btn btn-default"><i class="fas fa-fw fa-reply"></i> Voltar</a>
            <button type="submit" class="btn btn-success"><i class="fas fa-fw fa-save"></i> Salvar</button>
        </div> <!-- panel-footer -->
    </div> <!-- panel pane-default -->
</form>
@stop

@section('footer')
@include('vendor.adminlte.footer')
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
