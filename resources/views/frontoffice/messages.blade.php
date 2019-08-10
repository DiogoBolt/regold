@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/messages/messages.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-bar">
        <p class="container-bar_txt">mensagens do sistema</p>
        <div class="container-bar_img">
            <img src="{{ asset('img/mensagens.jpg') }}" />
        </div>
    </div>
    <div class="container">
        <div id="messages-container" class="box-body">
            @foreach($messages as $item)

                <div class="row msg {{$item->name}} 
                    {{$item->viewed === 1 ? 'viewed' : 'not-viewed'}}"
                    data-item="{{ $item }}"
                    data-toggle="modal" data-target="#messageModal">

                    <div class="msg-img">
                        <img src="/img/message.png" />
                    </div>
                    <div class="msg-info">
                        <div class="msg-title"><strong>{{$item->created_at}}</strong><span></span></div>
                        <div class="msg-body">{{$item->text}}</div>
                    </div>

                </div>
            @endforeach

            <i class="row msg" aria-hidden="true" style="background-color: transparent;box-shadow: none;"></i>
                
        </div>

    </div>

     <!-- Modal -->
    <div class="modal fade" id="messageModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>


@endsection

<script>

    window.onload = function () {
       
        $('#messageModal').on('show.bs.modal', function (event) {
            let item = $(event.relatedTarget); 
            let data = item.data('item'); 
            
            $(this).find('.modal-title').text(data.created_at);
            $(this).find('.modal-body').text(data.text);

        });

    };

   

</script>