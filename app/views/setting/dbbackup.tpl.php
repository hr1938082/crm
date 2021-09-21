<?php include (DIR.'app/views/common/header.tpl.php'); ?>
<script>$('#utilities').show();$('#utilities-li').addClass('active');</script>
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
	<div class="panel panel-default">
		<div class="panel-head">
			<div class="panel-title">
				<i class="icon-cloud-download panel-head-icon"></i>
				<span class="panel-title-text"><?php echo $lang['common']['text_database_backup']; ?></span>
			</div>
		</div>
		<div class="panel-body">
			<a href="<?php echo URL.DIR_ROUTE.'dbbackup/download'; ?>" class="btn btn-primary btn-outline btn-pill"><?php echo $lang['common']['text_download']; ?></a>
		</div>
	</div>
</form>
<!-- Footer -->
<?php include (DIR.'app/views/common/footer.tpl.php'); ?>