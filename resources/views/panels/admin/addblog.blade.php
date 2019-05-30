@extends('layouts.admin_blog')

@section('head')

@stop

@section('content')
    <style>
        .blog_title_lavel{
            width: 500px; height:40px;margin-left: 20px;margin-bottom: 20px;margin-top: 20px
        }
        @media (max-width: 700px) {
            #blog_title_lavel{
                width: 100%; height:40px;margin-left: 0px;margin-bottom: 20px;margin-top: 10px
            }
        }
        .btn-file {
            position: relative;
            overflow: hidden;
        }
        .btn-file input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            min-width: 100%;
            min-height: 100%;
            font-size: 100px;
            text-align: right;
            filter: alpha(opacity=0);
            opacity: 0;
            outline: none;
            background: white;
            cursor: inherit;
            display: block;
        }
    </style>
    {!! Form::open(['url' => route('admin.add-blog'), 'class' => 'form-signin', 'data-parsley-validate','enctype'=>'multipart/form-data' ] ) !!}

        <label for="question">Page Title</label>
        <input name="page_title" class="blog_title_lavel">&nbsp&nbsp&nbsp&nbsp
        <label for="question">Blog Title</label>
        <input name="title" class="blog_title_lavel">
        <h3>Summary</h3>
        <textarea class="form-control my-editor" name="summary"></textarea>
        <h3>Description</h3>
        <textarea class="form-control my-editor" name="blog"></textarea>
        <h3>Featured Image</h3>
        {{--<input type="file" name="image">--}}
        <label class="btn btn-primary">
            Browse <input type="file" name="image" style="display: none;">
        </label>
        <labdel id="file_name"> </labdel>
        <br/>
        <button style="margin-top: 20px" type="submit" class="btn btn-default">Submit</button>
    {{--</form>--}}
    {!! Form::close() !!}


@stop
@section('tinymce')
    <script src="{{ asset('assets/js/tinymce/tinymce.min.js') }}"></script>
    <script>
        // show file name after selecting image
        $(function() {
         // We can attach the `fileselect` event to all file inputs on the page
            $(document).on('change', ':file', function() {
                var input = $(this),
                    numFiles = input.get(0).files ? input.get(0).files.length : 1,
                    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');

                input.trigger('fileselect', [numFiles, label]);
                var file_name=document.getElementById( 'file_name' );
                file_name.textContent=label;

            });
        });

        $(document).ready(function () {

            var editor_config = {
//                path_absolute: "/blood-academy/public/",
                path_absolute: "{{URL::to('/')}}/",
                selector: "textarea",
                plugins: [
                    "advlist autolink lists link image charmap print preview hr anchor pagebreak autoresize",
                    "searchreplace wordcount visualblocks visualchars code fullscreen",
                    "insertdatetime media nonbreaking save table contextmenu directionality paste",
                    "emoticons template paste textcolor colorpicker textpattern"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
                height : "600",
                relative_urls: false,
                file_browser_callback: function (field_name, url, type, win) {
                    var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                    var y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;

                    var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
                    if (type == 'image') {
                        cmsURL = cmsURL + "&type=Images";
                    } else {
                        cmsURL = cmsURL + "&type=Files";
                    }

                    tinyMCE.activeEditor.windowManager.open({
                        file: cmsURL,
                        title: 'Filemanager',
                        width: x * 0.8,
                        height: y * 0.8,
                        resizable: "yes",
                        close_previous: "no"
                    });
                }
            };

            tinymce.init(editor_config);


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

@stop