@extends('layouts.app')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/client/client-bo.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-bar">
        <p class="container-bar_txt">Possiveis Clientes</p>
        <div class="container-bar_img">
            <img src="{{ asset('img/clientes.jpg') }}"/>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel">
                    <div class="panel-body table-responsive">
                        <table class="table">
                            <tr>
                                <th>Id</th>
                                <th>Nome</th>
                                <th>Nome Cliente</th>
                                <th>Email</th>
                                <th>Contacto</th>
                                <th>Morada</th>
                                <th>Contrato Atual</th>
                                <th>Final Contrato</th>
                                <th>Vendedor</th>
                                <th>Apagar</th>
                            </tr>
                            @foreach($possibleCustomers as $client)

                                    <tr>
                                        <td><a href="/possiblecustomers/edit/{{$client->id}}">{{$client->id}}</a></td>
                                        <td><a href="/possiblecustomers/edit/{{$client->id}}">{{$client->name}}</a></td>
                                        <td>{{$client->nome_cliente}}</td>
                                        <td>{{$client->email}}</td>
                                        <td>{{$client->contacto}}</td>
                                        <td>{{$client->address}}</td>
                                        <td>{{$client->current_contract}}</td>
                                        <td>{{date('y-m-d',strtotime($client->contract_end))}}</td>
                                        <td>{{$client->sales_id}}</td>
                                        <td><a href="/possiblecustomers/deletecustomer/{{$client->id}}">X</a></td>
                                    </tr>
                            @endforeach
                        </table>

                        <a href="/possiblecustomers/new" class="btn btn-primary"> Cliente </a>
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
        /*const greenlist=document.getElementsByClassName('green');
        const redlist=document.getElementsByClassName('red');
        $(greenlist).hide();*/


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
