@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Novo Grupo</div>
                <div class="panel-body">
                    <form action="/groups/add"  method="post">
                        {{ csrf_field() }}
                        <div class="col-sm-6">
                            <div class="form-group">
                                Nome:<input class="form-control"  name="name">
                            </div>

                            <div class="form-group">
                                Detalhes:<input class="form-control"  name="details">
                            </div>

                            <div class="form-group">
                                Periodicidade Visita: <select class="form-control" name="visit_time">
                                    <option value="Mensal">Mensal</option>
                                    <option value="Trimestral">Trimestral</option>
                                    <option value="Semestral">Semestral</option>
                                </select>
                            </div>
                            <div class="form-group">
                                Próxima Visita: <input class="form-control"  name="next_visit" type="datetime-local">
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
