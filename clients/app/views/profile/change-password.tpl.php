<?php include (DIR_CLIENTS.'app/views/common/header.tpl.php'); ?>
<div class="row">
	<div class="col-md-4"></div>
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-head">
				<div class="panel-title">
					<i class="icon-key panel-head-icon"></i>
					<span class="panel-title-text"><?php echo $lang['common']['text_change_password']; ?></span>
				</div>
				<div class="panel-action"></div>
			</div>
			<form action="<?php echo $action; ?>" method="post">
				<div class="panel-body">
					<div class="form-group">
						<label for="col-form-label"><?php echo $lang['common']['text_current_password']; ?></label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="icon-key"></i></span>
							</div>
							<input type="password" class="form-control" name="profile[old-password]" pattern=".{6,}" placeholder="***********" required>
						</div>
					</div>
					<div class="form-group">
						<label for="col-form-label"><?php echo $lang['common']['text_new_password']; ?></label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="icon-key"></i></span>
							</div>
							<input type="password" class="form-control" name="profile[new-password]" pattern=".{6,}" placeholder="***********" required>
						</div>
					</div>
					<div class="form-group">
						<label for="col-form-label"><?php echo $lang['common']['text_confirm_password']; ?></label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="icon-key"></i></span>
							</div>
							<input type="password" class="form-control" name="profile[confirm-password]" pattern=".{6,}" placeholder="***********" required>
						</div>
					</div>
					<input type="hidden" name="_token" value="<?php echo $token; ?>">
					<input type="hidden" name="profile[id]" value="<?php echo $user['id']; ?>">
					<input type="hidden" name="profile[email]" value="<?php echo $user['email']; ?>">
				</div>
				<div class="panel-footer text-center">
					<button type="submit" class="btn btn-info" name="submit"><?php echo $lang['common']['text_save']; ?></button>
				</div>

			</form>
		</div>
	</div>
	<div class="col-md-4"></div>
</div>	


<!-- Footer -->
<?php include (DIR_CLIENTS.'app/views/common/footer.tpl.php'); ?>