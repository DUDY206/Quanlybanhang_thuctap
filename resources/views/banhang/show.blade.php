@extends('layouts.app')
{{-- @include('returnLogin') --}}
@section('content')
  <div class="card">
    <div class="card-header">
      <h5 class="title">Xem bán hàng</h5>
    </div>
    <div class="card-body">
      <div class="table-responsive">
<form>

        <table class="table">
          <thead class=" text-primary" style="display: block !important;">
            <th>
            </th>
          </thead>
          <tbody style="display: block !important; overflow-y: auto;overflow-x: hidden;">
            <tr><td>Tên người mua:</td>
              <td>
                {{ Form::text('tennguoimua', $banhang->tennguoimua,['disabled'=>'']) }}
                @if ($errors->has('tennguoimua'))<i style="color:red"> {{ $errors->first('tennguoimua') }}!</i> @endif
              </td>
            </tr>
            <tr><td>Số điện thoại:</td>
              <td>{{ Form::text('sdt', $banhang->sdt,['disabled'=>'']) }}
                @if ($errors->has('sdt'))<i style="color:red"> {{ $errors->first('sdt') }}!</i> @endif
              </td>
            </tr>
            <tr><td>Địa chỉ:</td>
              <td>{{ Form::textarea('diachi', $banhang->diachi,['disabled'=>'']) }}   @if ($errors->has('diachi'))<i style="color:red"> {{ $errors->first('diachi') }}!</i> @endif</td>
            </tr>

            <tr><td>Giảm giá:</td>
              <td>{{ Form::text('giamgia', $banhang->giamgia,['class'=>'money','disabled'=>'']) }}@if ($errors->has('giamgia'))<i style="color:red"> {{ $errors->first('giamgia') }}!</i> @endif</td>
            </tr>
            <tr ><td colspan= "2" id="dsachHang">
              <div class="row">
                  <div class="col-md-3">Tên hàng</div>
                  <div class="col-md-3">Số lượng</div>
                  <div class="col-md-3">Giá bán / 1 đôi </div>
              </div>
              @foreach ($dsHang as $hang)

              <div class="row dsHang" style="margin-top:15px" >
                  <div class="col-md-3 col-sm-12">{{ Form::select('hang_id', $hangs,$hang->hang_id,['class'=>'tenhang','disabled'=>'','id'=>'tenhang_id','style'=>'width:100% !important;height:100% !important']) }}</div>
                  <div class="col-md-3 col-sm-12">{{ Form::number('soluonghang', $hang->soluong,['placeholder'=>'Số lượng','disabled'=>'','class'=>'soluonghang','style'=>'width:100% !important;height:100% !important']) }}</div>
                  <div class="col-md-3 col-sm-12">{{ Form::text('giabanhang', $hang->giaban,['placeholder'=>'Giá bán','disabled'=>'','class'=>'giabanhang money','style'=>'width:100% !important;height:100% !important']) }}</div>
                  <div class="col-md-2 col-sm-12">
                      <h4 style="line-height:0 !important;margin: 0 !important">
                        <a href="#" class="badge  badge-success xoaHang" style="padding:4.5px 9px" >-</a>
                      </h4></div>
              </div>
           @endforeach

              </td>
            </tr>

          </tbody>
        </table>



      </div>
      {!! Form::close() !!}

    </div>
  </div>
  </div>
  <script type="text/javascript">

      $(document).ready(function(){
          $('.money').simpleMoneyFormat();

      });
  </script>
@endsection
