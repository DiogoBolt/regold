@extends('layouts.app')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/client/client-add.css') }}" rel="stylesheet">
@endsection

@section('content')
<script src="{{ URL::asset('/js/validations.js') }}"></script>
<div class="container-bar">
    <p class="container-bar_txt">Editar Cliente</p>
    <div class="container-bar_img">
        <img src="{{ asset('img/add-user.png') }}" />
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form action="/clients/edit"  method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input value="{{$client->id}}" style="display:none" name="id">
                        <div class="col-sm-6">
                            <div class="form-group">
                                Vendedor: <select class="form-control" name="salesman" required>
                                <option disabled selected value="">Selecione o Vendedor</option>
                                    @foreach($salesman as $sales)
                                        @if( $sales->id == $client->salesman)
                                          <option selected value="{{$sales->id}}">{{$sales->name}}</option>
                                        @else
                                            <option value="{{$sales->id}}">{{$sales->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                Nome Comercial:<input class="form-control" placeholder="Nome Comercial" name="name" value="{{$client->name}}" required>
                            </div>

                            <div class="form-group">
                                <div class="form-group">
                                    Nome de Faturação:<input class="form-control" placeholder="Nome de Faturação" value="{{$client->comercial_name}}" name="invoiceName" required>
                                </div>
                            </div>
                            <div class="form-group">
                                NIF: <input id="nif" class="form-control" type="number" pattern="[0-9]{9}" placeholder="Insira o NIF" value="{{$client->nif}}" name="nif" required>
                            </div>
                            <div class="form-group">
                                <b>Morada Entrega</b>
                                <br/>
                                <div class="form-group">
                                    Distrito: 
                                    <select id="selectDistrict" class="form-control" name="districts" onchange="listCities(this)" required>
                                    <option disabled  value="">Selecione o Distrito</option> 
                                        @foreach($districts as $district)
                                            @if($district->id == $client->district)
                                                <option selected value="{{$district->id}}">{{$district->name}}</option>
                                            @else
                                                <option value="{{$district->id}}">{{$district->name}}</option>
                                            @endif 
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group"> 
                                    Cidade:
                                        <select id="selectCity" class="form-control" name="city" required>
                                            <option disabled selected value="">Selecione a Cidade</option> 
                                            @foreach($client->allCities as $cities)
                                                @if($cities->id== $client->city)
                                                    <option  selected value="{{$cities->id}}">{{$cities->name}}</option> 
                                                @else
                                                    <option  value="{{$cities->id}}">{{$cities->name}}</option>
                                                @endif
                                            @endforeach 
                                        </select>
                                </div>
                                <div class="form-group">    
                                    Código Postal:
                                        <input id="postal_code" class="form-control" name="postal_code" oninput="getParishName(this.value,this.id)" value="{{$client->postal_code}}" required>
                                        <label class="labelParish" id="labelParish">{{$client->parish}}</label>
                                    </div>  
                                <div class="form-group">
                                    Rua e número da porta<input class="form-control" placeholder="Morada de Entrega" name="deliveryAddress"  value="{{$client->address}}"required> 
                                </div>
                            </div>
                            <div id="AddressInvoice" class="form-group" >
                                <b>Morada de Faturação</b>
                                <br/>
                                <div class="form-group">
                                    Distrito: 
                                    <select id="selectDistrictInvoice" class="form-control" name="districtsInvoice" onchange="listCities(this)">
                                        <option disabled selected value="">Selecione o distrito</option>
                                        @foreach($districts as $district)
                                            @if($district->id == $client->invoice_district)
                                                <option selected class="form-control" value="{{$district->id}}">{{$district->name}}</option>
                                            @else
                                            <option  class="form-control" value="{{$district->id}}">{{$district->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group"> 
                                    Cidade:
                                        <select id="selectCityInvoice" class="form-control" name="cityInvoice" >
                                            <option disabled selected value="">Selecione a Cidade</option>
                                            @foreach($client->allCitiesInvoice as $cities)
                                                @if($cities->id == $client->invoice_city)
                                                    <option  selected value="{{$cities->id}}">{{$cities->name}}</option> 
                                                @else
                                                    <option value="{{$cities->id}}">{{$cities->name}}</option>
                                                @endif
                                            @endforeach   
                                        </select>
                                </div>
                                <div class="form-group">    
                                    Código Postal: <input class="form-control" name="invoicePostalCode" id="invoicePostalCode" placeholder="7654-321" value="{{$client->invoice_postal_code}}" oninput="getParishName(this.value,this.id)" >
                                    <label class="labelParish" id="labelParish" >{{$client->parishInvoice}}</label>
                                </div>  
                                <div class="form-group">
                                    Rua e número da porta<input class="form-control" placeholder="Morada de Entrega" value="{{$client->invoice_address}}" name="invoiceAddress" id="invoiceAddress">
                                </div>
                            </div>
                             <div id="EmailInvoice" class="form-group">
                                Email Faturação: <input class="form-control" value="{{$client->receipt_email}}" placeholder="Insira o E-mail de Faturação" type="email" name="invoiceEmail" required >
                            </div>
                            <div class="form-group">
                                Telefone: <input class="form-control" value="{{$client->telephone}}" placeholder="9********/2********" type="tel" name="telephone" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                       {{-- <div class="form-group">
                            Actividade do Cliente: <select class="form-control" name="activity" required>
                                <option disabled  value="">Selecione a Atividade/Tipo de Cliente</option>
                                @foreach($activityTypes as $activityType)
                                    @if($activityType->id==$client->activity)
                                        <option selected value="{{$activityType->id}}">{{$activityType->designation}}</option>
                                    @else
                                        <option value="{{$activityType->id}}">{{$activityType->designation}}</option>
                                    @endif

                                        @endforeach
                            </select>
                        </div>--}}

                            <div class="form-group">
                                NIB: <input type="number" placeholder="Insira o nib" class="form-control" type="number" value="{{$client->nib}}" name="nib">
                            </div>
                            {{--<div class="form-group">
                                Tipo de Pack: <input type="number" placeholder="Insira o nib" class="form-control" type="number" value="{{$client->nib}}" name="nib">
                            </div>--}}
                            {{--<div class="form-group">
                                NIB: <input type="number" placeholder="Insira o nib" class="form-control" type="number" value="{{$client->nib}}" name="nib">
                            </div>--}}


                            <div class="form-group">
                                Valor Contrato: <input type="number" step="0.01" placeholder="Valor de Contrato" value="{{$client->contract_value}}" min=0 class="form-control" name="value">
                            </div>
                            <div class="form-group">
                                PVP acordado: <input type="number" step="1" placeholder="Pvp acordado" value="{{$client->pvp}}" min=1 class="form-control" name="pvp">
                            </div>
                            <div class="form-group">
                                Método Pagamento:  <select class="form-control" name="payment_method" value="siuihus" required>
                                        <option disabled selected value="">Selecione o Método de Pagamento</option>
                                        <option selected value="{{$client->payment_method}}">{{$client->payment_method}}</option>
                                        <option value="Debito Direto">Débito Direto</option>
                                        <option value="Contra Entrega">Contra Entrega</option>
                                        <option value="Tranferência">Tranferência</option>
                                        <option value="Fatura Contra Fatura">Fatura Contra Fatura</option>
                                        <option value="30 dias">30 dias</option>

                                </select>
                            </div>
                            <div class="form-group">
                                Id Regoldi <input type="number" value="{{$client->regoldiID}}" class="form-control" name="regoldiID" >
                            </div>

                            <div class="form-group">
                                Informações/notas sobre o cliente 
                                <textarea class="form-control" placeholder="Informações/notas sobre o cliente" name="transport_note">{{$client->transport_note}}</textarea>
                            </div>
                            <div id="EmailInvoice" class="form-group">
                                Email Registo: <input class="form-control" value="{{$user->email}}" placeholder="Insira o E-mail de Registo" type="email" name="email" required >
                            </div>
                            <label>Nova Password</label>
                            <div class="form-group">
                                Password: <input class="form-control" value="{{$client->password}}" type="password" name="password">
                            </div>
                            <label>Novo Pin</label>
                            <div class="form-group">
                                Pin: <input class="form-control" value="{{$client->pin}}" type="password" name="pin">
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-add" onsubmit="return validateForm(this)">Editar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


    <script>
        function validateForm() {
            alert("Hello");
            var x = $('#nif').value;
            if (!validateNIF(x)) {
                alert("NIF Errado");
                return false;
            }
        }
    </script>

@endsection
