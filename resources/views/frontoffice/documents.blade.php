@extends('layouts.frontoffice')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Documentos </div>

                <div class="panel-body">

                    <div class="col-sm-6">

                        @foreach($types as $type)

                            @foreach($receipts as $receipt)
                                @if($receipt->document_type_id == $type->id)
                                    <h4>{{$type->name}}</h4>
                            <div class="form-group">
                                <a href="/uploads/{{$client->id}}/{{$receipt->file}}">{{$receipt->file}}</a>
                            </div>
                                @endif
                                @endforeach
                        @endforeach



                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


@endsection
