@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Voltas</div>

                <div class="panel-body">

                    <table class="table table-bordered">
                        <tr>
                            <th>Nome</th>
                            <th>Periodicidade Visita</th>
                            <th>Proxima Visita</th>
                            <th>Processar Volta</th>
                        </tr>
                        @foreach($groups as $group)
                            <tr>
                                <td><a href="/groups/{{$group->id}}">{{$group->name}}</a></td>
                                <td>{{$group->visit_time}}</td>
                                <td>{{$group->next_visit}}</td>
                                <td><button class="btn btn-primary" id="process" onclick="process({{$group->id}})">Processar</button></td>

                            </tr>

                        @endforeach

                    </table>

                    <a href="/groups/new" class="btn btn-success">Nova Volta</a>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
<script>
    function process(id) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: '{{url('/groups/processgroup')}}'+'/'+id
        }).done(window.location.reload());
    }
</script>