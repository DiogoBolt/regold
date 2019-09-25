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
                                Nome Comercial:<input class="form-control"  name="name" required>
                            </div>
                            <div class="form-group">
                                Nome Faturação:<input class="form-control"  name="comercial_name" required>
                            </div>
                            <div class="form-group">
                                Morada Faturação:<input class="form-control" name="invoice_address" required>
                            </div>
                            <div class="form-group">
                                Morada Entrega:<input class="form-control" name="address">
                            </div>

                            <div class="form-group">
                                Cidade: <input class="form-control" name="city" required>
                            </div>
                            <div class="form-group">
                            Codigo Postal: <input class="form-control" name="postal_code" required>
                            </div>
                            <div class="form-group">
                                NIF: <input id="nif" class="form-control" type="number" name="nif" required>
                            </div>
                            <div class="form-group">
                                Email Contacto: <input class="form-control" type="email" name="email" required>
                            </div>
                            <div class="form-group">
                                Actividade:  Tipo Cliente: <select class="form-control" name="activity" required>
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
                                Metodo Pagamento:  <select class="form-control" name="payment_method" required>
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
                                    @foreach($salesman as $sales)
                                        <option value="{{$sales->id}}">{{$sales->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                Tipo Cliente: <input class="form-control" name="client_type" required>
                            </div>
                            <div class="form-group">
                                Email Faturação: <input class="form-control" type="email" name="receipt_email" required>
                            </div>
                            <div class="form-group">
                                NIB: <input class="form-control" type="number" name="nib">
                            </div>
                            <div class="form-group">
                                Password: <input class="form-control" type="password" name="password" required>
                            </div>

                            <div class="form-group">
                                Valor Contrato: <input class="form-control" name="value" required>
                            </div>

                            <div class="form-group">
                                Id Regoldi <input class="form-control" name="regoldiID" required>
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


    <script>

        function validateNIF(value) {
            const nif = typeof value === 'string' ? value : value.toString();
            const validationSets = {
                one: ['1', '2', '3', '5', '6', '8'],
                two: ['45', '70', '71', '72', '74', '75', '77', '79', '90', '91', '98', '99']
            };

            if (nif.length !== 9) {
                return false;
            }

            if (!validationSets.one.includes(nif.substr(0, 1)) && !validationSets.two.includes(nif.substr(0, 2))) {
                return false;
            }

            let total = nif[0] * 9 + nif[1] * 8 + nif[2] * 7 + nif[3] * 6 + nif[4] * 5 + nif[5] * 4 + nif[6] * 3 + nif[7] * 2;
            let modulo11 = (Number(total) % 11);

            const checkDigit = modulo11 < 2 ? 0 : 11 - modulo11;

            return checkDigit === Number(nif[8]);
        }

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
