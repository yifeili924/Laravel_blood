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
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="bucket">Import bucket</label>
                        <input v-model="bucketName" type="text" class="form-control" id="bucket" aria-describedby="emailHelp" placeholder="baslides">
                    </div>
                    <button v-on:click="importSlidesFromBucket()" type="submit" class="btn btn-primary" v-bind:disabled="getting">Submit</button>
                </div>
            </div>
            <div class="row" style="height: 20px"></div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div v-for="file in files" class="panel panel-default col-lg-3">
                            <a v-bind:href="'/admin/slide/get/'+ file.id" target="_blank">
                                <div class="panel-body">
                                    @{{file.name}} / @{{ file.bucket_name }}
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    var app = new Vue({
        el: '#app',
        data: {
            files: [],
            bucketName: '',
            getting: false
        },
        methods: {
            getComments: function () {
                axios
                    .get('/admin/shownewslidesapi')
                    .then(response => (
                        this.files = response.data
                    ));
            },
            importSlidesFromBucket: function () {
                this.getting = true;
                axios
                    .get('/admin/importslides/' + this.bucketName)
                    .then(response => (
                        this.files = [],
                        this.files = response.data,
                        this.getting = false
                    ));
            }
        },
        mounted() {
            this.getComments()
        }});

</script>
@stop