<!DOCTYPE html>
<!-- here basic three files header footer and content and head contain link and scripts contain js scripts-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title' , 'My WeightLoss')</title>

    @include('admin.includes.head')
    @notifyCss
</head>

<body>
    @include('admin.includes.header')
    @include('admin.includes.sidebar')
    @yield('content')
    @include('admin.includes.footer')
    @include('admin.includes.script')
    @stack('scripts')
    @include('admin.pages.apicall')
    @notifyJs
</body>

</html>
