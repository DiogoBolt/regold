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
            <li class="breadcrumb-item" aria-current="page"><a href="/frontoffice/categories"><strong>Categorias</strong></a></li>
            <li class="breadcrumb-item " aria-current="page">Produtos</li>
            <li class="breadcrumb-item active" aria-current="page">Produto</li>
        </ol>
    </nav>

    {{-- Go Back Button --}}
    <a class="back-btn" href="/frontoffice/products/{{ $product->category }}">
        <span class="back-btn__front"><strong>Voltar</strong></span>
        <span class="back-btn__back"><strong>Produtos</strong></span>
    </a>

    <div class="container">
       
        <div class="product">
            <div class="product__img" style="background-image: url('/uploads/products/{{$product->file}}')"></div>
            <div class="product__body">
                <div class="product__body-main">
                    <form action="/frontoffice/products/addcart/"  method="get">
                        {{ csrf_field() }}
                        <button class="btn btn-add">Adicionar</button>
                        <input value="{{$product->id}}" name="id" type="hidden">
                        <select name="amount" id="amount">
                            @for($i = 1; $i <= 20; $i++)
                                <option value="{{ $i }}"> {{ $i }}</option>
                            @endfor
                        </select>
                    </form>
                    <img src="/img/fav.png"/>
                </div>
                <div class="product__body-info">
                    <h2> {{ $product->name }} </h2>
                    <p> Ref: {{ $product->ref }}</p>  
                    <div class="product__body-desc"> {{ $product->details }}</div>
                </div>
                <div class="product_body-table-prices">
                    <table>
                        <tr>
                            <th>Escalão 1</th>
                            <th>Escalão 2</th>
                            <th>Escalão 3</th>
                        </tr>
                        <tr>
                            <td class="price-amount" data-amount="1">1 unidade</td>
                            <td class="price-amount" data-amount="{{ $product->amount2 }}">{{ $product->amount2 }} unidades</td>
                            <td class="price-amount" data-amount="{{ $product->amount3 }}">{{ $product->amount3 }} unidades</td>
                        </tr>
                        <tr>
                            <td class="price-tag">{{ $product->price1 }} €</td>
                            <td class="price-tag">{{ $product->price2 }} €</td>
                            <td class="price-tag">{{ $product->price3 }} €</td>
                        </tr>
                    </table>
                </div>
                <div class="product__body-downloads">
                    <div>
                        <a href="/uploads/{{$product->id}}/{{$product->manual}}" class="btn" download>
                            Manual do Produto <img src="/img/download.png">
                        </a>
                    </div>
                    <div>
                        <a href="/uploads/{{$product->id}}/{{$product->seguranca}}" class="btn" download>
                            Ficha de Segurança <img src="/img/download.png">
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

<script>

    document.addEventListener("DOMContentLoaded", function(event) {
        const priceTags = document.querySelectorAll('.price-amount');
        const select = document.getElementById('amount');

        priceTags.forEach(priceTag => {
            priceTag.addEventListener('click', function() {
                const amount = parseInt(this.getAttribute('data-amount'));
                select.value = amount;
            });
        });
    });
</script>