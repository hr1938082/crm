<?php include (DIR.'app/views/common/header.tpl.php'); ?>
<script>
	$('#setting').show();
$('#setting-li').addClass('active');</script>
</script>
<form action="<?php echo $action; ?>" method="post">
	<input type="hidden" name="_token" value="<?php echo $token; ?>">
	<div class="panel panel-default">
		<div class="panel-head">
			<div class="panel-title">
				<i class="icon-notebook panel-head-icon"></i>
				<span class="panel-title-text"><?php echo $page_title; ?></span>
			</div>
			<div class="panel-action">
				<button type="submit" class="btn btn-primary btn-gradient btn-icon" name="submit" data-toggle="tooltip" data-placement="left" title="<?php echo $lang['common']['text_save']; ?>"><i class="far fa-save"></i></button>
			</div>  
		</div>
		<div class="panel-wrapper">
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-6">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group info-logo">
									<label class="d-block"><text>*</text><?php echo $lang['settings']['text_logo']; ?> : </label>
									<div class="image-upload" <?php if (!empty($result['logo'])) { echo " style=\"display: none\" "; }?> >
										<a class="ml-4"><?php echo $lang['common']['text_upload']; ?></a>
									</div>
									<div class="saved-picture" <?php if (empty($result['logo'])) { echo " style=\"display: none\" "; } ?> >
										<?php if (!empty($result['logo'])) { ?><img class="img-thumbnail" src="public/uploads/<?php echo $result['logo']; ?>" alt=""><?php } ?>
										<input type="hidden" name="info[logo]" value="<?php echo $result['logo']; ?>">
									</div>
									<div class="saved-picture-delete" data-toggle="tooltip" title="Remove" <?php if (empty($result['logo'])) { echo " style=\"display: none\" "; } ?>><a class="fa fa-times"></a></div>
									<div class="text-muted pt-1 pl-3"><?php echo $lang['settings']['text_size_max_height_35px']; ?></div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group info-logo">
									<label class="d-block"><text>*</text><?php echo $lang['settings']['text_favicon']; ?> : </label>
									<div class="image-upload" <?php if (!empty($result['favicon'])) { echo " style=\"display: none\" "; }?> >
										<a class="ml-3"><?php echo $lang['common']['text_upload']; ?></a>
									</div>
									<div class="saved-picture" <?php if (empty($result['favicon'])) { echo " style=\"display: none\" "; } ?> >
										<?php if (!empty($result['favicon'])) { ?><img class="img-thumbnail" src="public/uploads/<?php echo $result['favicon']; ?>" alt=""><?php } ?>
										<input type="hidden" name="info[favicon]" value="<?php echo $result['favicon']; ?>">
									</div>
									<div class="saved-picture-delete" data-toggle="tooltip" title="Remove" <?php if (empty($result['favicon'])) { echo " style=\"display: none\" "; } ?> ><a class="fa fa-times"></a></div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-form-label"><?php echo $lang['settings']['text_organization_name']; ?></label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="icon-organization"></i></span>
										</div>
										<input type="text" name="info[name]" class="form-control" value="<?php echo $result['name']; ?>" placeholder="<?php echo $lang['settings']['text_organization_name']; ?>">
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-form-label"><?php echo $lang['settings']['text_legal_organization_name']; ?></label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="icon-organization"></i></span>
										</div>
										<input type="text" name="info[legal_name]" class="form-control" value="<?php echo $result['legal_name']; ?>" placeholder="<?php echo $lang['settings']['text_legal_organization_name']; ?>">
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-form-label"><?php echo $lang['common']['text_email_address']; ?></label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="icon-envelope"></i></span>
										</div>
										<input type="text" name="info[email]" class="form-control" value="<?php echo $result['email']; ?>" placeholder="<?php echo $lang['common']['text_email_address']; ?>">
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-form-label"><?php echo $lang['settings']['text_language']; ?></label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="icon-globe"></i></span>
										</div>
										<select name="info[language]" class="custom-select">
											<option value="en-US" <?php if ($result['language'] == "en-US") { echo "selected"; } ?>>English</option>
											<option value="pt-BR" <?php if ($result['language'] == "pt-BR") { echo "selected"; } ?>>Portuguese (Brazil)</option>
											<option value="your-language" <?php if ($result['language'] == "your-language") { echo "selected"; } ?>>Your Language</option>
										</select>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-form-label"><?php echo $lang['common']['text_phone_number']; ?></label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="icon-screen-smartphone"></i></span>
										</div>
										<input type="text" name="info[phone]" class="form-control" value="<?php echo $result['phone']; ?>" placeholder="<?php echo $lang['common']['text_phone_number']; ?>">
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-form-label"><?php echo $lang['settings']['text_fax_number']; ?></label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="icon-call-in"></i></span>
										</div>
										<input type="text" name="info[fax]" class="form-control" value="<?php echo $result['fax']; ?>" placeholder="<?php echo $lang['settings']['text_fax_number']; ?>">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="col-form-label"><?php echo $lang['settings']['text_address_line_1']; ?></label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="icon-direction"></i></span>
										</div>
										<input type="text" name="info[address][address1]" class="form-control" value="<?php echo $address['address1']; ?>" placeholder="<?php echo $lang['settings']['text_address_line_1']; ?>">
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label class="col-form-label"><?php echo $lang['settings']['text_address_line_2']; ?></label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="icon-direction"></i></span>
										</div>
										<input type="text" name="info[address][address2]" class="form-control" value="<?php echo $address['address2']; ?>" placeholder="<?php echo $lang['settings']['text_address_line_2']; ?>">
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-form-label"><?php echo $lang['settings']['text_area_or_city']; ?></label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="icon-location-pin"></i></span>
										</div>
										<input type="text" name="info[address][city]" class="form-control" value="<?php echo $address['city']; ?>" placeholder="<?php echo $lang['settings']['text_area_or_city']; ?>">
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-form-label"><?php echo $lang['settings']['text_country']; ?></label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="icon-location-pin"></i></span>
										</div>
										<input type="text" name="info[address][country]" class="form-control" value="<?php echo $address['country']; ?>" placeholder="<?php echo $lang['settings']['text_country']; ?>">
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-form-label"><?php echo $lang['settings']['text_pincode']; ?></label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="fa fa-map-pin"></i></span>
										</div>
										<input type="text" name="info[address][pincode]" class="form-control" value="<?php echo $address['pincode']; ?>" placeholder="<?php echo $lang['settings']['text_pincode']; ?>">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="br-bottom-1x mt-3 mb-4"></div>
				<div class="row">
					<div class="col-12">
						<label class="col-form-label font-20">Invoice Settings</label>
					</div>
					<div class="col-lg-6">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label><?php echo $lang['settings']['text_account_number']; ?></label>
									<input type="text" class="form-control" name="info[invoice][accountnumber]" value="<?php echo $invoice['accountnumber'] ?>" placeholder="<?php echo $lang['settings']['text_account_number']; ?>">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label><?php echo $lang['settings']['text_account_name']; ?></label>
									<input type="text" class="form-control" name="info[invoice][accountname]" value="<?php echo $invoice['accountname'] ?>" placeholder="<?php echo $lang['settings']['text_account_name']; ?>">
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label><?php echo $lang['settings']['text_bank_name']; ?></label>
									<input type="text" class="form-control" name="info[invoice][bankname]" value="<?php echo $invoice['bankname'] ?>" placeholder="<?php echo $lang['settings']['text_bank_name']; ?>">
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label><?php echo $lang['settings']['text_bank_details']; ?></label>
									<textarea class="form-control" name="info[invoice][bankdetails]" placeholder="<?php echo $lang['settings']['text_bank_details']; ?>"><?php echo $invoice['bankdetails'] ?></textarea>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group invoice-template-img">
									<label><?php echo $lang['settings']['text_select_invoice_template']; ?></label>
									<div>
										<div class="custom-control custom-radio custom-radio-1 d-inline-block">
											<input type="radio" name="info[invoice][template]" class="custom-control-input" value="1" id="invoice-template-1" <?php if ($invoice['template'] == '1') { echo "checked"; } ?>>
											<label class="custom-control-label" for="invoice-template-1"><img src="public/images/invoice-1.png" alt="Invoice Template 1"></label>
										</div>
										<div class="custom-control custom-radio custom-radio-1 d-inline-block">
											<input type="radio" name="info[invoice][template]" class="custom-control-input" value="2" id="invoice-template-2" <?php if ($invoice['template'] == '2') { echo "checked"; } ?>>
											<label class="custom-control-label" for="invoice-template-2"><img src="public/images/invoice-2.png" alt="Invoice Template 1"></label>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group info-logo">
							<label class="d-block"><?php echo $lang['settings']['text_authorised_sign']; ?></label>
							<div class="image-upload" <?php if (!empty($result['signature'])) { echo " style=\"display: none\" "; }?> >
								<a class="ml-4"><?php echo $lang['common']['text_upload']; ?></a>
							</div>
							<div class="saved-picture" <?php if (empty($result['signature'])) { echo " style=\"display: none\" "; } ?> >
								<?php if (!empty($result['signature'])) { ?><img class="img-thumbnail" src="public/uploads/<?php echo $result['signature']; ?>" alt=""><?php } ?>
								<input type="hidden" name="info[signature]" value="<?php echo $result['signature']; ?>">
							</div>
							<div class="saved-picture-delete" data-toggle="tooltip" title="Remove" <?php if (empty($result['signature'])) { echo " style=\"display: none\" "; } ?>><a class="fa fa-times"></a></div>
						</div>
						<div class="form-group">
							<label><?php echo $lang['settings']['text_predefined_customer_note']; ?></label>
							<textarea name="info[invoice][customernote]" class="form-control" placeholder="<?php echo $lang['settings']['text_predefined_customer_note']; ?>"><?php echo $invoice['customernote'] ?></textarea>
						</div>
						<div class="form-group">
							<label><?php echo $lang['settings']['text_predefined_terms_conditions']; ?></label>
							<textarea name="info[invoice][tc]" class="form-control" placeholder="<?php echo $lang['settings']['text_predefined_terms_conditions']; ?>"><?php echo $invoice['tc'] ?></textarea>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="panel-footer text-center">
			<button type="submit" class="btn btn-primary btn-gradient btn-pill" name="submit"><?php echo $lang['common']['text_save']; ?></button>
		</div>
	</div>
</form>

<!-- Footer -->
<?php include (DIR.'app/views/common/footer.tpl.php'); ?>