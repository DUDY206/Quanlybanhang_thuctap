@extends('layouts.app')
{{-- @include('returnLogin') --}}
@section('content')
  <div class="card">
    <div class="card-header">
      <h5 class="title">Thông tin cá nhân</h5>
    </div>
    <div class="card-body">
      {!! Form::open(['action' => ['UserInfoController@update',$user->id],'method' => 'POST']) !!}
        <div class="row">
          <div class="col-md-5 pr-1">
            <div class="form-group">
              @if($user->is_active == 0)
                <span class="badge badge-danger">NGHỈ BÁN</span>
              @else
                <span class="badge badge-success">BÁN HÀNG</span>
              @endif
              <label>Tên người bán

              </label>
              {{-- <input type="text" class="form-control" disabled="" placeholder="{{ Auth::user()->ten  }}" > --}}
              {{ Form::text('ten',$user->ten,['class'=>'form-control','placeholder'=>Auth::user()->ten]) }}
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-5 pr-1">
            <div class="form-group">
              <label>Số điện thoại</label>
              {{-- <input type="text" class="form-control" disabled="" placeholder="{{ Auth::user()->sdt  }}" > --}}
              {{ Form::text('sdt',$user->sdt,['class'=>'form-control','placeholder'=>Auth::user()->sdt]) }}

            </div>
          </div>
        </div>
        @if(Auth::user()->id != $user->id)
        <div class="row">
          <div class="col-md-5 pr-1">
            <div class="form-group">
              <label>Chức vụ</label>
              {{-- <input type="text" class="form-control" disabled="" placeholder="{{ Auth::user()->sdt  }}" > --}}
              {{ Form::select('level', ['1' => 'Quản lý', '2' => 'Nhân viên'], $user->level, ['class'=>'form-control','id'=>'level','placeholder' => '----  Chức vụ  ----']) }}
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-5 pr-1">
            <div class="form-group">
              <label>Tình trạng bán hàng</label>
              {{-- <input type="text" class="form-control" disabled="" placeholder="{{ Auth::user()->sdt  }}" > --}}
              {{ Form::select('is_active', ['0' => 'Nghỉ bán', '1' => 'Bán hàng'], $user->is_active, ['class'=>'form-control','id'=>'is_active','placeholder' => '----  Tình trạng  ----']) }}
            </div>
          </div>
        </div>
      @endif
      <div class="row">
          <div class="col-md-5 pr-1">
          {{-- <a href="/userinfo/{{ Auth::user()->id }}/edit" class="btn btn-secondary">Sửa thông tin</a> --}}
          {{ Form::hidden('_method','PUT') }}
        {{ Form::submit('Hoàn tất',['class'=>' btn btn-success']) }}
        </div>
      </div>

      {!! Form::close() !!}

    </div>
  </div>
<script type="text/javascript">
  var level = document.getElementById("level");
  var is_active = document.getElementById("is_active");
  for(var i = 0;i<level.length;i++){
    if(level.options[i].value == $user->level){
        level.options[i].selected = true;

    }
    console.log(i);
}
</script>
@endsection
