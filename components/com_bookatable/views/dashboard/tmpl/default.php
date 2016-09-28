<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="dashboard">
    <vue-datetime-picker class="vue-picker1" name="picker1"
                         :model.sync="result1">
    </vue-datetime-picker>
    <greeting></greeting>
    <greeting></greeting>
    <greeting></greeting>

</div>
<template>
    <div>
        <input class="input" size="50" type="text" @click.stop="open($event,'picker1')" v-model="calendar.items.picker1.value" placeholder="普通日期模式，但限制了开始结束日期，使用了自定义星期标题"><br>
        <input class="input" size="50" type="text" @click.stop="open($event,'picker2')" v-model="calendar.items.picker2.value" placeholder="选择一段时间，不限制开始结束日期，间隔符号使用“.”"><br>
        <input class="input" size="50" type="text" @click.stop="open($event,'picker3')" v-model="calendar.items.picker3.value" placeholder="日期时间模式"><br>

        <input class="input" size="50" type="text" @click.stop="open($event,'picker4')" v-model="calendar.items.picker4.value" placeholder="时间模式"><br>
        <calendar
            :show.sync="calendar.show"
            :type="calendar.type"
            :value.sync="calendar.value"
            :x="calendar.x"
            :y="calendar.y"
            :begin.sync="calendar.begin"
            :end.sync="calendar.end"
            :range.sync="calendar.range"
            :weeks="calendar.weeks"
            :months="calendar.months"
            :sep="calendar.sep">

        </calendar>
    </div>
</template>

<script src="/components/com_bookatable/assets/vue.min.js"></script>
<script src="/components/com_bookatable/assets/vue-resource.min.js"></script>
<script src="/components/com_bookatable/assets/dashboard.js"></script>
<script>
    import calendar from "assets/calendar.vue"

    export default {
        components:{
            calendar
        },
        data() {
            return {
                // 数据绑定
                calendar:{
                    show:false,
                    x:0,
                    y:0,
                    picker:"",
                    type:"date",
                    value:"",
                    begin:"",
                    end:"",
                    value:"",
                    sep:"/",
                    weeks:[],
                    months:[],
                    range:false,
                    items:{
                        // 单选模式
                        picker1:{
                            type:"date",
                            begin:"2016-08-20",
                            end:"2016-08-25",
                            value:"2016-08-21",
                            sep:"-",
                            weeks:['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                            months:['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        },
                        // 2个日期模式
                        picker2:{
                            type:"date",
                            value:"",
                            range:true,
                            sep:".",
                        },
                        // 日期时间模式
                        picker3:{
                            type:"datetime",
                            value:"",
                            sep:"-",
                        },
                        // 日期时间模式
                        picker4:{
                            type:"time",
                            value:"",
                        },
                    }
                }
            }
        },
        // 处理值的传递
        watch:{
            'calendar.value': function (value) {
                this.calendar.items[this.calendar.picker].value=value
            }
        },
        methods:{
            // 打开显示选择器
            open(e,type) {
                // 设置类型
                this.calendar.picker=type
                this.calendar.type=this.calendar.items[type].type
                this.calendar.range=this.calendar.items[type].range
                this.calendar.begin=this.calendar.items[type].begin
                this.calendar.end=this.calendar.items[type].end
                this.calendar.value=this.calendar.items[type].value
                // 可不用写
                this.calendar.sep=this.calendar.items[type].sep
                this.calendar.weeks=this.calendar.items[type].weeks
                this.calendar.months=this.calendar.items[type].months

                this.calendar.show=true
                this.calendar.x=e.target.offsetLeft
                this.calendar.y=e.target.offsetTop+e.target.offsetHeight+8
            }
        }
    }
</script>
