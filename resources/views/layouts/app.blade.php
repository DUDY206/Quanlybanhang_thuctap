
<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="utf-8" />
  {{-- <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/apple-icon.png"> --}}
  <link rel="icon" type="image/png" href="/assets/img/debit-card.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Quan ly kho hang
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <!-- CSS Files -->
  <link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="/assets/css/now-ui-dashboard.css?v=1.5.0" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="/assets/demo/demo.css" rel="stylesheet" />

  <script src="/assets/js/core/jquery.min.js"></script>
  <script src="/assets/js/core/popper.min.js"></script>
  <script src="/assets/js/core/bootstrap.min.js"></script>
  <script src="/assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <script src="/assets/js/plugins/bootstrap-notify.js"></script>
  <script src="/assets/js/plugins/simple.money.format.js"></script>
  <script type="text/javascript" src="https://cdn.rawgit.com/asvd/dragscroll/master/dragscroll.js"></script>

</head>

<body class="">
  @if(isset(Auth::user()->sdt))

  <div class="wrapper ">
    <div class="sidebar" data-color="orange">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
    -->
      <div class="logo">


        <a href="/" class="simple-text logo-normal" >
          <i class="now-ui-icons business_chart-bar-32" style="padding:5px 15px;"></i>
          QUAN LY KHO HANG
        </a>
      </div>
      <div class="sidebar-wrapper" id="sidebar-wrapper">
        <ul class="nav ">
            {{-- @if(Auth::user()->is_active == 1)
              @if(Auth::user()->level <= 1) --}}

          {{-- <li class="active ">
            <a href="/hang" >
              <i class="now-ui-icons design_app"></i>
              <p>Mặt hàng</p>
            </a>
          </li> --}}
          <li>
              <a class="btn btn-primary"  data-toggle="collapse" data-target="#mathang" aria-expanded="false" aria-controls="collapseExample">
               <i class="now-ui-icons  design_app"></i>
               <p class="text-left">Mặt hàng </p>
              </a>
           <div class="collapse" id="mathang">
              <div class="card card-body" style="background-color:#fb7b51 !important">
               <ul style="list-style-type:none;padding-left:0">
                  <li><a href="/hang">---   Danh sách hàng</a> </li>
                  @if (Auth::user()->level <= 1)
                     <li><a href="/giaphanphoi">---   Bảng giá CTV</a> </li>
                     <li><a href="/hang/create">---   Thêm hàng mới</a> </li>
                     <li><a href="/hang/logs">---   Xem logs</a> </li>
                  @endif
               </ul>
              </div>
           </div>
          </li>

          <?php
            $sl_hangchuaduyet_all = DB::table('banhang')->where('trangthai','>','1')->count();
            $sl_hangchuaduyet_canhan = DB::table('banhang')->where([['trangthai','>','1'],['nguoiban_id','=',Auth::user()->id]])->count();


            if($sl_hangchuaduyet_all == 0){
               $sl_hangchuaduyet_all='';
            }
            if($sl_hangchuaduyet_canhan==0){
               $sl_hangchuaduyet_canhan ='';
            }
          ?>
          @if (Auth::user()->level <= 1)
          <li>
              <a class="btn btn-primary"  data-toggle="collapse" data-target="#nhaphang" aria-expanded="false" aria-controls="collapseExample">
               <i class="now-ui-icons education_atom"></i>
               <p class="text-left">Nhập hàng

               </p>
              </a>
           <div class="collapse" id="nhaphang">
              <div class="card card-body" style="background-color:#fb7b51 !important">
               <ul style="list-style-type:none;padding-left:0">
                  <li><a href="/nhaphang/create">---   Nhập hàng mới</a> </li>
                  <li><a href="/nhaphang">---   Lịch sử nhập hàng</a> </li>
                  <li><a href="/nhaphang/logs">---   Xem logs</a> </li>
               </ul>
              </div>
           </div>
          </li>
         @endif

          <li>
              <a class="btn btn-primary"  data-toggle="collapse" data-target="#banhang" aria-expanded="false" aria-controls="collapseExample">
               <i class="now-ui-icons shopping_delivery-fast"></i>
               <p class="text-left">BÁN hàng  <span class=" badge badge-danger" style="font-size:0.75rem">@if(Auth::user()->level<3){{ $sl_hangchuaduyet_all }}@else{{ $sl_hangchuaduyet_canhan }}@endif</span></p>
              </a>
           <div class="collapse" id="banhang">
              <div class="card card-body" style="background-color:#fb7b51 !important">
               <ul style="list-style-type:none;padding-left:0">
                  @if(Auth::user()->is_active!=0)
                  <li><a href="/banhang/create">+ ĐƠN HÀNG MỚI</a> </li>
                  <li><a href="/banhang/list/{{ Auth::user()->id }}/chuaduyet">+ Đơn chưa duyệt [ CÁ NHÂN ] <span class=" badge badge-danger" style="font-size:0.75rem">{{ $sl_hangchuaduyet_canhan }}</span></a> </li>
               @endif
                  <li><a href="/banhang/list/{{ Auth::user()->id }}/chuahoantat">+ ĐƠN CHƯA HOÀN TẤT [ CÁ NHÂN ]</a> </li>
                  <li><a href="/banhang/list/{{ Auth::user()->id }}/dahoantat">+ ĐƠN ĐÃ HOÀN TẤT [ CÁ NHÂN ]</a> </li>

                  @if (auth::user()->level <=2)
                     <li><a href="/banhang/list/all/chuaduyet">+ Đơn chưa duyệt [ALL]<span class=" badge badge-danger" style="font-size:0.75rem">{{ $sl_hangchuaduyet_all }}</span></a> </li>
                     <li><a href="/banhang/list/all/chuahoantat">+ ĐƠN CHƯA HOÀN TẤT [ALL]</a> </li>
                     <li><a href="/banhang/list/all/dahoantat">+ ĐƠN ĐÃ HOÀN TẤT [ALL]</a> </li>
                  @endif

               </ul>
              </div>
           </div>
          </li>
          {{-- <li>
            <a href="/nhaphang/create">
              <i class="now-ui-icons education_atom"></i>
              <p>Nhập hàng</p>
            </a>
          </li> --}}

        {{-- @endif --}}

        {{-- @endif --}}


          <li>
              <a class="btn btn-primary"  data-toggle="collapse" data-target="#thongke1" aria-expanded="false" aria-controls="collapseExample">
                 <i class="now-ui-icons business_money-coins"></i>
                 <p class="text-left">Thống kê bán hàng</p>
               </p>
              </a>
           <div class="collapse" id="thongke1">
              <div class="card card-body" style="background-color:#fb7b51 !important">
               <ul style="list-style-type:none;padding-left:0">

                  <li><a href="" id="thongkecanhan_ngay">+ CÁ NHÂN -  Hôm nay</a> </li>
                  <li><a href="" id="thongkecanhan_thang">+  CÁ NHÂN - Tháng </a> </li>
                  <li><a href="" id="thongkecanhan_nam">+ CÁ NHÂN -  Năm</a> </li>
                  @if(Auth::user()->level < 2)
                  <li><a href="" id="thongkeall_ngay">+ KHO -  hôm nay</a> </li>
                  <li><a href="" id="thongkeall_thang">+   KHO - tháng</a> </li>
                  <li><a href="" id="thongkeall_nam">+  KHO -  Năm</a> </li>
               @endif
               </ul>
              </div>
           </div>
          </li>
          <li>
           <a href="/thutien/{{ Auth::user()->id }}">
              <i class="now-ui-icons shopping_credit-card"></i>
              <p>Lịch sử thu tiền</p>
           </a>
          </li>
          @if(isset(Auth::user()->sdt))
          @if(Auth::user()->level <= 1)
          <li>
            <a href="/userinfo">
              <i class="now-ui-icons users_single-02"></i>
              <p>Quản lý nhân viên</p>
            </a>
          </li>



        @endif
      @endif
      <li>
          <a class="btn btn-primary"  data-toggle="collapse" data-target="#userinfo" aria-expanded="false" aria-controls="collapseExample">
             <i class="now-ui-icons travel_info"></i>
             <p class="text-left">Cá nhân</p>
           </p>
          </a>
      <div class="collapse" id="userinfo">
          <div class="card card-body" style="background-color:#fb7b51 !important">
           <ul style="list-style-type:none;padding-left:0">
             <li><a class="dropdown-item" href="/userinfo/{{ Auth::user()->id }}">Thông tin cá nhân</a></li>
             <li><a class="dropdown-item" href="/changePassword">Đổi mật khẩu</a></li>
             <li>  <a class="dropdown-item" href="{{ url('login/logout') }}">Dang xuat</a></li>
           </ul>
          </div>
      </div>
      </li>
          {{-- <li class="active-pro">
            <a href="./upgrade.html">
              <i class="now-ui-icons arrows-1_cloud-download-93"></i>
              <p>Upgrade to PRO</p>
            </a>
          </li> --}}
        </ul>
      </div>
    </div>
    <div class="main-panel" id="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent  bg-primary  navbar-absolute">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand" href="/">Trang chủ</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">

            <ul class="navbar-nav">

              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="now-ui-icons users_circle-08"></i>
                  @if(isset(Auth::user()->sdt))
                  <p>{{  Auth::user()->ten }}</p>
                @endif

                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="/userinfo/{{ Auth::user()->id }}">Thông tin cá nhân</a>
                  <a class="dropdown-item" href="/changePassword">Đổi mật khẩu</a>
                  <a class="dropdown-item" href="{{ url('login/logout') }}">Dang xuat</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="panel-header panel-header-sm">
      </div>
      <div class="content">
        <div class="row">
          <div class="col-md-12">
            @include('inc.messages')
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            @yield('content')
          </div>
        </div>
        <div class="row" style="height:250px">
          <div class="col-md-12" >

          </div>
      </div>

    </div>
  </div>

  </div>
  <!--   Core JS Files   -->

  <!--  Google Maps Plugin    -->
  {{-- <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script> --}}
  <!-- Chart JS -->
  <!--  Notifications Plugin    -->
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="/assets/js/now-ui-dashboard.min.js?v=1.5.0" type="text/javascript"></script><!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->
  <script src="/assets/demo/demo.js"></script>
  <script type="text/javascript">
     $(document).ready(function() {
        var today = new Date();

        var date = today.getFullYear()+'/'+(today.getMonth()+1)+'/'+today.getDate();
        var month = today.getFullYear()+'/'+(today.getMonth()+1);
        var year = today.getFullYear();
        $('#thongkecanhan_ngay').attr('href','/thongke/{{Auth::user()->id}}/'+date)
        $('#thongkecanhan_thang').attr('href','/thongke/{{Auth::user()->id}}/'+month)
        $('#thongkecanhan_nam').attr('href','/thongke/{{Auth::user()->id}}/'+year)
        $('#thongkeall_ngay').attr('href','/thongke/all/'+date)
        $('#thongkeall_thang').attr('href','/thongke/all/'+month)
        $('#thongkeall_nam').attr('href','/thongke/all/'+year)
     });
  </script>
@else
  <script type="text/javascript">
    window.location = "/login";
  </script>
@endif

</body>

</html>
