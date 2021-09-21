<?php include (DIR.'app/views/common/header.tpl.php'); ?>
<script>$('#quotes-li').addClass('active');</script>

<form action="<?php echo $action; ?>" method="post" data-toggle="validator">
    <div class="panel panel-default">
        <div class="panel-head">
            <div class="panel-title">
                <i class="icon-calculator panel-head-icon"></i>
                <span class="panel-title-text"><?php echo $page_title; ?></span>
            </div>
            <div class="panel-action">
                <button type="submit" class="btn btn-primary btn-gradient btn-icon" name="submit" data-toggle="tooltip" title="<?php echo $lang['common']['text_save'] ?>"><i class="far fa-save"></i></button>
                <a href="<?php echo URL.DIR_ROUTE . 'quotes'; ?>" class="btn btn-white btn-icon" data-toggle="tooltip" title="<?php echo $lang['common']['text_back_to_list'] ?>"><i class="fa fa-reply"></i></a>
            </div>  
        </div>
        <div class="panel-wrapper p-3">
            <input type="hidden" name="_token" value="<?php echo $token; ?>">
            <div class="mt-3 pl-4 pr-4">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group customer-search">
                            <label class="col-form-label"><?php echo $lang['common']['text_customer'] ?></label>
                            <div class="input-group">
                                <select class="selectpicker" name="invoice[customer]" data-width="100%" data-live-search="true" title="<?php echo $lang['common']['text_customer'] ?>" required>
                                    <?php if (!empty($customers)) { foreach ($customers as $key => $value) { ?>
                                    <option value="<?php echo $value['id'] ?>" <?php if ($result['customer'] == $value['id']) { echo "selected"; } ?>><?php echo $value['company'] ?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-form-label"><?php echo $lang['quotes']['text_project_name']; ?></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-layers"></i></span>
                                </div>
                                <input type="text" class="form-control" name="invoice[project_name]" value="<?php echo $result['project_name'] ?>" placeholder="<?php echo $lang['quotes']['text_project_name']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="col-form-label"><?php echo $lang['common']['text_currency']; ?></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-credit-card"></i></span>
                                </div>
                                <select name="invoice[currency]" class="custom-select" required>
                                    <?php if ($currency) { foreach ($currency as $key => $value) { ?>
                                    <option value="<?php echo $value['id'] ?>" <?php if ($result['currency'] == $value['id']) { echo "selected"; } ?>><?php echo $value['name']; ?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="col-form-label"><?php echo $lang['quotes']['text_payment_method']; ?></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-wallet"></i></span>
                                </div>
                                <select name="invoice[paymenttype]" class="custom-select" required>
                                    <option value=""><?php echo $lang['quotes']['text_payment_method']; ?></option>
                                    <?php if ($payment_type) { foreach ($payment_type as $key => $value) { ?>
                                    <option value="<?php echo $value['id'] ?>" <?php if ($result['paymenttype'] == $value['id']) { echo "selected"; } ?>><?php echo $value['name']; ?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="col-form-label"><?php echo $lang['quotes']['text_quote_date']; ?></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-calendar"></i></span>
                                </div>
                                <input type="text" class="form-control date" name="invoice[date]" value="<?php echo date_format(date_create($result['date']), 'd-m-Y'); ?>" placeholder="<?php echo $lang['quotes']['text_quote_date']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="col-form-label"><?php echo $lang['quotes']['text_expiry_date']; ?></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-event"></i></span>
                                </div>
                                <input type="text" class="form-control date" name="invoice[expiry]" value="<?php echo date_format(date_create($result['expiry']), 'd-m-Y'); ?>" placeholder="<?php echo $lang['quotes']['text_expiry_date']; ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="invoice-items pt-3">
                    <table class="table-input">
                        <thead>
                            <tr>
                                <th><?php echo $lang['quotes']['text_item_name']; ?></th>
                                <th><?php echo $lang['quotes']['text_item_description']; ?></th>
                                <th style="display:none;"><?php echo $lang['quotes']['text_quantity']; ?></th>
                                <th>Project Cost</th>
                                <th style="display:none;"><?php echo $lang['quotes']['text_tax']; ?></th>
                                <th>Total Amount</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($result['items'])) { $inv_items = json_decode($result['items'], true); foreach ($inv_items as $key => $value) { ?>
                            <tr class="item-row">
                                <td class="">
                                    <textarea name="invoice[item][<?php echo $key; ?>][name]" class="item-name"><?php echo $value['name']; ?></textarea>
                                </td>
                                <td class="invoice-item">
                                    <textarea name="invoice[item][<?php echo $key; ?>][descr]" class="item-descr"><?php echo $value['descr']; ?></textarea>
                                </td>
                                <td class="">
                                    <textarea type="text" name="invoice[item][<?php echo $key; ?>][quantity]" class="item-quantity"><?php echo $value['quantity']; ?></textarea>
                                </td>
                                <td class="">
                                    <textarea type="text" name="invoice[item][<?php echo $key; ?>][cost]" class="item-cost"><?php echo $value['cost']; ?></textarea>
                                </td>
                                <td class="invoice-tax">
                                    <?php if (!empty($value['tax'])) { foreach ($value['tax'] as $tax_key => $tax_value) { ?>
                                    <p class="badge badge-light badge-sm badge-pill">
                                        <?php echo $tax_value['name']; ?>
                                        <input type="text" name="invoice[item][<?php echo $key ?>][tax][<?php echo $tax_key ?>][tax_price]" class="single-tax-price" value="<?php echo $tax_value['tax_price']; ?>" readonly>
                                        <input type="hidden" name="invoice[item][<?php echo $key ?>][tax][<?php echo $tax_key ?>][id]" class="invoice-tax-id" value="<?php echo $tax_value['id']; ?>"> 
                                        <input type="hidden" name="invoice[item][<?php echo $key ?>][tax][<?php echo $tax_key ?>][name]" value="<?php echo $tax_value['name']; ?>">
                                        <input type="hidden" class="invoice-tax-rate" name="invoice[item][<?php echo $key ?>][tax][<?php echo $tax_key ?>][rate]" value="<?php echo $tax_value['rate']; ?>">
                                    </p>
                                    <?php } } ?>
                                    <input type="hidden" name="invoice[item][<?php echo $key; ?>][taxprice]" class="item-tax-price" value="<?php echo $value['taxprice']; ?>" readonly>
                                </td>
                                <td>
                                    <textarea type="text" name="invoice[item][<?php echo $key; ?>][price]" class="item-total-price" readonly><?php echo $value['price']; ?></textarea>
                                    <input type="hidden" class="item-price" value="<?php echo $value['price']; ?>">
                                </td>
                                
                            </tr>
                            <?php } } else {  ?>
                            <tr class="item-row">
                                <td class="">
                                    <textarea name="invoice[item][0][name]" class="item-name"></textarea>
                                </td>
                                <td class="invoice-item">
                                    <textarea name="invoice[item][0][descr]" class="item-descr"></textarea>
                                </td>
                                <td class="" style="display:none;">
                                    <textarea type="text" name="invoice[item][0][quantity]" class="item-quantity">1</textarea>
                                </td>
                                <td class="">
                                    <textarea type="text" name="invoice[item][0][cost]" class="item-cost"></textarea>
                                </td>
                                <td class="invoice-tax"  style="display:none;">
                                    <input type="hidden" name="invoice[item][0][taxprice]" class="item-tax-price" value="0" readonly>
                                </td>
                                <td class="">
                                    <textarea type="text" name="invoice[item][0][price]" class="item-total-price" readonly></textarea>
                                    <input type="hidden" class="item-price">
                                </td>
                             
                            </tr>
                            <?php } if (!empty($result['total'])) { $total = json_decode($result['total'], true); } else { $total = NULL; } ?>
                            <tr>
                                <td colspan="2" class="p-2">
                                    <div class="add-items d-inline-block">
                                        <a class="btn btn-success btn-sm m-1"><i class="icon-plus mr-1"></i> <?php echo $lang['quotes']['text_add_item']; ?></a>
                                    </div>
                                </td>
                                <td colspan="3" class="total-line">
                                    <label><?php echo $lang['quotes']['text_sub_total']; ?></label>
                                </td>
                                <td colspan="2" class="total-value">
                                    <input type="text" name="invoice[total][subtotal]" class="form-transparent sub-total" value="<?php echo $total['subtotal'] ?>" readonly>
                                </td>
                            </tr>
                            <tr  style="display:none;">
                                <td colspan="2" class="blank">
                                </td>
                                <td colspan="3" class="total-line"  style="display:none;">
                                    <label><?php echo $lang['quotes']['text_tax']; ?></label>
                                </td>
                                <td colspan="2" class="total-value">
                                    <input type="text" name="invoice[total][tax]" class="form-transparent tax-total" value="<?php echo $total['tax'] ?>" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="blank">
                                </td>
                                <td colspan="3" class="total-line">
                                    <div class="row align-items-center">
                                        <div class="col-9"><label><?php echo $lang['quotes']['text_discount']; ?></label></div>
                                        <div class="col-3">
                                            <select name="invoice[total][discounttype]" class="form-control discount-type">
                                                <option value="1" <?php if ($total['discounttype'] == 1) { echo "selected"; } ?>>%</option>
                                                <option value="2" <?php if ($total['discounttype'] == 2) { echo "selected"; } ?>><?php echo $lang['quotes']['text_flat']; ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </td>
                                <td colspan="2" class="total-value">
                                    <input type="text" name="invoice[total][discount]" class="form-transparent discount-total" value="<?php echo $total['discount'] ?>">
                                    <input type="hidden" class="discount_amount" name="invoice[total][discount_value]"  value="<?php echo $total['discount_value'] ?>">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="blank">
                                </td>
                                <td colspan="3" class="total-line">
                                    <label><?php echo $lang['quotes']['text_total']; ?></label>
                                </td>
                                <td colspan="2" class="total-value">
                                    <input type="text" name="invoice[total][amount]" class="form-transparent  total-amount" value="<?php echo $total['amount'] ?>" readonly>
                                    <input type="hidden" name="invoice[total][paid]" value="0.00">
                                    <input type="hidden" name="invoice[total][due]" value="0.00">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="pt-5">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label><?php echo $lang['quotes']['text_customer_note']; ?></label>
                                <textarea class="form-control" name="invoice[note]" rows="3"><?php echo $result['note']; ?></textarea>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label><?php echo $lang['quotes']['text_terms_Conditions']; ?></label>
                                <textarea class="form-control"  name="invoice[tc]" rows="3"><?php echo $result['tc']; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer text-center">
            <button type="submit" name="submit" class="btn btn-primary btn-gradient btn-pill"><?php echo $lang['common']['text_save']; ?></button>
        </div>
        <!-- <input type="hidden" class="items" value="<?php echo htmlspecialchars(htmlspecialchars_decode(json_encode($items), JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8'); ?>"> -->
        <input type="hidden" name="id" value="<?php echo $result['id']; ?>">

    </div>
</form>


<script src="public/js/invoice.js"></script>
<!-- Footer -->
<?php include (DIR.'app/views/common/footer.tpl.php'); ?>