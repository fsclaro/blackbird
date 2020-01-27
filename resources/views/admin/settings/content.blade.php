@extends('adminlte::page')

@section('title', Session::has('brand_sistema') ? Session::get('brand_sistema') : config('adminlte.title'))

@section('content_header')
<span style="font-size:20px"> <i class="fas fa-database"></i> Relação de Parâmetros</span>
Parâmetros</span>
{{ Breadcrumbs::render('settings_content') }}
@stop

@section('content')
<form method="post" action="{{ route('admin.settings.savecontent') }}" enctype="multipart/form-data">
    @csrf

    <div class="card">
        <div class="card-header">
            Define os valores dos parâmetros
        </div>

        <div class="card-body">
            @foreach($settings as $key => $setting)

            @if($setting->type == "text")
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="{{ $setting->name }}">{{ $setting->description }}</label>
                    <input type="text" id="{{ $setting->name }}" name="{{ $setting->name }}" class="form-control" value="{{ old('content', isset($setting) ? $setting->content : '') }}">
                    @if($setting->helper)
                    <small class="text-blue">{{ $setting->helper }}</small>
                    @endif
                </div>
            </div>
            @endif

            @if($setting->type == "number")
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="{{ $setting->name }}">{{ $setting->description }}</label>
                    <input type="number" id="{{ $setting->name }}" name="{{ $setting->name }}" class="form-control" value="{{ old('content', isset($setting) ? $setting->content : '') }}">

                    @if($setting->helper)
                    <small class="text-blue">{{ $setting->helper }}</small>
                    @endif
                </div>
            </div>
            @endif

            @if($setting->type == "email")
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="{{ $setting->name }}">{{ $setting->description }}</label>
                    <input type="email" id="{{ $setting->name }}" name="{{ $setting->name }}" class="form-control" value="{{ old('content', isset($setting) ? $setting->content : '') }}">

                    @if($setting->helper)
                    <small class="text-blue">{{ $setting->helper }}</small>
                    @endif
                </div>
            </div>
            @endif

            @if($setting->type == "textarea")
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="{{ $setting->name }}">{{ $setting->description }}</label>
                    <textarea class="form-control" id="{{ $setting->name }}" name="{{ $setting->name }}">{{ $setting->content }}</textarea>

                    @if($setting->helper)
                    <small class="text-blue">{{ $setting->helper }}</small>
                    @endif
                </div>
            </div>
            @endif

            @if($setting->type == "wysiwyg")
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="{{ $setting->name }}">{{ $setting->description }}</label>
                    <textarea class="form-control" id="{{ $setting->name }}" name="{{ $setting->name }}">{{ $setting->content }}</textarea>

                    @if($setting->helper)
                    <small class="text-blue">{{ $setting->helper }}</small>
                    @endif
                </div>
            </div>
            @endif

            @if($setting->type == "datepicker")
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="{{ $setting->name }}">{{ $setting->description }}</label>
                    <input type="datetime-local" id="{{ $setting->name }}" name="{{ $setting->name }}" class="form-control" value="{{ old('content', isset($setting) ? $setting->content : '') }}">

                    @if($setting->helper)
                    <small class="text-blue">{{ $setting->helper }}</small>
                    @endif
                </div>
            </div>
            @endif

            @if($setting->type == "radio")
            <div class="row">
                <div class="form-group col-sm-12">
                    <label>{{ $setting->description }}</label>
                    @php
                    $items = explode(",", $setting->dataenum)
                    @endphp

                    @for($i=0;$i<count($items);$i++) <div class="radio">
                        <label>
                            <input type="radio" id="{{ $setting->name }}" name="{{ $setting->name }}" class="radio" value="{{ $items[$i] }}" @if($setting->content == $items[$i]) checked @endif>{{ $items[$i] }}
                        </label>
                    @endfor

                    @if($setting->helper)
                    <small class="text-blue">{{ $setting->helper }}</small>
                    @endif
                </div>
            </div>
            @endif

            @if($setting->type == "select")
            <div class="row">
                <div class="form-group col-sm-12">
                    <label for="{{ $setting->name }}">{{ $setting->description }}</label>
                    @php
                        $items = explode(",", $setting->dataenum)
                    @endphp

                    @for($i=0;$i<count($items);$i++)
                    <div class="select">
                        <select class="form-control" name="{{ $setting->name }}" id="{{ $setting->name }}">
                            <option value="">Escolha uma das opções...</option>
                            @for($i=0; $i<count($items); $i++)
                            @php
                                if (strpos($items[$i], "|")) {
                                    list($value, $option) = explode("|", $items[$i]);
                                } else {
                                   $value = $option = $items[$i];
                                }
                            @endphp
                            <option value="{{ $value }}" @if($setting->content == $value) selected @endif>{{ $option }}</option>
                            @endfor
                        </select>
                    </div>
                    @endfor

                    @if($setting->helper)
                        <small class="text-blue">{{ $setting->helper }}</small>
                    @endif
                </div>
            </div>
            @endif

            @if($setting->type == "image")
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="{{ $setting->name }}">{{ $setting->description }}</label>

                    <input type="file" id="{{ $setting->name }}" name="{{ $setting->name }}" class="form-control">

                    @if($setting->helper)
                    <small class="text-blue">{{ $setting->helper }}</small>
                    @endif
                </div>

            </div>
            @endif

            @if($setting->type == "file")
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="{{ $setting->name }}">{{ $setting->description }}</label>
                    <input type="file" id="{{ $setting->name }}" name="{{ $setting->name }}" class="form-control" value="{{ old('content', isset($setting) ? $setting->content : '') }}">

                    @if($setting->helper)
                    <small class="text-blue">{{ $setting->helper }}</small>
                    @endif
                </div>
            </div>
            @endif

            @endforeach
        </div> <!-- panel-body -->

        <div class="card-footer">
            <a href="{{ route('admin.settings.index') }}" class="btn btn-default"><i class="fas fa-fw fa-reply"></i> Voltar</a>
            <button type="submit" class="btn btn-success"><i class="fas fa-fw fa-save"></i> Salvar</button>
        </div>
    </div>
</form>
@stop

@section('footer')
@include('vendor.adminlte.footer')
@stop

@section('css')
@stop

@section('js')

@foreach($settings as $setting)
@if($setting->type == "wysiwyg")
<script>
    $(function() {
        $('#{{ $setting->name }}').summernote({
            lang: 'pt-BR',
            tabsize: 2,
            height: 100
        });
    });
</script>
@endif
@endforeach
@stop
