@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{$product->name}}</div>
                <div class="panel-body">
                    <form action="/products/edit"  method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input value="{{$product->id}}" name="id" style="display:none">
                        <div class="col-sm-6">

                            <img src="/uploads/products/{{$product->file}}" class="img-responsive" style="width:365px;height:365px;">

                            <div class="form-group">
                                Nome:<input class="form-control"  name="name" value="{{$product->name}}">
                            </div>
                            <div class="form-group">
                                Detalhes:<textarea class="form-control"  name="details" >{{$product->details}}</textarea>
                            </div>

                            <div class="form-group">
                                Categoria : <select class="form-control" name="category">
                                    <option value="{{$product->category}}" selected>{{$product->category}}</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->name}}">{{$category->name}}</option>
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
                               Total Escalão 2:<input class="form-control"  name="amount2" value="{{$product->amount2}}" >
                            </div>
                            <div class="form-group">
                               Total Escalão 3:<input class="form-control"  name="amount3" value="{{$product->amount3}}" >
                            </div>

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


                            <button class="btn btn-warning">Editar</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
