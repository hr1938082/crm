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
				<i class="icon-people panel-head-icon"></i>
				<span class="panel-title-text"><?php echo $page_title; ?></span>
			</div>
			<div class="panel-action">
				<button type="submit" class="btn btn-primary btn-gradient btn-icon" name="submit" data-toggle="tooltip" title="<?php echo $lang['common']['text_save']; ?>"><i class="far fa-save"></i></button>
				<a href="<?php echo URL.DIR_ROUTE.'role'; ?>" class="btn btn-white btn-icon" data-toggle="tooltip" title="<?php echo $lang['common']['text_back_to_list']; ?>"><i class="fa fa-reply"></i></a>
			</div>  
		</div>
		<div class="panel-wrapper p-3">
			<div class="panel-body">
				<div class="form-group">
					<label class="col-form-label"><?php echo $lang['users']['text_user_role_name']; ?></label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="icon-people"></i></span>
						</div>
						<input type="text" name="name" class="form-control" value="<?php echo $result['name']; ?>" placeholder="<?php echo $lang['users']['text_user_role_name']; ?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-form-label"><?php echo $lang['common']['text_description']; ?></label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="icon-speech"></i></span>
						</div>
						<textarea name="description" class="form-control" rows="3"><?php echo $result['description']; ?></textarea>
					</div>
				</div>
				<div class="mb-2">
					<label class="col-form-label"><?php echo $lang['users']['text_permission']; ?></label>
					<table class="table table-bordered">
						<thead class="thead-light">
							<tr>
								<th><?php echo $lang['common']['text_list']; ?></th>
								<th><?php echo $lang['common']['text_add']; ?></th>
								<th><?php echo $lang['common']['text_edit']; ?></th>
								<th><?php echo $lang['common']['text_delete']; ?></th>
								<th><?php echo $lang['common']['text_view']; ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($role as $role_key => $role_value) { ?>
							<tr>
								<?php foreach ($role_value as $sub_key => $sub_value) { ?>
								<td>
									<?php if (!empty($sub_value)) { ?>
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" name="role[]" id="<?php echo $sub_key; ?>" value="<?php echo $sub_key; ?>" <?php if($role_selected) { foreach ($role_selected as $key => $value) { if ($value == $sub_key) { echo "checked"; } } } ?> >
										<label class="custom-control-label" for="<?php echo $sub_key; ?>"><?php echo $sub_value; ?></label>
									</div>
									<?php } ?>
								</td>
								<?php } ?>
							</tr> 
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
			<input type="hidden" name="id" value="<?php echo $result['id']; ?>">
		</div>
		<div class="panel-footer text-center">
			<button type="submit" name="submit" class="btn btn-primary btn-gradient btn-pill"><?php echo $lang['common']['text_save']; ?></button>
		</div>
	</div>
</form>


<!-- Footer -->
<?php include (DIR.'app/views/common/footer.tpl.php'); ?>