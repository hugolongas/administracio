@extends('layouts.master', ['body_class' => 'groups edit'])

@push('scripts')
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js "></script>
<script type="text/javascript" src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>
@endpush
@section('css')
<link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.3.0/css/select.dataTables.min.css " />
@stop

@section('content')
<div class=" row " style="margin-top:40px ">
    <div class="col-md-12 ">
        <h2>
            Editar Grup
        </h2>
        <div style="padding:30px">
            <form action="{{route('groups.update',['id'=>$group->id]) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="row ">
                    <div class="col-12 ">
                        <div class="form-group">
                            <label for="name ">Nom Grup</label>
                            {{$group->name}}
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="desc">Descripció:</label>
                            <textarea name="desc" id="desc" class="form-control"
                                rows="3">{{$group->description}}</textarea>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-dark" data-toggle="modal" data-target="#socisModal"
                        data-groupId="{{$group->id}}">Afegir Soci/Usuari</button>
                    <div class="col-12">
                        @foreach($group->users as $user)   
                        @if($user->username!='administracio')                       
                        <div class="badge badge-secondary">                            
                            {{$user->name}}                            
                            <i class="far fa-times-circle delete-user" data-id="{{$user->id}}"></i>
                        </div>     
                        @endif                   
                        @endforeach
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

<div class="modal fade" id="socisModal" tabindex="-1" role="dialog" aria-labelledby="socisModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="socisModalTitle">Socis</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered" id="socis-table" style="width:100%">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Nom Complert</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Tancar</button>
                <button type="button" id="addSoci" class="btn btn-outline-primary">Afegir Socis</button>
            </div>
        </div>
    </div>
</div>
<meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('js')
<script type="text/javascript">
    $(document).ready(function(){       
        tableSocis = null; 
        $('#socisModal').on('show.bs.modal', function (event) {
            if(tableSocis!=null)
            {
                tableSocis.destroy();
            }
            tableSocis = $('#socis-table').DataTable({
                processing: true,
                serverSide: false,
                select: 'multi+shift',
                selector: 'td:first-child',
                order: [[ 1, 'asc' ]],
                ajax: '{{route('groups.notInGroup',$group->id)}}',
                scrollX: true,
                columns: [
                    { data: 'id'},
                    { data: 'name'}
                ],
                columnDefs: [
                    {
                        targets: [0],
                        visible: false,
                        searchable: false,
                    }
                ]
            });
        });
        $("#addSoci").click(function(){
            var idUsers = tableSocis.rows( { selected: true } ).data().pluck('id').toArray();
            var requestData = JSON.stringify(idUsers);
            console.log(requestData);
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });
            var url = '{{route('groups.attachUser',$group->id)}}';
            var param = {'idUsers':requestData};
            $.ajax({
                data: param,
                url: url,
                type: 'POST',
                success: function (data) {
                    if (data=="done")
                    location.reload();
                }
            });
        });
        $(".delete-user").click(function(){
            userId = $(this).attr("data-id");
            id = {{$group->id}};
            if(confirm("Estas segur que vols eliminar aquest soci/usuari del grup?"))
            {
                $.ajaxSetup({
                    headers:{ 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                });
                var url = '{{route('groups.detachUser')}}';
                var param = {'id':id,'userId':userId};
                $.ajax({
                    data: param,
                    url: url,
                    type: 'POST',
                    success: function () {
                        location.reload();
                    }
                });
            }
        });
    });
</script>
@stop