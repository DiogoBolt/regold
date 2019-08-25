<div class="panel">
    <div class="panel-body">

        <table class="table table-responsive">
            <tr>
                <th>Id</th>
                <th>Ficheiro</th>
                <th>Total</th>
            </tr>
            @foreach($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->external_id }}</td>
                    <td>
                        <a href="{{asset('uploads/'.Auth::user()->client_id.'/'. $invoice->file)}}"
                            class="file-link"><strong>Visualizar Factura</strong></a>
                    </td>
                    <td>{{ $invoice->total }} €</td>
                </tr>
            @endforeach
        </table>

        {{ $invoices->links() }}
    </div>
</div>