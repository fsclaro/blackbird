<div class="col-lg-4">
    <div class="card card-primary card-outline">
        <div class="card-body box-profile">
            <div class="text-center">
                @if(Auth::user()->getAvatar(Auth::user()->id))
                    <img src="{{ Auth::user()->getAvatar(Auth::user()->id) }}" class="profile-user-img img-fluid img-circle" alt="User Image">
                @else
                    @if (Gravatar::exists(Auth::user()->email))
                        <img src="{{ Gravatar::get(Auth::user()->email) }}" class="profile-user-img img-fluid img-circle" alt="User Image">
                    @else
                        <img src="{{ asset('img/avatares/no-photo.png') }}" class="profile-user-img img-fluid img-circle" alt="User Image">
                    @endif
                @endif
            </div>

            <h3 class="profile-username text-center">{{ Auth::user()->getMyName() }}</h3>
            <br />

            <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                    <b>Email</b>
                    <span class="float-right">{{ Auth::user()->getMyEmail() }}</span>
                </li>

                <li class="list-group-item">
                    @if(Auth::user()->numRoles() <= 0)
                        <b>Papéis</b>
                        <span class="float-right text-red">Sem papel</span>
                    @else
                        <b>Papel</b>
                        <span class="float-right">
                            <span class="badge badge-primary">{{ Auth::user()->getMyRoleName() }}</span>
                        </span>
                    @endif
                </li>

                <li class="list-group-item">
                    <b>Cadastrado em</b>
                    @if(Auth::user()->created_at)
                        <span class="float-right">{{ Auth::user()->created_at->format("d/m/Y") }}</span>
                    @else
                        <span class="float-right text-red">Não informado</span>
                    @endif
                </li>

                <li class="list-group-item">
                    <b>Última atualização</b>
                    @if(Auth::user()->updated_at)
                        <span class="float-right">{{ Auth::user()->updated_at->format("d/m/Y") }}</span>
                    @else
                        <span class="float-right text-red">Não informado</span>
                    @endif
                </li>
            </ul>
        </div>
    </div>
</div>
