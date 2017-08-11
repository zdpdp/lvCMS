<template>
    <div   v-loading="loading1"
           element-loading-text="加载中">
        <div class="grayRow">
            <el-button v-if="power.indexOf('addRole')>0" type="primary" size="small" icon="plus" @click="openNewRoleForm">新增角色</el-button>
            <el-button type="primary" size="small" icon="loading" @click="refresh()">刷新</el-button>
        </div>
        <el-table

                :data="roleInfo"
                stripe
                style="width: 100%">
            <el-table-column
                    prop="grade"
                    label="角色级别"
                    width="250">
            </el-table-column>
            <el-table-column
                    prop="name"
                    label="角色名"
                    width="250">
            </el-table-column>
            <el-table-column
                    prop="num"
                    label="人数"
                    width="250">
            </el-table-column>
            <el-table-column
                    label="默认角色"
                    width="250">
                <template scope="scope">
                  {{ scope.row.ifDefault==1?'是':'否' }}
                </template>
            </el-table-column>
            <el-table-column label="操作" >
                <template scope="scope">
                    <el-button v-if="power.indexOf('grantPower')>0"
                            type="primary"
                            size="small"
                            @click="handlePermission(scope.$index, scope.row)">权限</el-button>
                    <el-button v-if="power.indexOf('editRole')>0"
                            size="small"
                            @click="handleEdit(scope.$index, scope.row)">编辑</el-button>
                    <el-button v-if="power.indexOf('deleteRole')>0"
                            size="small"
                            type="danger"
                            @click="handleDelete(scope.$index, scope.row)">删除</el-button>
                </template>
            </el-table-column>
        </el-table>

        <!--嵌套框 新增角色--开始-->
        <el-dialog title="新增角色" :visible.sync="newRoleVisible" >


            <el-form :model="newRole" ref="newRole"  :rules="newRoleRules">
                <el-row>
                    <el-col :span="14">
                        <el-form-item label="角色名称" :label-width="formLabelWidth"  prop="name">
                            <el-input v-model="newRole.name" auto-complete="off"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="14">
                        <el-form-item label="角色级别" :label-width="formLabelWidth"  prop="grade">
                            <el-input-number v-model="newRole.grade"  :min="1" :max="10"></el-input-number>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="14">
                        <el-form-item label="" :label-width="formLabelWidth">
                            <span style="color:red">Tip：新增角色的权限将会参考同级别角色</span>
                        </el-form-item>
                    </el-col>
                </el-row>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="newRoleVisible = false">取 消</el-button>
                <el-button type="primary" :disabled="newRoleButton" @click="addRole('newRole')">确 定</el-button>
            </div>
        </el-dialog>
        <!--嵌套框 新增角色--结束-->

        <!--嵌套框 编辑权限--开始-->
        <el-dialog :title="currentRole.name+'权限'"  v-loading="loading2" :visible.sync="PermissionVisible" @open="open()">
            <el-tree
                    :data="permissionInfo"
                    show-checkbox
                    check-strictly
                    node-key="id"
                    :default-expand-all="expland"
                    ref="tree"
                    :indent="50"
                    :props="defaultProps">
            </el-tree>
            <div slot="footer" class="dialog-footer">
                <el-button @click="PermissionVisible=false">取 消</el-button>
                <el-button type="primary" :disabled="editPermissionButton" @click="editPermission()">确 定</el-button>
            </div>
        </el-dialog>
        <!--嵌套框 编辑权限--结束-->

        <!--嵌套框 基本信息修改--开始-->
        <el-dialog :title="baseInfoRole.name+'信息'" :visible.sync="BaseInfoVisible" >
            <el-form :model="roleBaseInfo" ref="roleBaseInfo"  :rules="newRoleRules">
                <el-row>
                    <el-col :span="14">
                        <el-form-item label="角色名称" :label-width="formLabelWidth"  prop="name">
                            <el-input v-model="roleBaseInfo.name" auto-complete="off"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="14">
                        <el-form-item label="角色级别" :label-width="formLabelWidth"  prop="grade">
                            <el-input-number v-model="roleBaseInfo.grade"  :min="1" :max="10"></el-input-number>
                        </el-form-item>
                    </el-col>
                </el-row>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="BaseInfoVisible = false">取 消</el-button>
                <el-button type="primary" :disabled="baseInfoEdit" @click="editConfirm">确 定</el-button>
            </div>
        </el-dialog>
        <!--嵌套框 基本信息修改--结束-->


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
                roleInfo:[],

                /*新增用户*/
                newRoleVisible: false,
                newRole: {
                    name: '',
                    grade:10,
                },
                formLabelWidth: '120px',
                newRoleRules:{
                    name: [
                        { required: true, message: '请输入角色名称', trigger: 'blur' },
                        { min: 2, max: 10, message: '长度在 2 到 10 个字符', trigger: 'blur' }
                    ],
                    grade:[
                        { required: true, type: 'number', message: '级别必须为数字值'}
                    ]
                },
                newRoleButton:false,

                /*编辑权限*/
                PermissionVisible:false,
                permissionInfo:[],
                defaultProps: {
                    children: 'children',
                    label: 'label'
                },
                expland:false,
                getPermission:[],
                currentRole:{
                    name:""
                },
                editPermissionButton:false,
                loading2:false,

                /*编辑基本信息*/
                baseInfoRole:"",
                BaseInfoVisible:false,
                baseInfoEdit:false,

                roleBaseInfo:{
                    role_id:"",
                    name:"",
                    grade:"",
                    index:"",
                },


            }
        },
        methods:{
            openNewRoleForm(){
                this.newRole= {
                    name: '',
                    grade:10,
                }
                this.newRoleVisible=true

            },
            refresh(){
                Object.assign(this.$data, this.$options.data())
                this.init()
            },
            init(){
                this.loading1=true
                this.$http.get('/role',{

                }).then(function (data) {
                    if(data.body.result){
                        /*获取角色信息*/
                        this.roleInfo = data.body.msg
                        /*获取所有功能信息*/
                        for(var i=0;i<data.body._function.length;i++){
                            this.permissionInfo.push(data.body._function[i]);
                        }
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
            addRole(formName){
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        this.newRoleButton=true;
                        this.$message.info({
                            title: '消息',
                            message: '正在创建新角色'
                        });

                        this.$http.post('/admin/user/newRole',{
                            newRole:this.newRole
                        }).then(function (data) {
                            if(data.body.result){
                                this.$message({
                                    title: '成功',
                                    message: '新建角色成功',
                                    type:"success"
                                });
                                this.newRoleVisible = false
                                var temp = data.body.newRole
                                var tempRole={
                                    grade:temp.grade,
                                    role_id:temp.id,
                                    ifDefault:temp.ifDefault,
                                    num:0,
                                    name:temp.name,
                                }
                                this.roleInfo.push(tempRole)

                            }else{
                                this.$message.error({
                                    title: '失败',
                                    message: data.body.msg,
                                });
                            }
                            this.newRoleButton=false;
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
                            this.newRoleButton=false;

                        })
                    } else {
                        this.$message.error('未通过校验规则')
                        return false;
                    }
                });

            },
            setKey() {
                this.$refs.tree.setCheckedKeys(this.getPermission);
            },
            handlePermission(index,item){
                this.PermissionVisible=true
                this.currentRole = item
                this.loading2=true

                this.$http.get('/admin/user/editRolePermission',{
                    params:{role_id:item.role_id}
                }).then(function (data) {
                    if(data.body.result){
                        /*获取角色权限*/
                       this.getPermission=data.body.permissionId

                        this.setKey(this.getPermission)

                    }else{
                        this.$message.error({
                            title: '失败',
                            message: data.body.msg,
                        });
                    }
                    this.loading2=false
                })


            },
            open(){
                console.log(this.$refs)
            },
            editPermission(){

                this.editPermissionButton = true

                this.$http.post('/admin/user/editRolePermission',{
                    permissionArr:  this.$refs.tree.getCheckedKeys(),
                    role_id:this.currentRole.role_id
                }).then(function (data) {
                    if(data.body.result){

                        this.$message({
                            title: '成功',
                            message: '修改角色权限成功',
                            type:"success"
                        });
                        this.PermissionVisible=false

                    }else{
                        this.$message.error({
                            title: '失败',
                            message: data.body.msg,
                        });
                    }
                    this.editPermissionButton=false
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
                    this.editPermissionButton=false

                })
            },
            handleEdit(index,item){
                this.baseInfoRole = item;
                this.roleBaseInfo.role_id = item.role_id;
                this.roleBaseInfo.name = item.name;
                this.roleBaseInfo.grade = item.grade;
                this.roleBaseInfo.index = index;
                this.BaseInfoVisible = true;
                this.BaseInfoVisible = true;

            },
            editConfirm(forName){
                this.$refs['roleBaseInfo'].validate((valid) => {
                    if (valid){
                        this.baseInfoEdit = true
                        this.$http.post('/admin/user/editRoleBaseInfo',{
                            roleBaseInfo:this.roleBaseInfo
                        }).then(function (data) {
                            if(data.body.result){

                                this.$message({
                                    title: '成功',
                                    message: '修改角色信息成功',
                                    type:"success"
                                });
                                this.roleInfo[this.roleBaseInfo.index].name= this.roleBaseInfo.name
                                this.roleInfo[this.roleBaseInfo.index].grade= this.roleBaseInfo.grade
                            }else{
                                this.$message.error({
                                    title: '失败',
                                    message: data.body.msg,
                                });
                            }
                            this.baseInfoEdit = false
                            this.BaseInfoVisible=false

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
                            this.baseInfoEdit = false


                        })

                    }else{
                       this.$message.error('未通过校验规则');
                       return
                    }
                });

            },
            handleDelete(index,item){
                if(item.ifDefault==1){
                    this.$message.error('无法删除默认角色');
                    return
                }
                if(item.num>0){
                    this.$message.error('请先删除该角色下所有用户');
                    return
                }
                this.$confirm('此操作将永久删除该角色,是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                }).then(() => {
                    this.$http.post('/admin/user/deleteRole',{
                        role_id:item.role_id
                    }).then(function (data) {
                        if(data.body.result){
                            this.roleInfo.splice(index, 1);
                            this.$message({
                                type: 'success',
                                message: '删除成功!'
                            });
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
            }

        }
    }
</script>
<style>
    .grayRow{
        padding: 10px;
        background:#f2f2f2 ;
        margin: 10px 0;
    }
</style>