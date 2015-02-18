@if(!Auth::guest() && ( Auth::user()->hasRole("Administrador") || Auth::user()->hasRole("Super usuario")))

    <li class="dropdown @if(Request::is('Ejecucion/*')) active @endif">

        <a data-toggle="dropdown" class="dropdown-toggle" href="#">Ejecución Fiscal <b class="caret"></b></a>
        <ul role="menu" class="dropdown-menu">

            <li class="@if(Request::is('Ejecucion/ejecucion')) active @endif">
                <a href="{{URL::to('ejecuciones')}}">
                <i class="glyphicon glyphicon-th-list"></i>&nbsp;
                    Iniciar ejecución
                </a>
            </li>
            
            
            <li class="@if(Request::is('Ejecucion/')) active @endif">
                <a href="{{URL::to('ejecuciones')}}">
                <i class="glyphicon glyphicon-lock"></i>&nbsp;
                    Ejecución en trámite
                </a>
            </li>
            
			<li class="divider"></li>

            <li class="@if(Request::is('Ejecucion/buscar')) active @endif">
                <a href="{{URL::to('Ejecucion/buscar')}}">
                <i class="glyphicon glyphicon-user"></i>&nbsp;
                    Personal Ejecución
                </a>
            </li>
            
            
			
            <li class="@if(Request::is('Ejecucion/buscar')) active @endif">
                <a href="{{URL::to('Ejecucion/buscar')}}">
                <i class="glyphicon glyphicon-tags"></i>&nbsp;
                    Gasto Ejecución Municipal
                </a>
            </li>

            <li class="divider"></li>

                <li class="@if(Request::is('catalago')) active @endif">
                <a href="{{URL::to('catalogos/salario')}}">
                <i class="glyphicon glyphicon-list-alt"></i>&nbsp;
                    Salario Mínimo
                </a>
            </li>

            <li class="@if(Request::is('catalago')) active @endif">
                <a href="{{URL::to('catalogos/inpc')}}">
                <i class="glyphicon glyphicon-list-alt"></i>&nbsp;   
                    Índice de Precios
                </a>
            </li>

            <li class="@if(Request::is('catalago')) active @endif">
                <a href="{{URL::to('catalogos/status')}}">
                <i class="glyphicon glyphicon-list-alt"></i>&nbsp;
                    Catalogo Status
                </a>
            </li>

             
        </ul>
    </li>

@endif