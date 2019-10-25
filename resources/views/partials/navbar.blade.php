<nav id="navbar-top" class="navbar navbar-expand-lg navbar-light bg-light fixed-top nav-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">
            <img class="brand-logo img-fluid logo-ateneu" src="{{ asset('img/logo.png') }}" alt="Logo" />
        </a>
        <ul class="soci-options navbar-nav navbar-right">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownPerfil" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="soci-img img-fluid rounded-circle" src="@if(Auth::user()->soci!=null)
                    {{Storage::url('socis/'.Auth::user()->soci->soci_img)}}
                    @else{{Storage::url('socis/default.png')}}
                        @endif" />
                        <div class="soci-name">{{Auth::user()->name}}</div>
                </a>
                <div class="dropdown-menu menu-drop" aria-labelledby="navbarDropdownPerfil">
                    @if(Auth::user()->soci!=null)
                        <a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal-carnet">Carnet</a>
                        <a class="dropdown-item" href="{{route('profile')}}">Perfil</a>
                    @endif
                    @if(Auth::user()->sections!=null)
                        @foreach(Auth::user()->sections as $section)
                            @if($section->id!=2)
                                <a class="dropdown-item" href="{{route('sections.edit',$section->id)}}">Editar
                                {{$section->section_name}}</a>
                            @endif
                        @endforeach
                    @endif
                    @if(Auth::user()->promotors!=null)
                        @foreach(Auth::user()->promotors as $promotor)
                            <a class="dropdown-item" href="{{route('promotors.edit',$promotor->id)}}">Editar
                            {{$promotor->promotor_name}}</a>
                        @endforeach
                    @endif
                    <hr />
                    <div class="dropdown-item">
                        <form action="{{ url('/logout') }}" method="POST" >
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-link nav-link">
                                Tancar sessió
                            </button>
                        </form>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</nav>