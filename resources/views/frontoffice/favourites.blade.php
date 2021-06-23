@extends('layouts.frontoffice')

@section('styles')
<!-- Custom CSS -->
<link href="{{ asset('css/favourites/favourites.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container-bar">
    <p class="container-bar_txt">favoritos</p>
    <div class="container-bar_img">
        <img src="{{ asset('img/filled-fav.png') }}" />
    </div>
</div>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page">Home</li>
        <li class="breadcrumb-item active" aria-current="page">Favoritos</li>
    </ol>
</nav>

{{-- Go Back Button --}}
<a class="back-btn" href="/home">
    <span class="back-btn__front"><strong>Voltar</strong></span>
    <span class="back-btn__back"><strong>Home</strong></span>
</a>

<div class="container">

    <div class="favourites-container">

        @if(count($favourites) > 0)
            @foreach($favourites as $favourite)
                <div class="favourites">
                    <div class="favourites-img" style="background-image:url('/uploads/products/{{$favourite->file}}')">
                        <a href="/frontoffice/product/{{$favourite->id}}"></a>
                    </div>

                    <div class="favourites-info">
                        <div class="favourites-info__header">
                            {{$favourite->name}}
                        </div>

                        <div class="favourites-info__footer">
                            <button class="btn-remove removeFavourite" data-id="{{$favourite->id}}">
                                REMOVER
                            </button>
                        </div>
                    </div>

                </div>
            @endforeach
        @else
            <h1> Ainda não possui nenhum produto adicionado aos favoritos. </h1>
            <h1> Visite a nossa página de <a href="/frontoffice/categories">produtos</a>.</h1>
        @endif

    </div>

</div>

@endsection

<script>
    document.addEventListener("DOMContentLoaded", function (event) {
        const removeFavourite = document.querySelectorAll('.removeFavourite');
        const favouritesContainer = document.querySelector('.favourites-container');

        removeFavourite.forEach(function (elem) {
            elem.addEventListener('click', function () {
                const productId = this.getAttribute('data-id');
                const parent = this.parentNode.parentNode.parentNode;
                $.get(`/frontoffice/favorites/delete/${productId}`, function (response) {

                    if (response.success) {
                        parent.remove();

                        if(document.querySelectorAll('.removeFavourite').length === 0) {
                            favouritesContainer.innerHTML = `
                                <h1> Ainda não possui nenhum produto adicionado aos favoritos. </h1>
                                <h1> Visite a nossa página de <a href="/frontoffice/categories">productos</a>.</h1>
                            `;
                        };
                    }

                });
            });
        });

    });
</script>