@extends('layouts.master', ['body_class' => 'votacions'])
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" />
@stop
@section('js')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
@stop
@section('content')
<div class="table-cont" style="margin-top: 20px;">
	<table id="contest-table" class="table table-striped table-bordered" style="width:100%">
		<thead>
			<tr>
                <th>id</th>
                <th>Veure</th>
                <th>Votar</th>
                <th>Concurs</th>
				<th>Descripció</th>
                <th>Inici Votacions</th>
                <th>Final Votacions</th>
                <th>% Mesa</th>
                <th>% Soci</th>
			</tr>
		</thead>
		<tbody></tbody>
		<tfoot>
			<tr>				
                <th>id</th>
                <th>Veure</th>
                <th>Votar</th>
                <th>Concurs</th>
				<th>Descripció</th>
                <th>Inici Votacions</th>
                <th>Final Votacions</th>
                <th>% Mesa</th>
                <th>% Soci</th>
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
            ajax: "{{ route('votacions') }}",
            scrollX:true,
			searching:true,
			ordering:true,
			columns: [
			{ data: 'id'},
            { data: 'view'},
			{ data: 'vote'},
            { data: 'name'},
			{ data: 'description'},
            { data: 'start_votations_date'},
            { data: 'end_votations_date'},
            { data: 'mesa_percent'},
            { data: 'soci_percent'}
			],
			columnDefs: [
			{
				targets: [0],
				visible: false,
				searchable: false
			}			
			]
		});	
	});
</script>
@endpush