@extends('layouts.app')
{{-- @include('returnLogin') --}}
@section('content')
  <div class="card">
                <div class="card-header">
                  <h4 class="card-title"> THỐNG KÊ HÀNG TRONG KHO</h4>
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
                          Số lượng còn
                        </th>
                        <th></th>
                        <th></th>

                        {{-- <th class="text-right">
                          Salary
                        </th> --}}
                      </thead>
                      <tbody>
                          @foreach ($hangs as $hang)
                          {{-- <tr style="background:{{ @if($hang->soluong == 0) red @else green @endif  }}"> --}}
                          <tr style="background: @if($hang->soluong != 0) #3ebf5b @else #f99644 @endif ">
                            <td>{{ $loop->index+1 }}</td>
                            <td>{{ $hang->ten }}</td>
                            <td>{{ $hang->soluong }}</td>
                            @if (Auth::user()->level == 0)
                               <td>
                                {{-- <a href="/hang/{{ $hang->id }}" class="btn btn-danger">Xóa</a> --}}
                                {!!Form::open(['action' => ['HangsController@destroy',$hang->id],'method' => 'POST'])!!}
                                <a href="/hang/{{ $hang->id }}/edit" class="btn btn-warning">Sửa</a>
                                {{ Form::hidden('_method','DELETE') }}
                                {{ Form::submit('Xóa',['class'=>'btn btn-danger','onclick'=>'return confirm(\'Are you sure?\')']) }}
                                {!!Form::close()!!}
                              </td>
                            @endif

                              <td>{{-- Ngay nhap hang cuoi cung --}}</td>
                          </tr>
                          @endforeach
                      </tbody>
                    </table>

                    <a href="hang/create" class="btn btn-success">Thêm mặt hàng mới</a>
                    <a href="hang/logs" class="btn btn-warning">Xem logs</a>
                  </div>
                </div>
              </div>
@endsection
