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
</style>
</head>
<body>
	<div class="container-fluid" style="max-width: 800px;">
		<div class="panel panel-default mt-4"  style="padding: 40px;">
			<div class="panel-head">
				<div class="panel-title text-center">
					<span class="panel-title-text">You payment has been canceled. Please contact us for more info.</span>
				</div>
			</div>
			<div class="panel-wrapper">
				<div class="panel-body">
					<p></p>
					<div class="font-14 text-center">
						<a href="<?php echo URL_CLIENTS.DIR_ROUTE.'dashboard'; ?>" class="mdl-button mdl-js-button mdl-js-ripple-effect button button-blue button-fill-blue">Home</a>
						<a href="<?php echo URL_CLIENTS.DIR_ROUTE.'invoices'; ?>" class="mdl-button mdl-js-button mdl-js-ripple-effect button button-orange button-fill-orange">My Invoices</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	
</body>
</html>