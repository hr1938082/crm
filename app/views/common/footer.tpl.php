</div>
<input type="hidden" id="datatable_no_records" value="<?php echo $lang['common']['text_no_records_available'] ?>">
<input type="hidden" id="datatable_showing_page" value="<?php echo $lang['common']['text_showing_page_of'] ?>">
</div>
</div>
</div>
<!-- Set Confirmation Message on create, update and delete -->
<?php if (isset($message) && !empty($message)) { ?>
<script>
	/*Set toastr Option*/
	toastr.options = {
		"closeButton": true,
		"debug": false,
		"newestOnTop": false,
		"progressBar": false,
		"positionClass": "toast-top-center",
		"preventDuplicates": false,
		"onclick": null,
		"showDuration": "90000",
		"hideDuration": "10000",
		"timeOut": "500000",
		"extendedTimeOut": "1000",
		"showEasing": "swing",
		"hideEasing": "linear",
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"
	}
	toastr.<?php echo $message['alert']; ?>('<?php echo $message['value']; ?>', '<?php echo ucfirst($message['alert']); ?>');
</script>
<?php } ?>

</body>
</html>