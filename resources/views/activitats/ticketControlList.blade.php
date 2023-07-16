@extends('layouts.master', ['body_class' => 'entrades'])
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" />
<style>
	.redClass {
		background-color: #832222 !important;
		color: white;
	}
</style>
@stop
@section('js')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
@stop
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="options-menu">
	<a type="button" class="btn btn-outline-dark" href="{{ route('activitats.create')}}">Crear Activitat</a>
</div>
<div class="table-cont">
	<table id="tickets-table" class="table table-striped table-bordered" style="width:100%">
		<thead>
			<tr>
				<th>id</th>				
				<th>Gestionar</th>		
				<th>Nom</th>
				<th>Data</th>
				<th>Creat per</th>
				<th>Entrades de socis</th>
				<th>Entrades de no socis</th>				
			</tr>
		</thead>
		<tbody></tbody>
		<tfoot>
			<tr>
				<th>id</th>				
				<th>Gestionar</th>		
				<th>Nom</th>
				<th>Data</th>
				<th>Creat per</th>
				<th>Entrades de socis</th>
				<th>Entrades de no socis</th>	
			</tr>
		</tfoot>
	</table>
</div>
@stop
@push('scripts')
<script>
	$(function() {
		datatable = $('#tickets-table').DataTable({
			processing: true,
			serverSide: true,
			ajax: '{{route('entrades')}}',
			scrollX:true,
			searching:true,
			ordering:true,
			columns: [
			{ data: 'id'},
            {data: null},
			{data:'name'},
			{data:'activity_date'},
			{data:'created_by'},
			{data:'socis_tickets'},
			{data:'nosocis_tickets'}
			],
			columnDefs: [
			{
				targets: [0],
				visible: false,
				searchable: false
			},
			{
				targets: [1],
				render: function(data){
					var id = data['id'];			
					var url = '{{ route("entrades.control", "id") }}';
					url = url.replace('id', id); 		
					return '<a class="btn btn-outline-info" role="button" href="'+url+'"><i class="fas fa-ticket-alt"></i>Gestionar</a>';
				}
			}			
			]
		});	
	});

</script>



@endpush