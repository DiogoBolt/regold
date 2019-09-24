@extends('layouts.app')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/products/products-new.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container-bar">
    <p class="container-bar_txt">novo produto</p>
    <div class="container-bar_img">
        <img src="{{ asset('img/produtos.jpg') }}" />
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel">
                <div class="panel-body">
                    <div>
                        <img class="img-responsive add-img" src="/img/navbar/logoindexcolor.png"/>
                    </div>
                    <form action="/products/add"  method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="col-sm-6">
                            <div class="form-group">
                                Nome:<input class="form-control"  name="name" required>
                            </div>

                            <div class="form-group">
                                Detalhes:<input class="form-control"  name="details" required>
                            </div>

                            <div class="form-group">
                                Categoria : <select class="form-control" name="category">
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                               Imagem:  <input class="form-control" type="file" name="foto" required>
                            </div>

                            <div class="form-group">
                                Ficha Tecnica:  <input class="form-control" type="file" name="manual" required>
                            </div>

                            <div class="form-group">
                                Ficha Segurança:  <input class="form-control" type="file" name="seguranca" required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                Referência: <input class="form-control"  name="ref" required>
                            </div>

                            <div class="form-group">
                                Preço Escalão 1: <input class="form-control"  name="price1" required>
                            </div>
                            <div class="form-group">
                                Preço Escalão 2: <input class="form-control"  name="price2" required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                Preço Escalão 3: <input class="form-control"  name="price3" required>
                            </div>
                            <div class="form-group">
                                Total Escalão 2: <input class="form-control"  name="amount2" required>
                            </div>
                            <div class="form-group">
                                Total Escalão 3: <input class="form-control"  name="amount3" required>
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-add">Criar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
