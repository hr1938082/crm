<?php include (DIR_CLIENTS.'app/views/common/header.tpl.php'); ?>

<div class="panel panel-default">
	<div class="panel-head">
		<div class="panel-title">
			<i class="icon-calculator panel-head-icon"></i>
			<span class="panel-title-text"><?php echo $page_title; ?></span>
		</div>
		<div class="panel-action">
			
		</div>
	</div>
	<div class="panel-wrapper">
		<div class="inv-template">
			<div class="inv-template-hdr">
				<div class="row">
					<div class="col-12 text-right">
						<?php if (empty($result['invoice_id'])) { ?>
							<a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#acceptQuote"><i class="icon-docs mr-2"></i> <?php echo $lang['quotes']['text_accept']; ?></a>
						<?php } else { ?>
							<a href="<?php echo URL_CLIENTS.DIR_ROUTE.'invoice/view&id='.$result['invoice_id']; ?>" class="btn btn-primary btn-sm"><i class="icon-docs mr-2"></i> <?php echo $lang['quotes']['text_quotation_invoiced']; ?></a>
						<?php } ?>
						<a href="<?php echo URL_CLIENTS.DIR_ROUTE .'quote/pdf&id='.$result['id']; ?>" class="btn btn-danger btn-sm" target="_blank"><i class="fa fa-file-pdf-o mr-2"></i> <?php echo $lang['quotes']['text_pdf']; ?></a>
						<a href="<?php echo URL_CLIENTS.DIR_ROUTE .'quote/print&id='.$result['id']; ?>" class="btn btn-success btn-sm" target="_blank"><i class="icon-printer mr-2"></i><?php echo $lang['quotes']['text_print']; ?></a>
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
									<div class="title"><?php echo $lang['quotes']['text_quotation']; ?></div>
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
									<div class="heading"><?php echo $lang['quotes']['text_quote_to']; ?></div>
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
												<td class="text w-min-130"><?php echo 'QTN-'.str_pad($result['id'], 4, '0', STR_PAD_LEFT); ?></td>
											</tr>
											<tr>
												<td class="text"><?php echo $lang['quotes']['text_quote_date']; ?></td>
												<td class="text w-min-130"><?php echo date_format(date_create($result['date']), 'd-m-Y'); ?></td>
											</tr>
											<tr>
												<td class="text"><?php echo $lang['quotes']['text_expiry_date']; ?></td>
												<td class="text w-min-130"><?php echo date_format(date_create($result['expiry']), 'd-m-Y'); ?></td>
											</tr>
											<tr>
												<td class="text"><?php echo $lang['quotes']['text_payment_method']; ?></td>
												<td class="text w-min-130"><?php echo $result['payment_method']; ?></td>
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
								<th><?php echo $lang['quotes']['text_item_and_description']; ?></th>
								<th><?php echo $lang['quotes']['text_quantity']; ?></th>
								<th><?php echo $lang['quotes']['text_unit_cost'].'('.$result['currency_abbr'].')'; ?></th>
								<th><?php echo $lang['quotes']['text_tax'].' ('.$result['currency_abbr'].')'; ?></th>
								<th><?php echo $lang['quotes']['text_price'].' ('.$result['currency_abbr'].')'; ?></th>
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
								<td rowspan="4" colspan="3" class="blank"></td>
								<td class="title"><?php echo $lang['quotes']['text_sub_total']; ?></td>
								<td class="value"><?php echo $result['currency_abbr'].$result['total']['subtotal']; ?></td>
							</tr>
							<tr class="total">
								<td class="title"><?php echo $lang['quotes']['text_tax']; ?></td>
								<td class="value"><?php echo $result['currency_abbr'].$result['total']['tax']; ?></td>
							</tr>
							<tr class="total">
								<td class="title"><?php echo $lang['quotes']['text_discount']; ?></td>
								<td class="value"><?php echo $result['currency_abbr'].$result['total']['discount_value']; ?></td>
							</tr>
							<tr class="total">
								<td class="title"><?php echo $lang['quotes']['text_total']; ?></td>
								<td class="value"><?php echo $result['currency_abbr'].$result['total']['amount']; ?></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="note">
					<table>
						<tbody>
							<tr>
								<td class="block v-align-top">
									<span><?php echo $lang['quotes']['text_customer_note']; ?></span>
									<p><?php echo $result['note']; ?></p>
								</td>
								<td class="block v-align-top">
									<span><?php echo $lang['quotes']['text_terms_conditions']; ?></span>
									<p><?php echo $result['tc']; ?></p>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="acceptQuote">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Confirmation</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<p><?php echo $lang['quotes']['text_are_you_sure_you_want_to_accept_this_quotation']; ?></p>
			</div>
			<div class="modal-footer">
				<form action="<?php echo URL_CLIENTS.DIR_ROUTE.'convertquote'; ?>" method="post">
					<input type="hidden" name="id" value="<?php echo $result['id']; ?>">
					<button type="submit" name="submit" class="btn btn-info"><?php echo $lang['quotes']['text_yes']; ?></button>
				</form>
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $lang['quotes']['text_no']; ?></button>
			</div>
		</div>
	</div>
</div>

<!-- Footer -->
<?php include (DIR_CLIENTS.'app/views/common/footer.tpl.php'); ?>