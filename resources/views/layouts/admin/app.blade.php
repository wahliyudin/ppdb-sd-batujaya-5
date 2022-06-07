<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    @include('layouts.admin.inc.css')
</head>

<body class="hold-transition sidebar-mini" style="overflow-x: hidden;">
    <div class="wrapper">

        <!-- Navbar -->
        @include('layouts.admin.inc.nav')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('layouts.admin.inc.aside')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @if (isset($breadcrumbs))
                @include('layouts.admin.inc.breadcrumbs')
            @endif

            <!-- Main content -->
            <div class="content">
                @yield('content')
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        @include('layouts.admin.inc.footer')
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    @include('layouts.admin.inc.script')
</body>

</html>
