@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Clientes</div>

                <div class="panel-body">
                    <form method="get" action="/clients">
                        <input name="search" class="form-control">
                        <button type="submit" class="btn btn-primary">Pesquisa</button>

                    </form>

                    <table class="table table-bordered">
                        <tr>
                            <th>Id</th>
                            <th>Nome</th>
                            <th>Grupo</th>

                        </tr>
                        @foreach($clients as $client)
                            <tr>
                                <td><a href="/clients/{{$client->id}}">{{$client->id}}</a></td>
                                <td><a href="/clients/{{$client->id}}">{{$client->name}}</a></td>
                                <td><a href="/groups/{{$client->groupid}}">{{$client->group}}</a></td>

                            </tr>

                        @endforeach

                    </table>

                    <a href="/clients/new" class="btn btn-success">Novo Cliente</a>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
