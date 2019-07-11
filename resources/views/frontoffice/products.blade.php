@extends('layouts.frontoffice')

<style>

    .gallery-title
    {
        font-size: 36px;
        color: #42B32F;
        text-align: center;
        font-weight: 500;
        margin-bottom: 70px;
    }
    .gallery-title:after {
        content: "";
        position: absolute;
        width: 7.5%;
        left: 46.5%;
        height: 45px;
        border-bottom: 1px solid #5e5e5e;
    }

    .btn-default:active .filter-button:active
    {
        background-color: #42B32F;
        color: white;
    }

    .gallery_product
    {
        margin-bottom: 30px;
    }

</style>

@section('content')


    <div class="container">
        <div class="row">
            <div class="gallery col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h1 class="gallery-title">Produtos</h1>
            </div>
            <br/>


            @foreach($products as $product)
                <div class="gallery_product col-lg-2 col-md-2 col-sm-6 col-xs-6 filter sprinkle">
                    <div align="center"><b>{{$product->name}}</b></div>
                    <div align="center" style="height:10%">{{$product->category}}</div>
                    <a href="/frontoffice/products/{{$product->id}}"><img src="/uploads/products/{{$product->file}}" class="img-responsive" style="width:150px;height:150px;" align="center"></a>
                    <div align="center" style="color:green;margin-top:5px">Escalão 1 : <b>{{$product->price1}}€</b></div>
                    <div align="center" style="color:green">Escalão 2 : ({{$product->amount2}}) <b>{{$product->price2}}€</b></div>
                    <div align="center" style="color:green">Escalão 3 : ({{$product->amount3}}) <b>{{$product->price3}}€</b></div>
                    <div align="center" style="height:10%">{{$product->details}}</div>
                    <div align="center">
                    <form action="/frontoffice/products/addcart/"  method="get">
                    {{ csrf_field() }}
                        <input value="{{$product->id}}" name="id" style="display:none">
                        <select class="form-control" name="amount" style="float:left;width:35%">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                            <option value="16">16</option>
                            <option value="17">17</option>
                            <option value="18">18</option>
                            <option value="19">19</option>
                            <option value="20">20</option>
                        </select>
                        <button class="btn btn-success" style="float:right;width:65%">Encomendar</button>
                    </form>
                    </div>
                </div>

                @endforeach

        </div>
    </div>





@endsection

<script>

</script>