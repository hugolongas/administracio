<ul class="nav flex-column sidebar-menu">
    <li class="nav-item {{ request()->is('/')? 'active' : ''}}">
        <a class="nav-link" href="{{url('')}}">
            <i class="fas fa-home" aria-hidden="true"></i>
            <div class="aside-item">General</div>
        </a>
    </li>
    @if(Auth::user()->checkRoles(array("sccio")))
    <li class="nav-item {{ request()->is('activitats')? 'active' : ''}}">        
        <a class="nav-link" href="{{url('activitats')}}">
            <i class="fas fa-calendar" aria-hidden="true"></i>
            <div class="aside-item">Activitats</div>
        </a>
    </li>
    @endif
    @if(Auth::user()->checkRoles(array("entrada")))
    <li class="nav-item {{ Request::is('activitats/control_entrades')? 'active' : ''}}">
        <a class="nav-link" href="{{url('activitats/control_entrades')}}">
            <i class="fas fa-calendar-check" aria-hidden="true"></i>
            <div class="aside-item">Gestionar Activitats</div>
        </a>
    </li>
    @endif
    @if(Auth::user()->isAdmin())
    <li class="nav-item {{ Request::is('concursos')? 'active' : ''}}">        
        <a class="nav-link" href="{{url('concursos')}}">
            <i class="fas fa-list-alt" aria-hidden="true"></i>
            <div class="aside-item">Concursos</div>
        </a>
    </li>
    @endif
    @if(Auth::user()->isAdmin())
    <li class="nav-item {{ Request::is('gestio-documents')? 'active' : ''}}">
        <a class="nav-link" href="{{url('gestio-documents')}}">
            <i class="fas fa-file-upload"  aria-hidden="true"></i>
            <div class="aside-item">Gestionar documents</div>
        </a>
    </li>
    @endif
    @if(Auth::user()->checkRoles(array("soci")))
    <li class="nav-item {{ Request::is('documents')? 'active' : ''}}">        
        <a class="nav-link" href="{{url('documents')}}">            
            <i class="fas fa-file-download" aria-hidden="true"></i>
            <div class="aside-item">Documents</div>
        </a>
    </li>
    @endif
    @if(Auth::user()->checkRoles(array("soci")))
    <li class="nav-item {{ Request::is('votacions')? 'active' : ''}}">        
        <a class="nav-link" href="{{url('votacions')}}">
            <i class="fas fa-check-square" aria-hidden="true"></i>
            <div class="aside-item">Votacions</div>
        </a>
    </li>
    @endif
    @if(Auth::user()->isAdmin())
    <li class="nav-item {{ Request::is('seccions')? 'active' : ''}}">
        <a class="nav-link" href="{{url('seccions')}}">
            <i class="fas fa-list-alt" aria-hidden="true"></i>
            <div class="aside-item">Seccions</div>
        </a>
    </li>
    @endif
    @if(Auth::user()->checkRoles("promotor"))
    <li class="nav-item {{ Request::is('promotors')? 'active' : ''}}">
        <a class="nav-link" href="{{url('promotors')}}">
            <i class="fas fa-list-alt" aria-hidden="true"></i>
            <div class="aside-item">Promotors</div>
        </a>
    </li>
    @endif
    @if(Auth::user()->isAdmin())
    <li class="nav-item {{ Request::is('users')? 'active' : ''}}">
        <a class="nav-link" href="{{url('users')}}">
            <i class="fas fa-users" aria-hidden="true"></i>
            <div class="aside-item">Usuaris</div>
        </a>
    </li>
    @endif
    @if(Auth::user()->isAdmin())
    <li class="nav-item {{ Request::is('socis')? 'active' : ''}}">
        <a class="nav-link" href="{{url('socis')}}">
            <i class="fas fa-id-card" aria-hidden="true"></i>
            <div class="aside-item">Socis</div>
        </a>
    </li>
    @endif
    @if(Auth::user()->isAdmin())
    <li class="nav-item {{ Request::is('informes')? 'active' : ''}}">
        <a class="nav-link" href="{{url('informes')}}">
            <i class="fas fa-info" aria-hidden="true"></i>
            <div class="aside-item">Informes</div>
        </a>
    </li>
    @endif    
</ul>