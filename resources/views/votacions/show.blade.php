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
    <a href="{{ route('votacions')}}" class="btn btn-outline-dark"><i class="fas fa-angle-left"></i>tornar</a>
</div>
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class=" row " style="margin-top:40px ">
    <div class="col-md-12 ">
        <h2>Concurs</h2>
        <div style="padding:30px ">
            @if($concurs->finished)
            <div class="alert alert-success" style="text-align: center;margin-bottom: 23px;font-size: 40px;">
                GUANYADOR: {{$winner}}
            </div>
            @endif
            <div class="row">
                <div class="col-12">
                    <div>Nom Concurs:</div>
                    {{$concurs->name}}
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
            <table id="project-table" class="table table-striped table-bordered" style="width:100%;">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Projecte</th>
                        <th>Fitxer</th>
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
                        <th>Fitxer</th>
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
            ajax: '{{ route("votacions.projects", "$concurs->id") }}',
            scrollX:true,
			searching:true,
			ordering:true,
			columns: [
			{ data: 'id'},
			{ data: 'project_name'},
            { data: null},
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
			},{
                targets:[2],
                render: function(data)
				{
                    var slug = '{{asset("storage")}}' + data['project_url'];
                    return '<a href="'+slug+'" class="btn btn-outline-info" target="_blank">Veure Fitxer</a>';
				}
            }			
			]
        });	      
    });
</script>
@stop