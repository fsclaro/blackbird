
<div class="col-md-{{ $columns }}">
    <div class="card card-outline card-primary">
        <div class="card-body">
            {!! $usersChart30Days->container() !!}
        </div>
    </div>
</div>

@section('js')
    @if($usersChart30Days)
        {!! $usersChart30Days->script() !!}
    @endif
@stop
