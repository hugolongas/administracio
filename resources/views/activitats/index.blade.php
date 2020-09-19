@extends('layouts.master', ['body_class' => 'activitats'])
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
	<table id="activities-table" class="table table-striped table-bordered" style="width:100%">
		<thead>
			<tr>
				<th>id</th>
				<th>Veure</th>
				<th>Editar</th>		
				<th>Nom</th>		
				<th>Data</th>
				<th>Creat per</th>
				<th>Entrades de socis</th>
				<th>Entrades de no socis</th>
				<th>Estat</th>
				<th>Eliminar</th>
			</tr>
		</thead>
		<tbody></tbody>
		<tfoot>
			<tr>
				<th>id</th>
				<th>Veure</th>
				<th>Editar</th>		
				<th>Nom</th>		
				<th>Data</th>
				<th>Creat per</th>
				<th>Entrades de socis</th>
				<th>Entrades de no socis</th>
				<th>Estat</th>
				<th>Eliminar</th>
			</tr>
		</tfoot>
	</table>
</div>
@stop
@push('scripts')
<script>
	$(function() {
		datatable = $('#activities-table').DataTable({
			processing: true,
			serverSide: true,
			ajax: '{{ route("activitats") }}',
			scrollX:true,
			searching:true,
			ordering:true,
			columns: [
			{ data: 'id'},
			{data: null},
			{data: null},
			{data:'name'},
			{data:'activity_date'},
			{data:'created_by'},
			{data:'socis_tickets'},
			{data:'nosocis_tickets'},
			{data:'status'},
			{data: null, defaultContent: '<button class="btn btn-outline-secondary" accion="eliminar">Eliminar</button>'}
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
					var url = '{{ route("activitats.show", "id") }}';
					url = url.replace('id', id); 		
					return '<a class="btn btn-outline-info" role="button" href="'+url+'"><i class="fas fa-eye"></i>Veure</a>';
				}
			},
			{
				targets: [2],
				render: function(data){
					var id = data['id'];	
					var url = '{{ route("activitats.edit", "id") }}';
					url = url.replace('id', id);				
					return '<a class="btn btn-outline-warning" role="button" href="'+url+'"><i class="fas fa-pencil-alt"></i>Editar</a>';
				}
			}			
			]
		});	

		$('#activities-table tbody').on('click', 'button', function (ev) {
		var data = datatable.row($(this).parents('tr')).data();
		var accion = $(this).attr("accion");		
		switch (accion)
		{
			case "eliminar":
			{	
				if(confirm("Segur que vols eliminar l'activitat")){
			$.ajaxSetup({
				headers:
				{ 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
			});
			var id = data["id"];										
			var url = '{{ route("activitats.delete", "id") }}';
			url = url.replace('id', id);
			$.ajax({					
				url: url,
				type: 'POST',
				success: function () {
					$('#activities-table').DataTable().ajax.reload();
					var alert="<div id='custom-alert' class='alert alert-danger'>Activitat Eliminada</div>";
					$("#content").prepend(alert);
					setTimeout(function(){
						$('#custom-alert').remove();
					}, 5000);
				}
			});
				}
			break;
			}
		}
		});
	});

</script>



@endpush