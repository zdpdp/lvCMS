<template>
    <div    v-loading="loading1"
            element-loading-text="加载中">
        <div class="grayRow">


            <el-row class="searchRow">
                <el-col :span="2">
                    <el-select size="small" v-model="searchClass" placeholder="按类别搜索">
                        <el-option
                                v-for="item in classOptions"
                                :key="item.id"
                                :label="item.className"
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
                    <el-input placeholder="搜索标题，作者" size="small" v-model="searchInfo">

                    </el-input>
                </el-col>
                <el-button size="small" style="margin-left:10px" type="primary" @click="init()" icon="search">查询</el-button>
                <el-button type="primary" size="small" icon="loading" @click="refresh()">重置</el-button>

            </el-row>

        </div>
        <el-table
                @selection-change="handleSelect"
                :data="articles"
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
                    label="标题"
                    width="260"
                    sortable>
            </el-table-column>
            <el-table-column
                    prop="author"
                    label="作者"
                    width="150"
                    sortable>
            </el-table-column>
            <el-table-column
                    prop="className"
                    label="类别"
                    width="120"
                    sortable>
            </el-table-column>
            <el-table-column
                    prop="clickNum"
                    label="阅读量"
                    width="140 "
                    sortable
            >
            </el-table-column>
            <el-table-column
                    prop="created_at"
                    label="创建时间"
                    width="180"
                    sortable >
            </el-table-column>
            <el-table-column
                    prop="updated_at"
                    label="最后编辑"
                    width="180"
                    sortable >
            </el-table-column>
            <el-table-column
                    label="状态"
                    width="110"

            >
                <template scope="scope">
                    <el-tag :type="scope.row.state|stateTag">{{scope.row.state|stateToWord}}</el-tag>
                </template>
            </el-table-column>


            <el-table-column label="操作"   >
                <template scope="scope">
                    <a  v-if="power.indexOf('editArticle')>0" :href="'/admin#/addArticle?articleId='+scope.row.id" title="编辑"><i style="color: #00a0e9" class="hand el-icon-edit"></i></a>
                    <a   :href="'/article/'+scope.row.id" target="_blank" title="查看文章"><i style="color:black" class="hand fa fa-file-text"></i></a>
                    <a   v-if="power.indexOf('upArticle')>0&&scope.row.state==1" title="置顶"><i style="color: red" @click="handleUp(scope.$index, scope.row)" class="hand fa fa-arrow-up"></i></a>
                    <a   v-if="power.indexOf('downArticle')>0&&scope.row.state==0" title="取消置顶"><i style="color: red" @click="handleDown(scope.$index, scope.row)" class="hand fa fa-arrow-down"></i></a>
                    <a   v-if="power.indexOf('deleteArticle')>0" title="删除"><i style="color: red" @click="handleDelete(scope.$index, scope.row)" class="hand el-icon-delete2"></i></a>
                    <a v-if="power.indexOf('backArticleFromBin')>0&&scope.row.state==3" title="从回收站中还原成草稿"><i style='color: #00ab00' @click="handleBack(scope.$index, scope.row)" class="hand fa fa-backward"></i></a>
                    <a v-if="power.indexOf('addArticleToBin')>0&&scope.row.state!=3" title="加入回收站"><i style="color: orange"  @click="handleToCycle(scope.$index, scope.row)" class="hand el-icon-circle-close"></i></a>

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



        <!--嵌套框 状态选择框--开始-->
        <el-dialog size="tiny" title="修改状态" :visible.sync="stateOptionsVisible" >
            <el-form>
                <el-row>
                    <el-col :span="14">
                        <el-form-item label="文章状态"  :label-width="formLabelWidth" >
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
                <el-button type="primary"  @click="batchChange()">确 定</el-button>
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
            stateTag: function (val) {
                if(val==0)
                    return "primary";
                else if(val==1)
                    return "success";
                else if(val==2)
                    return 'warning';
                else if(val==3)
                    return "danger";
            },
            stateToWord: function (val) {
                if(val==0)
                    return "置顶";
                else if(val==1)
                    return "正常";
                else if(val==2)
                    return '草稿';
                else if(val==3)
                    return "回收站";
            }
        },
        data() {
            return {
                stateOptionsVisible:false,
                formLabelWidth:'120px',
                batchChangeState:'',
                selectItem:[],
                actionOptions:[{
                    value:1,
                    label:"批量删除"
                },{
                    value:2,
                    label:"批量改变状态"
                }],
                action:'',
                stateOptions:[{
                    value:0,
                    label:"置顶"
                },{
                    value:1,
                    label:"正常"
                },{
                    value:2,
                    label:'草稿'
                },{
                    value:3,
                    label:'回收站'
                }],
                classOptions:[{

                }],
                searchClass:'',
                searchState:'',
                loading1:false,
                articles:[],
                select:"",
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
                this.$confirm('此操作将永久删除这些文章, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    this.$http.post('/admin/allArticle/batchDelete',{
                        keyArr:arr
                    }).then(function (data) {
                        if(data.body.result){
                            this.$message({
                                title: '成功',
                                message: '批量删除文章成功',
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

                });

            },
            batchChange(){
                var keyArr = [];
                for(var x of this.selectItem){
                    keyArr.push(x.id)
                }
                this.$http.post('/admin/allArticle/batchChange',{
                    keyArr:keyArr,
                    state:this.batchChangeState,
                }).then(function (data) {
                    if(data.body.result){
                        this.$message({
                            title: '成功',
                            message: '批量修改文章状态成功',
                            type:"success"
                        });
                        this.stateOptionsVisible=false;
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
                if(this.action==2){
                   this.stateOptionsVisible=true;

                }
            },

            refresh(){
                Object.assign(this.$data, this.$options.data())
                this.init()
            },
            init(){
                this.loading1=true
                this.$http.post('/allArticle',{

                    page:this.page,
                    pageSize:this.pageSize,
                    searchInfo:this.searchInfo,
                    searchClass:this.searchClass,
                    searchState:this.searchState


                }).then(function (data) {
                    if(data.body.result){
                        this.classOptions = data.body.class
                        this.articles=data.body.articles
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
            handleEdit(index, row) {
                this.editUserVisible=true
                this.editUser.account = row.account
                this.editUser.name=row.name
                this.editUser.state=row.state
                this.editUser.role=row.role_id
                this.editUser.id = row.id
                console.log(index, row);
            },
            handleBack(index,row){
                this.$confirm('将该文章还原成草稿，您可以重新编辑并发布, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    this.$http.post('/admin/allArticle/back',{
                        articleId:row.id
                    }).then(function (data) {
                        if(data.body.result){
                            this.$message({
                                message: '还原成功',
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
            handleToCycle(index,row){
                this.$confirm('将该文章放入回收站，您可以恢复此操作, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    this.$http.post('/admin/allArticle/recycleBin',{
                        articleId:row.id
                    }).then(function (data) {
                        if(data.body.result){
                            this.$message({
                                message: '放入回收站成功',
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
            handleUp(index,row){
                if(!row.thumbnail){
                    this.$message.error('该文章没有缩略图，无法置顶');
                    return;
                }
                this.$confirm('将该文章置顶, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    this.$http.post('/admin/allArticle/up',{
                        articleId:row.id
                    }).then(function (data) {
                        if(data.body.result){
                            this.$message({
                                message: '置顶成功',
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
            handleDown(index,row){
                this.$confirm('将该文章取消置顶, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    this.$http.post('/admin/allArticle/down',{
                        articleId:row.id
                    }).then(function (data) {
                        if(data.body.result){
                            this.$message({
                                message: '取消置顶成功',
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
            handleDelete(index, row) {
                this.$confirm('此操作将永久删除该文章, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    this.$http.post('/admin/allArticle/delete',{
                        articleId:row.id
                    }).then(function (data) {
                        if(data.body.result){
                            this.$message({
                                message: '删除文章成功',
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
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: '已取消删除'
                    });
                });
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