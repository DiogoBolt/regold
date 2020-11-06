@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/documents/hygiene.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-bar">
        <p class="container-bar_txt">
            REGISTOS DE HIGIENE
        </p>
        <div class="container-bar_img">
            <img src="/img/haccp_icon.png"/>
        </div>
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">Home</li>
            <li class="breadcrumb-item " aria-current="page">Documentos Registos</li>
            <li class="breadcrumb-item active" aria-current="page">Higiene</li>
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
            <p> registos de higiene </p>
            <p> {{$today}} </p>
    </div>

    <div class="register-container">
        <div class="tab">
            <button class="tablinks" onclick="openCity(event, 1)">Diário</button>
            <button class="tablinks" onclick="openCity(event, 2)">Semanal</button>
            <button class="tablinks" onclick="openCity(event, 3)">Quinzenal</button>
            <button class="tablinks" onclick="openCity(event, 4)">Mensal</button>
        </div>

        <form action="/frontoffice/records/hygiene/save" method="POST">
            <div id="1" class="tabcontent">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Area</th>
                        <th>Produto</th>
                        <th><input onClick="checkBoxes(this)" type="Checkbox" > Selecionar tudo</th>
                    </tr>
                    </thead>
                    @foreach($section->areas as $a )
                        @if($a->idCleaningFrequency==1)
                            <tbody>
                            <td>{{$a->designation}}</td>

                            <td>@foreach($products as $product)
                                    @if($a->idProduct==$product->id)
                                        <a href="/frontoffice/product/{{$product->id}}">{{$product->name}}</a>
                                    @endif
                                @endforeach</td>
                            <td><input  type="Checkbox" ></td>
                            </tbody>
                        @endif
                    @endforeach
                </table>

                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Equipamento</th>
                        <th>Produto</th>
                        <th><input onClick="checkBoxes(this)" type="Checkbox" > Selecionar tudo</th>
                    </tr>
                    </thead>
                    @foreach($section->equipments as $a )
                        @if($a->idCleaningFrequency==1)
                            <tbody>
                            <td>{{$a->designation}}</td>
                            <td>@foreach($products as $product)
                                    @if($a->idProduct==$product->id)
                                        <a href="/frontoffice/product/{{$product->id}}">{{$product->name}}</a>
                                    @endif
                                @endforeach</td>
                            <td><input  type="Checkbox" ></td>
                            </tbody>
                        @endif
                    @endforeach
                </table>
                <button id="savePersolize" class="btn-del" {{--onclick="saveEachPersonalize()"--}}>Guardar</button>
            </div>
            <div id="2" class="tabcontent">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Area</th>
                        <th>Produto</th>
                        <th><input  onClick="checkBoxes(this)" type="Checkbox" > Selecionar tudo</th>
                    </tr>
                    </thead>
                    @foreach($section->areas as $a )
                        @if($a->idCleaningFrequency==2)
                            <tbody>
                            <td>{{$a->designation}}</td>
                            <td>@foreach($products as $product)
                                    @if($a->idProduct==$product->id)
                                        <a href="/frontoffice/product/{{$product->id}}">{{$product->name}}</a>
                                    @endif
                                @endforeach</td>
                            <td><input type="Checkbox" ></td>
                            </tbody>
                        @endif
                    @endforeach
                </table>

                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Equipamento</th>
                        <th>Produto</th>
                        <th><input  onClick="checkBoxes(this)" type="Checkbox"> Selecionar tudo</th>
                    </tr>
                    </thead>
                    @foreach($section->equipments as $a )
                        @if($a->idCleaningFrequency==2)
                            <tbody>
                            <td>{{$a->designation}}</td>
                            <td>@foreach($products as $product)
                                    @if($a->idProduct==$product->id)
                                        <a href="/frontoffice/product/{{$product->id}}">{{$product->name}}</a>
                                    @endif
                                @endforeach</td>
                            <td><input type="Checkbox" ></td>
                            </tbody>
                        @endif
                    @endforeach
                </table>
                <button id="savePersolize" class="btn-del" {{--onclick="saveEachPersonalize()"--}}>Guardar</button>
            </div>
            <div id="3" class="tabcontent">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Area</th>
                        <th>Produto</th>
                        <th><input onClick="checkBoxes(this)" type="Checkbox" > Selecionar tudo</th>
                    </tr>
                    </thead>
                    @foreach($section->areas as $a )
                        @if($a->idCleaningFrequency==3)
                            <tbody>
                            <td>{{$a->designation}}</td>
                            <td>@foreach($products as $product)
                                    @if($a->idProduct==$product->id)
                                        <a href="/frontoffice/product/{{$product->id}}">{{$product->name}}</a>
                                    @endif
                                @endforeach</td>
                            <td><input  type="Checkbox" ></td>
                            </tbody>
                        @endif
                    @endforeach
                </table>

                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Equipamento</th>
                        <th>Produto</th>
                        <th><input  onClick="checkBoxes(this)" type="Checkbox" > Selecionar tudo</th>
                    </tr>
                    </thead>
                    @foreach($section->equipments as $a )
                        @if($a->idCleaningFrequency==3)
                            <tbody>
                            <td>{{$a->designation}}</td>
                            <td>@foreach($products as $product)
                                    @if($a->idProduct==$product->id)
                                        <a href="/frontoffice/product/{{$product->id}}">{{$product->name}}</a>
                                    @endif
                                @endforeach</td>
                            <td><input  type="Checkbox" ></td>
                            </tbody>
                        @endif
                    @endforeach
                </table>
                <button id="savePersolize" class="btn-del" {{--onclick="saveEachPersonalize()"--}}>Guardar</button>
            </div>
            <div id="4" class="tabcontent">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Area</th>
                        <th>Produto</th>
                        <th><input  onClick="checkBoxes(this)" type="Checkbox" > Selecionar tudo</th>
                    </tr>
                    </thead>
                    @foreach($section->areas as $a )
                        @if($a->idCleaningFrequency==4)
                            <tbody>
                            <td>{{$a->designation}}</td>
                            <td>@foreach($products as $product)
                                    @if($a->idProduct==$product->id)
                                        <a href="/frontoffice/product/{{$product->id}}">{{$product->name}}</a>
                                    @endif
                                @endforeach</td>
                            <td><input type="Checkbox" ></td>
                            </tbody>
                        @endif
                    @endforeach
                </table>

                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Equipamento</th>
                        <th>Produto</th>
                        <th><input  onClick="checkBoxes(this)" type="Checkbox" > Selecionar tudo</th>
                    </tr>
                    </thead>
                    @foreach($section->equipments as $a )
                        @if($a->idCleaningFrequency==4)
                            <tbody>
                            <td>{{$a->designation}}</td>
                            <td>@foreach($products as $product)
                                    @if($a->idProduct==$product->id)
                                        <a href="/frontoffice/product/{{$product->id}}">{{$product->name}}</a>
                                    @endif
                                @endforeach</td>
                            <td><input type="Checkbox" ></td>
                            </tbody>
                        @endif
                    @endforeach
                </table>
                <button id="savePersolize" class="btn-del" {{--onclick="saveEachPersonalize()"--}}>Guardar</button>
            </div>
        </form>


    </div>

<script>
    function openCity(evt, id) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(id).style.display = "block";
        evt.currentTarget.className += " active";
    }
    checkBoxes = function (me) {
        $(me).closest("table").find('input[type="checkbox"]').not(me).prop('checked', me.checked);
    }
</script>

@endsection