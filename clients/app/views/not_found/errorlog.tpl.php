<?php include (DIR_CLIENTS.'app/views/common/header.tpl.php'); ?>
<script>$('#setting').show();</script>

<div class="content">
	<div class="content-block">
		<div class="content-block-ttl">Error Log</div>
		<div class="content-block-main">
			<div class="padding-10">
				<p class="font-12">
					<?php 
					$file = fopen("error.log","r");

					while(! feof($file))
					{
						echo fgets($file). "<br />";
					}

					fclose($file); ?>
				</p>
			</div>
		</div>
	</div>
</div>


<!-- Footer -->
<?php include (DIR_CLIENTS.'app/views/common/footer.tpl.php'); ?>