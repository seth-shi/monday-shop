<h3 style="text-align: center;">有效期至：{{ $data['start_date'] ?? '' }} ~ {{ $data['end_date'] ?? '' }}</h3>
<br>
<p style="text-indent: 20px;">
    你的兑换码为：</span><em id="code_txt" style="color: red; font-weight: bold;">{{ $data['code'] ?? '' }}</em>
</p>
<hr>
<div style="margin: 20px;">
    <button id="copy_btn" data-clipboard-text="{{ $data['code'] ?? '' }}" style="
    position: relative;
    display: inline-block;
    padding: 6px 12px;
    font-size: 13px;
    font-weight: 700;
    line-height: 20px;
    color: #333;
    white-space: nowrap;
    vertical-align: middle;
    cursor: pointer;
    background-color: #eee;
    background-image: linear-gradient(#fcfcfc,#eee);
    border: 1px solid #d5d5d5;
    border-radius: 3px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    -webkit-appearance: none;">
        复制兑换码
    </button>
    <button class="show_coupon_code_btn" style="
    position: relative;
    display: inline-block;
    padding: 6px 12px;
    font-size: 13px;
    font-weight: 700;
    line-height: 20px;
    color: #333;
    white-space: nowrap;
    vertical-align: middle;
    cursor: pointer;
    background-color: #eee;
    background-image: linear-gradient(#fff,#888);
    border: 1px solid #d5d5d5;
    border-radius: 3px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    -webkit-appearance: none;">
        点我兑换
    </button>

</div>
<script src="/js/clipboard.min.js"></script>
<script>

    var clipboard = new ClipboardJS('#copy_btn');

    clipboard.on('success', function(e) {

        layer.msg('复制成功')
        e.clearSelection();
    });

    clipboard.on('error', function(e) {
        layer.msg('复制失败，请手动复制')
    });
</script>

