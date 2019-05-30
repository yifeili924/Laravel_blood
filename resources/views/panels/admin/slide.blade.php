@extends('layouts.admin')
@section('head')
@stop
@section('content')
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
<div  id="app" class="bs-example">
    <div class="row">
        <div class="col-lg-6">
            <h3 style="margin-top: 5px">@{{ slideName }}
                <button  v-on:click="flipper()" type="button" class="btn btn-primary">@{{ buttonText }}</button>
                <button  v-on:click="goToAnnotation()" class="btn btn-info">Retrieve</button>
            </h3>
            <div id="openses"  style="width: 800px; height: 600px; border: 1px;">

            </div>
        </div>
        <div class="col-lg-6">
            <div class="row">
                <div id="annotext" v-if="textMode" style="padding-top: 50px">
                    <div class="form-group">
                        <label for="annotationText">Text @{{ xCoord }}, @{{ yCoord }}, @{{ viewportZoom }}</label>
                        <textarea v-model="annotationText" class="form-control" id="annotationText" rows="3"></textarea>
                    </div>
                    <button v-on:click='addAnnotation()' class="btn btn-primary">Submit</button>
                    <button v-on:click="cancelTextMode" class="btn btn-danger">Cancel</button>
                </div>
            </div>
            <div v-for="annotation in annotations" class="panel panel-default">
                <div class="panel-heading">
                    <button  v-on:click="jumpTo()" type="button" class="btn btn-primary">Jump to</button>
                    <button  v-on:click="deleteAnnotation(annotation.id, annotation.overlay_id)" class="btn btn-info">Delete</button>
                </div>
                <div class="panel-body">@{{ annotation.text }}</div>
            </div>
        </div>
    </div>

</div>

<script>
    var app = new Vue({
        el: '#app',
        data: {
            files: [],
            pref: '/admin/edit-question-',
            viewer: null,
            selectedSlide: '',
            xCoord: "",
            yCoord: "",
            annoMode: false,
            buttonText: "Annotate",
            textMode: false,
            selectedOverLayId: '',
            viewportZoom: '',
            annotationText: '',
            slideId: '',
            slideName: '',
            annotations: [],
        },
        methods: {
            addAnnotation: function (){
                axios
                    .post('/admin/annotation/add', {
                        slideId: this.slideId,
                        xCoord: this.xCoord,
                        yCoord: this.yCoord,
                        message: this.annotationText,
                        zoom: this.viewportZoom,
                        overlayId: this.overlayId
                    })
                    .then(function (response) {
                        app.annotations.push(response.data);
                    });
                this.annotationText = '';
                this.textMode = false;
                app.flipper();
            },
            deleteAnnotation: function (annotationId, overlayId) {
                axios
                    .post('/admin/annotation/remove', {
                        annotationId: annotationId,
                    })
                    .then(function (response) {
                        app.annotations = app.removeFromArray(app.annotations, annotationId)
                        app.removeAnnotationIcon(overlayId);
                    });
            },
            removeAnnotationIcon: function (annotationId) {
                this.viewer.removeOverlay(annotationId);
            },
            removeFromArray: function (myArray, itemToRemove) {
                for(var i = myArray.length - 1; i >= 0; i--) {
                    if(myArray[i].id === itemToRemove) {
                        myArray.splice(i, 1);
                        break;
                    }
                }
                return myArray
            },
            getComments: function () {
                var slideName = '{{$slide->name}}';
                var slideBucket = '{{$slide->bucket_name}}';
                var slideId = '{{$slide->id}}';
                this.initDragon(slideName, slideBucket);
                this.getAnnotations(slideId);
                this.slideId = slideId;
                this.slideName = slideName;
            },
            getAnnotations: function (slideId) {
                this.viewer.clearOverlays();
                axios
                    .get('/admin/annotation/get/' + slideId)
                    .then(response => (
                        app.annotations = response.data[0].annotations,
                            app.annotations.forEach(function (annotation) {
                            //var overLayId = "overlay" + Math.round(Math.random()*1000) + 1;
                            var overLayId = annotation.overlay_id;
                            app.addAnnotationIcon(parseFloat(annotation.x_coord), parseFloat(annotation.y_coord), app.viewer, overLayId, parseFloat(annotation.zoom));
                        })

                    ));
            },
            goToAnnotation: function () {
                this.viewer.viewport.zoomTo(this.viewportZoom).panTo(new OpenSeadragon.Point(this.xCoord, this.yCoord));
            },
            initDragon: function (filename, bucketname) {
                if(this.viewer){
                 this.viewer.destroy()
                }
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
                        let viewportZoom = viewer.viewport.getZoom(true);
                        app.viewportZoom = viewportZoom.toFixed(3);
                        let overLayId = "overlay" + Math.round(Math.random()*1000) + 1;
                        app.addAnnotationIcon(app.xCoord, app.yCoord, viewer, overLayId, app.viewportZoom);
                        app.overlayId = overLayId;
                        app.textMode = true;
                    }
                });
                viewer.initializeAnnotations();
                this.viewer = viewer;

            },
            cancelTextMode: function () {
              this.textMode = !this.textMode;
              this.viewer.removeOverlay(this.selectedOverLayId);
            },
            flipper: function () {
                this.annoMode = !this.annoMode;
                this.buttonText = this.annoMode ? "Cancel": "Annotate";
                this.viewer.zoomPerClick = this.annoMode ? 1 : 2 ;
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
                    viewer.viewport.zoomTo(zoom).panTo(new OpenSeadragon.Point(x, y));
                });
                viewer.addOverlay({
                    element : elt,
                    location : new OpenSeadragon.Point(x, y),
                    checkResize: false,
                    rotationMode: 2
                });
            },
            enableAnno: function () {
                // if zoom is locked then unlock otherwise lock.
                if (this.viewer.zoomPerClick === 1) {
                    this.viewer.zoomPerClick = 2;
                    this.annoMode = false;
                } else {
                    this.viewer.zoomPerClick = 1;
                    this.annoMode = true;
                }
            },
            addTempAnnoOverLay: function(x, y) {
                var img = document.createElement("img");
                img.src = "/homethormb.png";
                img.className = "img__img";
                img.height = "32";
                img.width = "32";

                var elt = document.createElement("div");
                elt.id = Math.round(Math.random()*1000) + 1;;
                elt.appendChild(img);
                elt.className = "img__wrap";
                this.viewer.addOverlay({
                    element : elt,
                    location : new OpenSeadragon.Point(x, y)
                });
            },
            cleanUp: function () {
              this.viewer.annotations.clean();
            }
        },
        mounted() {
            this.getComments()
        }});

</script>
@stop