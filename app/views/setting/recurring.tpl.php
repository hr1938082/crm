<?php include (DIR.'app/views/common/header.tpl.php'); ?>
<script>
	$('#setting').show();
	$('#setting-li').addClass('active');</script>
</script>

<div class="panel panel-default">
	<div class="panel-head">
		<div class="panel-title">
			<i class="icon-user panel-head-icon"></i>
			<span class="panel-title-text">Automation Setting</span>
		</div>
	</div>
	<div class="panel-wrapper">
		<div class="panel-body">
			<form action="<?php echo $action ?>" method="post">
				<input type="hidden" name="_token" value="<?php echo $token; ?>">
				<input type="hidden" name="name" value="recurring">
				<div class="form-group row align-items-start">
					<label class="col-form-label col-md-2">Security Token</label>
					<div class="col-md-10">
						<input type="text" name="security_token" class="form-control" value="<?php echo $result['data']; ?>" disabled>
						<button type="submit" name="submit" class="btn btn-info btn-sm mt-3">Re Generate Token</button>
					</div>
				</div>
			</form>
			<div class="br-bottom-1x mt-3 mb-4"></div>
			<h5 class="font-20">To enable the automation features to run, make sure you set up a cron job to run once per day. Also check your servcer time before run. (e.g. 8AM).</h5>
			<div class="form-group">
				<label class="col-form-label">Create Cron Job using following Command</label>
				<input type="text" class="form-control" value="/usr/bin/php <?php echo DIR.'index.php route=recurringjob code='.$result['data']; ?>" readonly>
			</div>
		</div>
	</div>
</div>

<!-- Footer -->
<?php include (DIR.'app/views/common/footer.tpl.php'); ?>