<template>
    <div  v-loading="loading1"
          element-loading-text="加载中">
        <div class="grayRow">
            <el-row>

                <el-col :span="3">
                    <el-input-number  style='width:100%' v-model="number"  :min="1" ></el-input-number>
                </el-col>

                <el-select v-model="type" placeholder="请选择统计单位">
                    <el-option
                            v-for="item in options"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                    </el-option>
                </el-select>
                <span>截至至</span>
                <el-date-picker
                        v-model="falseDate"
                        :type="dateType"
                        placeholder="默认为今日"
                        @change="handleChange">
                </el-date-picker>
                <el-button @click="init()">查询</el-button>

            </el-row>
        </div>
        <div id="ete" style="width:100%;height:700px;margin: 50px auto"></div>

    </div>

</template>
<style scoped>
    .grayRow{
        padding: 7px;
        background:#f2f2f2 ;
        margin: 10px 0;
    }
</style>
<script>
    import echarts from 'echarts'

    export default {
        props: ['power'],
        data() {
            return {
                falseDate:'',//只用来显示 实际提交的是toDate
                loading1:false,
                myChart:'',
                type:0,
                number:7,
                toDate:'',
                dateType:'date',

                options:[
                    {
                        value:0,
                        label:'日'
                    },
                    {
                        value:1,
                        label:'月'
                    },
                    {
                        value:2,
                        label:'年'
                    },
                ]

            }
        },
        mounted(){
            // 基于准备好的dom，初始化echarts实例
            this.myChart = echarts.init(document.getElementById('ete'));
          //  this.test();
            this.init()


        },
        filters:{

        },

        methods: {
            handleChange(val){
              this.toDate=val;
              var a = Date.parse(this.toDate);
              console.log(a/1000)
            },
            dateTypeToCn(){
              if(this.type==0)
                  return '日';
              if(this.type==1)
                  return '月';
              if(this.type==2)
                  return '年'
            },
            init(){
                this.loading1=true
                this.$http.post('/visit',{
                    number:this.number,
                    toDate:this.toDate==''?'':Date.parse(this.toDate)/1000,
                    type:this.type

                }).then(function (data) {
                    if(data.body.result){
                        var xAxis=[];
                        var visit=[];
                        var login=[];

                        for(var key in data.body.visit){
                            xAxis.push(key)
                            visit.push(data.body.visit[key])
                        }
                        for(var key in data.body.login){
                            login.push(data.body.login[key])
                        }
                        this.myChart.setOption({
                            title: { text: '访问统计 '+ this.toDate+'前'+this.number+this.dateTypeToCn()},
                            tooltip: {trigger: 'axis'},
                            xAxis: {
                                data: xAxis
                            },
                            legend: {
                                data:['访问次数','登录次数']

                            },
                            yAxis: {},
                            series: [
                                {
                                    name: '访问次数',
                                    type: 'line',
                                    data: visit
                                },
                                {
                                    name: '登录次数',
                                    type: 'line',
                                    data: login
                                },

                            ]
                        },true);
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
            test(){
                this.myChart.setOption({
                    title: { text: 'ECharts 入门示例' },
                    tooltip: {},
                    xAxis: {
                        data: ["衬衫","羊毛衫","雪纺衫","裤子","高跟鞋","袜子"]
                    },
                    yAxis: {},
                    series: [{
                        name: '销量',
                        type: 'bar',
                        data: [5, 20, 36, 10, 10, 20]
                    }]
                });

            },

        },
        watch:{
            type:function () {
                if(this.type==0){
                    this.dateType='date'
                }else if(this.type==1){
                    this.dateType='month'
                }else if(this.type==2) {
                    this.dateType = 'year'
                }
            },
            toDate:function () {
                console.log(this.toDate)
            }
        }
    }
</script>