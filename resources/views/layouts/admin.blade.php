<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Blood Academy</title>
        <!-- Bootstrap Core CSS -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="{{ asset('assets/css/sb-admin.css') }}" rel="stylesheet">
        <!-- Morris Charts CSS -->
        <link href="{{ asset('assets/css/plugins/morris.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/jquery-countryselector.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/jquery-te-1.4.0.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
        <!-- Custom Fonts -->
        <link href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
        <link rel="icon" href="{{ asset('assets/images/mini.png') }}">
        <!-- jQuery -->
        <script src="{{ asset('assets/js/jquery.js') }}"></script>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        @yield('head')
    </head>
    <body>
        <div id="wrapper">
            <!-- Navigation -->
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{ route('admin.home') }}">Blood Academy</a>
                </div>
                <!-- Top Menu Items -->
                <ul class="nav navbar-right top-nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> {{Auth::user()->username}} <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <!-- <li>
                                <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                            </li> -->
                            <!-- <li class="divider"></li> -->
                            <li>
                                <a href="{{ url('logout') }}"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                            </li>
                        </ul>

                    </li>
                </ul>
                <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav side-nav">
                        <li class="active">
                            <a href="{{ route('admin.home') }}"><i class="fa fa-fw fa-dashboard"></i>Dashboard</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.members', ['type' => 'all']) }}">Members List</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.add-test') }}">Add Test</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.pages') }}">Pages</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.info') }}">Add Information</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.pay-history') }}">Payment History</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.figurehub') }}">Figures Hub</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.slidehub') }}">Slides Hub</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.managecases') }}">Manage Cases</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.managesampletype') }}">Manage Sample Types</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.guidelines') }}">Guidelines summaries</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.dbfix') }}">DB fixes</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.view-comments') }}">View comments</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.manageslides') }}">Manage Slides</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.icase') }}">Interactive Cases</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.blog') }}">Bolgs</a>
                        </li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </nav>
            <div id="page-wrapper">
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">
                            Dashboard <small></small>
                            </h1>
                            <ol class="breadcrumb">
                                <li class="active">
                                    <i class="fa fa-dashboard"></i> Dashboard
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            @yield('content')
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /#page-wrapper -->
        </div>
        <!-- /#wrapper -->

        <!-- Bootstrap Core JavaScript -->
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap-datepicker.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.countryselector.js') }}"></script>
        <script src="{{ asset('assets/js/jquery-te-1.4.0.min.js') }}"></script>
        <script src="{{ asset('assets/js/script.js?ver=1.0.0') }}"></script>
        <script src="{{ asset('assets/js/tinymce/tinymce.min.js') }}"></script>
        <!-- Morris Charts JavaScript -->
        <!-- <script src="{{ asset('assets/js/plugins/morris/raphael.min.js') }}"></script> -->
        <!-- <script src="{{ asset('assets/js/plugins/morris/morris.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/morris/morris-data.js') }}"></script> -->
         <script>
            $(document).ready(function() {

                tinymce.init({
                  selector: 'textarea',
                  default_link_target: '_blank',
                  plugins: [
                                "autolink lists link autoresize",
                                "searchreplace code",
                                "paste"
                            ]
                });


                //$('textarea, .inpt').jqte();

                $("#quick-setup").countrySelector();
                $(".edit-sub").on('click', function(event) {
                    event.preventDefault();
                    $("#myModal").modal()
                    $("#user_id").val( $(this).attr('data-id') );
                    $("#user_date").val( $(this).attr('data-date') );
                });
                $(".ans_type").on('click', function(event) {
                    if ($(this).is(':checked')) {
                        if ( $(this).val() == 'single') {
                            $(".mcq-form").hide();
                            $(".emq-form").show();
                        }else{
                            $(".mcq-form").show();
                            $(".emq-form").hide();
                        }
                    }
                });
                var max_fields      = 10;
                var wrapper         = $(".input_fields_wrap");
                var x = $(".input_fields_wrap .row").length;
                $(document).on('click', '.add_field_button', function(event) {
                    event.preventDefault();
                    if(x < max_fields) {
                        console.log(x);
                        $(wrapper).append("<div class='row'><div class='col-md-8'><textarea class='form-control inpt_"+x+"' name=multiple_opts["+x+"][0]></textarea></div><div class='col-md-4'><input type='checkbox' name=multiple_opts["+x+"][1]><a href='#' class='remove_field btn btn-primary'>Remove</a></div></div>");
                        //$('.inpt_'+x).jqte();
                        tinymce.init({
                          selector: '.inpt_'+x,
                          default_link_target: '_blank',
                          plugins: [
                                      "autolink lists link autoresize",
                                      "searchreplace code",
                                      "paste"
                                  ]
                        });
                        x++;
                    }
                });


                $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
                    e.preventDefault(); $(this).parent('div').parent('div').remove(); x--;
                })

                // ++++++++++++++++++++++++++
                var max_fields1      = 100;
                var wrapper1         = $(".input_fields_wrap_emq");
                var x1 = $(".input_fields_wrap_emq .row").length;

                $(document).on('click', '.add_field_button_emq', function(event) {
                    event.preventDefault();
                    if(x1 < max_fields1){
                        //$('.textarea_'+x1).jqte();
                        console.log(x1);
                        $(wrapper1).append('' +
                            '<p>' +
                                '<div class="row">' +
                                    '<textarea class="textarea_'+ x1 +'" name="multiple_opts2[' + x1 + '][0]">' +
                                    '</textarea>' +
                                '<div class="input_fields_wrap_emq_inr" data-id="'+x1+'">' +
                                    '<button class="add_field_button_emq_inr" type="button">Add Answer Options</button>' +
                                '<div>' +
                                    '<input type="text" name="multiple_opts2[' + x1 + '][1][1]">' +
                                    '<input type="radio" name="multiple_opts2[' + x1 + '][1][2]">' +
                            '</div></div><a href="#" class="remove_field">Remove</a></div></div></p>'); //add input box
                        x1++;
                    }
                });


                $(wrapper1).on("click",".remove_field", function(e){ //user click on remove text
                    e.preventDefault(); $(this).parent('div').remove(); x1--;
                });

                // ++++++++++++++++++++++++++
                var max_fields2      = 500;
                var wrapper2         = $(".input_fields_wrap_emq_inr");
                var x2 = $(".input_fields_wrap_emq_inr .row2").length;
                $(document).on('click', '.add_field_button_emq_inr', function(event) {
                    event.preventDefault();
                    if(x2 < max_fields2){
                        x2++;
                        var did = $(this).parent('.input_fields_wrap_emq_inr').attr('data-id');
                        $(this).parent('.input_fields_wrap_emq_inr').append('<div><input type="text" name="multiple_opts2[' + did + ']['+x2+'][1]"/><input type="radio" name="multiple_opts2[' + did + ']['+x2+'][2]"><a href="#" class="remove_field">Remove</a></div>'); //add input box
                    }
                });

                $(wrapper2).on("click",".remove_field", function(e){ //user click on remove text
                    e.preventDefault(); $(this).parent('div').remove(); x2--;
                });

                $('.datepicker').datepicker({
                    todayHighlight:'TRUE',
                    autoclose: true,
                }).on('changeDate', function(e){
                    $(this).datepicker('hide');
                });

                $("#removeChoice").on('click', function (event) {
                    console.log("removing .....");
                });

                $("#addChoice").on('click', function () {
                    var x2 = getRandomIntInclusive();
                    var input = '<div id="row'+ x2 +'" class="col-lg-12" style="margin-bottom: 5px">\n' +
                        '        <div class="form-group">\n' +
                        '          <label for="name" class="col-lg-1">Choice '+x2+':</label>\n' +
                        '          <div class="col-lg-10">\n' +
                        '            <input type="text" class="form-control" name="choice['+x2+']" id="choiceId['+x2+']" value="'+x2+'">\n' +
                        '          </div>\n' +
                        '          <div class="col-lg-1">\n' +
                        '            <button type="button" onclick="removeChoice('+ x2 +');" class="close" aria-label="Close">\n' +
                        '              <span aria-hidden="true">&times;</span>\n' +
                        '            </button>\n' +
                        '          </div>\n' +
                        '        </div>\n' +
                        '      </div>';
                    $("#choices").append(input);
                    updateDropDowns();
                });

                $("#addStem").on('click', function () {
                    var stemId = getRandomIntInclusive();
                    var stem =  '      <div class="col-lg-12"  id="stemrow'+ stemId +'" style="margin-bottom: 10px">\n' +
                                '        <div class="form-group">\n' +
                                '          <label for="name" class="col-lg-1">Stem '+stemId+':</label>\n' +
                                '          <div class="col-lg-7">\n' +
                                '            <textarea type="text" class="form-control" name="stem['+stemId+']" id="stemId['+stemId+']"></textarea>\n' +
                                '          </div>\n' +
                                '          <div class="col-lg-1">\n' +
                                '            <select id="currentChoices'+stemId+'" onchange="displaySelected(' + stemId + ', this)">' +
                                '            </select>\n' +
                                '          </div>\n' +
                                '          <div class="col-lg-2" id="labelSpaceStem[' + stemId + ']">\n' +
                                '              <input type="hidden" class="form-control" name="selectedchoice2['+stemId+']" id="selectedchoice'+stemId+'" value="">\n' +
                                '            </div>\n' +
                                '          <div class="col-lg-1">\n' +
                                '            <button type="button" onclick="removeStem('+stemId+')" class="close" aria-label="Close">\n' +
                                '              <span aria-hidden="true">&times;</span>\n' +
                                '            </button>\n' +
                                '          </div>\n' +
                                '        </div>\n' +
                                '      </div>';
                    $("#stems").append(stem);
                    tinymce.EditorManager.execCommand('mceAddEditor', true, "stemId[" + stemId +"]");
                    updateDropDowns();

                });
                updateDropDowns();
            });

            function deselectOthers(key, v){
                let allChoices = $("#existingChoices" + key + " input[type=radio]");
                let i;
                for (i = 1; i <= allChoices.length; i++) {
                    if(  i !== v ){
                        $("#stemChoice"+ key  + i).prop("checked", false);
                    }
                }
            }

            function displaySelected(selectId, thisval) {
                var selectedChoice = "selectedchoice"+ selectId + "";
                console.log("selecting choice " + selectedChoice + " with " + thisval.value.substring(9, (thisval.value.length - 1) ));
                $("#"+selectedChoice).val(thisval.value.substring(9, (thisval.value.length - 1)));
            }

            function updateDropDowns() {
                // get all the current choices
                var allChoices = $("#choices input");
                var allStems = $("#stems select");
                let j;
                for (j = 0; j < allStems.length; j++) {
                    var currentChoices = "#"+ allStems[j].id;
                    $("#selectedchoice"+currentChoices.substr(15)).val("");
                    $(currentChoices).empty();
                    let i;
                    var insertSelect = '<option value="select" id="optionId'+choiceId+'">select</option>';
                    $(currentChoices).append(insertSelect);
                    for (i = 0; i < allChoices.length; i++) {
                        var choiceId = allChoices[i].id;
                        var choiceLabel = allChoices[i].value;
                        var dropDown = '<option value="'+choiceId+'" id="optionId'+choiceId+'">' + choiceId + '</option>';
                        $(currentChoices).append(dropDown);
                    }
                }
            }

            function removeChoice(choiceIndex) {
                $("#row" + choiceIndex).remove();
                updateDropDowns();
            }


            function removeStem(stemId) {
                var stemRemove = "#stemrow" + stemId;
                console.log("removing stem " + stemRemove);
                $(stemRemove).remove();
            }

            function getRandomIntInclusive() {
                min = Math.ceil(2);
                max = Math.floor(10000);
                return Math.floor(Math.random() * (max - min + 1)) + min; //The maximum is inclusive and the minimum is inclusive
            }
         </script>
    </body>
</html>
