<?php include(DIR . 'app/views/common/header.tpl.php'); ?>
<script>
    $('#lead-li').addClass('active');
</script>
<!-- User list page start -->
<div class="content">
    <div class="panel panel-default">
        <div class="panel-head">
            <div class="panel-title">
                <i class="fas fa-bullhorn panel-head-icon"></i>
                <span class="panel-title-text"><?php echo $page_title; ?></span>
            </div>
            <div class="panel-action">

                <button type="submit" form="deleteForm" class="btn btn-danger btn-outline btn-gradient btn-pill btn-sm">Delete</button>
                <a href="<?php echo URL . DIR_ROUTE . 'lead/add'; ?>" class="btn btn-primary btn-outline btn-gradient btn-pill btn-sm"><i class="icon-plus mr-1"></i>
                    <?php echo $lang['contact']['text_new_lead']; ?></a>
            </div>
        </div>
        <div class="panel-wrapper">
            <!-- <form method="get">
                <div class="row justify-content-end">
                    <div class="col-6 mt-3 mb-2 mr-3">
                        <div class="input-group">
                            <input type="hidden" name="route" value="<?php echo 'leads' ?>"/>
                            <select class="custom-select col-3" name="website"style="height: 35px !important;">
                                <option selected disabled>Websites</option>
                                <?php
                                if (count($websites) > 0) {
                                    foreach ($websites as $value) {
                                ?>
                                    <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                            <input type="text" class="form-control" name="search" style="height: 35px !important;">
                            <div class="input-group-prepend" id="input-slider-decrement" style="cursor: pointer;">
                                <button type="submit" class="input-group-text" style="cursor: pointer;"><i class="icon-magnifier"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form> -->
            <div class="table-container">
                <form action="<?php echo URL . DIR_ROUTE . 'lead/delete'; ?>" id="deleteForm" method="post">
                    <table class="table table-bordered table-striped datatable-table" width="100%">
                        <thead>
                            <tr class="table-heading">
                                <th class="table-srno">#</th>
                                <th><?php echo $lang['contact']['text_company']; ?></th>
                                <th><?php echo $lang['common']['text_email_address']; ?></th>
                                <th><?php echo $lang['common']['text_phone_number']; ?></th>
                                <th>Website Name</th>
                                <th><?php echo $lang['common']['text_status']; ?></th>
                                <th><?php echo $lang['common']['text_created_date']; ?></th>
                                <th><input type="checkbox" data-toggle="tooltip" title="Select all" id="checkall" onclick="checkUncheckAll()"></th>
                                <th>Action</th>
                                <th>Assign Staff</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if ($result) {
                                foreach ($result as $key => $value) {


                            ?>
                                    <tr>
                                        <td class="table-srno"><?php echo $key + 1; ?></td>
                                        <td><a class="font-14"><?php echo $value['company']; ?></a></td>
                                        <td><?php echo $value['email']; ?></td>
                                        <td><?php echo $value['phone']; ?></td>
                                        <?php
                                        $match = "not available";
                                        foreach ($website as $web) {
                                            if ($value['website_id'] == $web['id']) {
                                                $match = $web['name'];
                                            }
                                        }
                                        ?>
                                        <td><?php echo $match; ?></td>
                                        <td>
                                            <?php if ($value['status'] == "1") { ?>
                                                <span class="badge badge-light badge-pill badge-sm"><?php echo $lang['common']['text_new']; ?></span>
                                            <?php } elseif ($value['status'] == "2") { ?>
                                                <span class="badge badge-light badge-pill badge-sm"><?php echo $lang['contact']['text_attempted']; ?></span>
                                            <?php } elseif ($value['status'] == "3") { ?>
                                                <span class="badge badge-light badge-pill badge-sm"><?php echo $lang['contact']['text_not_attempted']; ?></span>
                                            <?php } elseif ($value['status'] == "4") { ?>
                                                <span class="badge badge-light badge-pill badge-sm"><?php echo $lang['contact']['text_working']; ?></span>
                                            <?php } elseif ($value['status'] == "5") { ?>
                                                <span class="badge badge-light badge-pill badge-sm"><?php echo $lang['contact']['text_contacted']; ?></span>
                                            <?php } elseif ($value['status'] == "6") { ?>
                                                <span class="badge badge-light badge-pill badge-sm"><?php echo $lang['contact']['text_converted_qualified']; ?></span>
                                            <?php } elseif ($value['status'] == "7") { ?>
                                                <span class="badge badge-light badge-pill badge-sm"><?php echo $lang['contact']['text_disqualified']; ?></span>
                                            <?php } ?>
                                        </td>
                                        <td><?php echo date_format(date_create($value['date_of_joining']), 'd-m-Y'); ?></td>
                                        <td><input type="checkbox" name="delete[]" value="<?php echo $value['id'] ?>" data-toggle="tooltip" title="Select to delete"></td>
                                        <td class="table-action">
                                            <a href="#" class="btn btn-primary btn-circle btn-outline btn-outline-1x p-2" data-toggle="modal" data-target="#example<?php echo $values['user_id']; ?>"><i class="fa fa-users"></i></a>
                                            <a href="<?php echo URL . DIR_ROUTE . 'lead/edit&id=' . $value['id']; ?>" class="btn btn-primary btn-circle btn-outline btn-outline-1x p-2" data-toggle="tooltip" title="<?php echo $lang['common']['text_edit']; ?>"><i class="icon-pencil"></i></a>
                                            <p class="btn btn-danger btn-circle btn-outline btn-outline-1x table-delete p-2" data-toggle="tooltip" title="<?php echo $lang['common']['text_delete']; ?>"><i class="icon-trash"></i><input type="hidden" value="<?php echo $value['id']; ?>">
                                            </p>
                                        </td>
                                        <td>
                                            <?php
                                            if ($staff) {
                                                foreach ($staff as $key => $values) {

                                                    echo $values['name'] . ' (' . $values['user_name'] . '),&nbsp';
                                                }
                                            }

                                            ?>

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
                <form action="<?php echo URL . DIR_ROUTE . 'lead/delete'; ?>" class="delete-card-button" method="post">
                    <input type="hidden" value="" name="id">
                    <button type="submit" class="btn btn-danger btn-gradient btn-pill" name="delete"><?php echo $lang['common']['text_delete']; ?></button>
                </form>
                <button type="button" class="btn btn-default btn-gradient btn-pill" data-dismiss="modal"><?php echo $lang['common']['text_close']; ?></button>
            </div>
        </div>
    </div>
</div>


<!--ASSIGN MODEL-->
<?php
foreach ($result as $key => $value) {


?>

    <div class="modal fade" id="example<?php echo $values['user_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Assing Staff To <?php echo $value['firstname']; ?>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo $action; ?>" method="post">

                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-md-10 customer-search">

                                <select name="staff_ff" class="selectpicker" data-width="100%" data-live-search="true" title="Assign Staff">
                                    <?php if ($staff) {
                                        foreach ($staff as $key => $values) { ?>
                                            <option value="<?php echo $values['user_id']; ?>" <?php if ($result['user_id'] == $values['user_id']) {
                                                                                                    echo "selected";
                                                                                                } ?>>
                                                <?php echo $values['name'] . ' (' . $values['user_name'] . ')'; ?></option>
                                    <?php }
                                    } ?>
                                </select>

                            </div>
                            <br>
                            <input type="hidden" name="_token" value="<?php echo $token; ?>">

                            <input type="hidden" name="id" value="<?php echo $value['id']; ?>">



                        </div>

                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary" type="submit" name="submit">Save</button>
                    </div>
                </form>
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
<?php } ?>



<!-- Footer -->
<?php include(DIR . 'app/views/common/footer.tpl.php'); ?>