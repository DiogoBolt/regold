@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/documents/type.css') }}" rel="stylesheet">
@endsection

@section('content')
    <form action="/frontoffice/saveOilRecords" method="POST">
        <div class="container">
            <div class="container-docs">
                <div>
                    <h4 style="text-align:left ; color:#9ac266"> REGISTOS DE MUDANÇA DE ÓLEO</h4>
                    <label style="text-align:center" for ="report_date">DATA</label>
                    <input type="date" id="report_date"  name="report_date">
                </div>
                <div>
                    <h2 style="text-align:center" >ASPETO</h2>
                    <input type="button" class="btn btn-oilRecord" name="oil_aspect" onclick="jQuery(this).toggleClass('active')" value="1">
                    <input type="button" class="btn btn-oilRecord2" name="oil_aspect" onclick="jQuery(this).toggleClass('active')" value="2">
                    <input type="button" class="btn btn-oilRecord3" name="oil_aspect" onclick="jQuery(this).toggleClass('active')" value="3">
                    <input type="button" class="btn btn-oilRecord4" name="oil_aspect" onclick="jQuery(this).toggleClass('active')" value="4">
                    <input type="button" class="btn btn-oilRecord5" name="oil_aspect" onclick="jQuery(this).toggleClass('active')" value="5">
                </div>
            </div>
        </div>
        <div>
            <button class="btn btn-add" >Validar</button>
        </div>
    </form>


   {{-- <script type="text/javascript">
    function reply_click($clicked_id)
    {
       var x= document.getElementById($clicked_id);
       x.style.borderColor="red";
    }
</script>--}}

@endsection