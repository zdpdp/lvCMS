<template>
    <div   v-loading="loading1"
           element-loading-text="加载中">
        <div class="grayRow">
            <el-button v-if="power.indexOf('addFriend')>0" type="primary" size="small" icon="plus" @click="handleAdd()">新增链接</el-button>
            <el-button type="primary" size="small" icon="loading" @click="refresh()">刷新</el-button>
        </div>
        <el-table
                @selection-change="handleSelect"
                :data="friends"
                stripe
                style="width: 100%">
            <el-table-column
                    type="selection"
                    width="55">
            </el-table-column>
            <el-table-column
                    type="index"
                    label="#"
                    width="100">
            </el-table-column>
            <el-table-column
                    prop="name"
                    label="链接名"
                    width="250">
            </el-table-column>
            <el-table-column
                    prop="url"
                    label="链接地址"
                    width="250">
            </el-table-column>
            <el-table-column
                    label="状态"
                    width="250">
                <template scope="scope">
                    <el-tag :type="scope.row.top==1?'primary':'danger'">{{scope.row.top==1?"置顶":"普通"}}</el-tag>
                </template>
            </el-table-column>
            <el-table-column label="操作" >
                <template scope="scope">
                    <el-button v-if="power.indexOf('editFriend')>0"
                               size="small"
                               @click="handleEdit(scope.$index, scope.row)">编辑</el-button>
                    <el-button v-if="power.indexOf('deleteFriend')>0"
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
        </div>
        <!--嵌套框 新增链接--开始-->
        <el-dialog size="tiny" :title='title' :visible.sync="newUrlVisitable" >


            <el-form :model="friend" ref="newRole" >
                <el-row>
                    <el-col :span="22">
                        <el-form-item label="链接名" label-width="120px" >
                            <el-input v-model="friend.name" ></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="22">
                        <el-form-item label="链接地址" label-width="120px" >
                            <el-input v-model="friend.url" ></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="22">
                        <el-form-item label="置顶" label-width="120px" >
                            <el-switch
                                    v-model="friend.top"
                                    on-text="是"
                                    off-text="否"
                                    on-color="#13ce66"
                                    off-color="#ff4949"
                                    :on-value="1"
                                    :off-value="0">
                            </el-switch>
                        </el-form-item>
                    </el-col>
                </el-row>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="newUrlVisitable = false">取 消</el-button>
                <el-button type="primary" :disabled="newUrlButton" @click="addOrEditUrl()">确 定</el-button>
            </div>
        </el-dialog>
        <!--嵌套框 新增链接--结束-->


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
                selectItem:[],
                actionOptions:[{
                    value:1,
                    label:"批量删除"
                }],
                action:'',
                loading1:false,
                newUrlButton:false,
                friends:[],
                newUrlVisitable:false,
                title:'',
                friend:{
                    name:'',
                    url:'',
                    top:0
                },
                type:'',

            }
        },
        methods:{
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
                var url =''
                if(this.action==1){
                    url='/admin/friends/batchDelete'
                }
                this.$http.post(url,{
                    keyArr:keyArr
                }).then(function (data) {
                    if(data.body.result){
                        this.$message({
                            title: '成功',
                            message: '批量删除链接成功',
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
            handleSelect(selection){
                this.selectItem = selection
            },
            refresh(){
                Object.assign(this.$data, this.$options.data())
                this.init()
            },
            init(){
                this.loading1=true
                this.$http.post('/friends',{

                }).then(function (data) {
                    if(data.body.result){
                        this.friends = data.body.friends
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
            addOrEditUrl(formName){
                        if(this.friend.name.trim().length<1){
                            this.$message.error('链接名不能为空')
                            return
                        }
                        if(this.friend.url.trim().length<1){
                            this.$message.error('链接地址不能为空')
                            return
                        }
                        this.newUrlButton=true;
                        this.$message.info({
                            title: '消息',
                            message: '正在更新信息'
                        });

                        this.$http.post('/admin/friends/'+this.type,{
                            friend:this.friend
                        }).then(function (data) {
                            if(data.body.result){
                                this.$message({
                                    title: '成功',
                                    message: '更新信息',
                                    type:"success"
                                });
                                this.newUrlVisitable=false
                                this.init()
                            }else{
                                this.$message.error({
                                    title: '失败',
                                    message: data.body.msg,
                                });
                            }
                            this.newUrlButton=false;
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
                            this.newUrlButton=false;

                        })


            },
            handleAdd(){
                this.type='add'
                this.newUrlVisitable = true
                this.title= '新增链接'
                this.friend={
                    name:'',
                    url:'',
                    top:0
                }
            },
            handleEdit(index,row){
                this.type='edit'
                this.newUrlVisitable = true
                this.title= '编辑链接'
                this.friend={
                    id:row.id,
                    name:row.name,
                    url:row.url,
                    top:row.top
                }
            },
            handleDelete(index,row){
                this.$confirm('永久删除该链接,是否继续', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    this.$http.post('/admin/friends/delete',{
                        id:row.id,
                    }).then(function (data) {
                        if(data.body.result){
                            this.$message.success('删除成功')
                            this.init()
                        }else{
                            this.$message.error('删除失败:'+data.body.msg)
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