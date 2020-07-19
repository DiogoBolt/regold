@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/documents/temp-register.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-bar">
        <p class="container-bar_txt">
            REGISTOS DE TEMPERATURA
        </p>
        <div class="container-bar_img">
            <img src="/img/haccp_icon.png"/>
        </div>
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">Home</li>
            <li class="breadcrumb-item " aria-current="page">Documentos Registos</li>
            <li class="breadcrumb-item active" aria-current="page">Temperaturas</li>
        </ol>
    </nav>

    {{-- Go Back Button --}}
    <a class="back-btn" href="/frontoffice/documents/registos">
        <span class="back-btn__front"><strong>Voltar</strong></span>
        <span class="back-btn__back"><strong>Documentos Registos</strong></span>
    </a>

    <div class="container">
        <div class="register-info">
            <p> registos de temperatura </p>
            <p> {{$today}} </p>
        </div>

        <a class="file-link" id="filter-link" data-toggle="collapse" href="#collapse-thermo" role="button"
           aria-expanded="false" aria-controls="collapse-thermo">
            <strong>Novo Termometro</strong>
        </a>

        <div class="collapse" id="collapse-thermo">
            <div class="card-body">
                <form method="post" action="/thermo/attachthermo">
                    Tipo :
                    <select name="type" class="form-control" required>
                        <option value="" disabled selected>Seleccione tipo</option>
                        <option value="1">Refrigeração</option>
                        <option value="2">Congelação</option>
                    </select>
                    Imei : <input name="imei" class="form-control" required>
                    Numero Arca : <input name="number" class="form-control" required>
                    {{ csrf_field() }}
                    <button class="btn btn-add">Adicionar</button>
                </form>
            </div>
        </div>

        <div class="register-container">
            @foreach($clientThermos as $thermo)
                @if($thermo->type === 1)
                    <div class="register-arc cooling">
                        <div class="register-arc__info">
                            <p>arca de refrigeração</p>
                            <h1>{{$thermo->id}}</h1>
                        </div>
                        <div class="register-arc__data">
                            <span>{{$thermo->fridgeType->min_temp}}º/c até {{$thermo->fridgeType->max_temp}}º/c</span>
                            <div class="register-arc__data_temps">
                                <div>
                                    <h3 class="temperature normal">{{number_format($thermo->thermo->temperature, 1)}}</h3>
                                    <p>manhã</p>
                                </div>
                                <div>
                                    <h3 class="temperature normal">{{number_format($thermo->thermo->temperature, 1)}}</h3>
                                    <p>tarde</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="register-arc freezing">
                        <div class="register-arc__info">
                            <p>arca de congelação</p>
                            <h1>{{$thermo->id}}</h1>
                        </div>
                        <div class="register-arc__data">
                            <span>{{$thermo->fridgeType->min_temp}}º/c até {{$thermo->fridgeType->max_temp}}º/c</span>
                            <div class="register-arc__data_temps">
                                <div>
                                    <h3 class="temperature">
                                        {{number_format($thermo->thermo->temperature, 1)}}
                                    </h3>
                                    <p>manhã</p>
                                </div>
                                <div>
                                    <h3 class="temperature">
                                        {{number_format($thermo->thermo->temperature, 1)}}
                                    </h3>
                                    <p>tarde</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <a class="btn btn-history" href="/frontoffice/records/temperatures/history">histórico</a>
    </div>
@endsection
