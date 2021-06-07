<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>Dashboard Login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--===============================================================================================-->
        <link rel="icon" type="image/png" href="{{ asset('images/icons/login-favicon.ico') }}"/>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"/>
        <!--===============================================================================================-->
        <link rel="stylesheet" href="{{ asset('dashboard-assets/css/dashboard-login.css') }}">
        <!--===============================================================================================-->
    </head>
    <body>
        <div class="container-login100" style="background-image: url('{{ asset('dashboard-assets/images/login-bg.jpg') }}');">

            <div class="wrap-login100 p-l-55 p-r-55 p-t-80 p-b-30">

                <form method="post" action="<?php route('login.submit') ?>" class="login100-form validate-form" autocomplete="off">
                    <span class="login100-form-title p-b-37">
                        DASHBOARD LOGIN
                    </span>

                    @csrf()

                    @if (!empty($errors->all()))
                        <div class="txt2-error p-b-10 text-center"><span>{{ $errors->first() }}</span></div>
                    @endif
                    <div class="wrap-input100 m-b-20">
                        <input required min="3" max="100" class="input100" type="text" value="{{ old('email', 'admin') }}" name="username" placeholder="username">
                    </div>

                    <div class="wrap-input100 m-b-25" >
                        <input required min="3" max="100" class="input100" type="password" name="password" value="password" placeholder="password">
                    </div>

                    <div class="wrap-input100 validate-input m-b-25 m-l-8 rem" data-validate = "Enter password">
                        <input type="checkbox" name="rememberme" id="rem"/><label for="rem" class="m-l-5 txt2">remember me</label>
                    </div>

                    <div class="container-login100-form-btn">
                        <button type="submit" class="login100-form-btn">
                            Login
                        </button>
                    </div>
                </form>

            </div>

        </div>
    </body>
</html>
