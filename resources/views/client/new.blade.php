@extends('layouts.app')
   
@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/client/client-add.css') }}" rel="stylesheet">
@endsection

@section('content')
<script src="\..\..\public\js\validations.js"></script> 
<div class="container-bar">
    <p class="container-bar_txt">novo cliente</p>
    <div class="container-bar_img">
        <img src="{{ asset('img/add-user.png') }}" />
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div>
                        <img class="img-responsive add-img" src="/img/navbar/logoindexcolor.png"/>
                    </div>
                    <form action="/clients/add"  method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="col-sm-6">
                            <div class="form-group">
                                Nome Comercial:<input class="form-control" placeholder="Nome Comercial"  name="name" required>
                            </div>

                            <div class="form-group">
                                <div class="form-group">
                                    Nome de Faturação:<input class="form-control" placeholder="Nome de Faturação" name="invoiceName">
                                </div>
                            </div>
                            <div class="form-group">
                                Morada Entrega
                                <br/>
                                <div class="form-group">
                                    Distrito: 
                                    <select id="selectDistrict" class="form-control" name="districts" onchange="listCities(this)" required>
                                        <option disabled selected value="">Selecione o distrito</option>
                                        @foreach($districts as $district)
                                            <option  class="form-control" value="{{$district->id}}">{{$district->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group"> 
                                    Cidade:
                                        <select id="selectCity" class="form-control" name="city" required>
                                            <option disabled selected value="">Selecione a Cidade</option>  
                                        </select>
                                </div>
                                <div class="form-group">    
                                    Código Postal:
                                    <br/>
                                     <label>
                                        <input placeholder="7654-321" pattern="[0-9]{4}-[0-9]{3}"  oninput="teste()" class="form-control" name="postal_code" required>
                                    </label>
                                </div>  
                                <div class="form-group">
                                    Rua e número da porta<input class="form-control" placeholder="Morada de Entrega" name="deliveryAddress" required>
                                    <label>Pretende usar a morada de entrega como morada de faturação?
                                            <input type="radio" name="VerifyAdress" onclick="notshowAddressInvoice()" checked="checked" value="sim">Sim
                                            <input type="radio" name="VerifyAdress" onclick="showAddressInvoice()" value="nao">Não
                                        </label> 
                                </div>
                            </div>
                            <div id="AddressInvoice" class="form-group"  style="display:none">
                                Morada de Faturação
                                <br/>
                                <div class="form-group">
                                    Distrito: 
                                    <select id="selectDistrictInvoice" class="form-control" name="districtsInvoice" onchange="listCities(this)">
                                        <option disabled selected value="">Selecione o distrito</option>
                                        @foreach($districts as $district)
                                            <option  class="form-control" value="{{$district->id}}">{{$district->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group"> 
                                    Cidade:
                                        <select id="selectCityInvoice" class="form-control" name="cityInvoice" >
                                            <option disabled selected value="">Selecione a Cidade</option>  
                                        </select>
                                </div>
                                <div class="form-group">    
                                    Código Postal: <input placeholder="7654-321"  pattern="[0-9]{4}-[0-9]{3}" oninput="teste(this)" class="form-control" name="invoicePostalCode">
                                </div>  
                                <div class="form-group">
                                    Rua e número da porta<input class="form-control" placeholder="Morada de Entrega" name="invoiceAddress">
                                </div>
                               
                            </div>

                             <script>
                                function showAddressInvoice(){
                                    document.getElementById("AddressInvoice").style.display="block";
                                }
                                function notshowAddressInvoice(){
                                    document.getElementById("AddressInvoice").style.display="none";
                                }
                                function showEmail(){
                                    document.getElementById("EmailInvoice").style.display="block";
                                }
                                function notshowEmail(){
                                    document.getElementById("EmailInvoice").style.display="none";
                                }
                            </script>

                            <script>
                                function listCities(cityObj){
                                        //aqui chamar pedro
                                    if(cityObj.id == "selectDistrict"){
                                        var selectCity = document.getElementById("selectCity");
                                        while (selectCity.firstChild) {
                                            selectCity.removeChild(selectCity.firstChild);
                                        } 
                                    }else{
                                        var selectCity = document.getElementById("selectCityInvoice");
                                        while (selectCity.firstChild) {
                                            selectCity.removeChild(selectCity.firstChild);
                                        } 
                                    }
                                    
                                    var optionCity =  document.createElement("option");
                                    var id=cityObj.value; 
                                    optionCity.text="Selecione a Cidade";
                                    optionCity.disable=true;
                                    selectCity.appendChild(optionCity);
                                        $.ajax({
                                            type:'GET',
                                            url:'/users/getCities/'+id,
                                        }).done(function(data){
                                            for(var i=0; i<data.length;i++){
                                                var optionCity =  document.createElement("option");
                                                optionCity.value=data[i].id; 
                                                optionCity.text=data[i].name;
                                                optionCity.disable=true;
                                                selectCity.appendChild(optionCity);
                                            }
                                        });
                                    }
                            </script>
                            <div class="form-group">
                                NIF: <input id="nif" class="form-control" type="number" name="nif" required>
                            </div>
                            <div class="form-group">
                                E-mail Contacto: <input class="form-control" type="email" name="email" required>
                                <div>
                                    <label>Pretende usar o E-mail de Contacto como E-mail de Faturação?
                                        <input type="radio" name="VerifyEmail" onclick="notshowEmail()"checked="checked" value="sim">Sim
                                        <input type="radio" name="VerifyEmail" onclick="showEmail()" value="nao">Não
                                    </label>
                                </div>
                            </div>

                             <div id="EmailInvoice" class="form-group" style="display:none" >
                                Email Faturação: <input class="form-control" type="email" name="invoiceEmail" >
                            </div>
                            <div class="form-group">
                                Actividade:  Tipo Cliente: <select class="form-control" name="activity" required>
                                    
                                    <option disabled selected value="">Selecione a Atividade/Tipo de Cliente</option>
                                    <option value="Cafe / Snack Bar">Cafe / Snack Bar</option>
                                    <option value="Salão de Chá">Salão de Chá</option>
                                    <option value="Supermercado">Supermercado</option>
                                    <option value="Peixaria">Peixaria</option>
                                    <option value="Talho">Talho</option>
                                    <option value="Restaurante">Restaurante</option>
                                    <option value="Industria">Industria</option>
                                    <option value="Hotel">Hotel</option>
                                    <option value="Outro">Outro</option>
                                    <option value="Posto Combustivel">Posto Combustivel</option>
                                    <option value="Padaria / Pastelaria">Padaria / Pastelaria</option>
                                </select>
                            </div>
                            <div class="form-group">
                                Telefone: <input class="form-control" placeholder="9********/2********" type="tel" pattern="[0-9]{9}" name="telephone" required>
                            </div>
                            <div class="form-group">
                                Método Pagamento:  <select class="form-control" name="payment_method" required>
                                        <option disabled selected value="">Selecione o Meétodo de Pagamento</option>
                                        <option value="Debito Direto">Débito Direto</option>
                                        <option value="Contra Entrega">Contra Entrega</option>
                                        <option value="Fatura Contra Fatura">Fatura Contra Fatura</option>
                                        <option value="30 dias">30 dias</option>

                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                Vendedor: <select class="form-control" name="salesman" required>
                                <option disabled selected value="">Selecione o Vendedor</option>
                                    @foreach($salesman as $sales)
                                        <option value="{{$sales->id}}">{{$sales->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                Tipo Cliente:
                                <br/>
                                <fieldset>
                                @foreach($serviceTypes as $serviceType)
                                    <input type="checkbox" name="serviceType{{$serviceType->id}}" value="{{$serviceType->id}}">{{$serviceType->name}}
                                    <br/>
                                </fieldset>    
                                 @endforeach
                                
                            </div>
                            <div class="form-group">
                                NIB: <input type="number" class="form-control" type="number" name="nib">
                            </div>
                            <div class="form-group">
                                Password: <input class="form-control" type="password" name="password" required>
                            </div>

                            <div class="form-group">
                                Valor Contrato: <input type="number" placeholder="Valor de Contrato" min=0 class="form-control" name="value" required>
                            </div>

                            <div class="form-group">
                                Id Regoldi <input type="number" class="form-control" name="regoldiID" >
                            </div>

                            <div class="form-group">
                                Informações/notas sobre o cliente <textarea class="form-control" name="transport_note"></textarea>
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-add" onsubmit="return validateForm(this)">Criar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
