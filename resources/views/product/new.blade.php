@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Novo Produto</div>
                <div class="panel-body">
                    <form action="/products/add"  method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="col-sm-6">
                            <div class="form-group">
                                Nome:<input class="form-control"  name="name">
                            </div>

                            <div class="form-group">
                                Detalhes:<input class="form-control"  name="details">
                            </div>

                            <div class="form-group">
                                Categoria : <select class="form-control" name="category">
                                    @foreach($categories as $category)
                                        <option value="{{$category->name}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                               Imagem:  <input class="form-control" type="file" name="foto">
                            </div>

                            <div class="form-group">
                                Ficha Tecnica:  <input class="form-control" type="file" name="manual">
                            </div>

                            <div class="form-group">
                                Ficha Segurança:  <input class="form-control" type="file" name="seguranca">
                            </div>

                            <div class="form-group">
                                Referência: <input class="form-control"  name="ref" >
                            </div>

                            <div class="form-group">
                                Preço Escalão 1: <input class="form-control"  name="price1" >
                            </div>
                            <div class="form-group">
                                Preço Escalão 2: <input class="form-control"  name="price2" >
                            </div>
                            <div class="form-group">
                                Preço Escalão 3: <input class="form-control"  name="price3" >
                            </div>
                            <div class="form-group">
                                Total Escalão 2: <input class="form-control"  name="amount2" >
                            </div>
                            <div class="form-group">
                                Total Escalão 3: <input class="form-control"  name="amount3" >
                            </div>


                            <button class="btn btn-primary">Criar</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
