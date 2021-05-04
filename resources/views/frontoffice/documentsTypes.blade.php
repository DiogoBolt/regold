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

    <div class="container">
        <div class="categories-container">
            @foreach($types as $type)
                <a class="category {{ $super }}" href="{{ $type->name === 'Faturas' ? '/frontoffice/invoices' : '/frontoffice/documents/'. $super . '/' . $type->id }}">
                    <div class="category-body">
                        <img class="img-categories" src="{{ URL::to('/') }}{{$type->url_image}}">
                        {{ $type->name }}
                    </div>
                </a>
            @endforeach

            @if($super==='Registos')
                @if($clientPermission->permission==1)
                    <a class="category {{ $super }}" >
                        <div class="category-body-disabled">
                            <img class="img-categories-disabled" src="{{ URL::to('/') }}/img/relatorio.png">
                            QUALIDADE DO ÓLEO
                        </div>
                    </a>
                    <a class="category {{ $super }}" >
                        <div class="category-body-disabled">
                            <img class="img-categories-disabled" src="{{ URL::to('/') }}/img/relatorio.png">
                            REGISTOS DE HIGIENE
                        </div>
                    </a>

                    <a class="category {{ $super }}">
                        <div class="category-body-disabled">
                            <img class="img-categories-disabled" src="{{ URL::to('/') }}/img/relatorio.png">
                            ENTRADA DE PRODUTO
                        </div>
                    </a>
                   {{-- <a class="category {{ $super }}" >
                        <div class="category-body-disabled">
                            <img class="img-categories-disabled" src="{{ URL::to('/') }}/img/areas_equipamentos.png">
                            ÁREAS E EQUIPAMENTOS
                        </div>
                    </a>--}}
                    @else
                        <a class="category {{ $super }}" href="/frontoffice/records/oil">
                            <div class="category-body">
                                <img class="img-categories" src="{{ URL::to('/') }}/img/relatorio.png">
                                QUALIDADE DO ÓLEO
                            </div>
                        </a>
                        <a class="category {{ $super }}" href="/frontoffice/records/hygiene">
                            <div class="category-body">
                                <img class="img-categories" src="{{ URL::to('/') }}/img/relatorio.png">
                                REGISTOS DE HIGIENE
                            </div>
                        </a>

                        <a class="category {{ $super }}" href="/frontoffice/records/insertProduct">
                            <div class="category-body">
                                <img class="img-categories" src="{{ URL::to('/') }}/img/relatorio.png">
                                ENTRADA DE PRODUTO
                            </div>
                        </a>
                        {{--@if($userType!=4)
                        <a class="category {{ $super }}" href="/frontoffice/personalizeAreasEquipments">
                            <div class="category-body">
                                <img class="img-categories" src="{{ URL::to('/') }}/img/areas_equipamentos.png">
                                ÁREAS E EQUIPAMENTOS
                            </div>
                        </a>
                        @endif--}}
                    @endif
            @endif

            @if($super === 'HACCP')
                <a class="category {{ $super }}"  href="/frontoffice/reports">
                    <div  class="category-body">
                        <img class="img-categories" src="{{ URL::to('/') }}/img/relatorio.png">
                        RELATÓRIOS
                    </div>
                </a>
                @if($userType==2 || $userType==5)
                    @if($controlCustomizationClient==1)
                    <a class="category {{ $super }}" href="/frontoffice/newReport">
                        <div class="category-body">
                            <img class="img-categories" src="{{ URL::to('/') }}/img/novo.png">
                            NOVO RELATÓRIO
                        </div>
                    @else
                    <a class="category {{ $super }}" href="/frontoffice/newReport" style="display:none">--}}
                        <div class="category-body">
                            <img class="img-categories" src="{{ URL::to('/') }}/img/novo.png">
                            NOVO RELATÓRIO
                        </div>
                    </a>
                    @endif
                        @if($showSections==1)
                            <a class="category {{ $super }}" href="/frontoffice/personalizeSection">
                                <div class="category-body">
                                    <img class="img-categories" src="{{ URL::to('/') }}/img/personalizar.png">
                                    PERSONALIZAR SECÇÕES
                                </div>
                            </a>
                        @else
                            <a class="category {{ $super }}" href="/frontoffice/personalizeSection" style="display:none">
                                <div class="category-body">
                                    <img class="img-categories" src="{{ URL::to('/') }}/img/personalizar.png">
                                    PERSONALIZAR SECÇÕES
                                </div>
                            </a>
                        @endif
                @endif
                        @if($userType!=4)
                                <a class="category {{ $super }}" href="/frontoffice/personalizeAreasEquipments">
                                    <div class="category-body">
                                        <img class="img-categories" src="{{ URL::to('/') }}/img/areas_equipamentos.png">
                                        ÁREAS E EQUIPAMENTOS
                                    </div>
                                </a>
                        @endif

                                <a class="category {{ $super }}" href="/frontoffice/statistics">
                                    <div class="category-body">
                                        <img class="img-categories" src="{{ URL::to('/') }}/img/estatisticas.png">
                                        ESTATÍSTICAS
                                    </div>
                                </a>
            @endif



                @if($super==='Controlopragas')
                    @if($userType==5 || $userType==3)
                        @if($controlFirstServiceClient!=1)
                            <a class="category {{ $super }}" href="/frontoffice/firstService">
                        @else
                            <a class="category {{ $super }}" href="/frontoffice/firstService" style="display: none">
                        @endif
                            <div class="category-body">
                                <img class="img-categories" src="{{ URL::to('/') }}/img/novo.png">
                                INSTALAÇÃO SERVIÇO
                            </div>
                        </a>
                        <a class="category {{ $super }}" href="/frontoffice/maintenance">
                            <div class="category-body">
                                <img class="img-categories" src="{{ URL::to('/') }}/img/novo.png">
                                MANUTENÇÃO
                            </div>
                        </a>
                            <a class="category {{ $super }}" href="/frontoffice/warranty">
                                <div class="category-body">
                                   <img class="img-categories" src="{{ URL::to('/') }}/img/novo.png">
                                   GARANTIA
                                </div>
                            </a>
                            <a class="category {{ $super }}" href="/frontoffice/punctual">
                                <div class="category-body">
                                    <img class="img-categories" src="{{ URL::to('/') }}/img/novo.png">
                                     PONTUAL
                                </div>
                            </a>
                    @endif
                        <a class="category {{ $super }}" href="/frontoffice/pestReports">
                            <div class="category-body">
                                <img class="img-categories" src="{{ URL::to('/') }}/img/relatorio.png">
                                CERTIFICADO DE SERVIÇO
                            </div>
                        </a>
                @endif
        </div>
    </div>
@endsection