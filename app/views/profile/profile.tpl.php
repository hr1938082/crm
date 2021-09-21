<?php include (DIR.'app/views/common/header.tpl.php'); ?>
<!-- Profile page start -->
<div class="row">
	<form class="col-sm-6" action="index.php?route=profile/action" method="post">
		<div class="panel panel-default">
			<div class="panel-head">
				<div class="panel-title">
					<i class="icon-user panel-head-icon"></i>
					<span class="panel-title-text"><?php echo $lang['common']['text_basic_info']; ?></span>
				</div>
			</div>
			<div class="panel-wrapper">
				<div class="panel-body">
					<input type="hidden" name="_token" value="<?php echo $token; ?>">
					<input type="hidden" value="<?php echo $result['user_id']; ?>" name="id" >
					<div class="form-group">
						<label class="col-form-label"><?php echo $lang['common']['text_username']; ?></label>
						<input type="text" class="form-control" name="username" value="<?php echo $result['user_name'];?>" placeholder="<?php echo $lang['common']['text_username']; ?>" required>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="col-form-label"><?php echo $lang['common']['text_first_name']; ?></label>
							<input type="text" class="form-control" name="firstname" value="<?php echo $result['firstname'];?>" placeholder="<?php echo $lang['common']['text_first_name']; ?>">
						</div>
						<div class="col-sm-6 form-group">
							<label class="col-form-label"><?php echo $lang['common']['text_last_name']; ?></label>
							<input type="text" class="form-control" name="lastname" value="<?php echo $result['lastname'];?>" placeholder="<?php echo $lang['common']['text_last_name']; ?>">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="col-form-label"><?php echo $lang['common']['text_email_address']; ?></label>
							<input type="text" class="form-control" name="email" value="<?php echo $result['email'];?>" placeholder="<?php echo $lang['common']['text_email_address']; ?>" readonly >
						</div>
						<div class="col-sm-6">
							<label class="col-form-label"><?php echo $lang['common']['text_mobile_number']; ?></label>
							<input type="number" class="form-control" name="mobile" value="<?php echo $result['mobile'];?>"  pattern=".{6,}" placeholder="<?php echo $lang['common']['text_mobile_number']; ?>">
						</div>
					</div>
				</div>
			</div>
			<div class="panel-footer text-center">
				<button type="submit" name="submit" class="btn btn-info"><?php echo $lang['common']['text_save']; ?></button>
			</div>
		</div>
	</form>
	<form class="col-sm-6" action="index.php?route=profile/password" method="post">
		<div class="panel panel-default">
			<div class="panel-head">
				<div class="panel-title">
					<i class="icon-key panel-head-icon"></i>
					<span class="panel-title-text"><?php echo $lang['common']['text_change_password']; ?></span>
				</div>
			</div>
			<div class="panel-wrapper">
				<div class="panel-body">
					<input type="hidden" name="_token" value="<?php echo $token; ?>">
					<input type="hidden" value="<?php echo $result['user_id']; ?>" name="id" >
					<div class="form-group">
						<label class="col-form-label"><?php echo $lang['common']['text_current_password']; ?></label>
						<input type="password" class="form-control" name="old-password" pattern=".{6,}" title="Minimum 6 word required!" placeholder="**********" required>
					</div>
					<div class="form-group">
						<label class="col-form-label"><?php echo $lang['common']['text_password']; ?></label>
						<input type="password" class="form-control" name="new-password" pattern=".{6,}" title="Minimum 6 word required!" placeholder="**********" required>
					</div>
					<div class="form-group">
						<label><?php echo $lang['common']['text_confirm_password']; ?></label>
						<input type="password" class="form-control" name="confirm-password" title="Minimum 6 word required!" pattern=".{6,}" placeholder="**********" required>
					</div>
				</div>
				<div class="panel-footer text-center">
					<button type="submit" name="submit" class="btn btn-info"><?php echo $lang['common']['text_save']; ?></button>
				</div>
			</div>
		</div>
	</form>
</div>

<!-- Footer -->
<?php include (DIR.'app/views/common/footer.tpl.php'); ?>