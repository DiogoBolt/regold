@extends('layouts.frontoffice')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/login/login.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container login-container">

    <div class="col-md-8 col-md-offset-2">
        <div>
            <img src="{{ asset('img/navbar/RegolFoodLogin.png') }}" class="img-responsive logo" alt="logo"/>

            <div class="panel-body">
                <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        
                        <div class="col-md-6 input-group">
                                <span class="input-group-addon">
                                    <img src="{{ asset('img/logousuario.png') }}" width="20" height="20" alt="login logo"/>
                                </span>
                            <input id="email" type="email" class="form-control" 
                                name="email" value="{{ old('email') }}" 
                                placeholder="Nome"
                                required autofocus>
                        </div>
                        @if ($errors->has('email'))
                        <span class="help-block" style="text-align: center">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <div class="col-md-6 input-group">
                            <span class="input-group-addon">
                                <img src="{{ asset('img/Logopassword.png') }}" width="20" height="20" alt="login logo"/>
                            </span>
                            <input id="password" type="password" class="form-control" 
                                placeholder="**********"
                                name="password" required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 input-group">
                                <span class="input-group-btn"> 
                            <button type="submit" class="btn login-btn">
                                LOGIN
                            </button>
                                </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 input-group login-bottom">
                            <label class="login-checkbox"> Lembrar
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                <span class="checkmark"></span>
                            </label>

                            <a class="btn-link" href="{{ route('password.request') }}">
                                Recuperar palavra-passe?
                            </a>
                        </div>
                    </div>
                </form>

                <a href="{{asset('RegolfoodApp.apk')}}" class="download-link">
                    <span>DOWNLOAD </span><span> APP!</span><img src="{{ asset('img/android2.png') }}" width="30" height="30" alt="login logo"/>
                </a>
            </div>
        </div>
    </div>
</div>

@endsection


<script>
    let externalUserId = "your User ID fetched from backend server";

    OneSignal.push(function() {
        OneSignal.isPushNotificationsEnabled(function(isEnabled) {
            if (isEnabled)
            {
                console.log("Push notifications are enabled!");
                OneSignal.setExternalUserId(externalUserId);
            }
            else
            {
                console.log("Push notifications are not enabled yet.");
            }
        });
    });
</script>
