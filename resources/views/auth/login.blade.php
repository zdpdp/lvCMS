@extends('layouts.base')
@section('style')
<style>
    .loginBody{
        padding:40px 70px !important;
    }
    .loginPanel{
        box-shadow: 0 0 25px #cacac6 !important;
        margin-top: 200px;
    }
    .form-group{
        margin: 25px 0 !important;
    }
    a:hover{
        cursor: hand;
    }
    .tip{
        color:red
    }
</style>
@endsection
@section('content')
    <div class="container">
        <div class="row">


            <div class="col-sm-6 col-sm-offset-3" >
                <div class="panel panel-info loginPanel">
                    <div class="panel-heading">
                        <h3 class="panel-title">登录</h3>
                    </div>
                    <div class="panel-body loginBody">
                        <div role="form" >
                            <div class="form-group">
                                <input type="text" class="form-control" v-model="account" placeholder="账号">
                                <div class="tip" v-text="accountTip"></div>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" v-on:keyup.enter="submit" v-model="password" placeholder="密码">
                                <div class="tip" v-text="passwordTip"></div>
                                <div class="tip" v-text="msg" ></div>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" v-model="rememberToken">  记住密码
                            </div>
                            <div class="form-group">
                                 <button class="btn btn-info"  @click='submit' style="width:100%">登录</button>
                            </div>
                        </div>

                        <div>
                            <a>忘记密码?</a>
                            <a class="pull-right">注册</a>
                        </div>
                    </div>


                </div>
            </div>


        </div>
    </div>
@endsection
@section('script')
<script>
    var vm = new Vue({
        el:'#app',
        data:{
            account:"",
            password:'',
            rememberToken:'',
            msg:'',
            accountTip:'',
            passwordTip:'',
        },
        methods:{
            submit(){
                this.$http.post('/login',{
                    account:this.account,
                    password:this.password,
                    rememberToken:this.rememberToken,
                }).then(function (data) {
                    if(data.body.result){
                        location.href='/admin'
                    }else{
                        this.msg = data.body.msg
                    }

                }).catch(function (response) {
                    if(response.status==422){
                        this.accountTip=response.body.account[0]
                        this.passwordTip=response.body.password[0]
                    }
                })
            }
        }
    })
</script>
@endsection