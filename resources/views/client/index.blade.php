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
                    <form method="get" action="/clients">
                        <input id="client-search" name="search" class="form-control" placeholder="Pesquisa de clientes.." />
                     </form>
                    <table class="table">
                        <tr>
                            <th>Id</th>
                            <th>Nome</th>
                            <th>Entrar</th>
                        </tr>
                        @foreach($clients as $client)
                            <tr>
                                <td><a href="/clients/{{$client->id}}">{{$client->id}}</a></td>
                                <td><a href="/clients/{{$client->id}}">{{$client->name}}</a></td>
                                <td><a href="/clients/impersonate/{{$client->userid}}">Entrar</a></td>
                            </tr>
                        @endforeach
                    </table>

                    <div style="text-align: center;">
                        {{ $clients->links() }}
                    </div>
                    
                    <a href="/clients/new" class="btn btn-add"><strong>Novo Cliente</strong></a>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
