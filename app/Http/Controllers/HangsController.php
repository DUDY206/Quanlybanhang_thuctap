<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Hang;
use App\LogHang;
use App\PhieuNhap;
use DB;
use Auth;
class HangsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hangs = Hang::orderBy('soluong','desc')->get();
        return view('hang.index')->with('hangs',$hangs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         if(Auth::user()->level > 1){
            return back()->with('error','Truy cap bi tu choi');
         }
        return view('hang.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         if(Auth::user()->level > 1){
             return back()->with('error','Truy cap bi tu choi');
         }
        $this->validate($request,[
          'ten'=>'required',
          'soluong'=>'required|numeric|gte:0',
          'gianhap'=>'required|regex:/([0-9]+\,)*[0-9]+/',
        ]);
        $hang = new Hang;
        $hang->id = null;
        $hang->ten = $request->input('ten');
        $hang->soluong = 0;
        $hang->save();
        $phieunhap = new PhieuNhap();
        $phieunhap->hang_id = $hang->id;
        $phieunhap->soluong = $request->input('soluong');
        $phieunhap->gianhap = (int) str_replace(',','',$request->input('gianhap'));
        $phieunhap->ngaynhap = Carbon::now()->format('Y-m-d');
        $phieunhap->save();
        return redirect('/hang')->with('success','Tạo mặt hàng thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $hangs = Hang::find($id);
        // return view('hang.show')->with('hangs',$hang);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      if(Auth::user()->level == 0){
         $hang = Hang::find($id);
         return view('hang.edit')->with('hang',$hang);
      }else{
         return back()->with('error','Truy cap bi tu choi');
      }

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
      if(Auth::user()->level != 0){
         return back()->with('error','Truy cap bi tu choi');
      }
      $this->validate($request,[
        'ten'=>'required',
        'soluong'=>'required|numeric|gte:0'
      ]);

      $hang = Hang::find($id);
      $log = new LogHang;

      $log->hang_id = $id;
      $log->phuongthuc = "UPDATE";
      $log->noidung =$id.': '.$hang->ten.', '.$hang->soluong."   |   ".$request->ten.', '.$request->soluong;
      $log->thoigian = Carbon::now();
      $log->save();

      $hang->ten = $request->input('ten');
      $hang->soluong = $request->input('soluong');
      $hang->save();
      return redirect('hang')->with('success','Cập nhật mặt hàng'.$hang->ten.' thành công');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      if(Auth::user()->level != 0){
         return back()->with('error','Truy cap bi tu choi');
      }
      try
      {
        $hang = Hang::find($id);

        $log = new LogHang;

        $log->hang_id = $id;
        $log->phuongthuc = "DELETE";
        $log->noidung = $id.': '.$hang->ten.', '.$hang->soluong;
        $log->thoigian = Carbon::now();
        $log->save();

        $ten = $hang->ten;
        $hang->delete();
        return redirect('hang')->with('success','Xóa mặt hàng '.$ten.' thành công');
      }
      catch(\Illuminate\Database\QueryException $e)
      {
        return redirect('hang')->with('error',$e->getMessage());
      }

    }

    public function logs(){
      if(Auth::user()->level > 1){
          return back()->with('error','Truy cap bi tu choi');
      }
      $logs = LogHang::orderBy('thoigian','desc')->paginate(10);
      return view('logs')->with('logs',$logs)->with('title','LOG MẶT HÀNG');
  }
}
