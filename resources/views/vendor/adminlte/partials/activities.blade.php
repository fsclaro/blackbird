<li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false" alt="Notificações" title="Notificações">
        <i class="far fa-bell"></i>
        <span class="badge badge-danger navbar-badge">{{ Auth::user()->activities()->where('is_read', 0)->count() }}</span>
    </a>

    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        @if(Auth::user()->activities()->where('is_read', 0)->count() == 1)
        <span class="dropdown-item dropdown-header">Você tem <span class="text-red text-bold">1</span> atividade não lida</span>
        @else
        <span class="dropdown-item dropdown-header">Você tem <span class="text-red text-bold">{{ Auth::user()->activities()->where('is_read', 0)->count() }}</span> atividades não lidas</span>
        @endif

        @php
            $activities = Auth::user()
                ->activities()
                ->where('is_read', 0)
                ->orderBy('id', 'desc')
                ->take(5)
                ->get();
        @endphp

        @foreach($activities as $activity)
        <div class="dropdown-divider"></div>
        <a href="{{ route('admin.activities.show', $activity->id) }}" class="dropdown-item">
            {!! Str::limit(strip_tags($activity->title),30) !!}
        </a>
        @endforeach

        <div class="dropdown-divider"></div>
        <a href="{{ route('admin.activities.user') }}" class="dropdown-item dropdown-footer bg-red">Ver Todas as Atividades</a>
    </div>
</li>
