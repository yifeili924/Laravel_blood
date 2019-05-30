@extends('layouts.user-page')
@section('pageTitle', 'Test Result')

@section('content')
@include('partials.status-panel')

	<div class="panel-content">
		<div class="page-title shadow">
			<p>
				<span onclick="openNav()" class="fa fa-navicon"></span>
				Results Page
			</p>
		</div>
		<div class="page-content">
			<div class="subtitle"> </div>
			<div class="row">
				<div class="col-sm-6">
					<div class="menu_box">
						<h3 class="menu_title shadow">Session Progress</h3>
						<ul class="ref">
							<li>
								<span>Total Questions:</span>
								<span style="float: right;">{{ $stats['total']}}</span>
							</li>
							<li>
								<span>Correct Answers</span>
								<span style="float: right;">{{ $stats['totalCorrect'] }}</span>
							</li>
							<li>
								<span>Incorrect Answers</span>
								<span style="float: right;">{{ $stats['total'] -  $stats['totalCorrect']}}</span>
							</li>
							{{--<li>--}}
								{{--<span>Skipped Answers</span>--}}
								{{--<span style="float: right;">{{ $skip }}</span>--}}
							{{--</li>--}}
							<li>
								<span>Percentage</span>
								<span style="float: right;">{{ round($stats['totalCorrect'] * 100 / $stats['total']) }} %</span>
							</li>
						</ul>
					</div>
				</div>
			</div>

			<a class="link-primary" style="margin-right: 15px; margin-bottom: 20px" href="{{route('activated.protected')}}">Return to Dashboard</a>
			<a class="link-primary" style="margin-right: 15px; margin-bottom: 20px" id="showans" href="{{route('user.reviewsession')}}">Review Incorrect Answers</a>
			<a class="link-primary" style="margin-right: 15px; margin-bottom: 20px" href="{{route('subscription.exam-mcq-emq-opt')}}">Return to MCQ/EMQ</a>

		</div>
	</div>

	<script type="text/javascript">
        $(document).ready(function() {
            $("#showans").on('click', function(event) {
                $("#inc_ans").show();
            });
        });
	</script>
@stop
