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
        <li class="breadcrumb-item" aria-current="page"><a
                href="/frontoffice/categories"><strong>Categorias</strong></a></li>
        <li class="breadcrumb-item " aria-current="page">Produtos</li>
        <li class="breadcrumb-item active" aria-current="page">Produto</li>
    </ol>
</nav>

{{-- Go Back Button --}}
<a class="back-btn" href="/frontoffice/products/{{ $product->category }}">
    <span class="back-btn__front"><strong>Voltar</strong></span>
    <span class="back-btn__back"><strong>Produtos</strong></span>
</a>

<div id="mobile-icons">
    <a id="mobile-msg" href="/frontoffice/messages">
        <img src="/img/green-msg.png" alt="mensagens" />
    </a>
    
    <a id="mobile-cart" href="/frontoffice/cart">
        <img src="/img/green-cart.png" alt="carrinho de compras">
    </a>
</div>



<div class="container">
    <div class="product">
        <div class="product__img" style="background-image: url('/uploads/products/{{$product->file}}')"></div>
        <div class="product__body">
            <div class="product__body-main">
                <form action="/frontoffice/products/addcart/" method="get">
                    {{ csrf_field() }}
                    <button class="btn btn-add">Adicionar</button>
                    <input value="{{$product->id}}" name="id" type="hidden" id="product-id">
                    <select name="amount" id="amount">
                        @for($i = 1; $i <= 20; $i++) <option value="{{ $i }}"> {{ $i }}</option>
                            @endfor
                    </select>
                </form>

                <a href="#" id="removeFavourite" style="{{ $isFavourite ? '' : 'display: none;' }}">
                    <img id="favorite" src="/img/filled-fav.png" />
                </a>

                <a href="#" id="addFavourite" style="{{ $isFavourite ? 'display: none;' : '' }}">
                    <img id="favorite" src="/img/fav.png" />
                </a>

            </div>
            <div class="product__body-info">
                <h2> {{ $product->name }} </h2>
                <p> Ref: {{ $product->ref }}</p>
                <div class="product__body-desc"> {{ $product->details }}</div>
            </div>
            <div class="product_body-table-prices">
                <table>
                    <tr>
                        <th>PVP</th>

                    </tr>
                    <tr>
                        @if($pvp == 1)
                            <td class="price-tag">{{ $product->price1 }}€</td>
                        @elseif($pvp == 2)
                            <td class="price-tag">{{ $product->price2 }}€</td>
                        @elseif(($pvp == 3))
                            <td class="price-tag">{{ $product->price3 }}€</td>
                        @elseif(($pvp == 4))
                            <td class="price-tag">{{ $product->price4 }}€</td>
                        @else
                            <td class="price-tag">{{ $product->price5 }}€</td>
                            @endif
                    </tr>
                </table>
            </div>
            <div class="product__body-downloads">
                <span class="info-btn" data-toggle="modal" data-target="#myModal">&#9432;</span>
         
                <div>
                    <a href="/uploads/{{$product->id}}/{{$product->manual}}" class="btn" download>
                        Ficha Técnica <img src="/img/download.png">
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

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Informação</h4>
            </div>
            <div class="modal-body">
                <p><strong> Para ser aplicado o preço do escalão 3 é necessário adquirir mais 3 produtos diferentes, 
                    para ser aplicado o preço do escalão 2 e necessário adquirir mais 2 produtos diferentes</strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-add" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

@endsection

<script>
    document.addEventListener("DOMContentLoaded", function (event) {
        const priceTags = document.querySelectorAll('.price-amount');
        const select = document.getElementById('amount');
        const addFavourite = document.getElementById('addFavourite');
        const removeFavourite = document.getElementById('removeFavourite');
        const productId = document.getElementById('product-id').value;

        priceTags.forEach(priceTag => {
            priceTag.addEventListener('click', function () {
                const amount = parseInt(this.getAttribute('data-amount'));
                select.value = amount;
            });
        });

        addFavourite.addEventListener('click', function (evt) {
            evt.preventDefault();

            $.get(`/frontoffice/favorites/add/${productId}`, function (response) {
                if (response.success) {
                    addFavourite.style.display = 'none';
                    removeFavourite.style.display = 'block';
                }
            });

        });

        removeFavourite.addEventListener('click', function (evt) {
            evt.preventDefault();

            $.get(`/frontoffice/favorites/delete/${productId}`, function (response) {

                if (response.success) {
                    removeFavourite.style.display = 'none';
                    addFavourite.style.display = 'block';
                }
            });
        });
    });
</script>