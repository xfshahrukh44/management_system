<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>{{env('APP_NAME')}}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- jquery ui css-->
  <link rel="stylesheet" type="text/css" href="{{asset('plugins/jquery-ui/jquery-ui.css')}}">
  
  <!-- jquery js -->
  <script type="text/javascript" src="{{asset('js/jquery.js')}}"></script>
  <!-- jquery ui js -->
  <!-- <script type="text/javascript" src="{{asset('plugins/jquery-ui/jquery-ui.js')}}"></script> -->

  <!-- toastr js -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
  <!-- toastr css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">

  <!-- local css -->
  <link rel="stylesheet" href="{{asset('css/app.css')}}">
  <!-- <link rel="stylesheet" href="{{asset('css/custom-style.css')}}"> -->
  <!-- <link rel="stylesheet" href="{{asset('dist/css/adminlte.css')}}"> -->

  <!-- adminlte css -->
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
  <!-- <link rel="stylesheet" type="text/css" href="{{asset('css/jquery.dataTables.min.css')}}"> -->

  <!-- bootstrap css -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

  <!-- fancy box -->
  <link rel="stylesheet" href="{{asset('fancybox/source/jquery.fancybox.css?v=2.1.7')}}" type="text/css" media="screen" />

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
  <!-- Fontawesome -->
  <link rel="stylesheet" href="{{asset('css/fontawesome.css')}}"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />

  <!-- Affirm import -->
  <script>
    _affirm_config = {
      public_api_key:  "L4FGD7NZZMLC5EDQ",
      script:          "https://cdn1-sandbox.affirm.com/js/v2/affirm.js"
    };
    (function(m,g,n,d,a,e,h,c){var b=m[n]||{},k=document.createElement(e),p=document.getElementsByTagName(e)[0],l=function(a,b,c){return function(){a[b]._.push([c,arguments])}};b[d]=l(b,d,"set");var f=b[d];b[a]={};b[a]._=[];f._=[];b._=[];b[a][h]=l(b,a,h);b[c]=function(){b._.push([h,arguments])};a=0;for(c="set add save post open empty reset on off trigger ready setProduct".split(" ");a<c.length;a++)f[c[a]]=l(b,d,c[a]);a=0;for(c=["get","token","url","items"];a<c.length;a++)f[c[a]]=function(){};k.async=
    !0;k.src=g[e];p.parentNode.insertBefore(k,p);delete g[e];f(g);m[n]=b})(window,_affirm_config,"affirm","checkout","ui","script","ready","jsReady");
  </script>
</head>
<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

      <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
          <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            <img src="{{ asset('dist/img/avatar.png') }}" class="img-circle elevation-2" alt="User Image" width="20px"><span class="caret"></span> {{ucfirst(Auth::user()->name)}}
          </a>

          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <!-- <a class="dropdown-item" href="#">
              Profile
            </a> -->
            <a class="dropdown-item" href="{{ route('logout') }}"
            onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
            {{ __('Logout') }}
          </a>

          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
        </div>
      </li>
    </ul>

  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('dashboard')}}" class="brand-link" id="topSidebar">
      <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="LaraStart Logo" class="brand-image img-circle elevation-3"
      style="opacity: .8">
      <span class="brand-text font-weight-light">Management System</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{route('dashboard')}}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt "></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                <!-- Your Twitter feed -->
                @if(auth()->user()->twitter_username)
                  <li class="nav-item">
                      <a href="{{route('dashboard')}}" class="nav-link">
                        <i class="nav-icon fab fa-twitter "></i>
                        <p>
                          Your Twitter feed
                        </p>
                      </a>
                  </li>
                @endif

                <!-- Blog Management -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-blog"></i>
                        <p>
                            Blog Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview ml-2">
                        <!-- Feed -->
                        <!-- <li class="nav-item">
                            <a href="{{route('post.index')}}" class="nav-link">
                                <i class="nav-icon fas fa-rss-square"></i>
                                <small>Feed</small>
                            </a>
                        </li> -->
                        <!-- Posts -->
                        <li class="nav-item">
                            <a href="{{route('post.index')}}" class="nav-link">
                                <i class="nav-icon fas fa-paste"></i>
                                <small>Posts</small>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Product Management -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fab fa-product-hunt"></i>
                        <p>
                            Product Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview ml-2">
                      <!-- Products -->
                      <li class="nav-item">
                          <a href="{{route('product.index')}}" class="nav-link">
                              <i class="nav-icon fab fa-product-hunt"></i>
                              <small>Products</small>
                          </a>
                      </li>
                      <!-- Orders -->
                      <li class="nav-item">
                          <a href="{{route('order.index')}}" class="nav-link">
                              <i class="nav-icon fas fa-shopping-bag"></i>
                              <small>Orders</small>
                          </a>
                      </li>
                      <!-- Categories -->
                      <li class="nav-item">
                          <a href="{{route('category.index')}}" class="nav-link">
                              <i class="nav-icon fas fa-copyright"></i>
                              <small>Categories</small>
                          </a>
                      </li>
                      <!-- Brands -->
                      <li class="nav-item">
                          <a href="{{route('brand.index')}}" class="nav-link">
                              <i class="nav-icon fab fa-bootstrap"></i>
                              <small>Brands</small>
                          </a>
                      </li>
                      <!-- Units -->
                      <li class="nav-item">
                          <a href="{{route('unit.index')}}" class="nav-link">
                              <i class="nav-icon fas fa-balance-scale-left"></i>
                              <small>Units</small>
                          </a>
                      </li>
                    </ul>
                </li>

                <!-- user management -->
                @can('isAdmin')
                  <li class="nav-item">
                      <a href="{{route('user.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-user "></i>
                        <p>
                          User Management
                        </p>
                      </a>
                  </li>
                @endcan
            </ul>
        </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        @yield('content_header')
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        @yield('content_body')
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">

  </footer>
</div>

<!-- local js -->
<script src="{{asset('js/app.js')}}"></script>
<!-- <script src="{{asset('js/jquery.dataTables.min.js')}}" defer></script> -->
<!-- <script src="{{asset('dist/js/adminlte.js')}}"></script> -->

<!-- adminlte js -->
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
<script src="{{asset('dist/js/demo.js')}}"></script>

<!-- fancybox -->
<script type="text/javascript" src="{{asset('fancybox/source/jquery.fancybox.pack.js?v=2.1.7')}}"></script>

<!-- jquery ui js-->
<script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>

<!-- bootstrap js -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<!-- pusher work -->

<!-- pusher -->
<!-- <script src="https://js.pusher.com/7.0/pusher.min.js"></script> -->

<!-- toastr init -->
<script>
  toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": true,
    "progressBar": false,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
  }
</script>

@yield('content_script')
</body>
</html>