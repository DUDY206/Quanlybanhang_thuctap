@extends('layouts.app')
{{-- @include('returnLogin') --}}
@section('content')
</div>
<div class="col-md-6">
  <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Hàng trong ngày</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead >
                        <th>Tên hàng</th>
								<th>Số lượng</th>
                      </thead>
                      <tbody>
									 @php
										$tongtien = 0;
										$tongluong = 0;
										$tongsoluong = 0;
									 @endphp
									 @foreach ($phieuxuat as $hang)
										 @php
											 $tongtien += $hang->tongtien;
											 $tongluong += $hang->tienluong;
											 $tongsoluong += $hang->soluongban;
										 @endphp
										 <tr>
											 <td>{{$hang->ten }}</td>
											 <td>{{$hang->soluongban }}</td>
										 </tr>
									 @endforeach
									 <tr style="color:red">
									 	<td>Tổng cộng</td>
										<td>{{ $tongsoluong }}</td>
									 </tr>
                      </tbody>
                    </table>



                  </div>
                </div>
              </div>
</div>
<div class="col-md-6">
	<div class="card">
					  <div class="card-header">
						 <h4 class="card-title">Tiền thu trong ngày</h4>
					  </div>
					  <div class="card-body">
						 <div class="table-responsive">


							<table class="table">
							 <thead >
								<th>Ngân hàng</th>
								<th>Số tiền</th>
							 </thead>
							 <tbody>
									 @php
										$tong = 0;
									 @endphp
									 @foreach ($thutien as $tien)
										 @php
											 $tong += $tien->tongtien;
										 @endphp
										 <tr>
											 <td>{{$tien->phuongthucthanhtoan }}</td>
											 <td>{{$tien->tongtien }}</td>
										 </tr>
									 @endforeach

							 </tbody>
							</table>
							<p><b>Tiền đã bán: </b>{{ number_format($tongtien) }}(VND)</p>
						 @if ($user_id != 'all')
						 	<p><b>Tiền lương: </b>{{ number_format($tongluong) }}(VND)</p>
						 @endif
							<p><b>Tiền đã thu: </b>{{ number_format($tong) }}(VND)</p>
							<a href="/thongke/{{ $user_id }}/{{ $year }}/{{ $month }}" class="btn btn-success">Xem thống kê tháng</a>
							<a href="/thongke/{{ $user_id }}/{{ $year }}" class="btn btn-success">Xem thống kê năm</a>
						 </div>
					  </div>
					</div>
</div>
@endsection
