@extends('layouts.main')
@section('pageTitle', 'Subscription')

@section('content')
@include('partials.status-panel')

	<div class="container">
		<div class="payment-section">
			<div class="Choose_plan" style="margin-top: 15px;">
				<h4>In order to gain access to the content please choose a subscription option</h4>
			</div>
			<div class="form-signin">
				<div class="row">
					<form accept-charset="UTF-8" action="{{route('user.stripe-payment')}}" class="require-validation"
						  data-get-coupon-url={{route('user.get-coupon')}}
						  data-cc-on-file="false"
						  data-stripe-publishable-key="{{ env('STR_PUB') }}"
						  id="payment-form" method="post">
						{{ csrf_field() }}

						<div class="container-fluid grid">
							<div class="row pull-center">
								<div class="well">
									<div class="Choose_plan">
										<h3>Subscription Type</h3>
										<div class="plain-select">
											<select name="subtype" id="subtype">
												<option value="four">4 Months Exams + Hub(&pound;80)</option>
												<option value="two">2 Months Exams + Hub(&pound;60)</option>
												<option value="three">1 year Hub(&pound;50)</option>
											</select>
										</div>
									</div>

									<div class="row card"></div>
									<br/>
									<br/>

									<div class="row">
										<div class="col-md-8">
											<div class="form-group">
												<label for="cardNumber">Credit Card Number </label>
												<input type="text" id="cardNumber" name="number" class="form-control" />
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="expiry">Expiration</label>
												<input type="text" placeholder="MM/YYYY" id="expiry" name="expiry" class="form-control" />
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-8">
											<div class="form-group">
												<label for="userName">Name</label>
												<input type="text" id="userName" name="name" class="form-control" required/>
											</div>
										</div>

										<div class="col-md-4">
											<div class="form-group">
												<label for="cvc">CVC </label>
												<input type="text" id="cvc" name="cvc" class="form-control" required/>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-8">
											<div class="row">
												<div class="col-md-8 col-sm-9">
													<label for="discode">Discount code</label>
													<input type="text" id="discode" name="discode" class="form-control"/>
												</div>
												<div class="col-md-4 col-sm-3 text-right">
													<button type="button" class="btn btn-primary" id="coupon"><i class="fa fa-spinner"></i>Add Code</button>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group input-icon">
												<label for="total">Total Payment</label>
												<input type="text" id="total" name="amount" class="form-control" value="80" readonly/>
												<i>&pound;</i>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-12 text-right">
											<button class="btn btn-success">Submit</button>
											<button type="button" class="btn btn-info" id="resetForm">Clear</button>
										</div>
									</div>

								</div>
							</div>
						</div>

					</form>

					<div class='form-row' style="color: red">
						<div class='col-md-12 error form-group hide'>
							<div class='alert-danger alert'></div>
						</div>
					</div>

					@if ((Session::has('success-message')))
						<div class="alert alert-success col-md-12">
							{{Session::get('success-message') }}
						</div>
					@endif
					@if ((Session::has('fail-message')))
						<div class="alert alert-danger col-md-12">
							{{ Session::get('fail-message') }}
						</div>
					@endif

				</div>
			</div>
		</div>
	</div>

	<script src='https://js.stripe.com/v2/' type='text/javascript'></script>
	<script src="https://code.jquery.com/jquery-1.12.3.min.js"></script>
	<script src="{{ asset('assets/js/card.js') }}"></script>
	<script>
	$(document).ready(function(){
        new Card({
            form: '#payment-form',
            container: '.card',
            formSelectors: {
                numberInput: 'input[name=number]',
                expiryInput: 'input[name=expiry]',
                cvcInput: 'input[name=cvc]',
                nameInput: 'input[name=name]'
            },

            width: 390, // optional — default 350px
            formatting: true,

            placeholders: {
                number: '•••• •••• •••• ••••',
                name: 'Full Name',
                expiry: '••/••••',
                cvc: '•••'
            }
        });

		$(".alert-success").fadeTo(2000, 500).slideUp(500, function(){
			$(".alert-success").slideUp(500);
		});

		$(".danger").fadeTo(2000, 500).slideUp(500, function(){
			$(".danger").slideUp(500);
		});

		$("#resetForm").click(function () {
			$(":text").val('');
        });

		$("#subtype").change(function(){
			var member = $(this).children("option:selected").val();
			var price = 0;
			switch (member) {
				case 'four':
					price = 80;
					break;
				case 'two':
					price = 60;
					break;
				case 'three':
					price = 50;
			}

			$('#total').val(price);
		});

		$('#coupon').click(function(){
			button = $(this);
			requestData = "coupon_id="+$('#discode').val();
			getCouponUrl = $('#payment-form').data('get-coupon-url');
			$.ajax({
				type: "GET",
				url: getCouponUrl,
				data: requestData,
				beforeSend: function() {
					button.find( 'i' ).addClass( 'fa-spin' );
				},
				success: function(response){
					button.find( 'i' ).removeClass( 'fa-spin' );

					var member = $('#subtype').find(":selected").val();
					var amount = 0;
					switch (member) {
						case 'four':
							amount = 80;
							break;
						case 'two':
							amount = 60;
							break;
						case 'three':
							amount = 50;
					}

					// amount = $('#total').val();
					console.log('Origin', amount);

					discount = amount * (100 - response) / 100;
					// console.log('After', discount);
					$('#total').val(discount);
				}
			});
		});
	});

    $(function() {
        var $form = $("#payment-form");
        $form.on('submit', function(e) {
            if (!$form.data('cc-on-file')) {
                var expMonthAndYear = $('input[name=expiry]').val().split(" / ");
                e.preventDefault();
                Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                Stripe.card.createToken({
                    number: $('input[name=number]').val(),
                    cvc: $('input[name=cvc]').val(),
                    exp_month: expMonthAndYear[0],
                    exp_year: expMonthAndYear[1]
                }, stripeResponseHandler);
            }
        });

        var stripeResponseHandler = function(status, response) {
            if (response.error) {
                $('.error')
                    .removeClass('hide')
                    .find('.alert')
                    .text(response.error.message);
            } else {
                // token contains id, last4, and card type
                var token = response.id;
                // insert the token into the form so it gets submitted to the server
                $form.find('input[type=text]').empty();
                $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                $form.get(0).submit();
            }
        }
    });

	$(function() {
		$('form.require-validation').bind('submit', function(e) {
			var $form         = $(e.target).closest('form'),
				inputSelector = ['input[type=email]', 'input[type=password]',
								 'input[type=text]', 'input[type=file]',
								 'textarea'].join(', '),
				$inputs       = $form.find('.required').find(inputSelector),
				$errorMessage = $form.find('div.error'),
				valid         = true;

			$errorMessage.addClass('hide');
			$('.has-error').removeClass('has-error');
			$inputs.each(function(i, el) {
				var $input = $(el);
				if ($input.val() === '') {
					$input.parent().addClass('has-error');
					$errorMessage.removeClass('hide');
					e.preventDefault(); // cancel on first error
				}
			});
		});
	});
	</script>
@stop