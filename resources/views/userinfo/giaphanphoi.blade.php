@extends('layouts.app')
{{-- @include('returnLogin') --}}
@section('content')
	<div class="card">
                 <div class="card-header">
                   <h4 class="card-title">BẢNG PHÂN PHỐI GIÁ CTV</h4>
                 </div>
                 <div class="card-body">
                   <div class="table-responsive">
                     <table border="1">
                       <thead class=" text-primary">
								  <th></th>
                         @foreach ($hangs as $hang)
									 <th >{{ $hang->ten }}</th>
                         @endforeach


                       </thead>
                       <tbody>
								  {!!Form::open(['action' => ['UserInfoController@save_giaphanphoi'],'method' => 'POST'])!!}
								  @foreach ($users as $user)
								  <tr @if($loop->index % 2 == 1) class="table-success" @endif>
									  <td class="giaphanphoi"><h5>{{ $user->ten }}</h5></td>
								  		@foreach ($hangs as $hang)
											@if($giaphanphoi->get($user->id) == null || $giaphanphoi->get($user->id)->get($hang->id) == null)
												@php
													 $a = ''
												@endphp
											@else
												@php
													 $a = $giaphanphoi->get($user->id)->get($hang->id)
												@endphp
											@endif
											<td class="giaphanphoi">
												{{ Form::text($user->id.'-'. $hang->id ,$a,['class'=>'money
													']) }}
											</td>
								  		@endforeach
									</tr>
								  @endforeach
                           <tr >
                             <td></td>

                             <td>


                             </td>
                           </tr>
                       </tbody>
                     </table>


                   </div>
						 {{ Form::submit('Hoàn tất',['class'=>' btn btn-success']) }}
						 {{-- <a href="/giaphanphoi/store" class="btn btn-success">Hoàn tất </a> --}}
						{!! Form::close() !!}
                 </div>
               </div>
<script type="text/javascript">
	 $(document).ready(function(){
		 $('.money').simpleMoneyFormat();
	 });
</script>
@endsection
