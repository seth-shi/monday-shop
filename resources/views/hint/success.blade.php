<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>跳转提示</title>
    <style type="text/css">
        * { padding: 0; margin: 0; }
        body { background: #fff; font-family: '微软雅黑'; color: #333; font-size: 16px; text-align: center;}
        .system-message {position: absolute;top:50%;left: 50%;padding: 20px;
            transform:translate(-50%, -50%);
            -webkit-transform:translate(-50%, -50%);
            -ms-transform:translate(-50%, -50%);
        }
        .system-message h1 { font-size: 120px; font-weight: normal; }
        .system-message .jump { padding-top: 10px }
        .system-message .jump a { color: #09C; text-decoration:none }
        .system-message .success, .system-message .error { line-height: 1.8em; font-size: 36px }
        .system-message .detail { font-size: 12px; line-height: 20px; margin-top: 12px; display:none }
        .system-message{border:3px solid #09C;}
        .system-message h1{ color: #09C;}
    </style>
</head>

<body>
<div class="system-message">
    <h1>√</h1>
    <p class="success">{{ $status }}</p>
    <p class="detail"></p>
    <p class="jump">页面自动
        <a id="href" href="{{ $url or url('/') }}">跳转</a>等待时间：
        <b id="wait">3</b>
    </p>
</div>
<script type="text/javascript">(function() {
        let wait = document.getElementById('wait'),
            href = document.getElementById('href').href;
        let interval = setInterval(function() {
                let time = --wait.innerHTML;
                if (time <= 0) {
                    location.href = href;
                    clearInterval(interval);
                };
            },
            1000);
    })();
</script>
</body>

</html>
