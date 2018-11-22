<canvas id="countRegistered"></canvas>
<script>
    $(function () {
        var ctx = document.getElementById("countRegistered").getContext('2d');
        var myRadarChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ["QQ", "Github", "微博", "商城前台注册"],
                datasets: [{
                    // 'registered_count', 'github_registered_count', 'qq_registered_count', 'weibo_registered_count',
                    data: [
                        {{ $today->qq_registered_count }},
                        {{ $today->github_registered_count }},
                        {{ $today->weibo_registered_count }},
                        {{ $today->moon_registered_count }}
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
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
    });
</script>
