<?php include(DIR . 'app/views/common/header.tpl.php');?>

<script>$('#web-client-li').addClass('active');</script>
<form action="<?php echo $action;?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="<?php echo $token; ?>">
    <div class="panel panel-default">
        <div class="panel-head">
            <div class="panel-title">
                <i class="icon-layers panel-head-icon"></i>
                <span class="panel-title-text"><?php echo $page_title; ?></span>
            </div>
            <div class="panel-action">
                <button type="submit" class="btn btn-primary btn-gradient btn-icon" name="submit" data-toggle="tooltip" title="<?php echo $lang['common']['text_save']; ?>"><i class="far fa-save"></i></button>
                <a href="<?php echo URL . DIR_ROUTE . 'webclients'; ?>" class="btn btn-white btn-icon" data-toggle="tooltip" title="<?php echo $lang['common']['text_back_to_list']; ?>"><i class="fa fa-reply"></i></a>
            </div>
        </div>
        <div class="panel-wrapper">
            <div class="p-3">
                <div class="tab-content mt-3 pl-4 pr-4">
                    <div class="tab-pane active" id="basic-info">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label">Site Name</label>
                                        <input type="text" class="form-control <?php
                                            if(isset($_GET['error']))
                                            {
                                                echo 'border border-danger';
                                            }
                                        ?>" name="website[site_name]" value="<?php echo $result[0]['name']?>" placeholder="Site Name">
                                        <?php 
                                            if(isset($_GET['error']))
                                            {
                                        ?>
                                            <div class="text-danger"><?php echo $_GET['error'];?></div>
                                        <?php
                                                
                                            }
                                        ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label">Site URl</label>
                                        <input type="text" class="form-control" name="website[site_url]" value="<?php echo $result[0]['site_url']?>" placeholder="Site URL">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="id" value="<?php echo $result[0]['id']; ?>">
        </div>
        <div class="panel-footer">
            <div class="row">
                <div class="col-12 text-center">
                    <button type="submit" name="submit" class="btn btn-primary btn-gradient btn-pill"><?php echo $lang['common']['text_save']; ?></button>
                </div>
            </div>
        </div>
    </div>
</form>
<link rel="stylesheet" href="public/css/jquery.fancybox.min.css">
<script src="public/js/jquery.fancybox.min.js"></script>
<!-- Footer -->
<?php include(DIR . 'app/views/common/footer.tpl.php'); ?>