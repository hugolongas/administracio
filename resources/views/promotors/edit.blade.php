@extends('layouts.master', ['body_class' => 'promotor edit'])
@section('content')
<div class="options-menu">
    <a href="{{ url()->previous() }}" class="btn btn-outline-dark"><i class="fas fa-angle-left"></i>tornar</a>
</div>
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class=" row " style="margin-top:40px ">
    <div class="col-md-12 ">
        <h2>
            Editar Promotor
        </h2>
        <div style="padding:30px ">
            <form action="{{route('promotors.update',['id'=>$promotor->id]) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="row ">
                    <div class="col-12 ">                        
                            <h3>
                                {{$promotor->promotor_name}}
                            </h3>                        
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="promotor_desc">Descripció:</label>
                            <textarea name="promotor_desc" id="promotor_desc" class="form-control"
                                rows="3">{{$promotor->description}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group text-center ">
                    <button type="submit " class="btn btn-outline-primary " style="padding:8px 100px;margin-top:25px; ">
                        Editar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop