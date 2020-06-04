@extends('layouts.app')
{{-- @include('returnLogin') --}}
@section('content')
  <div class="card">
    <div class="card-header">
      <h5 class="title">Thông tin hàng</h5>
    </div>
    <div class="card-body">
      <form>


        <div class="row">
          <div class="col-md-5 pr-1">
            <div class="form-group">

              <label>Loại hàng </label>
              {{ Form::text('hang_id', $hang, ['class'=>'form-control','disabled'=>'']) }}

            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-5 pr-1">
            <div class="form-group">
              <label>Số lượng</label>
              {{-- <input type="text" class="form-control" disabled="" placeholder="{{ Auth::user()->sdt  }}" > --}}
              {{ Form::number('soluong',$phieunhap->soluong,['class'=>'form-control','disabled'=>'']) }}
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-5 pr-1">
            <div class="form-group">
              <label>Giá nhập</label>
              {{ Form::number('gianhap',$phieunhap->gianhap,['class'=>'form-control','disabled'=>'']) }}
            </div>
          </div>
        </div>

      <div class="row">
          <div class="col-md-5 pr-1">
        <a href="/nhaphang" class="btn btn-primary">Xem lịch sử nhập hàng</a>
        <a href="/nhaphang/logs" class="btn btn-primary">Xem log</a>

        </div>
      </div>

      {!! Form::close() !!}
      <div class="row">
          <div class="col-md-5 pr-1">
        </div>
      </div>
    </div>
  </div>
@endsection
