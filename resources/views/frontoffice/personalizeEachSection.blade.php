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

     <h1 id="sectionTitle" class="title">{{$clientSection->designation}}</h1>
     <input type="hidden" id="idSection" name="custId" value="{{$clientSection->id}}">

     <!--Area Section-->
     <h2 class="title">ÁREAS</h2>
     <table class="table" id="areasTable">
        <tr>
            <th>Área</th>
            <th>Produto de Limpeza</th>
            <th>Produto de Limpeza</th>
            <th>Produto de Limpeza</th>
            <th>Frequência de Limpeza</th>
            <th>Ativo</th>
        </tr>
        <tbody>
        <tr class="tableRowArea" style="display:none">
            <td>
                <input type="hidden" id="idClientArea" value="">
                <label class="area" id="area{{$lastArea}}" onclick="showEdit('a',this.id)"></label>
            </td>
            <td>
                <select id="product">
                    <option value="" disabled>Produto</option>
                    @foreach($products as $product)
                            <option value="{{$product->id}}">{{$product->name}}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <select id="product2">
                    <option value="" disabled>Produto</option>
                    @foreach($products as $product)
                        <option value="{{$product->id}}">{{$product->name}}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <select id="product3">
                    <option value="" disabled>Produto</option>
                    @foreach($products as $product)
                        <option value="{{$product->id}}">{{$product->name}}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <select id="cleaning">
                    <option value="" disabled>Limpeza</option>
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
                    <select id="product">
                        <option value="" disabled>Produto</option>
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
                    <select id="product2">
                        <option value="" disabled>Produto</option>
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
                    <select id="product3">
                        <option value="" disabled>Produto</option>
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
                    <select id="cleaning">
                    <option value="" disabled>Limpeza</option>
                        @foreach($cleaningFrequencys as $cleaningFrequency)
                            @if($area->idCleaningFrequency == $cleaningFrequency->id)
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
    <button id="newSections" class="btn-del" onclick="showModal('addArea')">Nova área</button>
    {{--<button id="" class="btn-del" onclick="addArea()">Áreas Existentes</button>--}}
    <select>
        @foreach($allAreas as $allArea)
            <option id="allAreas" value='{"idProduct":{{$allArea->idProduct}},"designation":"{{$allArea->designation}}","idCleaningFrequency":{{$allArea->idCleaningFrequency}}}'>{{$allArea->designation}}</option>
        @endforeach
    </select>

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
            
                            <select id="product">
                                <option value="" disabled selected>Produto</option>
                                @foreach($products as $product)
                                    <option value="{{$product->id}}">{{$product->name}}</option>
                                @endforeach
                            </select>
                            <select id="product2">
                                <option value="" disabled selected>Produto</option>
                                @foreach($products as $product)
                                    <option value="{{$product->id}}">{{$product->name}}</option>
                                @endforeach
                            </select>
                            <select id="product3">
                                <option value="" disabled selected>Produto</option>
                                @foreach($products as $product)
                                    <option value="{{$product->id}}">{{$product->name}}</option>
                                @endforeach
                            </select>
                            <select id="cleaning">
                                <option value="" disabled selected>Limpeza</option>
                                @foreach($cleaningFrequencys as $cleaningFrequency)
                                    <option value="{{$cleaningFrequency->id}}">{{$cleaningFrequency->designation}}</option>
                                @endforeach
                            </select>
                            <i class="fa fa-trash fa-lg" style="display:none" onclick="deleteNewSection(parentNode)"></i>
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
            <th>Produto de Limpeza</th>
            <th>Produto de Limpeza</th>
            <th>Produto de Limpeza</th>
            <th>Frequência de Limpeza</th>
            <th>Ativo</th>
        </tr>
        <tbody>
        <tr class="tableRowEquipment" style="display:none">
            <td>
                <input type="hidden" id="idClientEquipment" value="0">
                <label class="equipment" id="equipment{{$lastEquipment}}" onclick="showEdit('e',this.id)"></label>
            </td>
            <td>
                <select id="product">
                    <option value="" disabled>Produto</option>
                    @foreach($products as $product)

                            <option value="{{$product->id}}">{{$product->name}}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <select id="cleaning">
                    <option value="" disabled>Limpeza</option>
                    @foreach($cleaningFrequencys as $cleaningFrequency)

                            <option value="{{$cleaningFrequency->id}}">{{$cleaningFrequency->designation}}</option>
                    @endforeach
                </select>
            </td>
                <td><input id="checkedArea" type="Checkbox" name="checkedArea[]" checked></td>

        </tr>
        @foreach($equipments as $equipment)
            <tr class="tableRowEquipment">
                <td>
                    <input type="hidden" id="idClientEquipment" value="{{$equipment->idAreaSectionClient}}">
                    <label class="equipment" id="equipment{{$equipment->id}}" onclick="showEdit('e',this.id)">{{$equipment->designation}}</label>
                </td>
                <td>
                    <select id="product">
                    <option value="" disabled>Produto</option>
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
                    <select id="product2">
                        <option value="" disabled>Produto</option>
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
                    <select id="product3">
                        <option value="" disabled>Produto</option>
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
                    <select id="cleaning">
                    <option value="" disabled>Limpeza</option>
                        @foreach($cleaningFrequencys as $cleaningFrequency)
                            @if($equipment->idCleaningFrequency == $cleaningFrequency->id)
                                <option value="{{$cleaningFrequency->id}}" selected>{{$cleaningFrequency->designation}}</option>
                            @else
                                <option value="{{$cleaningFrequency->id}}">{{$cleaningFrequency->designation}}</option>
                            @endif
                        @endforeach
                    </select>
                </td>
                @if($equipment->checked)
                <td><input id="checkedArea" type="Checkbox" name="checkedArea[]" checked></td>
                @else
                <td><input id="checkedArea" type="Checkbox" name="checkedArea[]"></td>
                @endif
            </tr>
        @endforeach
        @foreach($equipmentsSectionClient as $equipment)
            <tr class="tableRowEquipment">
                <td> 
                    <input type="hidden" id="idClientEquipment" value="{{$equipment->id}}">
                    <label class="equipment" id="equipment{{$equipment->id}}" onclick="showEdit('e',this.id)">{{$equipment->designation}}</label>
                </td>
                <td>
                    <select id="product">
                    <option value="" disabled>Produto</option>
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
                    <select id="product2">
                        <option value="" disabled>Produto</option>
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
                    <select id="product3">
                        <option value="" disabled>Produto</option>
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
                    <select id="cleaning">
                    <option value="" disabled>Limpeza</option>
                        @foreach($cleaningFrequencys as $cleaningFrequency)
                            @if($equipment->idCleaningFrequency == $cleaningFrequency->id)
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

    <button id="newSections" class="btn-del" onclick="showModal('addEquipment')">Novo Equipamento</button>
    {{--<button id="" class="btn-del" onclick="">Equipamentos Existentes</button>--}}
    {{--<select id="">
        <option value="" disabled>Equipamentos</option>
        @foreach($products as $product)
            @if($equipment->idProduct == $product->id)
                <option value="{{$product->id}}" selected>{{$product->name}}</option>
            @else
                <option value="{{$product->id}}">{{$product->name}}</option>
            @endif
        @endforeach
    </select>--}}


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
                            <select id="product">
                                <option value="" disabled selected>Produto</option>
                                @foreach($products as $product)
                                    <option value="{{$product->id}}">{{$product->name}}</option>
                                @endforeach
                            </select>
                            <select id="product2">
                                <option value="" disabled selected>Produto</option>
                                @foreach($products as $product)
                                    <option value="{{$product->id}}">{{$product->name}}</option>
                                @endforeach
                            </select>
                            <select id="product3">
                                <option value="" disabled selected>Produto</option>
                                @foreach($products as $product)
                                    <option value="{{$product->id}}">{{$product->name}}</option>
                                @endforeach
                            </select>
                            <select id="cleaning">
                                <option value="" disabled selected>Limpeza</option>
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


    <button id="savePersolize" class="btn-del" onclick="saveEachPersonalize()">Guardar</button>

@endsection

<script>
    function showEdit(type,id) {
        $('#name').val(null);
        $('#myModal').modal('show');
        $('#type').val(type);
        var chars = id.slice(0, id.search(/\d/));
        var numbs = parseInt(id.replace(chars, ''));
        $('#idItem').val(numbs);
    }
    function editItem() {
        var name = $('#name').val();
        var id = $('#idItem').val();

        var type = $('#type').val();
        if(type == 'a')
            $('#area'+id).text(name);
        if(type == 'e')
            $('#equipment'+id).text(name);

        $('#myModal').modal('hide');

    }
</script>