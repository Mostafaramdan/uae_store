<?php
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\dashboard as dashboardMiddleWare;
route::post('/login','authentication@login')->name('dashboard.login');
route::get('/login','authentication@index')->name('dashboard.login.index');
route::get('/logout','authentication@logout')->name('dashboard.logout');
route::get('changeLang','general@changeLang')->name('dashboard.changeLang');

Route::group(['middleware' => [dashboardMiddleWare::class]], function () 
{
       route::get('categoriesByStore/{id}','general@categoriesByStore')->name('dashboard.categoriesByStore.index');
       route::get('searchFor/{model}/{col}/{search}','general@searchFor')->name('dashboard.searchFor.search');
       route::get('searchFor/{model}/{col}/','general@searchFor')->name('dashboard.searchFor.search');

       route::get('statistics','statistics@index')->name('dashboard.statistics.index');
       route::post('statistics/getByDateRange','statistics@getByDateRange')->name('dashboard.statistics.getByDateRange');
       route::post('statistics','statistics@indexPageing')->name('dashboard.statistics.indexPageing');

       route::get('users','users@index')->name('dashboard.users.index');
       route::post('users/createUpdate','users@createUpdate')->name('dashboard.users.createUpdate');
       route::post('users','users@indexPageing')->name('dashboard.users.indexPageing');
       route::get('users/delete/{id}','users@delete')->name('dashboard.users.delete');
       route::get('users/check/{type}/{id}','users@check')->name('dashboard.users.check');
       route::get('users/getRecord/{id}','users@getRecord')->name('dashboard.users.getRecord');
       route::get('users/getLogs/{id}','users@getLogs')->name('dashboard.users.getLogs');

       route::get('notifications','notifications@index')->name('dashboard.notifications.index');
       route::post('notifications/createUpdate','notifications@createUpdate')->name('dashboard.notifications.createUpdate');
       route::post('notifications','notifications@indexPageing')->name('dashboard.notifications.indexPageing');
       route::get('notifications/delete/{id}','notifications@delete')->name('dashboard.notifications.delete');
       route::get('notifications/check/{type}/{id}','notifications@check')->name('dashboard.notifications.check');
       route::get('notifications/getRecord/{id}','notifications@getRecord')->name('dashboard.notifications.getRecord');

       route::get('contacts','contacts@index')->name('dashboard.contacts.index');
       route::post('contacts/createUpdate','contacts@createUpdate')->name('dashboard.contacts.createUpdate');
       route::post('contacts','contacts@indexPageing')->name('dashboard.contacts.indexPageing');
       route::get('contacts/delete/{id}','contacts@delete')->name('dashboard.contacts.delete');
       route::get('contacts/check/{check}/{id}','contacts@check')->name('dashboard.contacts.check');
       route::get('contacts/getRecord/{id}','contacts@getRecord')->name('dashboard.contacts.getRecord');

       route::get('report_persons','report_persons@index')->name('dashboard.report_persons.index');
       route::post('report_persons/createUpdate','report_persons@createUpdate')->name('dashboard.report_persons.createUpdate');
       route::post('report_persons','report_persons@indexPageing')->name('dashboard.report_persons.indexPageing');
       route::get('report_persons/delete/{id}','report_persons@delete')->name('dashboard.report_persons.delete');
       route::get('report_persons/check/{type}/{id}','report_persons@check')->name('dashboard.report_persons.check');
       route::get('report_persons/getRecord/{id}','report_persons@getRecord')->name('dashboard.report_persons.getRecord');

       route::get('regions','regions@index')->name('dashboard.regions.index');
       route::post('regions/createUpdate','regions@createUpdate')->name('dashboard.regions.createUpdate');
       route::post('regions','regions@indexPageing')->name('dashboard.regions.indexPageing');
       route::get('regions/delete/{id}','regions@delete')->name('dashboard.regions.delete');
       route::get('regions/check/{type}/{id}','regions@check')->name('dashboard.regions.check');
       route::get('regions/getRecord/{id}','regions@getRecord')->name('dashboard.regions.getRecord');

       route::get('ads','ads@index')->name('dashboard.ads.index');
       route::post('ads/createUpdate','ads@createUpdate')->name('dashboard.ads.createUpdate');
       route::post('ads','ads@indexPageing')->name('dashboard.ads.indexPageing');
       route::get('ads/delete/{id}','ads@delete')->name('dashboard.ads.delete');
       route::get('ads/check/{type}/{id}','ads@check')->name('dashboard.ads.check');
       route::get('ads/getRecord/{id}','ads@getRecord')->name('dashboard.ads.getRecord');

       route::get('offers','offers@index')->name('dashboard.offers.index');
       route::post('offers/createUpdate','offers@createUpdate')->name('dashboard.offers.createUpdate');
       route::post('offers','offers@indexPageing')->name('dashboard.offers.indexPageing');
       route::get('offers/delete/{id}','offers@delete')->name('dashboard.offers.delete');
       route::get('offers/check/{type}/{id}','offers@check')->name('dashboard.offers.check');
       route::get('offers/getRecord/{id}','offers@getRecord')->name('dashboard.offers.getRecord');

       route::get('admins','admins@index')->name('dashboard.admins.index');
       route::post('admins/createUpdate','admins@createUpdate')->name('dashboard.admins.createUpdate');
       route::post('admins','admins@indexPageing')->name('dashboard.admins.indexPageing');
       route::get('admins/delete/{id}','admins@delete')->name('dashboard.admins.delete');
       route::get('admins/check/{type}/{id}','admins@check')->name('dashboard.admins.check');
       route::get('admins/getRecord/{id}','admins@getRecord')->name('dashboard.admins.getRecord');

       route::get('appInfo','appInfo@index')->name('dashboard.appInfo.index');
       route::post('appInfo/createUpdate','appInfo@createUpdate')->name('dashboard.appInfo.createUpdate');
       route::post('appInfo','appInfo@indexPageing')->name('dashboard.appInfo.indexPageing');
       route::get('appInfo/delete/{id}','appInfo@delete')->name('dashboard.appInfo.delete');
       route::get('appInfo/check/{type}/{id}','appInfo@check')->name('dashboard.appInfo.check');
       route::get('appInfo/getRecord/{id}','appInfo@getRecord')->name('dashboard.appInfo.getRecord');

       route::get('categories','categories@index')->name('dashboard.categories.index');
       route::post('categories/createUpdate','categories@createUpdate')->name('dashboard.categories.createUpdate');
       route::post('categories','categories@indexPageing')->name('dashboard.categories.indexPageing');
       route::get('categories/delete/{id}','categories@delete')->name('dashboard.categories.delete');
       route::get('categories/check/{check}/{id}','categories@check')->name('dashboard.categories.check');
       route::get('categories/getRecord/{id}','categories@getRecord')->name('dashboard.categories.getRecord');
       route::get('categories/export','categories@export')->name('dashboard.categories.export');
       route::post('categories/import','categories@import')->name('dashboard.categories.import');

       route::get('stores','stores@index')->name('dashboard.stores.index');
       route::post('stores/createUpdate','stores@createUpdate')->name('dashboard.stores.createUpdate');
       route::post('stores','stores@indexPageing')->name('dashboard.stores.indexPageing');
       route::get('stores/delete/{id}','stores@delete')->name('dashboard.stores.delete');
       route::get('stores/check/{check}/{id}','stores@check')->name('dashboard.stores.check');
       route::get('stores/getRecord/{id}','stores@getRecord')->name('dashboard.stores.getRecord');

       route::get('price_list','price_list@index')->name('dashboard.price_list.index');
       route::post('price_list/createUpdate','price_list@createUpdate')->name('dashboard.price_list.createUpdate');
       route::post('price_list','price_list@indexPageing')->name('dashboard.price_list.indexPageing');
       route::get('price_list/delete/{id}','price_list@delete')->name('dashboard.price_list.delete');
       route::get('price_list/check/{check}/{id}','price_list@check')->name('dashboard.price_list.check');
       route::get('price_list/getRecord/{id}','price_list@getRecord')->name('dashboard.price_list.getRecord');

       route::get('codes','codes@index')->name('dashboard.codes.index');
       route::post('codes/createUpdate','codes@createUpdate')->name('dashboard.codes.createUpdate');
       route::post('codes','codes@indexPageing')->name('dashboard.codes.indexPageing');
       route::get('codes/delete/{id}','codes@delete')->name('dashboard.codes.delete');
       route::get('codes/check/{check}/{id}','codes@check')->name('dashboard.codes.check');
       route::get('codes/getRecord/{id}','codes@getRecord')->name('dashboard.codes.getRecord');

       route::get('recharges','recharges@index')->name('dashboard.recharges.index');
       route::post('recharges/createUpdate','recharges@createUpdate')->name('dashboard.recharges.createUpdate');
       route::post('recharges','recharges@indexPageing')->name('dashboard.recharges.indexPageing');
       route::get('recharges/delete/{id}','recharges@delete')->name('dashboard.recharges.delete');
       route::get('recharges/check/{check}/{id}','recharges@check')->name('dashboard.recharges.check');
       route::get('recharges/getRecord/{id}','recharges@getRecord')->name('dashboard.recharges.getRecord');

       route::get('send_to_my_emails','send_to_my_emails@index')->name('dashboard.send_to_my_emails.index');
       route::post('send_to_my_emails/createUpdate','send_to_my_emails@createUpdate')->name('dashboard.send_to_my_emails.createUpdate');
       route::post('send_to_my_emails','send_to_my_emails@indexPageing')->name('dashboard.send_to_my_emails.indexPageing');
       route::get('send_to_my_emails/delete/{id}','send_to_my_emails@delete')->name('dashboard.send_to_my_emails.delete');
       route::get('send_to_my_emails/check/{check}/{id}','send_to_my_emails@check')->name('dashboard.send_to_my_emails.check');
       route::get('send_to_my_emails/getRecord/{id}','send_to_my_emails@getRecord')->name('dashboard.send_to_my_emails.getRecord');

       route::get('withdraw_requests','withdraw_requests@index')->name('dashboard.withdraw_requests.index');
       route::post('withdraw_requests/createUpdate','withdraw_requests@createUpdate')->name('dashboard.withdraw_requests.createUpdate');
       route::post('withdraw_requests','withdraw_requests@indexPageing')->name('dashboard.withdraw_requests.indexPageing');
       route::get('withdraw_requests/delete/{id}','withdraw_requests@delete')->name('dashboard.withdraw_requests.delete');
       route::get('withdraw_requests/check/{check}/{id}','withdraw_requests@check')->name('dashboard.withdraw_requests.check');
       route::get('withdraw_requests/getRecord/{id}','withdraw_requests@getRecord')->name('dashboard.withdraw_requests.getRecord');

       route::get('bank_accounts','bank_accounts@index')->name('dashboard.bank_accounts.index');
       route::post('bank_accounts/createUpdate','bank_accounts@createUpdate')->name('dashboard.bank_accounts.createUpdate');
       route::post('bank_accounts','bank_accounts@indexPageing')->name('dashboard.bank_accounts.indexPageing');
       route::get('bank_accounts/delete/{id}','bank_accounts@delete')->name('dashboard.bank_accounts.delete');
       route::get('bank_accounts/check/{check}/{id}','bank_accounts@check')->name('dashboard.bank_accounts.check');
       route::get('bank_accounts/getRecord/{id}','bank_accounts@getRecord')->name('dashboard.bank_accounts.getRecord');

       route::get('orders','orders@index')->name('dashboard.orders.index');
       route::post('orders/createUpdate','orders@createUpdate')->name('dashboard.orders.createUpdate');
       route::post('orders','orders@indexPageing')->name('dashboard.orders.indexPageing');
       route::get('orders/delete/{id}','orders@delete')->name('dashboard.orders.delete');
       route::get('orders/check/{check}/{id}','orders@check')->name('dashboard.orders.check');
       route::get('orders/getRecord/{id}','orders@getRecord')->name('dashboard.orders.getRecord');
       route::get('orders/getRecordInfo/{id}','orders@getRecordInfo')->name('dashboard.orders.getRecordInfo');
       route::get('orders/deleteAllRecords','orders@deleteAllRecords')->name('dashboard.orders.deleteAllOrders');

       route::get('vehicles','vehicles@index')->name('dashboard.vehicles.index');
       route::post('vehicles/createUpdate','vehicles@createUpdate')->name('dashboard.vehicles.createUpdate');
       route::post('vehicles','vehicles@indexPageing')->name('dashboard.vehicles.indexPageing');
       route::get('vehicles/delete/{id}','vehicles@delete')->name('dashboard.vehicles.delete');
       route::get('vehicles/check/{check}/{id}','vehicles@check')->name('dashboard.vehicles.check');
       route::get('vehicles/getRecord/{id}','vehicles@getRecord')->name('dashboard.vehicles.getRecord');
       
       route::get('products','products@index')->name('dashboard.products.index');
       route::post('products/createUpdate','products@createUpdate')->name('dashboard.products.createUpdate');
       route::post('products','products@indexPageing')->name('dashboard.products.indexPageing');
       route::post('products/points/createUpdate','products@points')->name('dashboard.points.createUpdate');
       route::get('products/delete/{id}','products@delete')->name('dashboard.products.delete');
       route::get('products/delete/{id}/feature','products@deleteFeature')->name('dashboard.feature.delete');
       route::get('products/check/{check}/{id}','products@check')->name('dashboard.products.check');
       route::get('products/getRecord/{id}','products@getRecord')->name('dashboard.products.getRecord');
       route::get('products/export','products@export')->name('dashboard.products.export');
       route::post('products/import','products@import')->name('dashboard.products.import');
       route::post('products/uploadImages','products@uploadImages')->name('dashboard.products.uploadImages');

       route::get('points','points@index')->name('dashboard.points.index');
       route::post('points/createUpdate','points@createUpdate')->name('dashboard.points.createUpdate');
       route::post('points','points@indexPageing')->name('dashboard.points.indexPageing');
       route::get('points/delete/{id}','points@delete')->name('dashboard.points.delete');
       route::get('points/check/{check}/{id}','points@check')->name('dashboard.points.check');
       route::get('points/getRecord/{id}','points@getRecord')->name('dashboard.points.getRecord');

       route::get('drivers','drivers@index')->name('dashboard.drivers.index');
       route::post('drivers/createUpdate','drivers@createUpdate')->name('dashboard.drivers.createUpdate');
       route::post('drivers','drivers@indexPageing')->name('dashboard.drivers.indexPageing');
       route::get('drivers/delete/{id}','drivers@delete')->name('dashboard.drivers.delete');
       route::get('drivers/check/{check}/{id}','drivers@check')->name('dashboard.drivers.check');
       route::get('drivers/getRecord/{id}','drivers@getRecord')->name('dashboard.drivers.getRecord');
       route::get('drivers/getLogs/{id}','drivers@getLogs')->name('dashboard.drivers.getLogs');

       route::get('faqs','faqs@index')->name('dashboard.faqs.index');
       route::post('faqs/createUpdate','faqs@createUpdate')->name('dashboard.faqs.createUpdate');
       route::post('faqs','faqs@indexPageing')->name('dashboard.faqs.indexPageing');
       route::get('faqs/delete/{id}','faqs@delete')->name('dashboard.faqs.delete');
       route::get('faqs/check/{check}/{id}','faqs@check')->name('dashboard.faqs.check');
       route::get('faqs/getRecord/{id}','faqs@getRecord')->name('dashboard.faqs.getRecord');
       

       route::get('reports','reports@index')->name('dashboard.reports.index');
       route::post('reports/createUpdate','reports@createUpdate')->name('dashboard.reports.createUpdate');
       route::post('reports','reports@indexPageing')->name('dashboard.reports.indexPageing');
       route::get('reports/delete/{id}','reports@delete')->name('dashboard.reports.delete');
       route::get('reports/check/{check}/{id}','reports@check')->name('dashboard.reports.check');
       route::get('reports/getRecord/{id}','reports@getRecord')->name('dashboard.reports.getRecord');

       route::get('reports/print','reports@print')->name('dashboard.reports.print');

});

route::get('orders/getRecord/{id}','orders@getRecord')->name('dashboard.orders.getRecord');


 route::get('stores_has_regions','stores_has_regions@index')->name('dashboard.stores_has_regions.index');
route::post('stores_has_regions/createUpdate','stores_has_regions@createUpdate')->name('dashboard.stores_has_regions.createUpdate');
route::post('stores_has_regions','stores_has_regions@indexPageing')->name('dashboard.stores_has_regions.indexPageing');
route::get('stores_has_regions/delete/{id}','stores_has_regions@delete')->name('dashboard.stores_has_regions.delete');
route::get('stores_has_regions/check/{check}/{id}','stores_has_regions@check')->name('dashboard.stores_has_regions.check');
route::get('stores_has_regions/getRecord/{id}','stores_has_regions@getRecord')->name('dashboard.stores_has_regions.getRecord');