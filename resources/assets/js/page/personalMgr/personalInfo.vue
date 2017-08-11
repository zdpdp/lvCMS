<template>
    <div  v-loading="loading1"   element-loading-text="加载中" >
        <el-card class="box-card" >

            <el-tabs v-model="activeTag" type="card" @tab-click="handleTagClick">
                <el-tab-pane label="基本信息" name="baseVisable"></el-tab-pane>
                <el-tab-pane label="详细资料" name="detailVisable"></el-tab-pane>
                <el-tab-pane label="修改密码" name="changePswVisable"></el-tab-pane>
            </el-tabs>
            <div class="text item">

                <!-- 基本信息 -->
                <div v-show="visit.baseVisable">
                    <el-form   :label-position="labelPosition"  :label-width="formLabelWidth" >
                        <el-row>
                            <el-col :span="span" :offset="offset">
                                <el-form-item label="用户账号"  >
                                    <el-input v-model="account"  :disabled="true" size="large" auto-complete="off"></el-input>
                                </el-form-item>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="span" :offset="offset">
                                <el-form-item label="身份"  >
                                    <el-input v-model="role"  :disabled="true" size="large" auto-complete="off"></el-input>
                                </el-form-item>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="span"  :offset="offset">
                                <el-form-item label="头像">
                                    <el-upload
                                            class="avatar-uploader"
                                            action="/no"
                                            :show-file-list="false"
                                            :auto-upload="false"
                                            :with-credentials="true"
                                            name="headPic"
                                            accept="image/jpg,image/png"
                                            :on-change="headPicChange"
                                    >
                                        <img v-if="headPic" :src="headPic" class="headPic">
                                        <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                                    </el-upload>
                                </el-form-item>

                            </el-col>
                        </el-row>

                        <el-row>
                            <el-col :span="span" :offset="offset">
                                <el-form-item label="性别" prop="sex">
                                    <el-radio class="radio" v-model="userInfo.sex" label="1">男</el-radio>
                                    <el-radio class="radio" v-model="userInfo.sex" label="2">女</el-radio>
                                    <el-radio class="radio" v-model="userInfo.sex" label="3">未知</el-radio>
                                </el-form-item>
                            </el-col>
                        </el-row>

                        <el-row>
                            <el-col :span="span" :offset="offset">
                                <el-form-item label="昵称" prop="name">
                                    <el-input v-model="userInfo.name"  size="large" auto-complete="off"></el-input>
                                </el-form-item>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="span" :offset="offset">
                                <el-form-item label="手机号码"  prop="phone">
                                    <el-input v-model="userInfo.phone"  size="large" auto-complete="off"></el-input>
                                </el-form-item>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="span" :offset="offset">
                                <el-form-item label="邮箱"  prop="email" >
                                    <el-input type='email' v-model="userInfo.email"  size="large" auto-complete="off"></el-input>
                                </el-form-item>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="span" :offset="offset">
                                <el-form-item label="生日"  prop="birth"  >
                                    <el-date-picker
                                            style="width: 100%"
                                            v-model="userInfo.birth"
                                            type="date"
                                            placeholder="选择日期"
                                            @change="handleChange"
                                            format="yyyy-MM-dd"
                                            :picker-options="pickerOptions0">
                                    </el-date-picker>
                                </el-form-item>
                            </el-col>
                        </el-row>

                        <el-row>
                            <el-col :span="span" :offset="offset">
                                <el-button  v-if="power.indexOf('editSelfInfo')>0" style="margin-left:120px" type="info" size="large" @click="saveBase">保存</el-button>
                                <el-button style="" type="info" size="large" @click="baseInit">重置</el-button>
                            </el-col>
                        </el-row>
                    </el-form>
                </div>

                <!-- 详细信息 -->
                <div v-show="visit.detailVisable">

                </div>

                <!-- 修改密码 -->
                <div v-show="visit.changePswVisable">

                </div>

            </div>
        </el-card>
    </div>
</template>
<script>
    export default{
        props: ['power'],
        mounted(){
            this.baseInit()
        },
        data(){
            return {
                loading1:false,
                visit:{
                    baseVisable:true,
                    detailVisable:false,
                    changePswVisable:false,
                },
                pickerOptions0: {
                    disabledDate(time) {
                        return time.getTime() > Date.now();
                    }
                },
                activeTag:'baseVisable',
                span:18,
                offset:2,
                formLabelWidth:"120px",
                labelPosition: 'left',

                userInfo:{
                    phone:'',
                    email:'',
                    name:"",
                    birth:null,
                    sex:'1',
                },
                role:'',
                account:"",
                headPic:'',


                headPicChangeFlag:0,

                userBaseInforules:{
//                    name: [
//                        { required: true, message: '请输入站点名称', trigger: 'blur' },
//                        { min: 2, max: 10, message: '长度在 2 到 10 个字符', trigger: 'blur' }
//                    ],
                }

            }
        },
        methods:{
            handleChange(val){
              this.userInfo.birth = val
            },
            baseInit(){
                this.loading1=true
              this.$http.get('/userInfo',{

              }).then(function (data) {
                  if(data.body.result){

                      this.account = data.body.userInfo.account
                      this.role = data.body.userInfo.role
                      this.headPic = data.body.userInfo.head
                      this.userInfo.sex = data.body.userInfo.sex+''
                      this.userInfo.phone = data.body.userInfo.phone
                      this.userInfo.email = data.body.userInfo.email
                      this.userInfo.name = data.body.userInfo.name
                      this.userInfo.birth = data.body.userInfo.birth
                      this.$message.success('获取基本信息成功')
                  }else{
                      this.$message.error('获取基本信息失败:'+data.body.msg)

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
                  this.loading1=false

              })
            },
            saveBase(){
                this.$message.info('正在提交信息')
                this.loading1=true
                this.$http.post('/admin/userInfo/saveBase',{

                    userInfo:this.userInfo,
                    headPic:this.headPicChangeFlag==1?this.headPic:""

                }).then(function (data) {

                    if(data.body.result){
                        this.$message.success('保存基本信息成功')
                        if(this.headPicChangeFlag==1){
                            $('.head').find('img').attr('src',this.headPic)
                        }
                        $('.name').html(this.userInfo.name)
                    }else{
                        this.$message.error('保存信息失败')
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
                    this.loading1=false

                })
            },
            detailInit(){

            },

            headPicChange(){
                var p =$("input[name='headPic']").get(0)

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
                    x.headPic = e.target.result
                };
                this.headPicChangeFlag=1

            },
            handleTagClick(val){
                for(var key in this.visit){
                    if(val.name==key){
                        this.visit[key]=true;
                    }else{
                        this.visit[key]=false;
                    }
                }
                console.log(val.name)
            },
        },
    }
</script>
<style scoped="scoped" >
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
        width: 120px;
        height: 120px;
        line-height: 120px;
        text-align: center;
        border-radius:60px;
    }
    .avatar {
        width: 120px;
        height: 120px;
        display: block;
    }

    .headPic{
        width: 120px;
        height: 120px;
        border-radius:60px;
    }
    .text {
        font-size: 14px;
    }

    .item {
        padding: 18px 0;
    }

    .clearfix:before,
    .clearfix:after {
        display: table;
        content: "";
    }
    .clearfix:after {
        clear: both
    }

    .box-card {
        margin: 30px auto;
        width: 60%;
    }
    label{
        font-size: 20px;
    }
</style>