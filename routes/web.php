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
Route::post('/api/thermo/', array('middleware' => 'cors', 'uses' => 'ApiController@receiveThermo'));


Route::get('/', 'HomeController@index')->name('home');

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

//route to change session var
Route::post('/client/addSessionVar/{id}','ClientController@addSessionVar');
Route::post('/client/deleteSessionVar','ClientController@deleteSessionVar');

//routes personalize Sections
Route::get('/frontoffice/personlizeSection','PersonalizeSectionController@getSection');
Route::post('/frontoffice/personalizeSection/save','PersonalizeSectionController@saveClientSection');
Route::get('/frontoffice/personalizeAreasEquipments','PersonalizeSectionController@getAreasEquipments');
Route::get('/frontoffice/personalizeAreasEquipments/personalizeEachSection/{id}','PersonalizeSectionController@personalizeEachSection');
Route::post('/frontoffice/personalizeAreasEquipments/personalizeEachSection/save','PersonalizeSectionController@saveEachSection');

//routes novo relatorio
Route::get('/frontoffice/newReport','ReportController@getReportCover');
Route::get('/frontoffice/newReportGeralRules','ReportController@getGeralRules');
                            

Route::group(['middleware' => ['backoffice']], function () {

    Route::get('/salesman', 'SalesmanController@index');
    Route::get('/salesman/{id}', 'SalesmanController@salesman');
    Route::get('/newsalesman', 'SalesmanController@newSales');
    Route::get('/salesman/deliver/{id}', 'SalesmanController@deliverSalesman');
    //Route::get('/salesman/new', 'ClientController@newSales');
    Route::post('/salesman/add', 'SalesmanController@addSales');
    Route::delete('/salesman/delete', 'SalesmanController@deleteSales');


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

});


