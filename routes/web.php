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
Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/frontoffice/client/edit/{id}', 'FrontofficeController@editClient');
Route::get('/frontoffice/client', 'FrontofficeController@showCustomer');
Route::post('/frontoffice/editclient/', 'FrontofficeController@postEditClient');
Route::get('/frontoffice/documents/', 'FrontofficeController@documents');
Route::get('/frontoffice/documents/{type}', 'FrontofficeController@documentsByType');
Route::get('/frontoffice/produtos/', 'FrontofficeController@products');
Route::any('/frontoffice/products/addcart/', 'FrontofficeController@addCart');
Route::get('/frontoffice/categories/', 'FrontofficeController@categories');
Route::get('/frontoffice/cart', 'FrontofficeController@showCart');
Route::get('/frontoffice/cart/process', 'FrontofficeController@processCart');
Route::get('/frontoffice/orders', 'FrontofficeController@orders');
Route::get('/frontoffice/orders/{id}', 'FrontofficeController@viewOrder');
Route::get('/frontoffice/products/{id}', 'FrontofficeController@productsByCategory');
Route::get('/frontoffice/cart/delete/{id}', 'FrontofficeController@deleteLineFromCart');
Route::get('/frontoffice/messages', 'FrontofficeController@messages');
Route::get('/frontoffice/cartValue', 'FrontofficeController@cartValue');
Route::get('/frontoffice/unreadMessages', 'ClientController@unreadMessages');
Route::post('/frontoffice/confirm/', 'FrontofficeController@confirmPayment');
Route::get('/home', 'ClientController@home');


Route::group(['middleware' => ['backoffice']], function () {



    Route::get('/clients', 'ClientController@index');
    Route::get('/clients/new', 'ClientController@newCustomer');
    Route::post('/clients/add', 'ClientController@addCustomer');
    Route::get('/clients/{id}', 'ClientController@showCustomer');
    Route::get('/clients/group/{id}', 'ClientController@clientsByGroup');
    Route::post('/clients/addreceipt', 'ClientController@addReceipt');

    Route::get('/salesman/new', 'ClientController@newSales');
    Route::post('/salesman/add', 'ClientController@addSales');

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
    Route::get('/products/new', 'ProductController@newProduct');
    Route::post('/products/add', 'ProductController@addProduct');
    Route::get('/products/{id}', 'ProductController@editProduct');
    Route::post('/products/edit', 'ProductController@editProductPost');


    Route::get('/orders', 'ProductController@showOrders');
    Route::get('/orders/{id}', 'ProductController@viewOrder');
    Route::get('/orders/process/{id}', 'ProductController@processOrder');
    Route::post('/orders/attachReceipt', 'ProductController@attachReceipt');



    Route::get('/messages/{id}', 'ProductController@messages');
    Route::post('/messages/new', 'ProductController@newMessage');
    Route::post('/messages/newmassmessage', 'ProductController@newMassMessage');



});


