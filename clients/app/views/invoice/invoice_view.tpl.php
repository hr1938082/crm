<?php include (DIR_CLIENTS.'app/views/common/header.tpl.php'); ?>

<div class="panel panel-default">
	<div class="panel-head">
		<div class="panel-title">
			<i class="icon-docs panel-head-icon"></i>
			<span class="panel-title-text"><?php echo $page_title; ?></span>
		</div>
		<div class="panel-action">
			
		</div>
	</div>
	<div class="panel-wrapper">
		<div class="inv-template">
			<div class="inv-template-hdr">
				<div class="row">
					<div class="col-sm-2">
						<div class="ribbon"><?php if ($result['status'] == "Paid") { echo $lang['invoices']['text_paid']; } elseif ($result['status'] == "Unpaid") { echo $lang['invoices']['text_unpaid']; } elseif ($result['status'] == "Pending") { echo $lang['invoices']['text_pending']; } elseif ($result['status'] == "In Process") { echo $lang['invoices']['text_in_process']; } elseif ($result['status'] == "Cancelled") { echo $lang['invoices']['text_cancelled']; } elseif ($result['status'] == "Other") { echo $lang['invoices']['text_other']; } elseif ($result['status'] == "Partially Paid") { echo $lang['invoices']['text_partially_paid']; } else { echo $lang['invoices']['text_unknown']; } ?></div>
					</div>
					<div class="col-sm-10 text-right">
						<a href="<?php echo URL_CLIENTS.DIR_ROUTE .'invoice/pdf&id='.$result['id']; ?>" class="btn btn-danger btn-sm" target="_blank"><i class="fa fa-file-pdf-o mr-2"></i> <?php echo $lang['invoices']['text_pdf']; ?></a>
						<a href="<?php echo URL_CLIENTS.DIR_ROUTE .'invoice/print&id='.$result['id']; ?>" class="btn btn-success btn-sm" target="_blank"><i class="icon-printer mr-2"></i> <?php echo $lang['invoices']['text_print']; ?></a>
						<?php if ($result['due'] > "0") { ?>
							<a href="<?php echo URL_CLIENTS.DIR_ROUTE . 'makepayment&invoice=' .$result['id']; ?>" class="btn btn-warning btn-sm"><?php echo $lang['invoices']['text_pay_now']; ?></a>
						<?php } ?>
					</div>
				</div>
			</div>
			<div class="inv-template-bdy table-responsive p-4">
				<div class="company">
					<table>
						<tbody>
							<tr>
								<td class="info">
									<div class="logo"><img src="../public/uploads/<?php echo $info['logo']; ?>" alt="logo"></div>
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
												<td class="text w-min-130"><?php echo 'INV-'.str_pad($result['id'], 4, '0', STR_PAD_LEFT); ?></td>
											</tr>
											<tr>
												<td class="text"><?php echo $lang['common']['text_created_date']; ?></td>
												<td class="text w-min-130"><?php echo date_format(date_create($result['date_of_joining']), 'd-m-Y'); ?></td>
											</tr>
											<tr>
												<td class="text"><?php echo $lang['invoices']['text_due_date']; ?></td>
												<td class="text w-min-130"><?php echo date_format(date_create($result['duedate']), 'd-m-Y'); ?></td>
											</tr>
											<tr>
												<td class="text"><?php echo $lang['invoices']['text_payment_method']; ?></td>
												<td class="text w-min-130"><?php echo $result['payment']; ?></td>
											</tr>
											<tr>
												<td class="text"><?php echo $lang['invoices']['text_due']; ?></td>
												<td class="text w-min-130"><?php echo $result['currency_abbr'].$result['due']; ?></td>
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
								<td rowspan="5" colspan="3" class="blank">
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
							<tr class="total">
								<td class="title"><?php echo $lang['invoices']['text_paid']; ?></td>
								<td class="value"><?php echo $result['currency_abbr'].$result['paid']; ?></td>
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
										<?php if (!empty($info['signature']) && file_exists('../public/uploads/'.$info['signature'])) { ?>
											<img src="../public/uploads/<?php echo $info['signature']; ?>">
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

<div class="row">
	<div class="col-lg-6">
		<div class="panel panel-default">
			<div class="panel-head">
				<div class="panel-title">
					<i class="icon-credit-card panel-head-icon"></i>
					<span class="panel-title-text"><?php echo $lang['invoices']['text_payment_history']; ?></span>
				</div>
				<div class="panel-action"></div>
			</div>
			<div class="panel-body">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th><?php echo $lang['common']['text_date']; ?></th>
							<th><?php echo $lang['invoices']['text_method']; ?></th>
							<th><?php echo $lang['invoices']['text_amount'].'('.$result['currency_abbr']; ?>)</th>
						</tr>
					</thead>
					<tbody>
						<?php $total  = 0; if (!empty($payments)) { foreach ($payments as $key => $value) { ?>
							<tr>
								<td><?php echo date_format(date_create($value['payment_date']), 'd-m-Y'); ?></td>
								<td><?php if (!empty($value['method_name'])) { echo $value['method_name']; } else { echo "Paypal"; } ?></td>
								<td><?php echo $value['amount']; ?></td>
							</tr>
							<?php $total = $total + $value['amount']; } ?>
							<tr>
								<td colspan="2" class="text-right">Total</td>
								<td><?php echo $result['currency_abbr'].' '.$total ; ?></td>
							</tr>
						<?php } else { ?>
							<tr>
								<td colspan="3" class="text-center"><?php echo $lang['invoices']['text_no_payment_history']; ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="col-lg-6">
		<div class="panel panel-default">
			<div class="panel-head">
				<div class="panel-title">
					<i class="icon-paper-clip panel-head-icon"></i>
					<span class="panel-title-text"><?php echo $lang['invoices']['text_attachments']; ?></span>
				</div>
				<div class="panel-action"></div>
			</div>
			<div class="panel-body">
				<div class="attached-files">
					<?php if (!empty($attachments)) { foreach ($attachments as $key => $value) { $file_ext = pathinfo($value['file_name'], PATHINFO_EXTENSION); if ($file_ext == "pdf") { ?>
						<div class="attached-files-block">
							<a href="../public/uploads/<?php echo $value['file_name']; ?>" class="open-pdf" target="_blank"><i class="fa fa-file-pdf-o"></i></a>
						</div>
					<?php } else { ?>
						<div class="attached-files-block">
							<a href="../public/uploads/<?php echo $value['file_name']; ?>" data-fancybox="gallery" target="_black"><img src="../public/uploads/<?php echo $value['file_name']; ?>" alt=""></a>
						</div>
					<?php } } } ?>
				</div>
			</div>
		</div>
	</div>
</div>

<link rel="stylesheet" href="public/css/jquery.fancybox.min.css">
<script src="public/js/jquery.fancybox.min.js"></script>

<script>
	$("a.open-pdf").fancybox({
		'frameWidth': 800,
		'frameHeight': 900,
		'overlayShow': true,
		'hideOnContentClick': false,
		'type': 'iframe'
	});
</script>
<!-- Footer -->
<?php include (DIR_CLIENTS.'app/views/common/footer.tpl.php'); ?>