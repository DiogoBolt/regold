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
                    <table class="table">
                        <tr>
                            <th>Id</th>
                            <th>Nome</th>
                            <th>Dinheiro em mao</th>
                            <th>Eliminar</th>
                        </tr>
                        @foreach($salesman as $sales)
                                <tr>
                                    <td><a href="/salesman/{{$sales->id}}">{{$sales->id}}</a></td>
                                    <td><a href="/salesman/{{$sales->id}}">{{$sales->name}}</a></td>
                                    <td><a href="/salesman/{{$sales->id}}">{{$sales->total}}</a></td>
                                    <td><button class="btn-del"  data-toggle="modal" data-target="#deleteModal" data-item="{{ $sales }}">Eliminar</button></td>
                                </tr>
                        @endforeach
                    </table>


                    
                    <a href="/salesman/new/newsalesman" class="btn btn-add"><strong>Novo Vendedor</strong></a>
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
                    <h4 class="modal-title">Apagar Vendedor</h4>
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
    
                $(this).find('.modal-body').text(`Tem a certeza que quer apagar o seguinte vendedor, ${data.name} ? `);
    
                $('#delete-user').on('click', function() {
                    let clientId = data.id;
                    $.get(`/salesman/delete/${clientId}`, function (response) {
                        if (response.success) {
                           //console.log(response);
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
    
