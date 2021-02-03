@extends('layouts.app')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/client/client-bo.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-bar">
        <p class="container-bar_txt">clientes</p>
        <div class="container-bar_img">
            <img src="{{ asset('img/clientes.jpg') }}"/>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel">
                    <div class="panel-body table-responsive">


                        <a href="/frontoffice/staff/new" class="btn btn-add"><strong>Novo Funcionário</strong></a>

                        <table class="table">
                            <tr>
                                <th>Id</th>
                                <th>Nome</th>
                            </tr>
                            {{--@foreach($clients as $client)--}}
                                    <tr>
                                       {{-- <td><a href="/clients/{{$client->id}}">{{$client->regoldiID}}</a></td>--}}
                                    </tr>
                            {{--@endforeach--}}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

