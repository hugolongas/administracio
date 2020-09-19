@extends('layouts.master', ['body_class' => 'activitats create'])

@push('scripts')
@endpush
@section('css')
@stop

@section('content')
<div class="options-menu">
    <a href="{{ route('activitats')}}" class="btn btn-outline-dark"><i class="fas fa-angle-left"></i>tornar</a>
</div>
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class=" row " style="margin-top:40px ">
    <div class="col-md-12 ">
        <h2>Crear Activitat</h2>
        <div style="padding:30px ">
            <form action="{{route('activitats.store') }}" method="post">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-12 dades-activitat">
                        <div class="form-row">
                            <select id="created_by" name="created_by">
                                @if ($user->isAdmin())
                                    @foreach($sections as $section)                                        
                                        @if($section->section_name!='Soci')
                                            <option value="{{$section->section_name}}">{{$section->section_name}}</option>
                                        @endif
                                    @endforeach
                                    @else
                                    @foreach(Auth::user()->sections as $section)
                                        @if($section->section_name!='Soci')
                                            <option value="{{$section->section_name}}">{{$section->section_name}}</option>
                                        @endif
                                    @endforeach                                
                                @endif
                                <option value="{{$user->name}}" selected>{{$user->name}}</option>
                              </select>
                        </div>              
                        <div class="form-row">
                            <div class="form-group col-6">
                                <label for="name">Nom*:</label>
                                <input type="text" name="name" id="name" class="form-control" tabindex="1"
                                value="{{ old('name') }}" />
                                @if($errors->has('name'))
                                <span class="error-message">Has d'indicar un nóm</span>
                                @endif
                            </div>
                            <div class="form-group col-6">
                                <label for="activityDate">Data de l'activitat*:</label>
                                <input type="date" name="activityDate" id="activityDate" class="form-control"
                                    tabindex="5" value="{{ old('activityDate') }}" />
                                @if($errors->has('activityDate'))
                                <span class="error-message">Has d'indicar una data</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 dades-description">
                        <h4>Descripció</h4>
                        <textarea id="description" name="description">{{old("description")}}</textarea>
                    </div>
                </div>
                <div class="form-group text-center ">
                    <button type="submit " class="btn btn-outline-primary " style="padding:8px 100px;margin-top:25px; ">
                        Crear
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop
@push('scripts')
<script src="//cdn.ckeditor.com/4.14.0/basic/ckeditor.js"></script>
@endpush
@section('js')
<script>
    CKEDITOR.replace('description');
</script>
@stop