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

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">Home</li>
            <li class="breadcrumb-item active" aria-current="page">Mensagens do Sistema</li>
        </ol>
    </nav>
    
    {{-- Go Back Button --}}
    <a class="back-btn" href="/home">
        <span class="back-btn__front"><strong>Voltar</strong></span>
        <span class="back-btn__back"><strong>Home</strong></span>
    </a>

    <div class="dropdown-filter">
        <a href="/frontoffice/messages/allreads/{{$user->client_id}}"><button>Marcar como lidas</button></a>
        <button onclick="myFunction()" class="dropbtn-filter">Filtro</button>
        <div id="myDropdown" class="dropdown-filter-content">
            <a onclick="filterMessage(1)">Caixa de Entrada</a>
            <a onclick="filterMessage(2)">Não Lidas</a>
            <a onclick="filterMessage(3)">Termómetros</a>
            <a onclick="filterMessage(4)">Documentos</a>
            <a onclick="filterMessage(5)">Encomendas</a>
        </div>
    </div>


    <div class="container">
        <div id="messages-container" class="box-body">
            @if($messages->isEmpty())
                <h4 style="position:absolute">Não existem mensagens por ler</h4>
            @else
            @foreach($messages as $item)
                <div id= "{{$item->id}}" class="row msg {{$item->name}}
                    {{$item->viewed === 1 ? 'viewed' : 'not-viewed'}}"
                    data-item="{{ $item }}"
                    data-toggle="modal" data-target="#messageModal">

                    @if($item->viewed == 1)
                    <div  class="msg-img">
                        <img  src="/img/message.png" />
                    </div>
                    @else
                        <div class="msg-img">
                            <img id="img{{$item->id}}" src="/img/message_unread.png" />
                        </div>
                    @endif
                    <div class="msg-info">
                        <div class="msg-title"><strong>{{$item->created_at}}</strong><span></span></div>
                        <div class="msg-body">{{$item->text}}</div>
                    </div>
                </div>
            @endforeach
            @endif
            <i class="row msg" aria-hidden="true" style="background-color: transparent;box-shadow: none;"></i>
        </div>
    </div>

     <!-- Modal -->
    <div class="modal fade" id="messageModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">x</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <strong>Fechar</strong>
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

<script>

    document.addEventListener('DOMContentLoaded', function(){ 
 
       
        $('#messageModal').on('show.bs.modal', function (event) {

            let item = $(event.relatedTarget);
            let data = item.data('item');
            $(this).find('.modal-title').text(data.created_at);
            $(this).find('.modal-body').text(data.text);

            console.log(data.viewed)
            if(data.viewed == 0) {
                $(this).find('.modal-header').addClass('not-viewed');
                $(this).find('.modal-footer button').addClass('not-viewed');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'POST',
                    url: "/frontoffice/message/"+data.id,
                })
                $('#'+data.id).removeClass('row msg not-viewed').addClass('row msg viewed')
                $('#img'+data.id).attr('src','/img/message.png')
            }
        });

    }, false);

    function filterMessage(type) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'GET',
            url:'/frontoffice/messages/'+type,
            async: false,
        }).done(function (data) {
            $('#messages-container').empty()

            if(type==1)
                $(".dropbtn-filter").text('Caixa de Entrada')
            if(type==2)
                $(".dropbtn-filter").text('Não lidas')
            if(type==3)
                $(".dropbtn-filter").text('Termómetros')
            if(type==4)
                $(".dropbtn-filter").text('Documentos')
            if(type==5)
                $(".dropbtn-filter").text('Encomendas')

            for(var i=0;i<data.length;i++ ){
                if(data[i].viewed==0){
                    $('#messages-container').append(`<div id= "${data[i].id}" class="row msg ${data[i].name}
                    ${data[i].viewed === 1 ? 'viewed' : 'not-viewed'}"
                    data-item='{"id":${data[i].id},"text":"${data[i].text}","created_at":"${data[i].created_at}","viewed":"${data[i].viewed}"}'
                    data-toggle="modal" data-target="#messageModal">

                    <div class="msg-img">
                        <img id="img${data[i].id}" src="/img/message_unread.png" />
                    </div>

                    <div class="msg-info">
                        <div class="msg-title"><strong>${data[i].created_at}</strong><span></span></div>
                            <div class="msg-body">${data[i].text}</div>
                        </div>
                    </div>`)
                }
                else
                {
                    $('#messages-container').append(`<div id= "${data[i].id}" class="row msg ${data[i].name}
                    ${data[i].viewed === 1 ? 'viewed' : 'not-viewed'}"
                        data-item='{"id":${data[i].id},"text":"${data[i].text}","created_at":"${data[i].created_at}","viewed":"${data[i].viewed}"}'
                        data-toggle="modal" data-target="#messageModal">

                        <div  class="msg-img">
                            <img  src="/img/message.png" />
                        </div>

                        <div class="msg-info">
                            <div class="msg-title"><strong>${data[i].created_at}</strong><span></span></div>
                                <div class="msg-body">${data[i].text}</div>
                            </div>
                        </div>`)
                }
            }
        });
    }
    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    // Close the dropdown if the user clicks outside of it
    window.onclick = function(event) {
        if (!event.target.matches('.dropbtn-filter')) {
            var dropdowns = document.getElementsByClassName("dropdown-filter-content");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }

</script>