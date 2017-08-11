<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div id="app" >
        <div class="col-lg-4 col-lg-offset-4" style="margin-top: 200px">
        <form class="form-horizontal" role="/login" method="post">
            <div class="form-group">
                <label for="firstname" class="col-sm-2 control-label">账号</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" v-model="name" id="name" placeholder="请输入名字">
                </div>
            </div>
            <div class="form-group">
                <label for="lastname" class="col-sm-2 control-label">密码</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" v-model="phone" id="phone" placeholder="请输入手机">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="button" @click="test" class="btn btn-default">登录</button>
                </div>
            </div>
        </form>
        </div>
    </div>
</div>
<script src="{{asset('commonJS/vue.min.js')}}"></script>
<script src="{{asset('commonJS/vue-resource.min.js')}}"></script>
<script>
    var vm = new Vue({
        el:'#app',
        data:{
            name:"",
            phone:"",
        },
        methods:{
            test:function () {
                this.$http.post("/login",{
                     account:this.name,
                     password:this.phone,

                }).then(function(data){

                    alert(data.body.msg)
                },function(data){
                    /*错误报头回调*/

                    if(data.status==422) {
                        alert('数据不合格')
                    }
                })
            }
        }
    })
</script>
</body>
</html>