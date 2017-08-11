@extends('layouts.homeLayout')
@section('style')
    <link rel="stylesheet" href="/css/remark.css">
@endsection
@section('content')

    <section class="tm-section" style="margin-top:50px">
        <div class="container-fluid">
            <div class="row">



                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-9 col-xl-9">
                    @if($visitable==1||($visitable==3&&$login))
                    <div class="tm-blog-post">
                        <h2 class="tm-gold-text">{{$article->title}}</h2>
                        <p>
                            {{$article->secondTitle}}
                            @if($article->original==0)
                                <span>文章来源:{{$article->source}}</span>
                            @endif
                        </p>
                        <p>阅读量:{{$article->clickNum}}  <span  class="pull-right"> <a  href="/class/{{$classId}}">所属类别:{{$className}}</a></span></p>
                        <hr>
                        @if($article->thumbnail)
                            <div style="padding:10px 50px">
                                <img style='width: 100%;height:300px;text-align: center'  src="{{$article->thumbnail}}" alt="Image" class="img-fluid tm-img-post">
                            </div>
                        @endif


                        <div style="color:black">


                            <?php echo $article->content ?>

                        </div>




                        <div style="margin-top:50px">
                            @if($downloadable==1)
                                <div style="float:left">
                                    @foreach($link as $val)
                                        <p><a href="/download/{{$val->id}}">附件:{{$val->name}}</a></p>
                                    @endforeach
                                </div>
                            @endif
                            @if($downloadable==3)
                                <div style="float:left">
                                    @foreach($link as $val)
                                        <p><a href="/download/{{$val->id}}">附件:{{$val->name}}</a></p>
                                    @endforeach
                                    @if(!$login&&count($link)>0)
                                   <p> <i>登录后才可下载附件</i></p>
                                    @endif
                                </div>
                            @endif


                                <div  style="float:right">
                                <p>创建于:{{substr($article->created_at,0,16)}} </p>
                                <p>
                                    编辑于:{{substr($article->updated_at,0,16)}}
                                </p>

                            </div>
                        </div>

                    </div>

                    @if($remarkable!=2)
                    <div class="remark" class="">
                        <div class="row">
                            <div class="col-md-12">
                                <br>
                                <br>
                                <br>
                                <h2 class="tm-gold-text">评论</h2>
                                <ul class="media-list">
                                    @foreach($remark as $val)
                                        <hr>
                                        <li class="media">
                                            <div class="media-left">
                                                <a href="#">
                                                    <img class="media-object img-circle remark_headPic" src="{{$val['head']?:'/images/userHead/temp.png'}}" alt="头像">
                                                </a>
                                            </div>
                                            <div class="media-body" >
                                                <h4 class="media-heading"><span id="{{$val['id'].'name'}}">{{$val['userName']?:$val['tempName']}}</span> says:   <span id="{{$val['id'].'floor'}}" style="float:right">{{$val['index'].'楼'}}</span></h4>

                                                <p>{{$val['content']}}</p>

                                                <div class="ds-comment-footer">
                                                    <span class="ds-time"><i class="fa fa-clock-o"></i>{{$val['created_at']}}</span>&nbsp;
                                                    <a>
                                                        <span style='float: right' ><i mark="{{$val['id']}}" class="reply fa fa-mail-reply">回复</i></span>
                                                    </a>
                                                </div>
                                                @if($val['child'])
                                                <ul class="media-list">
                                                    @foreach($val['child'] as $val2)
                                                        <hr/>
                                                    <li class="media">
                                                        <div class="media-left">
                                                            <a href="#">
                                                                <img class="media-object img-circle remark_headPic" src="{{$val2['head']?:'/images/userHead/temp.png'}}" alt="头像">
                                                            </a>
                                                        </div>
                                                        <div class="media-body">
                                                            <h4 class="media-heading"><span id="{{$val2['id'].'name'}}">{{$val2['userName']?:$val2['tempName']}}</span> says: <div style="float:right;font-size: 16px;text-align: right"><span id="{{$val2['id'].'floor'}}">{{$val2['index'].'楼'}}</span><br>{{$val2['reply']}}</div></h4>

                                                            <p>{{$val2['content']}}</p>

                                                            <div class="ds-comment-footer">
                                    <span class="ds-time" ><i class="fa fa-clock-o"></i>{{$val2['created_at']}}</span>&nbsp;
                                                                <a>
                                                                    <span   style='float: right' ><i mark="{{$val2['id']}}"  class="reply fa fa-mail-reply">回复</i></span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    @endforeach
                                                </ul>

                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                                <hr>
                                @if($remarkable==1||($remarkable==3&&$login))
                                <form method="post" action="/addremark">
                                    <input type="text" hidden name="articleId" id="articleId" value="{{$article->id}}">
                                    <input type="text" hidden name="fatherId" id="remarkId"  value="">
                                    @if(!$login)
                                    <fieldset class="form-group">
                                        <label for="tempName">可输入临时名</label>
                                        <input type="text" class="form-control" name='tempName' id="tempName" placeholder="可留空使用匿名评论">
                                    </fieldset>
                                    @endif

                                    <fieldset id='remarkform' class="form-group">
                                        <label for="remarkContent">评论正文：<span >回复至: <span id="refrenceTest">文章</span></span> </label>
                                        <button style="float: right;margin-bottom: 5px" type="button" class="reset btn btn-primary">重置</button>
                                        <textarea type="text" class="form-control" name='content' rows='5' id="remarkContent" placeholder="" required></textarea>
                                    </fieldset>

                                    <button style="width: 100%" type="submit" class="btn btn-primary">提交评论</button>

                                </form>
                                @elseif($remarkable==3&&!$login)
                                    <h3>登录后才可评论</h3>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    @elseif ($visitable==3||!$login)
                        <h1>登录后才可浏览该文章</h1>
                    @elseif($visitable==2)
                        <h1>该文章未开放浏览</h1>
                    @endif
                </div>




                <!--侧边-->
                <aside class="col-xs-12 col-sm-12 col-md-4 col-lg-3 col-xl-3 tm-aside-r">

                    <div class="tm-aside-container">
                        <h3 class="tm-gold-text tm-title">
                            关于作者
                        </h3>
                        <nav style="text-align: left">
                            <p>
                                <img style="width: 100px;height: 100px;border-radius: 50px" src="{{$user->head}}" alt="">
                            </p>
                            <p>
                                昵称:   {{$user->name}}
                            </p>
                            <p>
                                职业:   本科在读
                            </p>

                        </nav>

                        <h3 class="tm-gold-text tm-title tm-margin-t-small">
                            相关文章
                        </h3>
                        <nav>
                            <ul class="nav">
                                @foreach($relativeArticle as $val)
                                    <li><a href="/article/{{$val->id}}" class="tm-text-link">{{$val->title}}</a></li>
                                @endforeach

                            </ul>
                        </nav>

                        <h3 class="tm-gold-text tm-title tm-margin-t-small">
                          热门文章
                        </h3>
                        @foreach($hot as $val)
                            <div class="tm-content-box tm-margin-t-small">
                                <a href="/article/{{$val->id}}" class="tm-text-link"><h4 class="tm-margin-b-20 tm-thin-font">{{$val->title}}</h4></a>
                                <p class="tm-margin-b-30">{{mb_substr(strip_tags($val->content),0,30)."..."}}</p>
                            </div>
                            <hr class="tm-margin-t-small">
                        @endforeach

                    </div>


                </aside>

            </div>

        </div>
    </section>

@endsection
@section('script')
    <script>
        $(document).ready(function(){
            $(".reply").click(function(){
                var mark = $(this).attr('mark')
                $('#remarkId').val(mark);

                var name = $('#'+mark+'name').html();
                var floor = $('#'+mark+'floor').html();
                $('#refrenceTest').html(name+'/'+floor)
                $('html,body').animate({scrollTop:$('#remarkform').offset().top}, 400);

            });

            $('.reset').click(function(){
                $('#remarkId').val('');
                $('#refrenceTest').html('文章')
                $('#remarkContent').val('')
            })
        });
    </script>
@endsection