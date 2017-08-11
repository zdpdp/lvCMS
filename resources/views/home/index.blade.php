@extends('layouts.homeLayout')
@section('content')

        <section class="tm-section">

            <div class="container-fluid">
                <div class="row tm-margin-t-big">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="tm-2-col-left">

                            <h3 style='text-align: center' class="tm-gold-text tm-title">推荐文章</h3>
                            @foreach ($top as $val)
                                <div class="media tm-related-post">
                                    <div class="media-left media-middle">
                                        <a href="#">
                                            <img  style='width:200px;height:140px' class="media-object" src="{{$val->thumbnail}}" alt="文章缩略图">
                                        </a>
                                    </div>
                                    <div style='position: relative' class="media-body">
                                        <a href="#"><h4 class="media-heading tm-gold-text tm-margin-b-15">{{$val->title}}</h4></a>
                                        <p style="margin-bottom: 80px" class="tm-small-font tm-media-description">{{mb_substr(strip_tags($val->content),0,100)."..."}}</p>

                                        <div style="position: absolute;bottom: 0;width: 100%;margin-top:10px">
                                            <i class="fa fa-clock-o" aria-hidden="true">{{substr($val->created_at,0,10)}} </i>
                                            <i style="margin-left: 50px" class="fa fa-bars" aria-hidden="true">{{$val->className}} </i>
                                            <div style="float:right;margin-bottom:5px"><a href="/article/{{$val->id}}"> <button  type="button" class="btn btn-warning">阅读全文</button></a></div>

                                        </div>

                                    </div>
                                </div>

                            @endforeach


                        </div>
                    </div>



                </div> <!-- row -->


                <div class="row" style="margin: 50px">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-xs-center">
                        <h3 class="tm-gold-text tm-title">热门文章</h3>

                    </div>
                </div>
                <div class="row">
                    @foreach($hot as $val)
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3 col-xl-3">

                        <div class="tm-content-box">
                            <img style='width: 310px;height: 180px' src="{{$val->thumbnail}}" alt="Image" class="tm-margin-b-20 img-fluid">
                                <div style="height:200px">
                                    <h4 class="tm-margin-b-20 tm-gold-text">{{$val->title}}</h4>
                                    <p class="tm-margin-b-20">{{mb_substr(strip_tags($val->content),0,50)."..."}}</p>
                                </div>

                                <a href="/article/{{$val->id}}" class="tm-btn text-uppercase">详细</a>


                        </div>  

                    </div>
                    @endforeach
                </div> <!-- row -->



            </div>
        </section>
        
@endsection