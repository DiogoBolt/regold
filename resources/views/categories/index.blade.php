@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Categorias</div>

                <div class="panel-body">

                    <table class="table table-bordered">
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

                    <a href="/categories/new" class="btn btn-success">Nova Categoria</a>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
