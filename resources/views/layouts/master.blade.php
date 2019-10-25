<!doctype html>
<html lang="es">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
    integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
  <link href="{{ asset('/css/main.min.css') }}" rel="stylesheet">
  @yield('css')
  <title>{{ config('app.name', 'Laravel') }}</title>
</head>

<body>
  @if( Auth::check())
  @include('partials.navbar')
  @endif
  <div id="main">
    <input type="hidden" id="num_soci" value="@if(Auth::user()->soci!=null) {{Auth::user()->soci->member_number}} @else 0 @endif" />
    <div class="aside">
      @include('partials.aside')
    </div>
    <div id="content" class="content {{$body_class or '' }}">
      @notification()
      @yield('content')
    </div>
  </div>
  @if(Auth::user()->soci!=null)
  <div class="modal fade" id="modal-carnet" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog carnet-content" role="document">      
      <div class="row">
        <div class="col-8 carnet-info">
          <div class="name-soci">{{Auth::user()->name}}</div>
          <div class="num-soci">SOCI: {{Auth::user()->soci->member_number}}</div>
          <div id="carnet" class="carnet"></div>
        </div>
        <div class="col-4 carnet-img">
          <img class="img-fluid" src="@if(Auth::user()->soci!=null)
          {{Storage::url('socis/'.Auth::user()->soci->soci_img)}}
          @else
          {{Storage::url('socis/default.png')}}
          @endif" />
        </div>
      </div>
    </div>
  </div>
  @endif

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
  </script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
  </script>
  <script src="{{asset('/js/jquery-barcode.min.js')}}"></script>
  <script src="{{asset('/js/main.js')}}"></script>
  @stack('scripts')
  @yield('js')
</body>

</html>