@extends('layouts.master', ['body_class' => 'groups crear']) 
@section('content')
<div class=" row " style="margin-top:40px ">
    <div class="col-md-12 ">
        <div class="card ">
            <div class="card-header text-center ">
                Crear Grup
            </div>
            <div class="card-body " style="padding:30px ">
                <form action="{{ action('GroupsController@store') }}" method="post">
                    {{ csrf_field() }}
                    <div class="row ">
                        <div class="col-12 ">
                            <div class="form-group">
                                <label for="name ">Nom Grup</label>
                                <input type="text" name="name" id="name" class="form-control ">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="desc">Descripció:</label>
                                <textarea name="desc" id="desc" class="form-control" rows="3"></textarea>
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
</div>


@stop