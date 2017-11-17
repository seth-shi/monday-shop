<aside class="menu">
    <ul>
        <li class="person active">
            <a href="{{ url('/user') }}">个人中心</a>
        </li>
        <li class="person">
            <ul>
                <li> <a href="{{ url('/user/setting') }}">个人信息</a></li>
                <li> <a href="{{ url('/user/password') }}">修改密码</a></li>
                <li> <a href="{{ url('/user/addresses') }}">收货地址</a></li>
            </ul>
        </li>
        <li class="person">
            <a href="#">我的交易</a>
            <ul>
                <li><a href="{{ url('user/orders') }}">订单管理</a></li>
            </ul>
        </li>
        <li class="person">
            <a href="#">我的小窝</a>
            <ul>
                <li> <a href="{{ url('/user/likes') }}">收藏</a></li>
                <li> <a href="foot.html">足迹</a></li>
                <li> <a href="comment.html">评价</a></li>
                <li> <a href="news.html">消息</a></li>
            </ul>
        </li>

    </ul>

</aside>