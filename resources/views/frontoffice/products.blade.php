@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/products/products.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-bar">
        <p class="container-bar_txt">loja ? produtos ?</p>
        <div class="container-bar_img">
            <img src="{{ asset('img/encomendas.jpg') }}" />
        </div>
    </div>

    <div class="container">
        <div class="products-container">
            @foreach($products as $product)
                <div class="product">
                    <div class="product-img" style="background-image: url('/uploads/products/{{$product->file}}')">
                        <a href="/frontoffice/products/{{$product->id}}"></a>
                        <span class="product-img__price">
                            {{$product->price1}}€
                        </span>
                    </div>
                    <div class="product-desc">
                        <h2 class="product-desc__title">{{$product->name}}</h2>
                        <div class="product-desc__txt">
                            {{$product->details}}
                        </div>
                        <div class="product-desc__add">
                            <form action="/frontoffice/products/addcart/"  method="get">
                                {{ csrf_field() }}
                                <button class="btn">adicionar</button>
                                <input value="{{$product->id}}" name="id" type="hidden">
                                <select name="amount">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
            
        </div>
    </div>





@endsection

{{-- 
    <div align="center" style="height:10%">{{$product->category}}</div>
    <div align="center" style="color:green;margin-top:5px">Escalão 1 : <b>{{$product->price1}}€</b></div>
    <div align="center" style="color:green">Escalão 2 : ({{$product->amount2}}) <b>{{$product->price2}}€</b></div>
    <div align="center" style="color:green">Escalão 3 : ({{$product->amount3}}) <b>{{$product->price3}}€</b></div>
 --}}