@extends('layouts.app')
{{-- @include('returnLogin') --}}
@section('content')
  {{-- <h1>{{ Auth::user()->password }}</h1> --}}
  <div class="card">
    <div class="card-header">
      <h5 class="title">Thông tin cá nhân</h5>
    </div>
    <div class="card-body">
      {!! Form::open(['action' => ['ChangePassword@update',Auth::user()->id],'method' => 'POST']) !!}
        <div class="row">
          <div class="col-md-5 pr-1">
            <div class="form-group">
              <label>Mật khẩu cũ</label>
              {{ Form::text('old_password','',['class'=>'form-control']) }}
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-5 pr-1">
            <div class="form-group">
              <label>Mật khẩu mới</label>
              {{ Form::text('new_password','',['class'=>'form-control']) }}
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-5 pr-1">
            <div class="form-group">
              <label>Nhập lại mật khẩu</label>
                {{ Form::text('confirm_password','',['class'=>'form-control']) }}
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-5 pr-1">
            <div class="form-group">
              {{ Form::hidden('_method','PUT') }}
              {{ Form::submit('Hoàn tất',['class'=>' btn btn-success']) }}
            </div>
          </div>
        </div>


      </form>
    </div>
  </div>

@endsection
