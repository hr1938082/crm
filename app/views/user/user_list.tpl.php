<?php include (DIR.'app/views/common/header.tpl.php'); ?>
<script>
	$('#user').show();
	$('#user-li').addClass('active');
</script>
<!-- User list page start -->

<div class="content">
	<div class="panel">
		<div class="panel-head">
			<div class="panel-title">
				<i class="icon-people panel-head-icon"></i>
				<span class="panel-title-text"><?php echo $page_title; ?></span>
			</div>
			<div class="panel-action">
				<a href="index.php?route=user/add" class="btn btn-primary btn-gradient btn-pill btn-sm"><i class="icon-plus"></i> <?php echo $lang['users']['text_new_user']; ?></a>
			</div>
		</div>
		<div class="panel-wrapper">
			<div class="table-container">
				<table class="table table-bordered table-striped datatable-table" width="100%">
					<thead>
						<tr class="table-heading">
							<th class="table-srno">#</th>
							<th><?php echo $lang['users']['text_person_info']; ?></th>
							<th><?php echo $lang['users']['text_username']; ?></th>
							<th><?php echo $lang['users']['text_user_role']; ?></th>
							<th><?php echo $lang['common']['text_status']; ?></th>
							<th><?php echo $lang['common']['text_created_date']; ?></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php if (!empty($result)) { foreach ($result as $key => $value) { ?>
						<tr>
							<td class="table-srno"><?php echo $key+1; ?></td>
							<td>
								<p class="font-16 m-0"><?php echo $value['firstname'] .' '. $value['lastname']; ?></p>
								<p class="font-12 m-0"><?php echo $value['email']; ?></p>
								<p class="font-12 m-0"><?php echo $value['mobile']; ?></p>
							</td>
							<td><?php echo $value['user_name']; ?></td>
							<td><?php echo $value['role']; ?></td>
							<td>
								<?php if ($value['status'] == '0') { ?>
								<span class="badge badge-sm badge-warning"><?php echo $lang['users']['text_inactive']; ?></span>
								<?php  } else { ?>
								<span class="badge badge-sm badge-success"><?php echo $lang['users']['text_active']; ?></span>
								<?php } ?>
							</td>
							<td><?php echo date_format(date_create($value['date_of_joining']), 'd-m-Y'); ?></td>
							<td class="table-action">
								<?php if ($role == "1") { ?>
								<a href="index.php?route=user/edit&id=<?php echo $value['user_id'];?>"  class="btn btn-primary btn-circle btn-outline btn-outline-1x" data-toggle="tooltip" title="<?php echo $lang['common']['text_edit']; ?>"><i class="icon-pencil"></i></a>
								<p class="btn btn-danger btn-circle btn-outline btn-outline-1x table-delete" data-toggle="tooltip" title="<?php echo $lang['common']['text_delete']; ?>">
									<i class="icon-trash"></i><input type="hidden" value="<?php echo $value['user_id'];?>">
								</p>
								<?php } elseif ($role != "1" && $value['user_role'] != "1") { ?>
								<a href="index.php?route=user/edit&id=<?php echo $value['user_id'];?>"  class="btn btn-primary btn-circle btn-outline btn-outline-1x" data-toggle="tooltip" title="<?php echo $lang['common']['text_edit']; ?>"><i class="icon-pencil"></i></a>
								<p class="btn btn-danger btn-circle btn-outline btn-outline-1x table-delete" data-toggle="tooltip" title="<?php echo $lang['common']['text_delete']; ?>">
									<i class="icon-trash"></i><input type="hidden" value="<?php echo $value['user_id'];?>">
								</p>
								<?php } ?>
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
				<form action="<?php echo URL.DIR_ROUTE.'user/delete'; ?>" class="delete-card-button" method="post">
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