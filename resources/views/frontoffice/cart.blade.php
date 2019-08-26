@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/cart/cart.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-bar">
        <p class="container-bar_txt">carrinho</p>
        <div class="container-bar_img">
            <img src="{{ asset('img/cart.png') }}"/>
        </div>
    </div>

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
                            <a href="/frontoffice/cart/delete/{{$item->id}}">remover x</a>
                            <p>Quantidade:{{$item->amount}}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="cart-info">
                <p>Total : {{number_format($totalprod, 2, '.', '')}}€</p>
                @foreach($items as $item)
                    <p>{{$item['descr']}} : {{number_format($item['amount'], 2, '.','')}} €</p>
                @endforeach
                <h4>Total IVA : {{number_format($total,2, '.', '')}} €</h4>

            </div>


            <a href="/frontoffice/cart/process" class="btn btn-cart">validar carrinho</a>
        @else

            <div class="cart-container">
                <h1>O carrinho encontra-se vazio.</h1>
            </div>
        @endif
    </div>


@endsection
