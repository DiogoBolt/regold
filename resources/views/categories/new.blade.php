@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/categories/categories-bo.css') }}" rel="stylesheet">
@endsection

@section('content')

    <div class="container-bar">
        <p class="container-bar_txt">categorias</p>
        <div class="container-bar_img">
            <img src="{{ asset('img/encomendas.jpg') }}" />
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form action="/categories/add"  method="post" id="add-cat">
                            {{ csrf_field() }}
                           
                            <div class="form-group">
                                Nome:<input class="form-control"  name="name">
                            </div>

                            <button class="btn btn-add">
                                <strong>Criar</strong>
                            </button>
                      
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
