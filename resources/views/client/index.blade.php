@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Clientes</div>

                <div class="panel-body">

                    <table class="table table-bordered">
                        <tr>
                            <th>Nome</th>
                            <th>Volta</th>

                        </tr>
                        @foreach($clients as $client)
                            <tr>
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
