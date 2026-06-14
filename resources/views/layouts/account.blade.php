@extends('layouts.modern')

@section('main')
<section class="shop-container py-10 lg:py-14">
    <div class="grid gap-8 lg:grid-cols-[240px_1fr]">
        <aside><div class="sticky top-28 overflow-hidden rounded-[2rem] border border-slate-200 bg-white p-4"><div class="flex items-center gap-3 border-b border-slate-100 px-2 pb-4"><img src="{{ auth()->user()->avatar }}" alt="" class="size-12 rounded-2xl object-cover"><div class="min-w-0"><strong class="block truncate text-sm">{{ auth()->user()->name }}</strong><span class="text-xs text-slate-400">个人中心</span></div></div><nav class="mt-3 grid gap-1 text-sm font-semibold">@foreach([['/user','概览'],['/user/orders','我的订单'],['/user/likes','我的收藏'],['/user/coupons','优惠券'],['/user/scores','我的积分'],['/user/addresses','收货地址'],['/user/notifications','消息通知'],['/user/setting','账户设置'],['/user/password','修改密码']] as [$href,$label])<a href="{{ url($href) }}" class="rounded-xl px-3 py-2.5 transition {{ request()->path() === ltrim($href, '/') ? 'bg-slate-950 text-white' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-950' }}">{{ $label }}</a>@endforeach</nav></div></aside>
        <div class="min-w-0">@yield('account')</div>
    </div>
</section>
@endsection
