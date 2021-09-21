<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?php echo $data['lang']['quotes']['text_quotation']; ?></title>
	<link rel="stylesheet" href="public/css/inv-pdf.css" type="text/css">
</head>
<body>
	<div class="inv-template">
		<div class="company pl-30 pr-30">
			<table>
				<tbody>
					<tr>
						<td class="info">
							<div class="logo"><img src="../public/uploads/<?php echo $data['info']['logo']; ?>" alt="logo"></div>
							<div class="name"><?php echo $data['info']['legal_name']; ?></div>
							<div class="text"><?php echo $data['info']['address']['address1'].', '.$data['info']['address']['address2'].', '.$data['info']['address']['city'].', '.$data['info']['address']['country'].' - '.$data['info']['address']['pincode']; ?></div>
						</td>
						<td class="text-right">
							<div class="title"><?php echo $data['lang']['quotes']['text_quotation']; ?></div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="meta pl-30 pr-30">
			<table>
				<tbody>
					<tr>
						<td class="bill-to v-aling-bottom">
							<div class="heading"><?php echo $data['lang']['quotes']['text_quote_to']; ?></div>
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
										<td class="text"><?php echo $data['lang']['quotes']['text_quote_date']; ?></td>
										<td class="text w-min-130"><?php echo date_format(date_create($result['date']), 'd-m-Y'); ?></td>
									</tr>
									<tr>
										<td class="text"><?php echo $data['lang']['quotes']['text_expiry_date']; ?></td>
										<td class="text w-min-130"><?php echo date_format(date_create($result['expiry']), 'd-m-Y'); ?></td>
									</tr>
									<tr>
										<td class="text"><?php echo $data['lang']['quotes']['text_payment_method']; ?></td>
										<td class="text w-min-130"><?php echo $result['payment_method']; ?></td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="item pl-30 pr-30">
			<table>
				<thead>
					<tr>
						<th><?php echo $data['lang']['quotes']['text_item_and_description']; ?></th>
						<th><?php echo $data['lang']['quotes']['text_quantity']; ?></th>
						<th><?php echo $data['lang']['quotes']['text_unit_cost'].'('.$result['currency_abbr'].')'; ?></th>
						<th><?php echo $data['lang']['quotes']['text_tax'].' ('.$result['currency_abbr'].')'; ?></th>
						<th><?php echo $data['lang']['quotes']['text_price'].' ('.$result['currency_abbr'].')'; ?></th>
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
						<td class="title"><?php echo $data['lang']['quotes']['text_sub_total']; ?></td>
						<td class="value"><?php echo $result['currency_abbr'].$result['total']['subtotal']; ?></td>
					</tr>
					<tr class="total">
						<td class="title"><?php echo $data['lang']['quotes']['text_tax']; ?></td>
						<td class="value"><?php echo $result['currency_abbr'].$result['total']['tax']; ?></td>
					</tr>
					<tr class="total">
						<td class="title"><?php echo $data['lang']['quotes']['text_discount']; ?></td>
						<td class="value"><?php echo $result['currency_abbr'].$result['total']['discount_value']; ?></td>
					</tr>
					<tr class="total">
						<td class="title"><?php echo $data['lang']['quotes']['text_total']; ?></td>
						<td class="value"><?php echo $result['currency_abbr'].$result['total']['amount']; ?></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="note pl-30 pr-30">
			<table>
				<tbody>
					<tr>
						<td class="block v-align-top">
							<span><?php echo $data['lang']['quotes']['text_customer_note']; ?></span>
							<p><?php echo $result['note']; ?></p>
						</td>
						<td class="block v-align-top">
							<span><?php echo $data['lang']['quotes']['text_terms_conditions']; ?></span>
							<p><?php echo $result['tc']; ?></p>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<?php if ($printQuote == '1') { ?>
		<script type="text/javascript"> 
			this.print(true);
		</script>
	<?php } ?>
</body>
</html>