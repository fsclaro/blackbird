<!-- left side -->
@if(\Session::get('footer_left'))
    {{ \Session::get('footer_left') }}
@else
<span>
    Copyright © 2019 by <a href="https://github.com/fsclaro/blackbird">
    <span class="text-bold">Blackbird</span></a>.
</span> Todos os direitos reservados.
@endif

<!-- right side -->
@if(\Session::get('footer_right'))
    {{ \Session::get('footer_right') }}
@else
<div class="float-right hidden-xs">
    <b>Versão: </b> 1.0.0
</div>
@endif
