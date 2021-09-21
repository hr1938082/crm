<?php
$router->get('login', 'LoginController@index@2');
$router->post('login', 'LoginController@login@2');

$router->get('register', 'LoginController@indexRegister@2');
$router->post('register', 'LoginController@register@2');

$router->get('forgot', 'LoginController@indexForgot@2');
$router->post('forgot', 'LoginController@forgot@2');

$router->get('reset', 'LoginController@resetPassword@2');
$router->post('reset', 'LoginController@resetPasswordAction@2');

$router->get('logout', 'LoginController@logout@2');

$router->get('dashboard', 'DashboardController@index@2');

$router->get('profile', 'ProfileController@index@2');
$router->post('profile', 'ProfileController@profileAction@2');
$router->get('changepassword', 'ProfileController@indexChangePassword@2');
$router->post('changePassword', 'ProfileController@changePasswordAction@2');


$router->get('invoices', 'InvoiceController@index@2');
$router->get('invoice/view', 'InvoiceController@indexView@2');
$router->get('invoice/pdf', 'InvoiceController@indexPdf@2');
$router->get('invoice/print', 'InvoiceController@indexPrint@2');

$router->get('quotes', 'QuoteController@index@2');
$router->get('quote/view', 'QuoteController@indexView@2');
$router->get('quote/print', 'QuoteController@indexPrint@2');
$router->get('quote/pdf', 'QuoteController@indexPdf@2');
$router->post('convertquote', 'QuoteController@indexAutoInvoice@2');

$router->get('tickets', 'TicketController@index@2');
$router->get('ticket/add', 'TicketController@indexAdd@2');
$router->get('ticket/edit', 'TicketController@indexEdit@2');
$router->post('ticket/action', 'TicketController@indexAction@2');
$router->get('ticket/fileDownload', 'TicketController@downloadFile@2');


$router->get('info', 'InfoController@index@2');
$router->post('info/action', 'InfoController@indexAction@2');


$router->post('upload', 'UploadController@index@3');
$router->post('upload/delete', 'UploadController@indexDelete@3');
$router->post('attachFile', 'UploadController@attachFile@3');
$router->post('attachFile/delete', 'UploadController@deleteAttachedFiles@3');

$router->get('makepayment', 'PaymentController@makePayment');
$router->get('cancel', 'PaymentController@cancelPayment');
$router->post('successpayment', 'PaymentController@successPayment');
$router->get('success', 'PaymentController@success');

$router->get('closetab', 'CommonsController@indexCloseTab');