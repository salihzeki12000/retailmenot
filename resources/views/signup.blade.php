@extends('base')

@section('static')
    <link rel="stylesheet" type="text/css" href="https://www.retailmenot.com/www/gui/build/webpack/design-standards/signup-e6921fb268e16ecaa4ccb4786609803f.css">
    <script defer="" type="text/javascript" src="https://www.retailmenot.com/www/gui/build/webpack/design-standards/signup-e335b2a7fb7abf5a64db.js"></script>
@endsection

@section('main')

    <main role="main" id="site-main" class="js-site-main">
        <div class="container js-page-container ">
            <div class="form form--centered form--constrained form-quicksignup">
                <div class="field-container">
                    <header>
                        <h2 class="h2 hide-modal">Log In or Sign Up For RetailMeNot</h2>
                        <h2 class="h5 show-modal">Log In or Sign Up For RetailMeNot</h2></header>
                    <section class="section-padding js-login-ui js-tabs">
                        <div class="tabs-header">
                            <ul>
                                <li class="js-tabs-header-item tabs-header-item active" data-tab-id="signUp"><a class="js-tabs-header-item-link" href="#">Sign Up</a></li>
                            </ul>
                        </div>
                        <div class="tabs-content">

                            <div id="signUp" class="tabs-content-item js-tabs-content-item active">
                                <!--<p>
                                    <button class="button-facebook js-fb-signup-button"><span class="icon-facebook-wrapper"><svg class="icon icon-facebook"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-facebook"></use></svg></span>Sign up with Facebook</button>
                                </p> -->
                                <p>Already registered? <a href="{{ url('login') }}" >Login</a></p>
                                <form class="js-auth-form" method="post" action="{{ url('register') }}" data-auth-action="signup" novalidate="">
                                    {{ csrf_field() }}

                                    <fieldset class="login-signup-form-fields">
                                        <!--[if lte IE 9]><label for="email">Email</label><![endif]-->
                                        <div class="field-container grid-unit">
                                            <input class="submit-required blur signup-email" type="email" value="{{ old('email') }}" placeholder="Email" name="email">
                                        </div>

                                        @if ($errors->has('email'))
                                            <div class="input-error password-msg">{{ $errors->first('email') }}</div>
                                            @endif
                                        <!--[if lte IE 9]><label for="password">Password</label><![endif]-->
                                            <div class="field-container grid-unit">
                                                <input class="required blur signup-password" type="password" placeholder="Password" name="password">
                                            </div>

                                            @if ($errors->has('password'))
                                                <div class="input-error password-msg">{{ $errors->first('password') }}</div>
                                                @endif



                                        <!--[if lte IE 9]><label for="password_confirmation">Confirm Password</label><![endif]-->
                                                <div class="field-container grid-unit">
                                                    <input class="required blur signup-password-confirm" type="password" placeholder="Confirm Password" name="password_confirmation">
                                                </div>

                                                @if ($errors->has('password_confirmation'))
                                                    <div class="input-error password-msg">{{ $errors->first('password_confirmation') }}</div>
                                            @endif

                                            <!-- <label>
                                            <input type="checkbox" name="favoriteStoresEmailAlerts" checked="checked">Send me emails about the best deals on RetailMeNot</label>
                                        <input name="source" type="hidden" value="us-rmn-desktop"> -->
                                    </fieldset>
                                    <br>
                                    <p>
                                        <button type="submit" class="button-primary">Sign Up</button>
                                    </p>


                                    <!-- <p>By joining, I agree to RetailMeNot’s <a href="/static/privacy/" target="_blank">Privacy Policy</a> and <a href="/static/terms/" target="_blank">Terms of&nbsp;Use</a>.</p>
                                    -->
                                </form>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </main>

@endsection