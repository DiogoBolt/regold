@extends('layouts.app')

<link href="{{ asset('css/categories/categories-bo.css') }}" rel="stylesheet">

@section('content')

<div class="container-bar">
        <p class="container-bar_txt">Tipos Documento</p>
        <div class="container-bar_img">
            <img src="{{ asset('img/doc-green.png') }}" />
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
                                <td><a href="/documents/{{$type->id}}">{{$type->name}}</a></td>
                                <td><a href="/documents/delete/{{$type->id}}" class="btn-del">Eliminar</a></td>
                            </tr>

                        @endforeach

                    </table>

                    <a href="/documents/new" class="btn btn-add"><strong>Novo Tipo Documento</strong></a>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
