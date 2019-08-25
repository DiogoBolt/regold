<div class="panel">
    <div class="panel-body">

        <table class="table table-responsive">
            <tr>
                <th>Nome</th>
                <th>Ficheiro</th>
                <th>Total</th>
                <th>Total + IVA</th>
            </tr>
            @foreach($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->name }}</td>
                    <td>
                        <a href="{{asset('uploads/' . $invoice->file)}}" 
                            class="file-link"><strong>Visualizar Factura</strong></a>
                    </td>
                    <td>{{ $invoice->total }} €</td>
                    <td>{{ $invoice->totaliva }} €</td>
                </tr>
            @endforeach
        </table>

        {{ $invoices->links() }}
    </div>
</div>