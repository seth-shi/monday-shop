@component('mail::message')
# 本周最受欢迎的商品

![{{ $likest->name }}]({{ $likest->thumb }})
### {{ $likest->name }}
{!! $likest->title !!}
[查看详情]({{ url("/products/{$likest->uuid}") }})
****
# 本周最好卖的商品
![{{ $hottest->name }}]({{ $hottest->thumb }})
### {{ $hottest->name }}
{!! $hottest->title !!}
[查看详情]({{ url("/products/{$hottest->uuid}") }})
****
# 本周最新的商品
![{{ $latest->name }}]({{ $latest->thumb }})
### {{ $latest->name }}
{!! $latest->title !!}
[查看详情]({{ url("/products/{$latest->uuid}") }})
****

@component('mail::button', ['url' => "/"])
来星期一商城看看
@endcomponent

感谢你花时间查看本周的订阅消息 | [取消订阅]({{ $unSubUrl }})
@endcomponent
