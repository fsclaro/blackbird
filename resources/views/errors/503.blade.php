@extends('errors::vulcano')

@section('title', __('Serviço não disponpível'))
@section('code', '503')
@section('message', __($exception->getMessage() ?: 'Lamento, mas este serviço não está disponível.'))
