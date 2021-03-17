@extends('layouts.frontoffice')
@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/documents/personalizeSection.css') }}" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="{{ mix('css/app.css') }}">
@endsection

@section('content')
    <script src="{{ URL::asset('/js/personalizeSection.js') }}"></script>

    <div class="container-bar">
        <p class="container-bar_txt">Personalizar Secções </p>
        <div class="container-bar_img">
            <img src="/img/haccp_icon.png">
        </div>
    </div>

    {{-- Go Back Button --}}
    <a class="back-btn" href="/frontoffice/personalizeAreasEquipments">
        <span class="back-btn__front"><strong>Voltar</strong></span>
        <span class="back-btn__back"><strong>Home</strong></span>
    </a>

    <div class="panel">
        <div class="panel-body table-responsive">

            <h1 id="sectionTitle" class="title">{{$clientSection->designation}}</h1>
            <input type="hidden" id="idSection" name="custId" value="{{$clientSection->id}}">

            <!--Area Section-->
            <h2 class="title">ÁREAS</h2>
            <table class="table" id="areasTable">
                <tr>
                    <th>Área</th>
                    <th>Obs</th>
                    <th>Produto de Limpeza</th>
                    <th>Frequência</th>
                    <th>Produto de Limpeza</th>
                    <th>Frequência</th>
                    <th>Produto de Limpeza</th>
                    <th>Frequência</th>
                    <th>Ativo</th>
                </tr>
                <tbody>
                <tr class="tableRowArea" style="display:none">
                    <td>
                        <input type="hidden" id="idClientArea" value="">
                        <label class="area" id="area{{$lastArea}}" onclick="showEdit('a',this.id)"></label>
                    </td>
                    <td>
                        <a id="" onclick="showModalAdd('a',this.id)">Observação</a>
                    </td>
                    <td>
                        <select class="prod" id="product" style="width: 180px">
                            <option value="">Produto</option>
                            @foreach($products as $product)
                                <option value="{{$product->id}}">{{$product->name}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select class="clean" id="cleaning" >
                            <option value="">Limpeza</option>
                            @foreach($cleaningFrequencys as $cleaningFrequency)
                                <option value="{{$cleaningFrequency->id}}">{{$cleaningFrequency->designation}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select class="prod" id="product2" style="width: 180px">
                            <option value="">Produto</option>
                            @foreach($products as $product)
                                <option value="{{$product->id}}">{{$product->name}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select class="clean" id="cleaning2">
                            <option value="">Limpeza</option>
                            @foreach($cleaningFrequencys as $cleaningFrequency)
                                <option value="{{$cleaningFrequency->id}}">{{$cleaningFrequency->designation}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select class="prod" id="product3" style="width: 180px">
                            <option value="">Produto</option>
                            @foreach($products as $product)
                                <option value="{{$product->id}}">{{$product->name}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select class="clean" id="cleaning3">
                            <option value="">Limpeza</option>
                            @foreach($cleaningFrequencys as $cleaningFrequency)
                                <option value="{{$cleaningFrequency->id}}">{{$cleaningFrequency->designation}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input id="checkedArea" type="Checkbox" name="checkedArea[]" checked></td>
                </tr>

                @foreach($areasSectionClients as $area)
                    <tr class="tableRowArea">
                        <td>
                            <input type="hidden" id="idClientArea" value="{{$area->id}}">
                            <label class="area" id="area{{$area->id}}" onclick="showEdit('a',this.id)">{{$area->designation}}</label>
                        </td>
                        <td>
                            <a onclick="showModalAdd('a',{{$area->id}})">Observação</a>
                        </td>
                        <td>
                            <select class="prod" id="product" style="width: 180px">
                                <option value="">Produto</option>
                                @foreach($products as $product)
                                    @if($area->idProduct == $product->id)
                                        <option value="{{$product->id}}" selected>{{$product->name}}</option>
                                    @else
                                        <option value="{{$product->id}}">{{$product->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select class="clean" id="cleaning">
                                <option value="" >Limpeza</option>
                                @foreach($cleaningFrequencys as $cleaningFrequency)
                                    @if($area->idCleaningFrequency == $cleaningFrequency->id)
                                        <option value="{{$cleaningFrequency->id}}" selected>{{$cleaningFrequency->designation}}</option>
                                    @else
                                        <option value="{{$cleaningFrequency->id}}">{{$cleaningFrequency->designation}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select class="prod" id="product2" style="width: 180px">
                                <option value="">Produto</option>
                                @foreach($products as $product)
                                    @if($area->idProduct2 == $product->id)
                                        <option value="{{$product->id}}" selected>{{$product->name}}</option>
                                    @else
                                        <option value="{{$product->id}}">{{$product->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select class="clean" id="cleaning2">
                                <option value="" >Limpeza</option>
                                @foreach($cleaningFrequencys as $cleaningFrequency)
                                    @if($area->idCleaningFrequency2 == $cleaningFrequency->id)
                                        <option value="{{$cleaningFrequency->id}}" selected>{{$cleaningFrequency->designation}}</option>
                                    @else
                                        <option value="{{$cleaningFrequency->id}}">{{$cleaningFrequency->designation}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select class="prod" id="product3" style="width: 180px">
                                <option value="" >Produto</option>
                                @foreach($products as $product)
                                    @if($area->idProduct3 == $product->id)
                                        <option value="{{$product->id}}" selected>{{$product->name}}</option>
                                    @else
                                        <option value="{{$product->id}}">{{$product->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select class="clean" id="cleaning3">
                                <option value="" >Limpeza</option>
                                @foreach($cleaningFrequencys as $cleaningFrequency)
                                    @if($area->idCleaningFrequency3 == $cleaningFrequency->id)
                                        <option value="{{$cleaningFrequency->id}}" selected>{{$cleaningFrequency->designation}}</option>
                                    @else
                                        <option value="{{$cleaningFrequency->id}}">{{$cleaningFrequency->designation}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                        <td><input id="checkedArea" type="Checkbox" name="checkedArea[]" checked></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <h1 style="font-size:12px">Secção já existente:</h1>
            <div>
                <select id="allAreas">
                    <option value="" disabled selected>Secção</option>
                    @foreach($otherSections as $otherSection)
                        <option value="{{$otherSection->allAreas}}">{{$otherSection->designation}}</option>
                    @endforeach
                </select>
                <button id="" class="btn_equip" onclick="addArea()">Adicionar</button>
            </div>
            <button id="newSections" class="btn-del" onclick="showModal('addArea')">Nova área</button>

            <!--Modal add novas areas-->
            <div class="modal fade" id="addArea" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">x</button>
                            <h4 class="modal-title">Adicionar Nova Área</h4>
                        </div>
                        <div class="modal-body">
                            <div id="allNewsAreas">
                                <div class="news" id="oneNew">
                                    <input type="text" id="idDesignation" name="designation" placeholder="Designação">
                                    <select class="prod" id="product" style="width: 50%">
                                        <option value="" selected>Produto</option>
                                        @foreach($products as $product)
                                            <option value="{{$product->id}}">{{$product->name}}</option>
                                        @endforeach
                                    </select>
                                    <select class="clean" id="cleaning">
                                        <option value="" selected>Limpeza</option>
                                        @foreach($cleaningFrequencys as $cleaningFrequency)
                                            <option value="{{$cleaningFrequency->id}}">{{$cleaningFrequency->designation}}</option>
                                        @endforeach
                                    </select>
                                    <select class="prod" id="product2" style="width: 50%">
                                        <option value="" selected>Produto</option>
                                        @foreach($products as $product)
                                            <option value="{{$product->id}}">{{$product->name}}</option>
                                        @endforeach
                                    </select>
                                    <select class="clean" id="cleaning2">
                                        <option value="" selected>Limpeza</option>
                                        @foreach($cleaningFrequencys as $cleaningFrequency)
                                            <option value="{{$cleaningFrequency->id}}">{{$cleaningFrequency->designation}}</option>
                                        @endforeach
                                    </select>
                                    <select class="prod" id="product3" style="width: 50%">
                                        <option value="" selected>Produto</option>
                                        @foreach($products as $product)
                                            <option value="{{$product->id}}">{{$product->name}}</option>
                                        @endforeach
                                    </select>
                                    <select class="clean" id="cleaning3">
                                        <option value="" selected>Limpeza</option>
                                        @foreach($cleaningFrequencys as $cleaningFrequency)
                                            <option value="{{$cleaningFrequency->id}}">{{$cleaningFrequency->designation}}</option>
                                        @endforeach
                                    </select>
                                    <i class="fa fa-tazer rash fa-lg" style="display:none" onclick="deleteNewSection(parentNode)"></i>
                                </div>
                            </div>
                            <button id="btnAddNewSection" onclick="clone('addArea')"><i class="fa fa-plus"></i></button>
                        </div>
                        <div class="modal-footer">
                            <button class="btn modal-del" id="btnAddSections" onclick="addAreasTable()">
                                <strong>Adicionar</strong>
                            </button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                <strong>Cancelar</strong>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!--end area section-->

            <!--equipments section-->
            <h2 class="title">Equipamentos</h2>
            <table class="table" id="equipmentTable">
                <tr>
                    <th>Equipamento</th>
                    <th>Obs</th>
                    <th>Produto de Limpeza</th>
                    <th>Frequência</th>
                    <th>Produto de Limpeza</th>
                    <th>Frequência</th>
                    <th>Produto de Limpeza</th>
                    <th>Frequência</th>
                    <th>Ativo</th>
                </tr>
                <tbody>
                <tr class="tableRowEquipment" style="display:none">
                    <td>
                        <input type="hidden" id="idClientEquipment" value="0">
                        <label class="equipment" id="equipment{{$lastEquipment}}" onclick="showEdit('e',this.id)"></label>
                    </td>
                    <td>
                        <a id="" onclick="showModalAdd('e',this.id)">Observação</a>
                    </td>
                    <td>
                        <select class="prod" id="product" style="width: 180px">
                            <option value="">Produto</option>
                            @foreach($products as $product)
                                <option value="{{$product->id}}">{{$product->name}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select class="clean" id="cleaning">
                            <option value="">Limpeza</option>
                            @foreach($cleaningFrequencys as $cleaningFrequency)
                                <option value="{{$cleaningFrequency->id}}">{{$cleaningFrequency->designation}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select class="prod" id="product2" style="width: 180px">
                            <option value="">Produto</option>
                            @foreach($products as $product)
                                <option value="{{$product->id}}">{{$product->name}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select class="clean" id="cleaning2">
                            <option value="">Limpeza</option>
                            @foreach($cleaningFrequencys as $cleaningFrequency)
                                <option value="{{$cleaningFrequency->id}}">{{$cleaningFrequency->designation}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select class="prod" id="product3" style="width: 180px">
                            <option value="">Produto</option>
                            @foreach($products as $product)
                                <option value="{{$product->id}}">{{$product->name}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select class="clean" id="cleaning3">
                            <option value="">Limpeza</option>
                            @foreach($cleaningFrequencys as $cleaningFrequency)
                                <option value="{{$cleaningFrequency->id}}">{{$cleaningFrequency->designation}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input id="checkedArea" type="Checkbox" name="checkedArea[]" checked></td>

                </tr>
                @foreach($equipmentsSectionClient as $equipment)
                    <tr class="tableRowEquipment">
                        <td>
                            <input type="hidden" id="idClientEquipment" value="{{$equipment->id}}">
                            <label class="equipment" id="equipment{{$equipment->id}}" onclick="showEdit('e',this.id)">{{$equipment->designation}}</label>
                        </td>
                        <td>
                            <a onclick="showModalAdd('e',{{$equipment->id}})">Observação</a>
                        </td>
                        <td>
                            <select class="prod" id="product">
                                <option value="">Produto</option>
                                @foreach($products as $product)
                                    @if($equipment->idProduct == $product->id)
                                        <option value="{{$product->id}}" selected>{{$product->name}}</option>
                                    @else
                                        <option value="{{$product->id}}">{{$product->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select class="clean" id="cleaning" >
                                <option value="">Limpeza</option>
                                @foreach($cleaningFrequencys as $cleaningFrequency)
                                    @if($equipment->idCleaningFrequency == $cleaningFrequency->id)
                                        <option value="{{$cleaningFrequency->id}}" selected>{{$cleaningFrequency->designation}}</option>
                                    @else
                                        <option value="{{$cleaningFrequency->id}}">{{$cleaningFrequency->designation}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select class="prod" id="product2">
                                <option value="">Produto</option>
                                @foreach($products as $product)
                                    @if($equipment->idProduct2 == $product->id)
                                        <option value="{{$product->id}}" selected>{{$product->name}}</option>
                                    @else
                                        <option value="{{$product->id}}">{{$product->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select class="clean" id="cleaning" >
                                <option value="">Limpeza</option>
                                @foreach($cleaningFrequencys as $cleaningFrequency)
                                    @if($equipment->idCleaningFrequency2 == $cleaningFrequency->id)
                                        <option value="{{$cleaningFrequency->id}}" selected>{{$cleaningFrequency->designation}}</option>
                                    @else
                                        <option value="{{$cleaningFrequency->id}}">{{$cleaningFrequency->designation}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select class="prod" id="product3" >
                                <option value="">Produto</option>
                                @foreach($products as $product)
                                    @if($equipment->idProduct3 == $product->id)
                                        <option value="{{$product->id}}" selected>{{$product->name}}</option>
                                    @else
                                        <option value="{{$product->id}}">{{$product->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select class="clean" id="cleaning" >
                                <option value="">Limpeza</option>
                                @foreach($cleaningFrequencys as $cleaningFrequency)
                                    @if($equipment->idCleaningFrequency3 == $cleaningFrequency->id)
                                        <option value="{{$cleaningFrequency->id}}" selected>{{$cleaningFrequency->designation}}</option>
                                    @else
                                        <option value="{{$cleaningFrequency->id}}">{{$cleaningFrequency->designation}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                        <td><input id="checkedArea" type="Checkbox" name="checkedArea[]" checked></td>

                    </tr>
                @endforeach
                </tbody>
            </table>

            <h1 style="font-size:12px">Secção já existente:</h1>
            <div>
                <select id="allEquipments">
                    <option value="" disabled selected>Secção</option>
                    @foreach($otherSections as $otherSection)
                        <option value="{{$otherSection->allEquipments}}">{{$otherSection->designation}}</option>
                    @endforeach
                </select>
                <button id="" class="btn_equip" onclick="addEquipment()">Adicionar</button>
            </div>

            <button id="newSections" class="btn-del" onclick="showModal('addEquipment')">Novo Equipamento</button>


            <!-- Modal add novos equipamentos -->
            <div class="modal fade" id="addEquipment" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">x</button>
                            <h4 class="modal-title">Adicionar Novo Equipamento</h4>
                        </div>
                        <div class="modal-body">
                            <div id="allNewsEquipments">
                                <div class="newsE" id="oneNew">
                                    <input type="text" id="idDesignation" name="designation" placeholder="Designação">
                                    <select class="prod" id="product" style="width: 50%">
                                        <option value="" selected>Produto</option>
                                        @foreach($products as $product)
                                            <option value="{{$product->id}}">{{$product->name}}</option>
                                        @endforeach
                                    </select>
                                    <select class="clean" id="cleaning">
                                        <option value="" selected>Limpeza</option>
                                        @foreach($cleaningFrequencys as $cleaningFrequency)
                                            <option value="{{$cleaningFrequency->id}}">{{$cleaningFrequency->designation}}</option>
                                        @endforeach
                                    </select>
                                    <select class="prod" id="product2" style="width: 50%">
                                        <option value="" selected>Produto</option>
                                        @foreach($products as $product)
                                            <option value="{{$product->id}}">{{$product->name}}</option>
                                        @endforeach
                                    </select>
                                    <select class="clean" id="cleaning2">
                                        <option value="" selected>Limpeza</option>
                                        @foreach($cleaningFrequencys as $cleaningFrequency)
                                            <option value="{{$cleaningFrequency->id}}">{{$cleaningFrequency->designation}}</option>
                                        @endforeach
                                    </select>
                                    <select class="prod" id="product3" style="width: 50%">
                                        <option value="" selected>Produto</option>
                                        @foreach($products as $product)
                                            <option value="{{$product->id}}">{{$product->name}}</option>
                                        @endforeach
                                    </select>
                                    <select class="clean" id="cleaning3">
                                        <option value="" selected>Limpeza</option>
                                        @foreach($cleaningFrequencys as $cleaningFrequency)
                                            <option value="{{$cleaningFrequency->id}}">{{$cleaningFrequency->designation}}</option>
                                        @endforeach
                                    </select>
                                    <i class="fa fa-trash fa-lg" style="display:none" onclick="deleteNewSection(parentNode)"></i>
                                </div>
                            </div>
                            <button id="btnAddNewSection" onclick="clone('addEquipment')"><i class="fa fa-plus"></i></button>
                        </div>
                        <div class="modal-footer">
                            <button class="btn modal-del" id="btnAddSections" onclick="addEquipmentTable()">
                                <strong>Adicionar</strong>
                            </button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                <strong>Cancelar</strong>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!--end equipments section-->

    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Editar Designação</h4>
                </div>
                <div class="modal-body" id="infomodal">
                        <input id="type" name="type" type="hidden" value="">
                        <input id="idItem" name="idItem" type="hidden" value="">
                        <input id="name" name="name" value="" class="form-control">
                        <button type="submit" class="btn btn-primary" onclick="editItem()">Editar</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                </div>
            </div>

        </div>
    </div>

    <div id="myModalObs" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Observações</h4>
                </div>
                <div id="obsShow">
                </div>
                <div class="modal-body" id="infomodal2">
                    <input id="type2" name="type2" type="hidden" value="">
                    <input id="idItem2" name="idItem2" type="hidden" value="">
                    <textarea class="form-control" placeholder="Observações" id="obs" name="obs"></textarea>
                    <button type="submit" class="btn btn-primary" onclick="saveObs()">Adicionar</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <button id="savePersolize" class="btn-del" onclick="saveEachPersonalize()">Guardar</button>

@endsection

<script>
    function showModalAdd(type,id) {
        $('#myModalObs').modal('show');
        var type2 = $('#type2').val(type);
        var idItem2 = $('#idItem2').val(id);

        $.get('/frontoffice/getObs/'+type+'/'+id, function( data ) {
           $('#obsShow').html('');
           $('#obsShow').append('Observação: ' +data);
        });
    }


    function saveObs(){

        var type2 = $('#type2').val();
        var idItem2 = $('#idItem2').val();
        var obs = $('#obs').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: "/frontoffice/addObs",
            data:{type2: type2,idItem2:idItem2,obs:obs}
        }).done($('#myModalObs').modal('hide'));
    }

</script>
