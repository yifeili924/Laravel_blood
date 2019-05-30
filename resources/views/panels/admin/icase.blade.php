@extends('layouts.admin')
@section('head')
@stop
@section('content')
<link rel="stylesheet" href="{{asset('assets/css/easy-autocomplete.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/easy-autocomplete.themes.min.css')}}">
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
    .easy-autocomplete.eac-plate-dark ul li {
        font-family: Verdana,Arial,sans-serif;
        font-size: 18px;
    }

</style>
<script src="{{ asset('assets/js/openseadragon.min.js') }}"></script>
<script src="{{ asset('assets/js/openseadragon-annotations.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js" xmlns:v-bind="http://www.w3.org/1999/xhtml"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="{{asset('assets/js/jquery.easy-autocomplete.min.js')}}"></script>

    <div  id="app" class="bs-example">

    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-12">
                    <div class="col-lg-1 form-group">
                        <label for="bucket">Case ID</label>
                        <input v-model="caseId" type="text" class="form-control" disabled="true">
                    </div>
                    <div class="col-lg-3 form-group">
                        <label for="bucket">Submitted By</label>
                        <input v-model="submittedBy" type="text" class="form-control" id="sub" placeholder="BloodAcademy">
                    </div>
                    <div class="col-lg-4 form-group">
                        <label for="publishdate">publish date 01/02/2019</label>
                        <input type="date" id="publishdate" class="form-control" >
                    </div>
                    <div class="col-lg-4 form-group">
                        <label for="closedate">closing date 01/02/2019</label>
                        <input type="date" id="closedate" class="form-control">
                    </div>
                    <div class="col-lg-6 form-group">
                        <label for="casedesc">Case description</label>
                        <textarea v-model="casedescription" class="form-control" id="casedesc"></textarea>
                    </div>
                    <div class="col-lg-6 form-group">
                        <label for="caseexplanation">Case explanation</label>
                        <textarea v-model="caseexplanation" class="form-control" id="caseexplanation"></textarea>
                    </div>
                    <div class="col-lg-2 form-group">
                        <label for="haemo">Haemoglobin</label>
                        <input v-model="haemo" type="text" class="form-control" id="haemo">
                    </div>
                    <div class="col-lg-2 form-group">
                        <label for="whitecell">White cell</label>
                        <input v-model="whitecell" type="text" class="form-control" id="whitecell">
                    </div>
                    <div class="col-lg-2 form-group">
                        <label for="platelet">platelet</label>
                        <input v-model="platelet" type="text" class="form-control" id="platelet">
                    </div>
                    <div class="col-lg-6 form-group ui-widget">
                        <label for="tags">search slide</label>
                        <input id="tags" type="text" class="form-control">
                    </div>
                    <div class="row">
                        <div v-for="slide in selectedSlides" class="panel panel-default col-lg-3">
                            <div class="panel-body col-lg-10">
                                @{{slide.slidename}}
                            </div>
                            <button v-on:click="removeSlide(slide.id)" class="btn btn-danger col-lg-2">
                                delete
                            </button>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 10px">
                        <div class="col-lg-1">
                            <label for="isdispalyed">Display</label>
                            <input id="isdispalyed" type="checkbox" class="form-control" v-model="isdisplayed">
                        </div>
                        <div class="col-lg-1">
                            <label for="ispublic">Make public</label>
                            <input id="ispublic" type="checkbox" class="form-control" v-model="ispublic">
                        </div>
                        <div class="col-lg-1">
                            <label for="pcampt">Active List</label>
                            <input id="pcampt" type="text" class="form-control" v-model="activeMembers">
                        </div>
                        <div class="col-lg-1">
                            <label for="rcampt">Non Active List</label>
                            <input id="rcampt" type="text" class="form-control" v-model="nonActiveMembers">
                        </div>
                        <div class="col-lg-1">
                            <label for="rcampt">AllMemebers</label>
                            <input id="rcampt" type="text" class="form-control" v-model="allmemebers">
                        </div>
                        <div class="col-lg-2">
                            <label for="pcampt">Active TemplateId</label>
                            <input id="pcampt" type="text" class="form-control" v-model="activeMembersTemplateId">
                        </div>
                        <div class="col-lg-2">
                            <label for="rcampt">Non Active TemplateId</label>
                            <input id="rcampt" type="text" class="form-control" v-model="nonActiveMembersTemplateId">
                        </div>
                        <div class="col-lg-2">
                            <label for="rcampt">reporting template Id</label>
                            <input id="rcampt" type="text" class="form-control" v-model="reportingTemplateId">
                        </div>
                    </div>

                    <button v-on:click="addicase()" type="submit" class="btn btn-primary">@{{butext}}</button>
                    <button v-on:click="clearAll()" type="submit" class="btn btn-danger">Clear</button>
                </div>
            </div>
            <div class="row" style="height: 20px"></div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div v-for="icase in icases" class="panel panel-default col-lg-12">
                            <div class="panel-body col-lg-10">
                                @{{icase.id}}: publish date : @{{icase.p_d}}
                                <span v-html="icase.description"></span>
                            </div>
                            <div class="panel-body col-lg-1">
                                <button v-on:click="loadIcase(icase.id)" class="btn btn-info" >
                                        Edit
                                </button>
                            </div>
                            <div class="panel-body col-lg-1">
                                <button class="btn btn-danger" >
                                    <a v-bind:href="'/admin/icase/delete/'+ icase.id">
                                        Delete
                                    </a>
                                </button>
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
            icases: [],
            submittedBy: 'BloodAcademy',
            publishdate: '',
            closedate: '',
            casedescription: '',
            caseexplanation: '',
            haemo: 0,
            whitecell: 0,
            platelet: 0,
            getting: false,
            slides: [],
            selectedSlides: [],
            caseId: '',
            butext: "Create",
            ispublic: false,
            isdisplayed: false,
            activeMembers: 'a2650eceea',
            nonActiveMembers: 'a2650eceea',
            allmemebers: 'a2650eceea',
            activeMembersTemplateId: 119569,
            nonActiveMembersTemplateId: 119573,
            reportingTemplateId: 119541,
        },
        methods: {
            clearAll: function () {
                $('#publishdate').val("");
                $('#closedate').val("");
                this.haemo = 0;
                this.platelet = 0;
                this.whitecell = 0;
                tinyMCE.get('casedesc').setContent("");
                tinyMCE.get('caseexplanation').setContent("");
                this.caseId = "";
                this.selectedSlides = [];
                this.butext = "Create";
            },
            loadIcase: function (icaseid) {
                $('#publishdate').val("");
                $('#closedate').val("");
                for (var i = 0; i < this.icases.length; i++) {
                    if (this.icases[i].id === icaseid) {
                        this.haemo = this.icases[i].haemoglobin;
                        this.platelet = this.icases[i].platelet;
                        this.whitecell = this.icases[i].whitecell;
                        this.isdisplayed = this.icases[i].isdisplayed;
                        this.ispublic = this.icases[i].ispublic;
                        $('#publishdate').val(this.icases[i].p_d);
                        $('#closedate').val(this.icases[i].c_d);
                        tinyMCE.get('casedesc').setContent(this.icases[i].description);
                        tinyMCE.get('caseexplanation').setContent(this.icases[i].explanation);
                        this.caseId = this.icases[i].id;
                        this.selectedSlides = [];
                        for (var j = 0; j < this.icases[i].slides.length; j++) {
                            this.selectedSlides.push(this.icases[i].slides[j]);
                        }
                        this.butext = "Update";
                        return;
                    }
                }
            },
            removeSlide: function (slideId) {
                for( var i = 0; i <= this.selectedSlides.length -1; i++){
                    if ( this.selectedSlides[i].id === slideId) {
                        this.selectedSlides.splice(i, 1);
                        break;
                    }
                }
            },
            addicase: function () {
                var pdate = new Date($('#publishdate').val());
                var cdate = new Date($('#closedate').val());
                if (pdate >= cdate) {
                    alert("close date must be later than publish date");
                    return;
                }
                axios
                    .post('/admin/icase/add', {
                        caseId: this.caseId,
                        submittedBy: this.submittedBy,
                        publishdate: $('#publishdate').val(),
                        closedate: $('#closedate').val(),
                        casedescription: tinyMCE.get('casedesc').getContent(),
                        caseexplanation: tinyMCE.get('caseexplanation').getContent(),
                        haemo: this.haemo,
                        whitecell: this.whitecell,
                        platelet: this.platelet,
                        selectedSlides: this.selectedSlides,
                        isdisplayed: this.isdisplayed,
                        ispublic: this.ispublic,
                        activeList: this.activeMembers,
                        nonActiveList: this.nonActiveMembers,
                        allMemebersList: this.allmemebers,
                        activeTemplateId: this.activeMembersTemplateId,
                        nonActiveTemplateId: this.nonActiveMembersTemplateId,
                        reportingTemplateId: this.reportingTemplateId
                    })

                    .then(function (response) {
                        location.reload();
                    });
            },
            geticases: function () {
                var myslides = [];
                axios
                    .get('/admin/icase/getall')
                    .then(response => (
                        this.icases = response.data
                    ));

                axios
                    .get('/admin/shownewslidesapi')
                    .then(response => (
                        this.slides = response.data,
                        this.setupAuto(this.slides)
                    ));
            },
            setupAuto: function (slides) {
                var options = {
                    data: slides,

                    getValue: "slidename",

                    template: {
                        type: "description",
                        fields: {
                            description: "bucket_name"
                        }
                    },
                    list: {
                        onChooseEvent: function() {
                            var selectedItemValue = $("#tags").getSelectedItemData();
                            $("#tags").val("");
                            for (i = 0; i < app.selectedSlides.length; i++) {
                                if (selectedItemValue.id === app.selectedSlides[i].id) {
                                    return;
                                }
                            }
                            app.selectedSlides.push(selectedItemValue);
                        },
                        match: {
                            enabled: true
                        },
                    },
                    theme: "plate-dark",
                    minCharNumber: 1
                };

                $("#tags").easyAutocomplete(options);
            }
        },
        mounted() {
            this.geticases()
        }});

</script>
@stop