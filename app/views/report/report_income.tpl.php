<?php include (DIR.'app/views/common/header.tpl.php'); ?>
<script>$('#quotes-li').addClass('active');</script>
<!-- Project list page start -->
<div class="content">
    <div class="panel panel-default">
        <div class="panel-head">
            <div class="panel-title">
                <i class="icon-chart panel-head-icon"></i>
                <span class="panel-title-text"><?php echo $page_title; ?></span>
            </div>
            <div class="panel-action">
            </div>
        </div>
        <div class="panel-wrapper">
            <div class="row widget-separator-1 m-0">
                <div class="col-md-12">
                    <div class="widget-1">
                        <div class="content">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h5 class="title">Total Income</h5>
                                    <span class="descr">All Time</span>
                                </div>
                                <div class="col text-right">
                                    <div class="number text-primary">$22900 + Rs12000</div>
                                </div>
                            </div>
                        </div>
                        <div class="content">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h5 class="title">Total Tax</h5>
                                    <span class="descr">Monthly</span>
                                </div>
                                <div class="col text-right">
                                    <div class="number text-danger">+$2900</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?php include (DIR.'app/views/common/footer.tpl.php'); ?>