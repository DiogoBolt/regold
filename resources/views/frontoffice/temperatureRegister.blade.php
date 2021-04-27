@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/documents/temp-register.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-bar">
        <p class="container-bar_txt">
            REGISTOS DE TEMPERATURA
        </p>
        <div class="container-bar_img">
            <img src="/img/haccp_icon.png"/>
        </div>
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">Home</li>
            <li class="breadcrumb-item " aria-current="page">Documentos Registos</li>
            <li class="breadcrumb-item active" aria-current="page">Temperaturas</li>
        </ol>
    </nav>

    {{-- Go Back Button --}}
    <a class="back-btn" href="/frontoffice/documents/Registos">
        <span class="back-btn__front"><strong>Voltar</strong></span>
        <span class="back-btn__back"><strong>Documentos Registos</strong></span>
    </a>

    <div class="container">
        @if($errors->any())
            <h4 class="high">{{$errors->first()}}</h4>
        @endif
        <div class="register-info">
            <p> registos de temperatura </p>
            <p> {{$today}} </p>
        </div>

            @if($userType!=4)
                <a class="file-link" id="filter-link" data-toggle="collapse" href="#collapse-thermo" role="button"
                   aria-expanded="false" aria-controls="collapse-thermo">
                    <strong>Novo Termometro</strong>
                </a>
            @endif

        <div class="collapse" id="collapse-thermo">
            <div class="card-body">
                <form method="post" action="/thermo/attachthermo">
                    Tipo :
                    <select name="type" class="form-control" required>
                        <option value="" disabled selected>Seleccione tipo</option>
                        <option value="1">Refrigeração</option>
                        <option value="2">Congelação</option>
                    </select>
                    Imei : <input name="imei" class="form-control" >
                    Numero Arca : <input name="number" class="form-control" required>
                    {{ csrf_field() }}
                    <button class="btn btn-add">Adicionar</button>
                </form>
            </div>
        </div>

        <div class="register-container">
            @foreach($clientThermos as $thermo)
                @if($thermo->imei != null)
                @if($thermo->type === 1)
                    <div class="register-arc cooling">
                        <div class="register-arc__info">
                            <div class="register-arc__info-extra">
                                <span><img style="width:20px;height:20px" src="{{ URL::to('/') }}/img/signal-icon-{{$thermo->signal_power}}.png">{{isset($thermo->thermo->signal_power) ? $thermo->thermo->signal_power : 0}}</span>
                                <span class="show-info" data-toggle="modal" data-target="#info-modal" onclick="showLastReads({{$thermo->id}})"><i class="glyphicon glyphicon-info-sign"></i></span>
                            </div>
                            <p>arca de refrigeração</p>
                            @if(Session::has('impersonated'))
                                <h1 onclick="showEditName({{$thermo->id}})">{{$thermo->number}}</h1>
                            @else
                                <h1>{{$thermo->number}}</h1>
                            @endif
                        </div>
                        <div class="register-arc__data">
                            <span>{{$thermo->fridgeType->min_temp}}º/c até {{$thermo->fridgeType->max_temp}}º/c</span>
                            <div class="register-arc__data_temps">
                                @if($thermo->average != null)
                                    <div>
                                        <h3 class="temperature normal">{{number_format($thermo->average->morning_temp , 1)}}</h3>
                                        <p>manhã</p>
                                    </div>
                                    <div>
                                        <h3 class="temperature normal">{{number_format($thermo->average->afternoon_temp , 1)}}</h3>
                                        <p>tarde</p>
                                    </div>
                                @else
                                    <div>
                                        <h3 class="temperature normal">N/A</h3>
                                        <p>manhã</p>
                                    </div>
                                    <div>
                                        <h3 class="temperature normal">N/A</h3>
                                        <p>tarde</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @if(Session::has('impersonated'))
                        <div class="register-arc__info delete" data-toggle="modal" data-target="#deleteModal"
                             data-item="{{ $thermo }}">
                            eliminar
                        </div>
                            @endif
                    </div>
                @else
                    <div class="register-arc freezing">
                        <div class="register-arc__info">
                            <div class="register-arc__info-extra">
                                    <span><img style="width:20px;height:20px" src="{{ URL::to('/') }}/img/signal-icon-{{$thermo->signal_power}}.png">{{isset($thermo->thermo->signal_power) ? $thermo->thermo->signal_power : 0}}</span>
                                <span class="show-info" data-toggle="modal" data-target="#info-modal" onclick="showLastReads({{$thermo->id}})"><i class="glyphicon glyphicon-info-sign"></i></span>
                            </div>
                            <p>arca de congelação</p>
                            @if(Session::has('impersonated'))
                                <h1 onclick="showEditName({{$thermo->id}})">{{$thermo->number}}</h1>
                            @else
                                <h1>{{$thermo->number}}</h1>
                            @endif
                        </div>
                        <div class="register-arc__data">
                            <span>{{$thermo->fridgeType->min_temp}}º/c até {{$thermo->fridgeType->max_temp}}º/c</span>
                            <div class="register-arc__data_temps">
                                @if($thermo->average != null)
                                    <div>
                                        <h3 class="temperature normal">{{number_format($thermo->average->morning_temp , 1)}}</h3>
                                        <p>manhã</p>
                                    </div>
                                    <div>
                                        <h3 class="temperature normal">{{number_format($thermo->average->afternoon_temp , 1)}}</h3>
                                        <p>tarde</p>
                                    </div>
                                @else
                                    <div>
                                        <h3 class="temperature normal">N/A</h3>
                                        <p>manhã</p>
                                    </div>
                                    <div>
                                        <h3 class="temperature normal">N/A</h3>
                                        <p>tarde</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @if(Session::has('impersonated'))
                        <div class="register-arc__info delete" data-toggle="modal" data-target="#deleteModal"
                             data-item="{{ $thermo }}">
                            eliminar
                        </div>
                            @endif
                    </div>
                @endif
                @else
                    @if($thermo->type === 1)
                        <div class="register-arc cooling">
                            <div class="register-arc__info">
                                <div class="register-arc__info-extra">
                                    <span><img style="width:20px;height:20px" src="{{ URL::to('/') }}/img/signal-icon-{{$thermo->signal_power}}.png">{{isset($thermo->thermo->signal_power) ? $thermo->thermo->signal_power : 0}}</span>
                                    <span class="show-info" data-toggle="modal" data-target="#info-modal" onclick="showLastReads({{$thermo->id}})"><i class="glyphicon glyphicon-info-sign"></i></span>
                                </div>
                                <p>arca de refrigeração</p>
                                @if(Session::has('impersonated'))
                                    <h1 onclick="showEditName({{$thermo->id}})">{{$thermo->number}}</h1>
                                @else
                                    <h1>{{$thermo->number}}</h1>
                                @endif
                            </div>
                            <div class="register-arc__data">
                                <span>{{$thermo->fridgeType->min_temp}}º/c até {{$thermo->fridgeType->max_temp}}º/c</span>
                                <div class="register-arc__data_temps">
                                    @if($thermo->average != null)
                                        <div>
                                            <h3 class="temperature normal" onclick="showEditTemp({{$thermo->id}},'m')" >{{number_format($thermo->average->morning_temp , 1)}}</h3>
                                            <p>manhã</p>
                                        </div>
                                        <div>
                                            <h3 class="temperature normal" onclick="showEditTemp({{$thermo->id}},'t')">{{number_format($thermo->average->afternoon_temp , 1)}}</h3>
                                            <p>tarde</p>
                                        </div>
                                    @else
                                        <div>
                                            <h3 class="temperature normal" onclick="showEditTemp({{$thermo->id}},'m')">N/A</h3>
                                            <p>manhã</p>
                                        </div>
                                        <div>
                                            <h3 class="temperature normal" onclick="showEditTemp({{$thermo->id}},'t')">N/A</h3>
                                            <p>tarde</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @if(Session::has('impersonated'))
                            <div class="register-arc__info delete" data-toggle="modal" data-target="#deleteModal"
                                 data-item="{{ $thermo }}">
                                eliminar
                            </div>
                                @endif
                        </div>
                    @else
                        <div class="register-arc freezing">
                            <div class="register-arc__info">
                                <div class="register-arc__info-extra">
                                    <span><img style="width:20px;height:20px" src="{{ URL::to('/') }}/img/signal-icon-{{$thermo->signal_power}}.png">{{isset($thermo->thermo->signal_power) ? $thermo->thermo->signal_power : 0}}</span>
                                    <span class="show-info" data-toggle="modal" data-target="#info-modal" onclick="showLastReads({{$thermo->id}})"><i class="glyphicon glyphicon-info-sign"></i></span>
                                </div>
                                <p>arca de congelação</p>
                                @if(Session::has('impersonated'))
                                <h1 onclick="showEditName({{$thermo->id}})">{{$thermo->number}}</h1>
                                    @else
                                    <h1>{{$thermo->number}}</h1>
                                    @endif
                            </div>
                            <div class="register-arc__data">
                                <span>{{$thermo->fridgeType->min_temp}}º/c até {{$thermo->fridgeType->max_temp}}º/c</span>
                                <div class="register-arc__data_temps">
                                    @if($thermo->average != null)
                                        <div>
                                            <h3 class="temperature normal" onclick="showEditTemp({{$thermo->id}},'m')">{{number_format($thermo->average->morning_temp , 1)}}</h3>
                                            <p>manhã</p>
                                        </div>
                                        <div>
                                            <h3 class="temperature normal" onclick="showEditTemp({{$thermo->id}},'t')">{{number_format($thermo->average->afternoon_temp , 1)}}</h3>
                                            <p>tarde</p>
                                        </div>
                                    @else
                                        <div>
                                            <h3 class="temperature normal" onclick="showEditTemp({{$thermo->id}},'m')">N/A</h3>
                                            <p>manhã</p>
                                        </div>
                                        <div>
                                            <h3 class="temperature normal" onclick="showEditTemp({{$thermo->id}},'t')">N/A</h3>
                                            <p>tarde</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @if(Session::has('impersonated'))
                            <div class="register-arc__info delete" data-toggle="modal" data-target="#deleteModal"
                                 data-item="{{ $thermo }}">
                                eliminar
                            </div>
                                @endif
                        </div>
                    @endif
                @endif
            @endforeach
        </div>
        <a class="btn btn-history" href="/frontoffice/records/temperatures/history">histórico</a>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">x</button>
                    <h4 class="modal-title">Apagar Termometro</h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn modal-del" id="delete-thermo">
                        <strong>Apagar</strong>
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <strong>Cancelar</strong>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <form action="/thermo/deletethermo" method="post" id="delete-form">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="delete"/>
        <input type="hidden" value="" name="id" id="thermo-id">
    </form>

    <!-- Info Modal -->
    <div id="info-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Info</h4>
                </div>
                <div class="modal-body" id="infomodal">
                    <!-- METE AQUI O TEXTO POR JS STICK LA PICE -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                </div>
            </div>

        </div>
    </div>

    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Editar Valor</h4>
                </div>
                <div class="modal-body" id="infomodal">
                    <form action="/frontoffice/editthermosvalue" method="POST">
                        {{ csrf_field() }}
                    <input id="dayTime" name="dayTime" type="hidden" value="">
                    <input id="idThermo" name="idThermo" type="hidden" value="">
                    <input  name="valor"  class="form-control" required>
                    <button type="submit" class="btn btn-primary">Editar</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <div id="modalName" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Editar Nome</h4>
                </div>
                <div class="modal-body" id="namemodal">
                    <form action="/frontoffice/editthermosname" method="POST">
                        {{ csrf_field() }}
                        <input id="idThermoName" name="idThermo" type="hidden" value="">
                       Nome : <input  name="name" class="form-control" >
                      Imei :  <input  name="imei" class="form-control" >
                      Tempo :  <input type="number" name="update" class="form-control" >
                        <button type="submit" class="btn btn-primary">Editar</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

@endsection

<script>

    function showEditName(id)
    {
        $('#modalName').modal('show');
        $('#idThermoName').val(id);
    }

    function showEditTemp(id,time)
    {
        $('#myModal').modal('show');
        $('#dayTime').val(time) ;
        $('#idThermo').val(id);
    }

    function showLastReads(id)
    {
        $('#infomodal').html('');
        $.get('/frontoffice/getlastreads/'+id, function( data ) {
            for(i=0;i<4;i++)
            {
           $('#infomodal').append('<tr></td><td>'+data[i]['temperature']+'------</td><td>'+data[i]['last_read']+'</td></tr>');
            }
        });

    }
    document.addEventListener('DOMContentLoaded', function () {
        $('#info-modal').on('show.bs.modal', function (event) {
            /* vê como fiz em baixo, se tiveres dificuldades apita */

        });


        $('#deleteModal').on('show.bs.modal', function (event) {
            const item = $(event.relatedTarget);
            const data = item.data('item');

            $(this).find('.modal-body').text(`Tem a certeza que quer apagar o seguinte termometro, ${data.fridgeType ? data.fridgeType.name : ''} n.º ${data.number}? `);

            $('#delete-thermo').on('click', function () {
                $('#thermo-id').val(data.id);
                $('#delete-form').submit();
            });

        });

        $("#deleteModal").on("hidden.bs.modal", function () {
            $('#delete-thermo').unbind('click');
        });

    }, false);

    setInterval(function(){window.location.reload()},100000);

</script>

