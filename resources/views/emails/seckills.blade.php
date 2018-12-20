@component('mail::message')
你收藏的商品：<h2 style="color: red">{{ $product->name }}</h2>
![{{ $product->name }}]({{ $product->thumb }})
****

原价：<em>{{ $product->price }}</em>, 现在只要 <span style="font-weight: bold; color: red;">{{ $seckill->price }}</span>

秒杀开始时间：**{{ $seckill->start_at }}**

活动数量：**{{ $seckill->number }}**

[查看详情]({{ url("/seckills/{$seckill->id}") }})
****

@component('mail::button', ['url' => "/"])
来星期一商城看看
@endcomponent

@endcomponent
