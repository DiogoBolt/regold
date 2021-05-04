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
            <img src="/img/reportPest.png">
        </div>
    </div>

    {{-- Go Back Button --}}
    <a class="back-btn" href="/frontoffice/documents/Controlopragas">
        <span class="back-btn__front"><strong>Voltar</strong></span>
        <span class="back-btn__back"><strong>Documentos Controlo Pragas</strong></span>
    </a>

    <h1 class="title">Manutenção</h1>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form id="form" action="/frontoffice/saveMaintenance" method="post">
                            {{ csrf_field() }}
                            @foreach($devices as $device)
                                @if($device->controlMain==null)
                                <div class="file">
                                    <div>
                                        <a type="button" data-toggle="modal" data-target="#myModal{{$device->id}}" >
                                            <img class="img-responsive" src="{{ URL::to('/') }}/img/reportPest.png">
                                        </a>
                                    </div>
                                    <div >
                                        Disp. {{$device->number_device}}-{{$device->type_device}}
                                    </div>
                                </div>
                                @else
                                <div class="file">
                                    <div>
                                        <a>
                                            <img class="devicePersonalized" src="{{ URL::to('/') }}/img/reportPest.png">
                                        </a>
                                    </div>
                                    <div>
                                        Disp. {{$device->number_device}}-{{$device->type_device}}
                                    </div>
                                </div>
                               {{-- @else
                                    <div class="file">
                                        <div>
                                            <a type="button" >
                                                <img class="devicePersonalized" src="{{ URL::to('/') }}/img/reportPest.png">
                                            </a>
                                        </div>
                                        <div >
                                            Disp. {{$device->number_device}}-{{$device->type_device}}
                                        </div>
                                    </div>--}}
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
                                    <option value="Roedores">Roedores</option>
                                    <option value="Blatella germanica">Blatella germanica</option>
                                    <option value="Blatella oriental">Blatella oriental</option>
                                    <option value="Blatella americana">Blatella americana</option>
                                    <option value="Formigas">Formigas</option>
                                    <option value="Insectos voadores">Insectos voadores</option>
                                </select>
                            </div>

                            <div id="subActiva" class="form-group" style="display: none">
                                Substância Activa:  <select class="form-control" name="subs_active" {{--onchange="payType(this)"--}}>
                                    <option disabled selected value="">Selecione o Isco</option>
                                    <option value="A-Cipermetrina">A-Cipermetrina</option>
                                    <option value="Clotiamidina">Clotiamidina</option>
                                    <option value="Imidaclopride">Imidaclopride</option>
                                    <option value="Telas de cola">Telas de cola</option>
                                    <option value="Brodifacume">Brodifacume</option>
                                    <option value="Bromadiolona">Bromadiolona</option>
                                    <option value="Difenacume">Difenacume</option>
                                    <option value="Fipronil">Fipronil</option>
                                    <option value="Tiametoxam">Tiametoxam</option>
                                </select>
                            </div>
                            <div id="typeSpecie" class="form-group" >
                                Ação Desenvolvida:  <select class="form-control" name="action">
                                    <option disabled selected value="">Selecione a Ação</option>
                                    <option value="Foi efetuada pulverização localizada">Foi efetuada pulverização localizada</option>
                                    <option value="Foi efetuada pulverização em locais apropriados">Foi efetuada pulverização em locais apropriados</option>
                                    <option value="Foi aplicado gel insecticida em locais apropriados">Foi aplicado gel insecticida em locais apropriados</option>
                                    <option value="Foi colocado raticida nos locais apropriados">Foi colocado raticida nos locais apropriados</option>
                                    <option value="Foi efetuada a pulverização e aplicado o gel insecticida">Foi efetuada a pulverização e aplicado o gel insecticida</option>
                                    <option value="Outra">Outra</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Recomendações: </label>
                                <textarea class="form-control" name="note"></textarea>
                            </div>
                            @if(count($devices)==count($checkDevices))
                            <div>
                                <button {{--type="button" data-toggle="modal" data-target="#myModal" --}} class="btn btn-add">Concluir</button>
                            </div>
                            @else
                                <div>
                                    <button disabled {{--type="button" data-toggle="modal" data-target="#myModal" --}} class="btn btn-add">Concluir</button>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--<div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">x</button>
                    <h4 class="modal-title" >PIN Cliente</h4>
                </div>
                <div class="modal-body">
                    <div class="codes" id="oneCode">
                        <div class="form-group">
                            Insira o Pin:
                            <input name="pin" class="form-control" type="password" placeholder="****" id="pin">
                            <label class="labelError" id="error" style="display: none">Pin Errado!</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="{{$client->ownerID}}" class="btn modal-del" onclick="verifyPin(this.id)">
                        <strong>Confirmar</strong>
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <strong>Cancelar</strong>
                    </button>
                </div>
            </div>
        </div>
    </div>--}}

    @foreach($devices as $device)
    <div class="modal fade" id="myModal{{$device->id}}" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">x</button>
                    <h4 class="modal-title" >Dispositivo {{$device->number_device}}-{{$device->type_device}}</h4>
                </div>
                <div class="modal-body">
                    <div class="codes" id="oneCode">
                        <div class="form-group">
                            Insira o código do dispositivo para aceder:
                            <input class="form-control" placeholder="Código do Dispositivo" id="{{$device->id}}">
                            <label class="labelError" id="error2" style="display: none">Código Errado!</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn_delete" data-item="{{ $device->id }}" href="/frontoffice/replaceDevice/{{ $device->id }}/{{$idReport}}">
                        Substituir
                    </a>
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

<script>
    function verifyCodeDeviceExist(id) {

        var code=document.getElementById(id).value;

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
                    document.getElementById("error2").style.display="inline";
                }
            }
        })
    }
</script>






