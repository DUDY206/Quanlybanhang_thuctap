@extends('layouts.app')
{{-- @include('returnLogin') --}}
@section('content')

  <div class="card">
    <div class="card-header">
      <h5 class="title">Đơn hàng mới</h5>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        {!! Form::open(['action' => ['BanHangController@store'],'method' => 'POST']) !!}

        <table class="table">
          <thead class=" text-primary" style="display: block !important;">
            <th>
            </th>
          </thead>
          <tbody style="display: block !important; overflow-y: auto;overflow-x: hidden;">
            <tr><td>Tên người mua:</td>
              <td>
                {{ Form::text('tennguoimua', null) }}
                @if ($errors->has('tennguoimua'))<i style="color:red"> {{ $errors->first('tennguoimua') }}!</i> @endif
              </td>
            </tr>
            <tr><td>Số điện thoại:</td>
              <td>{{ Form::text('sdt', null) }}
                @if ($errors->has('sdt'))<i style="color:red"> {{ $errors->first('sdt') }}!</i> @endif
              </td>
            </tr>
            <tr><td>Địa chỉ:</td>
              <td>{{ Form::textarea('diachi', null) }}   @if ($errors->has('diachi'))<i style="color:red"> {{ $errors->first('diachi') }}!</i> @endif</td>
            </tr>
            <tr><td>Thanh toán:</td>
              <td>{{ Form::radio('trangthai', '3',true) }}<label for="3"> Coc</label><br>
                {{ Form::radio('trangthai','2') }}<label for="2"> Thanh toan het</label>
              </td>
            </tr>
            <tr><td>Phương thức thanh toan:</td>
              <td>{{ Form::select('phuongthucthanhtoan', ['tienmat'=>'Tien mat','VietComBank'=>'VietComBank','VietinBank'=>'VietinBank','TechcomBank'=>'TechcomBank','BIDV'=>'BIDV','VPBank'=>'VPBank','khac'=>'Khac']) }}</td>
            </tr>
            <tr><td>Số tiền đã chuyển:</td>
              <td>{{ Form::text('sotien', null,['class'=>'money']) }} @if ($errors->has('sotien'))<i style="color:red"> {{ $errors->first('sotien') }}!</i> @endif </td>
            </tr>
            <tr><td>Giảm giá:</td>
              <td>{{ Form::text('giamgia', '0',['class'=>'money']) }}@if ($errors->has('giamgia'))<i style="color:red"> {{ $errors->first('giamgia') }}!</i> @endif</td>
            </tr>
            <tr ><td colspan= "2" id="dsachHang">
              <div class="row">
                  <div class="col-md-3">Tên hàng</div>
                  <div class="col-md-3">Số lượng</div>
                  <div class="col-md-3">Giá bán / 1 đôi </div>
              </div>

              <div class="row dsHang" style="margin-top:15px" >
                  <div class="col-md-3 col-sm-12">{{ Form::select('hang_id', $hangs,'',['class'=>'tenhang','id'=>'tenhang_id','style'=>'width:100% !important;height:100% !important']) }}</div>
                  <div class="col-md-3 col-sm-12">{{ Form::number('soluonghang', null,['placeholder'=>'Số lượng','class'=>'soluonghang','style'=>'width:100% !important;height:100% !important']) }}</div>
                  <div class="col-md-3 col-sm-12">{{ Form::text('giabanhang', null,['placeholder'=>'Giá bán','class'=>'giabanhang money','style'=>'width:100% !important;height:100% !important']) }}</div>
                  <div class="col-md-2 col-sm-12">
                      <h4 style="line-height:0 !important;margin: 0 !important">
                        <a href="#" class="badge  badge-success xoaHang" style="padding:4.5px 9px" >-</a>
                      </h4></div>
              </div>

              </td>
            </tr>
            <tr>
              <td>
                <a href="#" class="btn  btn-secondary" id="test">Thêm hàng</a>
                {{-- <a href="#" class="badge  badge-secondary" id="demo">Xem selected</a> --}}
              </td>
            </tr>
          </tbody>
        </table>

        {{ Form::submit('Hoàn tất',['class'=>' btn btn-success','id'=>'submit']) }}


      </div>
      {!! Form::close() !!}

    </div>
  </div>
  </div>
  <script type="text/javascript">

      $(document).ready(function(){
          $('.money').simpleMoneyFormat();
          $("#test").click(function(){
              var $clone = $(".dsHang").first().clone(true);
              var index = $( ".dsHang" ).length -1;
              $("#dsachHang").append($clone);
              $(".xoaHang").last().click(function(){
                    // $(".dsHang").eq(index).remove();
                    $(this).parent().parent().parent().remove();
              })
              $('.money').simpleMoneyFormat();
          });

          $("#submit").click(function(){
              $(".dsHang").each(function(index){
                  $(this).children().eq(0).children().eq(0).attr("name","hang_id-"+index);
                  $(this).children().eq(1).children().eq(0).attr("name","soluonghang-"+index);
                  $(this).children().eq(2).children().eq(0).attr("name","giabanhang-"+index);
              })
          })

      });
  </script>
@endsection
