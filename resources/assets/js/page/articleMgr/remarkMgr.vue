<template>
    <div    v-loading="loading1"
            element-loading-text="加载中">

        <div class="grayRow">


            <el-row class="searchRow">
                <el-col :span="5">
                    <el-input placeholder="请输入搜索内容" v-model="searchInfo">
                        <el-select style="width: 100px" v-model="type" slot="prepend" placeholder="请选择">
                            <el-option label="评论内容" value="1"></el-option>
                            <el-option label="文章标题" value="2"></el-option>
                            <el-option label="评论作者" value="3"></el-option>
                            <el-option label="评论层级" value="4"></el-option>
                        </el-select>
                        <el-button  @click='init' slot="append" icon="search"></el-button>
                    </el-input>

                </el-col>

                <el-button style="float: right" type="primary" icon="loading" @click="refresh()">刷新</el-button>


            </el-row>

        </div>
        <el-table
                @selection-change="handleSelect"
                :data="remarks"
                style="width: 100%"
                stripe>
            <el-table-column
                    type="selection"
                    width="55">
            </el-table-column>

            <el-table-column
                    type="index"
                    label="#"
                    width="55"
                    sortable>
            </el-table-column>
            <el-table-column
                    prop="title"
                    label="作者"
                    width="200"
                    >
                <template scope="scope">
                    <el-tag v-if="scope.row.name" type="primary">{{scope.row.name}}</el-tag>
                    <el-tag v-else :type="scope.row.tempName|tempNameTag">{{scope.row.tempName?scope.row.tempName:'游客'}}</el-tag>

                </template>
            </el-table-column>
            <el-table-column
                    prop="content"
                    label="内容"
                    width="300"
                    sortable>
            </el-table-column>
            <el-table-column
                    prop="grade"
                    label="层级"
                    width="100"
                    sortable>
            </el-table-column>
            <el-table-column
                    prop="title"
                    label="回复至文章"
                    width="250 "
                    sortable
            >
            </el-table-column>
            <el-table-column
                    prop="created_at"
                    label="提交于"
                    width="180"
                    sortable >
            </el-table-column>

            <el-table-column label="操作"   >
                <template scope="scope">
                    <a   v-if="power.indexOf('editRemark')>0" title="编辑"><i style="color: #7a7b0b" @click="handleEdit(scope.$index, scope.row)" class="hand el-icon-edit"></i></a>
                    <a   v-if="power.indexOf('replyRemark')>0" title="回复"><i style="color: #3bb1ff" @click="handleReply(scope.$index, scope.row)" class="hand fa fa-mail-reply"></i></a>
                    <a   :href="'/article/'+scope.row.articleId" target="_blank" title="查看文章"><i style="color:black" class="hand fa fa-file-text"></i></a>
                    <a v-if="power.indexOf('deleteRemark')>0" title="删除"><i style="color: red"  @click="handleDelete(scope.$index, scope.row)" class="hand el-icon-delete"></i></a>

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
                    style="float:right"
                    @size-change="handleSizeChange"
                    @current-change="handleCurrentChange"
                    :current-page="page"
                    :page-sizes="[25,100, 200, 300, 400]"
                    :page-size="pageSize"
                    layout="total, sizes, prev, pager, next, jumper"
                    :total="total">
            </el-pagination>
        </div>

    </div>


</template>
<script>
    export default {
        props: ['power'],
        mounted(){
            this.init()

        },
        filters:{
            stateTag: function (val) {
                if(val==1)
                    return "primary";
                else if(val==2)
                    return 'warning';
                else if(val==3)
                    return "danger";
            },
            stateToWord: function (val) {
                if(val==1)
                    return "正常";
                else if(val==2)
                    return "回收站";
            },
            tempNameTag:function (val) {
                if(val)
                    return 'warning'
                else
                    return 'danger'

            }
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
                remarks:[],
                type:'',
                total:1,
                page:1,
                pageSize:25,
                searchInfo:'',

            }
        },
        methods: {
            handleSelect(selection){
                this.selectItem = selection
            },
            batchDelete(arr){
                this.$http.post('/admin/remark/batchDelete',{
                    keyArr:arr
                }).then(function (data) {
                    if(data.body.result){
                        this.$message({
                            title: '成功',
                            message: '批量删除评论成功',
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
                if(this.action==1){
                    this.batchDelete(keyArr);
                }
            },
            refresh(){
                Object.assign(this.$data, this.$options.data())
                this.init()
            },
            init(){
                this.loading1=true
                this.$http.post('/remark',{
                    type:this.type?this.type:0,
                    page:this.page,
                    pageSize:this.pageSize,
                    searchInfo:this.searchInfo

                }).then(function (data) {
                    if(data.body.result){
                        this.remarks=data.body.remark
                        this.total=data.body.total
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
                })
            },
            handleReply(index, row) {
                this.$prompt('回复评论', '提示', {
                    confirmButtonText: '提交',
                    cancelButtonText: '取消',
                }).then(({ value }) => {
                    if(value.length<1){
                        alert("评论不能为空")
                        return;
                    }
                    this.$http.post('/admin/remark/reply',{
                        id:row.id,
                        content:value,
                    }).then(function (data) {
                        if(data.body.result){
                            this.$message({
                                title: '成功',
                                message: '获取信息成功',
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
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: '取消回复'
                    });
                });
            },
            handleEdit(index, row) {
                this.$prompt('编辑评论信息', '提示', {
                    confirmButtonText: '提交',
                    cancelButtonText: '取消',
                    inputValue:row.content,
                }).then(({ value }) => {
                    if(value.length<1){
                       alert("评论不能为空")
                        return;
                    }
                    this.$http.post('/admin/remark/edit',{
                        id:row.id,
                        content:value,
                    }).then(function (data) {
                        if(data.body.result){
                            this.$message({
                                title: '成功',
                                message: '获取信息成功',
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
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: '取消编辑'
                    });
                });
            },

            handleDelete(index,row){
                this.$confirm('删除该评论与其附属评论，该操作无法恢复, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'error'
                }).then(() => {
                    this.$http.post('/admin/remark/delete',{
                        id:row.id
                    }).then(function (data) {
                        if(data.body.result){
                            this.$message({
                                message: '删除成功',
                                type:"success"
                            });
                            this.init()
                        }else{
                            this.$message.error({
                                title: '失败',
                                message: data.body.msg,
                            });

                        }
                    })
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

        },
        watch:{
            pageSize:'init',
            page:'init'
        }
    }
</script>
<style>
    .hand{
        cursor: pointer;
        margin-right:2px;
    }
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