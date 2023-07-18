@extends('layouts.master', ['body_class' => 'documents crear'])
@section('content')
<div class="options-menu">
    <a href="{{ route('documentsAdmin')}}" class="btn btn-outline-dark"><i class="fas fa-angle-left"></i>tornar</a>
</div>
<div class=" row " style="margin-top:40px ">
    <div class="col-md-12 ">
        <h2>Crear Document</h2>
        <div style="padding:30px ">
            <form action="{{ action('DocumentsController@store') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row ">
                    <div class="col-5">
                        <div class="form-group">
                            <label for="name">Nom:</label>
                            <input type="text" name="name" id="name" class="form-control " tabindex="1"
                                value="{{ old('name') }}" />
                                @if($errors->has('name'))
                                    <span class="error-message">Has d'indicar un nóm</span>
                                @endif
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group">
                            <label for="group">Secció:</label>
                            <select id="group" name="group" class="form-control" tabindex="2">
                                @foreach ($groups as $group)
                                <option value="{{$group->id}}" @if (old('group')==$group->id) {{ 'selected' }} @endif>
                                    {{$group->name}}
                                </option>
                                @endforeach
                            </select>
                            @if($errors->has('group'))
                                    <span class="error-message">Has de seleccionar algun grup</span>
                                @endif
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <label for="file">Document:</label>
                            <input type="file" name="file" id="file" class="form-control" tabindex="3">
                            @if($errors->has('file'))
                            <span class="error-message">{{$errors}}</span>
                        @endif
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="summary">Resum:</label>
                            <textarea name="summary" id="summary" class="form-control" rows="3" tabindex="4">
                                {{ old('summary') }}
                            </textarea>
                        </div>
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
    CKEDITOR.replace('summary');
</script>
@stop