<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Payment</title>
	<meta name="Description" content="">
	<link rel="icon" type="image/x-icon" href="public/uploads/favicon-32x32.png" />
	<link rel="stylesheet" href="public/font-awesome/css/font-awesome.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Dosis:500,600" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500" rel="stylesheet">
	<link rel="stylesheet" href="public/css/bootstrap.min.css">
	<link rel="stylesheet" href="public/css/material.min.css" />
	<link rel="stylesheet" href="public/css/mdl-selectfield.min.css">
	<link rel="stylesheet" href="public/css/jquery-ui.min.css" />
	<link rel="stylesheet" href="public/css/owl.carousel.min.css" />
	<link rel="stylesheet" href="public/css/owl.theme.default.css" />
	<link rel="stylesheet" href="public/css/animate.min.css" />
	<link rel="stylesheet" href="public/css/magnific-popup.css" />
	<link rel="stylesheet" href="public/css/flexslider.css" />
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

	.panel-body a {
		margin: 10px;
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
	<div class="container-fluid" style="max-width: 800px;">
		<div class="panel panel-default mt-4"  style="padding: 40px;">
			<div class="panel-head">
				<div class="panel-title text-center">
					<h6 class="panel-title-text"><?php echo $lang['payments']['text_success_message']; ?></h6>
				</div>
			</div>
			<div class="panel-wrapper">
				<div class="panel-body text-center">
					<div class="text-center">
						<p class="font-18 "><?php echo $lang['payments']['text_transaction_id'].' - '.$txn_id; ?></p>
						<div class="pb-4">
							<a href="<?php echo URL_CLIENTS.DIR_ROUTE.'dashboard'; ?>" class="btn btn-default"><?php echo $lang['common']['text_dashboard']; ?></a>
							<a href="<?php echo URL_CLIENTS.DIR_ROUTE.'invoices'; ?>" class="btn btn-default"><?php echo $lang['payments']['text_my_invoices']; ?></a>
						</div>
						<p><?php echo $lang['payments']['text_loyal_customer']; ?></p>
					</div>
				</div>
			</div>
		</div>
	</div>
	
</body>
</html>