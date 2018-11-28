<canvas id="orderPayCount"></canvas>
<script>
    $(function () {
        var ctx = document.getElementById("orderPayCount").getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["今日", "七天", "当月"],
                datasets: [{
                    label: '# 交易量',
                    data: [
                        {{ $todaySite->order_pay_count }},
                        {{ $weekSites->sum('order_pay_count') }},
                        {{ $monthSites->sum('order_pay_count') }},
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                    ],
                    borderWidth: 1
                }]
            },
        });
    });
</script>
