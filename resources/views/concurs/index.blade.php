@extends('layouts.master', ['body_class' => 'concurs'])
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" />
<style>
	.activeClass {
		background-color: #a0e194 !important;
		color: #000000;
	}
	.finishedClass {
		background-color: #bbd6fb !important;
		color: #000000;
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
	<a type="button" class="btn btn-outline-dark" href="{{ route('concurs.create')}}">Crear Concurs</a>	
</div>
<div class="table-cont">
	<table id="contest-table" class="table table-striped table-bordered" style="width:100%">
		<thead>
			<tr>
                <th>id</th>
                <th>Veure</th>
				<th>Editar</th>
                <th>Concurs</th>
				<th>Descripció</th>
				<th>Projectes</th>
                <th>Inici Concurs</th>
				<th>Final Concurs</th>
				<th>Punts Mesa</th>
                <th>% Mesa</th>
                <th>% Soci</th>                
				<th>Guanyador</th>
				<th>Activar/Desactivar</th>
                <th>Finalitzar Concurs</th>
                <th>Eliminar</th>
			</tr>
		</thead>
		<tbody></tbody>
		<tfoot>
			<tr>				
                <th>id</th>
                <th>Veure</th>
				<th>Editar</th>
                <th>Concurs</th>
				<th>Descripció</th>
				<th>Projectes</th>
                <th>Inici Concurs</th>
				<th>Final Concurs</th>
				<th>Punts Mesa</th>
                <th>% Mesa</th>
                <th>% Soci</th>                
				<th>Guanyador</th>
				<th>Activar/Desactivar</th>
                <th>Finalitzar Concurs</th>
                <th>Eliminar</th>
			</tr>
		</tfoot>
	</table>
</div>


@stop
@push('scripts')
<script>
	$(function() {
		datatable = $('#contest-table').DataTable({
			processing: true,    
			serverSide: true,  
            ajax: "{{ route('concurs') }}",
            scrollX:true,
			searching:true,
			ordering:true,
			columns: [
			{ data: 'id'},
            { data: 'view'},
			{ data: 'edit'},
            { data: 'name'},
			{ data: 'description'},
			{ data: 'projects'},
            { data: 'start_votations_date'},
            { data: 'end_votations_date'},
			{ data: 'punts_mesa'},
            { data: 'mesa_percent'},
            { data: 'soci_percent'},            
            { data: 'winner'},
			{ data: 'activate'},
            { data: 'end_contest'},			
			{data: 'delete'}
			],
			columnDefs: [
			{
				targets: [0],
				visible: false,
				searchable: false
			}			
			],
			createdRow:function(row,data,dataIndex){
				var active = data['active'];
				var finished = data['finished'];
				if(active==1)
				{
					$(row).addClass('activeClass');
				}
				if(finished==1)
				{
					$(row).addClass('finishedClass');
				}
			}
		});	

		$('#contest-table tbody').on('click', 'button', function (ev) {
		var data = datatable.row($(this).parents('tr')).data();
		var accion = $(this).attr("accion");		
		switch (accion)
		{
			case "delete":
			{
				if(confirm('Segur que vols eliminar el concurs')){
					$.ajaxSetup({
						headers:
						{ 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
					});
					var id = data["id"];										
					var url = '{{ route("concurs.delete", "id") }}';
					url = url.replace('id', id);
					$.ajax({					
						url: url,
						type: 'POST',
						success: function () {
							$('#contest-table').DataTable().ajax.reload();
							var alert="<div id='custom-alert' class='alert alert-danger'>Concurs Eliminat</div>";
							$("#content").prepend(alert);
							setTimeout(function(){
								$('#custom-alert').remove();
							}, 5000);
						}
					});
				}
			break;
			}
			case "activar":
				{
					$.ajaxSetup({
						headers:
						{ 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
					});
					var id = data["id"];
					var url = '{{ route("concurs.activate", "id") }}';
					url = url.replace('id', id);
					$.ajax({					
						url: url,
						type: 'POST',
						success: function (resp) {
							if(resp == 1){
								alert="<div id='custom-alert' class='alert alert-success'>Concurs activar</div>";
							}
							else
							{
								alert="<div id='custom-alert' class='alert alert-danger'>Concurs desactivat</div>";
							}
							$("#content").prepend(alert);
							$('#contest-table').DataTable().ajax.reload();
							setTimeout(function(){$('#custom-alert').remove();}, 5000);                                
                            }
                        });
                    break;
                    }
		}
		});
	});
</script>
@endpush