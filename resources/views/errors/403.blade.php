@extends('errors::custom')

@section('title', __('Negado'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Lamento, mas você não tem acesso a este recurso.'))
