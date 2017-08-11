<template>
    <div   v-loading="loading1"   element-loading-text="加载中">
    <el-row>
        <el-form ref="site" :model="site" :rules="rules" id="siteForm" label-width="120px">
            <el-col :span="12" >
                <div class="mainLeft">
                    <el-form-item label="站点标题" prop="name">
                        <el-input v-model="site.name"></el-input>
                    </el-form-item>
                    <hr>
                    <el-form-item label="站点Logo">
                        <el-upload

                                class="avatar-uploader"
                                action="/qq"
                                :show-file-list="false"
                                :auto-upload="false"
                                :with-credentials="true"
                                name="logo"
                                accept="image/jpg,image/png"
                                :on-change="logoChange"
                               >
                            <img v-if="pic.logo" :src="pic.logo" class="logo">
                            <i v-else class="el-icon-plus avatar-uploader-logo"></i>
                        </el-upload>
                    </el-form-item>

                    <hr>
                    <el-form-item label="站点icon">
                        <el-upload

                                class="avatar-uploader"
                                action="/qq"
                                :show-file-list="false"
                                :auto-upload="false"
                                :with-credentials="true"
                                name="icon"
                                accept="image/jpg,image/png,image/x-icon"
                                :on-change="iconChange"
                               >
                            <img v-if="pic.icon" :src="pic.icon" class="icon">
                            <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                        </el-upload>
                    </el-form-item>

                    <hr>
                    <el-form-item label="网站邮箱">
                        <el-input v-model="site.email"></el-input>
                    </el-form-item>

                    <hr>
                    <el-form-item label="联系人">
                        <el-input v-model="site.contacts"></el-input>
                    </el-form-item>

                    <hr>
                    <el-form-item label="联系电话">
                        <el-input v-model="site.phone"></el-input>
                    </el-form-item>

                    <hr>
                    <el-form-item label="联系QQ">
                        <el-input v-model="site.qq"></el-input>
                    </el-form-item>

                    <hr>
                    <el-form-item label="站点关键字">
                        <el-input v-model="site.keyWord"></el-input>
                    </el-form-item>
                </div>
            </el-col>

            <el-col :span="12" >
                <div class="mainRight">
                    <el-form-item label="开放注册" required>
                        <el-switch on-text="是" off-text="否" v-model="site.openRegister"></el-switch>
                    </el-form-item>
                    <hr>
                        <el-form-item label="新用户默认角色" required>
                        <el-select v-model="site.defaultRole" placeholder="请选择">
                            <el-option
                                    v-for="item in roleOption"
                                    :key="item.value"
                                    :label="item.label"
                                    :value="item.value">
                            </el-option>
                        </el-select>
                    </el-form-item>
                    <hr>
                    <el-form-item label="ICB备案号">
                        <el-input v-model="site.ICB"></el-input>
                    </el-form-item>
                    <hr>
                    <el-form-item label="站点描述">
                        <el-input type="textarea"  autosize v-model="site.discription"></el-input>
                    </el-form-item>
                    <el-form-item>
                        <el-button v-if="power.indexOf('editSiteSetting')>0" type="primary" @click="onSubmit('site')">保存配置</el-button>
                        <el-button type="primary" @click="reset">重置配置</el-button>
                    </el-form-item>
                </div>
            </el-col>

        </el-form>

    </el-row>

    </div>

</template>
<style>
    .mainLeft,.mainRight{
        padding: 0 50px;
    }
    hr{
        border:0;border-top:1px dashed #d3d3d3;padding: 10px;
    }
    .avatar-uploader .el-upload {
        border: 1px dashed #d9d9d9;
        border-radius: 6px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }
    .avatar-uploader .el-upload:hover {
        border-color: #20a0ff;
    }
    .avatar-uploader-icon {
        font-size: 28px;
        color: #8c939d;
        width: 100px;
        height: 100px;
        line-height: 100px;
        text-align: center;
    }
    .avatar-uploader-logo {
        font-size: 28px;
        color: #8c939d;
        width: 400px;
        height: 100px;
        line-height: 100px;
        text-align: center;
    }
    .logoSelf{
        width: 100% ;
    }
    .icon {
        width: 100px;
        height: 100px;
        display: block;
    }
    .logo{
        width: 100%;
        height: 100px;
        display: block;
    }
</style>
<script>
    export default {
        props: ['power'],
        mounted:function(){

            this.init();


        },
        data() {
            return {
               loading1:false,
                site: {
                    name: '',
                    email:'',
                    contacts:'',
                    phone:'',
                    qq:'',
                    keyWord:'',
                    openRegister:'',
                    defaultRole:'',
                    ICB:'',
                    discription:'',
                },
                pic:{
                    logo:'',
                    icon:'',
                },
                roleOption:[],
                rules:{
                    name: [
                        { required: true, message: '请输入站点名称', trigger: 'blur' },
                        { min: 2, max: 10, message: '长度在 2 到 10 个字符', trigger: 'blur' }
                    ],
                },
                picChange:{
                    logoChange:0,
                    iconChange:0
                },
            };
        },
        methods: {
            init(){
                this.loading1=true
                this.$http.get("/siteSetting",{

                }).then(function(data){

                    if(data.body.result){


                        /*设置默认身份下拉框*/
                        var roleOotion = data.body.roleOption
                        for(var i=0;i<roleOotion.length;i++)
                        {
                            var item =[];
                            item['value']=roleOotion[i].id
                            item['label']=roleOotion[i].name
                            this.roleOption.push(item);
                        }

                        /*设置基本数据*/
                        var site = data.body.site
                        this.site.name = site.name
                        this.pic.logo = site.logo
                        this.pic.icon = site.icon
                        this.site.email = site.email
                        this.site.contacts = site.contacts

                        this.site.phone = site.phone
                        this.site.qq = site.qq
                        this.site.keyWord = site.keyWord
                        this.site.openRegister = site.openRegister==1?true:false
                        this.site.defaultRole = site.defaultRole
                        this.site.ICB = site.ICB
                        this.site.discription = site.discription

                        this.$message({
                            title: '成功',
                            message: '获取信息成功',
                            type:"success"
                        });


                    }else{
                        this.$message.error({
                            title: '失败',
                            message: data.body.msg,
                        });
                    }
                    this.loading1=false
                })
            },
            reset(){
                this.site = {
                    name: '',
                    email:'',
                    contacts:'',
                    phone:'',
                    qq:'',
                    keyWord:'',
                    openRegister:'',
                    defaultRole:'',
                    ICB:'',
                    discription:'',
                };
                this.roleOption=[];
                this.picChange ={
                    logoChange:0,
                    iconChange:0
                };
                this.init()

            },
            logoChange(file){
               //this.site.logo = URL.createObjectURL(file.raw);
                var p =$("input[name='logo']").get(0)

                var size = p.files[0].size

                var type = p.files[0].type


                if(!/image\/\w+/.test(type)){
                    this.$message.error('只能上传图片');
                    return;
                }

                if(size>2*1024*1024){
                    this.$message.error('图片最大为2M');
                    return
                }


                var reader = new FileReader();
                reader.readAsDataURL(p.files[0]);
                var x = this
                reader.onload =function(e){
                  x.pic.logo = e.target.result
                };
                this.picChange.logoChange=1


            },
            iconChange(file){
                var p =$("input[name='icon']").get(0)

                var size = p.files[0].size

                var type = p.files[0].type

                if(!/image\/\w+/.test(type)){
                    this.$message.error('只能上传图片');
                    return;
                }

                if(size>2*1024*1024){
                    this.$message.error('图片最大为2M');
                    return
                }



                var reader = new FileReader();
                reader.readAsDataURL(p.files[0]);
                var x = this
                reader.onload =function(e){
                    x.pic.icon = e.target.result
                };
                this.picChange.iconChange=1
            },
            onSubmit(formName){
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        this.loading1=true
                        this.$message.info({
                            title: '消息',
                            message: '正在更新站点配置'
                        });

                        this.$http.post("/admin/site/set",{

                            site:this.site,
                            icon:this.picChange.iconChange?this.pic.icon:"",
                            logo:this.picChange.logoChange?this.pic.logo:"",

                        }).then(function(data){

                            if(data.body.result){
                                this.$message({
                                    title: '成功',
                                    message: '站点配置更新成功',
                                    type: 'success'
                                });
                            }else{
                                this.$message.error({
                                    title: '失败',
                                    message: data.body.msg
                                });
                            }
                            this.loading1=false
                        }).catch(function (response) {
                            if(response.status==422){
                                var x = this
                                for (var Key in response.body){

                                    var m = response.body[Key]
                                    this.$message.error(m[0])

                                }
                            }else{
                                this.$message.error('错误：状态码'+response.status);
                            }
                        })
                    } else {
                        this.$message.error('信息未通过校验，请重新核查');
                        return false;
                    }
                });
            }


        },

    }
</script>