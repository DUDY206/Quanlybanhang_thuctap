@extends('layouts.app')
{{-- @include('returnLogin') --}}
@section('content')

  <div class="card">
                <div class="card-header">
                  <h4 class="card-title">LỊCH SỬ THU TIỀN</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead class=" text-primary">
                        <th>
                          STT
                        </th>
                        <th>
                          Phương thức thanh toán
                        </th>
                        <th>
                          Số tiền
                        </th>
                        <th>Ngày giao dịch</th>

                        {{-- <th class="text-right">
                          Salary
                        </th> --}}
                      </thead>
                      <tbody>
                          @foreach ($thutiens as $thutien)
                          {{-- <tr style="background:{{ @if($hang->soluong == 0) red @else green @endif  }}"> --}}
                          <tr @if($loop->index % 2 == 1) class="table-success" @endif>
                            <td>{{ $loop->index+1 }}</td>
                            <td>{{ $thutien->phuongthucthanhtoan }}</td>
                            <td>{{ number_format($thutien->sotien) }}</td>
                            <td>{{ $thutien->ngay }}</td>

                            <td>
                              {{-- <a href="/hang/{{ $hang->id }}" class="badge custom-badge badge-danger">Xóa</a> --}}
                              @if (Auth::user()->level == 0)
                                 {!!Form::open(['action' => ['ThutienController@destroy',$thutien->id],'method' => 'POST'])!!}
                                 <a href="/thutien/{{ $thutien->id }}/edit" class="btn btn-warning">Sửa</a>

                                 {{ Form::hidden('_method','DELETE') }}
                                 {{ Form::submit('Xóa',['class'=>'btn btn-danger','onclick'=>'return confirm(\'Are you sure?\')']) }}
                                 {!!Form::close()!!}
                              @endif

                            </td>
									 <td><a href="/banhang/{{ $thutien->banhang_id }}"  target="_blank">Xem đơn hàng</a> </td>
                          </tr>
                          @endforeach
                      </tbody>
                    </table>
                    <span style="float: right">{{ $thutiens->links() }}</span>


                  </div>
                </div>
              </div>

@endsection
