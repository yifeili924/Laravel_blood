@extends('layouts.user-page')
@section('pageTitle', 'Morphology Cases')

@section('content')
    @include('partials.status-panel')
    <style>
        .list-group{
            width: 200px;
        }
        .bs-example{
            margin: 20px;
        }
        .img__img {
            position:relative;
            top: -14px;
            left: -16px;
        }
        .sampleLink {
            color: #c4e3f3;
            font-size: 20px;
            margin: 0 15px;
        }
        .innerlink:hover {
            color: #c4e3f3
        }
        .comment_part{
            margin-left: 50px;
        }
        @media (max-width: 700px){
            .comment_part{
                margin-left: 15px;
            }
        }

    </style>

    <script src="{{ asset('assets/js/openseadragon.min.js') }}"></script>
    <script src="{{ asset('assets/js/openseadragon-annotations.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js" xmlns:v-bind="http://www.w3.org/1999/xhtml"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    <div id="app">
        <div class="panel-content">
            <div class="page-title shadow showcase">
                @{{ sampleType }}
                <div v-for="other in otherSamples" class="sampleLink">
                    <a v-bind:href="prefix + other" class="innerlink"> @{{ other }}</a>
                </div>
            </div>
            <div class="page-content">
                <div class="subtitle text-center">
                    @{{ caseDescription }}
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="text-center row no-padding" style="margin-bottom: 30px">
                            <div id="toolbardiv" style="position: relative; float: left; width:100%; height: 38px; background: #e7e7e7"></div>
                            <div id="openses" style="width: 100%; height: 600px; float: left; position: relative; background: #e7e7e7"></div>
                        </div>
                    </div>

                    <div class="col-md-4" style="overflow-y: scroll; height: 650px">
                        <div v-for="annotation in annotations" class="panel panel-default">
                            <div class="panel-heading">
                                <button  v-on:click="jumpTo()" type="button" class="btn btn-primary">Jump to</button>
                            </div>
                            <div class="panel-body">@{{ annotation.text }}</div>
                        </div>
                    </div>
                </div>

                <a href="{{ route('subscription.hubslides') }}" class="link-primary text-center">Return</a>

                <div class="row">
                    <div class="col-md-8">
                        <div class=" row no-padding" style="margin-bottom: 30px">
                            @include('partials._comment_morph', ['comments' => $case->comments->where('sample_type', $sampleType), 'morph_id' =>  $case->id,'sample_type'=>$sampleType])

                            <h3 style="margin-top: 30px;margin-bottom: 30px">Add comment</h3>
                            {!! Form::open(['url' => route('add_comment_to_morphology')] ) !!}

                            <div class="form-group">
                                <textarea name="comment_body" class="form-control" style="height: 100px"></textarea>
                                <input type="hidden" name="morph_id" value="{{ $case->id }}" />
                                <input type="hidden" name="sample_type" value="{{ $sampleType}}" />
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-warning" value="Add Comment" />
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function addReply(comment_id) {
            var reply=document.getElementById("reply_"+comment_id);
            if (reply.style.display=='none'){
                document.getElementById("reply_"+comment_id).style.display =  "block";
            }
            else{
                document.getElementById("reply_"+comment_id).style.display =  "none";
            }

        }
    </script>
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                prefix: '',
                files: [],
                viewer: null,
                xCoord: "",
                yCoord: "",
                annoMode: false,
                buttonText: "Annotate",
                textMode: false,
                selectedOverLayId: '',
                viewportZoom: '',
                annotationText: '',
                annotations: '',
                caseDescription: '',
                sampleType: '',
                otherSamples: [],
            },
            methods: {
                getComments: function () {
                    this.caseDescription = '{{$case->description}}';
                    this.sampleType =  '{{$sampleType}}';
                    this.prefix = '/user/case/get/' + '{{$case->id}}/';
                    this.otherSamples = JSON.parse('{{$otherSamples}}'.replace(/&quot;/g,'"'));
                    console.log(this.otherSamples);
                    var slideName = '{{$slide->name}}';
                    var slideBucket = '{{$slide->bucket_name}}';
                    var slideId = '{{$slide->id}}';
                    this.initDragon(slideName, slideBucket);
                    this.getAnnotations(slideId);
                },
                getAnnotations: function () {
                    this.viewer.clearOverlays();
                    axios
                        .get('/user/annotations/get/' + '{{$slide->id}}')
                        .then(response => (
                        app.annotations = response.data[0].annotations,
                            app.annotations.forEach(function (annotation) {
                                var overLayId = annotation.overlay_id;
                                app.addAnnotationIcon(parseFloat(annotation.x_coord), parseFloat(annotation.y_coord), app.viewer, overLayId, parseFloat(annotation.zoom));
                            })

                    ));
                },
                goToAnnotation: function () {
                    this.viewer.viewport.zoomTo(this.viewportZoom).panTo(new OpenSeadragon.Point(this.xCoord, this.yCoord));
                },
                initDragon: function (filename, bucketname) {
                    viewer = OpenSeadragon({
                        id: "openses",
                        showNavigator:  true,
                        constrainDuringPan: true,
                        prefixUrl: "https://s3.eu-central-1.amazonaws.com/simplezoom123/kidz_files/",
                        tileSources: ["https://s3.eu-west-2.amazonaws.com/"+ bucketname +"/" + filename]

                    });
                    viewer.addHandler('canvas-click', function(event) {
                        var webPoint = event.position;
                        var viewportPoint = viewer.viewport.pointFromPixel(webPoint);

                        if (app.annoMode && !app.textMode) {
                            app.xCoord = viewportPoint.x;
                            app.yCoord = viewportPoint.y;
                            var viewportZoom = viewer.viewport.getZoom(true);
                            app.viewportZoom = viewportZoom.toFixed(3);
                            var overLayId = "overlay" + Math.round(Math.random()*1000) + 1;
                            app.addAnnotationIcon(app.xCoord, app.yCoord, viewer, overLayId, app.viewportZoom);
                            app.overlayId = overLayId;
                            app.textMode = true;
                        }
                    });
                    viewer.initializeAnnotations();
                    this.viewer = viewer;

                },
                addAnnotationIcon: function (x, y, viewer, overLayId, zoom) {
                    ////
                    var img = document.createElement("img");
                    img.src = "/homethromb.png";
                    img.className = "img__img";
                    img.height = "32";
                    img.width = "32";

                    var elt = document.createElement("div");
                    app.selectedOverLayId = overLayId;
                    elt.id = app.selectedOverLayId;
                    elt.appendChild(img);
                    elt.className = "img__wrap";
                    elt.addEventListener('click', function () {
                        console.log("zooming accordingly");
                        viewer.viewport.zoomTo(zoom).panTo(new OpenSeadragon.Point(x, y));
                    });
                    console.log("adding aoverlay  with corrdinates " + zoom);
                    viewer.addOverlay({
                        element : elt,
                        location : new OpenSeadragon.Point(x, y),
                        checkResize: false,
                        rotationMode: 2
                    });
                },
            },
            mounted() {
                this.getComments()
            }});

    </script>
@stop