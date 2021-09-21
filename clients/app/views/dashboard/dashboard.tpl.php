<?php include (DIR_CLIENTS.'app/views/common/header.tpl.php'); ?>
<div class="panel panel-default">
	<div class="row separator">
		<div class="col-md-4">
			<div class="widget1">
				<div class="row m-0 align-items-center">
					<div class="col-auto">
						<i class="icon-docs icn text-primary"></i>
					</div>
					<div class="col">
						<div class="title"><?php echo $lang['dashboard']['text_total_invoices']; ?></div>
						<div class="desc"><?php echo $lang['dashboard']['text_paid_unpaid_other']; ?></div>
					</div>
					<div class="col-auto">
						<div class="stats text-primary"><?php echo $countInvoice; ?></div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="widget1">
				<div class="row m-0 align-items-center">	
					<div class="col-auto">
						<i class="icon-calculator icn text-warning"></i>
					</div>
					<div class="col">
						<div class="title"><?php echo $lang['dashboard']['text_total_quotes']; ?></div>
						<div class="desc"><?php echo $lang['dashboard']['text_all_quotes_count']; ?></div>
					</div>
					<div class="col-auto">
						<div class="stats text-warning"><?php echo $countQuotes; ?></div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="widget1">
				<div class="row m-0 align-items-center">
					<div class="col-auto">
						<i class="fa fa-ticket icn text-danger"></i>
					</div>
					<div class="col">
						<div class="title"><?php echo $lang['dashboard']['text_total_ticket']; ?></div>
						<div class="desc"><?php echo $lang['dashboard']['text_all_open_close_ticket']; ?></div>
					</div>
					<div class="col-auto">
						<div class="stats text-danger"><?php echo $countTicket; ?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="panel panel-default">
	<div class="row separator">
		<div class="col-md-3">
			<div class="widget1">
				<div class="title"><?php echo $lang['dashboard']['text_invoice_status_breakdown']; ?></div>
				<div id="status-chart" style="height: 180px;"></div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="widget1">
				<div class="title"><?php echo $lang['dashboard']['text_ticket_status_breakdown']; ?></div>
				<div id="ticket-chart" style="height: 180px;"></div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="widget1 pb-2">
				<div class="title"><?php echo $lang['dashboard']['text_last_ticket']; ?></div>
			</div>
			<div class="pl-3 pr-3">
				<?php if (!empty($lastticket)) { ?>
				<div class="card-block">
					<div class="card card-color-new">
						<div class="row card-hdr">
							<div class="col-sm-4 card-left text-left">
								<span class="text-center">#<?php echo $lastticket['id']; ?></span>
							</div>
							<div class="col-sm-8 text-right card-right">
								<span><?php echo $lang['common']['text_created_date']; ?> - <?php echo $lastticket['date_of_joining']; ?></span>
							</div>
						</div>
						<div class="row card-bdy">
							<div class="col-sm-6 col-md-5 text-left">
								<div class="card-info">
									<a class="card-name" target="_blank"><?php echo $lastticket['name']; ?></a>
									<div class="card-text"><?php echo $lang['common']['text_department']; ?> - <?php echo $lastticket['department']; ?></div>
									<div class="card-text"><?php echo $lang['dashboard']['text_priority']; ?> - <?php if ($lastticket['priority'] == 'Low') { ?>
										<span class="badge badge-Low badge-sm badge-pill"><?php echo $lang['dashboard']['text_low']; ?></span>
										<?php } elseif ($lastticket['priority'] == 'Medium') { ?>
										<span class="badge badge-Medium badge-sm badge-pill"><?php echo $lang['dashboard']['text_medium']; ?></span>
										<?php } else { ?>
										<span class="badge badge-High badge-sm badge-pill"><?php echo $lang['dashboard']['text_high']; ?></span>
										<?php } ?>
									</div>
								</div>
							</div>
							<div class="col-sm-6 col-md-7 card-subject">
								<span><?php echo $lang['common']['text_subject']; ?></span>
								<p><?php echo $lastticket['subject']; ?></p>
							</div>
						</div>
						<div class="row card-ftr align-items-center">
							<div class="col-sm-8 text-left">
								<span class="badge badge-light badge-pill badge-sm"><?php echo $lang['dashboard']['text_last_updated']; ?> - <?php echo $lastticket['last_updated']; ?></span>
								<span class="badge badge-default badge-pill badge-sm"><?php if ($lastticket['status'] == "1") { echo $lang['dashboard']['text_closed']; } else { echo $lang['dashboard']['text_open']; } ?></span>
							</div>
							<div class="col-sm-4 text-right card-action">
								<a href="<?php echo URL_CLIENTS.DIR_ROUTE.'ticket/edit&id='.$lastticket['id']; ?>" class="btn btn-outline btn-info btn-outline-1x btn-circle" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o"></i></a>
							</div>
						</div>
					</div>  
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>

<div class="row pb-4">
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-head">
				<div class="panel-title">
					<i class="icon-calculator panel-head-icon"></i>
					<span class="panel-title-text"><?php echo $lang['common']['text_quotations']; ?></span>
				</div>
				<div class="panel-action">
					<a href="<?php echo URL_CLIENTS.DIR_ROUTE.'quotes' ?>" class="btn btn-info btn-sm"><?php echo $lang['common']['text_view_all']; ?></a>
				</div>
			</div>
			<div class="panel-wrapper">
				<table class="table table-head-separator-primary">
					<thead>
						<tr>
							<th>#</th>
							<th><?php echo $lang['common']['text_company']; ?></th>
							<th><?php echo $lang['dashboard']['text_amount']; ?></th>
							<th><?php echo $lang['common']['text_action']; ?></th>
						</tr>
					</thead>
					<tbody>
						<?php if (!empty($quotes)) { foreach ($quotes as $key => $value) { $amount = json_decode($value['total'], true)['amount']; ?>
						<tr>
							<td><a href="<?php echo URL_CLIENTS.DIR_ROUTE.'quote/view&id='.$value['id']; ?>" class="text-primary">QTN-<?php echo str_pad($value['id'], 4, '0', STR_PAD_LEFT); ?></a></td>
							<td><?php echo $value['company']; ?></td>
							<td><?php echo $value['abbr'].' '.$amount; ?></td>
							<td><a href="<?php echo URL_CLIENTS.DIR_ROUTE.'quote/view&id='.$value['id']; ?>" class="btn btn-default btn-sm"><?php echo $lang['common']['text_view']; ?></a></td>
						</tr>
						<?php } } else { ?>
						<tr>
							<td colspan="4" class="font-18 text-center"><?php echo $lang['dashboard']['text_no_quotation_found']; ?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-head">
				<div class="panel-title">
					<i class="icon-docs panel-head-icon"></i>
					<span class="panel-title-text"><?php echo $lang['common']['text_invoices']; ?></span>
				</div>
				<div class="panel-action">
					<a href="<?php echo URL_CLIENTS.DIR_ROUTE.'invoices' ?>" class="btn btn-info btn-sm"><?php echo $lang['common']['text_view_all']; ?></a>
				</div>
			</div>
			<div class="panel-wrapper">
				<table class="table table-head-separator-primary">
					<thead>
						<tr>
							<th>#</th>
							<th><?php echo $lang['common']['text_company']; ?></th>
							<th><?php echo $lang['dashboard']['text_amount']; ?></th>
							<th><?php echo $lang['common']['text_status']; ?></th>
							<th><?php echo $lang['common']['text_action']; ?></th>
						</tr>
					</thead>
					<tbody>
						<?php if (!empty($invoices)) { foreach ($invoices as $key => $value) { ?>
						<tr>
							<td><a href="<?php echo URL_CLIENTS.DIR_ROUTE.'invoice/view&id='.$value['id']; ?>" class="text-primary">INV-<?php echo str_pad($value['id'], 4, '0', STR_PAD_LEFT); ?></a></td>
							<td><?php echo $value['company']; ?></td>
							<td><?php echo $value['abbr'].' '.$value['amount']; ?></td>
							<td>
								<?php if ($value['status'] == "Paid") { ?>
                                <span class="badge badge-Paid badge-pill badge-sm"><?php echo $lang['dashboard']['text_paid']; ?></span>
                                <?php } elseif ($value['status'] == "Unpaid") { ?>
                                <span class="badge badge-Unpaid badge-pill badge-sm"><?php echo $lang['dashboard']['text_unpaid']; ?></span>
                                <?php } elseif ($value['status'] == "Pending") { ?>
                                <span class="badge badge-Pending badge-pill badge-sm"><?php echo $lang['dashboard']['text_pending']; ?></span>
                                <?php } elseif ($value['status'] == "In Process") { ?>
                                <span class="badge badge-In-Process badge-pill badge-sm"><?php echo $lang['dashboard']['text_in_process']; ?></span>
                                <?php } elseif ($value['status'] == "Cancelled") { ?>
                                <span class="badge badge-Cancelled badge-pill badge-sm"><?php echo $lang['dashboard']['text_cancelled']; ?></span>
                                <?php } elseif ($value['status'] == "Other") { ?>
                                <span class="badge badge-Other badge-pill badge-sm"><?php echo $lang['dashboard']['text_other']; ?></span>
                                <?php } elseif ($value['status'] == "Partially Paid") { ?>
                                <span class="badge badge-Partially-Paid badge-pill badge-sm"><?php echo $lang['dashboard']['text_partially_paid']; ?></span>
                                <?php } else { ?>
                                <span class="badge badge-Unknown badge-pill badge-sm"><?php echo $lang['dashboard']['text_unknown']; ?></span>
                                <?php } ?>
							</td>
							<td><a href="<?php echo URL_CLIENTS.DIR_ROUTE.'invoice/view&id='.$value['id']; ?>" class="btn btn-default btn-sm"><?php echo $lang['common']['text_view']; ?></a></td>
						</tr>
						<?php } } else { ?>
						<tr>
							<td colspan="4" class="font-18 text-center"><?php echo $lang['dashboard']['text_no_invoice_found']; ?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script>
	$(function() {
		Morris.Donut({
			element: 'status-chart',
			data: <?php echo $invoice_status; ?>,
			colors: ['#93e3ff', '#b0dd91', '#ffe699', '#f8cbad', '#a4a4a4'],
			formatter: function(y) {
				return y + '%'
			}
		});
		Morris.Donut({
			element: 'ticket-chart',
			data: <?php echo $ticket_status; ?>,
			colors: ['#f4516c', '#716aca'],
			formatter: function(y) {
				return y + '%'
			}
		});


	});

</script>


<!-- Footer -->
<?php include (DIR_CLIENTS.'app/views/common/footer.tpl.php'); ?>