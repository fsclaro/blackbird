<div class="col-md-12">
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
