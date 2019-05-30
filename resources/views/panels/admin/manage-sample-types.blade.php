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
                        <label for="bucket">Add Sample Type</label>
                        <input v-model="samplename" type="text" class="form-control" id="bucket" aria-describedby="emailHelp" placeholder="case description">
                    </div>
                    <button v-on:click="addSample()" type="submit" class="btn btn-primary" v-bind:disabled="getting">Submit</button>
                </div>
            </div>
            <div class="row" style="height: 20px"></div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div v-for="sample in samples" class="panel panel-default col-lg-6">
                                <div class="panel-body" v-on:mouseover="displayButton(sample.id)" v-on:mouseleave="hideButton(sample.id)">
                                    <a target="_blank" style="position: relative">
                                        @{{sample.name}}
                                    </a>
                                    <button v-bind:id="sample.id" style="display: none; position: absolute; top: 6px; right: 5px;" v-on:click="deleteSample(sample.id)" class="btn btn-danger" >Delete</button>
                                </div>
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
            samples: [],
            getting: false,
            samplename: ''
        },
        methods: {
            deleteSample: function (sampleId) {
                axios
                    .post('/admin/sample/remove', {
                        sample_id: sampleId
                    })
                    .then( response => (
                        this.removeFromArray(this.samples, sampleId)
                    ));
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
            addSample: function () {
                axios
                    .post('/admin/sample/add', {
                        samplename: this.samplename
                    })
                    .then(response => (
                        this.samples.push(response.data),
                        this.samplename = ''
                    ));

            },
            displayButton: function (case_id) {
                $('#' + case_id).show();
            },
            hideButton: function (case_id) {
                $('#' + case_id).hide();
            },
            getComments: function () {
                axios
                    .get('/admin/sample/get/all')
                    .then(response => (
                        this.samples = response.data
                    ));
            }
        },
        mounted() {
            this.getComments()
        }});

</script>
@stop