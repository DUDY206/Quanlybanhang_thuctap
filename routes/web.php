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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/pages',function(){
    return redirect('/');
});
Route::get('/login','LoginController2@index');
Route::post('/login/checkLogin','LoginController2@checkLogin');
Route::get('/login/successLogin','LoginController2@successLogin');
Route::get('/login/logout','LoginController2@logout');

// route pages
Route::get('/pages/userinfo',function(){
    return view('pages/userinfo');
});
//end route pages
Route::get('giaphanphoi','UserInfoController@giaphanphoi');
Route::POST('giaphanphoi/store','UserInfoController@save_giaphanphoi');
Route::get('userinfo/{id}/resetPassword','UserInfoController@resetPassword');
Route::resource('changePassword','ChangePassword');

Route::get('/nhaphang/logs','NhapHangController@logs');
Route::get('/hang/logs','HangsController@logs');


// Route::get('/banhang/list/{user_id}/','BanHangController@get_list_user');
Route::get('/banhang/list/{user_id}/{trangthai}','BanHangController@get_list_user_trangthai');
Route::get('/banhang/list/{user_id}/{trangthai}/search/content={content}','BanHangController@get_list_user_trangthai_search');
//user_id: all - 1,2,3,
//trangthai: chuaduyet - daduyet
Route::get('/banhang/print/{banhang_id}/','BanHangController@print_banhang');
Route::get('/banhang/print/{banhang_id}/success','BanHangController@print_banhang_succes');
Route::POST('/banhang/finished/{banhang_id}/','BanHangController@finished_banhang');
Route::POST('/banhang/finished/{banhang_id}/success','BanHangController@finished_banhang_success');

Route::get('/thongke/{user_id}/{year}','ThongKeController@thongkenam');
Route::get('/thongke/{user_id}/{year}/{month}','ThongKeController@thongkethang');
Route::get('/thongke/{user_id}/{year}/{month}/{day}','ThongKeController@thongkengay');




//user info
Route::get('themthutien/{banhang_id}','ThuTienController@thutien');
Route::post('themthutien/{banhang_id}/success','ThuTienController@thutien_success');
Route::resource('thutien','ThuTienController');
Route::resource('userinfo','UserInfoController');
Route::resource('hang','HangsController');
Route::resource('nhaphang','NhapHangController');
Route::resource('banhang','BanHangController');
