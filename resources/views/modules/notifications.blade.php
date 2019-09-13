@auth
    <link rel="stylesheet" href="/css/toastr.min.css">
    <script src="/js/toastr.min.js"></script>

    <script>
        $(function () {

            // 点击跳去消息页面
            toastr.options.onclick = function() {
                window.location.href = '/user/notifications?tab=1';
            };
            // 永久显示
            toastr.options.timeOut = 0;
            toastr.options.extendedTimeOut = 0;

            var store = window.localStorage;
            // 请求时间间隔
            var timeLimit = 15 * 1000;
            // 保证第一次总是可以请求到
            store.setItem('last_request_at', (new Date()).getTime() - timeLimit);


            var timer = setInterval(function () {

                // 如果上一次的时间没超过 5 秒间隔，则不获取，防止多个窗口多次请求
                var lastRequestAt = store.getItem('last_request_at');
                var now = (new Date()).getTime() - timeLimit;
                var diff = now - lastRequestAt;

                console.log('上一次请求的时间：' + lastRequestAt);
                console.log('这一次请求的时间：' + now);
                console.log('相差时间：' + diff);

                if (diff < timeLimit) {
                    return false;
                }
                store.setItem('last_request_at', now);

                getUnReadNotification();

            }, timeLimit);


            // 进来先初始化请求一次
            getUnReadNotification();
            function getUnReadNotification()
            {
                $.get('/user/un_read_count/notifications', function (res) {

                    if (res.code != 200) {

                        if (timer) {
                            clearTimeout(timer);
                        }
                        toastr.error(res.msg);

                        return;
                    }

                    if (res.data.count > 0) {

                        // 跳去消息详情页面
                        var url = '/user/notifications';
                        if (res.data.id) {
                            url += '/' + res.data.id;
                        }
                        toastr.options.onclick = function() {
                            window.location.href = url;
                        };

                        toastr.info(res.data.title, res.data.content);
                        // 停掉定时器，只显示一个悬浮框即可
                        if (timer) {

                            clearInterval(timer);
                        }
                    }
                })
            }
        });
    </script>
@endauth