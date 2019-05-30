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
                <div v-for="file in files" class="panel panel-default col-lg-3" style="">
                    <a v-bind:href="'/admin/slide/get/'+ file.id" target="_blank">
                        <div class="panel-body">
                            @{{file.name}}
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var app = new Vue({
        el: '#app',
        data: {
            files: []
        },
        methods: {
            getComments: function () {
                axios
                    .get('/admin/shownewslidesapi')
                    .then(response => (
                        this.files = response.data
                    ));
            }
        },
        mounted() {
            this.getComments()
        }});

</script>
@stop