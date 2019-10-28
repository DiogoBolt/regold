@extends('layouts.app')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/categories/categories-bo.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container-bar">
    <p class="container-bar_txt">{{$type->name}}</p>
    <div class="container-bar_img">
        <img src="{{ asset('img/doc-green.png') }}" />
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form action="/documents/edit"  method="post">
                        {{ csrf_field() }}
                        <input value="{{$type->id}}" name="id" style="display:none">
                        <div class="col-sm-6">
                            <div class="form-group">
                                Nome:<input class="form-control"  name="name" value="{{$type->name}}">
                            </div>
                            <button class="btn">Editar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
