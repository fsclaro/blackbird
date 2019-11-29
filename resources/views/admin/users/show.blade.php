@extends('adminlte::page')

@section('title', 'Vulcano')

@section('content_header')
<span style="font-size:20px"> <i class="fas fa-fw fa-user"></i> Exibe detalhes do Usuário</span>
{{ Breadcrumbs::render('users_show') }}
@stop

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        Detalhes do usuário
    </div>
    <div class="panel-body">
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th class="col-sm-2">
                        ID
                    </th>
                    <td>
                        {{ $user->id }}
                    </td>
                </tr>
                <tr>
                    <th class="col-sm-2">
                        Nome do Usuário
                    </th>
                    <td>
                        {{ $user->name }}
                    </td>
                </tr>
                <tr>
                    <th class="col-sm-2">
                        E-mail
                    </th>
                    <td>
                        {{ $user->email }}
                    </td>
                </tr>

                <tr>
                    <th class="col-sm-2">
                        Usuário Ativo?
                    </th>
                    <td>
                        @if($user->active)
                        <span class="label label-success">Sim</span>
                        @else
                        <span class="label label-danger">Não</span>
                        @endif
                    </td>
                </tr>

                <tr>
                    <th class="col-sm-2">
                        Foto
                    </th>
                    <td>
                        @if($user->getAvatar($user->id))
                        <img src="{{ $user->getAvatar($user->id) }}" id="img-avatar" name="img-avatar" width="50px" class="img-circle" alt="Foto do perfil" title="Foto do perfil">
                        @else
                        @if (Gravatar::exists(Auth::user()->email))
                        <img src="{{ Gravatar::get($user()->email) }}" id="img-avatar" name="img-avatar" width="50px" class="img-circle" alt="Foto do perfil" title="Foto do perfil">
                        @else
                        <img src="{{ asset('img/avatar/no-photo.png') }}" id="img-avatar" name="img-avatar" width="50px" class="img-circle" alt="Foto do perfil" title="Foto do perfil">
                        @endif
                        @endif
                    </td>
                </tr>

                <tr>
                    <th class="col-sm-2">
                        Papéis
                    </th>
                    <td>
                        @foreach($user->roles as $key => $role)
                        <span class="label label-primary">{{ $role->title }}</span>
                        @endforeach
                    </td>
                </tr>

                <tr>
                    <th class="col-sm-2">
                        Criado em
                    </th>
                    <td>
                        {{ $user->created_at->format("d/m/Y H:i:s") }}
                    </td>
                </tr>

                <tr>
                    <th class="col-sm-2">
                        Atualizado em
                    </th>
                    <td>
                        {{ $user->updated_at->format("d/m/Y H:i:s") }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="panel-footer">
        <a href="{{ route('admin.users.index') }}" class="btn btn-default"><i class="fas fa-fx fa-reply"></i> Voltar</a>
    </div>
</div>
@stop

@section('css')
@stop

@section('js')
@stop
