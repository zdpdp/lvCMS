<template>

    <div style="padding: 20px" v-loading="loading1"   element-loading-text="加载中">

            <el-popover
                    ref="selectDraft"
                    placement="left"
                    width="400"
                    trigger="click">

                <el-select style="width: 100%" v-model="draftId" placeholder="请选择">
                    <el-option
                            v-for="item in drafts"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                        <span style="float: left">{{ item.label }}</span>
                        <span style="float: right; color: #8492a6; font-size: 13px">{{ item.time }}</span>
                    </el-option>
                </el-select>
            </el-popover>
            <el-card class="box-card">

                    <div slot="header" v-show="!end" class="clearfix">
                        <span style="line-height: 36px;font-size: 25px;font-weight: 500"><a class="textInfo" title="收起/展开"><i @click="showDetail=!showDetail" class="el-icon-caret-top"></i></a> 写文章</span>
                        <div style="float: right;">

                            <el-button v-if="power.indexOf('editArticle')>0" v-popover:selectDraft type="primary">从草稿加载</el-button>
                            <el-button  v-if="power.indexOf('publicArticle')>0" @click="submit(false)" type="primary">保存为草稿</el-button>
                            <el-button   v-if="power.indexOf('publicArticle')>0" @click="submit(true)"  type="primary">发布</el-button>
                        </div>

                    </div>

                    <div class="text item" v-show="!end">
                        <el-row type="flex" v-show="showDetail">
                            <el-col :span="10">
                                <div class=" ">

                                    <el-form :model="article"  label-width="80px">
                                        <el-form-item label="文章标题">
                                            <el-input style="width: 100%" v-model="article.name"></el-input>
                                        </el-form-item>
                                        <el-form-item label="文章类别">
                                            <el-cascader
                                                    v-model="article.class"
                                                    style="width: 100%"
                                                    expand-trigger="hover"
                                                    :options="classOptions"
                                                    filterable
                                                    change-on-select>
                                            </el-cascader>
                                        </el-form-item>
                                        <el-form-item label="原创">
                                            <el-row>
                                                <el-col :span="4">
                                                    <el-switch
                                                            v-model="article.original"
                                                            on-color="#13ce66"
                                                            off-color="#ff4949"
                                                            on-text="是"
                                                            off-text="否"
                                                            :on-value="1"
                                                            :off-value="0"
                                                    >

                                                    </el-switch>
                                                </el-col>
                                                <el-col v-if="!article.original" :span="20">
                                                    <el-input v-model='article.source' placeholder="文章来源"></el-input>
                                                </el-col>
                                            </el-row>


                                        </el-form-item>

                                        <el-form-item label="附件" v-if="power.indexOf('postAttachMent')>0">
                                            <el-upload
                                                    class="upload-demo"
                                                    action="/admin/addArticle/attach"
                                                    :with-credentials="true"
                                                    :before-upload="handleBefore"
                                                    :on-success="handleSuccess"
                                                    :on-remove="handleRemove"
                                                    :file-list="fileList"
                                                    show-file-list>
                                                <el-button size="small" type="primary">点击上传</el-button>
                                                <div slot="tip" class="el-upload__tip">单个文件不能超过10MB</div>
                                            </el-upload>
                                            <!--  <el-button @click="test">测试</el-button> -->

                                        </el-form-item>
                                    </el-form>
                                </div>
                            </el-col>

                            <el-col :span="10" :offset="4">
                                <div   class="avatar-uploader">
                                    <el-upload

                                            action="/qq"
                                            :show-file-list="false"
                                            :auto-upload="false"
                                            name="thumbnail"
                                            :with-credentials="true"
                                            accept="image/jpg,image/png"
                                            :on-change="thumbnailChange">
                                        <img class='avatar' v-if='thumbnail' :src="thumbnail" alt="缩略图">
                                        <i  v-else class="  el-icon-plus avatar-uploader-icon">缩略图</i>

                                    </el-upload>

                                </div>
                            </el-col>
                        </el-row>
                        <script id="container" name="content" type="text/plain">
                        </script>
                    </div>

                <div v-show="end" style="height: 400px">
                    <div style="margin-top:100px;text-align: center">
                        <div style="margin-bottom: 20px"><img src="http://img.baidu.com/hi/jx2/j_0072.gif"/></div>
                        <span style="font-size: 40px;font-weight: 300">{{msg}}</span>
                        <div style="margin-top:50px">
                            <el-button v-if="power.indexOf('AddArticlePage')>0" size="large" @click="reset()"  type="info" >继续添加</el-button>
                            <el-button v-if="power.indexOf('editArticle')>0" size="large" @click="end=false"  type='success'  >重新编辑</el-button>
                            <el-button size="large"   type="primary">查看文章</el-button>
                        </div>
                    </div>


                </div>
            </el-card>





    </div>
</template>
<style scoped>
    .textInfo :hover{
        cursor: pointer;
    }
    .avatar-uploader {
        border: 1px dashed #aaaaaa;
        border-radius: 6px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        float:right;
    }
    .avatar-uploader .el-upload:hover {
        border-color: #20a0ff;
    }
    .avatar-uploader-icon {
        font-size: 28px;
        color: #8c939d;
        width: 200px;
        height: 200px;
        line-height: 200px;
        text-align: center;
    }
    .avatar {
        width: 200px;
        height: 200px;
        display: block;
    }
    .thumb{
        float:right;
        margin: 10px;
        margin-top:0 ;
        border-radius: 10px;
        width: 40%;
        height: 50%;
    }
    .left{
        display: inline-block;
        width: 70%;
    }
    .rightPic{
        width: 40%;
        float: right;
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
        width: 100%;
    }
</style>
<script>
    export default{
        props: ['power'],
        data(){
            return {
                loading1:false,
                msg:'',
                end:false,
                showDetail:true,
                draftId:'',
                drafts:'',
                fileList: [
                    //用来保存缓存数据和二次编辑的附件信息
//                    {name: 'food.jpeg', url: 'https://fuss10.elemecdn.com/3/63/4e7f3a15429bfda99bce42a18cdd1jpeg.jpeg?imageMogr2/thumbnail/360x360/format/webp/quality/100'},
//                    {name: 'food2.jpeg', url: 'https://fuss10.elemecdn.com/3/63/4e7f3a15429bfda99bce42a18cdd1jpeg.jpeg?imageMogr2/thumbnail/360x360/format/webp/quality/100'}
                    ],
                thumbnail:'',
                ue:'',
                list:[],
                article:{
                    name:"",
                    class:[],
                    content:"",
                    original:1,
                    source:'',
                    draft:0,
                },
                class:'',
                classOptions:[],
                listChangeFlag:0,
                thumbnailChangeFlag:0,
                editId:'',

            }
        },
        mounted(){
            if(!this.ue){

                this.ue = UE.getEditor('container',{
                    initialFrameHeight:900 ,initialFrameWidth:'100%',
                    autoHeight: false,
                    toolbars: [
                        [   'source', //源代码
                            'preview', //预览
                            'insertcode', //代码语言
                            'fontfamily', //字体
                            'fontsize', //字号
                            'paragraph', //段落格式
                            'customstyle', //自定义标题
                            'inserttable', //插入表格
                            'insertrow', //前插入行
                            'insertcol', //前插入列
                            'mergeright', //右合并单元格
                            'mergedown', //下合并单元格
                            'deleterow', //删除行
                            'deletecol', //删除列
                            'splittorows', //拆分成行
                            'splittocols', //拆分成列
                            'splittocells', //完全拆分单元格
                            'deletecaption', //删除表格标题
                            'inserttitle', //插入标题
                            'mergecells', //合并多个单元格
                            'deletetable', //删除表格
                            'edittd', //单元格属性
                            'edittable', //表格属性
                            'fullscreen', //全屏
                        ],
                        [
                            'undo', //撤销
                            'redo', //重做
                            'bold', //加粗
                            'italic', //斜体
                            'underline', //下划线
                            'strikethrough', //删除线
                            'subscript', //下标
                            'fontborder', //字符边框
                            'superscript', //上标
                            'formatmatch', //格式刷
                            'blockquote', //引用
                            'justifyleft', //居左对齐
                            'justifyright', //居右对齐
                            'justifycenter', //居中对齐
                            'justifyjustify', //两端对齐
                            'insertorderedlist', //有序列表
                            'insertunorderedlist', //无序列表
                            'forecolor', //字体颜色
                            'backcolor', //背景色
                            'background', //背景
                            'simpleupload', //单图上传
                            'insertimage', //多图上传
                            'link', //超链接
                            'unlink', //取消链接
                        ],
                        [

                            // 'anchor', //锚点


                            // 'indent', //首行缩进
                            'snapscreen', //截图


                            'pasteplain', //纯文本粘贴模式
                            //'selectall', //全选
                            //'print', //打印

                            'horizontal', //分隔线
                            'removeformat', //清除格式
                            'time', //时间
                            'date', //日期


                            'cleardoc', //清空文档
                            'insertparagraphbeforetable', //"表格前插入行"


                            'emotion', //表情
                            //'spechars', //特殊字符
                            //'searchreplace', //查询替换
                            //'map', //Baidu地图
                            //'gmap', //Google地图
                            //'insertvideo', //视频
                            //'help', //帮助



                            //'directionalityltr', //从左向右输入
                            //'directionalityrtl', //从右向左输入
                            'rowspacingtop', //段前距
                            'rowspacingbottom', //段后距
                            //'pagebreak', //分页
                            // 'insertframe', //插入Iframe
                            'imagenone', //默认
                            'imageleft', //左浮动
                            'imageright', //右浮动
                            'attachment', //附件
                            'imagecenter', //居中
                            //'wordimage', //图片转存
                            'lineheight', //行间距
                            //'edittip ', //编辑提示

                            //'autotypeset', //自动排版
                            //  'webapp', //百度应用
                            //'touppercase', //字母大写
                            //'tolowercase', //字母小写

                            //'template', //模板
                            //'scrawl', //涂鸦
                            //  'music', //音乐

                            //'drafts', // 从草稿箱加载
                            //'charts', // 图表
                        ]
                    ]
                })



            }

            this.init()
            if(this.$route.query.articleId){
                this.editId = this.$route.query.articleId
            }

        },
        destroyed() {
            this.ue.destroy();
            this.ue ='';
            console.log('毁灭')
        },
        methods:{
            reset(){
                this.end = false
                this.draftId = ''
                this.drafts = ''
                this.fileList = []
                this.thumbnail = ''
                this.list = [],
                this.article = {
                    name:"",
                    class:[],
                    content:"",
                    original:1,
                    source:'',
                    draft:0,
                }
                this.class = ''
                this.listChangeFlag =0
                this.thumbnailChangeFlag =0
                this.editId =''
                this.ue.setContent('');

                this.init()
            },
            test(){
                console.log(this.list)

            },
            handleBefore(file){
                if(file.size>10*1024*1024){
                    this.$message.error('单个文件大于10MB，不允许上传');
                    return false
                }
                return true


            },
            thumbnailChange(){
                var p =$("input[name='thumbnail']").get(0)

                var size = p.files[0].size

                var type = p.files[0].type


                if(!/image\/\w+/.test(type)){
                    this.$message.error('只能上传图片');
                    return;
                }

                if(size>5*1024*1024){
                    this.$message.error('图片最大为5M');
                    return
                }


                var reader = new FileReader();
                reader.readAsDataURL(p.files[0]);
                var x = this
                reader.onload =function(e){
                    x.thumbnail = e.target.result
                };
                this.thumbnailChangeFlag=1
            },
            init(){
                this.loading1=true
                this.$http.post('addArticle',{

                }).then(function (data) {
                    if(data.body.result){
                        this.$message.success('获取信息成功')
                        this.classOptions = data.body.classOptions
                        this.drafts = data.body.drafts
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
            handleSuccess(response, file, fileList){
                if(!response.result){

                    var l = fileList.length;
                    fileList.length--
                    delete fileList[l]
                    this.$message.error(response.msg)
                }else if(response.result){
                    this.list.push({
                        name:file.name,
                        url:response.file
                    })
                    this.listChangeFlag = 1

                }else {
                    this.$message.error('本地 ERRO1')
                }

            },
            handleRemove(file, fileList){

                console.log(file)
                for(var x in this.list)
                {
                    console.log(x)
                    if(this.list[x].name==file.name){
                        this.list.splice(x,1)
                        this.listChangeFlag = 1
                        break
                    }
                }
            },
            submit(fomal){
                //formal 是否正式发布 true or false
                if(this.article.name.trim().length<1){
                    this.$message.error('请填写文章标题');
                    return
                }
                if(fomal){
                    this.article.draft = 0
                }else{
                    this.article.draft = 1
                }
                this.class = this.article.class[this.article.class.length-1]
                this.article.content = this.ue.getContent();
                var url = '/admin/addArticle/public'
                if(this.editId){
                    url = '/admin/addArticle/edit'
                }
                this.$message.info('正在提交信息');
                this.loading1=true
                this.$http.post(url,{
                    editId:this.editId,
                    article:this.article,
                    class:this.class,
                    thumbnail:this.thumbnailChangeFlag==1?this.thumbnail:'',
                    list:this.listChangeFlag==1?this.list:''

                }).then(function (data) {
                    if(data.body.result){
                        this.$message.success('发布文章成功');
                        this.end = true
                        this.msg = data.body.msg
                    }else{
                        this.$message.success('发布文章失败:'+data.body.msg);
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
            getEditInfo(){


                this.loading1=true
                this.$http.get('/admin/addArticle/edit',{
                    params:{articleId:this.editId}

                }).then(function (data) {
                    if(data.body.result){
                        this.$message.success('获取信息成功')
                        var msg = data.body.editArticleInfo
                        this.article.name = msg.title
                        this.article.class = msg.classId

                        this.article.original = msg.original
                        this.article.source = msg.source
                        this.article.draft = msg.state==2?1:0
                        this.thumbnail = msg.thumbnail

                        this.fileList=data.body.list
                        this.list = data.body.list


                        this.ue.ready(function() {
                            // editor准备好之后才可以使用
                            this.setContent(data.body.editArticleInfo.content);
                        });









                    }else{
                        this.$message.error('失败:'+data.body.msg)
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
                        console.log(response)
                        this.$message.error('错误：状态码'+response.status);
                    }
                    this.loading1=false

                })
            }
        },
        watch:{
            $route:function () {
                if(this.$route.query.articleId){
                    this.editId = this.$route.query.articleId
                }
            },
            draftId:function () {
                if(this.draftId){
                    var href = location.href
                    var  p = href.indexOf('?')
                    if(p>0){
                        location.href = href.substring(0,p) +"?articleId=" + this.draftId
                    }else{
                        location.href = href +"?articleId=" + this.draftId
                    }

                   //
                }
            },
            editId:function(){
                if(this.editId){

                    this.getEditInfo()
                }
            },
        }
    }

</script>