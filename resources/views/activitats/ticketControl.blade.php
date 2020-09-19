@extends('layouts.master', ['body_class' => 'entrades check'])

@push('scripts')
@endpush
@section('css')
<style>
    #result_busqueda{
        overflow: auto scroll;
        max-height: 400px;
        width: 466px;
        padding-left: 20px;
    }
.checkSoci {
    display : block;
    width: 400px;
    margin: 5px;
    }
    .checkSoci > input{ /* HIDE RADIO */
    visibility: hidden; /* Makes input not-clickable */
    position: absolute; /* Remove input from document flow */
    }
    .checkSoci > input + div{ /* DIV STYLES */
    cursor:pointer;
    border:1px solid black;
    padding:5px;
    }
    .checkSoci > input:checked + div{ /* (RADIO CHECKED) DIV STYLES */
    background-color: #ffd6bb;
    border: 1px solid #ff6600;
    }
    .spinner {
    position: absolute;
    z-index: 2;
    display: none;
    width: 100%;
    height: 100%;
    margin: 0 !important;
    padding: 0;
    background-color: rgba(255, 255, 255, .65);
}

.spinner-loader {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 160px;
    height: 160px;
    margin: -80px;
}

.spinner-loader .double-bounce1,
.spinner-loader .double-bounce2 {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background-color: #66D3FA;
    opacity: .6;
    position: absolute;
    top: 0;
    left: 0;
    -webkit-animation: sk-bounce 2s infinite ease-in-out;
    animation: sk-bounce 2s infinite ease-in-out;
}

.spinner-loader .double-bounce2 {
    -webkit-animation-delay: -1s;
    animation-delay: -1s;
}

@-webkit-keyframes sk-bounce {
    0%,
    100% {
        -webkit-transform: scale(0);
    }
    50% {
        -webkit-transform: scale(1);
    }
}

@keyframes sk-bounce {
    0%,
    100% {
        transform: scale(0);
        -webkit-transform: scale(0);
    }
    50% {
        transform: scale(1);
        -webkit-transform: scale(1);
    }
}

.spinner-active {
    display: block;
}
    
}
    </style>
@stop
@section('content')
<div class="options-menu">
    <a href="{{ route('entrades')}}" class="btn btn-outline-dark"><i class="fas fa-angle-left"></i>tornar</a>
</div>
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="spinner">
    <div class="spinner-loader">
        <div class="double-bounce1"></div>
        <div class="double-bounce2"></div>
    </div>
</div>
<div class="row" style="margin-top:40px ">
    <div class="col-md-12">
        <h2>Control d'entrada</h2>
        <div style="padding:30px">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h4>Entrades socis</h4>
                    <div>
                        Comprobar Si l'úsuari es soci
                        <div class="form-inline">
                            <div class="form-group mb-2">
                                <label for="dni_soci" class="sr-only">DNI Soci</label>
                                <input type="text" class="form-control" id="dni_soci" placeholder="DNI Soci">
                            </div>
                            <button class="btn btn-outline-primary mb-2 check_soci" value="dni">Comprovar Soci</button>
                        </div>                        
                        <div class="form-inline">
                            <div class="form-group mb-2">
                                <label for="name_soci" class="sr-only">Nom Soci</label>
                                <input type="text" class="form-control" id="name_soci" placeholder="Nom Soci">
                            </div>
                            <button class="btn btn-outline-primary mb-2 check_soci" value="name">Comprovar Soci</button>
                        </div>                     
                        <div id="result_busqueda"></div>
                    </div>
                    <div class="form-group">
                        <label for="ticket_soci">Enregistrar entrada venuda per soci</label>
                        <button class="btn btn-outline-primary form-control" id="ticket_soci">Enregistrar Entrada</button>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <h4>Entrades no socis</h4>                    
                    <div class="form-group">
                        <label for="ticket_nosoci">Enregistrar entrada venuda per no soci</label>
                        <button class="btn btn-outline-primary form-control" id="ticket_nosoci">Enregistrar Entrada</button>
                    </div>                   
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <form action="{{route('activitats.store') }}" method="post">
            {{ csrf_field() }}
            <div class="form-group text-center ">
                <button type="submit" class="btn btn-outline-success" style="padding:8px 100px;margin-top:25px;" >
                    Finalitzar Activitat
                </button>
            </div>
        </form>
    </div>
</div>
@stop

@section('js')

<script>
    $(document).ready(function(){
        $('.check_soci').click(function(){
            var type = $(this).val();
            var param = "";
            if(type=="dni")
            {
                param = $('#dni_soci').val();
            }
            else{
                param = $('#name_soci').val();
            }
            
            $("#result_busqueda").html("");
            $.ajaxSetup({
				headers:
				{ 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
			});									
			var url = '{{ route("entrades.checkSoci") }}';			
			$.ajax({					
				url: url,
				type: 'POST',
                data:{param:param, type:type},
				success: function (result) {
                    var socis = result[0];                    
                    socis.forEach(function(soci){
                        var sociImgUrl = "{{Storage::url('socis/sociImg')}}";
                        var sociID = soci['id'];
                        var sociDNI = soci['dni'];
                        var sociNum = soci['member_number'];
                        var sociName = soci['name']+" "+soci['surname']+" "+soci['second_surname'];
                        var sociImg = soci['soci_img'];                        
                        sociImgUrl = sociImgUrl.replace('sociImg', sociImg);                        
                        $("#result_busqueda").append("<label class='checkSoci'>"                            
                        +"<input type='radio' name='selected_soci' value="+sociID+">"                        
                        +"<div class='row'>"
                            +"<div class='col-4'>"
                                +"<img class='img-fluid rounded-circle' src='"+sociImgUrl+"' />"
                            +"</div>"
                            +"<div class='col-8'>"+sociID
                                +"<div>DNI: "+sociDNI+"</div>"
                                +"<div>Número de Soci: "+sociNum+"</div>"
                                +"<div>Soci: "+sociName+"</div>"
                            +"</div>"
                        +"</div>"
                        +"</label>");
                        });
				}, beforeSend: function(){
                    $(".spinner").addClass('spinner-active');
                },
                complete: function(){
                    $(".spinner").removeClass('spinner-active');
                    $('#dni_soci').val('');
                    $('#name_soci').val('');
                    }
			});
        });

        $('#ticket_soci').click(function(){
            if( $("input[name='selected_soci']:radio").is(':checked')) {  
                var id = $('input:radio[name=selected_soci]:checked').val();	
                    Saveticket(id);			
                }
            else{
                alert("selecciona un soci");
            }

        });

        $('#ticket_nosoci').click(function(){
            Saveticket(0);
        });

        function Saveticket(idSoci)
        {
            $.ajaxSetup({
				headers:
				{ 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
			});									
			var url = '{{ route("entrades.ticket") }}';			
			$.ajax({					
				url: url,
				type: 'POST',
                data:{sociId:idSoci, activityId:'{{$activity->id}}'},

				success: function (result) {
                    var alert="<div id='custom-alert' class='alert alert-success'>Entrada registrada</div>";
					$("#content").prepend(alert);
                    $("#result_busqueda").html("");
                    $('#dni_soci').val('');
					setTimeout(function(){
						$('#custom-alert').remove();
					}, 5000);
				}, beforeSend: function(){
                    $(".spinner").addClass('spinner-active');
                },
                complete: function(){
                    $(".spinner").removeClass('spinner-active');
                    }
			});
        }
    });

</script>
@stop