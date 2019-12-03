@extends('layouts.app')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/client/client-add.css') }}" rel="stylesheet">
@endsection

@section('content')
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
                                Nome de Faturação:<input class="form-control" placeholder="Nome de Faturação" name="name" required>
                            </div>
                            </div>

                            <div class="form-group">
                                Morada Entrega
                                <br/>
                                    Distrito: 
                                    <select id="selectDistrict" class="form-control" name="districts" onchange="listCities(this)" required>
                                        <option disabled selected value="">Selecione o distrito</option>
                                        @foreach($districts as $district)
                                            <option value="{{$district->id}}">{{$district->name}}</option>
                                        @endforeach
                                    </select>
                                    Cidade:
                                        <select id="selectCity" class="form-control" name="cities" required>
                                            <option disabled selected value="">Selecione a Cidade</option>  
                                        </select>
                                    Rua e número da porta<input class="form-control" placeholder="Morada de Entrega" name="invoice_address" required>
                                    Código Postal: <input placeholder="7654-321" oninput="teste(this)" class="form-control" name="postal_code" required>
                                        <label>Pretende usar a morada de entrega como morada de faturação?
                                            <input type="radio" name="VerifyAdress" onclick="notshowAddressBilling()" checked="checked" value="sim">Sim
                                            <input type="radio" name="VerifyAdress" onclick="showAddressBilling()" value="nao">Não
                                        </label>   
                                </div>
                           
                            <div id="AddressBilling" class="form-group"  style="display:none">
                                Morada de Faturação
                                <br/>
                                    Distrito: 
                                    <select id="selectDistrict" class="form-control" name="districts" onchange="listCities(this)" required>
                                        <option disabled selected value="">Selecione o distrito</option>
                                        @foreach($districts as $district)
                                            <option value="{{$district->id}}">{{$district->name}}</option>
                                        @endforeach
                                    </select>
                                    Cidade:
                                        <select id="selectCity" class="form-control" name="cities" required>
                                            <option disabled selected value="">Selecione a Cidade</option>  
                                        </select>
                                    Rua e número da porta<input class="form-control" placeholder="Morada de Entrega" name="invoice_address" required>
                                    Codigo Postal: <input type="number" id="postalCode" class="form-control" name="postal_code" required>
                                </div>

                             <script>
                                function showAddressBilling(){
                                    document.getElementById("AddressBilling").style.display="block";
                                }
                                function notshowAddressBilling(){
                                    document.getElementById("AddressBilling").style.display="none";
                                }
                                function showEmail(){
                                    document.getElementById("EmailBilling").style.display="block";
                                }
                                function notshowEmail(){
                                    document.getElementById("EmailBilling").style.display="none";
                                }

                                function teste(postalCode){
                                   /* var count = (postalCode.value.match(/\d/g) || []).length
                                    console.log("... "+ count);
                                   console.log("pedro  "+ postalCode.value);
                                   console.log("pedro  "+ postalCode.value.length);
                                   if(count==4){
                                       postalCode.value=postalCode.value+"-";
                                   }*/
                                }
                            </script>

                           
                            <script>
                                function listCities(idCity){
                                    //aqui chamar pedro
                                    var selectCity = document.getElementById("selectCity");
                                    while (selectCity.firstChild) {
                                        selectCity.removeChild(selectCity.firstChild);
                                    } 
                                    var optionCity =  document.createElement("option");
                                    var id=idCity.value; 
                                    optionCity.text="Selecione a Cidade";
                                    optionCity.disable=true;
                                    selectCity.appendChild(optionCity);
                                        $.ajax({
                                            type:'GET',
                                            url:'/users/getCities/'+id,
                                        }).done(function(data){
                                            console.log(data);
                                            console.log(data[1].id);
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

                             <div id="EmailBilling" class="form-group" style="display:none" >
                                Email Faturação: <input class="form-control" type="email" name="receipt_email" required>
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
                                Telefone: <input class="form-control" type="tel"  name="telephone" required>
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
                                @foreach($serviceTypes as $serviceType)
                                    <input type="checkbox" name="serviceType" value="{{$serviceType->id}}">{{$serviceType->name}}
                                    <br/>
                                 @endforeach
                                <br/>
                                
                            </div>
                            <div class="form-group">
                                NIB: <input type="number" class="form-control" type="number" name="nib">
                            </div>
                            <div class="form-group">
                                Password: <input class="form-control" type="password" name="password" required>
                            </div>

                            <div class="form-group">
                                Valor Contrato: <input type="number" class="form-control" name="value" required>
                            </div>

                            <div class="form-group">
                                Id Regoldi <input type="number" class="form-control" name="regoldiID" >
                            </div>

                            <div class="form-group">
                                Nota Transporte <textarea class="form-control" name="transport_note"></textarea>
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
