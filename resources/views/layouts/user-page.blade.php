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

            function gtag() {
                dataLayer.push(arguments);
            }

            gtag('js', new Date());

            gtag('config', 'UA-135411717-1');
        </script>
    @endif

    <title>@yield('pageTitle')</title>
    <link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700" rel="stylesheet">
    <link href="{{ asset('assets/font/css/font-awesome.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-notifications.min.css') }}">
    <link rel="icon" href="{{ asset('assets/images/mini.png') }}">
    {{--    <link href="{{ asset('assets/css/JiSlider.css') }}" rel="stylesheet" type="text/css">--}}


    {{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>--}}

    {{--<script src="{{ asset('assets/js/utils.js') }}"></script>--}}


    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('assets/js/jquery.js') }}"></script>
    <script src="{{ asset('assets/js/Chart.bundle.js') }}"></script>
    <script type="text/javascript">
        var Base_Url = "<?php echo URL::to('/'); ?>";
    </script>

    @yield('head')
</head>
<style>
    /*#JiSlider {*/
    /*width: 100%;*/
    /*height: 731px;*/
    /*}*/

    .active label {
        color: #fff
    }
</style>

<body>
<div class="user-panel">
    <div id="sideNav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <div class="logo">
            <a href="{{ route('public.home') }}"><img src="{{ asset('assets/images/logo.png') }}" alt=""/></a>
        </div>
        <ul id="menu">
            <li>
                <a href="{{ Auth::user()->homeUrl() }}">My Profile</a>
            </li>
            <li>
                <a href="{{ route('activated.protected') }}">Dashboard</a>
            </li>
            <li>
                <a href="{{ route('user.blogs') }}">Blogs</a>
            </li>
            <li class="dropdown-notifications">
                <a href="{{ route('user.replies', ['id' => Auth::user()->id]) }}" class="dropdown-toggle">Notification
                    <i data-count="0" class="glyphicon glyphicon-bell notification-icon"></i>
                </a>
            </li>
            <li>
                <a href="{{ url('logout') }}">Logout</a>
            </li>
        </ul>
        <div id="status"></div>
    </div>
    <div id="content">
        @yield('content')
    </div>

    <div class="footer">
        <div class="copyright center_dev">
            <p>© 2019 Blood Academy. All rights reserved </p>
        </div>
    </div>

    <div id="fbModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="top">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <p class="title">Feedback</p>
                <input id="questionId" type="hidden" value=""/>
                <input id="questionType" type="hidden" value=""/>
            </div>

            <p>Please tell us what do you think, any kind of feedback is highly appreciated.</p>

            <ul id="mytypes" class="options">
                <li value="idea" class="active"><i class="fa fa-lightbulb-o"></i>
                    <label for="commentType">&nbsp; Idea </label>
                    <input type="radio" name="commentType" value="idea" style="display: none">
                </li>
                <li value="question"><i class="fa fa-question-circle"></i>
                    <label for="commentType">&nbsp; Question </label>
                    <input type="radio" name="commentType" value="question" style="display: none">
                </li>
                <li value="problem"><i class="fa fa-exclamation-circle"></i>
                    <label for="commentType">&nbsp; Problem </label>
                    <input type="radio" name="commentType" value="problem" style="display: none">
                </li>
                <li value="praise"><i class="fa fa-heart"></i>
                    <label for="commentType">&nbsp; Praise </label>
                    <input type="radio" name="commentType" value="praise" style="display: none">
                </li>
            </ul>

            <textarea id="commentText" rows="6" placeholder="Your feedback" maxlength="250"></textarea>

            <button class="btn btn-sign" onclick="submitComment()">Submit feedback</button>
            {{--{!! Form::close() !!}--}}
        </div>
    </div>

    <div id="confirmation" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="top">
                <p class="title">Thank you for your feedback</p>
            </div>
        </div>
    </div>

    <div id="caseModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="instructions">
                <div class="top">
                    <img src="/assets/images/logo.png" alt="logo"/>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="content">
                    <h2>How does the interactive case work</h2>
                    <p>• A new case is published on the 1st and 15th of every month</p>
                    <p>• A short description of the case is given including the blood count</p>
                    <p>• You input answers for the three sections</p>
                    <p style="margin-left: 30px;"> 1. Key main features</p>
                    <p style="margin-left: 30px;"> 2. Suggestions for other investigations</p>
                    <p style="margin-left: 30px;"> 3. Differential diagnosis </p>
                    <br/>
                    <p>• Each case will close on the 8th and 23rd day of every month</p>
                    <p>• Your responses are compared with all responses provided in a compact report published on the
                        10th and 25th day of every month</p>
                    <p>• Your final report will be available in the ‘Interactive case’ menu which includes a short
                        commentary of the case</p>
                    <p>• The individualised report can be printed in pdf format and used as evidence for continuous
                        professional development</p>
                </div>
            </div>

            <div class="contact">
                <p>Interested in submitted case and get £50 in amazon vouchers, contact admin@blood-academy.com for
                    further information.</p>
            </div>
        </div>
    </div>

</div>


<!-- Bootstrap Core JavaScript -->
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.countryselector.js') }}"></script>
<script src="{{ asset('assets/js/jquery-te-1.4.0.min.js') }}"></script>
<script src="{{ asset('assets/js/script.js?ver=1.0.0') }}"></script>
{{--<script src="{{ asset('assets/js/tinymce/tinymce.min.js') }}"></script>--}}
<script>
    (function (h, o, t, j, a, r) {
        h.hj = h.hj || function () {
            (h.hj.q = h.hj.q || []).push(arguments)
        };
        h._hjSettings = {hjid: 1139319, hjsv: 6};
        a = o.getElementsByTagName('head')[0];
        r = o.createElement('script');
        r.async = 1;
        r.src = t + h._hjSettings.hjid + j + h._hjSettings.hjsv;
        a.appendChild(r);
    })(window, document, 'https://static.hotjar.com/c/hotjar-', '.js?sv=');
</script>
<script>
    function submitComment() {
        $('#fbModal').modal('hide');
        let commentType = $("li[class='active']").attr('value');
        console.log(commentType);
        $.post("/user/submitcomment",
            {
                cType: commentType,
                questionId: $('#questionId').val(),
                questionType: $('#questionType').val(),
                comment: $('#commentText').val().substr(0, 250),
                _token: '{{csrf_token()}}'
            },
            function (data, status) {
                $('#commentText').val('');
                $('#confirmation').modal('show');
            });

        setTimeout(function () {
            $('#confirmation').modal('hide');
        }, 1500);

    }

    $(document).ready(function () {
        const height = $('#column-left').height();
        $('.dashboard-content .page-content').css('min-height', height - 44);
    });

    $('#instruction, #fbModal').on('shown.bs.modal', function () {
        $("body.modal-open").removeAttr("style");
    });

    function openNav() {
        $('#sideNav').css({'left': 0});
    }

    /* Set the width of the side navigation to 0 */
    function closeNav() {
        $('#sideNav').css({'left': '-400px'});
    }

</script>
<!--begin::firebase script -->
<script src="https://www.gstatic.com/firebasejs/5.8.5/firebase.js"></script>
<script>
    // Initialize Firebase
    var config = {
        apiKey: "",
        authDomain: "",
        databaseURL: "",
        projectId: "",
        storageBucket: "",
        messagingSenderId: ""
    };
    firebase.initializeApp(config);

    show_number_notification("<?php echo(Auth::user()->id)?>");

    function show_number_notification(userid) {
        var notificationsWrapper = $('.dropdown-notifications');
        // notificationsWrapper.hide();
        var notificationsCountElem = notificationsWrapper.find('i[data-count]');

        var blog_comments = firebase.database().ref('users/' + userid + "/comments");
        blog_comments.on('value', function (snapshot) {
            var cnt = 0;
            snapshot.forEach(function (childSnapshot) {
                var comment = childSnapshot.val();
                if (comment.seen == "0") {
                    cnt++;
                }
            });
            notificationsCountElem.attr('data-count', cnt);
        })
        notificationsWrapper.show();
    }
</script>
</body>
</html>
