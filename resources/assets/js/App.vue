<template >
    <div id="app"  v-loading="loading1"
         element-loading-text="加载中" >
        <div class="head">
            <span class="web_title">后台管理系统</span>
            <el-dropdown style="float:right"  trigger="click"  @command="handleCommand">
              <span class="el-dropdown-link">
              <img class="head_pic" :src="head">

              </span>
                <el-dropdown-menu slot="dropdown">
                    <el-dropdown-item command="a">返回主页</el-dropdown-item>
                    <el-dropdown-item command="b">注销</el-dropdown-item>
                </el-dropdown-menu>
            </el-dropdown>

            <span class="name">{{name}}</span>

        </div>
        <div class="main">

            <div class="left">
                <el-row class="maxheight">
                        <el-menu  :default-active="activeIndex" class="maxheight"  :unique-opened="true" :router="true">
                            <el-submenu :index="index+''"  v-for="(nav,index) in navs" :key="nav.id">
                                <template slot="title"><i :class="nav.icon" style="margin-right: 10px" ></i>{{nav.name}}</template>
                                <el-menu-item-group v-for="(item,key) in nav.child" :key="item.id" >
                                    <el-menu-item :id="item.url.substring(1)" :index="item.url">{{item.name}}</el-menu-item>
                                </el-menu-item-group>
                            </el-submenu>
                        </el-menu>
                </el-row>

            </div>


            <div class="right">

                <transition name="slide-fade">


                        <router-view :power="power"></router-view>


                </transition>

            </div>
        </div>


    </div>
</template>
<script>
    export default{

        props: ['navs','head','name','power'],
        data:function(){
            return{
                loading1:false,
                flag:1,
                activeIndex:'',
            }
        },
        created(){
          this.loading1 = true
        },
        updated(){
            this.loading1 = false

        },
        mounted:function(){

            var path = this.$route.path;
            if(path=='/'){
                this.flag++
            }
        },
        methods:{
            handleCommand(command) {
                var url =''
                if(command=='a'){
                    url = './'
                }else if(command=='b'){
                    url = './logout'
                }
                location.href = url
            },

        },
        watch:{
            $route:function () {
                this.activeIndex = this.$route.path;

//                if(this.flag==1){
//                    this.routeTurn()
//                }

            }
        }


    }
</script>
<style>
    #app{
        font-family: "Helvetica Neue",Helvetica,"PingFang SC","Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;
    }
    .head{
        background: #20a0ff;
        height:60px;
        line-height:60px;
        color:#ffffff;
        width: 100%;
    }
    .head .web_title{
        font-size: 24px;
        padding-left: 35px;
    }

    .head .head_pic{
        width: 40px;
        height: 40px;
        border-radius: 20px;
        margin: 10px 30px 10px 10px;
        float:right;
    }
    .head_pic:hover{
        cursor: pointer;
    }
    .head .name{
        float:right;

    }
    .main{
        display: flex;
        position: absolute;
        top:60px;
        bottom:0;
        width:100%;

    }
    .left{
        width: 230px;
        flex:0 0 230px;
    }
    .left .maxheight{
        height:100%;
    }
    .right{
        flex:1;
        overflow-y:scroll;
        padding:20px;

    }
</style>