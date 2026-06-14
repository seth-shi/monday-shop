@extends('layouts.modern')

@section('title', '确认订单 - Monday Shop')

@section('main')
<section class="shop-container py-12 lg:py-16"><div class="mb-8"><span class="shop-kicker">Checkout</span><h1 class="mt-2 text-4xl font-black">确认订单</h1></div>
<div id="checkout-message" class="mb-6 hidden rounded-2xl px-4 py-3 text-sm font-semibold"></div>
<div class="grid gap-8 lg:grid-cols-[1fr_380px]">
    <div class="grid gap-5">@foreach($products as $product)<article class="shop-card flex gap-5 p-5"><img src="{{ assertUrl($product->thumb) }}" alt="{{ $product->name }}" class="size-24 rounded-2xl object-cover"><div class="min-w-0 flex-1"><a href="{{ url('/products/'.$product->uuid) }}" class="font-black">{{ $product->name }}</a><p class="mt-2 text-sm text-slate-500">¥{{ number_format($product->price, 2) }} × {{ $product->number }}</p><p class="mt-3 font-black">小计 ¥{{ number_format($product->total_amount, 2) }}</p></div></article>@endforeach</div>
    <aside><form id="checkout-form" class="shop-card sticky top-28 p-6">@csrf
        @foreach($products as $product)<input type="hidden" name="ids[]" value="{{ $product->uuid }}"><input type="hidden" name="numbers[]" value="{{ $product->number }}">@endforeach
        @foreach($cars as $id)<input type="hidden" name="cars[]" value="{{ $id }}">@endforeach
        <input type="hidden" name="coupon_id" id="coupon-id"><input type="hidden" name="pay_type" value="1">
        <h2 class="text-xl font-black">支付信息</h2>
        <label class="mt-5 grid gap-2 text-sm font-bold">收货地址 @if($addresses->isNotEmpty())<select class="shop-input" name="address_id" required><option value="">请选择收货地址</option>@foreach($addresses as $address)<option value="{{ $address->id }}" @selected($address->is_default)>{{ $address->name }} / {{ $address->phone }} / {{ $address->format() }}</option>@endforeach</select>@else<a href="{{ url('/user/addresses') }}" class="text-brand-600">先添加收货地址 →</a>@endif</label>
        <label class="mt-5 grid gap-2 text-sm font-bold">优惠券<select id="coupon-select" class="shop-input"><option value="" data-amount="0">不使用优惠券</option>@foreach($coupons as $coupon)<option value="{{ $coupon->id }}" data-amount="{{ $coupon->amount }}">{{ $coupon->title }} - ¥{{ number_format($coupon->amount, 2) }}</option>@endforeach</select></label>
        <div class="mt-6 grid gap-3 border-t border-slate-100 pt-5 text-sm"><div class="flex justify-between"><span class="text-slate-500">商品金额</span><span>¥{{ number_format($totalAmount, 2) }}</span></div><div class="flex justify-between"><span class="text-slate-500">运费</span><span>+ ¥{{ number_format($postAmount, 2) }}</span></div><div class="flex justify-between"><span class="text-slate-500">优惠</span><span id="coupon-amount" class="text-emerald-600">- ¥0.00</span></div><div class="flex items-end justify-between border-t border-slate-100 pt-4"><span class="font-bold">应付</span><strong id="checkout-total" data-total="{{ $totalAmount }}" data-post="{{ $postAmount }}" class="text-3xl">¥{{ number_format($totalAmount + $postAmount, 2) }}</strong></div></div>
        <button class="shop-button-primary mt-6 w-full" @disabled($addresses->isEmpty())>提交订单并付款</button>
    </form></aside>
</div></section>
@endsection

@push('scripts')
<script>
const couponSelect = document.querySelector('#coupon-select');
const totalElement = document.querySelector('#checkout-total');
couponSelect?.addEventListener('change', () => { const option = couponSelect.selectedOptions[0]; const discount = Number(option.dataset.amount || 0); document.querySelector('#coupon-id').value = option.value; document.querySelector('#coupon-amount').textContent = `- ¥${discount.toFixed(2)}`; totalElement.textContent = `¥${Math.max(0, Number(totalElement.dataset.total) + Number(totalElement.dataset.post) - discount).toFixed(2)}`; });
document.querySelector('#checkout-form')?.addEventListener('submit', async (event) => { event.preventDefault(); const button = event.submitter; const message = document.querySelector('#checkout-message'); button.disabled = true; button.textContent = '正在创建订单...'; try { const { data } = await axios.post('/user/comment/orders', new FormData(event.target)); if (Number(data.code) !== 200) throw new Error(data.msg || '创建订单失败'); window.location.href = `/user/pay/orders/${data.data.order_id}/again`; } catch (error) { button.disabled = false; button.textContent = '提交订单并付款'; message.textContent = error.response?.data?.msg || error.message || '创建订单失败'; message.className = 'mb-6 rounded-2xl bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700'; } });
</script>
@endpush
