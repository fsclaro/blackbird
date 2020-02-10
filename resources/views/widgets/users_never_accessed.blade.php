<div class="col-md-5">
    <div class="card card-danger card-outline">
        <div class="card-header">
            <h3 class="card-title">Nunca acessaram o sistema</h3>

            <div class="card-tools">
                @if(count($users) > 0)
                <span class="badge badge-danger">
                    {{ count($users) }}
                    @if(count($users) == 1)
                        usuário
                    @else
                        usuários
                    @endif
                </span>
                @endif
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <!-- /.card-header -->

        <div class="card-body p-0" style="display: block;">
            <ul class="users-list clearfix">
                @if(count($users) > 0)
                    @foreach($users as $user)
                    <li>
                        @if($user->getAvatar($user->id))
                            <img src="{{ $user->getAvatar($user->id) }}" class="img-size-64 img-thumbnail" alt="User Image">
                        @else
                            @if (Gravatar::exists($user->email))
                                <img src="{{ Gravatar::get($user->email) }}" class="img-size-64 img-thumbnail" alt="User Image">
                            @else
                                <img src="{{ asset('img/avatares/Others/no-photo.png') }}" class="img-size-64 img-thumbnail" alt="User Image">
                            @endif
                        @endif

                        <a class="users-list-name" href="#">{{ $user->name }}</a>
                        <small class="text-olive text-bold">{{ $user->roles[0]->title }}</small>
                    </li>
                    @endforeach
                @else
                    <div class="jumbotron jumbotron-fluid">
                        <h3 class="text-center text-blue">Todos os usuários <br>já acessaram o sistema!</h3>
                    </div>
                @endif
            </ul>
            <!-- /.users-list -->
        </div>
        <!-- /.card-body -->

        <div class="card-footer text-center" style="display: block;">
            @if(count($users) > 0)
                <a href="{{ route('admin.users.neveraccess')}}">Ver lista completa</a>
            @endif
        </div>
        <!-- /.card-footer -->
    </div>
    <!--/.card -->
</div>
