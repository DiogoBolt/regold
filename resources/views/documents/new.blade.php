@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/documents/type-add.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container-bar">
    <p class="container-bar_txt">Novo Tipo Documento</p>
    <div class="container-bar_img">
        <img src="{{ asset('img/doc-green.png') }}" />
    </div>
</div>
<div class="container">
    <div class="row">
          
        <div class="panel-body type-body">
            <form action="/documents/add" method="post">
                {{ csrf_field() }}
                <div class="col-sm-6">
                    <div class="form-group">
                        Nome:<input class="form-control"  name="name">
                    </div>

                    <div class="form-group">
                        Super Tipo: <select class="form-control" name="type">
                            @foreach($types as $type)
                                <option value="{{$type->id}}">{{$type->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <button class="btn btn-add"><strong>Criar</strong></button>

                </div>
            </form>
        </div>
           
    </div>
</div>

@endsection
