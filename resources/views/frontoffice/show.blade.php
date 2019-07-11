@extends('layouts.frontoffice')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{$client->name}} <div style="float:right"><a href="/frontoffice/client/edit/{{$client->id}}"><img src="/img/settings.png" style="margin-top:-7px;width:33px"></a></div></div>

                <div class="panel-body">

                    <div class="form-group" align="right">
                        <b> Proxima Visita:</b> {{$group->next_visit}}
                    </div>

                    <div class="col-sm-6">

                        <div class="form-group">
                            <b>Morada:</b>{{$client->address}}
                        </div>
                        <div class="form-group">
                            <b> Cidade:</b> {{$client->city}}
                        </div>
                        <div class="form-group">
                            <b> NIF:</b> {{$client->nif}}
                        </div>
                        <div class="form-group">
                            <b> Email Contacto:</b> {{$client->email}}
                        </div>
                        <div class="form-group">
                            <b>Actividade:</b> {{$client->activity}}
                        </div>
                        <div class="form-group">
                            <b> Telefone:</b> {{$client->telephone}}
                        </div>
                        <div class="form-group">
                            <b> Metodo Pagamento:</b> {{$client->payment_method}}
                        </div>
                        <div class="form-group">
                            <b> Email Faturação:</b> {{$client->receipt_email}}
                        </div>
                        <div class="form-group">
                            <b> NIB:</b> {{$client->nib}}
                        </div>



                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


@endsection
