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
    <div style="font-size: 18px" class="container-docs">

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
                        <td><i class="fa fa-trash fa-lg" data-toggle="modal" data-target="#deleteModal"
                               data-item="{{ $receipt }}">
                            </i></td>
                    </tr>
                @endforeach
            </table>
        @else
            <h2>Sem documentos associados.</h2>
        @endif
    </div>
</div>

<div class="modal fade" id="deleteModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">x</button>
                <h4 class="modal-title">Apagar Documento</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn modal-del" id="delete-receipt">
                    <strong>Apagar</strong>
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <strong>Cancelar</strong>
                </button>
            </div>
        </div>
    </div>
</div>

<form action="/clients/deletereceipt" method="post" id="delete-form">
    {{ csrf_field() }}
    <input type="hidden" name="_method" value="delete"/>
    <input type="hidden" id="receipt-id" value="" name="id">
</form>

@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {

        $('#deleteModal').on('show.bs.modal', function (event) {
            let item = $(event.relatedTarget);
            let data = item.data('item');

            $(this).find('.modal-body').text(`Tem a certeza que pretende apagar este documento? `);

            $('#delete-receipt').on('click', function () {
                $('#receipt-id').val(data.id);
                $('#delete-form').submit();
            });
        });

        $("#deleteModal").on("hidden.bs.modal", function () {
            $('#delete-receipt').unbind('click');
        });

    }, false);
</script>

