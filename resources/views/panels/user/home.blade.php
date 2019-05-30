@extends('layouts.user-dashboard')
@section('pageTitle', 'My Profile')

@section('content')
    <?php
    $user = Auth::user();
    $todayDate = date('U');
    $expireDate = date('U', strtotime($user->expire_at));
    ?>

	<div class="dashboard-content">
		<div class="page-title shadow">
			<p>
				<span onclick="openNav()" class="fa fa-navicon mobile_show"></span>
				My Profile
			</p>
		</div>
		<div class="page-content">
			<p class="subtitle"></p>

			@if ((Session::has('success-message')))
				<div class="alert alert-success col-md-12">{{
				Session::get('success-message') }}</div>
			@endif @if ((Session::has('fail-message')))
				<div class="alert alert-danger col-md-12">{{
				Session::get('fail-message') }}</div>
			@endif

			<div class="row">
				<div class="col-sm-6">
					<div class="menu_box">
						<div class="menu_title shadow">Personal</div>
						<ul class="data-table">
							<li>
								<span>My name</span>
								<span style="float: right;">{{ $user->first_name . ' ' . $user->last_name }}</span>
							</li>
							<li>
								<span>Email Address</span>
								<span style="float: right;">{{ $user->email }}</span>
							</li>
						</ul>
					</div>

					{{--<a class="link-primary" href="{{ route('user.edit-profile') }}" style="margin-bottom: 30px">Edit <i class="fa fa-angle-double-right"></i></a>--}}
					<a class="link-primary" href="{{ route('user.edit-profile') }}" style="margin-bottom: 30px">Edit username/password <i class="fa fa-angle-double-right"></i></a>
				</div>

				<div class="col-sm-6">
					<div class="menu_box">
						<div class="menu_title shadow">My account</div>
						<ul class="data-table">
							<li>
								<span>Joined :</span>
								<span style="float: right;"><?php echo date("d-M-Y", strtotime($user->created_at));?></span>
							</li>
							<li>
								<span>Expires</span>
								<span style="float: right;"><?php echo date("d-M-Y", strtotime($user->expire_at)); ?></span>
							</li>
						</ul>
					</div>

					<div class="menu_box">
						<div class="menu_title shadow">Payment History</div>
						<table class="table table-responsive payment-table">
							<tbody>
								<?php
								foreach ($payments as $key => $payment) {
									$paymentdata = unserialize($payment->data);
								?>
								<tr>
									<td style="word-break: break-all">{{ $paymentdata['source']['id'] }}</td>
									<td>£ {{ $paymentdata['amount'] / 100 }}</td>
									<td>{{ $paymentdata['currency'] }}</td>
									<td style="word-break: break-all">{{ $paymentdata['status'] }}</td>
									<td><a href="{{ route('user.invoice-page',['id'=> $payment->id]) }}"> <b>Get Invoice</b></a></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<div class="clearfix"></div>

	</div>
@stop
