<?php include (DIR.'app/views/common/header.tpl.php'); ?>
<script>
	$('#user').show();
	$('#user-li').addClass('active');
</script>
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
	<div class="panel panel-default">
		<input type="hidden" name="_token" value="<?php echo $token; ?>">
		<div class="panel-head">
			<div class="panel-title">
				<i class="icon-user panel-head-icon"></i>
				<span class="panel-title-text"><?php echo $page_title; ?></span>
			</div>
			<div class="panel-action">
				<button type="submit" class="btn btn-primary btn-gradient btn-icon" name="submit" data-toggle="tooltip" title="<?php echo $lang['common']['text_save']; ?>"><i class="far fa-save"></i></button>
				<a href="<?php echo URL.DIR_ROUTE . 'user'; ?>" class="btn btn-white btn-icon" data-toggle="tooltip" title="<?php echo $lang['common']['text_back_to_list']; ?>"><i class="fa fa-reply"></i></a>
			</div>  
		</div>
		<div class="panel-wrapper p-3">
			<div class="panel-body">
				<div class="row">
					<div class="col-sm-3">
						<div class="form-group">
							<label class="col-form-label"><?php echo $lang['users']['text_username']; ?></label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="icon-user"></i></span>
								</div>
								<input type="text" name="user[username]" class="form-control" value="<?php echo $result['user_name'];?>" placeholder="<?php echo $lang['users']['text_username']; ?>" required>
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							<label class="col-form-label"><?php echo $lang['users']['text_user_role']; ?></label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="icon-people"></i></span>
								</div>
								<select class="custom-select" name="user[role]" required>
									<option value=""><?php echo $lang['users']['text_user_role']; ?></option>
									<?php if (!empty($role)) { foreach ($role as $key => $value) { ?>
									<option value="<?php echo $value['id']; ?>" <?php if ($result['user_role'] == $value['id']) { echo "selected"; } ?>><?php echo $value['name']; ?></option>
									<?php } } ?>
								</select>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label class="col-form-label"><?php echo $lang['common']['text_email_address']; ?></label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="icon-envelope"></i></span>
								</div>
								<input type="email" name="user[email]" class="form-control" value="<?php echo $result['email'];?>" placeholder="<?php echo $lang['common']['text_email_address']; ?>" required>
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							<label class="col-form-label"><?php echo $lang['common']['text_first_name']; ?></label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="icon-user"></i></span>
								</div>
								<input type="text" name="user[firstname]" class="form-control" value="<?php echo $result['firstname'];?>" placeholder="<?php echo $lang['common']['text_first_name']; ?>" required>
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							<label class="col-form-label"><?php echo $lang['common']['text_last_name']; ?></label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="icon-user"></i></span>
								</div>
								<input type="text" name="user[lastname]" class="form-control" value="<?php echo $result['lastname'];?>" placeholder="<?php echo $lang['common']['text_last_name']; ?>" required>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label class="col-form-label"><?php echo $lang['common']['text_mobile_number']; ?></label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="icon-phone"></i></span>
								</div>
								<input type="number" name="user[mobile]" class="form-control" value="<?php echo $result['mobile'];?>" placeholder="<?php echo $lang['common']['text_mobile_number']; ?>" required>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label class="col-form-label"><?php echo $lang['common']['text_status']; ?></label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="icon-check"></i></span>
								</div>
								<select class="custom-select mb-2 mr-sm-2 mb-sm-0" name="user[status]" required>
									<option value="1" <?php if ($result['status'] == "1") { echo "selected"; } ?>><?php echo $lang['users']['text_active']; ?></option>
									<option value="0" <?php if ($result['status'] == "0") { echo "selected"; } ?>><?php echo $lang['users']['text_inactive']; ?></option>
								</select>
							</div>
						</div>
					</div>
					<div class="col-12">
						<div class="br-bottom-1x mt-3 mb-4"></div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label class="col-form-label"><?php echo $lang['users']['text_date_of_birth']; ?></label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="icon-calendar"></i></span>
								</div>
								<input type="text" name="user[meta][dob]" class="form-control date" value="<?php echo $meta['dob']; ?>" placeholder="<?php echo $lang['users']['text_date_of_birth']; ?>">
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label class="col-form-label"><?php echo $lang['users']['text_address_line_1']; ?></label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="icon-direction"></i></span>
								</div>
								<input type="text" name="user[meta][address1]" class="form-control" value="<?php echo $meta['address1']; ?>" placeholder="<?php echo $lang['users']['text_address_line_1']; ?>">
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label class="col-form-label"><?php echo $lang['users']['text_address_line_2']; ?></label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="icon-directions"></i></span>
								</div>
								<input type="text" name="user[meta][address2]" class="form-control" value="<?php echo $meta['address2']; ?>" placeholder="<?php echo $lang['users']['text_address_line_2']; ?>">
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							<label class="col-form-label"><?php echo $lang['users']['text_area_or_city']; ?></label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="icon-location-pin"></i></span>
								</div>
								<input type="text" name="user[meta][city]" class="form-control" value="<?php echo $meta['city']; ?>" placeholder="<?php echo $lang['users']['text_area_or_city']; ?>">
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							<label class="col-form-label"><?php echo $lang['users']['text_country']; ?></label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="icon-globe"></i></span>
								</div>
								<input type="text" name="user[meta][country]" class="form-control" value="<?php echo $meta['country']; ?>" placeholder="<?php echo $lang['users']['text_country']; ?>">
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label class="col-form-label"><?php echo $lang['users']['text_pincode']; ?></label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="icon-map"></i></span>
								</div>
								<input type="text" name="user[meta][pin]" class="form-control" value="<?php echo $meta['pin']; ?>" placeholder="<?php echo $lang['users']['text_pincode']; ?>">
							</div>
						</div>
					</div>
				</div>
			</div>
			<input type="hidden" name="id" value="<?php echo $result['user_id']; ?>">
		</div>
		<div class="panel-footer text-center">
			<button type="submit" name="submit" class="btn btn-primary btn-gradient btn-pill"><?php echo $lang['common']['text_save']; ?></button>
		</div>
	</div>
</form>


<!-- Footer -->
<?php include (DIR.'app/views/common/footer.tpl.php'); ?>