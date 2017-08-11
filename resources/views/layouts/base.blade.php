<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document - @yield('title')</title>


    <link rel="stylesheet" type="text/css" href="./commonCSS/bootstrap3.min.css">
    @yield('style')
</head>
<body>
    <div id="app">
        @yield('content')
    </div>


    <script src="./commonJS/jquery.min.js"></script>
    <script src="./commonJS/bootstrap.min.js"></script>
    <script src="./commonJS/vue.min.js"></script>
    <script src="./commonJS/vue-resource.min.js"></script>
    @yield('script')
</body>
</html>