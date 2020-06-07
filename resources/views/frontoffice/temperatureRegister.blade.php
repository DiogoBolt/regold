@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/documents/temp-register.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-bar">
        <p class="container-bar_txt">Documentos ----</p>
        <div class="container-bar_img">
            <img src="/img/haccp_icon.png"/>
        </div>
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">Home</li>
            <li class="breadcrumb-item " aria-current="page">Documentos ---</li>
            <li class="breadcrumb-item active" aria-current="page">Documento</li>
        </ol>
    </nav>

    {{-- Go Back Button --}}
    <a class="back-btn" href="">
        <span class="back-btn__front"><strong>Voltar</strong></span>
        <span class="back-btn__back"><strong>Documentos -----</strong></span>
    </a>

    <div class="container">
        <div class="register-info">
            <p> registos de temperatura </p>
            <p> 24/10/2020 </p>
        </div>

        <div class="register-container">
            <!-- meter class correspondente
                refrigeração -> cooling
                 congelação -> freezing
             -->
            <div class="register-arc cooling">
                <div class="register-arc__info">
                    <!-- preencher estes dados com vars -->
                    <p>arca de refrigeração</p>
                    <h1>Nº 1</h1>
                </div>
                <div class="register-arc__data">
                    <span>intervalo (0ºC a 5ºC)</span>
                    <div class="register-arc__data_temps">
                        <div>
                            <h3 class="temperature normal">5º</h3>
                            <p>manhã</p>
                        </div>
                        <div>
                            <h3 class="temperature normal">4º</h3>
                            <p>tarde</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="register-arc cooling">
                <div class="register-arc__info">
                    <!-- preencher estes dados com vars -->
                    <p>arca de refrigeração</p>
                    <h1>Nº 2</h1>
                </div>
                <div class="register-arc__data">
                    <span>intervalo (0ºC a 5ºC)</span>
                    <div class="register-arc__data_temps">
                        <div>
                            <h3 class="temperature medium">6º</h3>
                            <p>manhã</p>
                        </div>
                        <div>
                            <h3 class="temperature high">9º</h3>
                            <p>tarde</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="register-arc cooling">
                <div class="register-arc__info">
                    <!-- preencher estes dados com vars -->
                    <p>arca de refrigeração</p>
                    <h1>Nº 3</h1>
                </div>
                <div class="register-arc__data">
                    <span>intervalo (0ºC a 5ºC)</span>
                    <div class="register-arc__data_temps">
                        <div>
                            <h3 class="temperature normal">3º</h3>
                            <p>manhã</p>
                        </div>
                        <div>
                            <h3 class="temperature">
                                <img src="/img/question_mark.png"/>
                            </h3>
                            <p>tarde</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="register-arc freezing">
                <div class="register-arc__info">
                    <!-- preencher estes dados com vars -->
                    <p>arca de congelação</p>
                    <h1>Nº 1</h1>
                </div>
                <div class="register-arc__data">
                    <span>intervalo (-18ºC a 0ºC)</span>
                    <div class="register-arc__data_temps">
                        <div>
                            <h3 class="temperature normal">-18º</h3>
                            <p>manhã</p>
                        </div>
                        <div>
                            <h3 class="temperature normal">-16º</h3>
                            <p>tarde</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="register-arc freezing">
                <div class="register-arc__info">
                    <!-- preencher estes dados com vars -->
                    <p>arca de congelação</p>
                    <h1>Nº 2</h1>
                </div>
                <div class="register-arc__data">
                    <span>intervalo (-18ºC a 0ºC)</span>
                    <div class="register-arc__data_temps">
                        <div>
                            <h3 class="temperature">
                                <img src="/img/question_mark.png"/>
                            </h3>
                            <p>manhã</p>
                        </div>
                        <div>
                            <h3 class="temperature">
                                <img src="/img/question_mark.png"/>
                            </h3>
                            <p>tarde</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <button class="btn btn-history">histórico</button>
    </div>

@endsection
