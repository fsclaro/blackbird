@extends('adminlte::page')

@section('title', env('APP_NAME','Blackbird'))

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
    <div class="row">
        @widget('UsersCount')
        @widget('PermissionsCount')
        @widget('RolesCount')
        @widget('SettingsCount')
    </div>

    <div class="row">
        @widget('LogsCount')
    </div>

    @include("partials.dashboard-profile")
</div>
@stop

@section('footer')
@include('vendor.adminlte.footer')
@stop
