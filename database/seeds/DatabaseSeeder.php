<?php

use Illuminate\Database\Seeder;
use App\User;
use App\PhieuNhap;
use App\BanHang;
use App\ThuTien;
use App\PhanPhoiHang;
use App\PhieuXuat;

use Faker\Generator as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      // factory(App\PhieuNhap::class,100)->create();

        foreach (range(1,100) as $index){
           factory(App\BanHang::class,1)->create();
          $mabanhang =  BanHang::select(DB::raw('MAX(id) as max_id'))->pluck('max_id')->first();
          $a = rand(1,5);
          $hang_id_arr = range(1,5);
          shuffle($hang_id_arr);
          $user_id = rand(1,4);
          foreach (range(1,$a) as $index) {
             $giaphanphoi = (int)PhanPhoiHang::where('nguoibanid','=',$user_id)->where('hangid','=', $hang_id_arr[$index-1])->pluck('giaphanphoi')->first();
             PhieuXuat::create([
                'hang_id' => $hang_id_arr[$index-1],
                'soluong' => rand(1,4)*50,
                'giaban' =>$giaphanphoi  + rand(3,10)*10000,
                'mabanhang' => $mabanhang,
                'giaphanphoi' => $giaphanphoi
             ]);
          }
          $banhang = BanHang::find($mabanhang);
          $pttt = ['tienmat','VietComBank','VietinBank','TechcomBank','BIDV','VPBank','Khac'];
          foreach(range(1,$a) as $index){
             Thutien::create([
               'banhang_id' => $mabanhang,
              'phuongthucthanhtoan' => $pttt[rand(0,6)],
              'sotien' => rand(1,5)*400000,
              'ngay' => BanHang::find($mabanhang)->ngayban,
            ]);
          }

        }

    }
}
