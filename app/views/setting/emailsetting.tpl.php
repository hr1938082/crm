<?php include (DIR.'app/views/common/header.tpl.php'); ?>
<script>
	$('#setting').show();
$('#setting-li').addClass('active');</script>
</script>

<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
	<input type="hidden" name="_token" value="<?php echo $token; ?>">
	<div class="panel panel-default">
		<div class="panel-head">
			<div class="panel-title">
				<i class="icon-user panel-head-icon"></i>
				<span class="panel-title-text"><?php echo $lang['common']['text_email_settings']; ?></span>
			</div>
			<div class="panel-action">
				<button type="submit" class="btn btn-primary btn-gradient btn-icon" name="submit" data-toggle="tooltip" title="Save Page"><i class="far fa-save"></i></button>
			</div>  
		</div>
		<div class="panel-wrapper">
			<div class="panel-body">
				<div class="p-3">
					<div class="form-group">
						<label class="col-form-label"><text>*</text><?php echo $lang['settings']['text_default']; ?> : </label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="icon-check"></i></span>
							</div>
							<select name="status" class="custom-select">
								<option value="0" <?php if($result['status'] == '0') { echo "selected";} ?> ><?php echo $lang['settings']['text_default_PHP_mail']; ?></option>
								<option value="1" <?php if($result['status'] == '1') { echo "selected";} ?> ><?php echo $lang['settings']['text_SMTP_mail']; ?></option>
							</select>
						</div>
					</div>
					<div id="smtp-mail" class="row" <?php if ($result['status'] == "0") { echo 'style="display: none;"'; } ?>>
						<div class="col-12">
							<div class="br-bottom-1x mt-3 mb-4"></div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-form-label"><?php echo $lang['settings']['text_from_email_address']; ?></label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="icon-envelope"></i></span>
									</div>
									<input type="text" name="smtp[fromemail]" class="form-control" value="<?php echo $result['data']['fromemail'] ?>" placeholder="<?php echo $lang['settings']['text_from_email_address']; ?>">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-form-label"><?php echo $lang['settings']['text_from_name']; ?></label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="icon-envelope"></i></span>
									</div>
									<input type="text" name="smtp[fromname]" class="form-control" value="<?php echo $result['data']['fromname'] ?>" placeholder="<?php echo $lang['settings']['text_from_name']; ?>">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-form-label"><?php echo $lang['settings']['text_reply_to_email_address']; ?></label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="icon-envelope"></i></span>
									</div>
									<input type="text" name="smtp[reply]" class="form-control" value="<?php echo $result['data']['reply'] ?>" placeholder="<?php echo $lang['settings']['text_reply_to_email_address']; ?>">
								</div>
								<div class="form-text text-muted"><?php echo $lang['settings']['text_reply_optional']; ?></div>
							</div>
						</div>
						<div class="col-md-6"></div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-form-label"><?php echo $lang['settings']['text_SMTP_host']; ?></label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="icon-envelope"></i></span>
									</div>
									<input type="text" name="smtp[host]" class="form-control" value="<?php echo $result['data']['host'] ?>" placeholder="<?php echo $lang['settings']['text_SMTP_host']; ?>">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-form-label"><?php echo $lang['settings']['text_SMTP_port']; ?>	</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="icon-envelope"></i></span>
									</div>
									<input type="text" name="smtp[port]" class="form-control" value="<?php echo $result['data']['port'] ?>" placeholder="<?php echo $lang['settings']['text_SMTP_port']; ?>">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-form-label"><?php echo $lang['settings']['text_SMTP_username']; ?>	</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="icon-envelope"></i></span>
									</div>
									<input type="text" name="smtp[username]" class="form-control" value="<?php echo $result['data']['username'] ?>" placeholder="<?php echo $lang['settings']['text_SMTP_username']; ?>">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-form-label"><?php echo $lang['settings']['text_SMTP_password']; ?>	</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="icon-envelope"></i></span>
									</div>
									<input type="text" name="smtp[password]" class="form-control" value="<?php echo $result['data']['password'] ?>" placeholder="<?php echo $lang['settings']['text_SMTP_password']; ?>">
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label class="col-form-label"><?php echo $lang['settings']['text_type_of_encryption']; ?></label>
								<div class="">
									<div class="custom-control custom-radio custom-checkbox-1 d-inline-block mr-2">
										<input type="radio" class="custom-control-input" name="smtp[encryption]" value="none" id="encryption-none" <?php if ($result['data']['encryption'] == "none") { echo "checked"; } ?>>
										<label class="custom-control-label" for="encryption-none">none</label>
									</div>
									<div class="custom-control custom-radio custom-checkbox-1 d-inline-block mr-2">
										<input type="radio" class="custom-control-input" name="smtp[encryption]" value="ssl" id="encryption-sss" <?php if ($result['data']['encryption'] == "ssl") { echo "checked"; } ?>>
										<label class="custom-control-label" for="encryption-sss">SSL</label>
									</div>
									<div class="custom-control custom-radio custom-checkbox-1 d-inline-block">
										<input type="radio" class="custom-control-input" name="smtp[encryption]" value="tls" id="encryption-tls" <?php if ($result['data']['encryption'] == "tls") { echo "checked"; } ?>>
										<label class="custom-control-label" for="encryption-tls">TLS</label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-form-label"><?php echo $lang['settings']['text_SMTP_authentication']; ?></label>
								<div class="">
									<div class="custom-control custom-radio d-inline-block mr-2">
										<input type="radio" class="custom-control-input" name="smtp[authentication]" value="0" id="authentication-no" <?php if ($result['data']['authentication'] == "0") { echo "checked"; } ?>>
										<label class="custom-control-label" for="authentication-no"><?php echo $lang['settings']['text_no']; ?></label>
									</div>
									<div class="custom-control custom-radio d-inline-block">
										<input type="radio" class="custom-control-input" name="smtp[authentication]" value="1" id="authentication-yes" <?php if ($result['data']['authentication'] == "1") { echo "checked"; } ?>>
										<label class="custom-control-label" for="authentication-yes"><?php echo $lang['settings']['text_yes']; ?></label>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<input type="hidden" name="name" value="<?php echo $result['name']; ?>">
			</div>
		</div>
		<div class="panel-footer text-center">
			<button type="submit" name="submit" class="btn btn-primary btn-gradient btn-pill">Save</button>
		</div>
	</div>
</form>
<script>
	$('body').on('change', 'select[name="status"]', function () {
		var ele = $(this);
		if (ele.val() == "1") {
			$('#smtp-mail').show();
		} else {
			$('#smtp-mail').hide();
		}
	})
</script>
<!-- Footer -->
<?php include (DIR.'app/views/common/footer.tpl.php'); ?>