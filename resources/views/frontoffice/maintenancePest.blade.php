@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('/css/documents/pest.css') }}" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="{{ mix('/css/app.css') }}">

@endsection

@section('content')

    <script src="{{ URL::asset('/js/report.js') }}"></script>

    <div class="container-bar">
        <p class="container-bar_txt">Relatório Manutenção</p>
        <div class="container-bar_img">
            <img src="/img/reportPest.png"></a>
        </div>
    </div>

    {{-- Go Back Button --}}
    <a class="back-btn" href="/frontoffice/documents/Controlopragas">
        <span class="back-btn__front"><strong>Voltar</strong></span>
        <span class="back-btn__back"><strong>Documentos Controlo Pragas</strong></span>
    </a>

    <h1 class="title">Manutenção/Garantia</h1>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form action="/frontoffice/saveMaintenance" method="post">
                            {{ csrf_field() }}

                            @foreach($devices as $device)
                                @if($device->controlMain==null)
                                <div class="file">
                                    <div>
                                        <a type="button" data-toggle="modal" data-target="#myModal{{$device->id}}">
                                            <img class="img-responsive" src="{{ URL::to('/') }}/img/reportPest.png">
                                        </a>
                                    </div>
                                    <div >
                                        Dispositivo {{$device->number_device}}
                                    </div>
                                </div>
                                @else
                                <div class="file">
                                    <div>
                                        <a>
                                            <img class="img-responsive" src="{{ URL::to('/') }}/img/reportPestRed.png">
                                        </a>
                                    </div>
                                    <div style="color: red">
                                        Dispositivo {{$device->number_device}}
                                    </div>
                                </div>
                                @endif
                            @endforeach

                            <a href="/frontoffice/newDevice" class="btn btn-add"><strong>Novo Dispositivo</strong></a>

                            <div>
                                <label>Foi detetada a presença de pragas?</label>
                            </div>
                            <div class="form-group">
                                <label for="bom">Sim</label>
                                <input type="radio" onclick="showOptions()" name="pest_presence" id="sim" value="sim" required>
                                <label for="satisfatorio">Não</label>
                                <input type="radio" onclick="notshowOptions()" checked="checked" name="pest_presence" id="nao" value="nao" required>
                            </div>

                            <div id="typeSpecie" class="form-group" style="display: none">
                                Tipo de Espécie:  <select class="form-control" name="type_specie" {{--onchange="payType(this)"--}} >
                                    <option disabled selected value="">Selecione a Espécie</option>
                                    <option value="Debito Direto">Débito Direto</option>
                                    <option value="Contra Entrega">Contra Entrega</option>
                                    <option value="Tranferência/30dias">Tranferência/30 dias</option>
                                    <option value="Fatura Contra Fatura">Fatura Contra Fatura</option>
                                </select>
                            </div>

                            <div id="subActiva" class="form-group" style="display: none">
                                Substância Activa:  <select class="form-control" name="subs_active" {{--onchange="payType(this)"--}}>
                                    <option disabled selected value="">Selecione a Espécie</option>
                                    <option value="Debito Direto">Débito Direto</option>
                                    <option value="Contra Entrega">Contra Entrega</option>
                                    <option value="Tranferência/30dias">Tranferência/30 dias</option>
                                    <option value="Fatura Contra Fatura">Fatura Contra Fatura</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Recomendações: </label>
                                <textarea class="form-control" name="note"></textarea>
                            </div>
                            <div>
                                <button class="btn btn-add">Concluir</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach($devices as $device)
    <div class="modal fade" id="myModal{{$device->id}}" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">x</button>
                    <h4 class="modal-title" >Dispositivo {{$device->number_device}}</h4>
                </div>
                <div class="modal-body">
                    <div class="codes" id="oneCode">
                        <div class="form-group">
                            Insira o código do dispositivo para aceder:
                            <input class="form-control" placeholder="Código do Dispositivo" id="cod_device">
                            <label class="labelError" id="error" style="display: none">Código Errado!</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="{{$device->id}}" class="btn modal-del" onclick="verifyCodeDeviceExist(this.id)">
                        <strong>Confirmar</strong>
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <strong>Cancelar</strong>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endforeach

@endsection

<script type="text/javascript" >



    function verifyCodeDeviceExist(id) {

        var code=document.getElementById('cod_device').value;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'GET',
            url:'/frontoffice/verifyCodeDeviceExist/'+id+'/'+code,
            async: false,
            success:function (data) {
                if(data==0) {
                    location.replace("/frontoffice/deviceMaintenance"+'/'+id);
                }else {
                    document.getElementById("cod_device").style.border="1px solid #ff0000";
                    document.getElementById("error").style.display="inline"
                }
            }
        })/*.then(
            window.location.replace('/frontoffice/maintenance')
        );*/
    }
</script>




