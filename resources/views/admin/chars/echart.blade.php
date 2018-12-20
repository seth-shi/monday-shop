<script>

    $(function () {



        // 今天的注册人数
        let charts = [];
        let myChart = echarts.init(document.getElementById('todayRegister'));
        myChart.setOption({
            tooltip : {
                trigger: 'item',
                formatter: "{b} : {c} ({d}%)"
            },
            grid: {
                left: '3%',
                right: '8%',
                bottom: '3%',
                containLabel: true
            },
            series: {
                type: 'pie',
                data: [
                    {name: 'Moon商城', value: "{{ $todaySite->moon_registered_count }}"},
                    {name: 'QQ', value: "{{ $todaySite->qq_registered_count }}"},
                    {name: 'Github', value: "{{ $todaySite->github_registered_count }}"},
                    {name: '微博', value: "{{ $todaySite->weibo_registered_count }}"},
                ]
            }
        });
        charts.push(myChart);

        // 七天注册人数
        myChart = echarts.init(document.getElementById('weekRegister'));
        myChart.setOption({
            tooltip : {
                trigger: 'item',
                formatter: "{b} : {c} ({d}%)"
            },
            grid: {
                left: '3%',
                right: '8%',
                bottom: '3%',
                containLabel: true
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
        charts.push(myChart);

        // 当月注册人数
        myChart = echarts.init(document.getElementById('monthRegister'));
        myChart.setOption({
            tooltip : {
                trigger: 'item',
                formatter: "{b} : {c} ({d}%)"
            },
            grid: {
                left: '3%',
                right: '8%',
                bottom: '3%',
                containLabel: true
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
        charts.push(myChart);

        // 今天订单
        myChart = echarts.init(document.getElementById('todayOrders'));
        myChart.setOption({
            xAxis: {
                type: 'category',
                data: ['今日总订单', '今日付款订单', '今日取消订单']
            },
            grid: {
                left: '3%',
                right: '12%',
                bottom: '3%',
                containLabel: true
            },
            yAxis: {
                type: 'value'
            },
            series: [{
                data: [
                    {{ $todaySite->order_count }},
                    {{ $todaySite->order_pay_count }},
                    {{ $todaySite->refund_pay_count }}
                ],
                type: 'bar'
            }]
        });
        charts.push(myChart);


        // 七日订单
        myChart = echarts.init(document.getElementById('weekSites'));
        myChart.setOption({
            tooltip: {
                trigger: 'axis'
            },
            legend: {
                data: ['总订单', '付款订单', '取消订单量']
            },
            grid: {
                left: '3%',
                right: '12%',
                bottom: '3%',
                containLabel: true
            },
            xAxis: {
                type: 'category',
                boundaryGap: false,
                data: ['{!! $weekSites->pluck('date')->implode('\',\'') !!}']
            },
            yAxis: {
                type: 'value',
                min: 0,
                max: 'dataMax'
            },
            series: [
                {
                    name: '总订单',
                    type: 'line',
                    data: [{{ $weekSites->pluck('order_count')->implode(',') }}]
                },
                {
                    name: '付款订单',
                    type: 'line',
                    data: [{{ $weekSites->pluck('order_pay_count')->implode(',') }}]
                },
                {
                    name: '取消订单量',
                    type: 'line',
                    data: [{{ $weekSites->pluck('refund_pay_count')->implode(',') }}]
                }
            ]
        });
        charts.push(myChart);

        // 销售金额
        myChart = echarts.init(document.getElementById('saleMoney'));
        myChart.setOption({
            tooltip: {
                trigger: 'axis'
            },
            legend: {
                data: ['销售金额']
            },
            grid: {
                left: '3%',
                right: '12%',
                bottom: '3%',
                containLabel: true
            },
            xAxis: {
                type: 'category',
                boundaryGap: false,
                data: ['{!! $monthSites->pluck('date')->implode('\',\'') !!}']
            },
            yAxis: {
                type: 'value',
                min: 0,
                max: 'dataMax'
            },
            series: [
                {
                    name: '总订单',
                    type: 'line',
                    data: [{{ $monthSites->pluck('sale_money_count')->implode(',') }}]
                }
            ]
        });
        charts.push(myChart);

        window.addEventListener('resize', function () {

            for (let i in charts) {
                charts[i].resize();
            }
        });

    });

</script>
