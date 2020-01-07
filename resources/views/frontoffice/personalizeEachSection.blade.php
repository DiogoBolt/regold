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
            <img src="/img/haccp_icon.png"></a>
        </div>
    </div>

    <!--
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item" aria-current="page">Home</li>
                <li class="breadcrumb-item " aria-current="page">Documentos </li>
                <li class="breadcrumb-item active" aria-current="page">Documento</li>
            </ol>
        </nav>

        {{-- Go Back Button --}}
        <a class="back-btn" href="/frontoffice/documents/">
            <span class="back-btn__front"><strong>Voltar</strong></span>
            <span class="back-btn__back"><strong>Documentos </strong></span>
        </a>
     -->
    
     {{-- Go Back Button --}}
    <a class="back-btn" href="/frontoffice/personalizeAreasEquipments">
        <span class="back-btn__front"><strong>Voltar</strong></span>
        <span class="back-btn__back"><strong>Home</strong></span>
    </a>

     <h1 id="sectionTitle" class="title">{{$clientSection->designation}}</h1>
     <input type="hidden" id="idSection" name="custId"value="{{$clientSection->id}}">

     <!--Area Section-->
     <h2 class="title">ÁREAS</h2>
     <table class="table" id="areasTable">
        <tr>
            <th>Área</th>
            <th>Produto de Limpeza</th>
            <th>Frequência de Limpeza</th>
            <th>Checked</th>
        </tr>
        <tbody>
        @foreach($areas as $area)
            <tr class="tableRow">
                <td>
                    <input type="hidden" id="idClientArea" value="{{$area->idAreaSectionClient}}">
                    <label>{{$area->designation}}</label></td>
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
                    <select id="cleaning">
                    <option value="" disabled>Limpeza</option>
                        @foreach($cleaningFrequencys as $cleaningFrequency)
                            @if($area->idFrequencyCleaning == $cleaningFrequency->id)
                                <option value="{{$cleaningFrequency->id}}" selected>{{$cleaningFrequency->designation}}</option>
                            @else
                                <option value="{{$cleaningFrequency->id}}">{{$cleaningFrequency->designation}}</option>
                            @endif
                        @endforeach
                    </select>
                </td>
                @if($area->checked)
                <td><input id="checkedArea" type="Checkbox" name="checkedArea[]" checked></td>
                @else
                <td><input id="checkedArea" type="Checkbox" name="checkedArea[]"></td>
                @endif
            </tr>
        @endforeach
        @foreach($areasSectionClients as $area)
            <tr class="tableRow">
                <td>
                    <input type="hidden" id="idClientArea" value="{{$area->id}}">
                    <label>{{$area->designation}}</label>
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
            <th>Frequência de Limpeza</th>
            <th>Checked</th>
        </tr>
        <tbody>
        @foreach($equipments as $equipment)
            <tr class="tableRow">
                <td>
                    <input type="hidden" id="idClientEquipment" value="{{$equipment->idAreaSectionClient}}">
                    <label>{{$equipment->designation}}</label>
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
                    <select id="cleaning">
                    <option value="" disabled>Limpeza</option>
                        @foreach($cleaningFrequencys as $cleaningFrequency)
                            @if($equipment->idFrequencyCleaning == $cleaningFrequency->id)
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
            <tr class="tableRow">
                <td> 
                    <input type="hidden" id="idClientEquipment" value="{{$equipment->id}}">
                    <label>{{$equipment->designation}}</label>
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
                    <select id="cleaning">
                    <option value="" disabled>Limpeza</option>
                        @foreach($cleaningFrequencys as $cleaningFrequency)
                            @if($equipment->idFrequencyCleaning == $cleaningFrequency->id)
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
                        <div class="news" id="oneNew">
                            <input type="text" id="idDesignation" name="designation" placeholder="Designação">
                            <select id="product">
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


    <button id="savePersolize" class="btn-del" onclick="saveEachPersonalize()">Guardar</button>

@endsection