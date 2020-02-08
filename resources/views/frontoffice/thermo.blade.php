@extends('layouts.frontoffice')

@section('styles')
@endsection

@section('content')
    <div class="container-bar">
        <p class="container-bar_txt">Termometros</p>
        <div class="container-bar_img">
        </div>
    </div>
@foreach($thermos as $key => $value)
    <div class="container" align="center">
    <div align="center" class="card text-white bg-success mb-3 " style="max-width: 18rem;">
        <div class="card-header">Termometro {{$key}}</div>
        <div class="card-body">
            <h5 class="card-title" id="{{$key}}">{{$value}}ºc</h5>
        </div>
    </div>
    </div>
    @endforeach



    <form method="post" action="/thermo/attachthermo">
        Imei : <input name="imei" class="form-control">
        {{ csrf_field() }}
        <button class="btn btn-primary">Novo Termometro</button>

    </form>

@endsection
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>


    setInterval(function(){
        @foreach($thermos as $key => $value)

        $.get( "/thermo/getTemperature/"+{{$key}}, function( data ) {
            $( "#" + {{$key}} ).html( data );
        });


        @endforeach
    },5000);


</script>
