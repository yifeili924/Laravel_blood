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

</style>
<script src="{{ asset('assets/js/openseadragon.min.js') }}"></script>
<script src="{{ asset('assets/js/openseadragon-annotations.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js" xmlns:v-bind="http://www.w3.org/1999/xhtml"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<div id="app">
    <div class="panel-content">
        <div class="page-title shadow">
            <p>
                <span onclick="openNav()" class="fa fa-navicon"></span>
                Morphology Cases
            </p>
        </div>
        <div class="page-content">
            <div class="subtitle text-center">
                Fake Description
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

            <a href="{{ route('subscription.hubfigures') }}" class="link-primary text-center">Return</a>
        </div>
    </div>
</div>

<script>
    var app = new Vue({
        el: '#app',
        data: {
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
            annotations: ''
        },
        methods: {
            getComments: function () {
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
