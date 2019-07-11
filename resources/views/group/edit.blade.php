@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Volta {{$group->name}}</div>
                <div class="panel-body">
                    <form action="/groups/edit"  method="post">
                        {{ csrf_field() }}
                        <input value="{{$group->id}}" name="id" style="display:none">
                        <div class="col-sm-6">
                            <div class="form-group">
                                Nome:<input class="form-control"  name="name" value="{{$group->name}}">
                            </div>

                            <div class="form-group">
                                Detalhes:<textarea class="form-control"  name="details" >{{$group->details}}</textarea>
                            </div>

                            <div class="form-group">
                                Periodicidade Visita: <select class="form-control" name="visit_time">
                                    <option value="Mensal" @if($group->visit_time == "Mensal") selected @endif>Mensal</option>
                                    <option value="Trimestral" @if($group->visit_time == "Trimestral") selected @endif>Trimestral</option>
                                    <option value="Semestral" @if($group->visit_time == "Semestral") selected @endif>Semestral</option>
                                </select>
                            </div>
                            <div class="form-group">
                                Próxima Visita: <input class="form-control"  name="next_visit" value="{{$group->next_visit}}" type="date">
                            </div>

                            <a class="btn btn-primary" href="/clients/group/{{$group->id}}">Clientes</a>
                            <button class="btn btn-warning">Editar</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
