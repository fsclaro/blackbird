@extends('adminlte::page')

@section('title', 'Blackbird')

@section('content_header')
<span style="font-size:20px"> <i class="fas fa-key"></i> Cadastro de Permissões</span>
{{ Breadcrumbs::render('permissions_show') }}
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <i class="fas fa-eye"></i> Detalhes da permissão
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th style="width:18%">ID</th>
                    <td>{{ $permission->id }}</td>
                </tr>
                <tr>
                    <th style="width:18%">Título da Permissão</th>
                    <td>{{ $permission->title }}</td>
                </tr>
                <tr>
                    <th style="width:18%">Slug da Permissão</th>
                    <td>{{ $permission->slug }}</td>
                </tr>
                <tr>
                    <th style="width:18%">Criado em</th>
                    <td>
                        @if($permission->created_at)
                        {{ $permission->created_at->format("d/m/Y H:i:s") }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <th style="width:18%">Atualizado em</th>
                    <td>
                        @if($permission->updated_at)
                        {{ $permission->updated_at->format("d/m/Y H:i:s") }}
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <a href="{{ route('admin.permissions.index') }}" class="btn btn-default"><i class="fas fa-fw fa-reply"></i> Voltar</a>
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
