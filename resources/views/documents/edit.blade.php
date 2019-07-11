@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{$type->name}}</div>
                <div class="panel-body">
                    <form action="/documents/edit"  method="post">
                        {{ csrf_field() }}
                        <input value="{{$type->id}}" name="id" style="display:none">
                        <div class="col-sm-6">
                            <div class="form-group">
                                Nome:<input class="form-control"  name="name" value="{{$type->name}}">
                            </div>
                            <button class="btn btn-warning">Editar</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
