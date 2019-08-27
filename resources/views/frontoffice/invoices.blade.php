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

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">Home</li>
            <li class="breadcrumb-item active" aria-current="page">Facturas</li>
        </ol>
    </nav>

    {{-- Go Back Button --}}
    <a class="back-btn" href="/home">
        <span class="back-btn__front"><strong>Voltar</strong></span>
        <span class="back-btn__back"><strong>Home</strong></span>
    </a>

    <div class="container invoices-container">
       
       <select id="invoice-select">
           <option id="0" value="0">Facturas liquidadas</option>
           <option id="1" value="1" selected>Facturas por liquidar</option>
       </select>



       <div id="invoices">
           <h3>Conta Corrente : {{ $totalUnpaidAmount . ' €' ?: 'Sem montante em dívida' }}</h3>
            <div id="paid">

                @if ( count($paidInvoices) > 0)
                    @include('frontoffice.partials.invoices-partial', ['invoices' => $paidInvoices]) 
                @else
                    <h4>Não possui nenhuma factura liquidada de momento.</h4>
                @endif

            </div>      
            <div id="unpaid">


                @if (count($unpaidInvoices) > 0)
                    @include('frontoffice.partials.invoices-partial', ['invoices' => $unpaidInvoices])               
                @else
                    <h4>Não possui nenhuma factura para liquidar de momento.</h4>
                @endif
            </div>
       </div>


    </div>

@endsection

<script>


    function getCookie(name) {
        var value = "; " + document.cookie;
        var parts = value.split("; " + name + "=");
        if (parts.length == 2) return parts.pop().split(";").shift();
    }

    function updateSelect (paidDiv,unpaidDiv)
    {
        var id = getCookie("selected");
        if(id != null)
        {
            if(id == 0)
            {
                unpaidDiv.style.display = 'none';
                paidDiv.style.display = 'block';
            }else{
                unpaidDiv.style.display = 'block';
                paidDiv.style.display = 'none';
            }
            $('#'+id).prop('selected', true);
            $('#default').prop('selected', false);
        }

    }

    document.addEventListener("DOMContentLoaded", function() {
        const invoiceSelect = document.getElementById('invoice-select');
        const paidDiv = document.getElementById('paid'); 
        const unpaidDiv = document.getElementById('unpaid');
        updateSelect(paidDiv,unpaidDiv);

        invoiceSelect.addEventListener('change', function (evt) {
            let selected = evt.target.value;

            if ( selected === '0' ) { /* Facturas Liquidadas */
                document.cookie = "selected=0";
                unpaidDiv.style.display = 'none';
                paidDiv.style.display = 'block';
            } else if ( selected === '1' ) { /* Facturas por Liquidar */
                document.cookie = "selected=1";
                unpaidDiv.style.display = 'block';
                paidDiv.style.display = 'none';
            };

        });

    });

</script>