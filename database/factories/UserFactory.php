<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\PhieuNhap;
use App\BanHang;
use App\ThuTien;
use App\PhieuXuat;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'ten' => $faker->name,
        'sdt' => $faker->sdt,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'is_active'=>1,
    ];
});

$factory->define(PhieuNhap::class, function (Faker $faker) {

    $gianhap = 40000+rand(1,10)*1000;
    return [
        'hang_id' => rand(1,5),
        'soluong' => rand(5,10)*100,
        'ngaynhap' => $faker->dateTimeBetween('-4 years','-4 months'),
        'gianhap' => $gianhap,
    ];
});


$factory->define(BanHang::class, function (Faker $faker) {

    return [
        'nguoiban_id' => rand(1,4),
        'giamgia' => rand(0,10)*10000,
        'ngayban' => $faker->dateTimeBetween('-3 months','now'),
        // 'trangthai' => rand(2,3),   // 3 coc-chua duyet,
                                       // 2 thanh toan het - chua duyet
                                       // 1 thanh toan xong
                                       // 0 duyet chua xong
        'trangthai' => rand(0,1),
        'tennguoimua' => $faker->name,
        'sdt' => $faker->e164PhoneNumber,
        'diachi' => $faker->address,
    ];
});

$factory->define(ThuTien::class, function (Faker $faker) {
   $pttt = ['tienmat','VietComBank','VietinBank','TechcomBank','BIDV','VPBank','Khac'];
   static $number = 70;
    return [
        'banhang_id' => $number++,
        'phuongthucthanhtoan' => $faker->randomElement($pttt),
        'sotien' => rand(1,5)*200000,
        'ngay' => BanHang::find($number-1)->ngayban,

    ];
});

$factory->define(PhieuXuat::class, function (Faker $faker) {
   static $number = 75;

   return [
       'hang_id' => 19,
       'soluong' => rand(1,4)*50,
       'giaban' => rand(3,5)*20000,
       'mabanhang' => $number++,
   ];
});
