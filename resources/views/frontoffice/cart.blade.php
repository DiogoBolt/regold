@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/cart/cart.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-bar">
        <p class="container-bar_txt">carrinho</p>
        <div class="container-bar_img">
            <img src="{{ asset('img/cart.png') }}" />
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
                                <span class="price-tag">{{number_format($item->total,2)}}€</span>
                                <img src="/uploads/products/{{$item->product->file}}">
                            </div>
                            
                            <div class="cart-item_desc">
                                <h3>{{$item->product->name}}</h3>
                                <div class="cart-item_desc-txt">
                                    
                                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. 
                                        Quam nemo aliquid suscipit labore assumenda repudiandae alias dolores cupiditate saepe 
                                        corporis temporibus ratione mollitia rerum aperiam ipsa, quaerat, quibusdam odio ut.
                                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. 
                                    
                                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. 
                                        Quam nemo aliquid suscipit labore assumenda repudiandae alias dolores cupiditate saepe 
                                        corporis temporibus ratione mollitia rerum aperiam ipsa, quaerat, quibusdam odio ut.
                                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. 
                        
                                </div>
                            </div>    
                
                            <div class="cart-item_extra">
                                <a href="/frontoffice/cart/delete/{{$item->id}}">remover x</a>
                                <p>{{$item->amount}}</p>
                            </div>                    
                        </div>
                    @endforeach     
            </div>

            <div class="cart-info">
                <h4>Total : {{number_format($total + 0.23*$total,2)}}€</h3>
                <p>IVA(23) : {{number_format($total * 0.23,2)}}€</p>
            </div>
     

            <a href="/frontoffice/cart/process" class="btn btn-cart">validar carrinho</a>
        @else 

            <div class="cart-container">
                <h1>O carrinho encontra-se vazio.</h1>
            </div>
        @endif
    </div>


<!--
<th>Img</th>
<th>Nome</th>
<th>Quantidade</th>
<th>Preço/Unidade</th>
<th>Total</th>
<th>Eliminar</th>

<td><img style="height:25px;width:35px" src="/uploads/products/ $item->product->file "></td>
<td> $item->product->name </td>
<td> $item->amount </td>
<td> $item->total/$item->amount €</td>
<td>number_format($item->total,2 €</td>

-->

@endsection
