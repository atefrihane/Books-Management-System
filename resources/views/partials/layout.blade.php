@include('partials.head')

<body class="hold-transition sidebar-mini">

    @include('sweet::alert')
    <div class="wrapper">
        @include('partials.header')

          @yield('content')
          
      
        </div>
       
        @include('partials.footer')

     