@extends('layouts.master', ['body_class' => 'sections edit'])

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
            <form action="{{route('sections.update',['id'=>$section->id]) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="row ">
                    <div class="col-12 ">
                        <div class="form-group">
                            <label for="section_name ">Nom Grup</label>
                            {{$section->section_name}}
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="section_desc">Descripció:</label>
                            <textarea name="section_desc" id="section_desc" class="form-control"
                                rows="3">{{$section->description}}</textarea>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-dark" data-toggle="modal" data-target="#socisModal"
                        data-sectionId="{{$section->id}}">Afegir Soci/Usuari</button>
                    <div class="col-12">
                        @foreach($section->users as $user)                          
                        <div class="badge badge-secondary">                            
                            {{$user->name}}                            
                            <i class="far fa-times-circle delete-user" data-id="{{$user->id}}"></i>
                        </div>                        
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
                ajax: '{{route('sections.notInSection',$section->id)}}',
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
            var idSocis = tableSocis.rows( { selected: true } ).data().pluck('id').toArray();
            var requestData = JSON.stringify(idSocis);
            console.log(requestData);
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });
            var url = '{{route('sections.attachSocis',$section->id)}}';
            var param = {'idSocis':requestData};
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
            id = {{$section->id}};
            if(confirm("Estas segur que vols eliminar aquest soci de la secció?"))
            {
                $.ajaxSetup({
                    headers:{ 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                });
                var url = '{{route('sections.detachSoci')}}';
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