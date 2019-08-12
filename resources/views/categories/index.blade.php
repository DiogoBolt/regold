@extends('layouts.app')

<link href="{{ asset('css/categories/categories-bo.css') }}" rel="stylesheet">

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
                <div class="panel">
                    <div class="panel-body table-responsive">

                        <table class="table">
                            <tr>
                                <th>Nome</th>
                                <th>Eliminar</th>

                            </tr>
                            @foreach($documentTypes as $type)
                                <tr>
                                    <td><a href="/categories/{{$type->id}}">{{$type->name}}</a></td>
                                    <td><a href="/categories/delete/{{$type->id}}">Eliminar</a></td>

                                </tr>

                            @endforeach

                        </table>

                        <a href="/categories/new" class="btn btn-add"><strong>Nova Categoria</strong></a>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
