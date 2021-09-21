<!-- Setting Finance Menu -->
<div class="panel panel-default">
    <div class="panel-head">
        <div class="panel-title">
            <i class="icon-settings panel-head-icon"></i>
            <span class="panel-title-text"><?php echo $lang['settings']['text_finance_setting']; ?></span>
        </div>
    </div>
    <div class="panel-wrapper">
        <div class="nav flex-column vnav-tabs">
            <li id="finance-tax" class="nav-link"><a href="<?php echo URL.DIR_ROUTE; ?>taxes"><?php echo $lang['settings']['text_taxes']; ?></a></li>
            <li id="finance-currency" class="nav-link"><a href="<?php echo URL.DIR_ROUTE; ?>currency"><?php echo $lang['settings']['text_currencies']; ?></a></li>
            <li id="finance-method" class="nav-link"><a href="<?php echo URL.DIR_ROUTE; ?>paymenttype"><?php echo $lang['settings']['text_payment_method']; ?></a></li>
            <li id="finance-gateway" class="nav-link"><a href="<?php echo URL.DIR_ROUTE; ?>paymentgateway"><?php echo $lang['settings']['text_payment_gateway']; ?></a></li>
        </div>
    </div>
</div>