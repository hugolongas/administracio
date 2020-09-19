@extends('layouts.master', ['body_class' => 'documents crear'])
@section('content')
<div class=" row " style="margin-top:40px ">
    <div class="col-md-12 ">
        <div class="card ">
            <div class="card-header text-center ">
                Editar Secció
            </div>
            <div class="card-body " style="padding:30px ">
                <form action="{{ route('documentsAdmin.update',$document) }}" method="post" enctype="multipart/form-data">                    
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <div class="row ">
                        <div class="col-5">
                            <div class="form-group">
                                <label for="name">Nom:</label>
                                <input type="text" name="name" id="name" class="form-control " tabindex="1"
                                    value="{{ old('name', $document->title) }}" />
                                    @if($errors->has('name'))
                                        <span class="error-message">Has d'indicar un nóm</span>
                                    @endif
                            </div>
                        </div>
    
                        <div class="col-4">
                            <div class="form-group">
                                <label for="section">Secció:</label>
                                <select id="section" name="section" class="form-control" tabindex="2">
                                    @foreach ($sections as $s)
                                    <option value="{{$s->id}}" @if (old('section', $s->id)==$s->id) {{ 'selected' }} @endif>
                                        {{$s->section_name}}
                                    </option>
                                    @endforeach
                                </select>
                                @if($errors->has('section'))
                                        <span class="error-message">Has de seleccionar alguan secció</span>
                                    @endif
                            </div>
                        </div>
    
                        <div class="col-3">
                            <div class="form-group">
                                <label for="file">Document:<a href="{{asset('storage/documents/'.$document->file_name)}}" style="color:black">Veure</a></label>
                                <input type="hidden" value="{{$document->file_name}}" name="old_fileName" />                                
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
                                    {{ old('summary', $document->summary) }}
                                </textarea>
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