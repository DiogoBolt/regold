@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/index/client-index.css') }}" rel="stylesheet">
@endsection

@section('content')
<script src="{{ URL::asset('/js/validations.js') }}"></script>
    @if(!Session::has('impersonated'))
        @if(count($clients)>1)
            <div id=divSelectLoja>
                <div class="selectBox">
                    <select id="selectEstablishment" onchange="myFunction()">
                        @foreach($clients as $client)
                            @if(Session::get('establismentID')==$client->id)
                                <option selected value="{{$client->id}}">{{$client->name}}</option>
                            @else
                                <option value="{{$client->id}}">{{$client->name}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
        @endif
    @endif
    <section >
                        <div class="container index-box">
                            {{--@if($receiptsHACCP) <span class="notification">{{$receiptsHACCP}}</span> @endif--}}
                            @if($clientPermission->permission==1 || $clientPermission->permission== 2)
                            <a class="disabled" title="Documentos HACCP" href="/frontoffice/documents/HACCP"><img class="img-responsive" src="{{ URL::to('/') }}/img/index/Haccp.png">HACCP</a>
                            @else
                                <a class="box" title="Documentos HACCP" href="/frontoffice/documents/HACCP"><img class="img-responsive" src="{{ URL::to('/') }}/img/index/Haccp.png">HACCP</a>
                            @endif
                                {{--@if($receiptsCP) <span class="notification">{{$receiptsCP}}</span> @endif--}}
                                @if($clientPermission->permission==1 || $clientPermission->permission==3)
                                <a class="disabled" title="Controlo de Pragas" href="/frontoffice/documents/Controlopragas"><img class="img-responsive" src="{{ URL::to('/') }}/img/index/ControloPragas.png">CONTROLO DE PRAGAS</a>
                                @else
                                    <a class="box" title="Controlo de Pragas" href="/frontoffice/documents/Controlopragas"><img class="img-responsive" src="{{ URL::to('/') }}/img/index/ControloPragas.png">CONTROLO DE PRAGAS</a>
                                @endif

                                <a class="box" title="Produtos" href="/frontoffice/categories"><img class="img-responsive" src="{{ URL::to('/') }}/img/index/Produtos.png">PRODUTOS</a>

                                <a class="box" title="Encomendas" href="/frontoffice/orders">
                                    <img class="img-responsive" src="{{ URL::to('/') }}/img/index/Encomendas.png">ENCOMENDAS
                                </a>
                                {{--@if($receiptsReg) <span class="notification">{{$receiptsReg}}</span> @endif--}}
                                    <a class="box" title="Documentos Registos" href="/frontoffice/documents/Registos"><img class="img-responsive" src="{{ URL::to('/') }}/img/index/Registos.png">REGISTOS</a>

                              {{--  @if($receiptsCont) <span class="notification">{{$receiptsCont}}</span> @endif--}}
                                    <a class="box" title="Documentos Contabilisticos" href="/frontoffice/documents/Contabilistico"><img class="img-responsive" src="{{ URL::to('/') }}/img/index/DocumentosCont.png">DOCUMENTOS CONTABILISTICOS</a>
                        </div>
    </section>

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Informação</h4>
            </div>
            <form>
                <div class="modal-body">
                    <p>Deseja alterar a password fornecida?</p>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="col-xs-4">
                                <label for="new_pwd">Nova Password :</label>
                            </div>
                            <div class="col-xs-8">
                                <input id="new_pwd" type="password" placeholder="Nova Password" name="password" required>    
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="col-xs-4">
                                <label for="confirm_pwd">Confirmar Password :</label>
                            </div>
                            <div class="col-xs-8">
                                <input id="confirm_pwd" type="password" placeholder="Confirmar Nova Password" name="confirm" required>    
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div id="error" class="alert alert-danger" role="alert" style="display:none;"></div>
                        </div>
                        <div class="col-xs-12">
                            <div id="success" class="alert alert-success" role="alert" style="display:none;"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="change_pwd" class="btn btn-add">Alterar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

<script>

    document.addEventListener('DOMContentLoaded', function(){ 
        const changePasswordBtn = document.getElementById('change_pwd');
        const errorMsg = document.getElementById('error');
        const successMsg = document.getElementById('success');
    
        $.get('/frontoffice/firstlogin',  response => {   
            if (response === '1') $('#myModal').modal('show');
        });

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        changePasswordBtn.addEventListener('click', function(evt) {
            evt.preventDefault();
            const password = document.getElementById('new_pwd').value;
            const confirm = document.getElementById('confirm_pwd').value;

            $.ajax({
                type:'POST',
                url:'/frontoffice/changePassword',
                data:{password, confirm},
                success:function(response){
                    if(response.error) {
                        successMsg.style.display = 'none';
                        errorMsg.innerText = response.error;
                        errorMsg.style.display = 'block';
                    } else {
                        errorMsg.style.display = 'none';
                        successMsg.innerText = response.success;
                        successMsg.style.display = 'block';
                        setTimeout(function(){ $('#myModal').modal('hide'); }, 2000);
                    }
                }
            });
        });

    }, false);
    
</script>
        
