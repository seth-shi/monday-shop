@extends('layouts.modern')

@section('title', $product->name.' · Monday Shop')

@section('main')
@php($gallery = collect($product->pictures ?? [])->prepend($product->thumb)->filter()->unique()->values())
<section class="shop-container py-10 lg:py-16">
    <nav class="mb-7 flex items-center gap-2 text-xs font-medium text-slate-400"><a href="{{ url('/') }}">首页</a><span>/</span><a href="{{ url('/categories/'.$product->category_id) }}">商品分类</a><span>/</span><span class="text-slate-700">{{ $product->name }}</span></nav>

    <div class="grid gap-10 lg:grid-cols-2 lg:gap-16">
        <div>
            <div class="aspect-square overflow-hidden rounded-[2rem] bg-white ring-1 ring-slate-200"><img id="product-image" src="{{ $gallery->first() }}" alt="{{ $product->name }}" class="h-full w-full object-contain p-4"></div>
            @if($gallery->count() > 1)
                <div class="mt-4 grid grid-cols-5 gap-3">@foreach($gallery as $image)<button type="button" data-gallery-image="{{ assertUrl($image) }}" class="aspect-square overflow-hidden rounded-2xl border border-slate-200 bg-white p-1 transition hover:border-brand-500"><img src="{{ assertUrl($image) }}" alt="" class="h-full w-full rounded-xl object-cover"></button>@endforeach</div>
            @endif
        </div>

        <div class="lg:pt-5">
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-brand-600">In stock · 库存 {{ $product->count }}</p>
            <h1 class="mt-4 text-4xl font-black leading-tight tracking-tight sm:text-5xl">{{ $product->name }}</h1>
            <p class="mt-5 text-base leading-7 text-slate-500">{{ strip_tags($product->title) }}</p>
            <div class="mt-7 flex items-end gap-3"><strong class="text-4xl font-black">¥{{ number_format($product->price, 2) }}</strong>@if($product->original_price > $product->price)<del class="pb-1 text-sm text-slate-400">¥{{ number_format($product->original_price, 2) }}</del><span class="mb-1 rounded-full bg-rose-50 px-2 py-1 text-xs font-bold text-rose-600">立省 ¥{{ number_format($product->original_price - $product->price, 2) }}</span>@endif</div>

            <dl class="mt-8 grid grid-cols-3 divide-x divide-slate-200 rounded-2xl border border-slate-200 bg-white py-5 text-center"><div><dt class="text-xl font-black">{{ $product->sale_count }}</dt><dd class="mt-1 text-xs text-slate-400">累计销量</dd></div><div><dt class="text-xl font-black">{{ $product->view_count }}</dt><dd class="mt-1 text-xs text-slate-400">浏览次数</dd></div><div><dt id="likes-count" class="text-xl font-black">{{ $product->users->count() }}</dt><dd class="mt-1 text-xs text-slate-400">收藏人数</dd></div></dl>

            @include('hint.fail')
            @include('hint.validate_errors')
            @include('hint.status')

            <div class="mt-8"><label for="quantity" class="text-sm font-bold">购买数量</label><div class="mt-3 inline-flex items-center rounded-full border border-slate-300 bg-white p-1"><button id="quantity-minus" type="button" class="grid size-10 place-items-center rounded-full text-lg hover:bg-slate-100">−</button><input id="quantity" type="number" min="1" max="{{ $product->count }}" value="1" class="w-14 border-0 bg-transparent text-center font-bold outline-none"><button id="quantity-plus" type="button" class="grid size-10 place-items-center rounded-full text-lg hover:bg-slate-100">+</button></div></div>

            <div class="mt-8 grid gap-3 sm:grid-cols-2">
                @auth
                    <button id="buy-now" type="button" class="shop-button">立即购买</button>
                    <button id="add-cart" type="button" class="shop-button-secondary">加入购物车</button>
                @else
                    <a href="{{ url('/login') }}" class="shop-button">登录后购买</a>
                    <a href="{{ url('/login') }}" class="shop-button-secondary">登录后加入购物车</a>
                @endauth
            </div>
            <div class="mt-4 flex items-center justify-between"><p id="product-message" class="text-sm font-medium text-brand-700" aria-live="polite"></p>@auth<button id="like-product" type="button" class="inline-flex items-center gap-2 text-sm font-bold text-slate-600 hover:text-rose-600"><span>{{ $product->userIsLike ? '♥' : '♡' }}</span><span>{{ $product->userIsLike ? '已收藏' : '收藏商品' }}</span></button>@else<a href="{{ url('/login') }}" class="text-sm font-bold text-slate-600">♡ 收藏商品</a>@endauth</div>

            <div class="mt-8 grid gap-3 border-t border-slate-200 pt-6 text-sm text-slate-500 sm:grid-cols-3"><span>✓ 安全支付</span><span>✓ 正品保障</span><span>✓ 售后支持</span></div>
        </div>
    </div>
</section>

<section class="shop-container py-12">
    <div class="grid gap-10 lg:grid-cols-[1fr_320px]">
        <div class="space-y-8">
            <article class="rounded-[2rem] border border-slate-200 bg-white p-6 sm:p-9"><h2 class="text-2xl font-black">商品详情</h2><div class="prose prose-slate mt-6 max-w-none overflow-hidden leading-8 text-slate-600">{!! $product->detail?->content ?: '<p>暂无更多商品详情。</p>' !!}</div></article>
            <article class="rounded-[2rem] border border-slate-200 bg-white p-6 sm:p-9"><div class="flex items-end justify-between"><h2 class="text-2xl font-black">用户评价</h2><span class="text-sm text-slate-400">{{ $product->comments->count() }} 条</span></div><div class="mt-7 divide-y divide-slate-100">@forelse($product->comments as $comment)<div class="flex gap-4 py-6 first:pt-0"><img src="{{ $comment->user->avatar }}" alt="" class="size-11 rounded-full object-cover"><div class="min-w-0 flex-1"><div class="flex flex-wrap items-center justify-between gap-2"><strong class="text-sm">{{ $comment->user->name }}</strong><span class="text-xs text-slate-400">{{ $comment->created_at }}</span></div><p class="mt-1 text-amber-500">{{ str_repeat('★', $comment->score) }}<span class="text-slate-200">{{ str_repeat('★', 5 - $comment->score) }}</span></p><p class="mt-3 text-sm leading-6 text-slate-600">{{ $comment->content }}</p></div></div>@empty<p class="py-8 text-sm text-slate-500">还没有评价，购买后欢迎分享体验。</p>@endforelse</div></article>
        </div>
        <aside><div class="sticky top-28"><h2 class="text-xl font-black">相关推荐</h2><div class="mt-5 grid gap-4">@foreach($recommendProducts as $recommendProduct)<a href="{{ url('/products/'.$recommendProduct->uuid) }}" class="flex gap-4 rounded-2xl border border-slate-200 bg-white p-3 transition hover:border-brand-300"><img src="{{ $recommendProduct->thumb }}" alt="{{ $recommendProduct->name }}" class="size-20 rounded-xl object-cover"><div class="min-w-0 py-1"><strong class="line-clamp-2 text-sm">{{ $recommendProduct->name }}</strong><span class="mt-3 block font-black">¥{{ number_format($recommendProduct->price, 2) }}</span></div></a>@endforeach</div></div></aside>
    </div>
</section>
@endsection

@push('scripts')
<script>
const quantity = document.querySelector('#quantity');
const message = document.querySelector('#product-message');
document.querySelector('#quantity-minus')?.addEventListener('click', () => quantity.value = Math.max(1, Number(quantity.value) - 1));
document.querySelector('#quantity-plus')?.addEventListener('click', () => quantity.value = Math.min(Number(quantity.max), Number(quantity.value) + 1));
document.querySelectorAll('[data-gallery-image]').forEach(button => button.addEventListener('click', () => document.querySelector('#product-image').src = button.dataset.galleryImage));

@auth
document.querySelector('#add-cart')?.addEventListener('click', async () => {
    try {
        const { data } = await window.axios.post('{{ url('/cars') }}', { product_id: '{{ $product->uuid }}', number: Number(quantity.value) });
        message.textContent = data.msg;
    } catch (error) { message.textContent = error.response?.data?.msg ?? '加入购物车失败'; }
});
document.querySelector('#buy-now')?.addEventListener('click', () => window.location.href = `{{ url('/user/comment/orders/create') }}?ids[]={{ $product->uuid }}&numbers[]=${quantity.value}`);
document.querySelector('#like-product')?.addEventListener('click', async (event) => {
    const { data } = await window.axios.put('{{ url('/user/likes/'.$product->uuid) }}');
    const active = data.code === 201;
    event.currentTarget.querySelector('span:first-child').textContent = active ? '♥' : '♡';
    event.currentTarget.querySelector('span:last-child').textContent = active ? '已收藏' : '收藏商品';
    document.querySelector('#likes-count').textContent = Math.max(0, Number(document.querySelector('#likes-count').textContent) + (active ? 1 : -1));
    message.textContent = data.msg;
});
@endauth
</script>
@endpush
