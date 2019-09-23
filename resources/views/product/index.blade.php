@extends('layouts.app')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/products/products-bo.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-bar">
        <p class="container-bar_txt">produtos</p>
        <div class="container-bar_img">
            <img src="{{ asset('img/produtos.jpg') }}" />
        </div>
    </div>

    <div class="container">

        <a href="/products/new" class="btn btn-add">Novo Produto</a>

        <div class="products-container">
            
            @foreach($products as $product)
                <div class="product">

                    <div class="product-img" 
                        style="background-image:url('/uploads/products/{{$product->file}}')">
                        <a href="/products/{{$product->id}}"></a>
                    </div>

                    <div class="product-info">
                        <div class="product-info__header">
                            <div class="product-info__header-prices">
                                <span>Escalão 1 : <b>{{$product->price1}}</b></span>
                                <span>Escalão 2 : <b>{{$product->price2}}</b></span>
                                <span>Escalão 3 : <b>{{$product->price3}}</b></span>
                            </div>
                            <div class="product-info__header-title">
                                {{$product->name}}
                            </div>
                        </div>
                  
                        <div class="product-info__footer">
                            {{$product->details}}
                        </div>
                    </div>
                       
                </div>
            @endforeach
            
        </div>
    </div>

@endsection
