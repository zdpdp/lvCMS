<template>
    <div  element-loading-text="加载中"
          v-loading="loading1">
        <div class="grayRow">

            <el-button  v-if="power.indexOf('addArticleClass')>0" size="small" style="margin-left:10px" type="primary" @click="addClass" icon="plus">添加一级类别</el-button>
            <el-button type="primary" size="small" icon="loading" @click="refresh()">刷新</el-button>
        </div>
        <el-table

                border
                :data="classInfo"
                style="width: 100%"
                :default-expand-all="true"
                row-key="id">
            <el-table-column  type="expand" >
                <template scope="props" >
                    <el-table

                            :data="props.row.child"
                            border
                            style="width: 100%"
                            :show-header="false"
                    >
                        <el-table-column
                                prop="className"
                                width="180">
                        </el-table-column>
                        <el-table-column
                                width="180"
                                prop="sum"
                        >
                        </el-table-column>
                        <el-table-column
                                label="评论开放"
                                width="180"
                        >
                            <template scope="scope">
                                <el-tag v-if='scope.row.remarkable==1' type="primary">完全开放</el-tag>
                                <el-tag v-if='scope.row.remarkable==2' type="danger">完全禁止</el-tag>
                                <el-tag v-if='scope.row.remarkable==3' type="success">登录后允许</el-tag>


                            </template>
                        </el-table-column>
                        <el-table-column
                                label="浏览开放"
                                width="180"
                        >
                            <template scope="scope">
                                <el-tag v-if='scope.row.visitable==1' type="primary">完全开放</el-tag>
                                <el-tag v-if='scope.row.visitable==2' type="danger">完全禁止</el-tag>
                                <el-tag v-if='scope.row.visitable==3' type="success">登录后允许</el-tag>
                            </template>
                        </el-table-column>
                        <el-table-column
                                label="下载附件"
                                width="180"
                        >
                            <template scope="scope">
                                <el-tag v-if='scope.row.downloadable==1' type="primary">完全开放</el-tag>
                                <el-tag v-if='scope.row.downloadable==2' type="danger">完全禁止</el-tag>
                                <el-tag v-if='scope.row.downloadable==3' type="success">登录后允许</el-tag>
                            </template>
                        </el-table-column>
                        <el-table-column label="操作">
                            <template scope="scope">
                                <el-button  v-if="power.indexOf('editArticleClass')>0"
                                        size="small"
                                        @click="handleEdit(scope.$index, scope.row)">编辑</el-button>

                                <el-button  v-if="power.indexOf('deleteArticleClass')>0"
                                        size="small"
                                        type="danger"
                                        @click="deleteClass(scope.$index, scope.row)">删除</el-button>
                            </template>
                        </el-table-column>
                    </el-table>
                </template>
            </el-table-column>
            <el-table-column
                    label="类别名"
                    width="180"
                    prop="className"
            >
            </el-table-column>
            <el-table-column
                    label="文章数"
                    width="180"
                    prop="sum"
            >
            </el-table-column>
            <el-table-column
                    label="评论开放"
                    width="180"
            >
                <template scope="scope">
                    <el-tag v-if='scope.row.remarkable==1' type="primary">完全开放</el-tag>
                    <el-tag v-if='scope.row.remarkable==2' type="danger">完全禁止</el-tag>
                    <el-tag v-if='scope.row.remarkable==3' type="success">登录后允许</el-tag>


                </template>
            </el-table-column>
            <el-table-column
                    label="浏览开放"
                    width="180"
            >
                <template scope="scope">
                    <el-tag v-if='scope.row.visitable==1' type="primary">完全开放</el-tag>
                    <el-tag v-if='scope.row.visitable==2' type="danger">完全禁止</el-tag>
                    <el-tag v-if='scope.row.visitable==3' type="success">登录后允许</el-tag>
                </template>
            </el-table-column>
            <el-table-column
                    label="下载附件"
                    width="180"
            >
                <template scope="scope">
                    <el-tag v-if='scope.row.downloadable==1' type="primary">完全开放</el-tag>
                    <el-tag v-if='scope.row.downloadable==2' type="danger">完全禁止</el-tag>
                    <el-tag v-if='scope.row.downloadable==3' type="success">登录后允许</el-tag>
                </template>
            </el-table-column>
            <el-table-column label="操作">
                <template scope="scope">
                    <el-button v-if="power.indexOf('editArticleClass')>0"
                            size="small"
                            @click="handleEdit(scope.$index, scope.row)">编辑</el-button>
                    <el-button v-if="power.indexOf('addArticleClass')>0"
                            size="small"
                            type="info"
                            @click="addChildClass(scope.$index, scope.row)">添加</el-button>
                    <el-button v-if="power.indexOf('deleteArticleClass')>0"
                            size="small"
                            type="danger"
                            @click="deleteClass(scope.$index, scope.row)">删除</el-button>
                </template>
            </el-table-column>
        </el-table>

        <!-- 编辑类别 -->
        <el-dialog
                :title="editClassNameShow"
                :visible.sync="dialogVisible"
                size="tiny"
                >
            <el-form label-width="120px"  label-position="left">
                <el-form-item label="类别名">
                    <el-input v-model="editRow.className" placeholder="类别名不能为空"></el-input>
                </el-form-item>
                <el-form-item label="评论开放">
                    <el-select v-model="editRow.remarkable" placeholder="请选择">
                        <el-option
                                v-for="item in options"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value">
                        </el-option>
                    </el-select>

                </el-form-item>
                <el-form-item label="浏览开放">
                    <el-select v-model="editRow.visitable" placeholder="请选择">
                        <el-option
                                v-for="item in options"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value">
                        </el-option>
                    </el-select>


                </el-form-item>
                <el-form-item label="下载附件">
                    <el-select v-model="editRow.downloadable" placeholder="请选择">
                        <el-option
                                v-for="item in options"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value">
                        </el-option>
                    </el-select>


                </el-form-item>

            </el-form>

            <span slot="footer" class="dialog-footer">
            <el-button @click="dialogVisible = false">取 消</el-button>
            <el-button type="primary"  :disabled="editButton" @click="editClass()">确 定</el-button>
          </span>
        </el-dialog>

    </div>
</template>
<script>
    export default{
        props: ['power'],
        data(){
            return {
                options:[
                    {
                        value: 1,
                        label: '完全开放'
                    },
                    {
                        value: 2,
                        label: '完全禁止'
                    },
                    {
                        value: 3,
                        label: '登录后允许'
                    },
                ],
                editButton:false,
                loading1:false,
                classInfo:[],
                expands:[1],

                dialogVisible:false,
                editClassNameShow:'',
                editRow:{
                    classId:'',
                    className:'',
                    remarkable:1,
                    visitable:1,
                    downloadable:1,
                }
            }
        },
        mounted(){
            this.init()
        },

        methods:{
            refresh(){
                Object.assign(this.$data, this.$options.data())
                this.init()
            },
            init(){
                this.loading1=true
                 this.$http.post('/articleClass',{

              }).then(function (data) {
                    if(data.body.result){
                        this.$message.success('获取信息成功')
                        this.classInfo = data.body.msg
                    }else{
                        this.$message.error(data.body.msg)
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
            addClass(){

              this.$prompt('请输入一级类别名(权限默认完全开放)','提示',{
                  confirmButtonText: '确定',
                  cancelButtonText: '取消',
              }).then(({value})=>{
                  if(!value){
                      this.$message.error('类别名不能为空');
                      return
                  }
                  this.$http.post('/admin/articleClass/addClass',{
                      className:value,
                  }).then(function (data) {
                      if(data.body.result){
                          this.$message.success('添加成功')
                          this.classInfo.push(data.body.msg)
                      }else{
                          this.$message.error('添加失败')
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
              })
            },
            addChildClass(index,row){
                this.$prompt('请输入二级类别名(权限默认完全开放)','提示',{
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                }).then(({value})=>{
                    if(!value){
                        this.$message.error('类别名不能为空');
                        return
                    }
                    this.$http.post('/admin/articleClass/addClass',{
                        fatherId:row.id,
                        className:value,
                    }).then(function (data) {
                        if(data.body.result){
                            this.$message.success('添加成功')
                            row.child.push(data.body.msg)
                        }else{
                            this.$message.error('添加失败:'+data.body.msg)
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
                })
            },
            deleteClass(index,row){
                this.$confirm('永久删除该类别,子类别将成为一级类别,该类别下所有文章保留，无归属类别', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    this.$http.post('/admin/articleClass/deleteClass',{
                        classId:row.id,
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
            },
            editClass(){
              if(this.editRow.className.trim().length<2){
                  this.$message.error('类别名长度至少两个字符')
                  return
              }
              this.editButton = true
                this.$http.post('/admin/articleClass/editClass',{
                    editRow:this.editRow,
                }).then(function (data) {
                    if(data.body.result){
                        this.$message.success('修改成功')
                        this.dialogVisible=false
                        this.init()
                    }else{
                        this.$message.error('失败:'+data.body.msg)
                    }
                    this.editButton = false

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
                    this.editButton = false

                })

            },
            handleEdit(index, row) {
                this.editClassNameShow = row.className
                this.editRow.classId = row.id
                this.editRow.className = row.className
                this.editRow.remarkable = row.remarkable
                this.editRow.downloadable = row.downloadable
                this.editRow.visitable = row.visitable
                this.dialogVisible=true
            },
            handleDelete(index, row) {
                console.log(index, row);
            },
            remote(row,callback){
                setTimeout(function() {
                    callback(row.children)
                },500)
            }
        }
    }
</script>
<style scoped>
    .grayRow{
        padding: 7px;
        background:#f2f2f2 ;
        margin: 10px 0;
    }
</style>