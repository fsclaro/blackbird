@extends('adminlte::page')

@section('title', 'Vulcano')

@section('content_header')
<span style="font-size:20px"> <i class="fas fa-fw fa-bullhorn"></i> Define valores dos Parâmetros</span>
{{ Breadcrumbs::render('parameters_content') }}
@stop

@section('content')
<form method="post" action="{{ route('admin.parameters.savecontent') }}" enctype="multipart/form-data">
    @csrf

    <div class="panel panel-default">
        <div class="panel-heading">
            Define os valores dos parâmetros
        </div>

        <div class="panel-body">
            @foreach($parameters as $key => $parameter)
                @if($parameter->type == "text")
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="{{ $parameter->name }}">{{ $parameter->description }}</label>
                        <input type="text" id="{{ $parameter->name }}" name="{{ $parameter->name }}" class="form-control" value="{{ old('content', isset($parameter) ? $parameter->content : '') }}">
                        @if($parameter->helper)
                        <span class="text-light-blue">{{ $parameter->helper }}</span>
                        @endif
                    </div>
                </div>
                @endif

                @if($parameter->type == "number")
                <div class="row">
                    <div class="form-group col-md-2">
                        <label for="{{ $parameter->name }}">{{ $parameter->description }}</label>
                        <input type="number" id="{{ $parameter->name }}" name="{{ $parameter->name }}" class="form-control" value="{{ old('content', isset($parameter) ? $parameter->content : '') }}">
                        @if($parameter->helper)
                        <span class="text-light-blue">{{ $parameter->helper }}</span>
                        @endif
                    </div>
                </div>
                @endif

                @if($parameter->type == "email")
                <div class="row">
                    <div class="form-group col-md-8">
                        <label for="{{ $parameter->name }}">{{ $parameter->description }}</label>
                        <input type="email" id="{{ $parameter->name }}" name="{{ $parameter->name }}" class="form-control" value="{{ old('content', isset($parameter) ? $parameter->content : '') }}">
                        @if($parameter->helper)
                        <span class="text-light-blue">{{ $parameter->helper }}</span>
                        @endif
                    </div>
                </div>
                @endif

                @if($parameter->type == "textarea")
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="{{ $parameter->name }}">{{ $parameter->description }}</label>
                        <textarea class="form-control" id="{{ $parameter->name }}" name="{{ $parameter->name }}">{{ $parameter->content }}</textarea>

                        @if($parameter->helper)
                        <span class="text-light-blue">{{ $parameter->helper }}</span>
                        @endif
                    </div>
                </div>
                @endif

                @if($parameter->type == "wysiwyg")
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="{{ $parameter->name }}">{{ $parameter->description }}</label>
                        <textarea class="form-control" id="{{ $parameter->name }}" name="{{ $parameter->name }}">{{ $parameter->content }}</textarea>

                        @if($parameter->helper)
                        <span class="text-light-blue">{{ $parameter->helper }}</span>
                        @endif
                    </div>
                </div>
                @endif

                @if($parameter->type == "datepicker")
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="{{ $parameter->name }}">{{ $parameter->description }}</label>
                        <input type="datetime-local" id="{{ $parameter->name }}" name="{{ $parameter->name }}" class="form-control" value="{{ old('content', isset($parameter) ? $parameter->content : '') }}">

                        @if($parameter->helper)
                        <span class="text-light-blue">{{ $parameter->helper }}</span>
                        @endif
                    </div>
                </div>
                @endif

                @if($parameter->type == "radio")
                <div class="row">
                    <div class="form-group col-sm-12">
                        <label>{{ $parameter->description }}</label>
                        @php
                            $items = explode(",", $parameter->dataenum)
                        @endphp

                        @for($i=0;$i<count($items);$i++)
                        <div class="radio">
                            <label>
                                <input type="radio" id="{{ $parameter->name }}" name="{{ $parameter->name }}" class="radio" value="{{ $items[$i] }}" @if($parameter->content == $items[$i]) checked @endif>{{ $items[$i] }}
                            </label>
                        </div>
                        @endfor

                        @if($parameter->helper)
                        <span class="text-light-blue">{{ $parameter->helper }}</span>
                        @endif
                    </div>
                </div>
                @endif

                @if($parameter->type == "select")
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="{{ $parameter->name }}">{{ $parameter->description }}</label>
                        @php
                            $items = explode(",", $parameter->dataenum)
                        @endphp

                        @for($i=0;$i<count($items);$i++)
                        <div class="select">
                            <select class="form-control" name="{{ $parameter->name }}" id="{{ $parameter->name }}">
                                <option value="">Escolha uma das opções...</option>
                                @for($i=0;$i<count($items);$i++)
                                <option value="{{ $items[$i] }}" @if($parameter->content == $items[$i]) selected @endif>{{ $items[$i] }}</option>
                                @endfor
                            </select>
                        </div>
                        @endfor

                        @if($parameter->helper)
                        <span class="text-light-blue">{{ $parameter->helper }}</span>
                        @endif
                    </div>
                </div>
                @endif

            @endforeach
        </div> <!-- panel-body -->

        <div class="panel-footer">
            <a href="{{ route('admin.parameters.index') }}" class="btn btn-default"><i class="fas fa-fx fa-reply"></i> Voltar</a>
            <button type="submit" class="btn btn-success"><i class="fas fa-fx fa-save"></i> Salvar</button>
        </div>
    </div>
</form>
@stop

@section('css')
@stop

@section('js')

@foreach($parameters as $parameter)
    @if($parameter->type == "wysiwyg")
    <script>
    $(function() {
        $('#{{ $parameter->name }}').summernote({
            lang: 'pt-BR'
        });
    });
    </script>
    @endif
@endforeach
@stop
