@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/documents/personalizeSection.css') }}" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="{{ mix('css/app.css') }}">
@endsection

@section('content')
<div class="container-bar">
        <p class="container-bar_txt">Personalizar Secções </p>
        <div class="container-bar_img">
            <img src="/img/haccp_icon.png"></a>
        </div>
    </div>

    <!--
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item" aria-current="page">Home</li>
                <li class="breadcrumb-item " aria-current="page">Documentos </li>
                <li class="breadcrumb-item active" aria-current="page">Documento</li>
            </ol>
        </nav>

        {{-- Go Back Button --}}
        <a class="back-btn" href="/frontoffice/documents/">
            <span class="back-btn__front"><strong>Voltar</strong></span>
            <span class="back-btn__back"><strong>Documentos </strong></span>
        </a>
     -->
     <div class="divSection">
        <ul class="ks-cboxtags">
            <li><input type="checkbox" id="checkboxOne" value="Rainbow Dash"><label for="checkboxOne">Rainbow Dash</label></li>
            <li><input type="checkbox" id="checkboxTwo" value="Cotton Candy" checked><label for="checkboxTwo">Cotton Candy</label></li>
            <li><input type="checkbox" id="checkboxThree" value="Rarity" checked><label for="checkboxThree">Rarity</label></li>
            <li><input type="checkbox" id="checkboxFour" value="Moondancer"><label for="checkboxFour">Moondancer</label></li>
            <li><input type="checkbox" id="checkboxFive" value="Surprise"><label for="checkboxFive">Surprise</label></li>
            <li><input type="checkbox" id="checkboxSix" value="Twilight Sparkle" checked><label for="checkboxSix">TwilightSparkle</label></li>
            <li><input type="checkbox" id="checkboxSeven" value="Fluttershy"><label for="checkboxSeven">Fluttershy</label></li>
            <li><input type="checkbox" id="checkboxEight" value="Derpy Hooves"><label for="checkboxEight">Derpy Hooves</label></li>
            <li><input type="checkbox" id="checkboxNine" value="Princess Celestia"><label for="checkboxNine">Princess
                            Celestia</label></li>
            <li><input type="checkbox" id="checkboxTen" value="Gusty"><label for="checkboxTen">Gusty</label></li>
            <li class="ks-selected"><input type="checkbox" id="checkboxEleven" value="Discord"><label for="checkboxEleven">Discord</label></li>
            <li><input type="checkbox" id="checkboxTwelve" value="Clover"><label for="checkboxTwelve">Clover</label></li>
            <li><input type="checkbox" id="checkboxThirteen" value="Baby Moondancer"><label for="checkboxThirteen">Baby
                            Moondancer</label></li>
            <li><input type="checkbox" id="checkboxFourteen" value="Medley"><label for="checkboxFourteen">Medley</label></li>
            <li><input type="checkbox" id="checkboxFifteen" value="Firefly"><label for="checkboxFifteen">Firefly</label></li>
        </ul>
    </div>
    
@endsection
    