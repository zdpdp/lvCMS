@extends('layouts.homeLayout')
@section('content')
    <section class="tm-section" style="margin-top:50px">
        <div class="container-fluid">
            <div class="row">

                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-9 col-xl-9">
                    <div class="tm-blog-post">
                        <h2 class="tm-gold-text">{{$name}}</h2>
                        <div class="container" style="padding: 50px;min-height: 400px">
                            @foreach ($articles as $val)
                                <p><a href="/article/{{$val->id}}">{{$val->title}}</a><span style="float: right">{{$val->created_at}}</span></p>
                                <hr class="tm-margin-t-small">
                            @endforeach
                            @if(count($articles)==0)
                                <h2>暂无文章</h2>
                            @endif

                        </div>

                        <div class="pull-right">
                            {{ $articles->links() }}
                        </div>

                    </div>

                </div>
                <!--侧边-->
                <aside class="col-xs-12 col-sm-12 col-md-4 col-lg-3 col-xl-3 tm-aside-r">

                    <div class="tm-aside-container">
                        <h3 class="tm-gold-text tm-title">
                            相关栏目
                        </h3>
                        <nav style="text-align: left">
                            <ul class="nav">
                                @foreach($relativeClass as $val)
                                    <li><a href="/class/{{$val->id}}" class="tm-text-link">{{$val->className}}</a></li>

                                @endforeach

                            </ul>

                        </nav>


                    </div>


                </aside>
            </div>

        </div>

    </section>

@endsection