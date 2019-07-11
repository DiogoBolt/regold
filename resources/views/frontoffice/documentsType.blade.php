@extends('layouts.frontoffice')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Documentos {{$type}} </div>

                <div class="panel-body">

                    <div class="col-sm-6">

                            @foreach($receipts as $receipt)
                            <div class="form-group">
                                <a href="/uploads/{{$client->id}}/{{$receipt->file}}">{{$receipt->file}}</a>
                            </div>
                                @endforeach



                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


@endsection
