<ul class="nav flex-column sidebar-menu">
    <li class="nav-item {{ request()->is('/')? 'active' : ''}}">
        <a class="nav-link" href="{{url('')}}">
            <i class="fa fa-home" aria-hidden="true"></i>
            <div class="aside-item">General</div>
        </a>
    </li>
    @if(Auth::user()->checkRoles(array("soci","colaborador","admin")))
    <li class="nav-item {{ request()->is('activitats')? 'active' : ''}}">        
        <a class="nav-link" href="{{url('activitats')}}">
            <i class="fa fa-calendar" aria-hidden="true"></i>
            <div class="aside-item">Activitats</div>
        </a>
    </li>
    @endif
    @if(Auth::user()->checkRoles(array("admin","colaborador","entrada")))
    <li class="nav-item {{ Request::is('activitats/control_entrades')? 'active' : ''}}">
        <a class="nav-link" href="{{url('activitats/control_entrades')}}">
            <i class="fa fa-calendar-check-o" aria-hidden="true"></i>
            <div class="aside-item">Gestionar Activitats</div>
        </a>
    </li>
    @endif
    @if(Auth::user()->checkRoles(array("admin")))
    <li class="nav-item {{ Request::is('concursos')? 'active' : ''}}">        
        <a class="nav-link" href="{{url('concursos')}}">
            <i class="fa fa-list-alt" aria-hidden="true"></i>
            <div class="aside-item">Concursos</div>
        </a>
    </li>
    @endif
    @if(Auth::user()->checkRoles(array("soci","admin")))
    <li class="nav-item {{ Request::is('votacions')? 'active' : ''}}">        
        <a class="nav-link" href="{{url('votacions')}}">
            <i class="fa fa-check-square-o" aria-hidden="true"></i>
            <div class="aside-item">Votacions</div>
        </a>
    </li>
    @endif
    @if(Auth::user()->checkRoles("admin"))
    <li class="nav-item {{ Request::is('seccions')? 'active' : ''}}">
        <a class="nav-link" href="{{url('seccions')}}">
            <i class="fa fa-list-alt" aria-hidden="true"></i>
            <div class="aside-item">Seccions</div>
        </a>
    </li>
    @endif
    @if(Auth::user()->checkRoles("admin","promotor"))
    <li class="nav-item {{ Request::is('promotors')? 'active' : ''}}">
        <a class="nav-link" href="{{url('promotors')}}">
            <i class="fa fa-list-alt" aria-hidden="true"></i>
            <div class="aside-item">Promotors</div>
        </a>
    </li>
    @endif
    @if(Auth::user()->checkRoles("admin"))
    <li class="nav-item {{ Request::is('socis')? 'active' : ''}}">
        <a class="nav-link" href="{{url('socis')}}">
            <i class="fa fa-id-card" aria-hidden="true"></i>
            <div class="aside-item">Socis</div>
        </a>
    </li>
    @endif
    @if(Auth::user()->checkRoles("admin"))
    <li class="nav-item {{ Request::is('informes')? 'active' : ''}}">
        <a class="nav-link" href="{{url('informes')}}">
            <i class="fa fa-file-text-o" aria-hidden="true"></i>
            <div class="aside-item">Informes</div>
        </a>
    </li>
    @endif
</ul>