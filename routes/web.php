<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'PharmaController@HomeView');
Route::get('/home', 'PharmaController@HomeView');

Route::get('/main_categories', 'PharmaController@MainCategoryView');
Route::get('/sub_categories', 'PharmaController@SubCategoryView');
Route::get('/drugs_list', 'PharmaController@DrugView');

Route::post('/scrape_main_categories', 'PharmaController@ScrapeMainCategory');
Route::post('/scrape_sub_categories', 'PharmaController@ScrapeSubCategory');
Route::post('/scrape_drugs_list', 'PharmaController@ScrapeDrug');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//====================Filter Routes====================
Route::prefix('filter')->group(function() {
	Route::get('/customers/{ind}/{id}', 'HomeController@customerFilterView')->name('customer.filter')->where(['ind'=>'[0-9]+','id'=>'[0-9]+']);
	Route::get('/products/{ind}/{id}', 'HomeController@productFilterView')->name('product.filter')->where(['ind'=>'[0-9]+','id'=>'[0-9]+']);
});
//====================End of Filter Routes=============

Route::post('/select_customer/{ind}/{id}', 'HomeController@selectCustomer')->name('customer.select')->where(['ind'=>'[0-9]+','id'=>'[0-9]+']);
Route::get('/tabs_view/{ind}/{id?}', 'HomeController@tabsView')->name('tabs.view')->where(['ind'=>'[0-9]+','id'=>'[0-9]+']);
Route::get('/print_view/{ind}/{id?}', 'HomeController@printView')->name('print.view')->where(['ind'=>'[0-9]+','id'=>'[0-9]+']);
//====================Item Routes====================
Route::prefix('item')->group(function() {
	Route::post('/add', 'HomeController@addItems')->name('item.add')->where(['ind'=>'[0-9]+','id'=>'[0-9]+']);
	Route::post('/save', 'HomeController@saveItem')->name('item.save');
	Route::post('/delete', 'HomeController@deleteItem')->name('item.delete');
	Route::post('/moveup', 'HomeController@moveupItem')->name('item.moveup');
	Route::post('/movedown', 'HomeController@movedownItem')->name('item.movedown');
});
//====================End of Item Routes=============

//====================Invoice Routes====================
Route::prefix('invoice')->group(function() {
	Route::get('/index', 'HomeController@invoiceList')->name('invoice.index');
	Route::get('/recurring_index', 'HomeController@recurringInvoiceList')->name('recurring.index');
	Route::post('/invoice_view', 'HomeController@newInvoiceView')->name('invoice.new');
	Route::post('/invoice_recurring', 'HomeController@newInvoiceRecurring')->name('invoice.recurring');
	Route::get('/invoice_view/{id}', 'HomeController@addInvoiceView')->name('invoice.view')->where(['id'=>'[0-9]+']);
	Route::post('/save_invoice', 'HomeController@saveInvoice')->name('invoice.save');
	Route::post('/delete_invoices', 'HomeController@deleteInvoices')->name('invoice.delete');
	Route::post('/add_payment', 'HomeController@addPayment')->name('invoice.pay');
});
//====================End of Invoice Routes=============

//====================Order Routes====================
Route::prefix('order')->group(function() {
	Route::get('/index', 'HomeController@orderList')->name('order.index');
	Route::post('/order_view', 'HomeController@newOrderView')->name('order.new');
	Route::get('/order_view/{id}', 'HomeController@addOrderView')->name('order.view')->where(['id'=>'[0-9]+']);
	Route::post('/save_order', 'HomeController@saveOrder')->name('order.save');
	Route::post('/delete_orders', 'HomeController@deleteOrders')->name('order.delete');
	Route::post('/invoice', 'HomeController@convertOrderToInvoice')->name('order.invoice');
});
//====================End of Order Routes=============

//====================Estimate Routes====================
Route::prefix('estimate')->group(function() {
	Route::get('/index', 'HomeController@estimateList')->name('estimate.index');
	Route::post('/estimate_view', 'HomeController@newEstimateView')->name('estimate.new');
	Route::get('/estimate_view/{id}', 'HomeController@addEstimateView')->name('estimate.view')->where(['id'=>'[0-9]+']);
	Route::post('/save_estimate', 'HomeController@saveEstimate')->name('estimate.save');
	Route::post('/delete_estimates', 'HomeController@deleteEstimates')->name('estimate.delete');
	Route::post('/invoice', 'HomeController@convertEstimateToInvoice')->name('estimate.invoice');
});
//====================End of Estimate Routes=============

//====================POrder Routes====================
Route::prefix('porder')->group(function() {
	Route::get('/index', 'HomeController@porderList')->name('porder.index');
	Route::post('/porder_view', 'HomeController@newPorderView')->name('porder.new');
	Route::get('/porder_view/{id}', 'HomeController@addPorderView')->name('porder.view')->where(['id'=>'[0-9]+']);
	Route::post('/save_porder', 'HomeController@savePorder')->name('porder.save');
	Route::post('/delete_porders', 'HomeController@deletePorders')->name('porder.delete');
});
//====================End of POrder Routes=============

//====================Expense Routes====================
Route::prefix('expense')->group(function() {
	Route::get('/index', 'HomeController@expenseList')->name('expense.index');
	Route::get('/expense_view/{id?}', 'HomeController@addExpenseView')->name('expense.view');
	Route::post('/save_expense', 'HomeController@saveExpense')->name('expense.save');
	Route::post('/delete_expense', 'HomeController@deleteExpenses')->name('expense.delete');
});
//====================End of Expense Routes=============

//====================Customer Routes====================
Route::prefix('customer')->group(function() {
	Route::get('/index', 'HomeController@customerList')->name('customer.index');
	Route::get('/customer_view/{id?}', 'HomeController@addCustomerView')->name('customer.view');
	Route::post('/save_customer', 'HomeController@saveCustomer')->name('customer.save');
	Route::post('/delete_customer', 'HomeController@deleteCustomers')->name('customer.delete');
	Route::get('/tabs_view/{id?}', 'HomeController@ctabsView')->name('ctabs.view')->where(['id'=>'[0-9]+']);
});
//====================End of Customer Routes=============

//====================Product Routes====================
Route::prefix('product')->group(function() {
	Route::get('/index', 'HomeController@productList')->name('product.index');
	Route::get('/product_view/{id?}', 'HomeController@addProductView')->name('product.view');
	Route::post('/save_product', 'HomeController@saveProduct')->name('product.save');
	Route::post('/delete_product', 'HomeController@deleteProducts')->name('product.delete');
});
//====================End of Product Routes=============

//====================Reports Routes====================
Route::prefix('reports')->group(function() {
	Route::get('/index/{id?}', 'HomeController@reportsView')->name('reports.index');
	// Route::get('/recurring_index', 'HomeController@recurringList')->name('recurring.index');
	Route::get('/usage_report', 'UserController@usageReportView')->name('c.user.usage_report.view');
	Route::get('/recharge_offers', 'UserController@rechargeOffersView')->name('c.user.recharge_offers.view');
	Route::post('/recharge', 'UserController@recharge')->name('c.user.recharge');
	Route::post('/payment/status', 'UserController@paymentCallback')->name('c.payment.callback');
	Route::get('/payment/status/{id}', 'UserController@statusCheck')->name('c.recharge.status')->where(['id'=>'[0-9]+']);
	Route::get('/payment/refund/{id}', 'UserController@refund')->name('c.refund.payment')->where(['id'=>'[0-9]+']);
	Route::get('/payment/refund_status/{id}', 'UserController@refundStatus')->name('c.refund.status')->where(['id'=>'[0-9]+']);
	Route::get('/recharge_history', 'UserController@rechargeHistoryView')->name('c.user.recharge_history.view');
});
//====================End of Reports Routes=============

//====================Settings Routes====================
Route::prefix('settings')->group(function() {
	Route::get('/index/{id?}', 'HomeController@settingsView')->name('settings.index');
	Route::post('/save_extra_cost', 'HomeController@saveExtraCost')->name('settings.extra');
	Route::delete('/delete_extra_cost', 'HomeController@deleteExtraCost')->name('settings.extra.delete');
	Route::post('/save_hfooter_text', 'HomeController@saveHfooterText')->name('settings.hftext');
	Route::delete('/delete_hfooter_text', 'HomeController@deleteHfooterText')->name('settings.hftext.delete');
	Route::post('/save_payment_terms', 'HomeController@savePaymentTerm')->name('settings.pterm');
	Route::delete('/delete_payment_terms', 'HomeController@deletePaymentTerm')->name('settings.pterm.delete');
	Route::post('/save_company_settings', 'HomeController@saveCompanySettings')->name('settings.company');
	Route::post('/save_report_labels', 'HomeController@saveReportLabels')->name('settings.labels');
});
//====================End of Settings Routes=============