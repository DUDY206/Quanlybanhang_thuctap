<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ThuTien;
use App\BanHang;
use Carbon\Carbon;

class ThutienController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $thutiens = ThuTien::join('banhang','banhang.id','=','banhang_id')->where('nguoiban_id','=',$id)->select('thutien.id','banhang_id','phuongthucthanhtoan','sotien','ngay')->orderBy('ngay','desc')->paginate(10);

        return view('thutien.show',compact('thutiens'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function thutien($banhang_id){
      return view('thutien.create',compact('banhang_id'));
   }
   public function thutien_success(Request $request,$banhang_id){
      $this->validate($request,[
        'trangthai'=>'required',
        'sotien'=>'required|regex:/([0-9]+\,)*[0-9]+/',
      ]);
      if($request->input('trangthai') == 'them'){
         $this->validate($request,[
           'phuongthucthanhtoan'=>'required',
         ]);

      }else{
         $banhang = BanHang::find($banhang_id);
         $banhang->trangthai = 1;
         $banhang->ngayhoantat = Carbon::now();
         $banhang->save();
      }
      $thutien = new ThuTien;
      $thutien->banhang_id = $banhang_id;
      $thutien->phuongthucthanhtoan = $request->input('phuongthucthanhtoan');
      $thutien->sotien = (int) str_replace(',','',$request->input('sotien'));
      $thutien->ngay = Carbon::now();
      $thutien->save();
     // return view('thutien.create');
  }
}
