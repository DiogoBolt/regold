@extends('layouts.app')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/client/client-bo.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container-bar">
    <p class="container-bar_txt">clientes</p>
    <div class="container-bar_img">
        <img src="{{ asset('img/clientes.jpg') }}" />
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel">
                <div class="panel-body table-responsive">
                    <table class="table">
                        <tr>
                            <th>Id</th>
                            <th>Nome</th>
                            <th>Dinheiro em mao</th>
                        </tr>
                        @foreach($salesman as $sales)
                                <tr>
                                    <td><a href="/users/{{$sales->id}}">{{$sales->id}}</a></td>
                                    <td><a href="/users/{{$sales->id}}">{{$sales->name}}</a></td>
                                    <td><a href="/users/{{$sales->id}}">{{$sales->total}}</a></td>
                                </tr>
                        @endforeach
                    </table>


                    
                    <a href="/salesman/new" class="btn btn-add"><strong>Novo Vendedor</strong></a>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
