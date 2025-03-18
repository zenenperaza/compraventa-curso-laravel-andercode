<html  lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">

<head>   
   @include('partials.head')
</head>

<body>

    <div id="layout-wrapper">

        @include('partials.header')

        <!-- ========== App Menu ========== -->
        @include('partials.menu')

        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            @yield('content')

            @include('partials.footer')

        </div>
 

    </div>



    <!--start back-to-top-->
    @include('partials.top')

    @include('partials.js')    

    @stack('scripts')
</body>

</html>
