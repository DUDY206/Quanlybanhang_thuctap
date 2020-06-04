@extends('layouts.app')
{{-- @include('returnLogin') --}}
@section('content')
<h1>{{ route::current()->getName() }}</h1>
  <div class="card">
                <div class="card-header">
                  <h4 class="card-title">{{ $title }}</h4>


                </div>
                <div class="card-body">
                   <div class="row">

                   <div class="col-md-4 ml-0" >
                      <form class="" action="index.html" method="post">


                      <div class="input-group no-border">
                        <input type="text" name="content" value="" class="form-control" placeholder="Tim kiem'" id="searchbox">
                    <div class="input-group-append">
                      <div class="input-group-text">

                       <i class="now-ui-icons ui-1_zoom-bold"></i>
                      </div>
                    </div>
                  </div>
                  </form>

                   </div>
                   <div class="col-md-2">
                      <a type="submit" name="button" id="search_button" class="m-0 btn btn-primary ">Tìm kiếm</a>

                   </div>
                </div>

                  <div class="table-responsive">
                    <table class="table ">
                      <thead class=" text-primary">
                        <th>
                          STT
                        </th>
                        @if( Auth::user()->level <=2)<th></th>@endif
                           @if( $trangthai == 'chuahoantat' && Auth::user()->is_active != 0)<th></th>@endif

                        <th>
                          Người bán
                        </th>
								<th>Hàng</th>
								<th>Số lượng</th>
								<th>Giá bán</th>
                        <th>
                          Người mua
                        </th>
                        <th>SĐT khách</th>
                        <th>Địa chỉ</th>
                        <th>Giảm giá</th>
								<th>Ngày bán</th>

                        {{-- <th class="text-right">
                          Salary
                        </th> --}}
                      </thead>
                      <tbody >

                          @foreach ($banhangs as $banhang)
                          {{-- <tr style="background:{{ @if($hang->soluong == 0) red @else green @endif  }}"> --}}
                          <tr @if($loop->index % 2 == 1) class="table-success" @endif>
									  <?php
										$dsHang = $phieuxuats->get($banhang->banhangid);
										$soluong = $dsHang->count();

									  ?>

                            <td rowspan="{{ $soluong }}">{{ $loop->index+1 }}</td>
                            @if( Auth::user()->level <=2)
                               <td rowspan="{{ $soluong }}"><a href="/banhang/print/{{ $banhang->banhangid }}" class="btn btn-info" target="_blank">
                                  @if($trangthai == 'chuaduyet')In hóa đơn @else Xem hóa đơn @endif</a></td>
                            @endif
                            @if($trangthai == 'chuahoantat' && Auth::user()->is_active != 0)
                               <td rowspan="{{ $soluong }}">
                                  <a href="/themthutien/{{ $banhang->banhangid }}" class="btn btn-primary" style="margin-bottom:10px" target="_blank">Thu tiền</a>

                            {!! Form::open(['action' => ['BanHangController@finished_banhang',$banhang->banhangid],'method' => 'POST']) !!}
                             {{ Form::submit('Hoàn tất COD',['class'=>' btn btn-success','id'=>'submit']) }}
                             {!!Form::close()!!} <br>


                          </td>@endif

									 <td rowspan="{{ $soluong }}"><a href="/banhang/list/{{$banhang->nguoiban_id}}/{{$trangthai}}">{{ $banhang->tennguoiban }}</a></td>
                            @foreach ($dsHang as $hang)
                               @if ($loop->index==0)
                                  <td>{{ $hang->tenhang }}</td>
      									 <td>{{ $hang->soluonghang }}</td>
                                  <td>{{ $hang->giaban }}</td>

                                  <td rowspan="{{ $soluong }}">{{ $banhang->tennguoimua }}</td>
                                  <td rowspan="{{ $soluong }}">{{ $banhang->sdt_kh }}</td>
      									 <td rowspan="{{ $soluong }}">{{ $banhang->diachi }}</td>
      									 <td rowspan="{{ $soluong }}">{{ $banhang->giamgia }}</td>
                                  <td rowspan="{{ $soluong }}">{{ $banhang->ngayban }}</td>
                                  <td rowspan="{{ $soluong }}">
                                     @if (Auth::user()->level<1)
                                        {!!Form::open(['action' => ['BanHangController@destroy',$banhang->banhangid],'method' => 'POST'])!!}
                                        <a href="/banhang/{{ $banhang->banhangid }}/edit" class="btn btn-warning" style="margin-bottom:10px">Sửa</a>

                                        {{ Form::hidden('_method','DELETE') }}
                                        {{ Form::submit('Xóa',['class'=>'btn btn-danger','onclick'=>'return confirm(\'Are you sure?\')']) }}
                                        {!!Form::close()!!}
                                     @endif


                                     {{-- {!!Form::open(['action' => ['Thutien@store'],'method' => 'POST'])!!}
                                     <a href="/thutien/{{ $banhang->banhangid }}/create" class="btn btn-warning">Thu tiền</a>

                                     {{ Form::submit('Xóa',['class'=>'btn btn-danger']) }}
                                     {!!Form::close()!!} --}}
                                  </td>
                                  </tr>
                               @else
                                  <tr @if($loop->parent->index % 2 == 1) class="table-success" @endif>
                                  <td>{{ $hang->tenhang }}</td>
      									 <td>{{ $hang->soluonghang }}</td>
                                  <td>{{ $hang->giaban }}</td>
                                  </tr>
                               @endif

                            @endforeach


                          @endforeach
                      </tbody>
                    </table>


                  </div>
                  <span style="float: right;display:block">{{ $banhangs->links() }}</span>
                  <div style="float: left;display:block">

                  </div>

                </div>
              </div>
<script type="text/javascript">
$(document).ready(function(){
    $("#search_button").click(function(){
        var content = $("#searchbox").val();
        if(content != ''){
             window.location = "/banhang/list/{{$user_id}}/{{$trangthai}}/search/content="+content;
        }
        console.log(window.location.pathname.indexOf('banhang/choxuly'));
        console.log(window.location.pathname == '/banhang' );


    })

    $(window).keydown(function(event){
       if(event.keyCode == 13) {
          var content = $("#searchbox").val();
          if(content != ''){
               window.location = "/banhang/list/{{$user_id}}/{{$trangthai}}/search/content="+content;
          }else{
             console.log('b');
          }
         return false;
       }
  });
});
</script>
@endsection
