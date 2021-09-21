<?php include (DIR_CLIENTS.'app/views/common/header.tpl.php'); ?>

<form action="<?php echo $action; ?>" method="post">
	<div class="panel panel-default">
		<div class="panel-head">
			<div class="panel-title">
				<i class="icon-user panel-head-icon"></i>
				<span class="panel-title-text"><?php echo $lang['common']['text_my_account']; ?></span>
			</div>
			<div class="panel-action"></div>
		</div>
		<div class="panel-wrapper p-3">
			<input type="hidden" name="_token" value="<?php echo $token; ?>">
			<ul class="nav nav-tabs nav-tabs-line nav-tabs-line-primary pt-3">
				<li class="nav-item">
					<a class="nav-link active" href="#basic-info" data-toggle="tab"><i class="icon-home mr-2"></i><?php echo $lang['contact']['text_basic_info']; ?></a>
				</li>
				<li class="nav-item">  
					<a class="nav-link" href="#address" data-toggle="tab"><i class="icon-location-pin mr-2"></i><?php echo $lang['common']['text_address']; ?></a>
				</li>
				<!-- <li class="nav-item">
					<a class="nav-link" href="#rights" data-toggle="tab"><i class="icon-home mr-2"></i>Your Rights</a>
				</li> -->
			</ul>
			<div class="tab-content mt-3 pl-4 pr-4">
				<div class="tab-pane active" id="basic-info">
					<div class="row align-items-center">
						<div class="col-md-2 form-group p-0">
							<label class="col-form-label"><?php echo $lang['contact']['text_primary_contact']; ?></label>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="far fa-frown"></i></span>
									</div>
									<select class="custom-select" name="contact[salutation]" required>
										<option value=""><?php echo $lang['contact']['text_salutation']; ?></option>
										<option value="<?php echo $lang['contact']['text_mr.']; ?>" <?php if ($result['salutation'] == $lang['contact']['text_mr.']) { echo "selected"; } ?> ><?php echo $lang['contact']['text_mr.']; ?></option>
										<option value="<?php echo $lang['contact']['text_mrs.']; ?>" <?php if ($result['salutation'] == $lang['contact']['text_mrs.']) { echo "selected"; } ?>><?php echo $lang['contact']['text_mrs.']; ?></option>
										<option value="<?php echo $lang['contact']['text_ms.']; ?>" <?php if ($result['salutation'] == $lang['contact']['text_ms.']) { echo "selected"; } ?>><?php echo $lang['contact']['text_ms.']; ?></option>
										<option value="<?php echo $lang['contact']['text_dr.']; ?>" <?php if ($result['salutation'] == $lang['contact']['text_dr.']) { echo "selected"; } ?>><?php echo $lang['contact']['text_dr.']; ?></option>
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-4 form-group">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="icon-user"></i></span>
								</div>
								<input type="text" class="form-control" name="contact[firstname]" value="<?php echo $result['firstname']; ?>" placeholder="<?php echo $lang['common']['text_first_name']; ?>" required>
							</div>
						</div>
						<div class="col-md-4 form-group">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="icon-user"></i></span>
								</div>
								<input type="text" class="form-control" name="contact[lastname]" value="<?php echo $result['lastname']; ?>" placeholder="<?php echo $lang['common']['text_last_name']; ?>" required>
							</div>
						</div>
					</div>
					<div class="form-group row align-items-start">
						<label class="col-md-2 col-form-label pt-3"><?php echo $lang['contact']['text_company']; ?></label>
						<div class="col-md-10">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="far fa-building"></i></span>
								</div>
								<input type="text" class="form-control" name="contact[company]" value="<?php echo $result['company']; ?>" placeholder="<?php echo $lang['contact']['text_company']; ?>" required>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label"><?php echo $lang['common']['text_email_address']; ?></label>
						<div class="col-md-10 input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="icon-envelope"></i></span>
							</div>
							<input type="email" class="form-control" value="<?php echo $result['email']; ?>" placeholder="<?php echo $lang['common']['text_email_address']; ?>" readonly>
							<input type="hidden" name="contact[email]" value="<?php echo $result['email']; ?>">	
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label"><?php echo $lang['common']['text_phone_number']; ?></label>
						<div class="col-md-10 input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="icon-phone"></i></span>
							</div>
							<input type="number" class="form-control" name="contact[phone]" value="<?php echo $result['phone']; ?>" placeholder="<?php echo $lang['common']['text_phone_number']; ?>" required>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label"><?php echo $lang['common']['text_website']; ?></label>
						<div class="col-md-10 input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="icon-globe"></i></span>
							</div>
							<input type="text" class="form-control" name="contact[website]" value="<?php echo $result['website']; ?>" placeholder="<?php echo $lang['common']['text_website']; ?>" >
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label">Marketing</label>
						<div class="col-md-10">
							<div class="custom-control custom-checkbox custom-checkbox-1 d-inline-block">
								<input type="checkbox" name="contact[marketing][email]" class="custom-control-input" id="marketing-email" value="email" <?php if (!empty($result['marketing']['email']) && $result['marketing']['email'] == "email") { echo "checked"; } ?>>
								<label class="custom-control-label" for="marketing-email">Email</label>
							</div>
							<div class="custom-control custom-checkbox custom-checkbox-1 d-inline-block">
								<input type="checkbox" name="contact[marketing][phone]" class="custom-control-input" id="marketing-phone" value="phone" <?php if (!empty($result['marketing']['phone']) && $result['marketing']['phone'] == "phone") { echo "checked"; } ?>>
								<label class="custom-control-label" for="marketing-phone">Phone</label>
							</div>
							<div class="custom-control custom-checkbox custom-checkbox-1 d-inline-block">
								<input type="checkbox" name="contact[marketing][sms]" class="custom-control-input" id="marketing-sms" value="sms" <?php if (!empty($result['marketing']['sms']) && $result['marketing']['sms'] == "sms") { echo "checked"; } ?>>
								<label class="custom-control-label" for="marketing-sms">SMS</label>
							</div>
							<div class="custom-control custom-checkbox custom-checkbox-1 d-inline-block">
								<input type="checkbox" name="contact[marketing][social]" class="custom-control-input" id="marketing-social" value="social" <?php if (!empty($result['marketing']['social']) && $result['marketing']['social'] == "social") { echo "checked"; } ?>>
								<label class="custom-control-label" for="marketing-social">Social Media</label>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="address">
					<div class="row form-group">
						<label class="col-md-2 col-form-label"><?php echo $lang['common']['text_address']; ?></label>
						<div class="col-md-5">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="icon-direction"></i></span>
								</div>
								<input type="text" class="form-control" name="contact[address][address1]" value="<?php echo $result['address']['address1'] ?>" placeholder="<?php echo $lang['contact']['text_address_line_1'] ?>">
							</div>
						</div>
						<div class="col-md-5">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="icon-directions"></i></span>
								</div>
								<input type="text" class="form-control" name="contact[address][address2]" value="<?php echo $result['address']['address2'] ?>" placeholder="<?php echo $lang['contact']['text_address_line_2'] ?>">
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label"><?php echo $lang['contact']['text_city'] ?></label>
						<div class="col-md-10 input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="icon-location-pin"></i></span>
							</div>
							<input type="text" class="form-control" name="contact[address][city]" value="<?php echo $result['address']['city'] ?>" placeholder="<?php echo $lang['contact']['text_city'] ?>">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label"><?php echo $lang['contact']['text_state'] ?></label>
						<div class="col-md-10 input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="icon-map"></i></span>
							</div>
							<input type="text" class="form-control" name="contact[address][state]" value="<?php echo $result['address']['state'] ?>" placeholder="<?php echo $lang['contact']['text_state'] ?>">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label"><?php echo $lang['contact']['text_country'] ?></label>
						<div class="col-md-10 input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="icon-globe"></i></span>
							</div>
							<input type="text" class="form-control" name="contact[address][country]" value="<?php echo $result['address']['country'] ?>" placeholder="<?php echo $lang['contact']['text_country'] ?>">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label"><?php echo $lang['contact']['text_pincode'] ?></label>
						<div class="col-md-10 input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="icon-flag"></i></span>
							</div>
							<input type="text" class="form-control" name="contact[address][pin]" value="<?php echo $result['address']['pin'] ?>" placeholder="<?php echo $lang['contact']['text_pincode'] ?>">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label"><?php echo $lang['common']['text_phone_number'] ?></label>
						<div class="col-md-10 input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="icon-phone"></i></span>
							</div>
							<input type="text" class="form-control" name="contact[address][phone1]" value="<?php echo $result['address']['phone1'] ?>" placeholder="<?php echo $lang['common']['text_phone_number'] ?>">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label"><?php echo $lang['contact']['text_fax']; ?></label>
						<div class="col-md-10 input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="icon-call-in"></i></span>
							</div>
							<input type="text" class="form-control" name="contact[address][fax]" value="<?php echo $result['address']['fax'] ?>" placeholder="<?php echo $lang['contact']['text_fax']; ?>">
						</div>
					</div>
				</div>
				<div class="tab-pane" id="rights">
					<div class="table-responsive">
						<table class="table table-stripped table-bordered">
							<tbody>
								<tr>
									<td>Right to rectification</td>
									<td>You can have their personal data rectified if it is inaccurate or incomplete.</td>
									<td>
										<a href="#" class="btn btn-primary btn-shadow btn-pill">Edit your Data</a>
									</td>
								</tr>
								<tr>
									<td>Right to be forgotten</td>
									<td>You can have their personal data rectified if it is inaccurate or incomplete.</td>
									<td>
										<a href="#" class="btn btn-primary btn-shadow btn-pill">Edit your Data</a>
									</td>
								</tr>
								<tr>
									<td>right to restrict processing</td>
									<td>You can have their personal data rectified if it is inaccurate or incomplete.</td>
									<td>
										<a href="#" class="btn btn-primary btn-shadow btn-pill">Edit your Data</a>
									</td>
								</tr>
								<tr>
									<td>Right to data portability</td>
									<td>You can have their personal data rectified if it is inaccurate or incomplete.</td>
									<td>
										<a href="#" class="btn btn-primary btn-shadow btn-pill">Edit your Data</a>
									</td>
								</tr>
								<tr>
									<td>Right to object</td>
									<td>You can have their personal data rectified if it is inaccurate or incomplete.</td>
									<td>
										<a href="#" class="btn btn-primary btn-shadow btn-pill">Edit your Data</a>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="panel-footer">
			<div class="row">
				<div class="col-12 text-center">
					<button type="submit" name="submit" class="btn btn-info"><?php echo $lang['common']['text_save']; ?></button>
				</div>
			</div>
		</div>
	</div>
</form>
<!-- Footer -->
<?php include (DIR_CLIENTS.'app/views/common/footer.tpl.php'); ?>