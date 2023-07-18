@extends('layouts.master', ['body_class' => 'documents'])
@section('css')
@stop
@section('js')
@stop
@section('content')
<div class="row">
    @foreach ($documents as $d)
    <div class="col-xs-6 col-md-4 col-lg-3 document-item">
    <a href="{{ route('documents.download', ['document' => $d])}}">
        <div class="row">
            <div class="col-4">
                <img src="{{asset('img')}}/{{$d->type}}.png" class="img-fluid">
            </div>
            <div class="col-6 title">
                {{$d->title}}
            </div>
            <div class="col-12 description">
                @if (strlen($d->summary)>100)
                {!! substr($d->summary, 0, 100)!!}...    
                @else
                {!! $d->summary!!}    
                @endif
            </div>
        </div>
        </a>
    </div>
    @endforeach
</div>
@stop
@push('scripts')
@endpush