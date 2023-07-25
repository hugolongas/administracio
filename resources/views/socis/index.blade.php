@extends('layouts.master', ['body_class' => 'sections'])
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
	<a type="button" class="btn btn-outline-dark" href="{{ route('socis.create')}}">Crear Soci</a>
	<a type="button" class="btn btn-outline-dark" href="{{ route('socis.import')}}">Importar socis</a>
	<a type="button" class="btn btn-outline-dark" href="{{ route('socis.export')}}">Exportat socis</a>
</div>
<div class="table-cont">
	<table id="socis-table" class="table table-striped table-bordered" style="width:100%">
		<thead>
			<tr>
				<th>id</th>
				<th>Veure</th>
				<th>Editar</th>
				<th>Imatge Soci</th>
				<th>Número Soci</th>
				<th>Nom</th>
				<th>Cognom</th>
				<th>Segon Cognom</th>
				<th>DNI</th>
				<th>Teléfon fixe</th>
				<th>Teléfon Movil</th>
				<th>Data Naixement</th>
				<th>Sexe</th>
				<th>Email</th>
				<th>Data Alta</th>
				<th>Data baixa</th>
				<th>Soci</th>
				<th>Cuota</th>
				<th>Via</th>
				<th>Carrer</th>
				<th>Nº Carrer</th>
				<th>Nº Pis</th>
				<th>Nº Porta</th>
				<th>Codig postal</th>
				<th>Població</th>
				<th>IBAN</th>
				<th>Titular Compte</th>
				<th>Titular DNI</th>				
				<th>Baixa</th>
				<th>Eliminar</th>
			</tr>
		</thead>
		<tbody></tbody>
		<tfoot>
			<tr>
				<th>id</th>
				<th>Veure</th>
				<th>Editar</th>
				<th>Imatge Soci</th>
				<th>Número Soci</th>
				<th>Nom</th>
				<th>Cognom</th>
				<th>Segon Cognom</th>
				<th>DNI</th>
				<th>Teléfon fixe</th>
				<th>Teléfon Movil</th>
				<th>Data Naixement</th>
				<th>Sexe</th>
				<th>Email</th>
				<th>Data Alta</th>
				<th>Data baixa</th>
				<th>Soci</th>
				<th>Cuota</th>
				<th>Via</th>
				<th>Carrer</th>
				<th>Nº Carrer</th>
				<th>Nº Pis</th>
				<th>Nº Porta</th>
				<th>Codig postal</th>
				<th>Població</th>
				<th>IBAN</th>
				<th>Titular Compte</th>
				<th>Titular DNI</th>				
				<th>Baixa</th>
				<th>Eliminar</th>
			</tr>
		</tfoot>
	</table>
</div>

<div class="modal fade" id="modalUnregister" tabindex="-1" role="dialog" aria-labelledby="modalUnregister"
	aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Donar de baixa Soci</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="unregisterMotive">Motiu Baixa</label>
					<input type="text" class="form-control" id="unregisterMotive" placeholder="motiu baixa"
						list="motives">
					<datalist id="motives">
					</datalist>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
				<button type="button" id="donarBaixa" data-id="" class="btn btn-outline-primary">Donar de baixa</button>
			</div>
		</div>
	</div>
</div>


@stop
@push('scripts')
<script>
	$(function() {
		datatable = $('#socis-table').DataTable({
			processing: true,
			serverSide: true,
			ajax: '{{route('socis')}}',
			scrollX:true,
			searching:true,
			ordering:true,
			columns: [
			{ data: 'id'},
			{data: null},
			{data: null},
			{ data: 'soci_img'},
			{ data: 'member_number'},
			{ data: 'name'},
			{ data: 'surname'},
			{ data: 'second_surname'},
			{ data: 'dni'},
			{ data: 'phone'},
			{ data: 'mobile'},
			{ data: 'birth_date'},
			{ data: 'sex'},
			{ data: 'email'},
			{ data: 'register_date'},
			{ data: 'unregister_date'},			
			{ data: 'tipus_soci'},
			{ data: 'cuota_soci'},
			{ data: 'road'},
			{ data: 'address'},			
			{ data: 'address_num'},
			{ data: 'address_floor'},
			{ data: 'address_door'},						
			{ data: 'postal_code'},
			{ data: 'city'},
			{ data: 'iban'},									
			{ data: 'account_holder'},
			{ data: 'dni_holder'},			
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
				targets: [1],
				render: function(data){
					var id = data['id'];			
					var url = '{{ route("socis.show", "id") }}';
					url = url.replace('id', id); 		
					return '<a class="btn btn-outline-info" role="button" href="'+url+'"><i class="fas fa-eye"></i>Veure</a>';
				}
			},
			{
				targets: [2],
				render: function(data){
					var id = data['id'];	
					var url = '{{ route("socis.edit", "id") }}';
					url = url.replace('id', id);				
					return '<a class="btn btn-outline-warning" role="button" href="'+url+'"><i class="fas fa-pencil-alt"></i>Editar</a>';
				}
			},
			{
				targets: [3],
				render: function(data)
				{
					var imgSrc = data;
					var src = '{{asset('storage/socis')}}/'+data;
					return '<img class="img-fluid" src="'+src+'"></img>';
				}
			},			
			{
				targets: [28],
				render: function(data){
					var unregister_date = data['unregister_date'];
					var id = data['id'];
					if(unregister_date==null)
					{
						return '<button class="btn btn-outline-danger" accion="baixa" data-id="'+id+'">Donar de Baixa</button>';
					}
					else
					{
						return '<button class="btn btn-outline-success" accion="alta">Donar d\'Alta</button>';
					}
				}
			}
			],
			createdRow:function(row,data,dataIndex){
				if(data['unregister_date']!=null)
				{
					$(row).addClass('redClass');
				}
			}
		});	

		$('#socis-table tbody').on('click', 'button', function (ev) {
		var data = datatable.row($(this).parents('tr')).data();
		var accion = $(this).attr("accion");		
		switch (accion)
		{
			case "eliminar":
			{	
				if(confirm('Segur que vols eliminar el soci')){
			$.ajaxSetup({
				headers:
				{ 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
			});
			var id = data["id"];										
			var url = '{{ route("socis.delete", "id") }}';
			url = url.replace('id', id);
			$.ajax({					
				url: url,
				type: 'POST',
				success: function () {
					$('#socis-table').DataTable().ajax.reload();
					var alert="<div id='custom-alert' class='alert alert-danger'>Soci Eliminat</div>";
					$("#content").prepend(alert);
					setTimeout(function(){
						$('#custom-alert').remove();
					}, 5000);
				}
			});
				}
			break;
			}
			case "alta":
			{	
			$.ajaxSetup({
				headers:
				{ 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
			});
			var id = data["id"];										
			var url = '{{ route("socis.reactivate", "id") }}';
			url = url.replace('id', id);
			$.ajax({					
				url: url,
				type: 'POST',
				success: function (resp) {					
					alert="<div id='custom-alert' class='alert alert-success'>Soci donat d'Alta</div>";
					$("#content").prepend(alert);
					$('#socis-table').DataTable().ajax.reload();
					setTimeout(function(){
						$('#custom-alert').remove();
					}, 5000);
				}
			});
			break;
			}
			case "baixa":
			{	
			$("#modalUnregister").modal('show');
			var id = $(ev.target).attr('data-id');
			//console.log($(ev.target).attr('data-id'));
			$("#donarBaixa").attr('data-id',id);
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
				$('#socis-table').DataTable().ajax.reload();					
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