@extends('layouts.app')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/categories/categories.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-bar">
        <p class="container-bar_txt">produtos</p>
        <div class="container-bar_img">
            <img src="{{ asset('img/produtos.jpg') }}" />
        </div>
    </div>

    <div class="container">

        <a href="/newproduct" class="btn btn-new">Novo Produto</a>

        <div class="search-container">
            <input id="product-search" name="search" placeholder="Pesquisa de produtos.." />
            <div id="results"></div>
        </div>

        <div class="categories-container">
            @foreach($categories as $category)
                <a class="category" href="/products/{{ $category->id}}">
                    <div class="category-body">
                        <img src="/img/logoregoldi.png" class="img-responsive" />
                    </div>
                    <div class="category-footer">
                        {{ $category->name }}
                    </div>
                </a>
            @endforeach
        </div>
    </div>

@endsection

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
                                <a href="/products/${element.category}/${element.id}">${element.name}</a>
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