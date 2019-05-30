@extends('layouts.admin')

@section('head')

@stop

@section('content')

<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js" xmlns:v-bind="http://www.w3.org/1999/xhtml"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<h3>Payment History Listing 222</h3>

<div id="app" class="bs-example">
  <ul>
    <li>
      <a href="{{ route('admin.fixchoiceIndecies') }}">DB fixes</a>
    </li>
  </ul>
  <div class="row">
    <div class="col-lg-4">
      <div class="form-group">
        <label for="file">File</label>
        <input v-model="filename" type="text" class="form-control"/>
      </div>
        <button v-on:click="processFile()"
                class="btn btn-danger"
                v-bind:disabled="getting"
                data-toggle="tooltip" title="input the name of the excel file that contains the cases to import, make sure that file exists in
asset/images and click here">
            Upload
        </button>
        <button v-on:click="removeWhiteSpaces()" class="btn btn-info" v-bind:disabled="getting">remove existing whitespaces in description</button>
        <button v-on:click="importFigures()" class="btn btn-danger" v-bind:disabled="getting">import figures From excel</button>
        <button v-on:click="importFiguresFromBucket()" class="btn btn-danger" v-bind:disabled="getting">import figures from bucket</button>
        <button v-on:click="changeSlideExtensions()"
                class="btn btn-danger"
                v-bind:disabled="getting"
                data-toggle="tooltip" title="change current slide extentions in from .jpg to .dzi and prefix with bucket
                _name">
            change extensions
        </button>
        <button v-on:click="migrateMorphologyQsSlides()"
                class="btn btn-danger"
                v-bind:disabled="getting"
                data-toggle="tooltip" title="Creates the proper relations between slides and Morphology Questions">
            Migrate Morphology
        </button>
        <button v-on:click="importFeatures()"
                class="btn btn-danger"
                v-bind:disabled="getting"
                data-toggle="tooltip" title="imports features, investigations and diagnoiss from csv file">
            Import Features
        </button>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-4" v-if="changes.length == 0">
      No white spaces exist in the current case descriptions
    </div>
    <div class="col-lg-4" v-for="change in changes">
      @{{ change }}
    </div>
      <div class="col-lg-4" v-for="figure in figures">
          @{{ figure.title }}
      </div>
  </div>
</div>
<script>
    var app = new Vue({
        el: '#app',
        data: {
            samples: [],
            getting: false,
            filename: '',
            changes: ['click blue to nuke white spaces'],
            figures: [],
        },
        methods: {
            migrateMorphologyQsSlides: function () {
                this.getting = true;
                axios
                    .get('/admin/morphology/migrateMorphology')
                    .then(response => (
                        this.figures = response.data ,
                        this.getting = false
                    ));
            },
            changeSlideExtensions: function () {
                this.getting = true;
                axios
                    .get('/admin/morphology/fixslidextensions')
                    .then(response => (
                        this.figures = response.data,
                            this.getting = false
                    ));
            },
            importFiguresFromBucket: function () {
                this.getting = true;
                axios
                    .post('/admin/figures/importfrombucket', {
                        bucket_name: this.filename
                    })
                    .then(response => (
                        this.figures = response.data,
                        this.getting = false
                    ));
            },
            importFeatures: function () {
                this.getting = true;
                axios
                    .post('/admin/icase/importfeatures', {
                        file_name: this.filename
                    })
                    .then(response => (
                        this.figures = response.data,
                        this.getting = false
                    ));
            },
            importFigures: function () {
                this.getting = true;
                axios
                    .post('/admin/figures/import', {
                        file_name: this.filename
                    })
                    .then(response => (
                        this.figures = response.data,
                        this.getting = false
                    ));
            },
            removeWhiteSpaces: function () {
                this.getting = true;
                axios
                    .get('/admin/cases/removewhitespaces')
                    .then(response => (
                        this.changes = response.data,
                        this.getting = false
                    ));
            },
            processFile: function () {
                this.getting = true;
                axios
                    .get('/admin/cases/import/' + this.filename)
                    .then(response => (
                        this.changes = ['imported check slides hub'],
                        this.getting = false
                    ));
            },
            getComments: function () {
                // axios
                //     .get('/admin/cases/get/all')
                //     .then(response => (
                //         this.samples = response.data
                //     ));
            }
        },
        mounted() {
            this.getComments()
        }});

</script>
@stop