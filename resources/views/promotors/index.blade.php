@extends('layouts.master', ['body_class' => 'promotors']) 
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.css" /> 
@stop 
@section('js')
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
 crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.js"></script>
@stop 
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="options-menu">
	<a type="button" class="btn btn-outline-dark" href="{{ route('promotors.create')}}">Crear Promotor</a>
</div>
<table class="table table-bordered" id="users-table">
	<thead>
		<tr>
			<th>Id</th>
			<th>Nom del promotor</th>
			<th>Descripció</th>
			<th>Veure</th>
			<th>Editar</th>
			<th>Eliminar</th>
		</tr>
	</thead>
</table>



@stop @push('scripts')
<script>
	$(function() {
		datatable = $('#users-table').DataTable({
			processing: true,
			serverSide: true,
			ajax: '{{route('promotors.data')}}',
			columns: [
			{ data: 'id'},
			{ data: 'promotor_name'},
			{ data: 'description'},
			{data: null},
			{data: null},
			{data: null, defaultContent: '<button class="btn btn-outline-secondary" accion="eliminar">Eliminar</button>'}
			],
			columnDefs: [
			{
				targets: [0],
				visible: false,
				searchable: false
			},
			{
				targets: [3],
				render: function(data){
					var id = data['id'];			
					var url = '{{ route("promotors.show", "id") }}';
					url = url.replace('id', id); 		
					return '<a class="btn btn-outline-info" role="button" href="'+url+'"><i class="fas fa-eye"></i>Veure</a>';
				}
			},
			{
				targets: [4],
				render: function(data){
					var id = data['id'];	
					var url = '{{ route("promotors.edit", "id") }}';
					url = url.replace('id', id);				
					return '<a class="btn btn-outline-warning" role="button" href="'+url+'"><i class="fas fa-pencil-alt"></i>Editar</a>';
				}
			}
			]
		});

		$('#users-table tbody').on('click', 'button', function () {
		var data = datatable.row($(this).parents('tr')).data();
		var accion = $(this).attr("accion");
		$.ajaxSetup({
			headers:
			{ 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
		});
		switch (accion)
		{
			case "eliminar":
			{	
				if(confirm("Segur que vols eliminar al promotor")){
				var id = data["id"];										
			var url = '{{ route("promotors.delete", "id") }}';
			url = url.replace('id', id);
			$.ajax({					
				url: url,
				type: 'POST',
				success: function () {
					$('#users-table').DataTable().ajax.reload();
					var alert="<div id='custom-alert' class='alert alert-danger'>Promotor Eliminat</div>";
					$("#main").prepend(alert);
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