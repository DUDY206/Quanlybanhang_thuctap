@extends('layouts.app')
{{-- @include('returnLogin') --}}
@section('content')

   <div class="panel-header panel-header-lg">
  <canvas id="canvas"></canvas>
</div>
<div class="content">
   @if ($user_id != 'all')
      <div class="row"><div class="col-md-12"><h3>Lương: {{ number_format($tongluong) }}(VNĐ)</h3>  </div></div>
   @endif
  <div class="row">
     <div class="col-lg-6">
      <div class="card">
                     <div class="card-header">
                       <h4 class="card-title">Phân loại tiền đã thu theo ngân hàng </h4>
                     </div>
                     <div class="card-body">
                        <div class="row">
                     </div>
                     <canvas id="chart-area"></canvas>


                     </div>
                   </div>
   </div>
   <div class="col-lg-6">
    <div class="card">
                   <div class="card-header">
                     <h4 class="card-title">Thống kê tiền hàng đã bán</h4>
                   </div>
                   <div class="card-body">
                      <div class="row">
                   </div>
                   <table class="table">
                      <thead>
                        <th>Ngân hàng</th>
                         <th>Tổng tiền</th>
                      </thead>
                      <tbody>
                         @php
                           $tongthutheonganhang->each(function($item,$key){
                              echo "<tr><td>".$key."</td><td>".number_format($item)."</td></tr>";
                           });
                         @endphp
                      </tbody>
                   </table>

                   </div>
                 </div>
</div>
    <div class="col-lg-12">
      <div class="card">
                    <div class="card-header">
                      <h4 class="card-title">Thống kê tiền hàng đã bán</h4>
                    </div>
                    <div class="card-body">
                       <div class="row">
                    </div>

                       <div class="table-responsive dragscroll" style="overflow: scroll; cursor: grab; cursor : -o-grab; cursor : -moz-grab; cursor : -webkit-grab;">
                        <table class="table " id='thongke'  >
                          <thead class=" text-primary">
                            <th>
                               Tháng
                            </th>
                           @for ($i=1; $i <= $maxthang; $i++)
                              @if (isset($month))
                                <th><a href="/thongke/{{ $user_id }}/{{ $year }}/{{ $month }}/{{ $i }}">{{ $i }}</a></th>
                             @else
                                <th><a href="/thongke/{{ $user_id }}/{{ $year }}/{{ $i }}">{{ $i }}</a></th>
                             @endif
                           @endfor
                           <th>Tổng cả năm</th>
                          </thead>
                          <tbody>
                             @php
                                $tongtien = 0;
                                $tongsoluong = 0;
                             @endphp
                             @foreach ($dsHang as $hang)
                                @php
                                   $tongtienthang = 0;
                                @endphp
                             <tr>
                                <td class="sticky">{{ $hang->ten }}</td>
                                @for ($i=1; $i <= $maxthang; $i++)
                                   @if($collection->get($i) == null || $collection->get($i)->get($hang->id) == null)
                                      <td>0</td>
                                   @else
                                      <td>{{ number_format($collection->get($i)->get($hang->id)->get('tongtien')) }}</td>
                                      @php
                                        $tongtien += $collection->get($i)->get($hang->id)->get('tongtien');
                                        $tongsoluong += $collection->get($i)->get($hang->id)->get('soluongban');
                                        $tongtienthang += $collection->get($i)->get($hang->id)->get('tongtien');
                                     @endphp
                                   @endif
                                 @endfor
                                 <td>{{ number_format($tongtienthang) }}</td>
                              </tr>
                             @endforeach

                             <tr style="color:red">
                                <td>Tiền bán theo tháng:</td>
                                @for ($i=1; $i <= $maxthang; $i++)
                                   <td>{{ number_format($tienhangthang->get($i)) }}</td>
                                @endfor
                             </tr>
                             <tr>
                                <td colspan="{{ $maxthang+1 }}" style="text-align:right"><b>Tổng tiền hàng đã bán:</b></td><td><b> {{ number_format($tongtien) }}(VNĐ)</b></td>
                             </tr>
                              @php
                              $tongtiennhap =0;
                              @endphp
                              @if ($user_id == 'all')
                                 @for ($i=1; $i <= $maxthang; $i++)
                                   @if($tiennhap_thang->get($i)!=null)
                                      @php
                                         $tongtiennhap+=$tiennhap_thang->get($i);
                                      @endphp
                                   @endif
                                @endfor
                              @endif
                              @if($user_id=='all')

                             <tr>
                                <td colspan="{{ $maxthang+1 }}" style="text-align:right"><b>Tổng tiền hàng đã nhập:</b></td><td><b> {{ number_format(-$tongtiennhap) }}(VNĐ)</b></td>
                             </tr>
                             <tr>
                                <td colspan="{{ $maxthang+1 }}" style="text-align:right"><b>Tổng lãi thuần:</b></td><td><b> {{ number_format($tongtien+$tongtiennhap) }}(VNĐ)</b></td>
                             </tr>
                          @else
                             <tr>
                                <td colspan="{{ $maxthang+1 }}" style="text-align:right"><b>Lương:</b></td><td><b> {{ number_format($tongluong) }}(VNĐ)</b></td>
                             </tr>
                          @endif
                             <tr>
                                <td colspan="{{ $maxthang+1 }}" style="text-align:right"><b>Đã thu:</b></td><td><b> {{ number_format($tongthucanam) }}(VNĐ)</b></td>
                             </tr>
                             <tr>
                                <td colspan="{{ $maxthang+1 }}" style="text-align:right"><b>Chưa thu:</b></td><td><b> {{ number_format($tongtien-$tongthucanam) }}(VNĐ)</b></td>
                             </tr>

                          </tbody>
                        </table>


                      </div>


                    </div>
                  </div>
   </div>
   <div class="col-lg-12">
     <div class="card">
                   <div class="card-header">
                     <h4 class="card-title">Thống kê số lượng hàng đã bán</h4>
                   </div>
                   <div class="card-body">
                      <div class="row">
                   </div>

                     <div class="table-responsive dragscroll" style="overflow: scroll; cursor: grab; cursor : -o-grab; cursor : -moz-grab; cursor : -webkit-grab;">

                       <table class="table " id='thongke' >
                        <thead class=" text-primary">
                           <th>
                              Tháng
                           </th>
                          @for ($i=1; $i <= $maxthang; $i++)
                             @if (isset($month))
                                <th><a href="/thongke/{{ $user_id }}/{{ $year }}/{{ $month }}/{{ $i }}">{{ $i }}</a></th>
                             @else
                                <th><a href="/thongke/{{ $user_id }}/{{ $year }}/{{ $i }}">{{ $i }}</a></th>
                             @endif
                          @endfor
                          <th>Tổng cả năm</th>
                        </thead>
                        <tbody>
                           @php

                              $tongtheothang = collect();
                           @endphp
                           @foreach ($dsHang as $hang)
                           <tr>
                              <td>{{ $hang->ten }}</td>
                              @php
                                 $tongtheohang = 0;
                              @endphp
                              @for ($i=1; $i <= $maxthang; $i++)
                                  @if($collection->get($i) == null || $collection->get($i)->get($hang->id) == null)
                                     <td>0</td>
                                  @else
                                     <td>{{ number_format($collection->get($i)->get($hang->id)->get('soluongban')) }}</td>
                                     @php
                                        $tongtheohang+=$collection->get($i)->get($hang->id)->get('soluongban');
                                        if($tongtheothang->get($i) == null){
                                           $tongtheothang->put($i,$collection->get($i)->get($hang->id)->get('soluongban'));
                                        }else{
                                           $tongtheothang->put($i,$tongtheothang->get($i)+$collection->get($i)->get($hang->id)->get('soluongban'));
                                        }
                                     @endphp

                                  @endif


                                @endfor
                                <td>{{ number_format($tongtheohang) }}</td>
                             </tr>
                           @endforeach

                           <tr style="color:red">
                              <td>Tổng theo tháng</td>
                             @for ($i=1; $i <= $maxthang; $i++)
                                 <td>{{ number_format($tongtheothang->get($i)) }}</td>
                             @endfor
                           </tr>
                           <tr>

                              <td colspan="{{ $maxthang+1 }}" style="text-align:right"><b>Tổng số lượng bán: </b></td>
                              <td><b>{{ number_format($tongsoluong) }} (đôi)</b> </td>
                           </tr>
                           @if($user_id == 'all')
                           <tr>

                              <td colspan="{{ $maxthang+1 }}" style="text-align:right"><b>Tổng số lượng đã nhập: </b></td>
                              <td><b>{{ number_format($soluongnhap->first()->soluongnhap) }} (đôi)</b> </td>
                           </tr>
                           @endif
                        </tbody>
                       </table>

                      @if (isset($month))
                        <a href="/thongke/{{ $user_id }}/{{ $year }}" class="btn btn-success">Xem thống kê năm</a>
                      @endif
                     </div>


                   </div>
                 </div>
  </div>

  </div>
  </div>
  <script type="text/javascript">

  </script>
<script src="/js/chart/Chart.min.js"></script>
<script src="/js/chart/utils.js"></script>
<script src="/js/chart/draw.js"></script>
<script type="text/javascript">
var a =  <?php echo json_encode($tienhangthang)?>;
var b =  <?php echo json_encode($tongthutheothang)?>;
@if ($user_id == 'all')
   var c = <?php echo json_encode($tiennhap_thang)?>;
   var d = new Object;
   Object.keys(c).forEach((item,i)=>{
                          d[item] = Number(a[item])+Number(c[item]);}
   )
@else
   var luong =  <?php echo json_encode($luong)?>;
@endif
var tongthutheonganhang = <?php echo json_encode($tongthutheonganhang)?>;

var list_data = [['Đã bán',Object.values(a)],['Đã thu',Object.values(b)]@if ($user_id == 'all'),['Đã nhập',Object.values(c)],['Lãi',Object.values(d)]@else ,['Lương',Object.values(luong)] @endif];
   $(document).ready(function() {
      draw(Object.keys(a),list_data);
      DrawChartPie(Object.keys(tongthutheonganhang),Object.values(tongthutheonganhang));
   });
</script>
<script type="text/javascript">
$(document).ready(function() {
    var table = $('table').DataTable( {
        scrollCollapse: true,
        paging:         false,
        fixedColumns:   {
            leftColumns: 3
        }
    } );
} );
</script>

@endsection
