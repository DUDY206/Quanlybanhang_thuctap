@extends('layouts.app')
{{-- @include('returnLogin') --}}
@section('content')

  <div class="card">
                <div class="card-header">
                  <h4 class="card-title">LOG NHẬP HÀNG</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead class=" text-primary">
                        <th>

                          STT
                        </th>
                        <th>
                          Phương thức
                        </th>
                        <th>
                          Nội dung
                        </th>
                        <th>Thời gian</th>
                        {{-- <th class="text-right">
                          Salary
                        </th> --}}
                      </thead>
                      <tbody>
                          @foreach ($logs as $log)
                          {{-- <tr style="background:{{ @if($hang->soluong == 0) red @else green @endif  }}"> --}}
                          <tr @if($loop->index % 2 == 1) class="table-success" @endif>
                            <td>{{ $loop->index+1 }}</td>
                            <td>{{ $log->phuongthuc }}</td>
                            <td>{{ $log->noidung }}</td>
                            <td>{{ $log->thoigian }}</td>
                            <td><a href="/nhaphang/{{ $log->nhaphang_id  }}" class="btn btn-success">TT hiện tại</a></td>

                          </tr>
                          @endforeach
                      </tbody>
                    </table>
                    <span style="float: right">{{ $logs->links() }}</span>
                  </div>
                </div>
              </div>

@endsection
