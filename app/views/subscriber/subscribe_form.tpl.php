<?php include (DIR.'app/views/common/header.tpl.php'); ?>
<script>
	$('#user').show();
	$('#user-li').addClass('active');</script>
</script>

<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
	<input type="hidden" name="_token" value="<?php echo $token; ?>">
	<div class="panel panel-default">
		<div class="panel-head">
			<div class="panel-title">
				<i class="icon-user panel-head-icon"></i>
				<span class="panel-title-text"><?php echo $page_title; ?></span>
			</div>
			<div class="panel-action">
				<button type="submit" class="btn btn-primary btn-gradient btn-icon" name="submit" data-toggle="tooltip" title="<?php echo $lang['common']['text_save']; ?>"><i class="far fa-save"></i></button>
				<a href="<?php echo URL.DIR_ROUTE.'subscriber'; ?>" class="btn btn-white btn-icon" data-toggle="tooltip" title="<?php echo $lang['common']['text_back_to_list']; ?>"><i class="fa fa-reply"></i></a>
			</div>  
		</div>
		<div class="panel-wrapper p-3">
			<div class="panel-body">
				<div class="form-group">
					<label class="col-form-label"><?php echo $lang['common']['text_email_address']; ?></label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="icon-envelope"></i></span>
						</div>
						<input type="text" name="email" class="form-control" value="<?php echo $result['email'];?>" placeholder="<?php echo $lang['common']['text_email_address']; ?>">
					</div>
				</div>
				<?php if (!empty($result['id'])) { ?>
				<div class="form-group">
					<label class="col-form-label"><text>*</text><?php echo $lang['common']['text_status']; ?> : </label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="icon-check"></i></span>
						</div>
						<select name="status" id="" class="custom-select">
							<option value="0" <?php if($result['status'] == '0') { echo "selected";} ?> ><?php echo $lang['users']['text_inactive']; ?></option>
							<option value="1" <?php if($result['status'] == '1') { echo "selected";} ?> ><?php echo $lang['users']['text_active']; ?></option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-form-label"><?php echo $lang['common']['text_created_date']; ?></label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="icon-calendar"></i></span>
						</div>
						<input type="text" class="form-control" value="<?php echo date_format(date_create($result['date_of_joining']), "d-m-Y")?>" placeholder="<?php echo $lang['common']['text_created_date']; ?>" readonly>
					</div>
				</div>
				<?php } ?>
				<input type="hidden" name="id" value="<?php echo $result['id']; ?>">
			</div>
		</div>
		<div class="panel-footer text-center">
			<button type="submit" name="submit" class="btn btn-primary btn-gradient btn-pill"><?php echo $lang['common']['text_save']; ?></button>
		</div>
	</div>
</form>

<!-- Footer -->
<?php include (DIR.'app/views/common/footer.tpl.php'); ?>