@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/products/product.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-bar">
        <p class="container-bar_txt">produto</p>
        <div class="container-bar_img">
            <img src="{{ asset('img/encomendas.jpg') }}" />
        </div>
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">Home</li>
            <li class="breadcrumb-item " aria-current="page">Categorias</li>
            <li class="breadcrumb-item " aria-current="page">Produtos</li>
            <li class="breadcrumb-item active" aria-current="page">Produto</li>
        </ol>
    </nav>

    {{-- Go Back Button --}}
    <a class="back-btn" href="/frontoffice/categories">
        <span class="back-btn__front"><strong>Voltar</strong></span>
        <span class="back-btn__back"><strong>Categorias</strong></span>
    </a>

    <div class="container">
       
        <div class="product">
            <div class="product__img" style="background-image: url('/uploads/{{$product->id}}/{{$product->file}}')"></div>
            <div class="product__body">
                <div class="product__body-info">
                    <div class="product__body-info-txt">
                        <p> Ref. {{ $product->ref }}</p>
                        <h3> {{ $product->name }} </h3>
                    </div>
                    <div class="product_body-info-prices">
                        <p class="price-tag" data-amount="1"> {{ $product->price1 }} €</p>
                        <p class="price-tag" data-amount="{{ $product->amount2 }}"> {{ $product->price2 }} €</p>
                        <p class="price-tag" data-amount="{{ $product->amount3 }}"> {{ $product->price3 }} €</p>
                    </div>
                </div>
                <div class="product__body-desc"> {{ $product->details }}</div>
                <div class="product__body-downloads">
                    <div>
                        <a href="/uploads/{{$product->id}}/{{$product->manual}}" class="btn" download>
                            MANUAL DO PRODUTO <img src="/img/download.png">
                        </a>
                    </div>
                    <div>
                        <a href="/uploads/{{$product->id}}/{{$product->seguranca}}" class="btn" download>
                            FICHA DE SEGURANÇA <img src="/img/download.png">
                        </a>
                    </div>
                    <form action="/frontoffice/products/addcart/"  method="get">
                        {{ csrf_field() }}
                        <button class="btn btn-add">adicionar</button>
                        <input value="{{$product->id}}" name="id" type="hidden">
                        <select name="amount" id="amount">
                            @for($i = 1; $i <= 20; $i++)
                                <option value="{{ $i }}"> {{ $i }}</option>
                            @endfor
                        </select>
                    </form>
                </div>
            </div>
        </div>

    </div>

@endsection

<script>

    document.addEventListener("DOMContentLoaded", function(event) {
        const priceTags = document.querySelectorAll('.price-tag');
        const select = document.getElementById('amount');

        priceTags.forEach(priceTag => {
            priceTag.addEventListener('click', function() {
                const amount = parseInt(this.getAttribute('data-amount'));
                select.value = amount;
            });
        });
    });
</script>