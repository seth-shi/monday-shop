@extends('layouts.user')

@section('style')
    <style>
        .pagination {
            display: inline-block;
            padding-left: 0;
            margin: 20px 0;
            border-radius: 4px;
        }

        .pagination > li {
            display: inline;
        }

        .pagination > li > a,
        .pagination > li > span {
            position: relative;
            float: left;
            padding: 6px 12px;
            margin-left: -1px;
            line-height: 1.42857143;
            color: #337ab7;
            text-decoration: none;
            background-color: #fff;
            border: 1px solid #ddd;
        }

        .pagination > li:first-child > a,
        .pagination > li:first-child > span {
            margin-left: 0;
            border-top-left-radius: 4px;
            border-bottom-left-radius: 4px;
        }

        .pagination > li:last-child > a,
        .pagination > li:last-child > span {
            border-top-right-radius: 4px;
            border-bottom-right-radius: 4px;
        }

        .pagination > li > a:hover,
        .pagination > li > span:hover,
        .pagination > li > a:focus,
        .pagination > li > span:focus {
            z-index: 2;
            color: #23527c;
            background-color: #eee;
            border-color: #ddd;
        }

        .pagination > .active > a,
        .pagination > .active > span,
        .pagination > .active > a:hover,
        .pagination > .active > span:hover,
        .pagination > .active > a:focus,
        .pagination > .active > span:focus {
            z-index: 3;
            color: #fff;
            cursor: default;
            background-color: #337ab7;
            border-color: #337ab7;
        }

        .pagination .current {
            color: #999;
        }

        .pagination > .disabled > span,
        .pagination > .disabled > span:hover,
        .pagination > .disabled > span:focus,
        .pagination > .disabled > a,
        .pagination > .disabled > a:hover,
        .pagination > .disabled > a:focus {
            color: #777;
            cursor: not-allowed;
            background-color: #fff;
            border-color: #ddd;
        }

        .pagination-lg > li > a,
        .pagination-lg > li > span {
            padding: 10px 16px;
            font-size: 18px;
            line-height: 1.3333333;
        }

        .pagination-lg > li:first-child > a,
        .pagination-lg > li:first-child > span {
            border-top-left-radius: 6px;
            border-bottom-left-radius: 6px;
        }

        .pagination-lg > li:last-child > a,
        .pagination-lg > li:last-child > span {
            border-top-right-radius: 6px;
            border-bottom-right-radius: 6px;
        }

        .pagination-sm > li > a,
        .pagination-sm > li > span {
            padding: 5px 10px;
            font-size: 12px;
            line-height: 1.5;
        }

        .pagination-sm > li:first-child > a,
        .pagination-sm > li:first-child > span {
            border-top-left-radius: 3px;
            border-bottom-left-radius: 3px;
        }

        .pagination-sm > li:last-child > a,
        .pagination-sm > li:last-child > span {
            border-top-right-radius: 3px;
            border-bottom-right-radius: 3px;
        }

        .pager {
            padding-left: 0;
            margin: 20px 0;
            text-align: center;
            list-style: none;
        }

        .pager li {
            display: inline;
        }

        .pager li > a,
        .pager li > span {
            display: inline-block;
            padding: 5px 14px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 15px;
        }

        .pager li > a:hover,
        .pager li > a:focus {
            text-decoration: none;
            background-color: #eee;
        }

        .pager .next > a,
        .pager .next > span {
            float: right;
        }

        .pager .previous > a,
        .pager .previous > span {
            float: left;
        }

        .pager .disabled > a,
        .pager .disabled > a:hover,
        .pager .disabled > a:focus,
        .pager .disabled > span {
            color: #777;
            cursor: not-allowed;
            background-color: #fff;
        }
    </style>
    <style>
        .goods-date {
            margin-bottom: 10px;
        }

        .s-msg-item {
            display: block;
            width: 100%;
            background: #fff;
        }

        .s-msg-item {
            border: 1px solid #E4EAEE;
            position: relative;
            width: 100%;
        }

        .s-name {
            font-size: 14px;
            position: absolute;
            top: 7px;
            left: 7px;
        }

        .i-msg-downup-wrap {
            overflow: hidden;
            position: relative;
            margin-top: 30px;
        }

        .s-main-content {
            font-size: 14px;
            font-weight: 600;
            padding: 10px 5px;
        }

        a:link, a:visited {
            text-decoration: none;
            outline: none;
            color: #000;
        }

        .read {
            color: #ccc !important;
        }

        .read_all_btn { /* 按钮美化 */
            display: inline-block;
            width: 100px; /* 宽度 */
            border-width: 0px; /* 边框宽度 */
            border-radius: 3px; /* 边框半径 */
            background: #00a65a; /* 背景颜色 */
            cursor: pointer; /* 鼠标移入按钮范围时出现手势 */
            outline: none; /* 不显示轮廓线 */
            color: white; /* 字体颜色 */
            font-size: 17px; /* 字体大小 */
        }
        .read_all_btn:hover { /* 鼠标移入按钮范围时改变颜色 */
            background: #00a65a;
        }
    </style>
@endsection

@section('main')
    <div class="main-wrap">

        <div class="user-order">

            <!--标题 -->
            <div class="am-cf am-padding">
                <div class="am-fl am-cf"><strong class="am-text-danger am-text-lg">消息通知</strong>
                </div>
            </div>
            <hr/>

            <div class="am-tabs am-tabs-d2 am-margin" data-am-tabs>

                <ul class="am-avg-sm-5 am-tabs-nav am-nav am-nav-tabs">
                    <li class="{{ (request('tab', 1) == 1) ? 'am-active' : '' }}"><a style="cursor: pointer" href="?tab=1">未读({{ $unreadCount }})</a></li>
                    <li class="{{ request('tab', 1) == 2 ? 'am-active' : '' }}"><a style="cursor: pointer" href="?tab=2">所有({{ $readCount }})</a></li>
                    <li class="{{ request('tab', 1) == 3 ? 'am-active' : '' }}"><a style="cursor: pointer" href="?tab=3">已读({{ $unreadCount + $readCount }})</a></li>
                </ul>

                @include('hint.validate_errors')
                @include('hint.status')


                <div class="row row-masnory row-tb-20">
                    <div class="coupon-wrapper">
                        @foreach ($notifications as $notification)
                            <div class="s-msg-item s-msg-temp i-msg-downup">
                                <h6 class="s-msg-bar"><span class="s-name">{{ $notification->created_at }}</span></h6>
                                <div class="s-msg-content i-msg-downup-wrap">
                                    <div class="i-msg-downup-con">
                                        <a class="i-markRead" href="/user/notifications/{{ $notification->id }}">
                                            <p class="s-main-content">
                                                <span style="color: green" class="notification_title {{ is_null($notification->read_at) ? '' : 'read' }}">
                                                   {{ $notification->title }}
                                                </span>
                                            </p>
                                        </a>
                                        <p class="s-row s-main-content">
                                            @if (is_null($notification->read_at))
                                            <a class="read_btn" href="javascript:;" data-id="{{ $notification->id }}">
                                                标为已读<i class="am-icon-comments"></i>
                                            </a>
                                            @endif
                                            <a style="margin-left: 20px;" href="/user/notifications/{{ $notification->id }}">
                                                查看详情 <i class="am-icon-angle-right"></i>
                                            </a>
                                        </p>

                                    </div>
                                </div>
                            </div>
                        @endforeach

                        {{ $notifications->appends(request()->all())->links() }}
                    </div>

                </div>
            </div>
        </div>


    </div>

@endsection


@section('script')
    <script>
        $('.read_btn').click(function () {

            var that = $(this);
            var id = $(this).data('id');
            $.get('/user/notifications/' + id + '/read', function (res) {

                if (res.code != 200) {

                    layer.alert(res.msg, {icon: 2})
                    return;
                }

                that.parents('.i-msg-downup-con').find('.notification_title').addClass('read');
                // 移除掉自己按钮
                that.remove();
            })
        })

        // 已读所有
        $('.read_all_btn').click(function () {

            $.get('/user/notifications/read_all', function (res) {

                if (res.code != 200) {

                    layer.alert(res.msg, {icon: 2})
                    return;
                }

                layer.msg(res.msg);
                setTimeout(function () {
                    window.location.reload();
                }, 500);
            })
        });
    </script>
@endsection