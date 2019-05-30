var abc = 0; //Declaring and defining global increement variable


$(document).ready(function() {

    $("#disSlides").click(function(){
      $(".slidez").remove();
      $(".slidezcl").remove();
      $.ajax({
              url: '/admin/disSlides',
              type: 'GET',
              dataType: 'json',
              data: {
                  text: 'helloworld'
              },
              success: function (data) {
                  for (var k in data) {
                      var imname = data[k].name;
                      var slideId = data[k].id;
                      var div = document.createElement("div");
                      div.id = "slidesgall";
                      div.onclick = selectSlidesDiv;
                      div.className = "slidez";
                      var link = document.createElement("div");
                      var desc = document.createElement("div");

                      desc.className = "desc";
                      desc.textContent = imname;
                      desc.id = slideId;

                      link.appendChild(desc);
                      div.appendChild(link);
                      $(".modalslides").append(div);
                  }
              }
          });
    });
    $("#deleteslides").click(function () {
      $(".sslidezcl").remove();
      $("#deleteslides").prop("hidden", true);
      updateSlideInputValue();
    });

    function selectSlidesDiv() {
      if(this.className === "slidez") {
        this.className = "slidezcl";
      } else {
        this.className = "slidez";
      }
    }

    $('#slidebut').click(function () {
        $(".modalslides").children().each(function (){
            if(this.className === "slidezcl") {
                var imagename = $(this).children("div").children("div").text();
                var slideId = $(this).children("div").children("div").attr('id');
                console.log('slide ' + slideId);
                var imageFound = false;

                $(".selectedSlides").children().each(function () {
                    var selectedImageName = $(this).children("div").children("div").text();
                    if(selectedImageName === imagename) {
                        imageFound = true;
                    }
                });

                if(!imageFound){
                    var div = document.createElement("div");
                    div.id = "tablesfigures";
                    div.className = "sslidez";
                    div.onclick = selectSlide;
                    var link = document.createElement("a");
                    link.setAttribute("href", '/admin/slide/get/' + slideId);
                    link.setAttribute("target", "_blank");
                    var desc = document.createElement("div");
                    desc.className = "desc";
                    desc.textContent = imagename;
                    link.appendChild(desc);
                    div.appendChild(link);
                    $(".selectedSlides").append(div);
                }
            }
        });
      updateSlideInputValue();
    });
    function updateSlideInputValue() {
      $("#finalslides").val("");
      var inputvalue;
      $(".selectedSlides").children().each(function () {
        if(inputvalue) {
          inputvalue = inputvalue + "|" + $(this).children("a").children("div").text();
        } else {
          inputvalue = $(this).children("a").children("div").text();
        }
      });
      $("#finalslides").val(inputvalue);
    }
    selectSlide = function() {
      sSlide(this);
    };
    window.sSlide = function (element) {
      if(element.className === "sslidez") {
        element.className = "sslidezcl";
        showSlideDeleteButton();
      } else {
        element.className = "sslidez";
        removeSlideDeleteButton();
      }
    };
    function removeSlideDeleteButton() {
      var someselected = false;
      $(".selectedSlides").children().each(function (){
        if(this.className === "sslidezcl") {
          someselected = true;
        }
      });
      if(!someselected) {
        $("#deleteslides").prop("hidden", true);
      }
    }
    function showSlideDeleteButton() {
      var hidden = $("#deleteslides").attr("hidden");
      if(hidden != undefined) {
        $("#deleteslides").removeAttr("hidden");
      }
    }

    $('#fbModal').on('show.bs.modal', function(e) {

        //get data-id attribute of the clicked element
        var questionId = $(e.relatedTarget).data('question-id');
        var questionType = $(e.relatedTarget).data('question-type');

        //populate the textbox
        $(e.currentTarget).find('input[id="questionId"]').val(questionId);
        $(e.currentTarget).find('input[id="questionType"]').val(questionType);
    });

    $("#disImages").click(function(){
      $(".imgz").remove();
      $(".imgzcl").remove();
      $.ajax({
              url: '/admin/disImages',
              type: 'GET',
              dataType: 'json',
              data: {
                  text: 'helloworld'
              },
              success: function (data) {
                  for (var k in data) {
                    var imname = data[k].figureid;
                    var div = document.createElement("div");
                    div.id = "gall";
                    div.onclick = selectDiv;
                    div.className = "imgz";
                    var link = document.createElement("a");
                    link.setAttribute("href", "https://s3.eu-west-2.amazonaws.com/tablesfigures/" + imname);
                    link.setAttribute("target", "_blank");
                    var img = document.createElement("img");
                    img.setAttribute("src", "https://s3.eu-west-2.amazonaws.com/tablesfigures/" + imname);
                    img.setAttribute("width", "300");
                    img.setAttribute("height", "200");
                    var desc = document.createElement("div");
                    desc.className = "desc";
                    desc.textContent = imname;
                    link.appendChild(desc);
                    div.appendChild(img);
                    div.appendChild(link);
                    $(".modalimages").append(div);
                  }
              }
          });
    });

    $("#deleteimages").click(function () {
      $(".simgzcl").remove();
      $("#deleteimages").prop("hidden", true);
      updateInputValue();
    });

    function selectDiv() {
      if(this.className === "imgz") {
        this.className = "imgzcl";
      } else {
        this.className = "imgz";
      }
    }

    $('#imgbut').click(function () {
      $(".modalimages").children().each(function (){
        if(this.className === "imgzcl") {
          var imagename = $(this).children("a").children("div").text();
          var imageFound = false;

          $(".selectedImages").children().each(function () {
              var selectedImageName = $(this).children("a").children("div").text();
              if(selectedImageName === imagename) {
                imageFound = true;
              }
          });

          if(!imageFound){
              var div = document.createElement("div");
              div.id = "gall";
              div.className = "simgz";
              div.onclick = selectImage;
              var link = document.createElement("a");
              link.setAttribute("href", $(this).children("img").attr("src"));
              link.setAttribute("target", "_blank");
              var img = document.createElement("img");
              img.setAttribute("src",  $(this).children("img").attr("src"));
              img.setAttribute("width", "300");
              img.setAttribute("height", "200");
              var desc = document.createElement("div");
              desc.className = "desc";
              desc.textContent = imagename;
              link.appendChild(desc);
              div.appendChild(img);
              div.appendChild(link);
              $(".selectedImages").append(div);
            }
        }
      });
      updateInputValue();
    });
    function updateInputValue() {
      $("#finalimages").val("");
      var inputvalue;
      $(".selectedImages").children().each(function () {
        if(inputvalue) {
          inputvalue = inputvalue + "|" + $(this).children("a").children("div").text();
        } else {
          inputvalue = $(this).children("a").children("div").text();
        }
      });
      $("#finalimages").val(inputvalue);
    }
    selectImage = function() {
      sImage(this);
    };
    window.sImage = function (element) {
      if(element.className === "simgz") {
        element.className = "simgzcl";
        showDeleteButton();
      } else {
        element.className = "simgz";
        removeDeleteButton();
      }
    };
    function removeDeleteButton() {
      var someselected = false;
      $(".selectedImages").children().each(function (){
        if(this.className === "simgzcl") {
          //this one is selected
          someselected = true;
        }
      });
      if(!someselected) {
        $("#deleteimages").prop("hidden", true);
      }
    }
    function showDeleteButton() {
      var hidden = $("#deleteimages").attr("hidden");
      if(hidden != undefined) {
        $("#deleteimages").removeAttr("hidden");
      }
    }





    $('#add_more').click(function() {

        $(this).before($("<div/>", {

            id: 'filediv'

        }).fadeIn('slow').append(

            $("<input/>", {

                name: 'file[]',

                type: 'file',

                id: 'file'

            }),

            $("<br/><br/>")

        ));

    });



    //following function will executes on change event of file input to select different file

    $('body').on('change', '#file', function() {

        if (this.files && this.files[0]) {

            abc += 1; //increementing global variable by 1



            var z = abc - 1;

            var x = $(this).parent().find('#previewimg' + z).remove();

            $(this).before("<div id='abcd" + abc + "' class='abcd'><img id='previewimg" + abc + "' src=''/></div>");



            var reader = new FileReader();

            reader.onload = imageIsLoaded;

            reader.readAsDataURL(this.files[0]);



            $(this).hide();

            $("#abcd" + abc).append($("<img/>", {

                id: 'img',

                src: '/assets/images/x.png',

                alt: 'delete'

            }).click(function() {

                $(this).parent().parent().remove();

            }));

        }

    });



    //To preview image

    function imageIsLoaded(e) {

        $('#previewimg' + abc).attr('src', e.target.result);

    }



    $('#upload').click(function(e) {

        var name = $(":file").val();

        if (!name) {

            alert("First Image Must Be Selected");

            e.preventDefault();

        }

    });



    // morphology ---- >>

    var max_fields2 = 10; //maximum input boxes allowed

    var wrapper2 = $(".input_fields_wrap2"); //Fields wrapper

    var add_button2 = $(".add_field_button2"); //Add button ID



    var x = $(".input_fields_wrap2 .row2").length; //initlal text box count

    $(add_button2).click(function(e) { //on add input button click



        e.preventDefault();

        if (x < max_fields2) { //max input box allowed

            x++; //text box increment

            $(wrapper2).append('<div class="row2"><div class="form-group"><label for="question">Question ' + x + ':</label><textarea class="form-control textarea_' + x + '" name="question[' + x + '][0]"></textarea></div><div class="form-group"><label for="question">Answer:</label><textarea class="form-control textarea_' + x + '" name="question[' + x + '][1]"></textarea></div><a href="#" class="remove_field">Remove</a></div>');

            //$('.textarea_' + x).jqte();
            tinymce.init({
              selector: '.textarea_' + x,
              default_link_target: '_blank',
              plugins: [
                            "autolink lists link autoresize",
                            "searchreplace code",
                            "paste"
                        ]
            });

        }

    });



    $(wrapper2).on("click", ".remove_field", function(e) { //user click on remove text

        e.preventDefault();

        $(this).parent('div').remove();

        x--;

    });



    // << ----

    // Frontend



    $("#save_note").on('click', function(event) {

        if ($("#txt_notes").val() != "") {
            $.ajax({

                    url: Base_Url + '/save-note',

                    type: 'POST',

                    dataType: 'json',

                    data: {

                        text: $("#txt_notes").val(),

                        dt: $("#dt").val(),

                        qid: $("#qid").val()

                    },

                    headers: {

                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                    }

                })

                .done(function(res) {
                    $("#notes").append('<li><a href="'+res.key+'">' + $("#txt_notes").val() + ' - ' + res.id + '</a></li>');
                    console.log("success", res);
                    $("#txt_notes").val('');

                })

                .fail(function() {

                    console.log("error");

                });



        }

    });


    $(document).on('click', '#check_all', function(event) {

        if ($(this).is(':checked')) {

            $(".subject").prop('checked', true);

        } else {

            $(".subject").prop('checked', false);

        }

    });

    // function resetChart() {
    //
    //
    //
    //     if (localStorage.getItem("correct") != null) {
    //
    //         var corr = parseFloat(localStorage.getItem("correct")) * 100;
    //
    //         var tt = corr / tot;
    //
    //         localStorage.setItem("perc", parseFloat(tt));
    //
    //         $("#pers").text(parseFloat(tt).toFixed(0));
    //
    //     }
    //
    //
    //
    //     config.data.datasets.forEach(function(dataset) {
    //
    //         dataset.data[0] = parseFloat(localStorage.getItem("correct"));
    //
    //         dataset.data[1] = parseFloat(localStorage.getItem("incorrect"));
    //
    //     });
    //
    //     window.myPie.update();
    //
    // }

    $(".tab .tablinks").click(function() {
        const index = $(this).index();
        $(this).addClass('active').siblings().removeClass('active');
        $('.tablist .tabcontent').eq(index).show().siblings().hide();
    });

    $('.question-list .question-item').click(function(){
        $(this).addClass('selected').siblings().removeClass('selected');
        $('#current').removeAttr('disabled');
        const val = $(this).data('value');
        //alert(val);
        $(this).parent().find('input').val(val);
        $('#selIndex').val(val);
    });

    $(".options li").click(function () {
        $(this).addClass('active').siblings().removeClass('active');
    });

    $(window).resize(function () {
        const width = $(window).width();
        if (width >= 992) {
            $(".user-dashboard .sidenav").css({'left': 0, 'position': 'absolute'});
        } else {
            $(".user-dashboard .sidenav").css({'left': -400, 'position': 'fixed'});
        }
    });
});