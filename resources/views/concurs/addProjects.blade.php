@extends('layouts.master', ['body_class' => 'concurs create'])

@section('css')
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" />
@stop
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js"></script>
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js">
</script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
@endpush

@section('content')
<div class="options-menu">
    <a href="{{ route('concurs')}}" class="btn btn-outline-dark"><i class="fas fa-angle-left"></i>tornar</a>
</div>
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class=" row " style="margin-top:40px ">
    <div class="col-md-12 ">
        <h2>Afegir projectes</h2>
        <div style="padding:30px ">
            <div class="row">
                <div class="col-6">
                    <div>Nom Concurs:</div>
                    {{$concurs->name}}
                </div>
                <div class="col-6">
                    <div>Contrasenya</div>                    
                    <div class="input-group">
                        <input type="password" class="form-control pwd" value="{{$concurs->password}}" readonly />
                        <div class="input-group-append reveal">
                            <span class="input-group-text">
                                <i id="eye-icon" class="fas fa-eye-slash" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div clas="col-12">
                    <div>Descripció</div>
                    {!!$concurs->description!!}
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <div>Inici Concurs (votacions)</div>
                    {{$concurs->start_votations_date}}
                </div>
                <div class="col-3">
                    <div>Final Concurs (votacions)</div>
                    {{$concurs->end_votations_date}}
                </div>
                <div class="col-6">
                    <div class="row">
                        <div class="col-4">
                            <div>Punts Mesa</div>
                            {{$concurs->punts_mesa}}
                        </div>
                        <div class="col-4">
                            <div>Percentatge Mesa</div>
                            {{$concurs->mesa_percent}}
                        </div>
                        <div class="col-4">
                            <div>Percentatge Soci</div>
                            {{$concurs->soci_percent}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="concurs-projects">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#modalAddProject" style="margin-bottom: 20px;">
                Afegir Projecte
            </button>
            <table id="project-table" class="table table-striped table-bordered" style="width:100%;">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Editar</th>
                        <th>Projecte</th>
                        <th>Fitxer</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                    <tr>
                        <th>id</th>
                        <th>Editar</th>
                        <th>Projecte</th>
                        <th>Fitxer</th>
                        <th>Eliminar</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>



<!-- Modals -->
<div class="modal fade" id="modalAddProject" tabindex="-1" role="dialog" aria-labelledby="modalAddProjectLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddProjectLabel">Crear Projecte</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" id="addProject" class="form-horizontal" role="form" method="POST">
                {!! csrf_field() !!}
                <input type="hidden" name="idConcurs" id="idConcurs" class="form-control" value="{{$concurs->id}}" />
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label for="projectName">Nom projecte*:</label>
                            <input type="text" name="projectName" id="projectName" class="form-control" tabindex="1"
                                value="{{old('projectName')}}" />
                            <span id="projectNameError" class="error-message d-none">Has d'indicar un nom per el
                                projecte</span>
                        </div>
                        <div class="form-group col-6">
                            <label for="projectFile">Fitxer:</label>
                            <input type="file" class="form-control-file" name="projectFile" id="projectFile" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-2">
                            <button name="RegisterButton" type="submit" class="btn btn-outline-primary">
                                Guardar
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditProject" tabindex="-1" role="dialog" aria-labelledby="modalEditProjectLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditProjectLabel">Editar Projecte</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" id="editProject" class="form-horizontal" role="form" method="POST">
                {{ csrf_field() }}
                <div class="modal-body">
                    <input type="hidden" name="editProjectId" id="editProjectId" class="form-control" />
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label for="editProjectName">Nom projecte*:</label>
                            <input type="text" name="editProjectName" id="editProjectName" class="form-control"
                                tabindex="1" value="{{old('editProjectName')}}" />
                                <span id="editProjectNameError" class="error-message d-none">Has d'indicar un nom per el
                                    projecte</span>
                        </div>
                        <div class="form-group col-6">
                            <label for="editProjectFile">Fitxer:</label>
                            <input type="file" class="form-control-file" name="editProjectFile" id="editProjectFile" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            Fitxer: <a id="projectUrl" class="btn btn-outline-link" target="_blank">Veure Fitxer</a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-2">
                            <button name="RegisterButton" type="submit" class="btn btn-outline-primary">
                                Actualitzar
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop


@section('js')
<script>
    $(document).ready(function(){   

        $(".reveal").on('click',function() {
            var $pwd = $(".pwd");
            if ($pwd.attr('type') === 'password') {
                $pwd.attr('type', 'text');
                $("#eye-icon").removeClass("fa-eye-slash");
                $("#eye-icon").addClass("fa-eye");
            } else {
                $pwd.attr('type', 'password');
                $("#eye-icon").removeClass("fa-eye");
                $("#eye-icon").addClass("fa-eye-slash");
            }
        });

        
        datatable = $('#project-table').DataTable({
			processing: true,    
			serverSide: true,  
            ajax: '{{ route("project.projects", "$concurs->id") }}',
            scrollX:true,
			searching:true,
			ordering:true,
			columns: [
			{ data: 'id'},
			{data: null, defaultContent: '<button class="btn btn-outline-primary" accion="edit">Editar</button>'},
			{ data: 'project_name'},
            { data: null},
			{data: null, defaultContent: '<button class="btn btn-outline-danger" accion="delete">Eliminar</button>'}
			],
			columnDefs: [
			{
				targets: [0],
				visible: false,
				searchable: false
			},{
                targets:[3],
                render: function(data)
				{
                    var slug = '{{asset("storage")}}' + data['project_url'];
                    return '<a href="'+slug+'" class="btn btn-outline-info" target="_blank">Veure Fitxer</a>';
				}
            }			
			]
		});	

		$('#project-table tbody').on('click', 'button', function (ev) {
            event.preventDefault();
		    var data = datatable.row($(this).parents('tr')).data();
		    var accion = $(this).attr("accion");		
            switch (accion)
            {
                case "delete":
                {	
                    if(confirm('Segur que vols eliminar el projecte')){
                        $.ajaxSetup({
                            headers:
                            { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                        });
                        var id = data["id"];
                        var url = '{{ route("project.delete", "id") }}';
                        url = url.replace('id', id);
                        $.ajax({
                            url: url,
                            type: 'POST',
                            success: function () {
                                $('#project-table').DataTable().ajax.reload();
                                var alert="<div id='custom-alert' class='alert alert-danger'>Projecte Eliminat</div>";
                                $("#concurs-projects").prepend(alert);
                                setTimeout(function(){
                                    $('#custom-alert').remove();
                                }, 5000);
                            }
                        });
                    }
                break;
                }
                case "edit":{
                    $('#modalEditProject').modal('show');
                    var id = data["id"];
                    $("#editProjectId").val(id);
                    break;
                }
            }
        });
        

        $('#addProject').submit(function(){
            event.preventDefault();
            var url = '{{ route("project.saveProject", "$concurs->id") }}';
            var data = new FormData(this);            
            $.ajax({
                url: url,
                type: 'POST',
                data:data,
                dataType:'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function (response) {
                    if(response.success){
                        $('#modalAddProject').modal('hide');
                        $('#addProject')[0].reset();
                        $("#projectNameError").not(".d-none").addClass("d-none");
                        $('#project-table').DataTable().ajax.reload();
                        var alert="<div id='custom-alert' class='alert alert-success'>Projecte Afegit</div>";
                        $("#concurs-projects").prepend(alert);
                        setTimeout(function(){
                            $('#custom-alert').remove();
                        }, 5000);
                        
                    }
                    else{
                        var errors = JSON.stringify(response.errors);
                        $("#projectNameError").removeClass("d-none");
                    }
                },
                error: function(response){
                    
                }
            });
            return false;
        });

        $('#modalAddProject').on('hide.bs.modal', function (e) {
            $('#addProject')[0].reset();
            $("#projectNameError").not(".d-none").addClass("d-none");
        });

        $('#modalEditProject').on('shown.bs.modal', function (e) {
            var id =  $("#editProjectId").val();
            var url = '{{ route("project.getProject", "id") }}';
            url = url.replace('id', id);
            $.ajax({
                url: url,
                type: 'GET',
                success: function (response) {
                    if(response.success){                                               
                        projectName = response.project.project_name;                        
                        $("#editProjectName").val(projectName);
                        if(response.project.project_url!=null){
                            projectUrl = "{{asset('storage')}}" + response.project.project_url;
                            $("#projectUrl").attr("href", projectUrl);
                        }
                    }
                    else{
                        
                    }
                },
                error: function(){
                    
                }
            });
            return false;
        });        

        $('#editProject').submit(function(){
            event.preventDefault();
            var id =  $("#editProjectId").val();
            var url = '{{ route("project.updateProject", "id") }}';
            url = url.replace('id', id);
            var data = new FormData(this);            
            $.ajax({
                url: url,
                type: 'POST',
                data:data,
                dataType:'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function (response) {
                    if(response.success){
                        $('#modalEditProject').modal('hide');
                        $('#editProject')[0].reset();
                        $("#editProjectNameError").not(".d-none").addClass("d-none");
                        $('#project-table').DataTable().ajax.reload();
                        var alert="<div id='custom-alert' class='alert alert-success'>Projecte Actualitzat</div>";
                        $("#concurs-projects").prepend(alert);
                        setTimeout(function(){
                            $('#custom-alert').remove();
                        }, 5000);
                        
                    }
                    else{
                        var errors = JSON.stringify(response.errors);
                        $("#editProjectNameError").removeClass("d-none");
                    }
                },
                error: function(response){
                    
                }
            });
            return false;
        });

        $('#modalEditProject').on('hide.bs.modal', function (e) {
            $('#editProject')[0].reset();
            $("#editProjectNameError").not(".d-none").addClass("d-none");
        });
    });
</script>
@stop