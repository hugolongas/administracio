@extends('layouts.master', ['body_class' => 'groups']) 
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
	<a type="button" class="btn btn-outline-dark" href="{{ route('groups.create')}}">Crear Secció</a>
</div>
<table class="table table-bordered" id="group-table">
	<thead>
		<tr>
			<th>Id</th>
			<th>Veure</th>
			<th>Editar</th>
			<th>Nom del grup</th>
			<th>Descripció</th>
			<th>Número d'integrants</th>			
			<th>Eliminar</th>
		</tr>
	</thead>
</table>



@stop @push('scripts')
<script>
	$(function() {
		datatable = $('#group-table').DataTable({
			processing: true,
			serverSide: true,
			ajax: '{{route('groups')}}',
			columns: [
			{ data: 'id'},
			{data: 'view'},
			{data: 'edit'},
			{ data: 'name'},
			{ data: 'description'},
			{ data: 'members'},			
			{data: 'delete'}
			],
			columnDefs: [
			{
				targets: [0],
				visible: false,
				searchable: false
			}			
			]
		});

		$('#group-table tbody').on('click', 'button', function () {
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
				var group = data["name"];								
				if(confirm("Segur que vols eliminar la grup: "+group)){
				var id = data["id"];								
			var url = '{{ route("groups.delete", "id") }}';
			url = url.replace('id', id);
			$.ajax({					
				url: url,
				type: 'POST',
				success: function () {
					$('#group-table').DataTable().ajax.reload();
					var alert="<div id='custom-alert' class='alert alert-danger'>Secció Eliminada</div>";
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