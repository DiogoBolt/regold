@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/categories/categories.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-bar">
        <p class="container-bar_txt">documentos {{ $super }}</p>
        <div class="container-bar_img">
            <img src="{{ asset('img/encomendas.jpg') }}" />
        </div>
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">Home</li>
            <li class="breadcrumb-item active" aria-current="page">Documentos {{ $super }}</li>
        </ol>
    </nav>

    {{-- Go Back Button --}}
    <a class="back-btn" href="/home">
        <span class="back-btn__front"><strong>Voltar</strong></span>
        <span class="back-btn__back"><strong>Home</strong></span>
    </a>

    <div class="container">
        <div class="categories-container">
            @foreach($types as $type)
                <a class="category {{ $super }}" href="/frontoffice/documents/{{ $super }}/{{ $type->id}}">
                    <div class="category-body">
                        <img src="/img/logoregoldi.png" class="img-responsive" />
                    </div>
                    <div class="category-footer">
                        {{ $type->name }}
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection