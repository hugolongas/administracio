<ul class="nav flex-column sidebar-menu">
    <li class="nav-item {{ Request::is('home') && ! Request::is('home')? 'active' : ''}}">
        <a class="nav-link" href="{{url('')}}">
            <i class="fas fa-list-alt"></i>
            General
        </a>
    </li>
    @if(Auth::user()->checkRoles(array("colaborador", "junta")))
    <li class="nav-item {{ Request::is('activitats') && ! Request::is('activitats')? 'active' : ''}}">
        <a class="nav-link" href="{{url('activitats')}}">
            <i class="fas fa-file-invoice"></i>
            Activitats
        </a>
    </li>
    @endif
    @if(Auth::user()->checkRoles(array("junta")))
    <li class="nav-item {{ Request::is('gestio.activitats') && ! Request::is('gestio.activitats')? 'active' : ''}}">
        <a class="nav-link" href="{{url('gestio.activitats')}}">
            <i class="fas fa-file-invoice"></i>
            Gestionar Activitats
        </a>
    </li>
    @endif
    @if(Auth::user()->checkRoles("junta"))
    <li class="nav-item {{ Request::is('seccions') && ! Request::is('seccions')? 'active' : ''}}">
        <a class="nav-link" href="{{url('seccions')}}">
            <i class="fas fa-list-alt"></i>
            Seccions
        </a>
    </li>
    @endif
    @if(Auth::user()->checkRoles("junta","promotor"))
    <li class="nav-item {{ Request::is('promotors') && ! Request::is('promotors')? 'active' : ''}}">
        <a class="nav-link" href="{{url('promotors')}}">
            <i class="fas fa-list-alt"></i>
            Promotors
        </a>
    </li>
    @endif
    @if(Auth::user()->checkRoles("junta"))
    <li class="nav-item {{ Request::is('socis') && ! Request::is('socis')? 'active' : ''}}">
        <a class="nav-link" href="{{url('socis')}}">
            <i class="fas fa-list-alt"></i>
            Socis
        </a>
    </li>
    @endif
    @if(Auth::user()->checkRoles("junta"))
    <li class="nav-item {{ Request::is('informes') && ! Request::is('informes')? 'active' : ''}}">
        <a class="nav-link" href="{{url('informes')}}">
            <i class="fas fa-list-alt"></i>
            Informes
        </a>
    </li>
    @endif
</ul>