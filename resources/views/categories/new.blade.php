@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Nova Categoria</div>
                <div class="panel-body">
                    <form action="/categories/add"  method="post">
                        {{ csrf_field() }}
                        <div class="col-sm-6">
                            <div class="form-group">
                                Nome:<input class="form-control"  name="name">
                            </div>

                            <button class="btn btn-primary">Criar</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
