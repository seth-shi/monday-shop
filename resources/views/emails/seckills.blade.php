@component('mail::message')
# 你好！这是推送邮件。
****
你收藏的商品：[{{ $product->name }}]，有秒杀活动了 !!!
原价：{{ $product->price }}, 现在只要**{{ $seckill->price }}**
![{{ $product->name }}]({{ $product->thumb }})
* 秒杀开始时间：**{{ $seckill->start_at }}**
[查看详情]({{ url("/seckills/{$seckill->id}") }})
****

@component('mail::button', ['url' => "/"])
来星期一商城看看
@endcomponent

@endcomponent
