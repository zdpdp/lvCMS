<template>
    <div     v-loading="loading1"
             element-loading-text="加载中">
        <div class="grayRow">

            <el-row class="searchRow">

                <el-col :span="2">
                    <el-select size="small" v-model="searchRole" placeholder="按身份搜索">
                        <el-option
                                v-for="item in roleOptions"
                                :key="item.id"
                                :label="item.name"
                                :value="item.id">
                        </el-option>
                    </el-select>
                </el-col>
                <el-col :span="2">
                    <el-select size="small" v-model="searchState" placeholder="按状态搜索">
                        <el-option
                                v-for="item in stateOptions"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value">
                        </el-option>
                    </el-select>
                </el-col>
                <el-col :span="3">
                    <el-input placeholder="搜索账户，名称" size="small" v-model="searchInfo">

                    </el-input>
                </el-col>
                <el-button size="small" style="margin-left:10px" type="primary" @click="init()" icon="search">查询</el-button>
                <el-button type="primary" size="small" icon="loading" @click="refresh()">重置</el-button>

            </el-row>

        </div>
    <el-table

            :data="users"
            style="width: 100%"
            @selection-change="handleSelect"
            stripe>
        <!--
        <el-table-column type="expand">
            <template scope="props">
                <el-form label-position="left" inline class="demo-table-expand">
                    <el-form-item label="商品名称">
                        <span>{{ props.row.name }}</span>
                    </el-form-item>
                    <el-form-item label="所属店铺">
                        <span>{{ props.row.shop }}</span>
                    </el-form-item>
                    <el-form-item label="商品 ID">
                        <span>{{ props.row.id }}</span>
                    </el-form-item>
                    <el-form-item label="店铺 ID">
                        <span>{{ props.row.shopId }}</span>
                    </el-form-item>
                    <el-form-item label="商品分类">
                        <span>{{ props.row.category }}</span>
                    </el-form-item>
                    <el-form-item label="店铺地址">
                        <span>{{ props.row.address }}</span>
                    </el-form-item>
                    <el-form-item label="商品描述">
                        <span>{{ props.row.desc }}</span>
                    </el-form-item>
                </el-form>
            </template>
        </el-table-column>
        -->
        <el-table-column
                type="selection"
                width="55">
        </el-table-column>

        <el-table-column
                type="index"
                label="#"
                width="180"
               >
        </el-table-column>
        <el-table-column
                prop="account"
                label="账号"
                width="180"
                sortable>
        </el-table-column>
        <el-table-column
                prop="name"
                label="姓名"
                width="180">
        </el-table-column>
        <el-table-column
                prop="role"
                label="角色"
                width="180"
                sortable>
        </el-table-column>
        <el-table-column
                prop="created_at"
                label="注册时间"
                width="180"
                sortable >
        </el-table-column>
        <el-table-column
                prop="register_address"
                label="注册地址"
                >
        </el-table-column>

        <el-table-column label="状态" sortable>
            <template scope="scope">
               {{scope.row.state|stateToWord}}
            </template>
        </el-table-column>

        <el-table-column label="操作"   width="180">
            <template scope="scope">
                <el-button v-if="power.indexOf('editUser')>0"
                        size="small"
                        @click="handleEdit(scope.$index, scope.row)">编辑</el-button>
                <el-button v-if="power.indexOf('deleteUser')>0"
                        size="small"
                        type="danger"
                        @click="handleDelete(scope.$index, scope.row)">删除</el-button>
            </template>
        </el-table-column>
    </el-table>
        <div class="grayRow">
            <el-select size="small" v-model="action" placeholder="选择批量操作">
                <el-option
                        v-for="item in actionOptions"
                        :key="item.value"
                        :label="item.label"
                        :value="item.value">
                </el-option>
            </el-select>
            <el-button type="primary" size="small" icon="loading" @click="batch()">应用批量操作</el-button>
            <el-pagination
                    style="float: right"
                    @size-change="handleSizeChange"
                    @current-change="handleCurrentChange"
                    :current-page="page"
                    :page-sizes="[25,100, 200, 300, 400]"
                    :page-size="pageSize"
                    layout="total, sizes, prev, pager, next, jumper"
                    :total="total">
            </el-pagination>
        </div>

        <!--嵌套框 编辑用户--开始-->
        <el-dialog title="编辑用户" :visible.sync="editUserVisible" >
            <el-form :model="editUser" ref="editUserRules"  :rules="editUserRules">
                <el-row>
                    <el-col :span="14">
                        <el-form-item label="用户账号" :label-width="formLabelWidth"  prop="account">
                            <el-input v-model="editUser.account" auto-complete="off"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="14">
                        <el-form-item label="用户密码" :label-width="formLabelWidth"  prop="password">
                            <el-input placeholder="可留空不做修改" v-model="editUser.password" auto-complete="off"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="14">
                        <el-form-item label="用户昵称" :label-width="formLabelWidth"  prop="name">
                            <el-input v-model="editUser.name" auto-complete="off"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>

                <el-row>
                    <el-col :span="14">
                        <el-form-item label="用户角色" prop="role" :label-width="formLabelWidth" >
                            <el-select   style="width:100%" v-model="editUser.role">
                                <el-option v-for="item in roleOptions"
                                           :key="item.id"
                                           :label="item.name"
                                           :value="item.id"
                                           :disabled="item.disable"
                                >
                                </el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="14">
                        <el-form-item label="用户状态" prop="state" :label-width="formLabelWidth" >
                        <el-select  style="width:100%" v-model="editUser.state" placeholder="请选择">
                            <el-option
                                    v-for="item in stateOptions"
                                    :key="item.value"
                                    :label="item.label"
                                    :value="item.value">
                            </el-option>
                        </el-select>
                        </el-form-item>
                    </el-col>
                </el-row>

            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="editUserVisible = false">取 消</el-button>
                <el-button type="primary" :disabled="editUserConfirm" @click="editUserButton('editUserRules')">确 定</el-button>
            </div>
        </el-dialog>
        <!--嵌套框 编辑用户--结束-->

        <!--嵌套框 状态选择框--开始-->
        <el-dialog size="tiny" title="修改状态" :visible.sync="stateOptionsVisible" >
            <el-form :model="editUser" ref="editUserRules"  >
                <el-row>
                    <el-col :span="14">
                        <el-form-item label="用户状态"  :label-width="formLabelWidth" >
                            <el-select  style="width:100%" v-model="batchChangeState" placeholder="请选择">
                                <el-option
                                        v-for="item in stateOptions"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value">
                                </el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                </el-row>

            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="stateOptionsVisible = false">取 消</el-button>
                <el-button type="primary" :disabled="editUserConfirm" @click="batchChange()">确 定</el-button>
            </div>
        </el-dialog>
        <!--嵌套框 状态选择框--结束-->
    </div>


</template>
<script>
    export default {
        props: ['power'],
        mounted(){
            this.init()

        },
        filters:{
            stateToWord: function (val) {
              if(val==0)
                  return "正常";
              else if(val==1)
                  return '禁止登录';
              else if(val==2)
                  return "禁止发言";
              else if(val==3)
                  return "等待验证";
            }
        },
        data() {
            return {
                batchChangeState:'',
                stateOptionsVisible:false,
                selectItem:[],
                action:'',
                actionOptions:[{
                    value:1,
                    label:"批量删除"
                },{
                    value:2,
                    label:"批量修改状态"
                }],
                searchRole:'',
                searchState:'',
                loading1:false,
                select:"",
                input5: "",
                users: [],
                total:1,

                page:1,
                pageSize:25,
                searchInfo:"",

                formLabelWidth:'120px',
                editUserRules:{
                    account:[
                        { required: true, message: '请输入角色账号', trigger: 'blur' },
                        { min: 6, max: 30, message: '长度在 6到 30 个字符', trigger: 'blur' }
                    ],
                    password:[
                        { required: false, message: '请输入角色密码', trigger: 'blur' },
                        { min: 6, max: 18, message: '长度在 6到 18 个字符', trigger: 'blur' }
                    ],
                    name: [
                        { required: true, message: '请输入角色名称', trigger: 'blur' },
                        { min: 2, max: 10, message: '长度在 2 到 10 个字符', trigger: 'blur' }
                    ],
                    state:[
                        { required: true, type: 'number', message: '请选择用户状态'}
                    ]
                },
                editUserVisible:false,
                editUser:{
                    id:'',
                    account:"",
                    name:'',
                    password:'',
                    state:'',
                    role:'',
                },
                editUserConfirm:false,
                roleOptions:[],
                stateOptions:[{
                    value:0,
                    label:"正常"
                },{
                    value:1,
                    label:"禁止登录"
                },{
                    value:2,
                    label:'禁止发言'
                },{
                    value:3,
                    label:'等待验证'
                }]
            }
        },
        methods: {
            handleSelect(selection){
                this.selectItem = selection


            },
            refresh(){
                Object.assign(this.$data, this.$options.data())
                this.init()
            },
            init(){
                this.loading1=true;
                this.$http.post('/allUser',{

                    page:this.page,
                    pageSize:this.pageSize,
                    searchInfo:this.searchInfo,
                    searchRole:this.searchRole,
                    searchState:this.searchState

                }).then(function (data) {
                    if(data.body.result){
                        this.users=data.body.users.users
                        this.total=data.body.users.total
                        this.roleOptions = data.body.roleOptions
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
                    this.loading1=false;
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
                    this.loading1=false;
                })
            },
            handleEdit(index, row) {
                this.editUserVisible=true
                this.editUser.account = row.account
                this.editUser.name=row.name
                this.editUser.state=row.state
                this.editUser.role=row.role_id
                this.editUser.id = row.id
                console.log(index, row);
            },
            handleDelete(index, row) {
                this.$confirm('此操作将永久删除该用户, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    this.$message.info('正在提交信息')
                    this.$http.post('/admin/allUser/deleteUser',{
                        id:row.id
                    }).then(function (data) {
                        if(data.body.result){
                            this.$message({
                                message: '删除用户成功',
                                type:"success"
                            });
                            this.editUserConfirm=false
                            this.init()
                        }else{
                            this.$message.error({
                                title: '失败',
                                message: data.body.msg,
                            });

                        }
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
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: '已取消删除'
                    });
                });
            },
            editUserButton(ref){
                this.$refs[ref].validate((valid)=>{
                    if(valid){
                        this.editUserConfirm=true;
                        this.$message.info('正在提交信息')
                        this.$http.post('/admin/allUser/editUser',{
                            id:this.editUser.id,
                            editUser:this.editUser
                        }).then(function (data) {
                            if(data.body.result){
                                this.$message({
                                    title: '成功',
                                    message: '编辑用户成功',
                                    type:"success"
                                });
                                this.init()
                            }else{
                                this.$message.error({
                                    title: '失败',
                                    message: data.body.msg,
                                });

                            }
                            this.editUserConfirm=false
                            this.editUserVisible=false
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
                            this.editUserConfirm=false
                            this.editUserVisible=false
                        })

                    }
                })
            },
            handleSizeChange(val)
            {
                this.pageSize=val;
            },
            handleCurrentChange(val)
            {
                this.page=val;
            },
            batchChange(){
                var keyArr = [];
                for(var x of this.selectItem){
                    keyArr.push(x.id)
                }
                this.editUserConfirm = true;
                this.$http.post('/admin/allUser/batchChange',{
                    keyArr:keyArr,
                    state:this.batchChangeState
                }).then(function (data) {
                    if(data.body.result){
                        this.$message({
                            title: '成功',
                            message: '批量修改用户状态成功',
                            type:"success"
                        });
                        this.init()
                    }else{
                        this.$message.error({
                            title: '失败',
                            message: data.body.msg,
                        });
                    }
                    this.editUserConfirm = false;
                    this.stateOptionsVisible = false;

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
                    this.editUserConfirm = false;


                })

            },
            batch(){
                if(!this.action){
                    this.$message.error('请选择操作')
                    return;
                }
                var keyArr = [];
                for(var x of this.selectItem){
                    keyArr.push(x.id)
                }
                if(keyArr.length<1){
                    this.$message.error('当前没有选中项')
                    return;
                }
                var url = ''
                if(this.action==1){
                    url='/admin/allUser/batchDelete'
                }else if(this.action==2){
                    this.stateOptionsVisible=true;
                    return;

                }
                this.$http.post(url,{
                    keyArr:keyArr
                }).then(function (data) {
                    if(data.body.result){
                        this.$message({
                            title: '成功',
                            message: '批量删除用户成功',
                            type:"success"
                        });
                        this.init()
                    }else{
                        this.$message.error({
                            title: '失败',
                            message: data.body.msg,
                        });
                    }

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


            },

        },
        watch:{
            pageSize:'init',
            page:'init'
        }
    }
</script>
<style>
    .searchRow{
        margin-bottom: 0px;
    }
    .grayRow{
        padding: 7px;
        background:#f2f2f2 ;
        margin: 10px 0;
    }
    .demo-table-expand {
        font-size: 0;
    }
    .demo-table-expand label {
        width: 90px;
        color: #99a9bf;
    }
    .demo-table-expand .el-form-item {
        margin-right: 0;
        margin-bottom: 0;
        width: 33%;
    }
</style>