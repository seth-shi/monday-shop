@extends('layouts.user')

@section('style')
    <link href="/assets/user/css/addstyle.css" rel="stylesheet" type="text/css">
    <style>
        .am-selected-list {
            height: 120px;
            overflow-y: scroll;
        }
    </style>
    <script src="/assets/user/AmazeUI-2.4.2/assets/js/jquery.min.js" type="text/javascript"></script>
    <script src="/assets/user/AmazeUI-2.4.2/assets/js/amazeui.js"></script>
@endsection

@section('main')
	<div class="main-wrap">

		<div class="user-address">
			<!--标题 -->
			<div class="am-cf am-padding">
				<div class="am-fl am-cf"><strong class="am-text-danger am-text-lg">地址管理</strong> / <small>Address&nbsp;list</small></div>
			</div>
			<hr/>
			<ul class="am-avg-sm-1 am-avg-md-3 am-thumbnails">

                @foreach ($addresses as $address)
                    <li class="user-addresslist {{ $address->is_default ? 'defaultAddr' : '' }}">
                        <span class="new-option-r default_addr" data-id="{{ $address->id }}">
                            <i class="am-icon-check-circle"></i>默认地址
                        </span>
                        <p class="new-tit new-p-re">
                            <span class="new-txt">{{ $address->name }}</span>
                            <span class="new-txt-rd2">{{ $address->phone }}</span>
                        </p>
                        <div class="new-mu_l2a new-p-re">
                            <p class="new-mu_l2cw">
                                <span class="title">地址：</span>
                                <span class="province">{{ $address->format() }}</span>
                        </div>
                        <div class="new-addr-btn">
                            <a href="/user/addresses/{{ $address->id }}/edit"><i class="am-icon-edit"></i>编辑</a>
                            <span class="new-addr-bar">|</span>
                            <a href="javascript:;" data-id="{{ $address->id }}" class="delete_address">
                                <i class="am-icon-trash"></i>删除
                            </a>
                        </div>
                    </li>
                @endforeach


			</ul>
			<div class="clear"></div>


			<a class="new-abtn-type" data-am-modal="{target: '#doc-modal-1', closeViaDimmer: 0}">添加新地址</a>
			<!--例子-->


                {{ csrf_field() }}
                <div class="am-modal am-modal-no-btn" id="doc-modal-1">

                    <div class="add-dress">

                        <!--标题 -->
                        <div class="am-cf am-padding">
                            <div class="am-fl am-cf"><strong class="am-text-danger am-text-lg">新增地址</strong> / <small>Add&nbsp;address</small></div>
                        </div>
                        <hr/>


                        @include('hint.status')
                        @include('hint.validate_errors')


                        <div class="am-u-md-12 am-u-lg-8" style="margin-top: 20px;">
                            <form class="am-form am-form-horizontal" action="/user/addresses/{{ $address->id }}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}

                                <div class="am-form-group">
                                    <label for="user-name" class="am-form-label">收货人</label>
                                    <div class="am-form-content">
                                        <input type="text" id="user-name" name="name" value="{{ $address->name }}" placeholder="收货人">
                                    </div>
                                </div>

                                <div class="am-form-group">
                                    <label for="user-phone" class="am-form-label">手机号码</label>
                                    <div class="am-form-content">
                                        <input id="user-phone" name="phone" value="{{ $address->phone }}" placeholder="手机号必填" type="text" maxlength="11">
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="user-address" class="am-form-label">所在地</label>
                                    <div class="am-form-content address">
                                        <select name="province_id" data-am-selected>
                                            @foreach ($provinces as $province)
                                                <option value="{{ $province->id }}" {{ $address->province_id == $province->id ? 'selected' : '' }}>{{ $province->name }}</option>
                                            @endforeach
                                        </select>
                                        <select name="city_id" data-am-selected>
                                            @foreach ($cities as $city)
                                                <option value="{{ $city->id }}" {{ $address->city_id == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="am-form-group">
                                    <label for="user-intro" class="am-form-label">详细地址</label>
                                    <div class="am-form-content">
                                        <textarea name="detail_address" class="" rows="3" id="user-intro" placeholder="输入详细地址">{{ $address->detail_address }}</textarea>
                                        <small>100字以内写出你的详细地址...</small>
                                    </div>
                                </div>

                                <div class="am-form-group">
                                    <div class="am-u-sm-9 am-u-sm-push-3">
                                        <button class="am-btn am-btn-danger">添加</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>

                </div>

		</div>


		<script type="text/javascript">
            $(document).ready(function() {
                $(".new-option-r").click(function() {
                    $(this).parent('.user-addresslist').addClass("defaultAddr").siblings().removeClass("defaultAddr");
                });

                let $ww = $(window).width();
                if($ww>640) {
                    $("#doc-modal-1").removeClass("am-modal am-modal-no-btn")
                }

            })
		</script>

		<div class="clear"></div>
{{ method_field('PUT') }}
	</div>
@endsection

@section('script')
    <script src="/assets/user/layer/2.4/layer.js"></script>
    <script>
        $('.delete_address').click(function(){
            let id = $(this).data('id');
            let _url = "/user/addresses/" + id;
            let that = $(this);

            $.post(_url, {_token:'{{ csrf_token() }}', _method:'DELETE'}, function(res){
                if (res.code == 0) {
                    that.parent().parent().remove();
                }

                layer.msg(res.msg);
            });
        });
    </script>
    <script>
        $('.default_addr').click(function(){
            let id = $(this).data('id');
            let _url = "/user/addresses/default/" + id;

            $.post(_url, {_token:'{{ csrf_token() }}'}, function(res){
                if (res.code == 0) {

                }

                layer.msg(res.msg);
            });
        });
        
        $('select[name=province_id]').change(function () {
            let id = $(this).val();
            let url = "/user/addresses/cities?province_id=" + id;

            $.get(url, function(res){


                let text = '';
                for (let i in res) {

                    text += '<option value="'+ res[i].id +'">'+ res[i].name +'</option>';
                }

                $('select[name=city_id]').html(text);
            });
        });
    </script>
@endsection
