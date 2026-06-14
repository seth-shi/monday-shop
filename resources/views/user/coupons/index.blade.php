@extends('layouts.account')

@section('title', '我的优惠券 - Monday Shop')

@section('account')
<div class="flex flex-wrap items-end justify-between gap-4"><div><span class="shop-kicker">Wallet</span><h1 class="mt-2 text-3xl font-black">我的优惠券</h1></div><a href="{{ url('/coupon_templates') }}" class="shop-button-secondary">领取更多</a></div>
<nav class="mt-7 flex gap-2 overflow-x-auto">@foreach([1 => '未使用', 2 => '已使用', 3 => '已过期'] as $tab => $label)<a href="?tab={{ $tab }}" class="whitespace-nowrap rounded-full px-4 py-2 text-sm font-bold {{ (int) request('tab', 1) === $tab ? 'bg-slate-950 text-white' : 'bg-white text-slate-500' }}">{{ $label }}</a>@endforeach</nav>
<div class="mt-6 grid gap-5 md:grid-cols-2">
    @forelse($coupons as $coupon)
        <article class="shop-card overflow-hidden p-6 {{ $coupon->used ? 'opacity-60' : '' }}">
            <div class="flex items-start justify-between gap-4"><div><p class="text-sm font-bold text-slate-500">{{ $coupon->title }}</p><p class="mt-2 text-3xl font-black">¥{{ number_format($coupon->amount, 2) }}</p></div><span class="rounded-full bg-brand-50 px-3 py-1 text-xs font-bold text-brand-700">{{ $coupon->show_title }}</span></div>
            <p class="mt-4 text-sm text-slate-500">{{ $coupon->full_amount > 0 ? '满 ¥'.number_format($coupon->full_amount, 2).' 可用' : '无门槛使用' }}</p>
            <p class="mt-1 text-xs text-slate-400">{{ $coupon->start_date }} 至 {{ $coupon->end_date }}</p>
            @unless($coupon->used)<a href="{{ url('/products') }}" class="mt-5 inline-flex text-sm font-black text-brand-600">去选购 →</a>@endunless
        </article>
    @empty
        <div class="shop-card col-span-full p-12 text-center text-slate-500">这个分类下还没有优惠券。</div>
    @endforelse
</div>
<div class="mt-8">{{ $coupons->appends(request()->all())->links() }}</div>
@endsection
