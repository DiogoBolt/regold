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
                <a class="category {{ $super }}" href="{{ $type->name === 'Faturas' ? '/frontoffice/invoices' : '/frontoffice/documents/'. $super . '/' . $type->id }}">
                    <div class="category-body">
                        {{ $type->name }}
                    </div>
                </a>
            @endforeach

            @if($super==='Registos')
                    <a class="category {{ $super }}" href="/frontoffice/oilRecords">
                        <div class="category-body">
                            <img src="/img/logo2white.png" class="img-responsive"/>
                        </div>
                        <div class="category-footer">
                            REGISTOS DE QUALIDADE DO ÓLEO
                        </div>
                    </a>
            @endif

            @if($super === 'HACCP')
                <a class="category {{ $super }}" href="/frontoffice/reports">
                    <div class="category-body">
                        RELATÓRIOS
                    </div>
                </a>
                @if($userType==2 || $userType==5)
                    @if($controlCustomizationClient==1)
                    <a class="category {{ $super }}" href="/frontoffice/newReport">
                        <div class="category-body">
                            NOVO RELATÓRIO
                        </div>
                    @else
                    <a class="category {{ $super }}" href="/frontoffice/newReport" style="display:none">--}}
                        <div class="category-body">
                            NOVO RELATÓRIO
                        </div>
                    </a>
                    @endif
                        @if($showSections==1)
                            <a class="category {{ $super }}" href="/frontoffice/personalizeSection">
                                <div class="category-body">
                                    PERSONALIZAR SECÇÕES
                                </div>
                        @else
                            <a class="category {{ $super }}" href="/frontoffice/personalizeSection" style="display:none">
                                <div class="category-body">
                                    PERSONALIZAR SECÇÕES
                                </div>
                        @endif
                </a>
                @endif
            @endif
                <a class="category {{ $super }}" href="/frontoffice/personalizeAreasEquipments">
                    <div class="category-body">
                        ÁREAS E EQUIPAMENTOS
                    </div>
                </a>

                <a class="category {{ $super }}" href="/frontoffice/statistics">
                    <div class="category-body">
                       ESTATÍSTICAS
                    </div>
                </a>

                @if($super==='Controlopragas')
                    @if($userType==5 || $userType==3)
                        @if($controlFirstServiceClient!=1)
                            <a class="category {{ $super }}" href="/frontoffice/firstService">
                        @else
                            <a class="category {{ $super }}" href="/frontoffice/firstService" style="display: none">
                        @endif
                            <div class="category-body">
                                INSTALAÇÃO SERVIÇO
                            </div>
                        </a>
                        <a class="category {{ $super }}" href="/frontoffice/maintenance">
                            <div class="category-body">
                                MANUTENÇÃO/GARANTIA
                            </div>
                        </a>
                            <a class="category {{ $super }}" href="/frontoffice/punctual">
                                <div class="category-body">
                                     PONTUAL
                                </div>
                                </a>
                    @endif
                        <a class="category {{ $super }}" href="/frontoffice/pestReports">
                            <div class="category-body">
                                RELATÓRIOS
                            </div>
                        </a>
                @endif
        </div>
    </div>
@endsection