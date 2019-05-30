<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('pageTitle')</title>
    <link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700" rel="stylesheet">
    <link href="{{ asset('assets/font/css/font-awesome.css') }}" rel="stylesheet" type="text/css">
    {{--<link href="{{ asset('assets/css/JiSlider.css') }}" rel="stylesheet" type="text/css">--}}
    <link href="{{ asset('assets/css/style.css?ver=1.0.0') }}" rel="stylesheet" type="text/css">

    <link rel="icon" href="{{ asset('assets/images/mini.png') }}">

    <script src="{{ asset('assets/js/jquery.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.js') }}"></script>
    {{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>--}}
    {{--<script src="{{ asset('assets/js/Chart.bundle.js') }}"></script>--}}
    {{--<script src="{{ asset('assets/js/utils.js') }}"></script>--}}

    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('head')
</head>
<style>
    #JiSlider {
        width: 100%;
        height: 731px;
    }
</style>

<body>
<div class="user-dashboard rm-footer">
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
        <div id="updates">
            <div class="title">Updates...</div>
            <ul>
                <li>New essay questions added (essay 6). Answers to be published 18/9/18</li>
                <li>Answers for 'Essay 6' are now available.</li>
            </ul>
        </div>
        <div id="status"></div>
    </div>

    {{--<nav id="column-left">--}}
    {{--<span onclick="openNav()" class="fa fa-navicon"></span>--}}
    {{--</nav>--}}

    <div id="content">
        @yield('content')
    </div>
</div>

<script src="{{ asset('assets/js/ie10-viewport-bug-workaround.js') }}"></script>
{{--<script src="{{ asset('assets/js/JiSlider.js') }}"></script>--}}
<script src="{{ asset('assets/js/script.js?ver=1.0.0') }}"></script>

<script>
    $(document).ready(function () {
        const height = $('#sideNav').height();
        $('.dashboard-content .page-content').css('min-height', height - 125);
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
