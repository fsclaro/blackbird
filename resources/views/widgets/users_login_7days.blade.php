<div class="col-md-12">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            Logins nos Últimos 7 Dias
        </div>
        <div class="card-body">
            {!! $usersChart->container() !!}
        </div>
    </div>
</div>

@section('js')
    @if($usersChart)
        {!! $usersChart->script() !!}
    @endif
@stop
