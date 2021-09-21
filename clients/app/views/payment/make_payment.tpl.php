<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Payment</title>
	<meta name="Description" content="">
	<link rel="icon" type="image/x-icon" href="public/uploads/favicon.png" />
	<link rel="stylesheet" href="public/font-awesome/css/font-awesome.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Dosis:500,600" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500" rel="stylesheet">
	<link rel="stylesheet" href="public/css/bootstrap.min.css">
	<link rel="stylesheet" href="public/css/style.css">
	<style> 

		.wrapper {
			width: 100%;
			height: 100%;
			margin: 0 auto;
			padding: 40px 0;
			background: #ccc;
		}

		.panel {
			max-width: 900px;
			padding: 40px; 
			margin: 40px auto;
		}

		.panel-title-text {
			font-size: 24px;
			color: #555;
		}
		.loading-container {
			height: 100px;
		}
		.loader,
		.loader:before,
		.loader:after {
			background: #00c292;
			-webkit-animation: load1 1s infinite ease-in-out;
			animation: load1 1s infinite ease-in-out;
			width: 1em;
			height: 4em;
		}
		.loader {
			color: #00c292 ;
			max-height: 80px;
			height: 80px;
			margin: 40px auto;
			position: relative;
			font-size: 11px;
			-webkit-transform: translateZ(0);
			-ms-transform: translateZ(0);
			transform: translateZ(0);
			-webkit-animation-delay: -0.16s;
			animation-delay: -0.16s;
		}
		.loader:before,
		.loader:after {
			position: absolute;
			top: 0;
			content: '';
		}
		.loader:before {
			left: -1.5em;
			-webkit-animation-delay: -0.32s;
			animation-delay: -0.32s;
		}
		.loader:after {
			left: 1.5em;
		}
		@-webkit-keyframes load1 {
			0%,
			80%,
			100% {
				box-shadow: 0 0;
				height: 4em;
			}
			40% {
				box-shadow: 0 -2em;
				height: 5em;
			}
		}
		@keyframes load1 {
			0%,
			80%,
			100% {
				box-shadow: 0 0;
				height: 4em;
			}
			40% {
				box-shadow: 0 -2em;
				height: 5em;
			}
	}
</style>
</head>
<body>
	
	<div class="wrapper">
		<div class="panel panel-default mt-4">
			<div class="panel-head">
				<div class="panel-title text-center">
					<span class="panel-title-text"><?php echo $lang['payments']['text_redirect_message']; ?></span>
				</div>
			</div>
			<div class="panel-wrapper">
				<div class="panel-body">
					<div class="loading-container">	
						<div class="loader"></div>
					</div>
					<div class="font-18 text-center">
						<p><?php echo $lang['payments']['text_amount_paying'].' - '.$result['abbr'].' '.$result['due']; ?></p>
					</div>
					<div class="font-14 text-center">
						<p><?php echo $lang['payments']['text_loyal_customer']; ?></p>
					</div>
					<form id="formSubmit" action="<?php echo $paypalURL; ?>" method="post">
						<input type="hidden" name="cmd" value="_xclick">
						<input type="hidden" name="upload" value="1">
						<input type="hidden" name="business" value="<?php echo $paypalID; ?>">
						<input type="hidden" name="item_name" value="INV-<?php echo str_pad($result['id'], 4, '0', STR_PAD_LEFT); ?>">
						<input type="hidden" name="item_number" value="<?php echo $result['id']; ?>">
						<input type="hidden" name="amount" value="<?php echo $result['due']; ?>">
						<input type="hidden" name="quantity" value="1">
						<input type="hidden" name="weight" value="0">
						<input type="hidden" name="currency_code" value="<?php echo $result['currency']; ?>">
						<input type="hidden" name="first_name" value="">
						<input type="hidden" name="last_name" value="">
						<input type="hidden" name="email" value="<?php echo $result['email']; ?>">
						<!-- <input type="hidden" name="invoice" value="<?php echo $result['id'] ?>"> -->
						<input type="hidden" name="lc" value="en-gb">
						<input type="hidden" name="rm" value="2">
						<input type="hidden" name="charset" value="utf-8">
						<input type="hidden" name="return" value="<?php echo $success; ?>">
						<input type="hidden" name="notify_url" value="<?php echo $success; ?>">
						<input type="hidden" name="cancel_return" value="<?php echo $cancel; ?>">
						<input type="hidden" name="bn" value="Klinikal_2.0">
						<input type="hidden" name="custom" value="<?php echo $token; ?>">
						<div class="buttons" style="display: none">
							<div class="text-center">
								<input type="submit" value="Confirm Order" class="btn btn-primary">
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	
	
	<!-- Included Scripts -->
	<script src="public/js/jquery-2.1.4.min.js"></script>
	<script src="public/js/bootstrap.min.js"></script>

	<script type="text/javascript">
		document.getElementById('formSubmit').submit();
	</script>
</body>
</html>