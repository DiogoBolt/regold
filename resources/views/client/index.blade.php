@extends('layouts.app')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/client/client-bo.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container-bar">
    <p class="container-bar_txt">clientes</p>
    <div class="container-bar_img">
        <img src="{{ asset('img/clientes.jpg') }}" />
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel">
                <div class="panel-body table-responsive">
                    <form method="get" action="/clients">
                        <input id="client-search" name="search" class="form-control" placeholder="Pesquisa de clientes.." />
                     </form>
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
                                <td><a href="/clients/{{$client->id}}">{{$client->id}}</a></td>
                                <td><a href="/clients/{{$client->id}}">{{$client->name}}</a></td>
                                <td><a href="/unpaidOrders/{{$client->id}}">{{$client->current}}</a></td>
                                <td><a href="/clients/impersonate/{{$client->userid}}">Entrar</a></td>
                                <td><button class="btn-del"  data-toggle="modal" data-target="#deleteModal"  data-item="{{ $client }}">Eliminar</button></td>
                            </tr>
                            @else
                                <tr class="unpaid">
                                    <td><a href="/clients/{{$client->id}}">{{$client->id}}</a></td>
                                    <td><a href="/clients/{{$client->id}}">{{$client->name}}</a></td>
                                    <td><a href="/unpaidOrders/{{$client->id}}">{{$client->current}}</a></td>
                                    <td><a href="/clients/impersonate/{{$client->userid}}">Entrar</a></td>
                                    <td><button class="btn-del"  data-toggle="modal" data-target="#deleteModal" data-item="{{ $client }}">Eliminar</button></td>
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
                <button type="button" class="btn btn-del" id="delete-user">
                    <strong>Apagar</strong>
                </button>
                <button type="button" class="btn btn-default" id="dismiss-modal">
                    <strong>Cancelar</strong>
                </button>
            </div>
        </div>
    </div>
</div>


@endsection

<script>

    document.addEventListener('DOMContentLoaded', function(){ 
    
        $('#deleteModal').on('show.bs.modal', function (event) {
            let item = $(event.relatedTarget); 
            let data = item.data('item'); 

            $(this).find('.modal-body').text(`Tem a certeza que quer apagar o seguinte cliente, ${data.name} ? `);

            $('#delete-user').on('click', function() {
                let clientId = data.id;
                $.get(`/clients/delete/${clientId}`, function (response) {
                    if (response.success) {
                      // console.log(response);
                    }
                });

                $('#deleteModal').modal('hide');
                $('#delete-user').unbind('click');
            });

            $('#dismiss-modal').on('click', function() {
                $('#deleteModal').modal('hide');
                $('#delete-user').unbind('click');
            });

        });

    }, false);

</script>
