@extends('layouts.app')
{{-- @include('returnLogin') --}}
@section('content')

  <div class="card">
                <div class="card-header">
                  <h4 class="card-title">LỊCH SỬ NHẬP HÀNG</h4>
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
                          Số lượng nhập
                        </th>
                        <th>Giá nhập</th>
                        <th>Ngày nhập</th>

                        {{-- <th class="text-right">
                          Salary
                        </th> --}}
                      </thead>
                      <tbody>
                          @foreach ($phieunhaps as $phieunhap)
                          {{-- <tr style="background:{{ @if($hang->soluong == 0) red @else green @endif  }}"> --}}
                          <tr @if($loop->index % 2 == 1) class="table-success" @endif>
                            <td>{{ $loop->index+1 }}</td>
                            <td>{{ $phieunhap->ten }}</td>
                            <td>{{ $phieunhap->soluong }}</td>
                            <td>{{ $phieunhap->gianhap }}</td>
                            <td >{{ \Carbon\Carbon::parse($phieunhap->ngaynhap)->format('d/m/Y')}}</td>

                            <td>
                              {{-- <a href="/hang/{{ $hang->id }}" class="badge custom-badge badge-danger">Xóa</a> --}}
                              @if (Auth::user()->level == 0)
                                 {!!Form::open(['action' => ['NhapHangController@destroy',$phieunhap->id],'method' => 'POST'])!!}
                                 <a href="/nhaphang/{{ $phieunhap->id }}/edit" class="btn btn-warning">Sửa</a>

                                 {{ Form::hidden('_method','DELETE') }}
                                 {{ Form::submit('Xóa',['class'=>'btn btn-danger','onclick'=>'return confirm(\'Are you sure?\')']) }}
                                 {!!Form::close()!!}
                              @endif

                            </td>
                          </tr>
                          @endforeach
                      </tbody>
                    </table>
                    <span style="float: right">{{ $phieunhaps->links() }}</span>
                    <a href="/nhaphang/create" class="btn btn-success">Thêm nhập hàng mới</a>
                    <a href="/nhaphang/logs" class="btn btn-primary">Xem log</a>

                  </div>
                </div>
              </div>

@endsection
