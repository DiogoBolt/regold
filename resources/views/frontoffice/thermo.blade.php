@extends('layouts.frontoffice')

@section('styles')
@endsection

@section('content')
    <div class="container-bar">
        <p class="container-bar_txt">Termometros</p>
        <div class="container-bar_img">
        </div>
    </div>
@if(isset($thermo))
    <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
        <div class="card-header">Termometro {{$thermo->imei}}</div>
        <div class="card-body">
            <h5 class="card-title">{{$thermo->temperature}}</h5>
        </div>
    </div>
    @endif


    <form method="post" action="/thermo/attachthermo">
        Imei : <input name="imei" class="form-control">
        {{ csrf_field() }}
        <button class="btn btn-primary">Novo Termometro</button>

    </form>




@endsection
