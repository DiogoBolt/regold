@extends('layouts.app')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/client/client-add.css') }}" rel="stylesheet">
@endsection

@section('content')
<script src="{{ URL::asset('/js/validations.js') }}"></script>


<div class="container-bar">
    <p class="container-bar_txt">Documentos</p>
    <div class="container-bar_img">
        <img src="{{ asset('img/doc-green.png') }}" />
    </div>
</div>
<div class="container">
    <div class="container-docs">

        @if(count($receipts) > 0)
            <table class="table">
                <tr>
                    <th>Documento</th>
                    <th>Pasta</th>
                    <th>Data</th>
                    <th>Eliminar</th>
                </tr>
                @foreach($receipts as $receipt)
                    <tr>
                        <td><a href="/uploads/{{$client->id}}/{{$receipt->file}}">{{$receipt->file}}</a></td>
                        <td>
                            @foreach($documentsTypes as $document)
                                @if($receipt->document_type_id==$document->id)
                                    {{$document->name}}
                                @endif
                            @endforeach
                        </td>
                        <td>{{date('d-m-Y',strtotime($receipt->created_at))}}</td>
                        <td><a href="/clients/deletereceipt/{{$receipt->id}}">X</a></td>
                    </tr>
                @endforeach
            </table>
        @else
            <h2>Sem documentos associados.</h2>
        @endif
    </div>
</div>
@endsection

