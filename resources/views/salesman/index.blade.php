@extends('layouts.app')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/client/client-bo.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container-bar">
    <p class="container-bar_txt">Colaboradores</p>
    <div class="container-bar_img">
        <img src="{{ asset('img/clientes.jpg') }}" />
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel">
                <div class="panel-body table-responsive">
                <a data-toggle="collapse" href="#collapseFilter" role="button"
                           aria-expanded="false" aria-controls="collapseFilter">
                            <strong>Filtrar por Tipo de Colaborador</strong>
                        </a>
                        <div class="collapse" id="collapseFilter">
                            <form action="/salesman" method="GET" id="filter-form">
                                <div class="card card-body">
                                    <label for="district-filter">Tipo de Colaborador</label>
                                    <select class="form-control" id="contributor-filter"  name="contributor">
                                    <option value="" selected disabled>Seleccione o Tipo de Colaborador</option>
                                        @foreach($userstypes as $usertype)
                                            <option name="userTypeFilter" value="{{$usertype->id}}">{{$usertype->name}}</option>
                                        @endforeach
                                  
                                    </select>
                                </div>
                                <button class="btn" type="submit" form="filter-form">Filtrar</button>
                            </form>
                        </div>

                    <table class="table">
                        <tr>
                           <!-- <th>Id</th>-->
                            <th>Nome</th>
                            <th>Tipo de Colaborador</th>
                            <th>Eliminar</th>
                        </tr>
                        @foreach($contributors as $contributor)
                                <tr>
                                   <!-- <td><a href="/salesman/20">{{$contributor->sales_id}}</a></td>-->
                                    <td><a href="/salesman/{{$contributor->id}}">{{$contributor->name}}</a></td>
                                    <td><a href="/salesman/{{$contributor->id}}">{{$contributor->userTypeName}}</a></td>
                                    <td><button class="btn-del"  data-toggle="modal" data-target="#deleteModal" data-item="{{ $contributor }}">Eliminar</button></td>
                                </tr>
                        @endforeach
                    </table>


                    
                    <a href="/newsalesman" class="btn btn-add"><strong>Novo Colaborador</strong></a>
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

    <form action="/salesman/delete" method="post" id="delete-form">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="delete" />
        <input type="hidden" id="usertypeid" value="" name="usertypeid">
        <input type="hidden" id="usertype" value="" name="usertype">
    </form>
    
@endsection

<script>

    document.addEventListener('DOMContentLoaded', function(){ 
    
        $('#deleteModal').on('show.bs.modal', function (event) {
            let item = $(event.relatedTarget); 
            let data = item.data('item'); 

            $(this).find('.modal-body').text(`Tem a certeza que quer apagar o seguinte colaborador, ${data.name} ? `);

            $('#delete-user').on('click', function() { 
                $('#usertypeid').val(data.userTypeID);
                $('#usertype').val(data.userType);
                $('#delete-form').submit();
            });

        });

        $("#deleteModal").on("hidden.bs.modal", function () {
            $('#delete-user').unbind('click');
        });

    }, false);

</script>
    
