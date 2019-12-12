@extends('layouts.app')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/client/client-bo.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-bar">
        <p class="container-bar_txt">clientes</p>
        <div class="container-bar_img">
            <img src="{{ asset('img/clientes.jpg') }}"/>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel">
                    <div class="panel-body table-responsive">
                        <form method="get" action="/clients">
                            <input id="client-search" name="search" class="form-control"
                                   placeholder="Pesquisa de clientes.."/>
                        </form>

                        <a data-toggle="collapse" href="#collapseFilter" role="button"
                           aria-expanded="false" aria-controls="collapseFilter">
                            <strong>Filtrar por cidade</strong>
                        </a>

                        <div class="collapse" id="collapseFilter">
                            <form action="/clients" method="GET" id="filter-form">
                                <div class="card card-body">
                                    <label for="district-filter">Distrito</label>
                                    <select class="form-control" id="city-filter"  name="district" onchange="listCities(this)">
                                        <option value="" selected disabled>Seleccione o Distrito</option>
                                        @foreach($districts as $district)
                                            <option  class="form-control" value="{{$district->id}}">{{$district->name}}</option>
                                        @endforeach
                                    </select>
                                    <label for="city-filter">Cidade</label>
                                        <select id="selectCityInvoice" class="form-control" name="cityInvoice" >
                                            <option disabled selected value="">Selecione a Cidade</option>  
                                        </select>
                                </div>
                                <button class="btn" type="submit" form="filter-form">Filtrar</button>
                            </form>
                        </div>
                        <h3>{{$unpaid}}/{{$total}} Encomendas</h3>
                        <table class="table">
                            <tr>
                                <th>Id</th>
                                <th>Nome</th>
                                <th>Conta Corrente</th>
                                <th>Entrar</th>
                                <th>Eliminar</th>
                            </tr>
                            @foreach($clients as $client)
                                @if($client->order == 1)
                                    <tr>
                                        <td><a href="/clients/{{$client->id}}">{{$client->regoldiID}}</a></td>
                                        <td><a href="/clients/{{$client->id}}">{{$client->comercial_name}}</a></td>
                                        <td><a href="/unpaidOrders/{{$client->id}}">{{$client->current}}</a></td>
                                        <td><a href="/clients/impersonate/{{$client->id}}">Entrar</a></td>
                                        <td>
                                            <button class="btn-del" data-toggle="modal" data-target="#deleteModal"
                                                    data-item="{{ $client }}">Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                @else
                                    <tr class="unpaid">
                                        <td><a href="/clients/{{$client->id}}">{{$client->regoldiID}}</a></td>
                                        <td><a href="/clients/{{$client->id}}">{{$client->name}}</a></td>
                                        <td><a href="/unpaidOrders/{{$client->id}}">{{$client->current}}</a></td>
                                        <td><a href="/clients/impersonate/{{$client->id}}">Entrar</a></td>
                                        <td>
                                            <button class="btn-del" data-toggle="modal" data-target="#deleteModal"
                                                    data-item="{{ $client }}">Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </table>

                        <a href="/clients/new" class="btn btn-add"><strong>Novo Cliente</strong></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="deleteModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">x</button>
                    <h4 class="modal-title">Apagar Cliente</h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn modal-del" id="delete-user">
                        <strong>Apagar</strong>
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <strong>Cancelar</strong>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <form action="/clients/delete" method="post" id="delete-form">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="delete"/>
        <input type="hidden" id="user-id" value="" name="id">
    </form>

@endsection

<script>

    document.addEventListener('DOMContentLoaded', function () {

        $('#deleteModal').on('show.bs.modal', function (event) {
            let item = $(event.relatedTarget);
            let data = item.data('item');

            $(this).find('.modal-body').text(`Tem a certeza que quer apagar o seguinte cliente, ${data.name} ? `);

            $('#delete-user').on('click', function () {
                $('#user-id').val(data.id);
                $('#delete-form').submit();
            });

        });

        $("#deleteModal").on("hidden.bs.modal", function () {
            $('#delete-user').unbind('click');
        });

    }, false);

</script>
