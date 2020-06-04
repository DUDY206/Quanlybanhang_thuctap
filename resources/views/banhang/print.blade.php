<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>In hóa đơn [{{ $banhang->id }}]</title>
		<script src="/assets/js/core/jquery.min.js"></script>
		<style media="screen">
			table{
				float: left;
				margin:0;
				display: block;
			}
			td{
				width: 268px;
				height: 40px;
			}
			.clearfix::after {
			  content: "";
			  clear: both;
			  display: table;
			}
			#button{
				padding:10px;
				margin-top:10px;
				border:solid 1px black;
				background: #2ab7ca;
				color: :#fed766 !important;
			}

		</style>
	</head>
	<body >
		<div class="clearfix">
			<table border="1" cellpadding="3" id="printTable" onafterprint="myFunction()">
				<tbody>

				<tr >
					<td style="width:50%">Người gửi: {{ $user->ten }}</td>
					<td rowspan="5" style="width:50%"><textarea id="input3" style="width:98%;height:98%;border:none" ></textarea> </td>
				</tr>
				{{--  --}}
				<tr>
					<td>Địa chỉ: Gia Lộc, Hải Dương</td>
				</tr>
				{{--  --}}
				<tr>
	<td>Sđt:	{{ $user->sdt }}</td>
				</tr>
				{{--  --}}
				<tr>
	<td>Thu cod: </td>
				</tr>
				{{--  --}}
				<tr>
	<td>Số kiện: <input type="text" name="" value="" style="height:100%;margin:0;padding:0;border:none" id="input2"> </td>
				</tr>
				{{--  --}}
				<tr>
					<td rowspan="3"><textarea id="input1" style="width:98%;height:98%;border:none" ></textarea></td>
					<td>Người nhận: {{ $banhang->tennguoimua }}</td>
				</tr>
				{{--  --}}
				<tr>
					<td>Sđt: {{ $banhang->sdt }}</td>
				</tr>
				{{--  --}}
				<tr>
	<td >Địa chỉ: {{ $banhang->diachi }}</td>
				</tr>
				{{--  --}}

				{{-- --}}

			</tbody>

			 </table>

			 <div id="hang"  style="background:grey;width:400px;height:345px;float:right">
		<table border="1" style="text-align:left">
			<thead>
				<th>Tên hàng</th>
				<th>Số lượng</th>
				<th>Giá bán</th>
			</thead>
			<tbody>
				@php
					$giamgia = $banhang->giamgia;
					$tongtien = 0;
					$tiendathu = 0;
				@endphp
		@foreach ($phieuxuats as $phieuxuat)
				<tr>
					<td>{{ $phieuxuat->tenhang }}</td>
					<td>{{ $phieuxuat->soluonghang }}</td>
					<td>{{ number_format($phieuxuat->giaban) }}</td>
				</tr>
				@php
					 $tongtien += $phieuxuat->soluonghang*$phieuxuat->giaban;
				@endphp
		@endforeach
		@php
			$tongtien_format = number_format($tongtien);
		@endphp
				<tr>
					<td colspan="3">Tổng tiền: {{ $tongtien_format }}</td>
				</tr>
				<tr>
					<td colspan="3">Giảm giá: {{ number_format($giamgia) }}</td>
				</tr>
				@foreach ($thutiens as $thutien)
					<tr>
					<td colspan="3">Thu tiền lần {{ $loop->index+1 }}: {{ number_format($thutien->sotien) }} ({{ $thutien->phuongthucthanhtoan }})</td>
					@php
					$tiendathu += $thutien->sotien;
					@endphp
					</tr>
				@endforeach

				<tr>
					<td colspan="3">Tiền còn thiếu: {{ number_format($tongtien-$giamgia-$tiendathu) }}</td>
				</tr>
	</tbody>
</table>
			 </div>
		</div>

		<button type="button" name="button" id="button" >In hóa đơn</button>
	</body>
</html>
	<script type="text/javascript">
			$(document).ready(function(){
					$('#button').click(function(){
						var r = confirm("Press a button!");
						if (r == true) {
							var $clone = $("#printTable").clone(true);
							newWin= window.open("");
							newWin.document.write($clone[0].outerHTML);
							newWin.document.getElementById('input1').value = $('#input1').val();
							newWin.document.getElementById('input2').value = $('#input2').val();
							newWin.document.getElementById('input3').value = $('#input3').val();
							var x = false;
							newWin.document.write("<script type='text\/javascript'>"+"document.getElementsByTagName(\"BODY\")[0].onafterprint = function() {myFunction()};function myFunction() { window.opener.parent.location = \"\/banhang\/print\/{{$banhang->id}}\/success\";}"+"window.onload = function() { window.print(); }"+"<\/script>");
							newWin.print();

							newWin.close();
					  }

				  });

			});

</script>
