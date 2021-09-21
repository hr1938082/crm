<?php include(DIR . 'app/views/common/header.tpl.php'); ?>


<script>
    $('#project-li').addClass('active');
</script>
<!-- Project list page start -->
<div class="content">
    <div class="panel panel-default">
        <div class="panel-head pb-0">
            <div class="panel-title">
                <i class="icon-layers panel-head-icon"></i>
                <span class="panel-title-text"><?php echo $page_title; ?></span>
            </div>
            <div class="panel-action">
                <button type="submit" form="deleteForm" formaction="<?php echo URL . DIR_ROUTE . 'project/delete'; ?>" class="btn btn-danger btn-outline btn-gradient btn-pill btn-sm mb-3">Delete</button>
                <a href="index.php?route=project/add" class="btn btn-primary btn-outline btn-gradient btn-pill btn-sm mb-3"><i class="icon-plus mr-1"></i> <?php echo $lang['project']['text_new_project']; ?></a>
            </div>
        </div>
        <div class="panel-wrapper">
            <div class="table-container">
                <form id="deleteForm" method="post">
                    <div class="row justify-content-end mt-3 mr-3 mb-0" id="deleteSubmit">
                        <div class="form-group customer-search mb-0">
                            <div class="form-group mb-0">
                                <select name="staff" class="selectpicker" data-live-search="true" title="Staff">
                                    <?php if ($staff) {
                                        foreach ($staff as $key => $value) { ?>
                                            <option value="<?php echo $value['user_id']; ?>" <?php if ($value['name'] == $value['user_id']) {
                                                                                                    echo "selected";
                                                                                                } ?>><?php echo $value['name'] . ' <small> (' . $value['email'] . ')</small>'; ?></option>
                                    <?php }
                                    } ?>
                                </select>
                                <button type="submit" form="deleteForm" formaction="<?php echo URL . DIR_ROUTE . 'project/assign/staff'; ?>" class="btn btn-primary btn-outline btn-gradient btn-pill btn-sm">Assign</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped datatable-table" width="100%">
                        <thead>
                            <tr class="table-heading">
                                <th class="table-srno">#</th>
                                <th><?php echo $lang['project']['text_project_name']; ?></th>
                                <th><?php echo $lang['common']['text_customer']; ?></th>
                                <th>% <?php echo $lang['project']['text_complete']; ?></th>
                                <th>Payments</th>
                                <th>Website</th>
                                <th><?php echo $lang['common']['text_created_date']; ?></th>
                                <th><input type="checkbox" data-toggle="tooltip" title="Select all" id="checkall" onclick="checkUncheckAll()"></th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result) {
                                foreach ($result as $key => $value) {  ?>
                                    <tr>
                                        <td class="table-srno"><?php echo $key + 1; ?></td>
                                        <td><?php echo $value['name']; ?></td>
                                        <td><a href="index.php?route=contact/edit&id=<?php echo $value['customer'] ?>" class="text-primary font-14" target="_blank"><?php echo $value['company']; ?></a></td>
                                        <td>
                                            <?php if ($value['completed'] < '25') { ?>
                                                <span class="badge badge-danger badge-pill badge-sm"><?php echo $value['completed'] . '% Completed'; ?></span>
                                            <?php } elseif ($value['completed'] < '50') { ?>
                                                <span class="badge badge-warning badge-pill badge-sm"><?php echo $value['completed'] . '% Completed'; ?></span>
                                            <?php } elseif ($value['completed'] < '75') { ?>
                                                <span class="badge badge-dark badge-pill badge-sm"><?php echo $value['completed'] . '% Completed'; ?></span>
                                            <?php } elseif ($value['completed'] < '90') { ?>
                                                <span class="badge badge-info badge-pill badge-sm"><?php echo $value['completed'] . '% Completed'; ?></span>
                                            <?php } elseif ($value['completed'] > '90') { ?>
                                                <span class="badge badge-success badge-pill badge-sm"><?php echo $value['completed'] . '% Completed'; ?></span>
                                            <?php } else { ?>
                                                <span class="badge badge-primary badge-pill badge-sm"><?php echo $value['completed'] . '% Completed'; ?></span>
                                            <?php } ?>
                                        </td>
                                        <?php
                                        $match = 0;
                                        foreach ($payments as $pay) {
                                            if ($value['id'] == $pay['project_id']) {
                                                $match = $pay['amount'];
                                            }
                                        }
                                        ?>
                                        <td><?php echo $match ?></td>
                                        <?php
                                        $match = "not available";
                                        foreach ($websites as $web) {
                                            if ($value['website_id'] == $web['id']) {
                                                $match = $web['name'];
                                            }
                                        }
                                        ?>
                                        <td><?php echo $match ?></td>
                                        <td><?php echo date_format(date_create($value['date_of_joining']), 'd-m-Y'); ?></td>
                                        <td><input type="checkbox" name="delete[]" value="<?php echo $value['id'] ?>"></td>
                                        <td class="table-action">
                                            <a href="index.php?route=project/edit&id=<?php echo $value['id'] ?>" class="btn btn-primary btn-circle btn-outline btn-outline-1x" data-toggle="tooltip" title="<?php echo $lang['common']['text_edit']; ?>"><i class="icon-pencil"></i></a>
                                            <p class="btn btn-danger btn-circle btn-outline btn-outline-1x table-delete" data-toggle="tooltip" data-placement="top" title="<?php echo $lang['common']['text_delete']; ?>"><i class="icon-trash"></i><input type="hidden" value="<?php echo $value['id'] ?>"></p>
                                        </td>
                                    </tr>
                            <?php }
                            } ?>
                        </tbody>
                    </table>
                </form>
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
                <form action="<?php echo URL . DIR_ROUTE . 'project/delete'; ?>" class="delete-card-button" method="post">
                    <input type="hidden" value="" name="id">
                    <button type="submit" class="btn btn-danger btn-gradient btn-pill" name="delete"><?php echo $lang['common']['text_delete']; ?></button>
                </form>
                <button type="button" class="btn btn-default btn-gradient btn-pill" data-dismiss="modal"><?php echo $lang['common']['text_close']; ?></button>
            </div>
        </div>
    </div>
</div>

<script>
    var checkUncheckAll = (e) => {
        var checkall = document.getElementById('checkall');
        if (checkall.checked) {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            for (var checkbox of checkboxes) {
                checkbox.checked = true;
            }
        } else {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            for (var checkbox of checkboxes) {
                checkbox.checked = false;
            }
        }
    }
</script>
<!-- Footer -->
<?php include(DIR . 'app/views/common/footer.tpl.php'); ?>