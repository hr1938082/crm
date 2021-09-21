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
				<span class="panel-title-text">Cookie Setting</span>
			</div>
			<div class="panel-action">
				<button type="submit" class="btn btn-info btn-icon" name="submit" data-toggle="tooltip" title="Save Page"><i class="far fa-save"></i></button>
			</div>  
		</div>
		<div class="panel-wrapper">
			<div class="panel-body">
				<div class="form-group">
					<label class="col-form-label">Cookie Message</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="icon-check"></i></span>
						</div>
						<textarea name="" class="form-control" placeholder="Cookie Message"></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-form-label">Link Text</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="icon-check"></i></span>
						</div>
						<input type="text" placeholder="Link Text">
					</div>
				</div>
				<div class="form-group">
					<label class="col-form-label">Link URL</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="icon-check"></i></span>
						</div>
						<input type="text" placeholder="Link Text">
					</div>
				</div>
				<input type="hidden" name="name" value="<?php echo $result['name']; ?>">
			</div>
		</div>
		<div class="panel-footer text-center">
			<button type="submit" name="submit" class="btn btn-info">Save</button>
		</div>
	</div>
</form>

<!-- Footer -->
<?php include (DIR.'app/views/common/footer.tpl.php'); ?>