@extends('layouts.app')
   
@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/client/client-add.css') }}" rel="stylesheet">
@endsection

@section('content')
<script src="{{ URL::asset('/js/validations.js') }}"></script>
<div class="container-bar">
    <p class="container-bar_txt">Novo Cliente</p>
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
                    <form action="/clients/add" method="post" onsubmit="return validateForm()" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div id="ownerRegister" style="display:block">
                            <label class="add-label">Dados do Proprietário</label>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    Nome:<input class="form-control" placeholder="Nome" id='ownerName'  name="ownerName" required>
                                </div>
                                <div class="form-group">
                                        <input type="radio" name="sex" value="M" checked >Sr
                                        <input type="radio" name="sex" value="F">Sra
                               </div>
                            </div>   
                            <div class="col-sm-6">
                                <div class="form-group">
                                    E-Mail: <input class="form-control" placeholder="Insira o E-mail" type="email" id="loginMail" name="loginMail" required>
                                </div>
                                <div class="form-group">
                                    Password: <input class="form-control" type="password" placeholder="*********" id="password" name="password" required>
                                </div>
                            </div>  
                        </div>

                        <div  style="display:none" id="registeredOwner">
                            <label class="add-label">Dados do Proprietário</label>
                                <div class="form-group">
                                Insira o E-Mail da conta Registada: 
                                <input class="form-control" type="email" placeholder="Insira o E-mail" id="registedMail" name="registedMail" oninput="validateEmailExist(this)" >
                            </div>
                        </div>  
                          
                        <div class="form-group">
                            <label class='add-label'>Proprietário já com registo!
                                <input type="radio" onclick="ownerRegister(this)" name="verifyHaveRegister" value="sim">Sim
                                <input type="radio" onclick="ownerRegister(this)" name="verifyHaveRegister" checked="checked" value="nao">Não
                            </label> 
                        </div> 
                        <div>
                        <label class="add-label">Dados do Estabelecimento</label>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                Vendedor: <select class="form-control" name="salesman" required>
                                <option disabled selected value="">Selecione o Vendedor</option>
                                    @foreach($salesman as $sales)
                                       @if( $sales->id == Auth::user()->userTypeID )
                                          <option selected value="{{$sales->id}}">{{$sales->name}}</option>
                                        @else
                                            <option value="{{$sales->id}}">{{$sales->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                Nome Comercial:<input class="form-control" placeholder="Nome Comercial" name="name" required>
                            </div>

                            <div class="form-group">
                                <div class="form-group">
                                    Nome de Faturação:<input class="form-control" placeholder="Nome de Faturação" name="invoiceName" required>
                                </div>
                            </div>

                            <div class="form-group">
                                NIF: <input id="nif" class="form-control" type="number" pattern="[0-9]{9}" placeholder="Insira o NIF"  name="nif" required>
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
                                        <select name="city" id="selectCity" class="form-control" required>
                                            <option disabled selected value="">Selecione a Cidade</option>  
                                        </select>
                                </div>
                                <div class="form-group">    
                                    Código Postal:
                                        <input id="postal_code" class="form-control" name="postal_code" oninput="getParishName(this.value,this.id)" placeholder="7654-321" required>
                                        <label class="labelParish" id="labelParish" style="display:none"></label>
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
                                    Código Postal: <input class="form-control" name="invoicePostalCode" id="invoicePostalCode" placeholder="7654-321" oninput="getParishName(this.value,this.id)" >
                                    <label class="labelParish" id="labelParish" style="display:none" ></label>
                                </div>  
                                <div class="form-group">
                                    Rua e número da porta<input class="form-control" placeholder="Morada de Entrega" name="invoiceAddress" id="invoiceAddress">
                                </div>
                            </div>

                            <div id="EmailInvoice" class="form-group">
                                Email Faturação: <input class="form-control" id="ReceiptEmail"  placeholder="Insira o E-mail de Faturação" type="email" name="invoiceEmail" >
                            </div>
                            <label>Pretende usar o email de registo?
                                <input type="radio" name="VerifyEmail" onclick="showRegistedMail()"  value="true">Sim
                                <input type="radio" name="VerifyEmail" onclick="notshowRegistedMail()" checked="checked" value="false">Não
                            </label>

                            <div class="form-group">
                                Telefone: <input class="form-control" placeholder="9********/2********" type="tel" name="telephone" required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                Actividade do Cliente: <select class="form-control" name="activity" required>        
                                    <option disabled selected value="">Selecione a Atividade/Tipo de Cliente</option>
                                    
                                    @foreach($activityTypes as $activityType)
                                        <option value="{{$activityType->id}}">{{$activityType->designation}}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="form-group" id="clientType">
                                Tipo Cliente:
                                <br/>
                                <div id="serviceTypesDiv">
                                    @foreach($serviceTypes as $serviceType)
                                        <input type="checkbox" onclick="myfuncao(this.value)" id="serviceType{{$serviceType->id}}" name="serviceType{{$serviceType->id}}" value="{{$serviceType->id}}">{{$serviceType->name}}
                                        <br/> 
                                    @endforeach
                            </div>

                                <div id="contract" class="form-group" style="display: none">
                                    Tipo de contrato:  <select class="form-control" name="contract_type" {{--onchange="payType(this)"--}} required>
                                        <option disabled selected value="">Selecione o Tipo de Contrato</option>
                                        <option value="2">2 Visitas</option>
                                        <option value="3">3 Visitas</option>
                                        <option value="4">4 Visitas</option>
                                        <option value="6">6 Visitas</option>
                                        <option value="12">12 Visitas</option>
                                    </select>
                                </div>

                            <div class="form-group">
                                Valor Contrato: <input type="number" step="0.01" placeholder="Valor de Contrato" min=0 class="form-control" name="value">
                            </div>

                            <div class="form-group">
                                Método Pagamento:  <select class="form-control" name="payment_method" onchange="payType(this)" required>
                                        <option disabled selected value="">Selecione o Método de Pagamento</option>
                                        <option value="Debito Direto">Débito Direto</option>
                                        <option value="Contra Entrega">Contra Entrega</option>
                                        <option value="Tranferência/30dias">Tranferência/30 dias</option>
                                        <option value="Fatura Contra Fatura">Fatura Contra Fatura</option>
                                </select>
                            </div>

                            <div id="divNib" class="form-group" style="display:none" >
                                NIB: <input id="nib" type="number" placeholder="Insira o nib" class="form-control" type="number" name="nib">
                            </div>

                            <div class="form-group">
                                Id Regoldi <input type="number" class="form-control" name="regoldiID" >
                            </div>

                            <div class="form-group">
                                Informações/notas sobre o cliente <textarea class="form-control" placeholder="Informações/notas sobre o cliente" name="transport_note"></textarea>
                            </div>
                        </div>
                    <div>
                        <button class="btn btn-add" >Criar</button>
                    </div>
                        </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
