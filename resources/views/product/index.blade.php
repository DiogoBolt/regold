@extends('layouts.app')

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
            <a href="/products/new" align="right" class="btn btn-default">Novo Produto</a>
            <br/>

            @foreach($products as $product)
                <div class="gallery_product col-lg-4 col-md-4 col-sm-4 col-xs-6 filter sprinkle">
                    <div align="center"><b>{{$product->name}}</b></div>
                    <a href="/products/{{$product->id}}"><img src="/uploads/products/{{$product->file}}" class="img-responsive" style="width:365px;height:365px;"></a>
                    <div align="center" style="color:green">Escalão 1 : <b>{{$product->price1}}€</b></div>
                    <div align="center" style="color:green">Escalão 2 : <b>{{$product->price2}}€</b></div>
                    <div align="center" style="color:green">Escalão 3 : <b>{{$product->price3}}€</b></div>
                    <div align="center">{{$product->details}}</div>
                </div>

                @endforeach

        </div>
    </div>





@endsection

<script>

</script>