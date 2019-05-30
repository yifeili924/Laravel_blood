@extends('layouts.admin')
@section('head')
@stop
@section('content')

<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js" xmlns:v-bind="http://www.w3.org/1999/xhtml"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<style>
  .list-group{
    width: 200px;
  }
  .bs-example{
    margin: 20px;
  }

</style>
<div  id="app" class="bs-example">
    <div v-for="comment in comments" class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">@{{comment.user_details}} </h3>
            <br />
            <a v-bind:href="pref + comment.question_type + '/' +comment.question_id">
                <h3 class="panel-title">QId: @{{comment.question_id}} :::: QType: @{{comment.question_type}} :::-> @{{comment.type}} on @{{ comment.created_at }}</h3>
            </a>
        </div>
        <div class="panel-body">
            @{{comment.comment}}
        </div>
    </div>
</div>

<script>
    var app = new Vue({
        el: '#app',
        data: {
            comments: [],
            pref: '/admin/edit-question-'
        },
        methods: {
            getComments: function () {
                axios
                    .get('/admin/getComments')
                    .then(response => (
                        this.comments = response.data
                    ))
            }
        },
        mounted() {
            this.getComments()
        }});
</script>
@stop