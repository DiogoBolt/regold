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
        @if(session()->has('message'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">x</button>
                {{ session()->get('message') }}
            </div>
        @endif
        @if($errors->any())
            <h4 class="high">{{$errors->first()}}</h4>
        @endif
        <div class="register-info">
            <p> registos de higiene </p>
            <p> {{$today}} </p>
    </div>

    <div class="register-container">
        <div class="tab">
            <button class="tablinks active"  onclick="openFrequency(event, 1)">Diário</button>
            <button class="tablinks" onclick="openFrequency(event, 2)">Semanal</button>
            <button class="tablinks" onclick="openFrequency(event, 3)">Quinzenal</button>
            <button class="tablinks" onclick="openFrequency(event, 4)">Mensal</button>
        </div>

       {{-- @if(isset($section->areas)||isset($section->equipments))--}}
            <div id="1" class="tabcontent" style="display: block">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Área</th>
                        <th>Secção</th>
                        <th>Produto</th>
                        <th><input onClick="checkBoxes(this)" type="Checkbox"> Selecionar tudo</th>
                    </tr>
                    </thead>
                    @foreach($areasDaily as $area )

                            <tbody>
                            <td>{{$area->designation}}</td>
                            <td>@foreach($clientSections as $clientSection)
                                    @if($area->idSection==$clientSection->id)
                                        {{$clientSection->designation}}
                                    @endif
                                @endforeach
                            </td>
                            <td>@foreach($products as $product)
                                    @if($area->idProduct==$product->id)
                                        <a href="/frontoffice/product/{{$product->id}}">{{$product->name}}</a>
                                    @endif
                                @endforeach</td>
                            <td><input name="checkbox[]" type="checkbox" id="{{$area->designation}}" value='{"idArea":{{$area->id}},"idProduct":{{$area->idProduct}},"designation":"{{$area->designation}}","idCleaningFrequency":{{$area->idCleaningFrequency}}}'></td>
                            </tbody>

                    @endforeach
                </table>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Equipamento</th>
                        <th>Secção</th>
                        <th>Produto</th>
                        <th><input onClick="checkBoxes(this)" type="checkbox" > Selecionar tudo</th>
                    </tr>
                    </thead>
                    @foreach($equipDaily as $equip )

                            <tbody>
                            <td>{{$equip->designation}}</td>
                            <td>@foreach($clientSections as $clientSection)
                                    @if($equip->idSection==$clientSection->id)
                                        {{$clientSection->designation}}
                                    @endif
                                @endforeach
                            </td>
                            <td>@foreach($products as $product)
                                    @if($equip->idProduct==$product->id)
                                        <a href="/frontoffice/product/{{$product->id}}">{{$equip->idProduct}}{{$product->name}}</a>
                                    @endif
                                @endforeach</td>
                            <td><input name="checkbox[]" type="checkbox" id="{{$equip->designation}}" value='{"idEquipment":{{$equip->id}},"idProduct":{{$equip->idProduct}},"designation":"{{$equip->designation}}","idCleaningFrequency":{{$equip->idCleaningFrequency}}}'></td>
                            </tbody>

                    @endforeach
                </table>
                <button id="savePersolize" class="btn-recordHygiene" onclick="saveRecordHygiene()" {{--onclick="saveEachPersonalize()"--}}>Guardar</button>
            </div>


            <div id="2" class="tabcontent">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Área</th>
                        <th>Secção</th>
                        <th>Produto</th>
                        <th><input  onClick="checkBoxes(this)" type="checkbox" > Selecionar tudo</th>
                    </tr>
                    </thead>
                    @foreach($areasWeekly as $area )

                            <tbody>
                            <td>{{$area->designation}}</td>
                            <td>@foreach($clientSections as $clientSection)
                                    @if($area->idSection==$clientSection->id)
                                        {{$clientSection->designation}}
                                    @endif
                                @endforeach
                            </td>
                            <td>@foreach($products as $product)
                                    @if($area->idProduct==$product->id)
                                        <a href="/frontoffice/product/{{$product->id}}">{{$product->name}}</a>
                                    @endif
                                @endforeach</td>
                            <td><input name="checkbox[]" type="checkbox" id="{{$area->designation}}" value='{"idArea":{{$area->id}},"idProduct":{{$area->idProduct}},"designation":"{{$area->designation}}","idCleaningFrequency":{{$area->idCleaningFrequency}}}'></td>
                            </tbody>

                    @endforeach
                </table>

                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Equipamento</th>
                        <th>Secção</th>
                        <th>Produto</th>
                        <th><input  onClick="checkBoxes(this)" type="checkbox"> Selecionar tudo</th>
                    </tr>
                    </thead>
                    @foreach($equipWeekly as $equip )

                            <tbody>
                            <td>{{$equip->designation}}</td>
                            <td>@foreach($clientSections as $clientSection)
                                    @if($equip->idSection==$clientSection->id)
                                        {{$clientSection->designation}}
                                    @endif
                                @endforeach
                            </td>
                            <td>@foreach($products as $product)
                                    @if($equip->idProduct==$product->id)
                                        <a href="/frontoffice/product/{{$product->id}}">{{$product->name}}</a>
                                    @endif
                                @endforeach</td>
                            <td><input name="checkbox[]" type="checkbox" id="{{$equip->designation}}" value='{"idEquipment":{{$equip->id}},"idProduct":{{$equip->idProduct}},"designation":"{{$equip->designation}}","idCleaningFrequency":{{$equip->idCleaningFrequency}}}'></td>
                            </tbody>

                    @endforeach
                </table>
                <button id="savePersolize" class="btn-recordHygiene" onclick="saveRecordHygiene()" {{--onclick="saveEachPersonalize()"--}}>Guardar</button>
            </div>
            <div id="3" class="tabcontent">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Área</th>
                        <th>Secção</th>
                        <th>Produto</th>
                        <th><input onClick="checkBoxes(this)" type="checkbox" > Selecionar tudo</th>
                    </tr>
                    </thead>
                    @foreach($areasBiweekly as $area )

                            <tbody>
                            <td>{{$area->designation}}</td>
                            <td>@foreach($clientSections as $clientSection)
                                    @if($area->idSection==$clientSection->id)
                                        {{$clientSection->designation}}
                                    @endif
                                @endforeach
                            </td>
                            <td>@foreach($products as $product)
                                    @if($area->idProduct==$product->id)
                                        <a href="/frontoffice/product/{{$product->id}}">{{$product->name}}</a>
                                    @endif
                                @endforeach</td>
                            <td><input name="checkbox[]" type="checkbox" id="{{$area->designation}}" value='{"idArea":{{$area->id}},"idProduct":{{$area->idProduct}},"designation":"{{$area->designation}}","idCleaningFrequency":{{$area->idCleaningFrequency}}}'></td>
                            </tbody>

                    @endforeach
                </table>

                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Equipamento</th>
                        <th>Secção</th>
                        <th>Produto</th>
                        <th><input  onClick="checkBoxes(this)" type="checkbox" > Selecionar tudo</th>
                    </tr>
                    </thead>
                    @foreach($equipBiweekly as $equip )

                            <tbody>
                            <td>{{$equip->designation}}</td>
                            <td>@foreach($clientSections as $clientSection)
                                    @if($equip->idSection==$clientSection->id)
                                        {{$clientSection->designation}}
                                    @endif
                                @endforeach
                            </td>
                            <td>@foreach($products as $product)
                                    @if($equip->idProduct==$product->id)
                                        <a href="/frontoffice/product/{{$product->id}}">{{$product->name}}</a>
                                    @endif
                                @endforeach</td>
                            <td><input name="checkbox[]" type="checkbox" id="{{$equip->designation}}" value='{"idEquipment":{{$equip->id}},"idProduct":{{$equip->idProduct}},"designation":"{{$equip->designation}}","idCleaningFrequency":{{$equip->idCleaningFrequency}}}'></td>
                            </tbody>

                    @endforeach
                </table>
                <button id="savePersolize" class="btn-recordHygiene" onclick="saveRecordHygiene()" {{--onclick="saveEachPersonalize()"--}}>Guardar</button>
            </div>
            <div id="4" class="tabcontent">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Área</th>
                        <th>Secção</th>
                        <th>Produto</th>
                        <th><input  onClick="checkBoxes(this)" type="checkbox"> Selecionar tudo</th>
                    </tr>
                    </thead>
                    @foreach($areasMonthly as $area )

                            <tbody>
                            <td>{{$area->designation}}</td>
                            <td>@foreach($clientSections as $clientSection)
                                    @if($area->idSection==$clientSection->id)
                                        {{$clientSection->designation}}
                                    @endif
                                @endforeach
                            </td>
                            <td>@foreach($products as $product)
                                    @if($area->idProduct==$product->id)
                                        <a href="/frontoffice/product/{{$product->id}}">{{$product->name}}</a>
                                    @endif
                                @endforeach</td>
                            <td><input name="checkbox[]" type="checkbox" id="{{$area->designation}}" value='{"idArea":{{$area->id}},"idProduct":{{$area->idProduct}},"designation":"{{$area->designation}}","idCleaningFrequency":{{$area->idCleaningFrequency}}}'></td>
                            </tbody>

                    @endforeach
                </table>

                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Equipamento</th>
                        <th>Secção</th>
                        <th>Produto</th>
                        <th><input  onClick="checkBoxes(this)" type="checkbox" > Selecionar tudo</th>
                    </tr>
                    </thead>
                    @foreach($equipMonthly as $equip )

                            <tbody>
                            <td>{{$equip->designation}}</td>
                            <td>@foreach($clientSections as $clientSection)
                                    @if($equip->idSection==$clientSection->id)
                                        {{$clientSection->designation}}
                                    @endif
                                @endforeach
                            </td>
                            <td>@foreach($products as $product)
                                    @if($equip->idProduct==$product->id)
                                        <a href="/frontoffice/product/{{$product->id}}">{{$product->name}}</a>
                                    @endif
                                @endforeach</td>
                            <td><input name="checkbox[]" type="checkbox" id="{{$equip->designation}}" value='{"idEquipment":{{$equip->id}},"idProduct":{{$equip->idProduct}},"designation":"{{$equip->designation}}","idCleaningFrequency":{{$equip->idCleaningFrequency}}}'></td>
                            </tbody>

                    @endforeach
                </table>
                <button id="savePersolize" onclick="saveRecordHygiene()" class="btn-recordHygiene" {{--onclick="saveEachPersonalize()"--}}>Guardar</button>
            </div>
        <a class="btn-history"  href="/frontoffice/records/hygiene/history">Histórico</a>
    </div>
           {{-- @else
                <h2 class="text-center margin-top">Sem áreas e equipamentos registados. Nessário criar secções, áreas e equipamentos</h2>
            @endif--}}


<script>
    function openFrequency(evt, id) {
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

    function saveRecordHygiene() {
        var allCheckboxes=[];
        var checkboxes=document.getElementsByName('checkbox[]');
        var areaSize=checkboxes.length;

        for (var i=0;i<areaSize;i++){
            if(checkboxes[i].checked){
                var values = JSON.parse(checkboxes[i].value);
                var checkbox={};
                checkbox.checked=checkboxes[i].id;
                checkbox.idArea=values['idArea'];
                checkbox.idEquipment=values['idEquipment'];
                checkbox.designation=values['designation'];
                checkbox.idProduct=values['idProduct'];
                checkbox.idCleaningFrequency=values['idCleaningFrequency']
                checkbox.designation=values['designation'];
                allCheckboxes.push(checkbox);
            }
        }
        var checkboxesJson = JSON.stringify(allCheckboxes);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: "/frontoffice/records/hygiene/save",
            data:{checkBoxes: checkboxesJson}
        }).done(
            setTimeout(function(){
                window.location.replace('/frontoffice/records/hygiene');
            },1000)
        );

    }
</script>


@endsection