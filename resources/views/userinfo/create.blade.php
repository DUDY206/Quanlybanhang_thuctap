@extends('layouts.app')
{{-- @include('returnLogin') --}}
@section('content')
  <div class="card">
    <div class="card-header">
      <h5 class="title">Thông tin cá nhân</h5>
    </div>
    <div class="card-body">
      {!! Form::open(['action' => ['UserInfoController@store'],'method' => 'POST']) !!}
        <div class="row">
          <div class="col-md-5 pr-1">
            <div class="form-group">

              <label>Tên người bán

              </label>
              {{-- <input type="text" class="form-control" disabled="" placeholder="{{ Auth::user()->ten  }}" > --}}
              {{ Form::text('ten','',['class'=>'form-control','placeholder'=>'Tên người dùng']) }}
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-5 pr-1">
            <div class="form-group">
              <label>Số điện thoại</label>
              {{-- <input type="text" class="form-control" disabled="" placeholder="{{ Auth::user()->sdt  }}" > --}}
              {{ Form::text('sdt','',['class'=>'form-control','placeholder'=>'0123.456.789']) }}
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-5 pr-1">
            <div class="form-group">
              <label>Chức vụ</label>
              {{ Form::select('level', ['2' => 'Quản lý', '3' => 'Nhân viên'], null, ['class'=>'form-control','placeholder' => 'Chức vụ']) }}
            </div>
          </div>
        </div>
      <div class="row">
          <div class="col-md-5 pr-1">
          {{-- <a href="/userinfo/{{ Auth::user()->id }}/edit" class="btn btn-secondary">Sửa thông tin</a> --}}
        {{ Form::submit('Hoàn tất',['class'=>' btn btn-success']) }}
        </div>
      </div>

      {!! Form::close() !!}

    </div>
  </div>
@endsection
