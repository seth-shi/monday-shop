@extends('layouts.account')
@section('title', '个人中心 · Monday Shop')
@section('account')
<div class="overflow-hidden rounded-[2rem] bg-slate-950 p-7 text-white sm:p-9"><div class="flex flex-col justify-between gap-8 sm:flex-row sm:items-center"><div class="flex items-center gap-5"><img src="{{ $user->avatar }}" alt="" class="size-20 rounded-3xl object-cover ring-4 ring-white/10"><div><p class="text-sm text-slate-400">欢迎回来</p><h1 class="mt-1 text-3xl font-black">{{ $user->name }}</h1><p class="mt-2 text-xs text-brand-500">{{ $level?->name ?? '普通会员' }}</p></div></div><a href="{{ url('/user/setting') }}" class="rounded-full bg-white px-5 py-3 text-center text-sm font-bold text-slate-950">编辑资料</a></div></div>

<div class="mt-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
    @foreach([['订单',$user->orders_count,'/user/orders'],['优惠券',$user->coupons_count,'/user/coupons'],['收藏',$user->like_products_count,'/user/likes'],['购物车',$user->cars_count,'/cars']] as [$label,$count,$url])
        <a href="{{ url($url) }}" class="shop-card p-6"><span class="text-sm text-slate-500">{{ $label }}</span><strong class="mt-3 block text-3xl font-black">{{ $count }}</strong><span class="mt-4 block text-xs font-bold text-brand-700">查看详情 →</span></a>
    @endforeach
</div>

<div class="mt-6 grid gap-6 xl:grid-cols-2">
    <section class="rounded-[2rem] border border-slate-200 bg-white p-6"><div class="flex items-center justify-between"><h2 class="text-xl font-black">积分动态</h2><a href="{{ url('/user/scores') }}" class="text-xs font-bold text-brand-700">全部记录</a></div><p class="mt-2 text-sm text-slate-500">累计 {{ $user->score_all }}，当前可用 {{ $user->score_now }}</p><div class="mt-5 divide-y divide-slate-100">@forelse($scoreLogs as $log)<div class="flex justify-between gap-4 py-3 text-sm"><span class="text-slate-600">{{ $log->description }}</span><strong class="{{ $log->score > 0 ? 'text-emerald-600' : 'text-rose-600' }}">{{ $log->score > 0 ? '+' : '' }}{{ $log->score }}</strong></div>@empty<p class="py-8 text-sm text-slate-400">暂无积分记录</p>@endforelse</div></section>
    <section class="rounded-[2rem] border border-slate-200 bg-white p-6"><div class="flex items-center justify-between"><h2 class="text-xl font-black">最近收藏</h2><a href="{{ url('/user/likes') }}" class="text-xs font-bold text-brand-700">全部收藏</a></div><div class="mt-5 grid grid-cols-3 gap-3">@forelse($user->likeProducts->take(6) as $product)<a href="{{ url('/products/'.$product->uuid) }}" class="group"><div class="aspect-square overflow-hidden rounded-2xl bg-slate-100"><img src="{{ $product->thumb }}" alt="{{ $product->name }}" class="h-full w-full object-cover transition group-hover:scale-105"></div><strong class="mt-2 block truncate text-xs">{{ $product->name }}</strong></a>@empty<p class="col-span-3 py-8 text-sm text-slate-400">还没有收藏商品</p>@endforelse</div></section>
</div>
@endsection
