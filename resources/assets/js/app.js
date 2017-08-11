
//require('./bootstrap');

import App from './App.vue'
import Vue from 'vue'
import VueRouter from 'vue-router'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-default/index.css'
import 'font-awesome/css/font-awesome.css'
import VueResource from 'vue-resource'


Vue.use(VueRouter)
Vue.use(ElementUI)
Vue.use(VueResource)

const router = new VueRouter({
    routes: [
       // { path: '/', component: resolve => require(['./components/Example.vue'], resolve)}
    ]
})
const routeMap={
    个人资料 :resolve => require(['./components/Example.vue'], resolve),
    常规设置 :resolve => require(['./page/siteMgr/siteSetting.vue'], resolve),
    友情链接:resolve => require(['./page/siteMgr/friendLink.vue'],resolve),
    所有用户:resolve => require(['./page/userMgr/allUser.vue'], resolve),
    角色管理:resolve => require(['./page/userMgr/role.vue'], resolve),
    添加用户:resolve => require(['./page/userMgr/addUser.vue'], resolve),
    个人信息:resolve => require(['./page/personalMgr/personalInfo.vue'],resolve),
    添加文章:resolve => require(['./page/articleMgr/addArticle.vue'],resolve),
    文章类别:resolve => require(['./page/articleMgr/articleClassMgr.vue'],resolve),
    所有文章:resolve => require(['./page/articleMgr/allArticle.vue'],resolve),
    评论管理:resolve => require(['./page/articleMgr/remarkMgr.vue'],resolve),
    访问统计:resolve => require(['./page/visitMgr/visitLog.vue'],resolve),

}
const app = new Vue({
    data:{
        nav :"",
        head :'',
        name:'',
        power:''

    },
    el: '#app',
    router,
    template: '<App :navs="nav" :head="head" :name="name" :power="power"></App>',
    components: { App },
    created:function()
    {

        this.$http.post("/admin",{

        }).then(function(data){

            if(data.body.result){
                this.nav = data.body.msg
                for(var i=0;i<this.nav.length;i++)
                {

                    for(var j=0;j<this.nav[i].child.length;j++)
                    {
                        router.addRoutes([ { path: this.nav[i].child[j].url, component: routeMap[this.nav[i].child[j].name]}])
                    }
                }
                this.head = data.body.head
                this.name = data.body.name
                this.power = data.body.power


            }else{
                this.$message.error("错误:"+data.body.msg)
                //toastr.error(data.body.msg)
            }
        })
    }
});

