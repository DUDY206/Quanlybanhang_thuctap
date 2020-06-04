@extends('layouts.app')
{{-- @include('returnLogin') --}}
@section('content')

  <div class="card">
              <div class="card-header">
                <h5 class="title">Sửa mặt hàng {{  $hang->id}}</h5>
              </div>
              <div class="card-body">
  {!! Form::open(['action' => ['HangsController@update',$hang->id],'method' => 'POST']) !!}
  <div class="row">
    <div class="col-md-12 pr-1">
      <div class="form-group">
        <label>Tên hàng</label>
    {{ Form::text('ten',$hang->ten,['class'=>'form-control','placeholder'=>'Tên hàng']) }}
      {{-- @if ($errors->has('ten'))
        <span class="error_message "role="alert">
            {{ $errors->first('ten') }}
        </span>
      @endif --}}
  </div>
</div>

<div class="col-md-12 pr-1">
  <div class="form-group">
    <label>Số lượng</label>
    {{ Form::text('soluong',$hang->soluong,['class'=>'form-control','placeholder'=>'0']) }}
  </div>
</div>
<div class="col-md-12 pr-1">
  {{ Form::hidden('_method','PUT') }}
{{ Form::submit('Hoàn tất',['class'=>' btn btn-success']) }}
</div>
  {!! Form::close() !!}
</div>
@endsection
