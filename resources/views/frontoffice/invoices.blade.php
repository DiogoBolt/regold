@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/invoices/invoices.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-bar">
        <p class="container-bar_txt">facturas</p>
        <div class="container-bar_img">
            <img src="/img/invoice.png"></a>
        </div>
    </div>

    {{-- Go Back Button --}}
    <a class="back-btn" href="/home">
        <span class="back-btn__front"><strong>Voltar</strong></span>
        <span class="back-btn__back"><strong>Home</strong></span>
    </a>

    <div class="container invoices-container">
       
       <select id="invoice-select">
           <option value="" selected disabled>Escolha tipo de Factura</option>
           <option value="0">Facturas liquidadas</option>
           <option value="1">Facturas por liquidar</option>
       </select>

       <div id="invoices">
            <div id="paid">

                @if ( count($paidInvoices) > 0)
                    @foreach ($paidInvoices as $invoice)
                        <div></div>
                    @endforeach                  
                @else
                    <h4>Não possui nenhuma factura liquidada de momento.</h4>
                @endif

            </div>      
            <div id="unpaid">
                <h3>Total : {{ $totalUnpaidAmount ?: 'Sem montante em dívida' }}</h3>

                @if (count($unpaidInvoices['receipts']) > 0)
                    @foreach ($unpaidInvoices as $invoice)
                        <div></div>
                    @endforeach                  
                @else
                    <h4>Não possui nenhuma factura para liquidar de momento.</h4>
                @endif
            </div>
       </div>


    </div>

@endsection

<script>
    
    document.addEventListener("DOMContentLoaded", function() {
        const invoiceSelect = document.getElementById('invoice-select');
        const paidDiv = document.getElementById('paid'); 
        const unpaidDiv = document.getElementById('unpaid');

        invoiceSelect.addEventListener('change', function (evt) {
            let selected = evt.target.value;

            if ( selected == 0 ) { /* Facturas Liquidadas */
                unpaidDiv.style.display = 'none';
                paidDiv.style.display = 'block';
            } else if ( selected == 1 ) { /* Facturas por Liquidar */
                unpaidDiv.style.display = 'block';
                paidDiv.style.display = 'none';
            };

        });

    });

</script>