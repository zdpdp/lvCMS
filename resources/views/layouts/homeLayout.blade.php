<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <title>{{$site->name}}</title>
    <link rel="icon" href="{{$site->icon}}" sizes="32x32" />

    <!-- load stylesheets -->

    <link rel="stylesheet" href="http://apps.bdimg.com/libs/fontawesome/4.4.0/css/font-awesome.min.css">
    <link href="https://cdn.bootcss.com/bootstrap/4.0.0-alpha.2/css/bootstrap.min.css" rel="stylesheet">
                                  <!--    <link rel="stylesheet" href="/commonCSS/bootstrap4.min.css">    -->
    <link rel="stylesheet" href="/css/templatemo-style.css">                                   <!-- Templatemo style -->

    <style>
        body{
            background-color: #f5f8fa;
        }
        .navbar .nav > li .dropdown-menu {
            margin: 0;
        }
        a{
            text-decoration: none !important;
        }
        .nav > li:hover .dropdown-menu { display: block; }
        .dropdown-item {padding: 10px;font-size: 20px}
        .dropdown-item:hover {background-color: #cc9900;color:#ffffff}

    </style>
@yield('style')

</head>

<body>

<div class="tm-header">

    <div style="padding: 0 100px 0 200px">
        <div class="tm-header-inner">
            <a href="/" class="navbar-brand tm-site-name">{{$site['name']}}</a>

            <!-- navbar -->
            <nav class="navbar tm-main-nav">

                <button class="navbar-toggler hidden-md-up" type="button" data-toggle="collapse" data-target="#tmNavbar">
                    &#9776;
                </button>

                <div class="collapse navbar-toggleable-sm" id="tmNavbar">



                    <ul class="nav navbar-nav">
                        <li class="nav-item ">
                            <a href="/" class="nav-link">首页</a>
                        </li>
                        @foreach ($class as $val)
                            <li class="nav-item dropdown" >

                                <a href='/class/{{$val->id}}' class="nav-link" @if ($val->child)   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" @endif  href="#" role="a" >{{$val->className}}</a>

                                @if ($val->child)
                                    <div class="dropdown-menu">
                                        @foreach ($val->child as $val2)
                                            <a href='/class/{{$val2->id}}' class="dropdown-item" href="#">{{$val2->className}}</a>
                                        @endforeach
                                    </div>
                                @endif

                            </li>
                        @endforeach


                    </ul>
                </div>

            </nav>

        </div>
    </div>
</div>
<div >
    <img style="height:180px;width:100%"  src="{{$site->logo}}" alt="">
</div>



@yield('content')




<footer class="tm-footer">
    <div class="container-fluid">
        <div class="row">

            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3 col-xl-3">

                <div class="tm-footer-content-box">
                    <h3 class="tm-gold-text tm-title tm-footer-content-box-title">访问统计</h3>
                    <div class="tm-gray-bg">
                        <p>历史访问量:{{$totalVisit}}</p>
                        <p id="showNow"><?php echo date('Y/m/d H:i:s',time());?></p>
                        <script type="text/javascript">
                            setInterval(function() {
                                var now = (new Date());
                                var weekday=new Array(7)
                                weekday[0]="星期天"
                                weekday[1]="星期一"
                                weekday[2]="星期二"
                                weekday[3]="星期三"
                                weekday[4]="星期四"
                                weekday[5]="星期五"
                                weekday[6]="星期六"
                                $('#showNow').text(now.toLocaleString()+" "+weekday[now.getDay()]);
                            }, 1000);
                        </script>
                        @if($login)
                        <p><a href="/logout" >博主注销</a></p>
                        <p><a href="/admin" target="_blank" >进入后台</a></p>
                        @else
                        <p><a href="/login" target="_blank">博主登录</a></p>
                        @endif
                    </div>
                </div>

            </div>

            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3 col-xl-3">
                <div class="tm-footer-content-box tm-footer-links-container">

                    <h3 class="tm-gold-text tm-title tm-footer-content-box-title">友情链接</h3>
                    <nav>
                        <ul class="nav">
                            @foreach($friends as $val)
                                <li><a href="{{$val->url}}"  target="_blank" class="tm-footer-link">{{$val->name}}</a></li>
                            @endforeach

                        </ul>
                    </nav>

                </div>

            </div>

            <!-- Add the extra clearfix for only the required viewport
                http://stackoverflow.com/questions/24590222/bootstrap-3-grid-with-different-height-in-each-item-is-it-solvable-using-only
            -->
            <div class="clearfix hidden-lg-up"></div>

            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3 col-xl-3">

                <div class="tm-footer-content-box">

                    <h3 class="tm-gold-text tm-title tm-footer-content-box-title">GitHub</h3>
                    <p class="tm-margin-b-30">暂未发布</p>

                    <a href="#" class="tm-btn tm-btn-gray text-uppercase">Read More</a>

                </div>

            </div>

            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3 col-xl-3">

                <div class="tm-footer-content-box">

                    <h3 class="tm-gold-text tm-title tm-footer-content-box-title">PoweredBy</h3>
                    <div class="tm-margin-b-30">
                        <img  src="/images/power/bootstrap.png" alt="Image" class="tm-footer-thumbnail">
                        <img  src="/images/power/elementUi.png" alt="Image" class="tm-footer-thumbnail">
                        <img  src="/images/power/laravel.png" alt="Image" class="tm-footer-thumbnail">
                        <img  src="/images/power/vue.jpg" alt="Image" class="tm-footer-thumbnail">
                        <img  src="/images/power/aliyun.png" alt="Image" class="tm-footer-thumbnail">
                        <img  src="/images/power/jquery.jpg" alt="Image" class="tm-footer-thumbnail">

                    </div>
                    <p class="tm-margin-b-20">Bootstrap4.0   Vue2.3   Laravel5.4   Element-Ui   Jquery  阿里云Centos</p>


                </div>

            </div>


        </div>

        <div class="row">
            <div class="col-xs-12 tm-copyright-col">
                <p class="tm-copyright-text">Copyright © 2017-{{date('Y')}} {{$site->contacts}} 版权所有 {{$site->ICB}} </p>
            </div>
        </div>
    </div>
</footer>

<!-- load JS files -->
<!-- /commonJS/jquery-1.11.3.min.js -->
<script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>             <!-- jQuery (https://jquery.com/download/) -->
<script src="/commonJS/tether.min.js"></script> <!-- Tether for Bootstrap, http://stackoverflow.com/questions/34567939/how-to-fix-the-error-error-bootstrap-tooltips-require-tether-http-github-h -->
<script src="https://cdn.bootcss.com/bootstrap/4.0.0-alpha.2/js/bootstrap.min.js"></script>
                <!--<script src="/commonJS/bootstrap.min.js"></script>  -->
<script>
    $(document).ready(function(){
        $(document).off('click.bs.dropdown.data-api');
    });
</script>
@yield('script')
</body>
</html>