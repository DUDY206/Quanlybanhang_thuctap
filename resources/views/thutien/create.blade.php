@extends('layouts.app')
{{-- @include('returnLogin') --}}
@section('content')

   @extends('layouts.app')
   {{-- @include('returnLogin') --}}
   @section('content')

     <div class="card">
       <div class="card-header">
         <h5 class="title">Thu tiền hàng</h5>
       </div>
       <div class="card-body">
         <div class="table-responsive">
           {!! Form::open(['action' => ['ThuTienController@thutien_success',$banhang_id],'method' => 'POST']) !!}

           <table class="table">
             <thead class=" text-primary" style="display: block !important;">
               <th>
               </th>
             </thead>
             <tbody style="display: block !important; overflow-y: auto;overflow-x: hidden;">
               <tr><td>Hình thức:</td>
                 <td>
                    {{ Form::radio('trangthai', 'them',true) }}<label for="them"> Thêm thu tiền mới</label><br>
                    {{ Form::radio('trangthai','xong') }}<label for="xong"> Thanh toan lần cuối</label>
                 </td>
               </tr>
               <tr><td>Phương thức thanh toán</td>
                 <td>{{ Form::select('phuongthucthanhtoan', ['tienmat'=>'Tien mat','VietComBank'=>'VietComBank','VietinBank'=>'VietinBank','TechcomBank'=>'TechcomBank','BIDV'=>'BIDV','VPBank'=>'VPBank','khac'=>'Khac']) }}
                 </td>
               </tr>
               <tr><td>Số tiền</td>
                 <td>  {{ Form::text('sotien', null,['class'=>'money']) }}</td>

             </tbody>
           </table>

           {{ Form::submit('Hoàn tất',['class'=>' btn btn-success']) }}


         </div>
         {!! Form::close() !!}

       </div>
     </div>
     </div>
     <script type="text/javascript">

         $(document).ready(function(){
             $('.money').simpleMoneyFormat();
            
         });
     </script>
   @endsection

   /////////////////////////////////////////////

@endsection
