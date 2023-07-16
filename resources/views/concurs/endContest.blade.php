@extends('layouts.master', ['body_class' => 'concurs finish'])

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
<div class="row" style="margin-top:40px ">
    <div class="col-md-12 ">
        <h2>{{$concurs->name}}</h2>
        <div style="padding:30px ">
            <div class="row">
                <div clas="col-12">
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
            <div style="margin:40px 0px">
                <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#modalMailVote">
                    Afegir Vots per correu
                </button>
                <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#modalMesaVote">
                    Afegir puntuació mesa
                </button>
                <a href="{{route('concurs.finish',$concurs->id) }}" class="btn btn-outline-success pull-right">Finalitzar Concurs</a>
            </div>
            <table id="project-table" class="table table-striped table-bordered" style="width:100%;">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Projecte</th>
                        <th>Vots Mesa</th>
                        <th>Vots Mesa(%)</th>
                        <th>Vots Socis</th>
                        <th>Vots Socis(%)</th>
                        <th>Vots Totals(%)</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                    <tr>
                        <th>id</th>
                        <th>Projecte</th>
                        <th>Vots Mesa</th>
                        <th>Vots Mesa(%)</th>
                        <th>Vots Socis</th>
                        <th>Vots Socis(%)</th>
                        <th>Vots Totals(%)</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="modalMailVote" tabindex="-1" role="dialog" aria-labelledby="modalMailVoteLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalMailVoteLabel">Vots per correu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addMailVote" class="form-horizontal" role="form" method="POST">
                {{ csrf_field() }}
                <div class="modal-body">
                    <input type="hidden" name="idConcurs" id="idConcurs" class="form-control" tabindex="1"
                        value="{{$concurs->id}}" />
                    <div class="form-group">
                        <label for="name">DNI Soci*:</label>
                        <input type="text" name="dni" id="dni" class="form-control" tabindex="1"
                            value="{{ old('dni') }}" />
                        <span id="error_dni" class="error-message d-none">Has d'indicar un dni</span>
                        <span id="error_soci" class="error-message d-none">El dni no pertany a cap soci</span>                        
                    </div>
                    @if($concurs->projects->count()>0)
                    <div class="form-group">
                        <label for="project_vote">Projectes</label>
                        <select class="form-control" id="project_vote" name="project_vote">
                            <option value="" selected>Seleccionar...</option>
                            @foreach($concurs->projects as $project)
                            <option value="{{$project->id}}">{{$project->project_name}}</option>
                            @endforeach
                        </select>
                        <span id="error_project_vote" class="error-message d-none">Has de seleccionar un projecte</span>
                    </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <div class="form-group text-center ">
                        <input type="submit" class="btn btn-outline-success" style="padding:8px 100px;margin-top:25px;"
                            value="Votar" tabindex="9" />
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalMesaVote" tabindex="-1" role="dialog" aria-labelledby="modalEditProjectLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditProjectLabel">Editar Projecte</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addMesaVote" class="form-horizontal" role="form" method="POST">
                {{ csrf_field() }}
                <div class="modal-body">
                    <input type="hidden" name="concurs_id" id="concurs_id"
                    value="{{$concurs->id}}" />
                    @if($concurs->projects->count()>0)
                    @foreach($concurs->projects as $project)
                    <div class="form-row">
                        <div class="form-group col-6">                            
                            {{$project->project_name}}
                        </div>
                        <div class="form-group col-6">
                            <input type="number" name="project_vote_{{$project->id}}" id="project_vote_{{$project->id}}"
                                class="form-control" value={{$project->vots_mesa}} />
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
                <div class="modal-footer">
                    <div class="form-group text-center ">
                        <input type="submit" class="btn btn-outline-success" style="padding:8px 100px;margin-top:25px;"
                            value="Actualitzar puntuacions" tabindex="2" />
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
        
        datatable = $('#project-table').DataTable({
			processing: true,    
			serverSide: true,  
            ajax: '{{ route("concurs.close", "$concurs->id") }}',
            scrollX:true,
			searching:true,
			ordering:true,
			columns: [
			{ data: 'id'},			
			{ data: 'project_name'},            
			{ data: 'vots_mesa'},
            { data: 'vots_mesa_total'},
			{ data: 'vots_soci'},
            { data: 'vots_soci_total'},
            { data: 'vots_total'}			
			],
			columnDefs: [
			{
				targets: [0],
				visible: false,
				searchable: false
			}			
			]
		});	
        
        $('#addMailVote').submit(function(){
            event.preventDefault();
            $("#error_dni").not(".d-none").addClass("d-none");
            $("#error_soci").not(".d-none").addClass("d-none");
            $("#error_project_vote").not(".d-none").addClass("d-none");
            var url = '{{ route("votacions.storeVoteAdmin") }}';
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
                        $('#addMailVote')[0].reset();                        
                        $('#project-table').DataTable().ajax.reload();
                        var alert="<div id='custom-alert' class='alert alert-success'>Vot Afegit</div>";
                        $("#addMailVote").prepend(alert);
                        setTimeout(function(){
                            $('#custom-alert').remove();
                        }, 5000);
                        
                    }
                    else{
                        var errors = response.errors;
                        $.each(errors,function(i,val){
                            console.log("i: "+i+" val: "+val);
                            if(i!="vot"){
                                id = "#error_"+i;
                                console.log(id);
                                $(id).removeClass("d-none");
                            }
                            else{
                                var alert="<div id='custom-alert' class='alert alert-warning'>Aquest soci ja ha votat</div>";
                                $("#addMailVote").prepend(alert);
                                setTimeout(function(){
                                    $('#custom-alert').remove();
                                    }, 5000);
                            }
                            
                        });
                    }
                },
                error: function(response){
                    
                }
            });
            return false;
        });

        $('#modalAddProject').on('hide.bs.modal', function (e) {
            $('#addProject')[0].reset();
            $("#error_dni").not(".d-none").addClass("d-none");
            $("#error_soci").not(".d-none").addClass("d-none");
            $("#error_project_vote").not(".d-none").addClass("d-none");            
        });

        $('#addMesaVote').submit(function(){
            event.preventDefault();            
            var url = '{{ route("votacions.storeMesaVote") }}';
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
                        $('#addMesaVote')[0].reset();
                        $('#modalMesaVote').modal('hide');
                        $('#project-table').DataTable().ajax.reload();
                        var alert="<div id='custom-alert' class='alert alert-success'>Votacions mesa Actualitzades</div>";
                        $("#content").prepend(alert);
                        setTimeout(function(){
                            $('#custom-alert').remove();
                        }, 5000);                        
                    }
                },
                error: function(response){
                    
                }
            });
            return false;
        });

        $('#modalMesaVote').on('hide.bs.modal', function (e) {
            $('#addMesaVote')[0].reset();
            $("#error_dni").not(".d-none").addClass("d-none");
            $("#error_soci").not(".d-none").addClass("d-none");
            $("#error_project_vote").not(".d-none").addClass("d-none");            
        });
    });
</script>
@stop