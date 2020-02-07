@extends('adminlte::page')

@section('title', Session::has('brand_sistema') ? Session::get('brand_sistema') : config('adminlte.title'))

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h5><i class="fas fa-tachometer-alt"></i> Dashboard</h5>
        </div><!-- /.col -->
        <div class="col-sm-6">
            {{ Breadcrumbs::render('dashboard') }}
        </div><!-- /.col -->
    </div><!-- /.row -->
</div>
@stop

@section('content')
<div class="container-fluid">
    @if(in_array(Auth::user()->getMyRoleName(), ['Admin', 'SuperAdmin']))
    <div class="row">
        @widget('UsersCount')
        @widget('PermissionsCount')
        @widget('RolesCount')
        @widget('SettingsCount')
        @widget('UsersLogin7Days')
    </div>
    @endif

    @include("partials.dashboard-profile")

</div>
@stop

@section('footer')
@include('vendor.adminlte.footer')
@stop

@section('js')

@stop

@section('css')

@stop
