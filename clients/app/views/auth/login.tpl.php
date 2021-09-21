<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $info['name'].' | '.$lang['login']['text_admin_login']; ?></title>
	<link rel="icon" type="image/x-icon" href="public/images/favicon.png">
	<link href="https://fonts.googleapis.com/css?family=Dosis:500,600" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500" rel="stylesheet">
	<link rel="stylesheet" href="public/font-awesome/css/font-awesome.min.css" />
	<link rel="stylesheet" href="public/css/bootstrap.min.css" />
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
				<a><img src="public/images/logo-color.png" alt="Office Manager"></a>
				<p class="lgn-type"><?php echo $lang['login']['text_client_portal']; ?></p>
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
					<div class="lgn-input form-group">
						<label class="control-label col-sm-12"><?php echo $lang['common']['text_email_address']; ?></label>
						<div class="col-sm-12">
							<input class="form-control" type="text" name="username" value="" id="lgn-mail" placeholder="<?php echo $lang['common']['text_email_address']; ?>" autocomplete="off">
						</div>
					</div>
					<div class="lgn-input form-group">
						<label class="control-label col-sm-12"><?php echo $lang['common']['text_password']; ?></label>
						<div class="col-sm-12">
							<input type="password" name="password" id="lgn-pass" value="" class="form-control" placeholder="<?php echo $lang['common']['text_password']; ?>" autocomplete="off">
						</div>	
					</div>
					<div class="lgn-input form-group">
						<label class="control-label col-sm-12"><?php echo $lang['login']['text_what_is'].' '.(rand(1,10)).' '.$lang['login']['text_plus'].' '.(rand(1,20)); ?> =</label>
						<div class="col-sm-12">
							<input type="text" id="lgn-bot" class="form-control" placeholder="Answer" autocomplete="off">
						</div>
					</div>
					<div class="lgn-forgot">
						<div class="row">
							<div class="col-sm-6">
								<a href="<?php echo URL_CLIENTS.DIR_ROUTE.'register'; ?>"><?php echo $lang['login']['text_create_account']; ?></a>
							</div>
							<div class="col-sm-6 text-right">
								<a href="<?php echo URL_CLIENTS.DIR_ROUTE.'forgot'; ?>"><?php echo $lang['login']['text_forgotten_password']; ?></a>
							</div>
						</div>

					</div>
					<div class="lgn-submit">
						<button type="submit" id="lgn-submit" class="btn btn-primary btn-pill btn-lg" name="login"><?php echo $lang['login']['text_login']; ?></button>
					</div>
				</form>
			</div>
			<div class="lgn-footer">
				<p><?php echo $lang['login']['text_are_you_admin_user']; ?></p>
				<a href="<?php echo URL.DIR_ROUTE.'login'; ?>"><?php echo $lang['login']['text_admin_login']; ?></a>
			</div>
		</div>
	</div>

	<script type="text/javascript" id="cookieinfo" src="//cookieinfoscript.com/js/cookieinfo.min.js" data-bg="#282a3c" data-fg="#FFFFFF" data-link="#F1D600" data-cookie="cllientCookieInfo" data-text-align="left" data-close-text="<?php echo $lang['login']['text_cookie_close_text']; ?>" data-message="<?php echo $lang['login']['text_cookie_message']; ?>"></script>

</body>
</html>


