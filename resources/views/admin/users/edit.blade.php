@extends('adminlte::page')

@section('title', Session::has('brand_sistema') ? Session::get('brand_sistema') : config('adminlte.title'))

@section('content_header')
<span style="font-size:20px"> <i class="fas fa-fw fa-users"></i> Cadastro de Usuários</span>
{{ Breadcrumbs::render('users_edit') }}
@stop

@section('content')
<form method="post" action="{{ route('admin.users.update', [$user->id]) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <input type="hidden" name="id" id="id" value="{{ $user->id }}">

    <div class="row">
        <div class="col-lg-3">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <label for="foto">Foto do Usuário</label>
                    <br />
                    <div class="image text-center">
                        @php $canDeleteAvatar = false; @endphp

                        @if($user->getAvatar($user->id))
                            @php
                                $canDeleteAvatar = true;
                            @endphp
                            <img src="{{ $user->getAvatar($user->id) }}" id="img-avatar" name="img-avatar" class="profile-user-img img-fluid img-circle" alt="Foto do perfil" title="Foto do perfil">
                        @else
                            @if (Gravatar::exists($user->email))
                                <img src="{{ Gravatar::get($user->email) }}" id="img-avatar" name="img-avatar" class="profile-user-img img-fluid img-circle" alt="Foto do perfil" title="Foto do perfil">
                            @else
                                <img src="{{ asset('img/avatares/Others/no-photo.png') }}" id="img-avatar" name="img-avatar" class="profile-user-img img-fluid img-circle" alt="Foto do perfil" title="Foto do perfil">
                            @endif
                        @endif

                        <div class="row">&nbsp;</div>

                        <div class="btn-group-sm center-block" role="group">
                            <div class="btn btn-flat btn-success div-avatar">
                                <input type="file" id="avatar" name="avatar" class="input-avatar" onchange="changeAvatar(event);">
                                <span><i class="fas fa-fw fa-camera"></i> Nova Foto</span>
                            </div>

                            @if($canDeleteAvatar)
                                <a href="{{ route('admin.users.delete.avatar', $user) }}" class="btn btn-flat btn-danger"><i class="fas fa-fw fa-trash"></i> Excluir Foto</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="card card-success card-outline">
                <div class="card-body box-profile">
                    <div class="row">
                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }} col-md-8">
                            <label for="name">Nome do Usuário
                                <span class="text-red">*</span>
                            </label>

                            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($user) ? $user->name : '') }}">

                            @if($errors->has('name'))
                                <small class="form-text text-red text-bold">
                                    {{ $errors->first('name') }}
                                </small>
                            @endif
                        </div>
                    </div> <!-- row -->

                    <div class="row">
                        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }} col-md-5">
                            <label for="title">Email
                                <span class="text-red">*</span>
                            </label>

                            <input type="text" id="email" name="email" class="form-control" value="{{ old('email', isset($user) ? $user->email : '') }}">

                            @if($errors->has('email'))
                            <small class="form-text text-red text-bold">
                                {{ $errors->first('email') }}
                            </small>
                            @endif
                        </div>
                    </div> <!-- row -->

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
                            <small class="form-text text-red text-bold">
                                {{ $errors->first('active') }}
                            </small>
                            @endif
                        </div>
                    </div> <!-- row -->

                    <div class="row">
                        <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }} col-md-6">
                            <label for="title">Senha</label>
                            <input type="password" id="password" name="password" class="form-control" value="" placeholder="A senha deve ter pelo menos 8 caracteres">
                            <small class="text-info">Deixe o campo da senha em branco caso não queira alterá-la</small>

                            @if($errors->has('password'))
                            <small class="form-text text-red text-bold">
                                {{ $errors->first('password') }}
                            </small>
                            @endif
                        </div>
                    </div> <!-- row -->

                    <div class="row">
                        <div class="form-group {{ $errors->has('roles') ? 'has-error' : '' }} col-md-4">
                            <label for="roles">Papel
                                <span class="text-red">*</span>
                            </label>

                            <select name="roles" id="roles" class="select2 form-control">
                                <option>Selecione uma das opções...</option>
                                @foreach($roles as $id => $roles)
                                @if($roles == "SuperAdmin")
                                    @continue
                                @endif
                                <option value="{{ $id }}" {{ (in_array($id, old('roles', [])) || isset($user) && $user->roles->contains($id)) ? 'selected' : '' }}>
                                    {{ $roles }}
                                </option>
                                @endforeach
                            </select>

                            @if($errors->has('roles'))
                            <small class="form-text text-red text-bold">
                                {{ $errors->first('roles') }}
                            </small>
                            @endif
                        </div>
                    </div> <!-- row -->
                </div> <!-- card-body -->

                <div class="card-footer">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-flat btn-default">
                        <i class="fas fa-fw fa-reply"></i> Voltar
                    </a>

                    <button type="submit" class="btn btn-flat btn-success">
                        <i class="fas fa-fw fa-save"></i> Salvar
                    </button>
                </div> <!-- panel-footer -->

            </div> <!-- card -->
        </div> <!-- col-lg-9 -->
    </div> <!-- row -->
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
    $(function() {
        $("#roles").select2();

        $("#active").select2();
    });

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
