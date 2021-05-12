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

    <div id="rr" class="register-container">
        <div class="tab">
            <button class="tablinks active" onclick="openFrequency(event, 1)">Diário</button>
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
                        <th>Obs</th>
                        <th><input onClick="checkBoxes(this)" type="Checkbox"></th>
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
                                    @if($area->productId==$product->id)
                                        <a href="/frontoffice/product/{{$product->id}}">{{$product->name}}</a>
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                <span class="show-info" data-toggle="modal" data-target="#info-modal" onclick="showObservation({{$area->id}},'a')"><i class="glyphicon glyphicon-info-sign"></i></span>
                            </td>
                            <td><input name="checkbox[]" type="checkbox" id="{{$area->designation}}" value='{"idArea":{{$area->id}},"idProduct":{{$area->productId}},"designation":"{{$area->designation}}","idSection":"{{$area->idSection}}","idCleaningFrequency":1}'></td>
                            </tbody>
                    @endforeach
                </table>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Equipamento</th>
                        <th>Secção</th>
                        <th>Produto</th>
                        <th>Obs</th>
                        <th><input onClick="checkBoxes(this)" type="checkbox" ></th>
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
                                    @if($equip->productId==$product->id)
                                        <a href="/frontoffice/product/{{$product->id}}">{{$equip->idProduct}}{{$product->name}}</a>
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                <span class="show-info" data-toggle="modal" data-target="#info-modal" onclick="showObservation({{$equip->id}},'e')" ><i class="glyphicon glyphicon-info-sign"></i></span>
                            </td>
                            <td><input name="checkbox[]" type="checkbox" id="{{$equip->designation}}" value='{"idEquipment":{{$equip->id}},"idProduct":{{$equip->productId}},"designation":"{{$equip->designation}}","idSection":"{{$equip->idSection}}","idCleaningFrequency":1}'></td>
                            </tbody>
                    @endforeach
                </table>
                <button class="btn btn-Val" onclick="saveRecordHygiene()">Validar</button>
                <a class="btn-history"  href="/frontoffice/records/hygiene/history">Histórico</a>
            </div>


        <div class="tabcontent" id="table-area" style="display: none">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Área</th>
                    <th>Secção</th>
                    <th>Produto</th>
                    <th>Obs</th>
                    <th><input onClick="checkBoxes(this)" type="Checkbox"></th>
                </tr>
                </thead>
                <tbody id="tbody-area">

                </tbody>
            </table>
        </div>


        <div class="tabcontent" id="table-equip" style="display: none">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Equipamento</th>
                    <th>Secção</th>
                    <th>Produto</th>
                    <th>Obs</th>
                    <th><input onClick="checkBoxes(this)" type="Checkbox"></th>
                </tr>
                </thead>
                <tbody id="tbody-equip">

                </tbody>
            </table>
            <button class="btn btn-Val" onclick="saveRecordHygiene()">Validar</button>
            <a class="btn-history" href="/frontoffice/records/hygiene/history">Histórico</a>
        </div>

        <div id="info-modal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Info</h4>
                    </div>
                    <div class="modal-body" id="infomodal">
                        <!-- METE AQUI O TEXTO POR JS STICK LA PICE -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    </div>
                </div>

            </div>
        </div>


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
        evt.currentTarget.className += " active";

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'GET',
            url: "/frontoffice/records/hygieneFreq/" + id,
        }).done(function (data) {
            $('#tbody-area').empty()
            $('#tbody-equip').empty()
            $('#table-area').css("display", "block")
            $('#table-equip').css("display", "block")
            for(var i=0;i<data[0].length;i++ ) {
                $('#tbody-area').append(`
                    <tr>
                        <td>${data[0][i].designation}</td>
                        <td>${data[0][i].sectionDesignation}</td>
                        <td><a href="/frontoffice/product/${data[0][i].productId}">${data[0][i].productName}</a></td>
                        <td><span class="show-info" data-toggle="modal" data-target="#info-modal" onclick="showObservation(${data[0][i].id},'a')" ><i class="glyphicon glyphicon-info-sign"></i></span></td>
                        <td><input name="checkbox[]" type="checkbox" id="${data[0][i].designation}" value='{"idArea":${data[0][i].id},"idProduct":${data[0][i].productId},"designation":"${data[0][i].designation}","idSection":"${data[0][i].idSection}","idCleaningFrequency":"${id}"}'></td>
                    </tr>
             `)
            }
            for(var i=0;i<data[1].length;i++ ) {
                $('#tbody-equip').append(`
                    <tr>
                        <td>${data[1][i].designation}</td>
                        <td>${data[1][i].sectionDesignation}</td>
                        <td><a href="/frontoffice/product/${data[1][i].productId}">${data[1][i].productName}</a></td>
                        <td><span class="show-info" data-toggle="modal" data-target="#info-modal" onclick="showObservation(${data[1][i].id},'e')" ><i class="glyphicon glyphicon-info-sign"></i></span></td>
                        <td><input name="checkbox[]" type="checkbox" id="${data[1][i].designation}" value='{"idEquipment":${data[1][i].id},"idProduct":${data[1][i].productId},"designation":"${data[1][i].designation}","idSection":"${data[1][i].idSection}","idCleaningFrequency":"${id}"}'></td>
                    </tr>
             `)
            }
        });
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
                checkbox.idSection=values['idSection'];
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

    function showObservation(id,type) {
        $('#infomodal').html('');
        $.get('/frontoffice/getObservation/'+id+'/'+type, function( data ) {
            $('#infomodal').append(data);
        });
    }
</script>

@endsection