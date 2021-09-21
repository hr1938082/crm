<?php include (DIR.'app/views/common/header.tpl.php'); ?>
<script>$('#ticket-li').addClass('active');</script>
<!-- User list page start -->
<div class="content">
	<div class="panel panel-default">
		<div class="panel-head">
			<div class="panel-title">
				<i class="fa fa-ticket panel-head-icon"></i>
				<span class="panel-title-text"><?php echo $page_title; ?></span>
			</div>
			<div class="panel-action">
				<a href="<?php echo URL.DIR_ROUTE . 'tickets&filter=open'; ?>" class="btn btn-outline btn-warning btn-outline-1x btn-sm btn-pill"><?php echo $lang['tickets']['text_open_tickets'].'('.$ticketCount['open']; ?> )</a>
				<a href="<?php echo URL.DIR_ROUTE . 'tickets&filter=closed'; ?>" class="btn btn-outline btn-success btn-outline-1x btn-sm btn-pill"><?php echo $lang['tickets']['text_closed_tickets'].'('.$ticketCount['closed']; ?> )</a>
				<a href="<?php echo URL.DIR_ROUTE . 'tickets&filter=all'; ?>" class="btn btn-outline btn-primary btn-outline-1x btn-sm btn-pill"><?php echo $lang['tickets']['text_all_tickets'].'('.$ticketCount['all']; ?> )</a>
				<a href="<?php echo URL.DIR_ROUTE . 'ticket/add'; ?>" class="btn btn-primary btn-gradient btn-sm btn-pill"><i class="icon-plus mr-1"></i> <?php echo $lang['tickets']['text_new_ticket']; ?></a>
			</div>
		</div>
		<div class="panel-wrapper">
			<div class="table-container">
				<table class="datatable-table" width="100%">
					<thead>
						<tr class="table-heading"><th style="display: none"></th></tr>
					</thead>
					<tbody>
						<?php if (!empty($result)) { foreach ($result as $key => $value) { ?>
						<tr>
							<td>
								<div class="card-block">
									<div class="card card-color-new">
										<div class="row card-hdr">
											<div class="col-sm-4 card-left text-left">
												<span class="text-center">#<?php echo $value['id']; ?></span>
											</div>
											<div class="col-sm-8 text-right card-right">
												<span><?php echo $lang['common']['text_created_date']; ?> - <?php echo $value['date_of_joining']; ?></span>
											</div>
										</div>
										<div class="row card-bdy">
											<div class="col-sm-6 col-md-5 text-left">
												<div class="card-img">
													<i class="icon-user"></i>
												</div>
												<div class="card-info">
													<a class="card-name" target="_blank"><?php echo $value['name']; ?></a>
													<div class="card-text"><?php echo $lang['tickets']['text_department']; ?> - <?php echo $value['department']; ?></div>
													<div class="card-text"><?php echo $lang['tickets']['text_priority']; ?> - <?php if ($value['priority'] == 'Low') { ?>
														<span class="badge badge-Low badge-sm badge-pill"><?php echo $lang['tickets']['text_low']; ?></span>
														<?php } elseif ($value['priority'] == 'Medium') { ?>
														<span class="badge badge-Medium badge-sm badge-pill"><?php echo $lang['tickets']['text_medium']; ?></span>
														<?php } else { ?>
														<span class="badge badge-High badge-sm badge-pill"><?php echo $lang['tickets']['text_high']; ?></span>
														<?php } ?>
													</div>
												</div>
											</div>
											<div class="col-sm-6 col-md-7 card-subject">
												<span><?php echo $lang['tickets']['text_subject']; ?></span>
												<p><?php echo $value['subject']; ?></p>
											</div>
										</div>
										<div class="row card-ftr align-items-center">
											<div class="col-sm-8 text-left">
												<span class="badge badge-light badge-pill badge-sm"><?php echo $lang['tickets']['text_last_updated'].'-'.$value['last_updated']; ?></span>
												<span class="badge badge-default badge-pill badge-sm"><?php if ($value['status'] == "1") { echo $lang['tickets']['text_closed']; } else { echo $lang['tickets']['text_open']; } ?></span>
												<?php if ($value['date_of_joining'] == $value['last_updated']) { ?>
												<span class="badge badge-primary badge-pill badge-sm"><?php echo $lang['common']['text_new']; ?></span>
												<?php } elseif ($value['reply_status'] == "1") { ?>
												<span class="badge badge-success badge-pill badge-sm"><?php echo $lang['tickets']['text_replied']; ?></span>
												<?php } else { ?>
												<span class="badge badge-warning badge-pill badge-sm"><?php echo $lang['tickets']['text_waiting_for_reply']; ?></span>
												<?php } ?>
												
											</div>
											<div class="col-sm-4 text-right card-action">
												<a href="<?php echo URL.DIR_ROUTE.'ticket/edit&id='.$value['id']; ?>" class="btn btn-outline btn-primary btn-outline-1x btn-circle" data-toggle="tooltip" title="<?php echo $lang['common']['text_edit'] ?>"><i class="icon-pencil"></i></a>
												<a class="btn btn-outline btn-danger btn-outline-1x btn-circle table-delete" data-toggle="tooltip" data-placement="top" title="<?php echo $lang['common']['text_delete'] ?>">
													<i class="icon-trash"></i>
													<input type="hidden" value="<?php echo $value['id'] ?>">
												</a>
											</div>
										</div>
									</div>  
								</div>
							</td>
						</tr>
						<?php } } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<!-- Delete Modal -->
<div id="delete-card" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><?php echo $lang['common']['text_confirm_delete']; ?></h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<p class="delete-card-ttl"><?php echo $lang['common']['text_are_you_sure_you_want_to_delete?']; ?></p>
			</div>
			<div class="modal-footer">
				<form action="<?php echo URL.DIR_ROUTE.'ticket/delete'; ?>" class="delete-card-button" method="post">
					<input type="hidden" value="" name="id">
					<button type="submit" class="btn btn-danger btn-gradient btn-pill" name="delete"><?php echo $lang['common']['text_delete']; ?></button>
				</form>
				<button type="button" class="btn btn-default btn-gradient btn-pill" data-dismiss="modal"><?php echo $lang['common']['text_close']; ?></button>
			</div>
		</div>
	</div>
</div>


<!-- Footer -->
<?php include (DIR.'app/views/common/footer.tpl.php'); ?>