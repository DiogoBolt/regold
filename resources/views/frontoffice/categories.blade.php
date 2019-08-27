@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/categories/categories.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-bar">
        <p class="container-bar_txt">categorias</p>
        <div class="container-bar_img">
            <img src="{{ asset('img/encomendas.jpg') }}" />
        </div>
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">Home</li>
            <li class="breadcrumb-item active" aria-current="page">Categorias</li>
        </ol>
    </nav>

    {{-- Go Back Button --}}
    <a class="back-btn" href="/home">
        <span class="back-btn__front"><strong>Voltar</strong></span>
        <span class="back-btn__back"><strong>Home</strong></span>
    </a>

    <div class="container">
        <div class="categories-container">
            @foreach($categories as $category)
                <a class="category" href="/frontoffice/products/{{ $category->id}}">
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