<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @if(env('APP_ENV') == "local")
        <!-- Global site tag (gtag.js) - Google Analytics -->
            <script async src="https://www.googletagmanager.com/gtag/js?id=UA-135411717-1"></script>
            <script>
                window.dataLayer = window.dataLayer || [];
                function gtag(){dataLayer.push(arguments);}
                gtag('js', new Date());

                gtag('config', 'UA-135411717-1');
            </script>
        @endif

        <title>@yield('pageTitle')</title>
        <link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700" rel="stylesheet">
        <link href="{{ asset('assets/font/css/font-awesome.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/style.css?ver=1.0.0') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/responsive.css?ver=1.0.0') }}" rel="stylesheet" type="text/css">
        <link rel="icon" href="{{ asset('assets/images/mini.png') }}">

        {{--<link href="{{ asset('assets/css/JiSlider.css') }}" rel="stylesheet" type="text/css">--}}
        {{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>--}}
        {{--<script src="{{ asset('assets/js/Chart.bundle.js') }}"></script>--}}
        {{--<script src="{{ asset('assets/js/utils.js') }}"></script>--}}
        <script src="{{ asset('assets/js/jquery.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.js') }}"></script>
        <script src="{{ asset('assets/js/mobile-detect.min.js') }}"></script>

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <script type="text/javascript">
            var Base_Url = "<?php echo URL::to('/'); ?>";
        </script>
        <script>
            $(document).ready(function(){
                $("#click").click(function(){
                    $(".nav").slideToggle();
                });
            });
        </script>
        <script>
        $(document).ready(function(){
            $(".login_p").click(function(){
                $(".login_page").addClass("intro");
            });

            $("#close_lo").click(function(){
                $(".login_page").removeClass("intro");
            });
        });
        </script>
        <script>
            (function(h,o,t,j,a,r){
                h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
                h._hjSettings={hjid:1139319,hjsv:6};
                a=o.getElementsByTagName('head')[0];
                r=o.createElement('script');r.async=1;
                r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
                a.appendChild(r);
            })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
        </script>
        <script type="text/javascript">
            // This function creates a new anchor element and uses location
            // properties (inherent) to get the desired URL data. Some String
            // operations are used (to normalize results across browsers).


            // $(document).ready(function () {
            //     var page = window.location.pathname;
            //
            //     if(page !== '/login' && page !== 'register'){
            //         //Disable cut copy paste
            //         $('body').bind('cut copy paste', function (e) {
            //             e.preventDefault();
            //         });
            //
            //         //Disable mouse right click
            //         $("body").on("contextmenu",function(e){
            //             return false;
            //         });
            //     }
            // });
        </script>

        @yield('head')
    </head>
    {{--<style>--}}
    {{--#JiSlider {--}}
    {{--width: 100%;--}}
    {{--height: 731px;--}}
    {{--}--}}
    {{--</style>--}}

    <body>
        <div class="main_wrap">
            <div class="login_page">
                <div class="ovel_about">
                    <div class="full_loginpag">
                        <span id="close_lo"><i class="fa fa-window-close" aria-hidden="true"></i></span>
                        <form action="myaccount.html">
                            <div class="dev_row">
                                <label>Username or Email Address</label>
                                <input type="text" name="" value="">
                            </div>
                            <div class="dev_row">
                                <label>Password</label>
                                <input type="text" name="" value="">
                            </div>
                            <div class="dev_row"><input type="checkbox" name="" value=""><p>Remember me</p></div>
                            <div class="dev_row"><input type="submit" name="" value="log in"><a href="#">Sign in</a></div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- header-part-start-->
            <div class="header">
                <div class="container">
                    <div class="head wp100">
                        <div class="logo"> <a href="{{ route('public.home') }}"><img src="{{ asset('assets/images/logo.png') }}" alt=""/></a> </div>
                       <span id="click"><i class="fa fa-bars" aria-hidden="true"></i></span>
                       <div class="nav">
                            <ul>
                                <li>
                                    <a href="{{ route('public.home') }}">Home</a>
                                </li>
                                @if(!Auth::check())
                                    <li class="">
                                        <a href="{{ route('public.aboutus') }}">About us</a>
                                    </li>
                                    <li class="">
                                        <a href="{{ route('public.contact-us') }}">contact us</a>
                                    </li>
                                    <li class="">
                                        <a href="{{ route('public.blogs') }}">BOLGS</a>
                                    </li>
                                    <li>
                                        <a href="" data-toggle="modal" data-target="#signModal">Register</a>
                                    </li>
                                    <li>
                                        <a href="" data-toggle="modal" data-target="#logModal">Login</a>
                                    </li>
                                @else
                                    @if(Auth::user()->subscription)
                                        <li>
                                            <a href="{{ Auth::user()->homeUrl() }}">My Profile</a>
                                        </li>
                                    @endif
                                    @if( Auth::user()->hasRole('user') )
                                        <li>
                                            <a href="{{ route('activated.protected') }}">Dashboard</a>
                                        </li>
                                    @endif
                                    @if( Auth::user()->hasRole('administrator') )
                                        <li>
                                            <a href="{{ route('admin.members') }}">Members List</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.add-test') }}">Add Test</a>
                                        </li>
                                    @endif
                                    @if(!Auth::user()->subscription)
                                        <li>
                                            <a href="{{ route('public.payment') }}">Payments</a>
                                        </li>
                                    @endif
                                    <li>
                                        <a href="{{ url('logout') }}">Logout</a>
                                        <!-- login_p -->
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content">
                @yield('content')
            </div>

            <div class="footer">
                <div class="foot-nav">
                    <ul>
                        <li class="active"><a href="{{ route('public.home') }}">Home</a></li>
                        {{--<li class=""><a href="{{ route('public.aboutus') }}">About us</a></li>--}}
                        <li class=""><a href="{{ route('public.terms-use') }}">Terms of Use</a></li>
                        <li class=""><a href="{{ route('public.contact-us') }}">Contact Us</a></li>
                        <li class=""><a href="{{ route('public.cookies-policy') }}">Cookies Policy</a></li>
                    </ul>

                    <div class="social">
                        <a href="https://www.facebook.com/BloodCadet" class="social-facebook" target="_blank"><i class="fa fa-facebook fa-fw"></i></a>
                        <a href="https://twitter.com/blood_academy" class="social-twitter" target="_blank"><i class="fa fa-twitter fa-fw"></i></a>
                        <a href="https://www.instagram.com/blood_academy" class="social-instagram" target="_blank"><i class="fa fa-instagram fa-fw"></i></a>
                    </div>
                </div>
                <div class="copyright center_dev">
                    <p>© 2019 Blood Academy. All rights reserved </p>
                </div>
            </div>

            <div id="logModal" class="modal fade" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <div class="top">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        {{--<img src="{{ asset('assets/images/logo.png') }}">--}}
                        <span class="registerModalText">Log In</span>
                    </div>

                    {{--<p class="title">Log In</p>--}}

                    {!! Form::open(['url' => url('login'), 'class' => 'form-signin', 'data-parsley-validate']) !!}

                    @include('includes.status')

                    <label for="inputUsername" class="sr-only">Username</label>

                    {!! Form::text('username', null, [
                        'class' => 'form-control',
                        'placeholder' => 'Username',
                        'required',
                        'id' => 'inputUsername',
                        'data-parsley-required-message' => 'Username is required',
                        'data-parsley-trigger' => 'change focusout',
                        'data-parsley-minlength' => '2',
                        'data-parsley-maxlength' => '32'
                    ]) !!}

                    <label for="Password" class="sr-only">Password</label>

                    {!! Form::password('password', [
                        'class' => 'form-control',
                        'placeholder' => 'Password',
                        'required',
                        'id' => 'Password',
                        'data-parsley-required-message' => 'Password is required',
                        'data-parsley-trigger' => 'change focusout',
                        'data-parsley-minlength' => '6',
                        'data-parsley-maxlength' => '20'

                    ]) !!}

                    <span class="forgot-question">
                        <a href="{{ url('password/reset') }}"> Forgot password </a>
                        <a href="{{ route('public.getusername') }}"> Forgot Username </a>
                    </span>

                    <button class="btn btn-lg btn-primary register-btn" type="submit">Sign in <i class="fa fa-angle-double-right"></i></button>
                    <fieldset class="form-group">
                        {!! Form::checkbox('remember', 1, null, ['id' => 'remember-me']) !!}
                        <label for="remember-me" class="remember-label"> Remember me </label>
                    </fieldset>

                    {!! Form::close() !!}
                </div>
            </div>

            <div id="signModal" class="modal fade" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <div class="top">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        {{--<img src="{{ asset('assets/images/logo.png') }}">--}}
                        <span class="registerModalText">Register</span>
                    </div>

                    {{--<p class="title">Register</p>--}}
                    <form action="{{url('register')}}" class="require-validation" id="sign-form" method="post">

                        {{ csrf_field() }}

                        @include('includes.errors')

                        <div class="row">
                            <div class="col-md-6">
                                {!! Form::text('first_name', null, [
                                    'class' => 'form-control',
                                    'placeholder' => 'First Name',
                                    'required',
                                    'data-parsley-required-message' => 'First name is required',
                                    'data-parsley-trigger' => 'change focusout'
                                    ])
                                !!}
                            </div>
                            <div class="col-md-6">
                                {!! Form::text('last_name', null, [
                                    'class' => 'form-control',
                                    'placeholder' => 'Last Name',
                                    'required',
                                    'data-parsley-required-message' => 'Last name is required',
                                    'data-parsley-trigger' => 'change focusout'
                                    ])
                                !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                {!! Form::text('city', null, [
                                    'class' => 'form-control',
                                    'placeholder' => 'City',
                                    'data-parsley-required-message' => 'City is required',
                                    'data-parsley-trigger' => 'change focusout'
                                    ])
                                !!}
                            </div>
                            <div class="col-md-6">
                                {!! Form::text('country_residence', null, [
                                    'class' => 'form-control',
                                    'placeholder' => 'Country',
                                    'data-parsley-required-message' => 'Country is required',
                                    'data-parsley-trigger' => 'change focusout'
                                    ])
                                !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                {!! Form::email('email', null, [
                                    'class' => 'form-control',
                                    'placeholder' => 'Email address',
                                    'required',
                                    'data-parsley-required-message' => 'Email address is required',
                                    'data-parsley-trigger' => 'change focusout',
                                    'data-parsley-type' => 'email'
                                    ])
                                !!}
                            </div>
                            <div class="col-md-6">
                                {!! Form::password('password', [
                                    'class' => 'form-control',
                                    'placeholder' => 'Password',
                                    'required',
                                    'id' => 'inputPassword',
                                    'data-parsley-required-message' => 'Password is required',
                                    'data-parsley-trigger' => 'change focusout',
                                    'data-parsley-minlength' => '6',
                                    'data-parsley-maxlength' => '20'
                                    ])
                                !!}

                                {!! Form::password('password_confirmation', [
                                    'class' => 'form-control',
                                    'placeholder' => 'Confirm Password',
                                    'required',
                                    'id' => 'confirmPassword',
                                    'data-parsley-required-message' => 'Password confirmation is required',
                                    'data-parsley-trigger' => 'change focusout',
                                    'data-parsley-equalto' => '#inputPassword',
                                    'data-parsley-equalto-message'  => 'Not same as Password',
                                ]) !!}

                                {!! Form::checkbox('agree', 1, null, [
                                    'class' => 'form-control',
                                    'required',
                                    'id' => 'inputAgree',
                                    'data-parsley-required-message' => 'Please accept terms of use.',
                                    'data-parsley-trigger' => 'change focusout',
                                ]) !!}

                                <label class="term-check" for="inputAgree"> I agree to terms of use</label>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 50px;">
                            <div class="col-md-6">
                                <div class="g-recaptcha" data-sitekey="{{ env('RE_CAP_SITE') }}"></div>
                            </div>
                            <div class="col-md-6 text-center">
                                <button class="btn btn-lg btn-primary register-btn" type="submit">Sign Up <i class="fa fa-angle-double-right"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div id="termsModal" class="modal fade" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <div class="top">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        {{--<img src="{{ asset('assets/images/logo.png') }}">--}}
                        <span class="registerModalText">Terms of Use</span>
                    </div>
                    <div class="terms-content">
                        <h4>Terms of Use</h4>
                        <p>By accessing www.blood-academy.com (hereinafter the &lsquo;Site), submitting registration
                            information and subscribing, you agree to have read, understood and be bound by the Terms of
                            Use as stated below. We advise you to read these Terms of Use carefully. These Terms of Use
                            may be subject to change at any time, without notice. It is the responsibility of you
                            (hereinafter the &lsquo;user&rsquo;) to regularly check the Site and review these Terms of
                            Use for any changes. This version of the Terms of Use is effective as from 1<sup>st</sup>
                            July 2018.</p>
                        <h4>Disclaimer</h4>
                        <p>The content found on the Site is intended solely for educational purposes to support, not
                            replace, your own knowledge, experience and judgement. It is not intended and should not be
                            relied upon to recommend or promote a specific method, diagnosis or treatment by healthcare
                            practitioners and scientists for any patient. We cannot guarantee the accuracy or
                            completeness of the Site&rsquo;s content and assume no legal liability for the same. We will
                            however endeavour to regularly update the Site and correct or remove inaccurate content.</p>
                        <h4>Ownership and licenses</h4>
                        <p>The Site&rsquo;s content is original and has been prepared by haematologists who have passed
                            the FRCPath (haematology) examination. The Site has no direct link with the Royal of College
                            of Pathologists and the Site authors have no direct knowledge of the content of past,
                            current or future FRCPath examinations. The content, design, databases and images on this
                            Site are protected by UK and other international intellectual property laws and are owned by
                            the Site owners. No part of the Site can be reproduced, stored, or be used to produce
                            derivative work without prior written consent from the Site authors. The Site is only
                            permitted for private use and cannot be broadcasted or displayed publicly. Where these terms
                            have been breached, your right to access the Site will cease immediately and you will return
                            and/or destroy any copies of the materials you have made in breach.</p>
                        <h4>Access to www.blood-academy.com</h4>
                        <p>The Site will aim to provide access on an uninterrupted basis. We cannot guarantee that
                            access will not be restricted at times to allow for maintenance, repair or the introduction
                            of new services. Where this occurs, all efforts will be made to limit the disruption caused.
                            Subscription is provided on a unique and individual basis and is not transferable to others.
                            You will not attempt to use other user&rsquo;s account, or divulge your username or password
                            to others on or off the Site. The Site has not been optimised for use via mobile devices and
                            users wishing to do so should be aware that they may not experience the full functionality
                            of the Site.</p>
                        <h4>Privacy</h4>
                        <p>All content is fully anonymised and untraceable back to the source. Patient details have been
                            altered to ensure full anonymity without compromising the educational value of the Site&rsquo;s
                            content. The basis of this Site is in full compliance with the General Medical Council&rsquo;s
                            advice (<em>&lsquo;</em><em>Making and using visual and audio recordings of
                                patients&rsquo;</em>, paragraphs 10-12, <a
                                    href="http://www.gmc-uk.org/guidance/ethical_guidance/7818.asp" target="_blank"
                                    rel="noopener">link</a>).</p>
                        <h4>Pricing</h4>
                        <p>The price for subscription to the Site and its services will be clearly provided on the Site.
                            All prices are in pound sterling. Where purchases are made from outside the UK, the exchange
                            rate will be calculated by your bank. Payments are handled by a secure and PCI-compliant
                            third party payment processor, Stripe, and hence we never obtain and retain any bank card
                            details. Although this arrangement is extremely secure, we take no liability for losses
                            caused by unauthorised access to the information provided by you.</p>
                        <h4>Cancellation</h4>
                        <p>After purchasing a subscription to the Site, cancellation leading to a refund of the
                            subscription fee will be at the discretion of the Site owners.</p>
                        <h4>Data collection</h4>
                        <p>The information you provide about yourself will be held on a secure database and provides
                            essential information to guide the development of the Site. We do not pass your information
                            to third parties. You are however required only to provide an email address and compose a
                            password for the Site to gain access. Where you have provided additional information on
                            registration about yourself and wish to retract this information from our database, you are
                            required to email the Site owners (<a href="mailto:admin@blood-academy.com">admin@blood-academy.com</a>)
                            who will comply with your request.</p>
                        <h4>Links to third parties</h4>
                        <p>The Site contains links to third party websites and references to published journals and
                            textbooks. This does not reflect endorsement or approval by the third party or content. We
                            take no responsibility for any content found on any Site or published work other than this
                            Site.</p>
                    </div>
                </div>
            </div>


        </div>

        <script src="{{ asset('assets/js/ie10-viewport-bug-workaround.js') }}"></script>
        {{--<script src="{{ asset('assets/js/JiSlider.js') }}"></script>--}}
        <script src="{{ asset('assets/js/script.js??ver=1.0.0') }}"></script>

        <script>
            // $(window).load(function () {
            //     $('#JiSlider').JiSlider({color: '#fff', start: 2, reverse: true}).addClass('ff')
            // })
            $(document).ready(function() {

                var password = document.getElementById("inputPassword")
                    , confirm_password = document.getElementById("confirmPassword");

                function validatePassword(){
                    if(password.value != confirm_password.value) {
                        confirm_password.setCustomValidity("Passwords Don't Match");
                    } else {
                        confirm_password.setCustomValidity('');
                    }
                }

                password.onchange = validatePassword;
                confirm_password.onkeyup = validatePassword;


                $(document).on('click', '.close', function(event) {
                    event.preventDefault();
                    $(".alert.in, .alert-success").remove()
                });

                $("#inputAgree").on('click', function(event) {
                    url = "{{route('public.terms-use')}}";
                    var md = new MobileDetect(window.navigator.userAgent);
                    if (md.tablet() || md.mobile()){
                        $('#termsModal').modal('show');
                    } else {
                        var win = window.open(url, '_blank');
                    }

                });

                $(".edit-sub").on('click', function(event) {
                    event.preventDefault();
                    $("#myModal").modal()
                    $("#user_id").val( $(this).attr('data-id') );
                    $("#user_date").val( $(this).attr('data-date') );
                });
                var max_fields      = 10;
                var wrapper         = $(".input_fields_wrap");
                var add_button      = $(".add_field_button");
                var x = 1;
                $(add_button).click(function(e) {
                    e.preventDefault();
                    if(x < max_fields) {
                        x++;
                        $(wrapper).append('<div class="row"><div class="col-md-8"><input type="text" class="form-control" name="multiple_opts['+x+'][option]"/></div><div class="col-md-4"><input type="checkbox" name="multiple_opts['+x+'][answer]"><a href="#" class="remove_field btn btn-primary">Remove</a></div></div>');
                    }
                });

                $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
                    e.preventDefault(); $(this).parent('div').remove(); x--;
                });

                $(".alert-success").fadeTo(2000, 500).slideUp(500, function(){
                    $(".alert-success").slideUp(500);
                });

                $(".danger").fadeTo(2000, 500).slideUp(500, function(){
                    $(".danger").slideUp(500);
                });

                $('form.require-validation').bind('submit', function(e) {
                    var $form = $(e.target).closest('form'),
                        inputSelector = ['input[type=email]', 'input[type=password]', 'input[type=text]', 'input[type=file]', 'textarea'].join(', '),
                        $inputs = $form.find('.required').find(inputSelector),
                        $errorMessage = $form.find('div.error'),
                        valid = true;

                    $errorMessage.addClass('hide');
                    $('.has-error').removeClass('has-error');
                    $inputs.each(function(i, el) {
                        var $input = $(el);
                        if ($input.val() === '') {
                            $input.parent().addClass('has-error');
                            $errorMessage.removeClass('hide');
                            e.preventDefault(); // cancel on first error
                        }
                    });
                });
            });

            window.ParsleyConfig = {
                errorsWrapper: '<div></div>',
                errorTemplate: '<span class="error-text"></span>',
                classHandler: function (el) {
                    return el.$element.closest('input');
                },
                successClass: 'valid',
                errorClass: 'invalid'
            };

        </script>

        {!! HTML::script('/assets/plugins/parsley.min.js') !!}
        <script src='https://www.google.com/recaptcha/api.js'></script>

        @yield('footer')
    </body>
</html>
