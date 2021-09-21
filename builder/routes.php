<?php
$router->get('login', 'LoginController@index@2');
$router->post('login', 'LoginController@login@2');
$router->get('forgot', 'LoginController@indexForgot@2');
$router->post('forgot', 'LoginController@forgot@2');
$router->get('reset', 'LoginController@resetPassword@2');
$router->post('reset', 'LoginController@resetPasswordAction@2');
$router->get('logout', 'LoginController@logout@2');
$router->get('dashboard', 'DashboardController@index@2');

$router->get('closetab', 'CommonsController@indexCloseTab@2');

$router->get('user', 'UserController@index@2');
$router->get('user/edit', 'UserController@indexEdit@2');
$router->get('user/add', 'UserController@indexAdd@2');
$router->post('user/action', 'UserController@indexAction@2');
$router->post('user/delete', 'UserController@indexDelete@2');


$router->get('role', 'UserController@userRole@2');
$router->get('role/add', 'UserController@userRoleAdd@2');
$router->get('role/edit', 'UserController@userRoleEdit@2');
$router->post('role/action', 'UserController@userRoleAction@2');
$router->post('role/delete', 'UserController@userRoleDelete@2');

$router->get('profile', 'ProfileController@index@2');
$router->post('profile/action', 'ProfileController@indexAction@2');
$router->post('profile/password', 'ProfileController@indexPassword@2');

$router->get('invoices', 'InvoiceController@index@2');
$router->get('invoice/view', 'InvoiceController@indexView@2');
$router->get('invoice/pdf', 'InvoiceController@indexPdf@2');
$router->get('invoice/print', 'InvoiceController@indexPrint@2');
$router->get('invoice/add', 'InvoiceController@indexAdd@2');
$router->get('invoice/edit', 'InvoiceController@indexEdit@2');
$router->post('invoice/action', 'InvoiceController@indexAction@2');
$router->post('invoice/delete', 'InvoiceController@indexDelete@2');
$router->post('invoice/sentmail', 'InvoiceController@indexMail@2');
$router->get('invoice/items', 'InvoiceController@indexItems@2');


$router->get('recurring', 'RecurringController@index@2');
$router->get('recurring/view', 'RecurringController@indexView@2');
$router->get('recurring/pdf', 'RecurringController@indexPdf@2');
$router->get('recurring/print', 'RecurringController@indexPrint@2');
$router->get('recurring/add', 'RecurringController@indexAdd@2');
$router->get('recurring/edit', 'RecurringController@indexEdit@2');
$router->post('recurring/action', 'RecurringController@indexAction@2');
$router->post('recurring/delete', 'RecurringController@indexDelete@2');
$router->post('recurring/sentmail', 'RecurringController@indexMail@2');

$router->get('recurringjob', 'RecurringjobController@index@2');

$router->get('expenses', 'ExpenseController@index@2');
$router->get('expense/add', 'ExpenseController@indexAdd@2');
$router->get('expense/edit', 'ExpenseController@indexEdit@2');
$router->post('expense/action', 'ExpenseController@indexAction@2');
$router->post('expense/delete', 'ExpenseController@indexDelete@2');

$router->get('domains', 'DomainController@index@2');
$router->get('domain/add', 'DomainController@indexAdd@2');
$router->get('domain/edit', 'DomainController@indexEdit@2');
$router->post('domain/action', 'DomainController@indexAction@2');
$router->post('domain/delete', 'DomainController@indexDelete@2');

$router->get('tickets', 'TicketController@index@2');
$router->get('ticket/add', 'TicketController@indexAdd@2');
$router->get('ticket/edit', 'TicketController@indexEdit@2');
$router->get('ticket/fileDownload', 'TicketController@downloadFile@2');
$router->post('ticket/action', 'TicketController@indexAction@2');
$router->post('ticket/delete', 'TicketController@indexDelete@2');

$router->get('quotes', 'QuoteController@index@2');
$router->get('quote/view', 'QuoteController@indexView@2');
$router->get('quote/print', 'QuoteController@indexPrint@2');
$router->get('quote/pdf', 'QuoteController@indexPdf@2');
$router->get('quote/autoinvoice', 'InvoiceController@indexAutoInvoice@2');
$router->get('quote/add', 'QuoteController@indexAdd@2');
$router->get('quote/edit', 'QuoteController@indexEdit@2');
$router->post('quote/action', 'QuoteController@indexAction@2');
$router->post('quote/delete', 'QuoteController@indexDelete@2');

$router->get('contacts', 'ContactController@index@2');
$router->get('contact/view', 'ContactController@indexView@2');
$router->get('contact/add', 'ContactController@indexAdd@2');
$router->get('contact/edit', 'ContactController@indexEdit@2');
$router->post('contact/action', 'ContactController@indexAction@2');
$router->post('contact/delete', 'ContactController@indexDelete@2');
$router->post('contact/sentmail', 'ContactController@indexMail@2');
$router->post('contact/import', 'ContactController@indexImport@2');
$router->get('contact/sample', 'ContactController@indexSmapleDownload@2');

$router->get('leads', 'LeadController@index@2');
$router->get('lead/add', 'LeadController@indexAdd@2');
$router->get('lead/edit', 'LeadController@indexEdit@2');
$router->post('lead/action', 'LeadController@indexAction@2');
$router->post('lead/action_assign', 'LeadController@assign_user@2');

$router->post('lead/delete', 'LeadController@indexDelete@2');
$router->get('lead/convert', 'LeadController@convertLead@2');

$router->get('reports/income', 'ReportController@incomeReport@2');

$router->get('clients', 'ContactController@indexClients@2');
$router->get('client/edit', 'ContactController@indexClientEdit@2');
$router->post('client/action', 'ContactController@indexClientAction@2');
$router->post('client/delete', 'ContactController@indexClientDelete@2');

$router->get('webclients', 'WebClientsController@Index@2');
$router->get('webclients/add', 'WebClientsController@IndexAdd@2');
$router->get('webclients/form', 'WebClientsController@IndexEdit@2');
$router->post('webclient/action', 'WebClientsController@IndexAction@2');
$router->post('webclients/delete', 'WebClientsController@IndexDelete@2');

$router->get('calendar', 'CalendarController@index@2');
$router->post('calendar/drop', 'CalendarController@indexDrop@2');
$router->post('calendar/action', 'CalendarController@indexAction@2');
$router->post('calendar/delete', 'CalendarController@indexDelete@2');

$router->get('items', 'ItemsController@index@2');
$router->get('item/add', 'ItemsController@indexAdd@2');
$router->get('item/edit', 'ItemsController@indexEdit@2');
$router->post('item/action', 'ItemsController@indexAction@2');
$router->post('item/delete', 'ItemsController@indexDelete@2');

$router->get('taxes', 'TaxController@index@2');
$router->post('tax/action', 'TaxController@indexAction@2');
$router->post('tax/delete', 'TaxController@indexDelete@2');

$router->get('departments', 'TypesController@departments@2');
$router->post('department/action', 'TypesController@departmentAction@2');
$router->post('department/delete', 'TypesController@departmentDelete@2');

$router->get('paymenttype', 'TypesController@paymentType@2');
$router->post('paymenttype/action', 'TypesController@paymentTypeAction@2');
$router->post('paymenttype/delete', 'TypesController@paymentTypeDelete@2');

$router->get('paymentgateway', 'TypesController@paymentGateway@2');
$router->post('paymentgateway/action', 'TypesController@paymentGatewayAction@2');

$router->get('currency', 'TypesController@currency@2');
$router->post('currency/action', 'TypesController@currencyAction@2');
$router->post('currency/delete', 'TypesController@currencyDelete@2');

$router->get('expensetype', 'TypesController@expenseType@2');
$router->post('expensetype/action', 'TypesController@expenseTypeAction@2');
$router->post('expensetype/delete', 'TypesController@expenseTypeDelete@2');

$router->get('projects', 'ProjectController@index@2');
$router->get('project/add', 'ProjectController@indexAdd@2');
$router->get('project/edit', 'ProjectController@indexEdit@2');
$router->post('project/action', 'ProjectController@indexAction@2');
$router->post('project/delete', 'ProjectController@indexDelete@2');
$router->post('project/assign/staff', 'ProjectController@AssignStaff@2');

$router->post('make_comment', 'ProjectController@makeComment@2');

$router->get('notes', 'NoteController@index@2');
$router->get('note/add', 'NoteController@indexAdd@2');
$router->get('note/edit', 'NoteController@indexEdit@2');
$router->post('note/action', 'NoteController@indexAction@2');
$router->post('note/delete', 'NoteController@indexDelete@2');

$router->get('info', 'InfoController@index@2');
$router->post('info/action', 'InfoController@indexAction@2');

$router->get('customization', 'InfoController@customization@2');
$router->post('customization/action', 'InfoController@customizationAction@2');

$router->post('upload', 'UploadController@index@2');
$router->post('upload/delete', 'UploadController@indexDelete@2');
$router->post('attachFile', 'UploadController@attachFile@2');
$router->post('attachFile/delete', 'UploadController@deleteAttachedFiles@2');

$router->get('subscriber', 'SubscriberController@index@2');
$router->get('subscriber/edit', 'SubscriberController@indexEdit@2');
$router->get('subscriber/add', 'SubscriberController@indexAdd@2');
$router->post('subscriber/action', 'SubscriberController@indexAction@2');
$router->post('subscriber/delete', 'SubscriberController@indexDelete@2');

$router->post('invoicePayment/action', 'PaymentController@invoicePayment@2');

$router->get('emailtemplate', 'TemplateController@index@2');
$router->post('emailtemplate/action', 'TemplateController@indexAction@2');

$router->get('emaillog', 'UtilitiesController@emailLog@2');
$router->get('cronlog', 'UtilitiesController@cronLog@2');

$router->get('setting', 'SettingController@index@2');
$router->post('setting/action', 'SettingController@indexAction@2');

$router->get('dbbackup', 'SettingController@databaseBackup@2');
$router->get('dbbackup/download', 'SettingController@dbBackupDownload@2');


// API'S
$router->post('leadform_api_submit', 'ApiController@leadform_api_submit@2');

$router->get('leadform_api', 'ApiController@leadform_api@2');
$router->post('ProjectApi', 'ApiController@ProjectApi@2');
$router->post('LeadApi', 'ApiController@LeadApi@2');
$router->post('orderApi', 'ApiController@orderApi@2');
$router->post('paymentApi', 'ApiController@paymentDetails@2');
