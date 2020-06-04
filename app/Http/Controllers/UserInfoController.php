<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Hang;
use App\PhieuNhap;
use App\PhanPhoiHang;

use Auth;
class UserInfoController extends Controller
{



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('is_active','desc')->orderBy('level','asc')->get();
        return view('userinfo.index')->with('users',$users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('userinfo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validate($request,[
        'ten'=>'required',
        'sdt'=>'required|regex:/[0-9]+/',
        'level'=>'required'
      ]);
$user_find = User::where('sdt','=',$request->input('sdt'))->get()->first();
      if($user_find != null){
         return back()->with('error','Đã tồn tại số điện thoại');
      }
      $user = new User;
      $user->ten = $request->input('ten');
      $user->sdt = $request->input('sdt');
      $user->level = $request->input('level');
      $user->password = Hash::make('password');
      $user->is_active = 1;
      $user->save();
      return redirect('userinfo')->with('success','Thêm mới TK '.$user->ten.' thành công <br> ID: '.$user->sdt.'<br> Mật khẩu: password ');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        if($id==Auth::user()->id || Auth::user()->level <= 1){
           return view('userinfo.show');
        }else{
           return back()->with('error','Truy cap bi han che');
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
        $user = User::find($id);
        return view('userinfo.edit')->with('user',$user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
      $this->validate($request,[
        'ten'=>'required',
        'sdt'=>'required|regex:/[0-9]+/',
      ]);
      if($request->level != null && $request->is_active != null){
        $this->validate($request,[
          'level'=>'required',
          'is_active'=>'required',
        ]);
      }
$user_find = User::where('sdt','=',$request->input('sdt'))->get()->first();
      if($user_find != null){
         return back()->with('error','Đã tồn tại số điện thoại');
      }

      $user = User::find($id);
      $user->ten = $request->input('ten');
      $user->sdt = $request->input('sdt');
      if($request->level != null && $request->is_active != null){
        $user->level = $request->input('level');
        $user->is_active = $request->input('is_active');
      }

      $user->save();
      return redirect('userinfo')->with('success','Cập nhật thông tin TK '.$user->ten.' thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {
          $user = User::find($id);
          $ten = $user->ten;
          $user->delete();
          return redirect('userinfo')->with('success','Xóa người dùng '.$ten.' thành công');
        }
        catch(\Illuminate\Database\QueryException $e)
        {
          return redirect('userinfo')->with('error',$e->getMessage());
        }
    }

    public function resetPassword($id){
        if(Auth::user()->level == 0){
            try {
                $user = User::findOrFail($id);
                $user->password = Hash::make('password');
                $user->save();

                return redirect('userinfo')->with('success','Reset password cho '.$user->ten.' thành công');
            } catch (Exception $e) {

            }
        }else{
            return redirect('userinfo')->with('error','Ban khong co quyen reset password');
        }
    }

    function giaphanphoi(){
      $hangs = Hang::select('id','ten')->orderBy('id','asc')->get();
      $users = User::select('id','ten')->where('level','<>','0')->where('is_active','<>','0')->orderBy('level','asc')->get();

      $phanphois = PhanPhoiHang::all();
      $giaphanphoi = collect();
      foreach ($phanphois as $phanphoi) {
         $thongtin = collect([$phanphoi->hangid => $phanphoi->giaphanphoi]);
         if($giaphanphoi->get($phanphoi->nguoibanid) == null){
            $giaphanphoi->put($phanphoi->nguoibanid,$thongtin);
         }else{
            $giaphanphoi->get($phanphoi->nguoibanid)->put($phanphoi->hangid,$phanphoi->giaphanphoi);
         }
      }

      // return $giaphanphoi;
      return view('userinfo.giaphanphoi',compact('hangs','users','giaphanphoi'));
   }

   function save_giaphanphoi(Request $request){
      $hangs = Hang::select('id','ten')->orderBy('id','asc')->get();
     $users = User::select('id','ten')->where('level','<>','0')->where('is_active','<>','0')->orderBy('level','asc')->get();
     // return 'a'
     $names = collect();
     foreach ($hangs as $hang) {
        foreach ($users as $user) {
           $names->push($user->id.'-'.$hang->id);
        }
     }
     foreach ($names as $name) {
        $this->validate($request,[
          $name=>'required|regex:/([0-9]+\,)*[0-9]+/',
       ]);
     }
     foreach ($hangs as $hang) {
        foreach ($users as $user) {
           // ($user->id.'-'.$hang->id);
           $giaphanphoi = PhanPhoiHang::where('nguoibanid','=',$user->id)->where('hangid','=',$hang->id)->first();
           if($giaphanphoi == null){
             $giaphanphoi = new PhanPhoiHang;
             $giaphanphoi->nguoibanid = $user->id;
             $giaphanphoi->hangid = $hang->id;
          }
         $giaphanphoi->giaphanphoi = (int) str_replace(',','',$request->input($user->id.'-'.$hang->id));
         $giaphanphoi->save();
        }
     }
     // return 'a';
     return back()->with('success','Cập nhật bảng giá phân phối hàng CTV thành công');
   }

}
