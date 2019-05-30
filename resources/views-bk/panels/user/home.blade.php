@extends('layouts.main')
@section('head')
@stop
@section('content')
<?php
	$user = Auth::user();
	$todayDate = date('U');
	$expireDate = date('U', strtotime($user->expire_at));
?>

<div class="contant_part">
	
	<div class="container">
		<div class="section_full_rw padding_tp-botm wp100">
			
			<div class="myaccount_se">
				
				<ul>
					<li><span href="#">My account <div style="float: right;">{{$user->first_name}}</div></span></li>
					<li><span href="#">Date joined <div style="float: right;">{{$user->created_at}}</div></span></li>
					<li>
						<span href="#">Your subscription expires on ???
							<div style="float: right;">{{$user->expire_at}}
							<?php
							if($todayDate > $expireDate || $user->subscription == 0) { ?>
								<a class="btn btn-warning" href="{{route('user.subscribe')}}">Subscribe</a>
							<?php } ?>
							</div>
						</span>						
					</li>
					<li><span href="#">Email <div style="float: right;">{{$user->email}}</div></span></li>
				</ul>
				
			</div>
		</div>
		
	</div>
	
</div>

@stop