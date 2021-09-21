<?php include (DIR.'app/views/common/header.tpl.php'); ?>
<script>$('#rinvoice-li').addClass('active');</script>

<div class="panel panel-default">
	<div class="panel-head">
		<div class="panel-title">
			<i class="icon-docs panel-head-icon"></i>
			<span class="panel-title-text"><?php echo $page_title; ?></span>
		</div>
	</div>
	<div class="panel-wrapper">
		<div class="inv-template">
			<div class="inv-template-hdr">
				<div class="row">
					<div class="col-sm-2">
						<div class="ribbon"><?php if ($result['inv_status'] == "0") { echo $lang['invoices']['text_draft']; } else { echo $lang['invoices']['text_published']; } ?></div>
					</div>
					<div class="col-sm-10 text-right">
						<a href="<?php echo URL.DIR_ROUTE .'recurring/pdf&id='.$result['id']; ?>" class="btn btn-danger btn-sm" target="_blank"><i class="far fa-file-pdf mr-2"></i> <?php echo $lang['invoices']['text_pdf']; ?></a>
						<a href="<?php echo URL.DIR_ROUTE .'recurring/print&id='.$result['id']; ?>" class="btn btn-success btn-sm" target="_blank"><i class="icon-printer mr-2"></i><?php echo $lang['invoices']['text_print']; ?></a>
						<a href="<?php echo URL.DIR_ROUTE .'recurring/edit&id='.$result['id']; ?>" class="btn btn-info btn-sm"><i class="icon-pencil mr-2"></i> <?php echo $lang['common']['text_edit']; ?></a>
					</div>
				</div>
			</div>
			<div class="inv-template-bdy table-responsive p-3">
				<div class="company">
					<table>
						<tbody>
							<tr>
								<td class="info">
									<div class="logo"><img src="public/uploads/<?php echo $info['logo']; ?>" alt="logo"></div>
									<div class="name"><?php echo $info['legal_name']; ?></div>
									<div class="text"><?php echo $info['address']['address1'].', '.$info['address']['address2'].', '.$info['address']['city'].', '.$info['address']['country'].' - '.$info['address']['pincode']; ?></div>
								</td>
								<td class="text-right">
									<div class="title"><?php echo $lang['common']['text_invoice']; ?></div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="meta">
					<table>
						<tbody>
							<tr>
								<td class="bill-to v-aling-bottom">
									<div class="heading"><?php echo $lang['invoices']['text_bill_to']; ?></div>
									<div class="title"><?php echo $result['company']; ?></div>
									<div class="text"><?php echo $result['email']; ?></div>
									<div class="text"><?php echo $result['address']['address1'].', '.$result['address']['address2']; ?></div>
									<div class="text"><?php echo $result['address']['city'].', '.$result['address']['country'].' - '.$result['address']['pin']; ?></div>
								</td>
								<td class="info v-aling-bottom">
									<table class="text-right">
										<tbody>
											<tr>
												<td class="text">#</td>
												<td class="text w-min-130"><?php echo 'RINV-'.str_pad($result['id'], 4, '0', STR_PAD_LEFT); ?></td>
											</tr>
											<tr>
												<td class="text"><?php echo $lang['invoices']['text_invoice_date']; ?></td>
												<td class="text w-min-130"><?php echo date_format(date_create($result['inv_date']), 'd-m-Y'); ?></td>
											</tr>
											<tr>
												<td class="text"><?php echo $lang['invoices']['text_repeat_every']; ?></td>
												<td class="text w-min-130"><?php echo $result['repeat_every']; ?></td>
											</tr><tr>
												<td class="text"><?php echo $lang['invoices']['text_payment_method']; ?></td>
												<td class="text w-min-130"><?php echo $result['payment']; ?></td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="item">
					<table>
						<thead>
							<tr>
								<th><?php echo $lang['invoices']['text_item_and_description']; ?></th>
								<th><?php echo $lang['invoices']['text_quantity']; ?></th>
								<th><?php echo $lang['invoices']['text_unit_cost'].'('.$result['currency_abbr'].')'; ?></th>
								<th><?php echo $lang['invoices']['text_tax'].' ('.$result['currency_abbr'].')'; ?></th>
								<th><?php echo $lang['invoices']['text_price'].' ('.$result['currency_abbr'].')'; ?></th>
							</tr>
						</thead>
						<tbody>
							<?php if (!empty($result['items'])) { foreach ($result['items'] as $key => $value) { ?>
								<tr>
									<td class="title"><p><?php echo $value['name']; ?></p><span><?php echo $value['descr']; ?></span></td>
									<td><?php echo $value['quantity']; ?></td>
									<td><?php echo $value['cost']; ?></td>
									<td class="tax">
										<?php if (!empty($value['tax'])) { foreach ($value['tax'] as $tax_key => $tax_value) { ?>
											<div><span><?php echo $tax_value['tax_price']; ?></span><span><?php echo $tax_value['name']; ?></span></div>
										<?php } } ?>
									</td>
									<td><?php echo $value['price']; ?></td>
								</tr>
							<?php } } ?>
							<tr class="total">
								<td rowspan="4" colspan="3" class="blank">
									<?php if ($result['want_payment'] == '1') { ?>
										<div class="payment">
											<div class="title"><?php echo $lang['invoices']['text_payment_info']; ?></div>
											<table>
												<tbody>
													<tr>
														<td><?php echo $lang['invoices']['text_account_#']; ?></td>
														<td><?php echo $info['invoice_setting']['accountnumber']; ?></td>
													</tr>
													<tr>
														<td><?php echo $lang['invoices']['text_account_name']; ?></td>
														<td><?php echo $info['invoice_setting']['accountname']; ?></td>
													</tr>
													<tr>
														<td><?php echo $lang['invoices']['text_bank_name']; ?></td>
														<td><?php echo $info['invoice_setting']['bankname']; ?></td>
													</tr>
													<tr>
														<td><?php echo $lang['invoices']['text_bank_details']; ?></td>
														<td><?php echo $info['invoice_setting']['bankdetails']; ?>.</td>
													</tr>
												</tbody>
											</table>
										</div>
									<?php } ?>
								</td>
								<td class="title"><?php echo $lang['invoices']['text_sub_total']; ?></td>
								<td class="value"><?php echo $result['currency_abbr'].$result['subtotal']; ?></td>
							</tr>
							<tr class="total">
								<td class="title"><?php echo $lang['invoices']['text_tax']; ?></td>
								<td class="value"><?php echo $result['currency_abbr'].$result['tax']; ?></td>
							</tr>
							<tr class="total">
								<td class="title"><?php echo $lang['invoices']['text_discount']; ?></td>
								<td class="value"><?php echo $result['currency_abbr'].$result['discount_value']; ?></td>
							</tr>
							<tr class="total">
								<td class="title"><?php echo $lang['invoices']['text_total']; ?></td>
								<td class="value"><?php echo $result['currency_abbr'].$result['amount']; ?></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="note">
					<table>
						<tbody>
							<tr>
								<td class="block v-align-top">
									<span><?php echo $lang['invoices']['text_customer_note']; ?></span>
									<p><?php echo $result['note']; ?></p>
								</td>
								<td class="block v-align-top">
									<span><?php echo $lang['invoices']['text_terms_Conditions']; ?></span>
									<p><?php echo $result['tc']; ?></p>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<?php if ($result['want_signature'] == '1') { ?>
					<div class="bottom pr-30">
						<table>
							<tbody>
								<tr>
									<td class="sign">
										<?php if (!empty($info['signature']) && file_exists('public/uploads/'.$info['signature'])) { ?>
											<img src="public/uploads/<?php echo $info['signature']; ?>">
										<?php } else { ?>
											<div class="sign_white"></div>
										<?php } ?>
										<div class="text-right"><?php echo $lang['invoices']['text_authorised_sign']; ?></div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<div class="panel panel-default">
	<div class="panel-head">
		<div class="panel-title">
			<span class="panel-title-text"><?php echo $lang['invoices']['text_invoices_created_from_recurring_invoice']; ?></span>
		</div>
	</div>
	<div class="panel-body">
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>#</th>
						<th><?php echo $lang['common']['text_customer']; ?></th>
						<th><?php echo $lang['invoices']['text_amount']; ?></th>
						<th><?php echo $lang['common']['text_status']; ?></th>
						<th><?php echo $lang['common']['text_date']; ?></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php if (!empty($recurringInvoices)) { foreach ($recurringInvoices as $key => $value) { ?>
						<tr>
							<td><a href="<?php echo URL.DIR_ROUTE . 'invoice/view&id=' .$value['id']; ?>" class="text-primary">INV-<?php echo str_pad($value['id'], 4, '0', STR_PAD_LEFT); ?></a></td>
							<td class="text-dark"><?php echo $value['company']; ?></td>
							<td class="text-dark"><?php echo $value['abbr'].$value['amount']; ?></td>
							<td>
								<?php if ($value['status'] == "Paid") { ?>
									<span class="badge badge-Paid badge-pill badge-sm"><?php echo $lang['invoices']['text_paid']; ?></span>
								<?php } elseif ($value['status'] == "Unpaid") { ?>
									<span class="badge badge-Unpaid badge-pill badge-sm"><?php echo $lang['invoices']['text_unpaid']; ?></span>
								<?php } elseif ($value['status'] == "Pending") { ?>
									<span class="badge badge-Pending badge-pill badge-sm"><?php echo $lang['invoices']['text_pending']; ?></span>
								<?php } elseif ($value['status'] == "In Process") { ?>
									<span class="badge badge-In-Process badge-pill badge-sm"><?php echo $lang['invoices']['text_in_process']; ?></span>
								<?php } elseif ($value['status'] == "Cancelled") { ?>
									<span class="badge badge-Cancelled badge-pill badge-sm"><?php echo $lang['invoices']['text_cancelled']; ?></span>
								<?php } elseif ($value['status'] == "Other") { ?>
									<span class="badge badge-Other badge-pill badge-sm"><?php echo $lang['invoices']['text_other']; ?></span>
								<?php } elseif ($value['status'] == "Partially Paid") { ?>
									<span class="badge badge-Partially-Paid badge-pill badge-sm"><?php echo $lang['invoices']['text_partially_paid']; ?></span>
								<?php } else { ?>
									<span class="badge badge-Unknown badge-pill badge-sm"><?php echo $lang['invoices']['text_unknown']; ?></span>
								<?php } ?>
							</td>
							<td><i class="fa fa-clock-o mr-2 text-muted"></i><?php echo date_format(date_create($value['date_of_joining']), 'd-m-Y'); ?></td>
							<td>
								<a href="<?php echo URL.DIR_ROUTE . 'invoice/view&id=' .$value['id']; ?>" class="mr-2"><i class="fa fa-eye mr-2 text-dark" data-toggle="tooltip" title="<?php echo $lang['common']['text_view'] ?>"></i></a>
								<a href="<?php echo URL.DIR_ROUTE . 'invoice/edit&id=' .$value['id']; ?>"><i class="icon-pencil mr-2 text-info" data-toggle="tooltip" title="<?php echo $lang['common']['text_edit'] ?>"></i></a>
							</td>
						</tr>
					<?php } } else { ?>
						<tr>
							<td colspan="6" class="text-center font-18"><?php echo $lang['common']['text_no_records_available']; ?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- Sent Email -->
<div id="invoiceMail" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><?php echo $lang['invoices']['text_send_email']; ?></h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<form action="<?php echo URL.DIR_ROUTE .'recurring/sentmail';?>" method="post" enctype="multipart/form-data">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6 form-group">
							<label class="col-form-label"><?php echo $lang['invoices']['text_to']; ?></label>
							<input type="text" class="form-control" value="<?php echo $result['email'] ?>" placeholder="<?php echo $lang['invoices']['text_to']; ?>" readonly>
						</div>
						<div class="col-md-6 form-group">
							<label class="col-form-label"><?php echo $lang['invoices']['text_bcc']; ?></label>
							<input type="email" class="form-control" name="mail[bcc]" value="" placeholder="<?php echo $lang['invoices']['text_bcc']; ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-form-label"><?php echo $lang['invoices']['text_subject']; ?></label>
						<input type="text" class="form-control" name="mail[subject]" value="Invoice Reminder" placeholder="<?php echo $lang['invoices']['text_subject']; ?>" required>
					</div>
					<div class="form-group">
						<label class="col-form-label"><?php echo $lang['invoices']['text_message']; ?></label>
						<textarea name="mail[message]" class="summernote1" placeholder="<?php echo $lang['invoices']['text_message']; ?>">Hello Dear,<br/><br/>Your Invoice has been created. Invoice Number - <b>RINV-<?php echo str_pad($result['id'], 4, '0', STR_PAD_LEFT); ?></b><br/>You can also view this invoice online by <a href="<?php echo URL.'clients/index.php?route=invoice/view&id='.$result['id']; ?>">clicking here</a>.<br/><br/>Thank you,<br/>Administrator</textarea>
					</div>
					<input type="hidden" name="mail[invoice]" value="<?php echo $result['id']; ?>">
					<input type="hidden" name="mail[to]" value="<?php echo $result['email']; ?>">
					<input type="hidden" name="mail[name]" value="<?php echo $result['company']; ?>">
					<input type="hidden" name="_token" value="<?php echo $token; ?>">
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary" name="submit"><?php echo $lang['invoices']['text_send']; ?></button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- include summernote css/js-->
<link href="public/css/summernote-bs4.css" rel="stylesheet">
<script type="text/javascript" src="public/js/summernote-bs4.min.js"></script>
<script type="text/javascript" src="public/js/custom.summernote.js"></script>

<!-- Footer -->
<?php include (DIR.'app/views/common/footer.tpl.php'); ?>