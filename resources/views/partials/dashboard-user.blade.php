<div class="col-md-3">
    <div class="card card-primary card-outline">
        <div class="card-body box-profile">
            <div class="text-center">
                @if(Auth::user()->getAvatar(Auth::user()->id))
                <img src="{{ Auth::user()->getAvatar(Auth::user()->id) }}" class="profile-user-img img-fluid img-circle" alt="User Image">
                @else
                @if (Gravatar::exists(Auth::user()->email))
                <img src="{{ Gravatar::get(Auth::user()->email) }}" class="profile-user-img img-fluid img-circle" alt="User Image">
                @else
                <img src="{{ asset('img/avatar/no-photo.png') }}" class="profile-user-img img-fluid img-circle" alt="User Image">
                @endif
                @endif
            </div>
            <h3 class="profile-username text-center">{{ auth()->user()->myName() }}</h3>
            <br />
            <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                    <b>Email</b>
                    <a class="float-right">{{ auth()->user()->myEmail() }}</a>
                </li>
                <li class="list-group-item">
                    @if(auth()->user()->numRoles() <= 0) <b>Papéis</b>
                        <a class="float-right text-red">Sem papéis atribuídos</a>
                        @endif

                        @if(auth()->user()->numRoles() == 1)
                        <b>Papel</b>
                        <a class="float-right"><span class="badge badge-primary">{{ auth()->user()->getFirstRoleName() }}</span>
                        </a>
                        @endif

                        @if(auth()->user()->numRoles() > 1)
                        <b>Papéis</b>
                        <a class="float-right">
                            @php $roles = auth()->user()->getRolesNames(); @endphp
                            @for($i=0;$i<count($roles);$i++) <span class="badge badge-primary">{{ $roles[$i] }}</span>
                                @endfor
                        </a>
                        @endif
                </li>
                <li class="list-group-item">
                    <b>Cadastrado em</b>
                    @if(auth()->user()->created_at)
                    <a class="float-right">{{ auth()->user()->created_at->format("d/m/Y") }}</a>
                    @else
                    <a class="float-right">Não informada</a>
                    @endif
                </li>
                <li class="list-group-item">
                    <b>Última atualização</b>
                    @if(auth()->user()->updated_at)
                    <a class="float-right">{{ auth()->user()->updated_at->format("d/m/Y") }}</a>
                    @else
                    <a class="float-right">Não informada</a>
                    @endif
                </li>
            </ul>

        </div>
    </div>
</div>
