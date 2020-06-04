
@extends('layouts.app')
{{-- @include('returnLogin') --}}
@section('content')
              <div class="card">
                <div class="card-header">
                  <h5 class="title">Thông tin cá nhân</h5>
                </div>
                <div class="card-body">
                  <form>
                    <div class="row">
                      <div class="col-md-5 pr-1">
                        <div class="form-group">
                          @if(Auth::user()->is_active == 0)
                            <span class="badge badge-danger">Tạm nghỉ</span>
                          @else
                            <span class="badge badge-success">Làm việc</span>
                          @endif
                          @if(Auth::user()->level == 0)
                            <span class="badge custom-badge badge-info">Admin</span>
                          @elseif(Auth::user()->level == 1)
                            <span class="badge custom-badge badge-danger">Giám đốc ⁪⁪⁪⁪</span>
                          @elseif(Auth::user()->level == 2)
                            <span class="badge custom-badge badge-primary">Quản lý ⁪⁪⁪⁪</span>
                          @else
                            <span class="badge custom-badge badge-light">Nhân viên</span>
                          @endif
                          <br>
                          <label>Tên người bán

                          </label>
                          <input type="text" class="form-control" disabled="" placeholder="{{ Auth::user()->ten  }}" >
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-5 pr-1">
                        <div class="form-group">
                          <label>Số điện thoại</label>
                          <input type="text" class="form-control" disabled="" placeholder="{{ Auth::user()->sdt  }}" >
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-5 pr-1">
                        <div class="form-group">
                          <label>Ngày bắt đầu bán</label>
                          <input type="text" class="form-control" disabled="" placeholder="{{ Auth::user()->created_at  }}" >
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-5 pr-1">
                        <div class="form-group">
                          <label>Lần bán gần nhất</label>
                          <input type="text" class="form-control" disabled="" placeholder="{{Auth::user()->created_at}}" >
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-5 pr-1">
                      <a href="/userinfo/{{ Auth::user()->id }}/edit" class="btn btn-secondary">Sửa thông tin</a>
                    </div>
                  </div>

                  </form>
                </div>
              </div>

@endsection
