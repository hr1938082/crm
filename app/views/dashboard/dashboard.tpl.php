<?php include (DIR.'app/views/common/header.tpl.php'); ?>
<script>$('#dashboard-li').addClass('active');</script>
<!-- Moris Chart Plugin -->
<script type="text/javascript" src="public/js/raphael-min.js"></script>
<script type="text/javascript" src="public/js/morris.min.js"></script>
<!-- Dahsboard Body -->
<div class="content">
    <div class="row">
        <div class="col-md-6 col-lg-3">
            <div class="dashboard-stat color-success">
                <div class="content"><h4><?php echo $statistics['0']['total']; ?></h4> <span><?php echo $lang['common']['text_contact']; ?></span></div>
                <div class="icon"><i class="icon-people"></i></div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="dashboard-stat color-warning">
                <div class="content"><h4><?php echo $statistics['1']['total']; ?></h4> <span><?php echo $lang['common']['text_projects']; ?></span></div>
                <div class="icon"><i class="icon-layers"></i></div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="dashboard-stat color-primary">
                <div class="content"><h4><?php echo $statistics['2']['total']; ?></h4> <span><?php echo $lang['common']['text_invoices']; ?></span></div>
                <div class="icon"><i class="icon-docs"></i></div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="dashboard-stat color-danger">
                <div class="content"><h4><?php echo $statistics['3']['total']; ?></h4> <span><?php echo $lang['common']['text_quotes']; ?></span></div>
                <div class="icon"><i class="icon-envelope-letter"></i></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="icon-widget-heading pb-3"><?php echo $lang['dashboard']['text_income_expense']; ?></div>
                    <div id="inv-exp-chart" style="height: 380px;"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="">
                    <div class="icon-widget-heading pr-3 pl-3 pt-3 pb-0"><?php echo $lang['dashboard']['text_expense_categories_breakdown']; ?></div>
                    <div id="exp-catg-chart" style="height: 180px;"></div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="">
                    <div class="icon-widget-heading pr-3 pl-3 pt-3 pb-0"><?php echo $lang['dashboard']['text_ticket_status_breakdown']; ?></div>
                    <div id="ticket-chart" style="height: 180px;"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <div class="panel panel-default">
                <div class="panel-head">
                    <div class="panel-title">
                        <i class="icon-credit-card panel-head-icon"></i>
                        <span class="panel-title-text"><?php echo $lang['dashboard']['text_latest_invoices']; ?></span>
                    </div>
                    <div class="panel-action"></div>
                </div>
                <div class="panel-wrapper">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo $lang['common']['text_customer']; ?></th>
                                        <th><?php echo $lang['dashboard']['text_amount']; ?></th>
                                        <th><?php echo $lang['common']['text_status']; ?></th>
                                        <th><?php echo $lang['common']['text_date']; ?></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($invoices)) { foreach ($invoices as $key => $value) { ?>
                                    <tr>
                                        <td><a href="<?php echo URL.DIR_ROUTE . 'invoice/view&id=' .$value['id']; ?>" class="text-primary">INV-<?php echo str_pad($value['id'], 4, '0', STR_PAD_LEFT); ?></a></td>
                                        <td class="text-dark"><?php echo $value['company']; ?></td>
                                        <td class="text-dark"><?php echo $value['abbr'].$value['amount']; ?></td>
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
                                        <td><i class="fa fa-clock-o mr-2 text-muted"></i><?php echo date_format(date_create($value['date_of_joining']), 'd-m-Y'); ?></td>
                                        <td>
                                            <a href="<?php echo URL.DIR_ROUTE . 'invoice/view&id=' .$value['id']; ?>" class="mr-2"><i class="fa fa-eye mr-2 text-dark" data-toggle="tooltip" title="<?php echo $lang['common']['text_view'] ?>"></i></a>
                                            <a href="<?php echo URL.DIR_ROUTE . 'invoice/edit&id=' .$value['id']; ?>"><i class="icon-pencil mr-2 text-info" data-toggle="tooltip" title="<?php echo $lang['common']['text_edit'] ?>"></i></a>
                                        </td>
                                    </tr>
                                    <?php } } else { ?>
                                    <tr>
                                        <td colspan="6" class="text-center font-18"><?php echo $lang['dashboard']['text_no_record_found']; ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="icon-widget-heading pb-3"><?php echo $lang['dashboard']['text_invoice_status_breakdown']; ?></div>
                    <div id="inv-status-chart" style="height: 350px;"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-head">
                    <div class="panel-title">
                        <i class="icon-credit-card panel-head-icon"></i>
                        <span class="panel-title-text"><?php echo $lang['dashboard']['text_latest_contacts']; ?></span>
                    </div>
                    <div class="panel-action"></div>
                </div>
                <div class="panel-wrapper">
                    <div class="panel-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th><?php echo $lang['dashboard']['text_company']; ?></th>
                                    <th><?php echo $lang['common']['text_first_name']; ?></th>
                                    <th><?php echo $lang['common']['text_last_name']; ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($contacts)) { foreach ($contacts as $key => $value) { ?>
                                <tr>
                                    <td><a href="<?php echo URL.DIR_ROUTE.'contact/edit&id='.$value['id']; ?>" class="text-primary"><?php echo $value['company']; ?></a></td>
                                    <td class="text-dark"><?php echo $value['firstname']; ?></td>
                                    <td class="text-dark"><?php echo $value['lastname']; ?></td>
                                </tr>
                                <?php } } else { ?>
                                <tr>
                                    <td colspan="3" class="text-center font-18"><?php echo $lang['dashboard']['text_no_record_found']; ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        Morris.Area({
            element: 'inv-exp-chart',
            data: <?php echo $stats; ?>,
            //lineColors: ['#00ced1', '#ff758e'],
            xkey: 'period',
            xLabelFormat: function (x) { return months[x.getMonth()]; },
            ykeys: ['income','expense'],
            labels: ['<?php echo $lang['dashboard']['text_income'] ?>', '<?php echo $lang['dashboard']['text_expense'] ?> '],
            pointSize: 0,
            fillOpacity: 0.8,
            pointStrokeColors:['#ffc107', '#3483FF'],
            behaveLikeLine: true,
            gridLineColor: '#e0e0e0',
            lineWidth: 0,
            smooth: false,
            hideHover: 'auto',
            lineColors: ['#3483FF', '#aaa'],
            resize: true
        });
        Morris.Donut({
            element: 'exp-catg-chart',
            data: <?php echo $expenses; ?>,
            colors: ['#93e3ff', '#b0dd91', '#ffe699', '#f8cbad', '#a4a4a4'],
            formatter: function(y) {
                return y + '%'
            }
        });
        Morris.Donut({
            element: 'ticket-chart',
            data: <?php echo $ticketByStatus; ?>,
            colors: ['#f4516c', '#716aca'],
            formatter: function(y) {
                return y + '%'
            }
        });
        Morris.Donut({
            element: 'inv-status-chart',
            data: <?php echo $invoiceByStatus; ?>,
            colors: ['#ccc5a8', '#52bacc', '#dbdb46', '#98aafb', '#5cbae6', '#b6d957', '#fac364', '#8cd3ff', '#d998cb', '#f2d249', '#93b9c6'],
            formatter: function(y) {
                return y + '%'
            }
        });
    });
</script>

<!-- Footer -->
<?php include (DIR.'app/views/common/footer.tpl.php'); ?>