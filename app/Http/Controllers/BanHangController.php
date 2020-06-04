<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hang;
use App\BanHang;
use App\ThuTien;
use App\PhieuXuat;
use App\User;
use Carbon\Carbon;
use App\PhanPhoiHang;
use Auth;
use DB;

class BanHangController extends Controller
{
      public function print_banhang($banhang_id){
         if(Auth::user()->level>2){
            return back()->with('error','Bạn không có quyền truy cập');
         }
       $banhang = BanHang::find($banhang_id);
       $user=User::find($banhang->nguoiban_id);
       $phieuxuats=PhieuXuat::join('hang','hang.id','=','phieuxuat.hang_id')->select('hang.ten as tenhang','phieuxuat.soluong as soluonghang','phieuxuat.giaban')->where('phieuxuat.mabanhang','=',$banhang_id)->get();
       $thutiens = Thutien::where('banhang_id','=',$banhang_id)->get();
      return view('banhang.print',compact('banhang','user','phieuxuats','thutiens'));
   }

   public function print_banhang_succes($banhang_id){
      $banhang = BanHang::find($banhang_id);
      if($banhang->trangthai < 2){
         return redirect('/')->with('error','Khong the thuc hien thao tac');
      }else{
         if($banhang->trangthai == 2){
            $banhang->trangthai = 1;
            $banhang->save();
         }else{
            $banhang->trangthai = 0;
            $banhang->save();
         }
         return redirect('/')->with('success','In hoa don thanh cong');
      }
   }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


     public function get_list_user_trangthai($user_id,$trangthai){
          $raw = BanHang::join('nguoiban','nguoiban.id','=','banhang.nguoiban_id')->select('banhang.id as banhangid','nguoiban.ten as tennguoiban','banhang.nguoiban_id','banhang.tennguoimua','banhang.sdt as sdt_kh','banhang.diachi','banhang.giamgia','banhang.ngayban');
          if($user_id != 'all'){
                if(User::find($user_id) == null){
                     return redirect('/')->with('error','Không tìm thấy trang');
                }elseif($trangthai == 'chuahoantat'){
                   $banhangs = $raw->where([['trangthai','=',0],['nguoiban_id','=',$user_id]])->orderBy('ngayban','desc')->paginate(10);
                   $title = 'Hàng chưa hoàn tất - ['.User::find($user_id)->ten.']';
                }elseif($trangthai == 'dahoantat'){
                   $banhangs = $raw->where([['trangthai','=',1],['nguoiban_id','=',$user_id]])->orderBy('ngayhoantat','desc')->paginate(10);
                   $title = 'Hàng đã hoàn tất - ['.User::find($user_id)->ten.']';
                }elseif($trangthai == 'chuaduyet'){
                   $banhangs = $raw->where([['trangthai','>',1],['nguoiban_id','=',$user_id]])->orderBy('ngayban','desc')->paginate(10);
                   $title = 'Hàng chưa duyệt - ['.User::find($user_id)->ten.']';
                }elseif($trangthai == 'xacnhanhoanthanh'){
                   $banhangs = $raw->where([['trangthai','=',-1],['nguoiban_id','=',$user_id]])->orderBy('ngayban','desc')->paginate(10);
                   $title = 'xác nhận hoàn thanh đơn COD - ['.User::find($user_id)->ten.']';
                }else{
                   return redirect('/')->with('error','Khong tim thay trang');
                }
          }else{
             if(Auth::user()->level >2){
                return redirect('/')->with('error','Bạn không có quyền truy cập');
             }elseif($trangthai == 'chuahoantat'){
                $banhangs =$raw->where('trangthai','=',0)->orderBy('ngayban','desc')->paginate(10);;
                $title = 'Hàng chưa hoàn tất - [Tất cả]';
             }elseif($trangthai == 'dahoantat'){
                $banhangs =$raw->where('trangthai','=',1)->orderBy('ngayhoantat','desc')->paginate(10);;
                $title = 'Hàng đã hoàn tất - [Tất cả]';
             }elseif($trangthai == 'chuaduyet'){
                $banhangs =$raw->where('trangthai','>',1)->orderBy('ngayban','desc')->paginate(10);;
                $title = 'Hàng chưa duyệt - [Tất cả]';
             }elseif($trangthai == 'xacnhanhoanthanh'){
                $banhangs =$raw->where('trangthai','=',-1)->orderBy('ngayban','desc')->paginate(10);;
                $title = 'Xác nhận đơn cod - [Tất cả]';
             }else{
                return redirect('/')->with('error','Khong tim thay trang');
             }
          }

          $phieuxuats = collect();
           foreach ($banhangs as $banhang) {
               $banhangid = $banhang->banhangid;
               $phieuxuat = PhieuXuat::join('hang','hang.id','=','phieuxuat.hang_id')->select('hang.ten as tenhang','phieuxuat.soluong as soluonghang','phieuxuat.giaban')->where('phieuxuat.mabanhang','=',$banhang->banhangid)->get();
               $phieuxuats->prepend($phieuxuat,$banhangid);
           }
           return view('banhang.index',compact('banhangs','phieuxuats','user_id','trangthai','title'));

     }
     public function get_list_user_trangthai_search($user_id,$trangthai,$content){
        $raw = BanHang::join('nguoiban','nguoiban.id','=','banhang.nguoiban_id')->select('banhang.id as banhangid','nguoiban.ten as tennguoiban','banhang.nguoiban_id','banhang.tennguoimua','banhang.sdt as sdt_kh','banhang.diachi','banhang.giamgia','banhang.ngayban');
        if($user_id != 'all'){
             if(User::find($user_id) == null){
                   return redirect('/')->with('error','Không tìm thấy trang');
             }elseif($trangthai == 'dahoantat'){
                $banhangs = $raw->where([['trangthai','=',1],['nguoiban_id','=',$user_id]]);
                $title = 'Hàng đã hoàn tất - ['.User::find($user_id)->ten.']';
             }elseif($trangthai == 'chuahoantat'){
                $banhangs = $raw->where([['trangthai','=',0],['nguoiban_id','=',$user_id]]);
                $title = 'Hàng chưa hoàn tất - ['.User::find($user_id)->ten.']';
             }elseif($trangthai == 'chuaduyet'){
                $banhangs = $raw->where([['trangthai','>',1],['nguoiban_id','=',$user_id]]);
                $title = 'Hàng chưa duyệt - ['.User::find($user_id)->ten.']';
             }elseif($trangthai == 'xacnhanhoanthanh'){
                $banhangs = $raw->where([['trangthai','=',-1],['nguoiban_id','=',$user_id]]);
                $title = 'Xác nhận đơn COD - ['.User::find($user_id)->ten.']';
             }else{
                return redirect('/')->with('error','Khong tim thay trang');
             }
        }else{
          if(Auth::user()->level >2){
             return redirect('/')->with('error','Bạn không có quyền truy cập');
          }elseif($trangthai == 'dahoantat'){
             $banhangs =$raw->where('trangthai','=',1)->orderBy('ngayhoantat','desc');
             $title = 'Hàng đã hoàn tất - [Tất cả]';
          }elseif($trangthai == 'chuahoantat'){
             $banhangs =$raw->where('trangthai','=',0)->orderBy('ngayban','desc');
             $title = 'Hàng chưa hoàn tất - [Tất cả]';
          }elseif($trangthai == 'chuaduyet'){
             $banhangs =$raw->where('trangthai','>',1)->orderBy('ngayban','desc');
             $title = 'Hàng chưa duyệt - [Tất cả]';
          }elseif($trangthai == 'xacnhanhoanthanh'){
             $banhangs =$raw->where('trangthai','=',-1)->orderBy('ngayban','desc');
             $title = 'xác nhận đơn COD - [Tất cả]';
          }else{
             return redirect('/')->with('error','Khong tim thay trang');
          }
        }
         $banhangs = $banhangs->where('banhang.sdt','like','%'.$content.'%')->orWhere('nguoiban.ten','like','%'.$content.'%')->orWhere('tennguoimua','like','%'.$content.'%')->orderBy('ngayban','desc')->paginate(10);
        $phieuxuats = collect();
        foreach ($banhangs as $banhang) {
             $banhangid = $banhang->banhangid;
             $phieuxuat = PhieuXuat::join('hang','hang.id','=','phieuxuat.hang_id')->select('hang.ten as tenhang','phieuxuat.soluong as soluonghang','phieuxuat.giaban')->where('phieuxuat.mabanhang','=',$banhang->banhangid)->get();
             $phieuxuats->prepend($phieuxuat,$banhangid);
        }
        return view('banhang.index',compact('banhangs','phieuxuats','user_id','trangthai','title'));
     }
    public function index()
    {
      $getBanHang = self::getBanHang('choxuly');
      $banhangs = $getBanHang->get('banhangs');
      $phieuxuats = $getBanHang->get('phieuxuats');
      return view('banhang.index')->with('banhangs',$banhangs)->with('phieuxuats',$phieuxuats);

        // return $banhangs->banhangid;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hangs = Hang::pluck('ten','id');
        return view('banhang.create')->with('hangs',$hangs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      //1. Validate tất cả các thuộc tính
      //2. Kiểm tra trùng lặp mặt hàng trong Request
        DB::beginTransaction();
        try {
          //1.Validate truowngf cho bảng [BÁN HÀNG],[THU TIỀN] mới

          $this->validate($request,[
            'tennguoimua'=>'required',
            'sdt'=>'required|regex:/[0-9]+/',
            'diachi'=>'required',
            'sotien'=>'required|regex:/([0-9]+\,)*[0-9]+/',
            'giamgia'=>'required|regex:/([0-9]+\,)*[0-9]+/',
          ]);
          $soluonghang_tong = Hang::count();
          $soluonghang_request = 0;
          $set_hangid = collect();  //lưu danh sách id hàng trong request

          for($i = 0;$i<$soluonghang_tong;$i++){
              $hangid = 'hang_id-'.$i;
              $soluonghang = 'soluonghang-'.$i;
              $giabanhang = 'giabanhang-'.$i;

              $id = $request->input($hangid);
              $soluong =$request->input($soluonghang);
              $giaban = $request->input($giabanhang);

              if($request->has($hangid)){
                $this->validate($request,[
                   $soluonghang=>'required|numeric|gt:0',
                   $giabanhang=>'required|regex:/([0-9]+\,)*[0-9]+/',
               ]);
                $set_hangid->prepend($id);
                $soluonghang_request++;
              }
          }

          //2.kiểm tra hàng trong request có bị trùng hay không
          if($set_hangid->unique()->count() != $soluonghang_request){
              return back()->with('error','Trùng mặt hàng');
          }


          // tạo bẳng  [BAN HANG]
          $banhang = new BanHang;
          $banhang->nguoiban_id = Auth::user()->id;
          $banhang->giamgia = (int) str_replace(',','',$request->input('giamgia'));
          $banhang->ngayban = Carbon::now();
          $banhang->trangthai = $request->input('trangthai');
          $banhang->tennguoimua = $request->input('tennguoimua');
          $banhang->sdt = $request->input('sdt');
          $banhang->diachi = $request->input('diachi');
          $banhang->save();

          //tạo bảng [THU TIỀN]
          $thutien = new ThuTien;
          $thutien->banhang_id = $banhang->id;;
          $thutien->phuongthucthanhtoan = $request->input('phuongthucthanhtoan');
          $thutien->sotien = (int) str_replace(',','',$request->input('sotien'));
          $thutien->ngay = Carbon::now();
          $thutien->save();


          for($i = 0;$i<$soluonghang_request;$i++){
             $hangid = 'hang_id-'.$i;
             $soluonghang = 'soluonghang-'.$i;
             $giabanhang = 'giabanhang-'.$i;

             if($request->has($hangid)){
                $phieuxuat = new PhieuXuat;
                $phieuxuat->hang_id = $request->input($hangid);
                $phieuxuat->soluong = $request->input($soluonghang);
                $phieuxuat->giaban = (int) str_replace(',','',$request->input($giabanhang));

                $phieuxuat->giaphanphoi = PhanPhoiHang::where('nguoibanid','=',Auth::user()->id)->where('hangid','=',$request->input($hangid))->pluck('giaphanphoi')->first();

                $phieuxuat->mabanhang = $banhang->id;
                $phieuxuat->save();
             }
          }


          DB::commit();
          return redirect('/banhang/list/'.Auth::user()->id.'/chuaduyet')->with('success','Thêm đơn hàng thành công');
        } catch (\Illuminate\Database\QueryException  $e) {
          DB::rollBack();
          return back()->with('error',$e->getMessage().'query');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $hangs = Hang::pluck('ten','id');
     $banhang = BanHang::find($id);
     $dsHang = PhieuXuat::where('mabanhang','=',$id)->get();

     return view('banhang.show')->with('banhang',$banhang)->with('dsHang',$dsHang)->with('hangs',$hangs);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $hangs = Hang::pluck('ten','id');
        $banhang = BanHang::find($id);
        $dsHang = PhieuXuat::where('mabanhang','=',$id)->get();

        return view('banhang.edit')->with('banhang',$banhang)->with('dsHang',$dsHang)->with('hangs',$hangs);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

      DB::beginTransaction();
      try {
        //1.Validate truowngf cho bảng [BÁN HÀNG],[THU TIỀN] mới

        $this->validate($request,[
          'tennguoimua'=>'required',
          'sdt'=>'required|regex:/[0-9]+/',
          'diachi'=>'required',
          'giamgia'=>'required|regex:/([0-9]+\,)*[0-9]+/',
        ]);
        $soluonghang_tong = Hang::count();
        $soluonghang_request = 0;
        $set_hangid = collect();  //lưu danh sách id hàng trong request

        for($i = 0;$i<$soluonghang_tong;$i++){
            $hangid = 'hang_id-'.$i;
            $soluonghang = 'soluonghang-'.$i;
            $giabanhang = 'giabanhang-'.$i;

            $hang_id = $request->input($hangid);
            $soluong =$request->input($soluonghang);
            $giaban = $request->input($giabanhang);

            if($request->has($hangid)){
             $this->validate($request,[
                 $soluonghang=>'required|numeric|gt:0',
                 $giabanhang=>'required|regex:/([0-9]+\,)*[0-9]+/',
             ]);
             $set_hangid->prepend($hang_id);
             $soluonghang_request++;
            }
        }

        //2.kiểm tra hàng trong request có bị trùng hay không
        if($set_hangid->unique()->count() != $soluonghang_request){
            return back()->with('error','Trùng mặt hàng');
        }


        // update bẳng  [BAN HANG]
        $banhang = BanHang::find($id);
        $banhang->giamgia = (int) str_replace(',','',$request->input('giamgia'));
        $banhang->tennguoimua = $request->input('tennguoimua');
        $banhang->sdt = $request->input('sdt');
        $banhang->diachi = $request->input('diachi');
        $banhang->save();

        //update bang hang
        $dsHang = PhieuXuat::where('mabanhang','=',$id)->delete();

        for($i = 0;$i<$soluonghang_request;$i++){
           $hangid = 'hang_id-'.$i;
           $soluonghang = 'soluonghang-'.$i;
           $giabanhang = 'giabanhang-'.$i;

           if($request->has($hangid)){
             $phieuxuat = new PhieuXuat;
             $phieuxuat->hang_id = $request->input($hangid);
             $phieuxuat->soluong = $request->input($soluonghang);
             $phieuxuat->giaban = (int) str_replace(',','',$request->input($giabanhang));
             $phieuxuat->mabanhang = $banhang->id;
             $phieuxuat->save();
           }
        }

        return back()->with('success','Sửa thành công');

        DB::commit();
      } catch (\Illuminate\Database\QueryException  $e) {
        DB::rollBack();
        return back()->with('error',$e->getMessage().'query');
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banhang = BanHang::find($id);
        // $thutiens = Thutien::where('banhang_id','=',)
        $phieuxuats = PhieuXuat::where('mabanhang','=',$id)->get();
        foreach ($phieuxuats as $phieuxuat) {
           $phieuxuat->delete();
        }
        $banhang->delete();
        return back()->with('success','Xoa mat hang thanh cong');
    }

    public function finished_banhang($banhang_id){
      $banhang = BanHang::find($banhang_id);
         $banhang->trangthai = 1;
         $thutien = new ThuTien;
         $thutien->banhang_id = $banhang_id;
         $thutien->phuongthucthanhtoan = 'Hoan COD';
         $thutien->ngay = Carbon::now();
         $thutien->sotien = (int) PhieuXuat::select(DB::raw('sum(soluong*giaban) as tongtien'))->where('mabanhang','=',$banhang_id)->get()->first()->tongtien - (int)$banhang->giamgia;
         $thutien->save();
         $banhang->save();
         return back()->with('success','Đã hoàn thành đơn cod')   ;

   }

   public function finished_banhang_success($banhang_id){
      return view('themthutien.create');
   }

}
