<li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false" alt="Notificações" title="Notificações">
        <i class="far fa-bell"></i>
        <span class="badge badge-danger navbar-badge">{{ Auth::user()->notifications()->where('is_read', 0)->count() }}</span>
    </a>

    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        @if(Auth::user()->notifications()->where('is_read', 0)->count() == 1)
        <span class="dropdown-item dropdown-header">1 Notificação Não Lida</span>
        @else
        <span class="dropdown-item dropdown-header">{{ Auth::user()->notifications()->where('is_read', 0)->count() }} Notificações Não Lidas</span>
        @endif

        @php
            $notifications = Auth::user()->notifications()->where('is_read', 0)->take(5)->get();
        @endphp

        @foreach($notifications as $notification)
        <div class="dropdown-divider"></div>
        <a href="{{ route('admin.notifications.show', $notification->id) }}" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> {{ \Str::limit($notification->title,32) }}
        </a>
        @endforeach

        <div class="dropdown-divider"></div>
        <a href="{{ route('admin.notifications.index') }}" class="dropdown-item dropdown-footer bg-red">Ver Todas as Notificações</a>
    </div>
</li>
