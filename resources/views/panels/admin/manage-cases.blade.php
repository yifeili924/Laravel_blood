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
                        <label for="bucket">Add Case</label>
                        <input v-model="casedescription" type="text" class="form-control" id="bucket" aria-describedby="emailHelp" placeholder="case description">
                    </div>
                    <button v-on:click="addCase()" type="submit" class="btn btn-primary" v-bind:disabled="getting">Submit</button>
                </div>
            </div>
            <div class="row" style="height: 20px"></div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div v-for="mcase in mcases" class="panel panel-default col-lg-6">
                                <div class="panel-body" v-on:mouseover="displayButton(mcase.id)" v-on:mouseleave="hideButton(mcase.id)">
                                    <a v-bind:href="'/admin/slide/get/'+ mcase.id" target="_blank" style="position: relative">
                                        @{{mcase.description}}
                                    </a>
                                    <button v-bind:id="mcase.id" style="display: none; position: absolute; top: 6px; right: 5px;" v-on:click="deleteCase(mcase.id)" class="btn btn-danger" >Delete</button>
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
            mcases: [],
            getting: false,
            casedescription: ''
        },
        methods: {
            deleteCase: function (caseId) {
                axios
                    .post('/admin/cases/remove', {
                        case_id: caseId
                    })
                    .then(response => (
                        this.removeFromArray(this.mcases, caseId)
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
            addCase: function () {
                axios
                    .post('/admin/cases/add', {
                        caseDescription: this.casedescription
                    })
                    .then(response => (
                        this.mcases.push(response.data),
                        this.casedescription = ''
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
                    .get('/admin/cases/get/all')
                    .then(response => (
                        this.mcases = response.data
                    ));
            }
        },
        mounted() {
            this.getComments()
        }});

</script>
@stop