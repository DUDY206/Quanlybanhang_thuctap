
@extends('layouts.app')
{{-- @include('returnLogin') --}}
@section('content')
  <div class="card">
                <div class="card-header">
                  <h4 class="card-title"> DANH SÁCH NHÂN VIÊN</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead class=" text-primary">
                        <th>
                          STT
                        </th>
                        <th>
                          Tên
                        </th>
                        <th>
                          SĐT
                        </th>
                        <th>
                          Ngày bắt đầu
                        </th>
                        <th>Trạng thái</th>
                        <th></th>

                        {{-- <th class="text-right">
                          Salary
                        </th> --}}
                      </thead>
                      <tbody>
                          @foreach ($users as $user)
                          {{-- <tr style="background:{{ @if($hang->soluong == 0) red @else green @endif  }}"> --}}
                          <tr style="background: @if($user->is_active == 0) #b1b1b1 @elseif($user->level == 0) #2a4d69 @elseif($user->level == 1) #fe4a49 @elseif($user->level == 2) #2ab7ca  @else #fed766  @endif ">
                            <td>{{ $loop->index+1 }}</td>
                            <td>{{ $user->ten }}</td>
                            <td>{{ $user->sdt }}</td>
                            <td>{{ $user->created_at->format('d-m-Y') }}</td>
                            <td>
                            @if($user->is_active == 1)
                              <span class="badge custom-badge badge-success">Làm việc</span>
                            @else
                              <span class="badge custom-badge badge-danger">Tạm nghỉ  </span>
                            @endif
                            <br>
                            @if($user->level == 0)
                              <span class="badge custom-badge badge-info">admin</span>
                            @elseif($user->level == 1)
                              <span class="badge custom-badge badge-danger">Giám đốc ⁪⁪⁪⁪</span>
                            @elseif($user->level == 2)
                              <span class="badge custom-badge badge-primary">Quản lý ⁪⁪⁪⁪</span>
                            @else
                              <span class="badge custom-badge badge-light">Nhân viên</span>
                            @endif

                             </td>
                            <td>
                              {{-- <a href="/hang/{{ $hang->id }}" class="badge custom-badge badge-danger">Xóa</a> --}}
                              @if(Auth::user()->level ==0)
                              {!!Form::open(['action' => ['UserInfoController@destroy',$user->id],'method' => 'POST'])!!}
                              <a href="/userinfo/{{ $user->id }}/edit" class="btn btn-warning">Sửa</a>



                              {{ Form::hidden('_method','DELETE') }}
                              {{ Form::submit('Xóa',['class'=>'btn btn-danger','onclick'=>'return confirm(\'Are you sure?\')']) }}
                              {!!Form::close()!!}
                            </td>
                              <td>
                                <a href="/userinfo/{{ $user->id }}/resetPassword" class="btn btn-dark">Reset password</a>
                              </td>
                           @endif

                          </tr>
                          @endforeach
                      </tbody>
                    </table>
                    <a href="userinfo/create" class="btn btn-success">Thêm người dùng mới</a>
                  </div>
                </div>
              </div>
@endsection
