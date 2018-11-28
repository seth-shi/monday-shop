<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
<div id="monthRegister" style=""></div>
<script type="text/javascript">
    $(function () {

        // 动态获取父容器的高度设置为
        var dom = document.getElementById('monthRegister');
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
                    {name: 'Moon商城', value: "{{ $monthSites->sum('moon_registered_count') }}"},
                    {name: 'QQ', value: "{{ $monthSites->sum('qq_registered_count') }}"},
                    {name: 'Github', value: "{{ $monthSites->sum('github_registered_count') }}"},
                    {name: '微博', value: "{{ $monthSites->sum('weibo_registered_count') }}"},
                ]
            }
        });
    });


</script>
