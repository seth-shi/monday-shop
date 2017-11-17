@component('mail::message')
# 本周最受欢迎的商品
![$likest->name]({{ asset('/storage/' . $likest->thumb) }})
### {{ $likest->name }}
> {!! $likest->title !!}
[查看详情]({{ url("/home/products/{$likest->id}") }})
****
# 本周最好卖的商品
![$hotest->name]({{ asset('/storage/' . $hotest->thumb) }})
### {{ $hotest->name }}
> {!! $hotest->title !!}
[查看详情]({{ url("/home/products/{$hotest->id}") }})
****
# 本周最新的商品
![$latest->name]({{ asset('/storage/' . $latest->thumb) }})
### {{ $latest->name }}
> {!! $latest->title !!}
[查看详情]({{ url("/home/products/{$latest->id}") }})
****

@component('mail::button', ['url' => "/"])
来星期一商城看看
@endcomponent

感谢你花时间查看本周的订阅消息，如需退订，请去到星期一商城首页点击退订！<br>
@endcomponent
