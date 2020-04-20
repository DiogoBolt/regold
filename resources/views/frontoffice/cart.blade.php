@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/cart/cart.css') }}" rel="stylesheet">
@endsection

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="{{ URL::asset('/js/validations.js') }}"></script>
    <div class="container-bar">
        <p class="container-bar_txt">carrinho</p>
        <div class="container-bar_img">
            <img src="{{ asset('img/green-cart.png') }}"/>
        </div>
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">Home</li>
            <li class="breadcrumb-item active" aria-current="page">Carrinho</li>
        </ol>
    </nav>

    {{-- Go Back Button --}}
    <a class="back-btn" href="/home">
        <span class="back-btn__front"><strong>Voltar</strong></span>
        <span class="back-btn__back"><strong>Home</strong></span>
    </a>

    <div class="container">
        @if(count($line_items) > 0 )
            <div class="cart-container">
                @foreach($line_items as $item)
                    <div class="cart-item">
                        <div class="cart-item_img">
                            <span class="price-tag">{{number_format($item->total, 2 , '.', '')}} €</span>
                            <img src="/uploads/products/{{$item->product->file}}">
                        </div>

                        <div class="cart-item_desc">
                            <h3>{{$item->product->name}}</h3>
                            <div class="cart-item_desc-txt">

                                {{$item->product->details}}

                            </div>
                        </div>

                        <div class="cart-item_extra">
                            <select class="remove-item" onchange="removeItem(this,{{$item->id}})" data-product="{{$item->id}}">
                                <option value="" disabled selected>Remover</option>
                                @for($i = 1; $i <= $item->amount; $i++)
                                    <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                            <p>Quantidade:{{$item->amount}}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <form action="/frontoffice/cart/process">
                <div class="form-group">
                    Informações/notas sobre a encomenda <textarea class="form-control" placeholder="Informações/notas sobre a encomenda" name="order_note"></textarea>
                </div>
                <div class="cart-info">
                    <p>Total : {{number_format($totalprod, 2, '.', '')}}€</p>
                    @foreach($items as $item)
                        <p>{{$item['descr']}} : {{number_format($item['amount'], 2, '.','')}} €</p>
                    @endforeach
                    <h4>Total IVA : {{number_format($total,2, '.', '')}} €</h4>
                </div>
                <button class="btn btn-cart">validar carrinho</button>
            </form>
        @else
            <div class="cart-container">
                <h1>O carrinho encontra-se vazio.</h1>
            </div>
        @endif
    </div>

    <div class="modal fade" id="alertModal" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Aviso <span style="float: right;">&#9888;</span></h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-alert" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

@endsection

<!--
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const alertModal = $('#alertModal');
        const removeSelect = $('.remove-item');
        /* Mete aqui as condições para o gajo coiso e tal, nem precisas desses if's todos, o text pode ser uma variavel que consoante
        coiso e tal e cenas mudas e chapas no modal */
        let xpto = false;
        if (xpto) {

            $(this).find('.modal-body').text('O manel é um pétáculo');
            alertModal.modal(); /* Abrir o modal */
        } else if (xpto === 'xpto') {

            $(this).find('.modal-body').text('O manel é um pétáculo');

            alertModal.modal(); /* Abrir o modal */
        }

   /* SELECT */
   removeSelect.on('change', function () {
           const productId = $(this).data('product');
           const removeQuantity = $(this).val();
           $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

            $.ajax({
                method: "POST",
                url: "/frontoffice/cart/removeitem",
                data: {"_token": "{{ csrf_token() }}", id: productId, qt: removeQuantity }
            }).then(
                window.location.reload()
            )
        });
    }, false);
</script>-->