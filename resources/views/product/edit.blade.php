@extends('layouts.app')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/products/products-edit.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container-bar">
    <p class="container-bar_txt">{{$product->name}}</p>
    <div class="container-bar_img">
        <img src="{{ asset('img/produtos.jpg') }}" />
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel">
                <div class="panel-body">
                    <form action="/products/edit"  method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input value="{{$product->id}}" name="id" style="display:none">
                        <div class="main-info">
                            <div class="col-sm-6">
                                <img src="/uploads/products/{{$product->file}}" class="img-responsive product-img">
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    Nome:<input class="form-control"  name="name" value="{{$product->name}}">
                                </div>
                                <div class="form-group">
                                    Detalhes:<textarea class="form-control" name="details" >{{$product->details}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                Categoria : <select class="form-control" name="category">
                                    <option value="{{$product->category}}" selected>{{$selected->name}}</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                Preço Escalão 1:<input class="form-control"  name="price1" value="{{$product->price1}}" >
                            </div>
                            <div class="form-group">
                                Preço Escalão 2:<input class="form-control"  name="price2" value="{{$product->price2}}" >
                            </div>
                            <div class="form-group">
                                Preço Escalão 3:<input class="form-control"  name="price3" value="{{$product->price3}}" >
                            </div>
                            <div class="form-group">
                                Preço Escalão 4: <input class="form-control"  name="price4" value="{{$product->price4}}">
                            </div>
                            <div class="form-group">
                                Preço Escalão 5: <input class="form-control"  name="price5" value="{{$product->price5}}">
                            </div>
                        </div>
                        <div class="col-sm-6">

                            <div class="form-group">
                                Referência:<input class="form-control"  name="ref" value="{{$product->ref}}" >
                            </div>

                            <div class="form-group">
                                Imagem:  <input class="form-control" type="file" name="foto">
                            </div>

                            <div class="form-group">
                                Ficha Tecnica:  <input class="form-control" type="file" name="manual">
                            </div>
                            <div class="form-group">
                                <a href="/uploads/products/{{$product->manual}}">{{$product->manual}}</a>
                            </div>
                            <div class="form-group">
                                Ficha Segurança:  <input class="form-control" type="file" name="seguranca">
                            </div>
                            <div class="form-group">
                                <a href="/uploads/products/{{$product->seguranca}}">{{$product->seguranca}}</a>
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-edit" type="submit">Editar</button>
                            <button class="btn btn-del" type="button" data-toggle="modal" data-target="#deleteModal">Apagar</button>
                        </div>
                    </form>
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
                <h4 class="modal-title">Apagar Produto</h4>
            </div>
            <div class="modal-body">Deseja apagar este produto?</div>
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

<form action="/products/delete" method="post" id="delete-form">
    {{ csrf_field() }}
    <input type="hidden" name="_method" value="delete" />
    <input type="hidden" value="{{$product->id}}" name="id">
</form>


@endsection

<script>

    document.addEventListener('DOMContentLoaded', function(){ 
    
        $('#deleteModal').on('show.bs.modal', function (event) {
          
            $('#delete-user').on('click', function() { 
                $('#delete-form').submit();
            });

        });

        $("#deleteModal").on("hidden.bs.modal", function () {
            $('#delete-user').unbind('click');
        });

    }, false);

</script>
