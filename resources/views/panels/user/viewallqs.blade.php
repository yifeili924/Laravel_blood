@extends('layouts.main')
@section('pageTitle', 'Morphology')
@section('content')
@include('partials.status-panel')
<style>
	.flex-grid {
		padding: 0;
		margin: 0;
		list-style: none;
		border: 1px solid silver;
		-ms-box-orient: horizontal;
		display: -webkit-box;
		display: -moz-box;
		display: -ms-flexbox;
		display: -moz-flex;
		display: -webkit-flex;
		display: flex;
	}

	.wrap {
		-webkit-flex-wrap: wrap;
		flex-wrap: wrap;
	}

	.flex-item {
		background: tomato;
		padding: 5px;
		width: 120px;
		height: 100px;
		margin: 10px;

		line-height: 100px;
		color: white;
		font-weight: bold;
		font-size: 2em;
		text-align: center;
	}
</style>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<div class="container">
	<div id="app">
		<div>MCQs EMQs</div>
		<div class="flex-grid wrap">
			<div v-for="mcqsEmq in mcqsEmqs" class="flex-item">
				<a v-bind:href="pref + mcq + mcqsEmq.id" >@{{ mcqsEmq.id }}@{{ mcqsEmq.seen }}</a>
			</div>
		</div>
		<div>Morpholgy</div>
		<div class="flex-grid wrap">
			<div v-for="morpholgy in morpholgys" class="flex-item">
				<a v-bind:href="pref + morph +morpholgy.id">@{{ morpholgy.id }}@{{ morpholgy.seen }}</a>
			</div>
		</div>
		<div>Essays</div>
		<div class="flex-grid wrap">
			<div v-for="essay in essays" class="flex-item">
				<a v-bind:href="pref + essayString + essay.id">@{{ essay.id }}@{{ essay.seen }}</a>
			</div>
		</div>
		<div>Quality Assurance</div>
		<div class="flex-grid wrap">
			<div v-for="qa in qas" class="flex-item">
				<a v-bind:href="pref + qaString + qa.id">@{{ qa.id }}@{{ qa.seen }}</a></div>
		</div>
		<div>Transfusion</div>
		<div class="flex-grid wrap">
			<div v-for="tran in trans" class="flex-item">
				<a v-bind:href="pref + transfusion + tran.id">@{{ tran.id }}@{{ tran.seen }}</a>
			</div>
		</div>
		<div>Haemostasis and thrombosis</div>
		<div class="flex-grid wrap">
			<div v-for="haemo in haemos" class="flex-item">
				<a v-bind:href="pref + haemoString + haemo.id">@{{ haemo.id }}@{{ haemo.seen }}</a></div>
		</div>
	</div>
</div>

<script>
    var app = new Vue({
        el: '#app',
        data: {
            message: 'Hello Vue!',
            morpholgys: [],
            mcqsEmqs: [],
			essays: [],
			qas:[],
			trans: [],
			haemos: [],
			pref: '/user/getquestion/',
			mcq: 'mcq/',
			morph: 'morph/',
			essayString: "essay/",
			qaString: 'qa/',
			transfusion: 'trans/',
			haemoString: 'haemo/'
        },
		methods: {
            getComments: function () {
                this.getMorphology();
                this.getMcqEmq();
            },
			getMorphology: function () {
                axios
                    .get('/user/getMorphology')
                    .then(response => (
                        	this.morpholgys = response.data.morphology ,
                            this.mcqsEmqs = response.data.mcqEmqs ,
							this.essays = response.data.essays ,
							this.qas = response.data.qa,
							this.trans = response.data.trans,
							this.haemos = response.data.haemo
					))
            },
			getMcqEmq: function () {
                console.log("hello from mars");
            }
		},
        mounted() {
            this.getComments()
    }});
</script>
@stop
