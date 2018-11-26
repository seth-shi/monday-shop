<canvas id="saleMoney"></canvas>
<script>
    $(function () {
        var ctx = document.getElementById("saleMoney").getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["今日", "七天", "当月"],
                datasets: [{
                    label: '# 交易金额',
                    data: [
                        {{ $todaySite->product_sale_money_count }},
                        {{ $weekSites->sum('product_sale_money_count') }},
                        {{ $monthSites->sum('product_sale_money_count') }},
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
