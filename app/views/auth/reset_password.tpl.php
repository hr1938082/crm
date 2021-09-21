<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $info['name'].' | '.$lang['login']['text_reset_password']; ?></title>
	<link rel="icon" type="image/x-icon" href="public/images/favicon.png">
	<link href="https://fonts.googleapis.com/css?family=Dosis:500,600" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500" rel="stylesheet">
	<link rel="stylesheet" href="public/css/style.css" />
	<script src="public/js/jquery-2.1.4.min.js"></script>
	<script type="text/javascript" src="public/js/popper.min.js"></script>
	<script type="text/javascript" src="public/js/bootstrap.min.js"></script>
	<script src="public/js/custom.js"></script>
</head>
<body>
	<div class="lgn-background">
		<div class="lgn-wrapper">
			<div class="lgn-logo text-center">
				<a><img src="public/images/logo-color.png" alt=""></a>
			</div>
			<div id="login-form" class="lgn-form ">
				<form class="form-vertical" action="<?php echo $action ?>" method="post">
					<?php if(!empty($success)) { ?>
					<div class="alert alert-success alert-dismissable">
						<?php echo $success ?>
						<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
					</div>
					<?php } if(!empty($error)) { ?>
					<div class="alert alert-danger alert-dismissable">
						<?php echo $error ?>
						<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
					</div>
					<?php } ?>
					<input type="hidden" name="_token" value="<?php echo $token; ?>">
					<input type="hidden" name="mail" value="<?php echo $mail; ?>">
					<input type="hidden" name="hash" value="<?php echo $hash; ?>">
					<div class="lgn-input form-group">
						<label class="control-label col-sm-12"><?php echo $lang['common']['text_password']; ?></label>
						<div class="col-sm-12">
							<input type="password" name="password" id="lgn-pass" class="form-control" placeholder="<?php echo $lang['common']['text_password']; ?>" autocomplete="off">
						</div>	
					</div>
					<div class="lgn-input form-group">
						<label class="control-label col-sm-12"><?php echo $lang['common']['text_confirm_password']; ?></label>
						<div class="col-sm-12">
							<input type="password" name="confirmpassword" id="lgn-cnfrmpass" class="form-control" placeholder="<?php echo $lang['common']['text_confirm_password']; ?>" autocomplete="off">
						</div>	
					</div>
					<div class="lgn-input form-group">
						<label class="control-label col-sm-12"><?php echo $lang['login']['text_what_is'].' '.(rand(1,10)).' '.$lang['login']['text_plus'].' '.(rand(1,20)); ?> =</label>
						<div class="col-sm-12">
							<input type="text" id="lgn-bot" class="form-control" placeholder="Answer" autocomplete="off">
						</div>
					</div>
					<div class="lgn-submit">
						<button type="submit" id="reset-submit" class="btn btn-primary btn-pill btn-lg" name="reset"><?php echo $lang['login']['text_reset']; ?></button>
					</div>
				</form>
			</div>
		</div>
	</div>

</body>
</html>


