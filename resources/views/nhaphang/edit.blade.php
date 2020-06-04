@extends('layouts.app')
{{-- @include('returnLogin') --}}
@section('content')
  <div class="card">
    <div class="card-header">
      <h5 class="title">Nhập hàng</h5>
    </div>
    <div class="card-body">
      {!! Form::open(['action' => ['NhapHangController@update',$phieunhap->id],'method' => 'POST']) !!}

        <div class="row">
          <div class="col-md-5 pr-1">
            <div class="form-group">

              <label>Loại hàng </label>
              {{ Form::select('hang_id', $maps, $phieunhap->hang_id, ['class'=>'form-control']) }}

            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-5 pr-1">
            <div class="form-group">
              <label>Số lượng</label>
              {{-- <input type="text" class="form-control" disabled="" placeholder="{{ Auth::user()->sdt  }}" > --}}
              {{ Form::number('soluong',$phieunhap->soluong,['class'=>'form-control','placeholder'=>'0']) }}
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-5 pr-1">
            <div class="form-group">
              <label>Giá nhập</label>
              {{ Form::number('gianhap',$phieunhap->gianhap,['class'=>'form-control','placeholder'=>'0']) }}
            </div>
          </div>
        </div>
       
      <div class="row">
          <div class="col-md-5 pr-1">
        {{ Form::hidden('_method','PUT') }}
        {{ Form::submit('Hoàn tất',['class'=>' btn btn-success']) }}
        <a href="/nhaphang" class="btn btn-primary">Xem lịch sử nhập hàng</a>

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
