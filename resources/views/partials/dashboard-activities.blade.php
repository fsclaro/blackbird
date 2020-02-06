@php
    if(Session::has('nro_atividades')) {
        $nro_registros = Session::get('nro_atividades');
    } else {
        $nro_registros = 5;
    }
    $activities = App\Activity::getUserActivities($nro_registros);
@endphp

<div class="col-lg-8">
    <div class="card card-warning card-outline">
        <div class="card-header p-2">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link active" href="#atividades" data-toggle="tab">Atividades
                        @if($activities->count() > 0)
                        <span class="badge badge-warning badge-pill ml-1">{{ $activities->count() }}</span>
                        @endif
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#mensagens" data-toggle="tab">Mensagens</a>
                </li>
            </ul>
        </div>

        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane active text-muted" id="atividades">
                    <div class="table-responsible">
                        <table class="table table-striped table-condensed datatable" id="table-atividades">
                            <tbody>
                                @foreach($activities as $activity)
                                <tr>
                                    <td>
                                        <small>
                                            <i class="fas fa-clock"></i>
                                            {{ $activity->created_at->format("d/m/Y - H:i:s") }}

                                            <span class="ml-5">
                                                <i class="fas fa-globe"></i>
                                                {{ $activity->ipaddress }} @if($activity->externalip) / {{ $activity->externalip }} @endif
                                            </span>

                                            <div class="float-right">
                                                <a href="{{ route('admin.activities.show', $activity->id) }}" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a>
                                            </div>
                                        </small>
                                        <br>
                                        <div class="float-left">
                                            <span>{!! $activity->title !!}</span>
                                        </div>
                                        <div class="float-right">
                                            @if($activity->is_read)
                                                <span class="badge badge-pill badge-danger">Lido</span>
                                            @else
                                                <span class="badge badge-pill badge-warning">Não Lido</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div>
                            <div class="float-right">
                                {{ $activities->links() }}
                            </div>
                        </div>
                    </div> <!-- table-responsive -->
                </div> <!-- tab-pane -->

                <div class="tab-pane" id="mensagens">
                    <div class="jumbotron">
                        <h2 class="display-9">Olá!! {{ Auth::user()->name }}</h2>
                        <p class="lead">Até o presente momento você não possui mensagens de outros usuários.</p>
                        <hr class="my-4">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
