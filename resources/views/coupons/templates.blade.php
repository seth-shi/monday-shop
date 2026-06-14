@extends('layouts.modern')

@section('title', '优惠中心 - Monday Shop')

@section('main')
<section class="shop-container py-12 lg:py-16">
    <div class="mb-10 max-w-2xl">
        <span class="shop-kicker">Member rewards</span>
        <h1 class="mt-3 text-4xl font-black tracking-tight">优惠中心</h1>
        <p class="mt-3 text-slate-500">领取适合你的优惠券，下单时系统会自动筛选可用优惠。</p>
    </div>

    @include('hint.status')
    <div id="coupon-message" class="mb-6 hidden rounded-2xl px-4 py-3 text-sm font-semibold"></div>

    <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
        @forelse($templates as $template)
            <article class="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-slate-950 to-slate-800 p-6 text-white shadow-xl shadow-slate-200">
                <div class="absolute -right-10 -top-10 size-32 rounded-full bg-brand-500/30 blur-2xl"></div>
                <div class="relative">
                    <div class="flex items-start justify-between gap-4">
                        <div><p class="text-sm font-semibold text-slate-300">{{ $template->title }}</p><p class="mt-3 text-4xl font-black">¥{{ number_format($template->amount, 2) }}</p></div>
                        @if($template->score > 0)<span class="rounded-full bg-white/10 px-3 py-1 text-xs">{{ $template->score }} 积分</span>@endif
                    </div>
                    <p class="mt-5 text-sm text-slate-300">{{ $template->full_amount > 0 ? '满 ¥'.number_format($template->full_amount, 2).' 可用' : '无门槛使用' }}</p>
                    <p class="mt-1 text-xs text-slate-400">有效期 {{ $template->start_date }} 至 {{ $template->end_date }}</p>
                    <button type="button" data-coupon-id="{{ $template->id }}" class="mt-6 w-full rounded-2xl px-4 py-3 text-sm font-black transition {{ $template->coupons_count > 0 ? 'cursor-not-allowed bg-white/10 text-slate-400' : 'bg-white text-slate-950 hover:bg-brand-50' }}" {{ $template->coupons_count > 0 ? 'disabled' : '' }}>{{ $template->coupons_count > 0 ? '已领取' : '立即领取' }}</button>
                </div>
            </article>
        @empty
            <div class="shop-card col-span-full p-12 text-center text-slate-500">暂时没有可领取的优惠券。</div>
        @endforelse
    </div>
</section>
@endsection

@push('scripts')
<script>
document.querySelectorAll('[data-coupon-id]').forEach((button) => button.addEventListener('click', async () => {
    const message = document.querySelector('#coupon-message');
    button.disabled = true;
    try {
        const { data } = await axios.post('/coupons', { template_id: button.dataset.couponId });
        if (Number(data.code) !== 200) throw new Error(data.msg || '领取失败');
        button.textContent = '已领取';
        button.className = 'mt-6 w-full cursor-not-allowed rounded-2xl bg-white/10 px-4 py-3 text-sm font-black text-slate-400';
        message.textContent = data.msg || '领取成功';
        message.className = 'mb-6 rounded-2xl bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700';
    } catch (error) {
        button.disabled = false;
        message.textContent = error.response?.data?.msg || error.message || '领取失败，请稍后再试';
        message.className = 'mb-6 rounded-2xl bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700';
    }
}));
</script>
@endpush
