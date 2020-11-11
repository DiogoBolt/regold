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

use App\Cart;
use App\Category;
use Illuminate\Support\Facades\View;

View::composer(/**
 * @param $view
 */
    'layouts.frontoffice', function($view){
    $view->with('categories', Category::all());
});

Route::post('/api/confirm/', 'ApiController@confirmPayment');


Route::get('/', 'HomeController@index')->name('home');
Route::get('/duvidascovid', 'HomeController@duvidascovid')->name('covid');


Auth::routes(['register' => false]);

Route::get('/frontoffice/client/edit/{id}', 'FrontofficeController@editClient');
Route::get('/frontoffice/client', 'FrontofficeController@showCustomer');
Route::post('/frontoffice/editclient/', 'FrontofficeController@postEditClient');
Route::get('/frontoffice/documents/', 'FrontofficeController@documents');
Route::get('/frontoffice/documents/{type}', 'FrontofficeController@documentsBySuper');
Route::get('/frontoffice/documents/{super}/{type}', 'FrontofficeController@documentsByType');
Route::get('/frontoffice/produtos/', 'FrontofficeController@products');
Route::any('/frontoffice/products/addcart/', 'FrontofficeController@addCart');
Route::get('/frontoffice/produtos/search/{keyword}', 'FrontofficeController@productsSearch');
Route::get('/frontoffice/categories/', 'FrontofficeController@categories');
Route::get('/frontoffice/cart', 'FrontofficeController@showCart');
Route::post('/frontoffice/cart/removeitem', 'FrontofficeController@removeItem');
Route::get('/frontoffice/cart/process', 'FrontofficeController@processCart');
Route::get('/frontoffice/orders', 'FrontofficeController@orders');
Route::get('/frontoffice/orders/{id}', 'FrontofficeController@viewOrder');
Route::get('/frontoffice/products/{id}', 'FrontofficeController@productsByCategory');
Route::get('/frontoffice/product/{id}', 'FrontofficeController@productById');
Route::get('/frontoffice/favorites', 'FavoriteController@getFavorites');
Route::get('/frontoffice/favorites/add/{id}', 'FavoriteController@addFavorite');
Route::get('/frontoffice/favorites/delete/{id}', 'FavoriteController@deleteFavorite');
Route::get('/frontoffice/cart/delete/{id}', 'FrontofficeController@deleteLineFromCart');
Route::get('/frontoffice/messages', 'FrontofficeController@messages');
Route::get('/frontoffice/cartValue', 'FrontofficeController@cartValue');
Route::get('/frontoffice/unreadMessages', 'ClientController@unreadMessages');
Route::get('/frontoffice/invoices', 'FrontofficeController@invoices')->name('invoices');
Route::get('/frontoffice/firstlogin', 'ClientController@checkFirstLogin');
Route::post('/frontoffice/changePassword', 'ClientController@changePassword');
Route::get('/home', 'ClientController@home');

//Thermos
Route::get('/frontoffice/thermo', 'ThermoController@index');
Route::post('/thermo/attachthermo', 'ThermoController@attachThermo');
Route::delete('/thermo/deletethermo', 'ThermoController@deleteThermo');
Route::get('/thermo/getTemperature/{imei}', 'ThermoController@getTemperature');

//route to change session var
Route::post('/client/addSessionVar/{id}','ClientController@addSessionVar');
Route::post('/client/deleteSessionVar','ClientController@deleteSessionVar');

//routes personalize Sections
Route::get('/frontoffice/personalizeSection','PersonalizeSectionController@getSection');
Route::post('/frontoffice/personalizeSection/save','PersonalizeSectionController@saveClientSection');
Route::get('/frontoffice/personalizeAreasEquipments','PersonalizeSectionController@getAreasEquipments');
Route::get('/frontoffice/personalizeAreasEquipments/personalizeEachSection/{id}','PersonalizeSectionController@personalizeEachSection');
Route::post('/frontoffice/personalizeAreasEquipments/personalizeEachSection/save','PersonalizeSectionController@saveEachSection');


//routes novo relatorio
Route::get('/frontoffice/newReport','ReportController@getReportCover');
Route::get('/frontoffice/newReportRules/{id}','ReportController@getRules');
Route::get('/frontoffice/newReportSections','ReportController@getClientSection');
Route::get('/frontoffice/forgetSession','ReportController@forgetSessionVar');
Route::post('/frontoffice/addSection/{id}','ReportController@addSectionReport');
Route::post('/frontoffice/saveAnswers','ReportController@saveAnswers');
Route::post('/frontoffice/saveReport/{visitNumber}','ReportController@saveReport');
Route::get('/concluedReport','ReportController@concludeReport');
Route::get('/frontoffice/reports','ReportController@reportList');
Route::get('/frontoffice/reportShow/{idReport}','ReportController@reportShow');

//routes Relatorio CONTROLO DE PRAGAS
Route::get('/frontoffice/firstService','PestController@firstService');
Route::post('/frontoffice/savefirstService','PestController@savefirstService');
Route::get('/frontoffice/newDevice','PestController@newDevice');
Route::post('/frontoffice/addDevice','PestController@addDevice');
Route::get('/frontoffice/pestReports','PestController@pestReportList');
Route::get('/frontoffice/reportPestShow/{id}','PestController@reportPestShow');
Route::get('/frontoffice/reportMaintenanceShow/{idReport}','PestController@reportMaintenanceShow');
Route::get('/frontoffice/maintenance','PestController@maintenancePest');
Route::post('/frontoffice/saveMaintenance','PestController@saveMaintenance');
Route::get('/frontoffice/deviceMaintenance/{id}','PestController@getDeviceMaintenance');
Route::post('/frontoffice/saveDeviceMaintenance/{id}','PestController@saveDeviceMaintenance');
Route::get('/frontoffice/punctual','PestController@punctualPest');
Route::post('/frontoffice/savePunctual','PestController@savePunctualPest');
Route::get('/frontoffice/reportPunctualShow/{id}','PestController@reportPunctualShow');
Route::get('/frontoffice/warranty','PestController@warrantyPest');
Route::post('/frontoffice/saveWarranty','PestController@saveWarrantyPest');
Route::get('frontoffice/reportWarrantyShow/{id}','PestController@reportWarrantyShow');
Route::get('/frontoffice/deviceWarranty/{id}','PestController@getDeviceWarranty');
Route::post('/frontoffice/saveDeviceWarranty/{id}','PestController@saveDeviceWarranty');

Route::get('/frontoffice/verifyPin/{id}/{pin}','PestController@verifyPin');

//relatório pontual de cliente nao criado na plataforma
Route::get('/frontoffice/reports/punctualList','PestController@getList');
Route::get('/frontoffice/report/punctual','PestController@punctualData');
Route::post('/frontoffice/report/savePunctual','PestController@savePunctualData');
Route::get('/frontoffice/report/punctualData/{id}','PestController@punctualDataShow');

Route::get('/frontoffice/verifyCodeDeviceExist/{id}/{code}','PestController@verifyCodeDeviceExist');

//routes Registos
Route::get('/frontoffice/insertProductConformities', 'RecordsController@insertConformities');
Route::post('/frontoffice/saveOilRecords', 'RecordsController@saveOilRecords');
Route::get('/frontoffice/oilRecords','RecordsController@insertOilRecords');

Route::get('/frontoffice/records/oil/history','RecordsController@getOilRecordsHistory');
Route::get('/frontoffice/records/oil/history/get','RecordsController@getHistByMonth');
Route::get('/frontoffice/records/oil/history/print','RecordsController@printReportOil');


Route::get('/frontoffice/records/temperatures','RecordsController@getTemperatureRecords');
Route::get('/frontoffice/records/temperatures/history','RecordsController@getTemperatureRecordsHistory');
Route::get('/frontoffice/records/temperatures/history/get','RecordsController@getHistoryByMonth');
Route::post('/frontoffice/records/temperatures/history/comment','RecordsController@saveComment');
Route::get('/frontoffice/records/temperatures/history/print','RecordsController@printReport');
Route::post('/frontoffice/thermos/editvalue/','RecordsController@editThermoTemperature');

Route::get('/frontoffice/records/hygiene','RecordsController@getHygieneRecords');
Route::get('/frontoffice/getlastreads/{id}', 'RecordsController@getLast5Temperatures');

//estatisticas route
Route::get('/frontoffice/statistics','ReportController@reportStatistics');


Route::group(['middleware' => ['backoffice']], function () {

    Route::get('/salesman', 'SalesmanController@index');
    Route::get('/salesman/{id}', 'SalesmanController@salesman');
    Route::get('/newsalesman', 'SalesmanController@newSales');
    Route::get('/salesman/deliver/{id}', 'SalesmanController@deliverSalesman');
    //Route::get('/salesman/new', 'ClientController@newSales');
    Route::post('/salesman/add', 'SalesmanController@addSales');
    Route::delete('/salesman/delete', 'SalesmanController@deleteSales');

    Route::get('/clients/regolfood', 'ClientController@indexRegolfood');
    Route::post('/schedule/regolfood/save/{id}','ClientController@saveScheduleRegolfood');
    Route::get('/clients/regolpest', 'ClientController@indexRegolpest');
    Route::get('/schedule','ClientController@getSchedule');


    Route::get('/clients', 'ClientController@index');
    Route::get('/clients/new', 'ClientController@newCustomer');
    Route::post('/clients/add', 'ClientController@addCustomer');
    Route::delete('/clients/delete', 'ClientController@deleteCustomer');
    Route::get('/clients/{id}', 'ClientController@showCustomer');
    Route::get('/clients/edit/{id}', 'ClientController@editCustomer');
    Route::post('/clients/edit', 'ClientController@editCustomerPost');
    Route::get('/clients/group/{id}', 'ClientController@clientsByGroup');
    Route::post('/clients/addreceipt', 'ClientController@addReceipt');
    Route::get('/clients/impersonate/{id}', 'ClientController@impersonateClient');
    Route::get('/clients/editPrices/{id}', 'ClientController@editClientPrices');
    Route::post('/editpricepvp/', 'ClientController@editClientPvp');
    Route::get('/impersonate/leaveuser', 'ClientController@leaveUser');
    //pedro                             
    Route::get('/users/getCities/{id}','ClientController@getCitiesByDistrict');
    Route::get('/users/verifyEmailExist/{email}','ClientController@verifyEmailExist');
    Route::get('/users/getParish/{postalCode}','ClientController@getParishbyPostalCode');


    Route::get('/groups', 'ClientController@groups');
    Route::get('/groups/new', 'ClientController@newGroup');
    Route::get('/groups/{id}', 'ClientController@editGroup');
    Route::post('/groups/edit', 'ClientController@editGroupPost');
    Route::post('/groups/processgroup/{id}', 'ClientController@processGroup');

    Route::get('/documents', 'ClientController@documentTypes');
    Route::get('/documents/new', 'ClientController@newDocumentType');
    Route::post('/documents/add', 'ClientController@addDocument');
    Route::get('/documents/{id}', 'ClientController@showDocument');
    Route::post('/documents/edit', 'ClientController@editDocument');
    Route::get('/documents/delete/{id}', 'ClientController@deleteDocumentType');

    Route::get('/categories', 'ClientController@categories');
    Route::get('/categories/new', 'ClientController@newCategory');
    Route::post('/categories/add', 'ClientController@addCategory');
    Route::get('/categories/{id}', 'ClientController@showCategory');
    Route::post('/categories/edit', 'ClientController@editCategory');
    Route::get('/categories/delete/{id}', 'ClientController@deleteCategory');

    Route::get('/products', 'ProductController@index');
    Route::get('/products/{id}', 'ProductController@productsByCategory');
    Route::get('/newproduct', 'ProductController@newProduct');
    Route::post('/products/add', 'ProductController@addProduct');
    Route::get('/products/{cat}/{id}', 'ProductController@editProduct');
    Route::delete('/products/delete', 'ProductController@deleteProduct');
    Route::post('/products/edit', 'ProductController@editProductPost');
    /*luis*/
    route::get('/billing','ProductController@showBilling');


    Route::get('/orders', 'ProductController@showOrders');
    Route::get('/processedOrders', 'ProductController@showProcessedOrders');
    Route::get('/unpaidOrders/{id}', 'ProductController@showOrdersByClient');
    Route::get('/historyOrders', 'ProductController@showHistoryOrders');
    Route::get('/orders/{id}', 'ProductController@viewOrder');
    Route::get('/orders/process/{id}', 'ProductController@processOrder');
    Route::get('/order/print/{id}', 'ProductController@printOrder');
    Route::get('/order/printOrders', 'ProductController@printOrders');
    Route::post('/orders/attachReceipt', 'ProductController@attachReceipt');
    Route::post('/orders/attachInvoice', 'ProductController@attachInvoice');
    Route::get('/orders/pay/{id}', 'ProductController@payOrder');
    Route::get('/orders/unpay/{id}', 'ProductController@unPayOrder');
    Route::post('/orders/semipay', 'ProductController@semiPayOrder');
    Route::get('/orders/filter/q', 'ProductController@filterOrders');
    Route::get('/processedOrders/filter', 'ProductController@filterProcessedOrders');


    Route::get('/messages/{id}', 'ProductController@messages');
    Route::post('/messages/new', 'ProductController@newMessage');
    Route::post('/messages/newmassmessage', 'ProductController@newMassMessage');


    // Apaga isto depois Diogo
    Route::get('/runcron', function() {
        \Illuminate\Support\Facades\Artisan::call('update:temperatures');
    });
});


