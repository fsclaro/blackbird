<!-- left side -->
@if(Session::has('footer_left'))
    {!! Session::get('footer_left') !!}
@else
<span>
    Copyright © 2019 by <a href="https://github.com/fsclaro/blackbird"><span class="text-bold">Blackbird</span></a>. Todos os direitos reservados.
</span>
@endif

<!-- right side -->
<div class="float-right hidden-xs">
@if(Session::has('footer_right'))
    {!! Session::get('footer_right') !!}
@else
    Versão: <span class="text-bold text-blue">1.0.0</span>
@endif
</div>
