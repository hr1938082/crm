<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?php echo $data['lang']['common']['text_invoice']; ?></title>
	<link rel="stylesheet" href="public/css/inv-pdf.css" type="text/css">
</head>
<body>
	<div class="inv-template inv-template-1">
		<div class="company pl-30 pr-30">
			<table>
				<tbody>
					<tr>
						<td class="info">
							<div class="logo"><img src="public/uploads/<?php echo $data['info']['logo']; ?>" alt="logo"></div>
							<div class="name"><?php echo $data['info']['legal_name']; ?></div>
							<div class="text"><?php echo $data['info']['address']['address1'].', '.$data['info']['address']['address2'].', '.$data['info']['address']['city'].', '.$data['info']['address']['country'].' - '.$data['info']['address']['pincode']; ?></div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="strip"><p><?php echo $data['lang']['common']['text_invoice']; ?></p></div>
		<div class="meta pl-30 pr-30">
			<table>
				<tbody>
					<tr>
						<td class="bill-to v-align-bottom">
							<div class="heading"><?php echo $data['lang']['invoices']['text_bill_to']; ?></div>
							<div class="title"><?php echo $result['company']; ?></div>
							<div class="text"><?php echo $result['email']; ?></div>
							<div class="text"><?php echo $result['address']['address1'].', '.$result['address']['address2']; ?></div>
							<div class="text"><?php echo $result['address']['city'].', '.$result['address']['country'].' - '.$result['address']['pin']; ?></div>
						</td>
						<td class="info v-align-bottom">
							<table class="text-right">
								<tbody>
									<tr>
										<td class="text">#</td>
										<td class="text w-min-130"><?php echo 'INV-'.str_pad($result['id'], 4, '0', STR_PAD_LEFT); ?></td>
									</tr>
									<tr>
										<td class="text"><?php echo $data['lang']['common']['text_created_date']; ?></td>
										<td class="text w-min-130"><?php echo date_format(date_create($result['date_of_joining']), 'd-m-Y'); ?></td>
									</tr>
									<tr>
										<td class="text"><?php echo $data['lang']['invoices']['text_due_date']; ?></td>
										<td class="text w-min-130"><?php echo date_format(date_create($result['duedate']), 'd-m-Y'); ?></td>
									</tr>
									<tr>
										<td class="text"><?php echo $data['lang']['invoices']['text_payment_method']; ?></td>
										<td class="text w-min-130"><?php echo $result['payment']; ?></td>
									</tr><tr>
										<td class="text"><?php echo $data['lang']['invoices']['text_due']; ?></td>
										<td class="text w-min-130"><?php echo $result['currency_abbr'].$result['due']; ?></td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="item pl-30 pr-30">
			<table cellspacing="0">
				<thead>
					<tr>
						<th><?php echo $data['lang']['invoices']['text_item_and_description']; ?></th>
						<th><?php echo $data['lang']['invoices']['text_quantity']; ?></th>
						<th><?php echo $data['lang']['invoices']['text_unit_cost'].'('.$result['currency_abbr'].')'; ?></th>
						<th><?php echo $data['lang']['invoices']['text_tax'].' ('.$result['currency_abbr'].')'; ?></th>
						<th><?php echo $data['lang']['invoices']['text_price'].' ('.$result['currency_abbr'].')'; ?></th>
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
				</tbody>
			</table>
		</div>
		<div class="payment-total">
			<table>
				<tbody>
					<tr>
						<td class="v-align-top pr-30 pl-30">
							<?php if ($result['want_payment'] == '1') { ?>
								<div class="payment">
									<div class="title"><?php echo $data['lang']['invoices']['text_payment_info']; ?></div>
									<table>
										<tbody>
											<tr>
												<td><?php echo $data['lang']['invoices']['text_account_#']; ?></td>
												<td><?php echo $data['info']['invoice_setting']['accountnumber']; ?></td>
											</tr>
											<tr>
												<td><?php echo $data['lang']['invoices']['text_account_name']; ?></td>
												<td><?php echo $data['info']['invoice_setting']['accountname']; ?></td>
											</tr>
											<tr>
												<td><?php echo $data['lang']['invoices']['text_bank_name']; ?></td>
												<td><?php echo $data['info']['invoice_setting']['bankname']; ?></td>
											</tr>
											<tr>
												<td><?php echo $data['lang']['invoices']['text_bank_details']; ?></td>
												<td><?php echo $data['info']['invoice_setting']['bankdetails']; ?>.</td>
											</tr>
										</tbody>
									</table>
								</div>
							<?php } ?>
						</td>
						<td class="v-align-top pr-30">
							<div class="total">
								<table cellspacing="0">
									<tbody>
										<tr>
											<td><?php echo $data['lang']['invoices']['text_sub_total']; ?></td>
											<td><?php echo $result['currency_abbr'].$result['subtotal']; ?></td>
										</tr>
										<tr>
											<td><?php echo $data['lang']['invoices']['text_tax']; ?></td>
											<td><?php echo $result['currency_abbr'].$result['tax']; ?></td>
										</tr>
										<tr>
											<td><?php echo $data['lang']['invoices']['text_discount']; ?></td>
											<td><?php echo $result['currency_abbr'].$result['discount_value']; ?></td>
										</tr>
										<tr>
											<td><?php echo $data['lang']['invoices']['text_paid']; ?></td>
											<td><?php echo $result['currency_abbr'].$result['paid']; ?></td>
										</tr>
										<tr class="main">
											<td><?php echo $data['lang']['invoices']['text_total']; ?></td>
											<td><?php echo $result['currency_abbr'].$result['amount']; ?></td>
										</tr>
									</tbody>
								</table>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="note pl-30 pr-30">
			<table>
				<tbody>
					<tr>
						<td class="block v-align-top">
							<span><?php echo $data['lang']['invoices']['text_customer_note']; ?></span>
							<p><?php echo $result['note']; ?></p>
						</td>
						<td class="block v-align-top">
							<span><?php echo $data['lang']['invoices']['text_terms_Conditions']; ?></span>
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
								<?php if (!empty($data['info']['signature']) && file_exists('public/uploads/'.$data['info']['signature'])) { ?>
									<img src="public/uploads/<?php echo $data['info']['signature']; ?>">
								<?php } else { ?>
									<div class="sign_white"></div>
								<?php } ?>
								<div class="text-right"><?php echo $data['lang']['invoices']['text_authorised_sign']; ?></div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		<?php } ?>
	</div>
	<?php if ($printInvoice == '1') { ?>
		<script type="text/javascript"> 
			this.print(true);
		</script>
	<?php } ?>
</body>
</html>