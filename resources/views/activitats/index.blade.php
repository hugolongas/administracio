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
				<th>Control d'Entrades</th>
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
				<th>Control d'Entrades</th>
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
			ajax: '{{route('activitats.data')}}',
			scrollX:true,
			searching:true,
			ordering:true,
			columns: [
			{ data: 'id'},
			{data: null},
			{data: null},
			{fata:'name'},
			{fata:'activity_date'},
			{data: null},
			{data: null, defaultContent: '<button class="btn btn-secondary" accion="eliminar">Eliminar</button>'}
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
					return '<a class="btn btn-info" role="button" href="'+url+'"><i class="fa fa-eye"></i>Veure</a>';
				}
			},
			{
				targets: [2],
				render: function(data){
					var id = data['id'];	
					var url = '{{ route("activitats.edit", "id") }}';
					url = url.replace('id', id);				
					return '<a class="btn btn-warning" role="button" href="'+url+'"><i class="fa fa-pencil-alt"></i>Editar</a>';
				}
			}
			{
				targets: [-2],
				render: function(data){
					var id = data['id'];	
					var url = '{{ route("activitats.entrada", "id") }}';
					url = url.replace('id', id);				
					return '<a class="btn btn-warning" role="button" href="'+url+'"><i class="fa fa-pencil-alt"></i>Control d\'Entrada</a>';
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
					$('#users-table').DataTable().ajax.reload();
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

	$('#modalUnregister').on('shown.bs.modal', function () {
		var url = '{{route("socis.unregisterMotive")}}';		
		$.ajax({					
			url: url,
			type: 'GET',
			success: function (data) {
				if(data.length>0){
					// Loop over the JSON array.
					data.forEach(function (item) {
						// Create a new <option> element.
						var option = document.createElement('option');
						// Set the value using the item in the JSON array.
						option.value = item.unregister_motive;
						// Add the <option> element to the <datalist>.
							$("#motives").append(option);
					});
				}		
			}
		});
	});

	$("#donarBaixa").on('click',function(e){
		var id = $(this).attr('data-id');
		var motive = $("#unregisterMotive").val();
		console.log(motive);
		$.ajaxSetup({
				headers:
				{ 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
		});			
		var url = '{{ route("socis.unregister") }}';
		$.ajax({					
			url: url,
			method: 'POST',
			data: {
				id: id,
				motive: motive                     
			},
			success: function (resp) {					
				alert="<div id='custom-alert' class='alert alert-success'>Soci donat de baixa</div>";
				$("#content").prepend(alert);
				$('#users-table').DataTable().ajax.reload();					
				$("#modalUnregister").modal('hide');
				setTimeout(function(){
					$('#custom-alert').remove();
				}, 5000);
			}
		});
	});

	$("#modalUnregister").on('hidden.bs.modal',function(){
		$("#unregisterMotive").val('');
		$("#motives").empty();
	});

</script>



@endpush