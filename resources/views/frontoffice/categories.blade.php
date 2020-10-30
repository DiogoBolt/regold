@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/categories/categories.css') }}" rel="stylesheet">
@endsection

@section('content')




    {{-- Go Back Button --}}
    <a class="back-btn" href="/home">
        <span class="back-btn__front"><strong>Voltar</strong></span>
        <span class="back-btn__back"><strong>Home</strong></span>
    </a>
    <a class="fav" href="/frontoffice/favorites">
        <img class="favorito" src="{{ URL::to('/') }}/img/filled-fav.png">FAVORITOS
    </a>

    <div class="container">


        <div class="search-container" data-toggle="modal">
            <div class="fav">
{{--                <a class="fav" href="/frontoffice/favorites">--}}
{{--                    <img src="{{ URL::to('/') }}/img/filled-fav.png">FAVORITOS--}}
{{--                </a>--}}
                <input id="product-search" name="search" placeholder="Pesquisa de produtos.." />
{{--                <a class="fav" href="/frontoffice/favorites">--}}
{{--                    <img class="favorito" src="{{ URL::to('/') }}/img/filled-fav.png">FAVORITOS--}}
{{--                </a>--}}
                <div id="results"></div>
            </div>

           {{-- <input id="product-search" name="search" placeholder="Pesquisa de produtos.." />
            <div id="results"></div>--}}
        </div>

       {{-- <--}}{{--div class="categories-container">
            <a class="category" href="/frontoffice/favorites">
                <div class="fav">
                    FAVORITOS
                </div>
            </a>
            @foreach($categories as $category)
                <a class="category" href="/frontoffice/products/{{ $category->id}}">
                    <div class="category-body">
                        {{$category->name}}
                    </div>
                </a>
            @endforeach
        </div>--}}
        <div class="row">
        @foreach($categories as $category)
            <div class="column">
               <a class="produtos" href="/frontoffice/products/{{ $category->id}}">
                        {{$category->name}}
               </a>
            </div>

            @endforeach
        </div>
        @endsection
    </div>

<script>

    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById('product-search');
        const searchResults = document.getElementById('results');
        
        searchInput.addEventListener('input', function() {
            let searchTerm = this.value.trim();

            /* To easy the load on the database, start search after at least 3 letters */
            if(searchTerm !== '' && searchTerm.length > 2) {
                
                $.get(`/frontoffice/produtos/search/${searchTerm}`,  response => {
                    searchTerm = this.value.trim();

                    if(response.length > 0 ) {
                        let result = '';

                        response.forEach(element => {
                            result += `
                            <div class="search-result">
                                <img class="img-fluid" src="/uploads/products/${element.file}" />
                                <a href="/frontoffice/product/${element.id}">${element.name}</a>
                            </div>`
                        });

                        searchResults.innerHTML = result;
                    } else {
                        searchResults.innerHTML = '<div class="search-result">Sem resultados.</div>';
                    }
                    
                    if(searchTerm === '')  {
                        searchResults.innerHTML = '';
                    }
                });
            } else {
                searchResults.innerHTML = '';
            }
        });
    });


</script>
