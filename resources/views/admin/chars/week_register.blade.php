<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
<div id="weekRegister" style=""></div>
<script type="text/javascript">
    $(function () {

        // 动态获取父容器的高度设置为
        var dom = document.getElementById('weekRegister');
        $dom = $(dom);
        $dom.width($dom.parent().width()).height(300);

        // 绘制图表。
        var myChart = echarts.init(dom);
        myChart.setOption({
            tooltip : {
                trigger: 'item',
                formatter: "{b} : {c} ({d}%)"
            },
            series: {
                type: 'pie',
                data: [
                    {name: 'Moon商城', value: "{{ $weekSites->sum('moon_registered_count') }}"},
                    {name: 'QQ', value: "{{ $weekSites->sum('qq_registered_count') }}"},
                    {name: 'Github', value: "{{ $weekSites->sum('github_registered_count') }}"},
                    {name: '微博', value: "{{ $weekSites->sum('weibo_registered_count') }}"},
                ]
            }
        });
    });


</script>
