@extends('layouts.master', ['body_class' => 'documents-admin'])
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" />

@stop
@section('js')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
@stop
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="options-menu">
	<a type="button" class="btn btn-outline-dark" href="{{ route('documentsAdmin.create')}}">Crear Document</a>
</div>
<div class="table-cont">
	<table id="documents-table" class="table table-striped table-bordered" style="width:100%">
		<thead>
			<tr>
				<th>id</th>
				<th>Veure</th>
				<th>Editar</th>
                <th>Titol</th>
                <th>Resum</th>
                <th>Tamany</th>
                <th>Tipus</th>
                <th>Grup</th>
				<th>Descarregar</th>
				<th>Eliminar</th>
			</tr>
		</thead>
		<tbody></tbody>
		<tfoot>
			<tr>
				<th>id</th>
				<th>Veure</th>
				<th>Editar</th>
                <th>Titol</th>
                <th>Resum</th>
                <th>Tamany</th>
                <th>Tipus</th>
                <th>Grup</th>
				<th>Descarregar</th>
				<th>Eliminar</th>
			</tr>
		</tfoot>
	</table>
</div>

@stop
@push('scripts')
<script>
	$(function() {
		datatable = $('#documents-table').DataTable({
			processing: true,
			serverSide: true,
			ajax: '{{route('documentsAdmin')}}',
			scrollX:true,
			searching:true,
			ordering:true,
			columns: [
			{ data: 'id'},
			{data: 'view'},
			{data: 'edit'},
			{data: 'title'},
			{data: 'summary'},
            {data: 'size'},
            {data: 'type'},
            {data: 'group'},
			{data: 'download'},
			{data: 'delete'}
			],
			columnDefs: [
			{
				targets: [0],
				visible: false,
				searchable: false
			},					
			]
		});	

		$('#documents-table tbody').on('click', 'button', function (ev) {
		var data = datatable.row($(this).parents('tr')).data();
		var accion = $(this).attr("accion");		
		switch (accion)
		{
			case "delete":
			{	
				if(confirm('Segur que vols eliminar el document')){
			$.ajaxSetup({
				headers:
				{ 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
			});
			var id = data["id"];										
			var url = '{{ route("documentsAdmin.delete", "id") }}';
			url = url.replace('id', id);
			$.ajax({					
				url: url,
				type: 'POST',
				success: function () {
					$('#documents-table').DataTable().ajax.reload();
					var alert="<div id='custom-alert' class='alert alert-danger'>Document Eliminat</div>";
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