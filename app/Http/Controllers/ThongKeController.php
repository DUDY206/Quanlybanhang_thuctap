<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\ThuTien;
use App\BanHang;
use App\PhieuXuat;
use App\PhieuNhap;
use App\Hang;
class ThongKeController extends Controller
{

	//thống kê theo năm
    public function thongkenam($user_id,$year){
      $dsHang = Hang::select('id','ten')->get();
		 if($user_id=='all'){
			  //[CẢ KHO] thống kê số lượng đã bán (số lượng, tiền bán hàng) - theo năm, tưng tháng
 			  $chitiet_Hang_Thang = PhieuXuat::join('banhang','banhang.id','=','phieuxuat.mabanhang')
 			  							 ->whereYear('banhang.ngayban',$year)
 			  							 ->select(DB::raw('month(banhang.ngayban) as thang,hang_id,sum(soluong) as soluongban,sum(soluong*giaban-giamgia) as tongtien'))
 			  							 ->groupBy('thang','hang_id')
                               ->orderBy('thang','asc')
 			  							 ->get();
           $soluongnhap = PhieuNhap::whereYear('ngaynhap',$year)
                                   ->select(DB::raw('sum(soluong) as soluongnhap'))
                                   ->get();
           $tienthu_thang = ThuTien::whereYear('ngay',$year)
                            ->select(DB::raw('month(ngay) as thang, phuongthucthanhtoan,sum(sotien) as tongtien'))
                            ->groupBy('thang','phuongthucthanhtoan')
                            ->orderBy('thang','asc')
                            ->get();
           $tiennhap_thang = PhieuNhap::whereYear('ngaynhap',$year)
                              ->select(DB::raw('month(ngaynhap) as thang,-sum(soluong*gianhap) as tongtien'))
                              ->groupBy('thang')
                              ->pluck('tongtien','thang');

		 }else{
          //[CÁ NHÂN] thống kê số lượng đã bán (số lượng, tiền bán hàng) - theo năm, tưng tháng
          $chitiet_Hang_Thang = PhieuXuat::join('banhang','banhang.id','=','phieuxuat.mabanhang')
                              ->whereYear('banhang.ngayban',$year)
                              ->where('banhang.nguoiban_id','=',$user_id)
                              ->select(DB::raw('month(banhang.ngayban) as thang,hang_id,sum(soluong) as soluongban,sum(soluong*giaban) as tongtien'))
                              ->groupBy('thang','hang_id')
                              ->orderBy('thang','asc')
                              ->get();
         $tienthu_thang = ThuTien::join('banhang','banhang.id','=','thutien.banhang_id')
                          ->whereYear('ngay',$year)
                          ->where('banhang.nguoiban_id','=',$user_id)
                          ->select(DB::raw('month(ngay) as thang, phuongthucthanhtoan,sum(sotien) as tongtien'))
                          ->groupBy('thang','phuongthucthanhtoan')
                          ->orderBy('thang','asc')
                          ->get();
         $luong = PhieuXuat::join('banhang','banhang.id','=','phieuxuat.mabanhang')
                             ->whereYear('banhang.ngayban',$year)
                             ->where('banhang.nguoiban_id','=',$user_id)
                             ->select(DB::raw('month(banhang.ngayban) as thang,sum((giaban-giaphanphoi)*phieuxuat.soluong) as tienluong'))
                             ->groupBy('thang')
                             ->pluck('tienluong','thang');
		 }

       if($chitiet_Hang_Thang->count()==0){
          return redirect('/')->with('error','Không tồn tại lịch sử bán hàng !');
       }
       //lưu thông tin  dưới dạng map với key ngoài là tháng, key trong là id hàng
        $collection = collect();
        $tienhangthang = collect();
        $tongtien = 0;
        $maxthang = 0;
        foreach ($chitiet_Hang_Thang as $chitiet) {
           $thongtin = collect([$chitiet->hang_id=>collect(['soluongban' => $chitiet->soluongban,'tongtien' => $chitiet->tongtien])]); // collect(ID1 => ['soluong'=>'0','tien'=>'0']);
           if($collection->get($chitiet->thang) == null){
             $collection->put($chitiet->thang,$thongtin);
             $tongtien = $chitiet->tongtien;
             $tienhangthang->put($chitiet->thang,$tongtien);
             $maxthang = $chitiet->thang;
           }else{
             $collection->get($chitiet->thang)->put($chitiet->hang_id,collect(['soluongban' => $chitiet->soluongban,'tongtien' => $chitiet->tongtien]));
             $tongtien += $chitiet->tongtien;
             $tienhangthang->put($chitiet->thang,$tongtien);
           }
        }
        for($i = 1;$i<=$maxthang;$i++){
           if($tienhangthang->get($i) == null){
             $tienhangthang->put($i,0);
          }
        }
        $tienhangthang = $tienhangthang->sortKeys();
        $tongthu = 0;
        $tongthucanam = 0;
        $tongthutheonganhang = collect();
        $tongthutheothang = collect();
        $tongthu2 = 0;
        foreach ($tienthu_thang as $tien) {
           $tongthu += $tien->tongtien;
           $tongthucanam+=$tien->tongtien;
           if($tongthutheonganhang->get($tien->phuongthucthanhtoan) == null){
             $tongthu = $tien->tongtien;
             $tongthutheonganhang->put($tien->phuongthucthanhtoan,$tongthu);
          }else{
             $tongthu =$tien->tongtien+$tongthutheonganhang->get($tien->phuongthucthanhtoan);
             $tongthutheonganhang->put($tien->phuongthucthanhtoan,$tongthu);
          }

          if($tongthutheothang->get($tien->thang) == null){
             $tongthu2 = $tien->tongtien;
             $tongthutheothang->put($tien->thang,$tongthu2);
          }else{
             $tongthu2 = $tien->tongtien+$tongthutheothang->get($tien->thang);
             $tongthutheothang->put($tien->thang,$tongthu2);
          }
        }
        for($i = 1;$i<=$maxthang;$i++){
           if($tongthutheothang->get($i) == null){
             $tongthutheothang->put($i,0);
          }
        }
        $tongthutheothang = $tongthutheothang->sortKeys();


        // $tiennhap_thang = $tiennhap_thang->sortKeys();
        // return $tongthucanam;
        if($user_id=='all'){
           for($i = 1;$i<=$maxthang;$i++){
             if($tiennhap_thang->get($i) == null){
                $tiennhap_thang->put($i,0);
             }
           }
        return  view('layouts.chart',compact('year','user_id','dsHang','collection','tienhangthang','maxthang','tongthucanam','tongthutheonganhang','tongthutheothang','tiennhap_thang','soluongnhap'));}else{
           $tongluong = 0;
           for($i = 1;$i<=$maxthang;$i++){
             if($luong->get($i) == null){
                $luong->put($i,0);
             }
             $tongluong+=$luong->get($i);

           }
        return  view('layouts.chart',compact('year','luong','tongluong','user_id','dsHang','collection','tienhangthang','maxthang','tongthucanam','tongthutheonganhang','tongthutheothang'));
        };
	 }
	 	//thống kê theo tháng
	 public function thongkethang($user_id,$year,$month){
      $dsHang = Hang::select('id','ten')->get();
      if($user_id=='all'){
          //[CẢ KHO] thống kê số lượng đã bán (số lượng, tiền bán hàng) - theo năm, tưng tháng
          $chitiet_Hang_Thang = PhieuXuat::join('banhang','banhang.id','=','phieuxuat.mabanhang')
                               ->whereYear('banhang.ngayban',$year)
                               ->whereMonth('banhang.ngayban',$month)
                               ->select(DB::raw('day(banhang.ngayban) as thang,hang_id,sum(soluong) as soluongban,sum(soluong*giaban-giamgia) as tongtien'))
                               ->groupBy('thang','hang_id')
                                ->orderBy('thang','asc')
                               ->get();
           $soluongnhap = PhieuNhap::whereYear('ngaynhap',$year)
                                    ->whereMonth('ngaynhap',$month)
                                    ->select(DB::raw('sum(soluong) as soluongnhap'))
                                    ->get();
           $tienthu_thang = ThuTien::whereYear('ngay',$year)
                              ->whereMonth('ngay',$month)
                             ->select(DB::raw('day(ngay) as thang, phuongthucthanhtoan,sum(sotien) as tongtien'))
                             ->groupBy('thang','phuongthucthanhtoan')
                             ->orderBy('thang','asc')
                             ->get();
           $tiennhap_thang = PhieuNhap::whereYear('ngaynhap',$year)
                                ->whereMonth('ngaynhap',$month)
                               ->select(DB::raw('day(ngaynhap) as thang,-sum(soluong*gianhap) as tongtien'))
                               ->groupBy('thang')
                               ->pluck('tongtien','thang');

      }else{
          //[CÁ NHÂN] thống kê số lượng đã bán (số lượng, tiền bán hàng) - theo năm, tưng tháng
          $chitiet_Hang_Thang = PhieuXuat::join('banhang','banhang.id','=','phieuxuat.mabanhang')
                               ->whereYear('banhang.ngayban',$year)
                               ->whereMonth('banhang.ngayban',$month)
                               ->where('banhang.nguoiban_id','=',$user_id)
                               ->select(DB::raw('day(banhang.ngayban) as thang,hang_id,sum(soluong) as soluongban,sum(soluong*giaban) as tongtien'))
                               ->groupBy('thang','hang_id')
                               ->orderBy('thang','asc')
                               ->get();
          $tienthu_thang = ThuTien::join('banhang','banhang.id','=','thutien.banhang_id')
                           ->whereYear('ngay',$year)
                           ->whereMonth('ngay',$month)
                           ->where('banhang.nguoiban_id','=',$user_id)
                           ->select(DB::raw('day(ngay) as thang, phuongthucthanhtoan,sum(sotien) as tongtien'))
                           ->groupBy('thang','phuongthucthanhtoan')
                           ->orderBy('thang','asc')
                           ->get();
          $luong = PhieuXuat::join('banhang','banhang.id','=','phieuxuat.mabanhang')
                              ->whereYear('banhang.ngayban',$year)
                              ->whereMonth('banhang.ngayban',$month)
                              ->where('banhang.nguoiban_id','=',$user_id)
                              ->select(DB::raw('day(banhang.ngayban) as thang,sum((giaban-giaphanphoi)*phieuxuat.soluong-banhang.giamgia) as tienluong'))
                              ->groupBy('thang')
                              ->pluck('tienluong','thang');
      }

       if($chitiet_Hang_Thang->count()==0){
          return redirect('/')->with('error','Không tồn tại lịch sử bán hàng !');
       }
       //lưu thông tin  dưới dạng map với key ngoài là tháng, key trong là id hàng
        $collection = collect();
        $tienhangthang = collect();
        $tongtien = 0;
        $maxthang = 0;
        foreach ($chitiet_Hang_Thang as $chitiet) {
           $thongtin = collect([$chitiet->hang_id=>collect(['soluongban' => $chitiet->soluongban,'tongtien' => $chitiet->tongtien])]); // collect(ID1 => ['soluong'=>'0','tien'=>'0']);
           if($collection->get($chitiet->thang) == null){
             $collection->put($chitiet->thang,$thongtin);
             $tongtien = $chitiet->tongtien;
             $tienhangthang->put($chitiet->thang,$tongtien);
             $maxthang = $chitiet->thang;
           }else{
             $collection->get($chitiet->thang)->put($chitiet->hang_id,collect(['soluongban' => $chitiet->soluongban,'tongtien' => $chitiet->tongtien]));
             $tongtien += $chitiet->tongtien;
             $tienhangthang->put($chitiet->thang,$tongtien);
           }
        }
        for($i = 1;$i<=$maxthang;$i++){
           if($tienhangthang->get($i) == null){
             $tienhangthang->put($i,0);
          }
        }
        $tienhangthang = $tienhangthang->sortKeys();
        $tongthu = 0;
        $tongthucanam = 0;
        $tongthutheonganhang = collect();
        $tongthutheothang = collect();
        $tongthu2 = 0;
        foreach ($tienthu_thang as $tien) {
           $tongthu += $tien->tongtien;
           $tongthucanam+=$tien->tongtien;
           if($tongthutheonganhang->get($tien->phuongthucthanhtoan) == null){
             $tongthu = $tien->tongtien;
             $tongthutheonganhang->put($tien->phuongthucthanhtoan,$tongthu);
          }else{
             $tongthu =$tien->tongtien+$tongthutheonganhang->get($tien->phuongthucthanhtoan);
             $tongthutheonganhang->put($tien->phuongthucthanhtoan,$tongthu);
          }

          if($tongthutheothang->get($tien->thang) == null){
             $tongthu2 = $tien->tongtien;
             $tongthutheothang->put($tien->thang,$tongthu2);
          }else{
             $tongthu2 = $tien->tongtien+$tongthutheothang->get($tien->thang);
             $tongthutheothang->put($tien->thang,$tongthu2);
          }
        }
        for($i = 1;$i<=$maxthang;$i++){
           if($tongthutheothang->get($i) == null){
             $tongthutheothang->put($i,0);
          }
        }
        $tongthutheothang = $tongthutheothang->sortKeys();


        // $tiennhap_thang = $tiennhap_thang->sortKeys();
        // return $tongthucanam;
        if($user_id=='all'){
           for($i = 1;$i<=$maxthang;$i++){
             if($tiennhap_thang->get($i) == null){
                 $tiennhap_thang->put($i,0);
             }
           }
        return  view('layouts.chart',compact('year','month','user_id','dsHang','collection','tienhangthang','maxthang','tongthucanam','tongthutheonganhang','tongthutheothang','tiennhap_thang','soluongnhap'));}else{
           $tongluong = 0;
           for($i = 1;$i<=$maxthang;$i++){
             if($luong->get($i) == null){
                 $luong->put($i,0);
             }
             $tongluong+=$luong->get($i);

           }
        return  view('layouts.chart',compact('year','month','luong','tongluong','user_id','dsHang','collection','tienhangthang','maxthang','tongthucanam','tongthutheonganhang','tongthutheothang'));
        };
	 }
	 	//thống kê theo ngay
	 public function thongkengay($user_id,$year,$month,$day){
		 if($user_id=='all'){
          $phieuxuat = PhieuXuat::join('banhang','banhang.id','=','phieuxuat.mabanhang')
                                 ->join('hang','hang.id','=','phieuxuat.hang_id')
                                  ->whereYear('banhang.ngayban',$year)
                                  ->whereMonth('banhang.ngayban',$month)
                                  ->whereDay('banhang.ngayban',$day)
                                  ->select(DB::raw('hang.ten,sum(phieuxuat.soluong) as soluongban,sum(phieuxuat.soluong*giaban-giamgia) as tongtien'))
                                  ->groupBy('hang.ten')
                                  ->get();
          $thutien = ThuTien::join('banhang','banhang.id','=','thutien.banhang_id')
                           ->whereYear('ngay',$year)
                           ->whereMonth('ngay',$month)
                           ->whereDay('ngay',$day)
                           ->select(DB::raw('phuongthucthanhtoan,sum(sotien) as tongtien'))
                           ->groupBy('phuongthucthanhtoan')
                           ->get();

		 }else{
          $phieuxuat = PhieuXuat::join('banhang','banhang.id','=','phieuxuat.mabanhang')
                                  ->join('hang','hang.id','=','phieuxuat.hang_id')
                                  ->whereYear('banhang.ngayban',$year)
                                  ->whereMonth('banhang.ngayban',$month)
                                  ->whereDay('banhang.ngayban',$day)
                                  ->where('banhang.nguoiban_id','=',$user_id)
                                  ->select(DB::raw('hang.ten,sum(phieuxuat.soluong) as soluongban,sum(phieuxuat.soluong*phieuxuat.giaban-giamgia) as tongtien,sum((phieuxuat.giaban-phieuxuat.giaphanphoi)*phieuxuat.soluong-banhang.giamgia) as tienluong'))
                                  ->groupBy('hang.ten')
                                  ->get();
          $thutien = ThuTien::join('banhang','banhang.id','=','thutien.banhang_id')
                           ->whereYear('ngay',$year)
                           ->whereMonth('ngay',$month)
                           ->whereDay('ngay',$day)
                           ->where('banhang.nguoiban_id','=',$user_id)
                           ->select(DB::raw('phuongthucthanhtoan,sum(sotien) as tongtien'))
                           ->groupBy('phuongthucthanhtoan')
                           ->get();
		 }
       // return [$phieuxuat,$thutien];
		 return view('layouts.thongke',compact('phieuxuat','thutien','user_id','year','month','day'));
	 }

}
