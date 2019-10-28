@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/salesman/salesman.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container-bar">
    <p class="container-bar_txt">Novo Vendedor</p>
    <div class="container-bar_img">
        <img src="{{ asset('img/salesman.png') }}" />
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div>
                        <img class="salesman-img img-responsive" src="/img/navbar/logoindexcolor.png"/>
                    </div>
                    <form action="/salesman/add"  method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="col-sm-6">
                            <div class="form-group">
                                Nome:<input class="form-control"  name="name">
                            </div>
                            <div class="form-group">
                                Morada:<input class="form-control" name="address">
                            </div>
                            <div class="form-group">
                                Cidade: <input class="form-control" name="city">
                            </div>
                           
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                NIF: <input id="nif" class="form-control" type="number" name="nif">
                            </div>
                            <div class="form-group">
                                Email: <input class="form-control" type="email" name="email">
                            </div>

                            <div class="form-group">
                                Password: <input class="form-control" type="password" name="password">
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-add" onsubmit="return validateForm(this)">
                                <strong>Criar</strong>
                            </button>
                        </div>
        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection
