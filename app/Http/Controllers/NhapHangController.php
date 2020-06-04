<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Hang;
use App\PhieuNhap;
use App\LogPhieuNhap;
use Auth;
class NhapHangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      if(Auth::user()->level >1){
         return back()->with('error','Truy cap bi tu choi');
      }
        $phieunhaps = DB::table('phieunhap')->join('hang','phieunhap.hang_id','=','hang.id')->select('phieunhap.*','hang.ten')->orderBy('phieunhap.ngaynhap','desc')->paginate(10);
        return view('nhaphang.index')->with('phieunhaps',$phieunhaps);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      if(Auth::user()->level >1){
         return back()->with('error','Truy cap bi tu choi');
      }
        $dsHangs = Hang::select('id','ten')->get();
        $maps =  $dsHangs->mapWithKeys(function ($item){
           return [$item['id'] => $item['ten']];
        });
        return view('nhaphang.create')->with('maps',$maps);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      if(Auth::user()->level >1){
         return back()->with('error','Truy cap bi tu choi');
      }
      $this->validate($request,[
        'hang_id'=>'required',
        'soluong'=>'required|numeric|gte:0',
        'gianhap'=>'required|numeric|gte:0',
      ]);
      $phieunhap = new PhieuNhap;
      $hang = Hang::find($request->hang_id);
      $phieunhap->hang_id = $request->hang_id;
      $phieunhap->soluong = $request->soluong;
      $phieunhap->gianhap = $request->gianhap;
      $phieunhap->ngaynhap = Carbon::now()->format('Y-m-d');

      $phieunhap->save();
      $hang->soluong += $request->soluong;
      $hang->save();
      return back()->with('success','Nhập hàng thành công');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      if(Auth::user()->level >1){
         return back()->with('error','Truy cap bi tu choi');
      }
            $phieunhap = PhieuNhap::find($id);
            if($phieunhap != null){
              $hang = Hang::find($phieunhap->hang_id)->ten;
              return view('nhaphang.show')->with('phieunhap',$phieunhap)->with('hang',$hang);
            }else{
              return redirect('nhaphang/logs')->with('error','Khong ton tai ban ghi cho PHIEU NHAP');
            }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      if(Auth::user()->level >1){
         return back()->with('error','Truy cap bi tu choi');
      }
        $phieunhap = PhieuNhap::find($id);
        $maps = Hang::pluck('ten', 'id');

        return view('nhaphang.edit')->with('phieunhap',$phieunhap)->with('maps',$maps);
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
      if(Auth::user()->level >1){
         return back()->with('error','Truy cap bi tu choi');
      }
        try {
            $this->validate($request,[
              'hang_id'=>'required',
              'soluong'=>'required|numeric|gte:0',
              'gianhap'=>'required|numeric|gte:0',
            ]);
            $phieunhap = PhieuNhap::find($id);
            $hang_rq = Hang::find($request->hang_id);
            $log = new LogPhieuNhap;

            $log->nhaphang_id = $id;
            $log->phuongthuc = "UPDATE";
            $log->noidung =$phieunhap->hang_id.', '.Hang::find($phieunhap->hang_id)->ten.', '.$phieunhap->soluong.', '.$phieunhap->gianhap."   |   ".$request->hang_id.', '.$hang_rq->ten.', '.$request->soluong.', '.$request->gianhap;
            $log->thoigian = Carbon::now();
            $log->save();

            $phieunhap->hang_id = $request->hang_id;
            $phieunhap->soluong = $request->soluong;
            $phieunhap->gianhap = $request->gianhap;
            $phieunhap->save();

            return redirect('nhaphang')->with('success','Cập nhật hàng thành công');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('nhaphang/'.$id.'/edit')->with('error',$e->getMessage());
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
      if(Auth::user()->level >1){
         return back()->with('error','Truy cap bi tu choi');
      }
        $phieunhap = PhieuNhap::find($id);

        $log = new LogPhieuNhap;

        $log->nhaphang_id = $id;
        $log->phuongthuc = "DELETE";
        $log->noidung = $phieunhap->hang_id.', '.Hang::find($phieunhap->hang_id)->ten.', '.$phieunhap->soluong.', '.$phieunhap->gianhap;
        $log->thoigian = Carbon::now();
        $log->save();

        $phieunhap->delete();
        return redirect('nhaphang')->with('success','Xóa phiếu nhập thành công');
    }

    public function logs(){
      if(Auth::user()->level >1){
         return back()->with('error','Truy cap bi tu choi');
      }
        $logs = LogPhieuNhap::orderBy('thoigian','desc')->paginate(10);
        return view('nhaphang.log')->with('logs',$logs);
    }
}
