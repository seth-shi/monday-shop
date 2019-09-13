@extends('layouts.user')

@section('style')

@endsection

@section('main')
    <div class="main-wrap">

        <div class="user-order">

            <!--标题 -->
            <div class="am-cf am-padding">
                <div class="am-fl am-cf"><strong class="am-text-danger am-text-lg">消息详情</strong>
                </div>
            </div>
            <hr/>

            <div class="am-tabs am-tabs-d2 am-margin" data-am-tabs>

                <ul class="am-avg-sm-5 am-tabs-nav am-nav am-nav-tabs">
                    <li class="{{ is_null($last) ? '' : 'am-active' }}">
                        <a  style="cursor: pointer" href="{{ is_null($last) ? 'javascript:;' : "/user/notifications/{$last->id}" }}" >上一条</a>
                    </li>
                    <li class="am-active">
                        <a style="cursor: pointer" href="/user/notifications" >返回列表</a>
                    </li>
                    <li class="{{ is_null($next) ? '' : 'am-active' }}">
                        <a style="cursor: pointer" href="{{ is_null($next) ? 'javascript:;' : "/user/notifications/{$next->id}" }}">下一条</a>
                    </li>
                </ul>

                @include('hint.validate_errors')
                @include('hint.status')


                <div class="row row-masnory row-tb-20">
                    <div class="coupon-wrapper">
                        <h2 style="text-align: center; margin: 20px;font-size: 24px;">{{ $notification->title }}</h2>
                        <hr>
                        @include($view)
                    </div>
                </div>
            </div>
        </div>


    </div>

@endsection


