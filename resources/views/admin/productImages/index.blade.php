@extends('layouts.admin')

@section('style')
	<link href="{{ asset('assets/admin/lib/lightbox2/2.8.1/css/lightbox.css') }}" rel="stylesheet" type="text/css" >
@endsection

@section('main')
	<div class="page-container">
		<div class="cl pd-5 bg-1 bk-gray mt-20">
			<span class="l">
				<a href="javascript:;" id="delete_btn" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
			</span> <span class="r">共有数据：<strong>54</strong> 条</span>
		</div>
		<div class="portfolio-content">
			<ul class="cl portfolio-area">
				@inject("categoryPersenter", 'App\Presenters\CategoryPresenter')
				@foreach ($productImages as $image)
					<li class="item">
						<div class="portfoliobox">
							<input class="checkbox" name="image_input" type="checkbox" value="{{ $image->id }}">
							<div class="picbox">
								<a href="{{ $categoryPersenter->getThumbLink($image->link) }}" data-lightbox="gallery" data-title="{{ $image->product->name }}">
									<img class="thumb" src="{{ $categoryPersenter->getThumbLink($image->link) }}">
								</a>
							</div>
							<div class="textbox">{{ $image->product->name }}</div>
						</div>
					</li>
				@endforeach
			</ul>
		</div>
	</div>
@endsection


@section('script')
	<!--请在下方写此页面业务相关的脚本-->
	<script type="text/javascript" src="{{ asset('assets/admin/lib/lightbox2/2.8.1/js/lightbox.min.js') }}"></script>
	<script type="text/javascript">
        $(function(){
            $(".portfolio-area li").Huihover();
        });

        $('#delete_btn').click(function(){

            $('input[name=image_input]:checked').each(function(){
                var id = $(this).val();
                var that = $(this);

                var url = "{{ url('/admin/productImages/') }}/" + id;
                var data = {_token:'{{ csrf_token() }}', _method:'DELETE'};
                $.post(url, data, function(res){

                    if (res.code == 200) {
                        that.parent().parent().remove();
                    }

                    layer.msg(res.msg);
                });
            });
        });
	</script>
@endsection