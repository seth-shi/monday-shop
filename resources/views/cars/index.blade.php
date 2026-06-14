@extends('layouts.modern')

@section('title', '购物车 · Monday Shop')

@section('main')
<section class="shop-container py-14">
    <div class="flex flex-wrap items-end justify-between gap-4"><div><p class="text-xs font-bold uppercase tracking-[0.2em] text-brand-600">Your cart</p><h1 class="mt-3 text-4xl font-black">购物车</h1></div><a href="{{ url('/products') }}" class="text-sm font-bold text-brand-700">继续购物 →</a></div>

    @guest
        <div class="mt-10 rounded-[2rem] border border-slate-200 bg-white py-20 text-center"><div class="mx-auto grid size-16 place-items-center rounded-full bg-slate-100"><svg class="size-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3h2l2.2 10.2a2 2 0 0 0 2 1.6h7.7a2 2 0 0 0 2-1.6L20 7H6"/></svg></div><h2 class="mt-5 text-xl font-black">登录后查看购物车</h2><p class="mt-2 text-sm text-slate-500">商品会安全地保存在你的账户中。</p><a href="{{ route('login') }}" class="shop-button mt-6">前往登录</a></div>
    @else
        @if($cars->isEmpty())
            <div class="mt-10 rounded-[2rem] border border-dashed border-slate-300 bg-white py-20 text-center"><div class="text-4xl">◇</div><h2 class="mt-4 text-xl font-black">购物车还是空的</h2><p class="mt-2 text-sm text-slate-500">去挑一件喜欢的商品吧。</p><a href="{{ url('/products') }}" class="shop-button mt-6">浏览商品</a></div>
        @else
            <form action="{{ url('/user/comment/orders/create') }}" method="get" id="cart-form" class="mt-10 grid gap-8 lg:grid-cols-[1fr_340px]">
                <div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white">
                    <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4 sm:px-7"><label class="flex items-center gap-3 text-sm font-bold"><input id="select-all" type="checkbox" checked class="size-4 rounded border-slate-300">全选</label><span class="text-xs text-slate-400">{{ $cars->count() }} 件商品</span></div>
                    <div class="divide-y divide-slate-100" id="cart-items">
                        @foreach($cars as $car)
                            <article class="cart-item grid grid-cols-[auto_80px_1fr] gap-4 p-5 sm:grid-cols-[auto_96px_1fr_auto] sm:p-7" data-price="{{ $car->product->price }}">
                                <input type="checkbox" name="ids[]" value="{{ $car->product->uuid }}" checked class="cart-check mt-9 size-4 rounded border-slate-300">
                                <a href="{{ url('/products/'.$car->product->uuid) }}" class="size-20 overflow-hidden rounded-2xl bg-slate-100 sm:size-24"><img src="{{ $car->product->thumb }}" alt="{{ $car->product->name }}" class="h-full w-full object-cover"></a>
                                <div class="min-w-0"><h2 class="line-clamp-2 font-black"><a href="{{ url('/products/'.$car->product->uuid) }}">{{ $car->product->name }}</a></h2><p class="mt-2 text-lg font-black">¥{{ number_format($car->product->price, 2) }}</p><div class="mt-4 inline-flex items-center rounded-full border border-slate-300 p-1"><button type="button" class="cart-minus grid size-8 place-items-center rounded-full hover:bg-slate-100">−</button><input name="numbers[]" value="{{ $car->number }}" min="1" max="{{ $car->product->count }}" data-product="{{ $car->product->uuid }}" class="cart-quantity w-12 border-0 bg-transparent text-center text-sm font-bold outline-none"><button type="button" class="cart-plus grid size-8 place-items-center rounded-full hover:bg-slate-100">+</button></div></div>
                                <div class="col-start-3 flex items-center justify-between sm:col-start-auto sm:flex-col sm:items-end"><strong class="item-total">¥{{ number_format($car->product->price * $car->number, 2) }}</strong><button type="button" data-delete-cart="{{ $car->id }}" class="text-xs font-bold text-slate-400 hover:text-rose-600">删除</button></div>
                            </article>
                        @endforeach
                    </div>
                </div>
                <aside><div class="sticky top-28 rounded-[2rem] bg-slate-950 p-7 text-white"><h2 class="text-xl font-black">订单摘要</h2><dl class="mt-7 grid gap-4 text-sm"><div class="flex justify-between text-slate-400"><dt>已选商品</dt><dd id="selected-count">0 件</dd></div><div class="flex justify-between text-slate-400"><dt>运费</dt><dd>结算时计算</dd></div><div class="flex items-end justify-between border-t border-white/10 pt-5"><dt class="font-bold">商品合计</dt><dd id="cart-total" class="text-3xl font-black">¥0.00</dd></div></dl><button class="mt-7 w-full rounded-full bg-brand-500 px-5 py-3 text-sm font-bold transition hover:bg-brand-600">去结算</button><p id="cart-message" class="mt-4 text-center text-xs text-slate-400" aria-live="polite"></p></div></aside>
            </form>
        @endif
    @endguest
</section>
@endsection

@auth
@push('scripts')
<script>
const refreshCart = () => {
    let total = 0, count = 0;
    document.querySelectorAll('.cart-item').forEach(item => {
        const checkbox = item.querySelector('.cart-check');
        const quantity = Number(item.querySelector('.cart-quantity').value);
        const subtotal = Number(item.dataset.price) * quantity;
        item.querySelector('.item-total').textContent = `¥${subtotal.toFixed(2)}`;
        item.querySelector('.cart-quantity').disabled = !checkbox.checked;
        if (checkbox.checked) { total += subtotal; count += quantity; }
    });
    document.querySelector('#cart-total').textContent = `¥${total.toFixed(2)}`;
    document.querySelector('#selected-count').textContent = `${count} 件`;
};
const syncQuantity = async input => {
    const { data } = await window.axios.post('{{ url('/cars') }}', { product_id: input.dataset.product, number: Number(input.value), action: 'sync' });
    document.querySelector('#cart-message').textContent = data.msg;
};
document.querySelector('#select-all')?.addEventListener('change', event => { document.querySelectorAll('.cart-check').forEach(input => input.checked = event.target.checked); refreshCart(); });
document.querySelector('#cart-items')?.addEventListener('change', async event => { if (event.target.matches('.cart-check')) refreshCart(); if (event.target.matches('.cart-quantity')) { await syncQuantity(event.target); refreshCart(); } });
document.querySelector('#cart-items')?.addEventListener('click', async event => {
    const item = event.target.closest('.cart-item'); if (!item) return;
    const input = item.querySelector('.cart-quantity');
    if (event.target.closest('.cart-minus')) { input.value = Math.max(1, Number(input.value) - 1); await syncQuantity(input); }
    if (event.target.closest('.cart-plus')) { input.value = Math.min(Number(input.max), Number(input.value) + 1); await syncQuantity(input); }
    const deleteButton = event.target.closest('[data-delete-cart]');
    if (deleteButton) { await window.axios.delete(`/cars/${deleteButton.dataset.deleteCart}`); item.remove(); }
    refreshCart();
});
document.querySelector('#cart-form')?.addEventListener('submit', event => { if (!document.querySelector('.cart-check:checked')) { event.preventDefault(); document.querySelector('#cart-message').textContent = '请至少选择一件商品'; } });
refreshCart();
</script>
@endpush
@endauth
