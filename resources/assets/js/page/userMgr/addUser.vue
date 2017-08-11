<template>
    <div v-loading="loading1"
         element-loading-text="加载中">
        <el-card class="addOneUser">
            <div slot="header" class="clearfix">
                <span style="line-height: 36px;">添加用户</span>


            </div>
            <div class=" ">
                <el-form :model="newUser" :rules="newUserRules" ref="newUser" label-width="50px" class="">
                    <el-form-item label="账号" prop="account">
                        <el-input v-model="newUser.account"></el-input>
                    </el-form-item>
                    <el-form-item label="密码" prop="password">
                        <el-input v-model="newUser.password"></el-input>
                    </el-form-item>
                    <el-form-item label="名称" prop="name">
                        <el-input v-model="newUser.name"></el-input>
                    </el-form-item>
                    <el-form-item label="角色" prop="role">
                    <el-select   style="width:100%" v-model="newUser.role">
                        <el-option v-for="item in options"
                                   :key="item.id"
                                   :label="item.name"
                                   :value="item.id"
                                   :disabled="item.disable"
                                   >
                        </el-option>
                    </el-select>
                    </el-form-item>
                    <el-form-item>
                        <el-button v-if="power.indexOf('addOneUser')>0" type="primary" @click="addOneUser()" :disable="addButton">提交</el-button>
                        <el-button @click="resetForm()">重置</el-button>
                    </el-form-item>
                </el-form>
            </div>
        </el-card>

    </div>
</template>
<script>
    export default {
        props: ['power'],
        mounted(){
            this.init()

        },
        data() {
            return {
                loading1:false,
                newUser:{
                    account:"",
                    password:"",
                    name:"",
                    role:"",
                },
                options:{

                },
                newUserRules:{
                    account:[
                        { required: true, message: '请输入角色账号', trigger: 'blur' },
                        { min: 6, max: 30, message: '长度在 6到 30 个字符', trigger: 'blur' }
                    ],
                    password:[
                        { required: true, message: '请输入角色密码', trigger: 'blur' },
                        { min: 6, max: 18, message: '长度在 6到 18 个字符', trigger: 'blur' }
                    ],
                    name: [
                        { required: true, message: '请输入角色名称', trigger: 'blur' },
                        { min: 2, max: 10, message: '长度在 2 到 10 个字符', trigger: 'blur' }
                    ],
                    role:[
                        { required: true, type: 'number', message: '请选择用户身份'}
                    ]
                },
                addButton:false,


            }
        },
        methods: {
            init(){
                this.loading1=true
                this.$message.info('正在获取信息');
                this.$http.get('/addUser', {}).then(function (data) {
                    if (data.body.result) {
                        this.options = data.body.options
                        this.$message.success('获取信息成功');
                    } else {
                        this.$message.error({
                            title:'失败',
                            message:data.body.msg
                        })
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
            addOneUser(){

                this.$refs['newUser'].validate((valid)=>{
                    if(valid){
                        this.addButton=true;
                        this.$message.info('正在提交信息');
                        this.loading1=true
                        this.$http.post('/admin/addUser/addOneUser',{
                            newUser:this.newUser
                        }).then(function (data) {
                            if(data.body.result){
                                this.$message({
                                    title: '成功',
                                    message: '添加用户成功',
                                    type:"success"
                                });
                            }else{
                                this.$message.error({
                                    title: '失败',
                                    message: data.body.msg,
                                });

                            }
                            this.loading1=false
                            this.addButton=false
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
                            this.addButton=false
                            this.loading1=false

                        })
                    }
                })
            },
            resetForm(){

                this.$refs['newUser'].resetFields()
            },

        }
    }
</script>
<style>
    .addOneUser{
        width:30%;
        margin:100px auto;
    }

</style>