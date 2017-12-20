@extends('layouts.admin')


@section('main')

	@include('common.admin.header')

	@include('common.admin.menu')

	<section class="Hui-article-box">
		<div id="Hui-tabNav" class="Hui-tabNav hidden-xs">
			<div class="Hui-tabNav-wp">
				<ul id="min_title_list" class="acrossTab cl">
					<li class="active">
						<span title="我的桌面" data-href="welcome.html">我的桌面</span>
						<em></em></li>
				</ul>
			</div>
			<div class="Hui-tabNav-more btn-group"><a id="js-tabNav-prev" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d4;</i></a><a id="js-tabNav-next" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d7;</i></a></div>
		</div>
		<div id="iframe_box" class="Hui-article">
			<div class="show_iframe">
				<div style="display:none" class="loading"></div>

                <!-- {{ route('admin.welcome') }} -->
				<iframe scrolling="yes" frameborder="0" src="{{ url('admin/admins') }}"></iframe>
			</div>
		</div>
	</section>

	@include('common.admin.footer')
    <!-- 此处 footer 仅是 引入js -->
@endsection