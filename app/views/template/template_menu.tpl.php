<!-- Setting Finance Menu -->
<div class="panel panel-default">
    <div class="panel-head">
        <div class="panel-title">
            <i class="icon-settings panel-head-icon"></i>
            <span class="panel-title-text"><?php echo $lang['common']['text_email_template_menu']; ?></span>
        </div>
    </div>
    <div class="panel-wrapper">
        <div class="nav flex-column vnav-tabs">
            <?php foreach ($template_menu as $key => $value) { ?>
            <li id="<?php echo $value['template'] ?>" class="nav-link"><a href="<?php echo URL.DIR_ROUTE; ?>emailtemplate&for=<?php echo $value['template'] ?>"><?php echo $value['name']; ?></a></li>
            <?php } ?>
        </div>
    </div>
</div>
<script>
        $('#<?php echo $result['template']; ?>').addClass('active');
</script>