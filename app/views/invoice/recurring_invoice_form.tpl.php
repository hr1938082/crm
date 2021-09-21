<?php include (DIR.'app/views/common/header.tpl.php'); ?>
<script>$('#rinvoice-li').addClass('active');</script>

<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="<?php echo $token; ?>">
    <div class="panel panel-default">
        <div class="panel-head">
            <div class="panel-title">
                <i class="icon-docs panel-head-icon"></i>
                <span class="panel-title-text"><?php echo $page_title; ?></span>
            </div>
            <div class="panel-action">
                <button type="submit" class="btn btn-primary btn-gradient btn-icon" name="submit" data-toggle="tooltip" title="<?php echo $lang['common']['text_save']; ?>"><i class="far fa-save"></i></button>
                <a href="<?php echo URL.DIR_ROUTE . 'recurring'; ?>" class="btn btn-white btn-icon" data-toggle="tooltip" title="<?php echo $lang['common']['text_back_to_list']; ?>"><i class="fa fa-reply"></i></a>
            </div>  
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group customer-search">
                        <label class="col-form-label"><?php echo $lang['common']['text_customer']; ?></label>
                        <div class="input-group">
                            <select class="selectpicker" name="invoice[customer]" data-width="100%" data-live-search="true" title="<?php echo $lang['common']['text_customer']; ?>" required>
                                <?php if (!empty($customers)) { foreach ($customers as $key => $value) { ?>
                                    <option value="<?php echo $value['id']; ?>" <?php if ($value['id'] == $result['customer']) { echo "selected"; } ?>><?php echo $value['company']; ?></option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="col-form-label"><?php echo $lang['invoices']['text_invoice_date']; ?></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="icon-calendar"></i></span>
                            </div>
                            <input type="text" name="invoice[inv_date]" class="form-control date" value="<?php echo date_format(date_create($result['inv_date']), 'd-m-Y'); ?>" placeholder="<?php echo $lang['invoices']['text_invoice_date']; ?>">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="col-form-label"><?php echo $lang['invoices']['text_repeat_every']; ?></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="icon-check"></i></span>
                            </div>
                            <select name="invoice[repeat_every]" class="custom-select" required>
                                <option value="1 Week" <?php if ($result['repeat_every'] == "1 Week") { echo "selected"; } ?>><?php echo $lang['invoices']['text_week']; ?></option>
                                <option value="2 Week" <?php if ($result['repeat_every'] == "2 Week") { echo "selected"; } ?>>2 <?php echo $lang['invoices']['text_weeks']; ?></option>
                                <option value="1 Month" <?php if ($result['repeat_every'] == "1 Month") { echo "selected"; } ?>><?php echo $lang['invoices']['text_month']; ?></option>
                                <option value="2 Month" <?php if ($result['repeat_every'] == "2 Month") { echo "selected"; } ?>>2 <?php echo $lang['invoices']['text_months']; ?></option>
                                <option value="3 Month" <?php if ($result['repeat_every'] == "3 Month") { echo "selected"; } ?>>3 <?php echo $lang['invoices']['text_months']; ?></option>
                                <option value="6 Month" <?php if ($result['repeat_every'] == "6 Month") { echo "selected"; } ?>>6 <?php echo $lang['invoices']['text_months']; ?></option>
                                <option value="1 Year" <?php if ($result['repeat_every'] == "1 Year") { echo "selected"; } ?>><?php echo $lang['invoices']['text_year']; ?></option>
                                <option value="2 Year" <?php if ($result['repeat_every'] == "2 Year") { echo "selected"; } ?>>2 <?php echo $lang['invoices']['text_years']; ?></option>
                                <option value="3 Year" <?php if ($result['repeat_every'] == "3 Year") { echo "selected"; } ?>>3 <?php echo $lang['invoices']['text_years']; ?></option>
                                <option value="6 Year" <?php if ($result['repeat_every'] == "6 Year") { echo "selected"; } ?>>6 <?php echo $lang['invoices']['text_years']; ?></option>
                            </select>
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
                        <label class="col-form-label"><?php echo $lang['invoices']['text_payment_method']; ?></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="icon-credit-card"></i></span>
                            </div>
                            <select name="invoice[paymenttype]" class="custom-select" required>
                                <option value=""><?php echo $lang['invoices']['text_payment_method']; ?></option>
                                <?php if ($payment_type) { foreach ($payment_type as $key => $value) { ?>
                                    <option value="<?php echo $value['id'] ?>" <?php if ($result['paymenttype'] == $value['id']) { echo "selected"; } ?>><?php echo $value['name']; ?></option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-form-label"><?php echo $lang['common']['text_status']; ?></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="icon-check"></i></span>
                            </div>
                            <select name="invoice[inv_status]" class="custom-select" required>
                                <option value="0" <?php if ($result['inv_status'] == "0") { echo "selected";} ?>><?php echo $lang['invoices']['text_draft']; ?></option>
                                <option value="1" <?php if ($result['inv_status'] == "1") { echo "selected";} ?>><?php echo $lang['invoices']['text_published']; ?></option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="invoice-items pt-3 pb-4">
                <table class="table-input">
                    <thead>
                        <tr>
                            <th><?php echo $lang['invoices']['text_item_name']; ?></th>
                            <th><?php echo $lang['invoices']['text_item_description']; ?></th>
                            <th><?php echo $lang['invoices']['text_quantity']; ?></th>
                            <th><?php echo $lang['invoices']['text_unit_cost']; ?></th>
                            <th><?php echo $lang['invoices']['text_tax']; ?></th>
                            <th><?php echo $lang['invoices']['text_price']; ?></th>
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
                                <td>
                                    <a class="badge badge-warning badge-sm badge-pill add-taxes m-1"><?php echo $lang['invoices']['text_add_taxes']; ?></a>
                                    <a class="badge badge-danger badge-sm badge-pill delete m-1"><?php echo $lang['common']['text_delete']; ?></a>
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
                                <td class="">
                                    <textarea type="text" name="invoice[item][0][quantity]" class="item-quantity">1</textarea>
                                </td>
                                <td class="">
                                    <textarea type="text" name="invoice[item][0][cost]" class="item-cost"></textarea>
                                </td>
                                <td class="invoice-tax">
                                    <input type="hidden" name="invoice[item][0][taxprice]" class="item-tax-price" value="0" readonly>
                                </td>
                                <td class="">
                                    <textarea type="text" name="invoice[item][0][price]" class="item-total-price" readonly></textarea>
                                    <input type="hidden" class="item-price">
                                </td>
                                <td>
                                    <a class="badge badge-warning badge-sm badge-pill add-taxes m-1"><?php echo $lang['invoices']['text_add_taxes']; ?></a>
                                    <a class="badge badge-danger badge-sm badge-pill delete m-1"><?php echo $lang['common']['text_delete']; ?></a>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="2" class="p-2">
                                <div class="add-items d-inline-block m-1">
                                    <a class="btn btn-success btn-sm"><i class="icon-plus mr-1"></i> <?php echo $lang['invoices']['text_add_item']; ?></a>
                                </div>
                            </td>
                            <td colspan="3" class="total-line">
                                <label><?php echo $lang['invoices']['text_sub_total']; ?></label>
                            </td>
                            <td colspan="2" class="total-value">
                                <input type="text" name="invoice[subtotal]" class="form-transparent sub-total" value="<?php echo $result['subtotal'] ?>" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="blank">
                            </td>
                            <td colspan="3" class="total-line">
                                <label><?php echo $lang['invoices']['text_tax']; ?></label>
                            </td>
                            <td colspan="2" class="total-value">
                                <input type="text" name="invoice[tax]" class="form-transparent tax-total" value="<?php echo $result['tax'] ?>" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="blank">
                            </td>
                            <td colspan="3" class="total-line">
                                <div class="row align-items-center">
                                    <div class="col-9"><label><?php echo $lang['invoices']['text_discount']; ?></label></div>
                                    <div class="col-3">
                                        <select name="invoice[discounttype]" class="form-control discount-type">
                                            <option value="1" <?php if ($result['discount_type'] == 1) { echo "selected"; } ?>>%</option>
                                            <option value="2" <?php if ($result['discount_type'] == 2) { echo "selected"; } ?>><?php echo $lang['invoices']['text_flat']; ?></option>
                                        </select>
                                    </div>
                                </div>
                            </td>
                            <td colspan="2" class="total-value">
                                <input type="text" name="invoice[discount]" class="form-transparent discount-total" value="<?php echo $result['discount'] ?>">
                                <input type="hidden" class="discount_amount" name="invoice[discount_value]"  value="<?php echo $result['discount_value'] ?>">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="blank">
                            </td>
                            <td colspan="3" class="total-line">
                                <label><?php echo $lang['invoices']['text_total']; ?></label>
                            </td>
                            <td colspan="2" class="total-value">
                                <input type="text" name="invoice[amount]" class="form-transparent  total-amount" value="<?php echo $result['amount'] ?>" readonly>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label><?php echo $lang['invoices']['text_customer_note']; ?></label>
                        <textarea class="form-control" name="invoice[note]"><?php if (!empty($result['id'])) { echo $result['note']; } else { echo $info['invoice_setting']['customernote']; } ?></textarea>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label><?php echo $lang['invoices']['text_terms_Conditions']; ?></label>
                        <textarea class="form-control" name="invoice[tc]" rows="3"><?php if (!empty($result['id'])) { echo $result['tc']; } else { echo $info['invoice_setting']['tc']; } ?></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label><?php echo $lang['invoices']['text_want_payment_info_on_invoice']; ?></label>
                        <div>
                            <div class="custom-control custom-radio custom-radio-1 d-inline-block">
                                <input type="radio" name="invoice[want_payment]" class="custom-control-input" value="1" id="paymentinfo-yes" <?php if ($result['want_payment'] == '1') { echo "checked"; } ?>>
                                <label class="custom-control-label" for="paymentinfo-yes"><?php echo $lang['invoices']['text_yes']; ?></label>
                            </div>
                            <div class="custom-control custom-radio custom-radio-1 d-inline-block">
                                <input type="radio" name="invoice[want_payment]" class="custom-control-input" value="0" id="paymentinfo-no" <?php if ($result['want_payment'] == '0') { echo "checked"; } ?>>
                                <label class="custom-control-label" for="paymentinfo-no"><?php echo $lang['invoices']['text_no']; ?></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label><?php echo $lang['invoices']['text_want_signature_on_invoice']; ?></label>
                        <div>
                            <div class="custom-control custom-radio custom-radio-1 d-inline-block">
                                <input type="radio" name="invoice[want_signature]" class="custom-control-input" value="1" id="signature-yes" <?php if ($result['want_signature'] == '1') { echo "checked"; } ?>>
                                <label class="custom-control-label" for="signature-yes"><?php echo $lang['invoices']['text_yes']; ?></label>
                            </div>
                            <div class="custom-control custom-radio custom-radio-1 d-inline-block">
                                <input type="radio" name="invoice[want_signature]" class="custom-control-input" value="0" id="signature-no" <?php if ($result['want_signature'] == '0') { echo "checked"; } ?>>
                                <label class="custom-control-label" for="signature-no"><?php echo $lang['invoices']['text_no']; ?></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <div class="row">
                <div class="col-12 text-center">
                    <button type="submit" name="submit" class="btn btn-primary btn-gradient btn-pill"><?php echo $lang['common']['text_save']; ?></button>
                </div>
            </div>
        </div>
        <!-- <input type="hidden" class="items" value="<?php echo htmlspecialchars(htmlspecialchars_decode(json_encode($items), JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8'); ?>"> -->
        <input type="hidden" name="id" value="<?php echo $result['id']; ?>">
        <input type="hidden" class="lang_add_tax" value="<?php echo $lang['invoices']['text_add_taxes']; ?>">
        <input type="hidden" class="lang_delete" value="<?php echo $lang['common']['text_delete']; ?>">
    </div>
</form>


<div class="modal fade" id="addTax">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo $lang['invoices']['text_tax']; ?></h5>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <?php if ($taxes) { foreach ($taxes as $key => $value) { ?>
                    <div class="custom-control custom-checkbox custom-checkbox-1 mb-3">
                        <input type="checkbox" class="custom-control-input" id="inv-taxes-<?php echo $value['id'] ?>" value="<?php echo $value['id'] ?>" data-rate="<?php echo $value['rate'] ?>" data-name="<?php echo $value['name'] ?>" name="modaltax">
                        <label class="custom-control-label" for="inv-taxes-<?php echo $value['id'] ?>"><?php echo $value['name'].' ('.$value['rate'].'%)'; ?></label>
                    </div>
                <?php } } ?>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-gradient btn-pill add-modal-taxes"><?php echo $lang['invoices']['text_add_taxes']; ?></button>
            </div>
        </div>
    </div>
</div>

<script src="public/js/invoice.js"></script>
<!-- Footer -->
<?php include (DIR.'app/views/common/footer.tpl.php'); ?>