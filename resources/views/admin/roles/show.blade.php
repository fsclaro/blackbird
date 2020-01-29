@extends('adminlte::page')

@section('title', Session::has('brand_sistema') ? Session::get('brand_sistema') : config('adminlte.title'))

@section('content_header')
<span style="font-size:20px"> <i class="fas fa-fw fa-user-tag"></i> Cadastro de Papéis</span>
{{ Breadcrumbs::render('roles_show') }}
@stop

@section('content')
<div class="card card-primary card-outline">
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th style="width:18%">ID</th>
                    <td>{{ $role->id }}</td>
                </tr>
                <tr>
                    <th style="width:18%">Descrição</th>
                    <td>{{ $role->title }}</td>
                </tr>
                <tr>
                    <th style="width:18%">Permissões</th>
                    <td>
                        @foreach($role->permissions as $key => $permission)
                        <span class="badge badge-primary">{{ $permission->title }}</span>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th style="width:18%">Criado em</th>
                    <td>
                        @if($role->created_at)
                        {{ $role->created_at->format("d/m/Y H:i:s") }}
                        @else
                        <span class="text-red">Informação não disponível</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th style="width:18%">Atualizado em</th>
                    <td>
                        @if($role->updated_at)
                        {{ $role->updated_at->format("d/m/Y H:i:s") }}
                        @else
                        <span class="text-red">Informação não disponível</span>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <a href="{{ route('admin.roles.index') }}" class="btn btn-default"><i class="fas fa-fw fa-reply"></i> Voltar</a>
    </div>
</div>
@stop

@section('footer')
@include('vendor.adminlte.footer')
@stop

@section('css')
@stop

@section('js')
@stop
