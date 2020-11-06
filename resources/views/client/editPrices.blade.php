@extends('layouts.app')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/client/client-add.css') }}" rel="stylesheet">
@endsection

@section('content')
<script src="{{ URL::asset('/js/validations.js') }}"></script>


<div class="container-bar">
    <p class="container-bar_txt">Editar Preços {{$client->name}}</p>
    <div class="container-bar_img">
        <img src="{{ asset('img/add-user.png') }}" />
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                   @foreach($pvps as $pvp)
                       <h3>{{$pvp->name}}</h3>
                        @switch($pvp->pvp)
                            @case(1)
                            <input type="checkbox" class="radio-inline"  onchange="sendPost({{$pvp}},1)" id="{{$pvp}}pvp1" name="{{$pvp}}" value="1" checked>
                            <label for="{{$pvp}}pvp1"> PVP1</label><br>
                            <input type="checkbox" class="radio-inline" onchange="sendPost({{$pvp}},2)" id="{{$pvp}}pvp2" name="{{$pvp}}"  value="2" >
                            <label for="{{$pvp}}pvp2"> PVP2</label><br>
                            <input type="checkbox" class="radio-inline" onchange="sendPost({{$pvp}},3)" id="{{$pvp}}pvp3" name="{{$pvp}}" value="3" >
                            <label for="{{$pvp}}pvp3"> PVP3</label><br>
                            <input type="checkbox" class="radio-inline" onchange="sendPost({{$pvp}},4)" id="{{$pvp}}pvp4" name="{{$pvp}}"  value="4" >
                            <label for="{{$pvp}}pvp4"> PVP4</label><br>
                            <input type="checkbox" class="radio-inline"  onchange="sendPost({{$pvp}},5)" id="{{$pvp}}pvp5" name="{{$pvp}}" value="5" >
                            <label for="{{$pvp}}pvp5"> PVP5</label><br>
                            @break
                            @case(2)
                            <input type="checkbox" class="radio-inline" onchange="sendPost({{$pvp}},1)" id="{{$pvp}}pvp1" name="{{$pvp}}" value="1" >
                            <label for="{{$pvp}}pvp1"> PVP1</label><br>
                            <input type="checkbox" class="radio-inline" onchange="sendPost({{$pvp}},2)" id="{{$pvp}}pvp2" name="{{$pvp}}" value="2" checked>
                            <label for="{{$pvp}}pvp2"> PVP2</label><br>
                            <input type="checkbox" class="radio-inline" onchange="sendPost({{$pvp}},3)" id="{{$pvp}}pvp3" name="{{$pvp}}" value="3" >
                            <label for="{{$pvp}}pvp3"> PVP3</label><br>
                            <input type="checkbox" class="radio-inline" onchange="sendPost({{$pvp}},4)" id="{{$pvp}}pvp4" name="{{$pvp}}" value="4" >
                            <label for="{{$pvp}}pvp4"> PVP4</label><br>
                            <input type="checkbox" class="radio-inline" onchange="sendPost({{$pvp}},5)" id="{{$pvp}}pvp5" name="{{$pvp}}" value="5" >
                            <label for="{{$pvp}}pvp5"> PVP5</label><br>
                            @break
                        @case(3)
                            <input type="checkbox" class="radio-inline" onchange="sendPost({{$pvp}},1)" id="{{$pvp}}pvp1" name="{{$pvp}}" value="1" >
                            <label for="{{$pvp}}pvp1"> PVP1</label><br>
                            <input type="checkbox" class="radio-inline" onchange="sendPost({{$pvp}},2)" id="{{$pvp}}pvp2" name="{{$pvp}}" value="2" >
                            <label for="{{$pvp}}pvp2"> PVP2</label><br>
                            <input type="checkbox" class="radio-inline" onchange="sendPost({{$pvp}},3)" id="{{$pvp}}pvp3" name="{{$pvp}}" value="3" checked>
                            <label for="{{$pvp}}pvp3"> PVP3</label><br>
                            <input type="checkbox" class="radio-inline" onchange="sendPost({{$pvp}},4)" id="{{$pvp}}pvp4" name="{{$pvp}}" value="4" >
                            <label for="{{$pvp}}pvp4"> PVP4</label><br>
                            <input type="checkbox" class="radio-inline" onchange="sendPost({{$pvp}},5)" id="{{$pvp}}pvp5" name="{{$pvp}}" value="5" >
                            <label for="{{$pvp}}pvp5"> PVP5</label><br>
                            @break
                            @case(4)
                            <input type="checkbox"  class="radio-inline" onchange="sendPost({{$pvp}},1)" id="{{$pvp}}pvp1" name="{{$pvp}}" value="1" >
                            <label for="{{$pvp}}pvp1"> PVP1</label><br>
                            <input type="checkbox" class="radio-inline" onchange="sendPost({{$pvp}},2)" id="{{$pvp}}pvp2" name="{{$pvp}}" value="2" >
                            <label for="{{$pvp}}pvp2"> PVP2</label><br>
                            <input type="checkbox" class="radio-inline" onchange="sendPost({{$pvp}},3)" id="{{$pvp}}pvp3" name="{{$pvp}}" value="3" >
                            <label for="{{$pvp}}pvp3"> PVP3</label><br>
                            <input type="checkbox" class="radio-inline" onchange="sendPost({{$pvp}},4)" id="{{$pvp}}pvp4" name="{{$pvp}}" value="4" checked>
                            <label for="{{$pvp}}pvp4"> PVP4</label><br>
                            <input type="checkbox" class="radio-inline" onchange="sendPost({{$pvp}},5)" id="{{$pvp}}pvp5" name="{{$pvp}}"  value="5" >
                            <label for="{{$pvp}}pvp5"> PVP5</label><br>
                            @break
                            @case(5)
                            <input type="checkbox" class="radio-inline" onchange="sendPost({{$pvp}},1)" id="{{$pvp}}pvp1" name="{{$pvp}}" value="1" >
                            <label for="{{$pvp}}pvp1"> PVP1</label><br>
                            <input type="checkbox" class="radio-inline" onchange="sendPost({{$pvp}},2)" id="{{$pvp}}pvp2" name="{{$pvp}}" value="2" >
                            <label for="{{$pvp}}pvp2"> PVP2</label><br>
                            <input type="checkbox" class="radio-inline" onchange="sendPost({{$pvp}},3)" id="{{$pvp}}pvp3" name="{{$pvp}}" value="3" >
                            <label for="{{$pvp}}pvp3"> PVP3</label><br>
                            <input type="checkbox" class="radio-inline" onchange="sendPost({{$pvp}},4)" id="{{$pvp}}pvp4" name="{{$pvp}}" value="4" >
                            <label for="{{$pvp}}pvp4"> PVP4</label><br>
                            <input type="checkbox" class="radio-inline" onchange="sendPost({{$pvp}},5)" id="{{$pvp}}pvp5" name="{{$pvp}}" value="5"checked >
                            <label for="{{$pvp}}pvp5"> PVP5</label><br>
                            @break
                            @default
                        @endswitch
                       @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
<script>
        function sendPost(id,value)
        {
        $.ajax({
            type: "POST",
            url: "/editpricepvp",
            data: {
                "_token": "{{ csrf_token() }}",
                id: id, // < note use of 'this' here
                value: value
            },
            success: function(result) {
                window.location.reload()
            },
            error: function(result) {
                alert('error');
            }
        });
    };

</script>

@endsection

