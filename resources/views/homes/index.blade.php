@extends('layouts.modern')

@section('title', 'Monday Shop · 精选生活好物')

@section('main')
<section class="overflow-hidden bg-white">
    <div class="shop-container grid min-h-[620px] items-center gap-12 py-16 lg:grid-cols-2 lg:py-24">
        <div class="relative z-10">
            <span class="inline-flex rounded-full border border-brand-100 bg-brand-50 px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-brand-700">New season · 精选上新</span>
            <h1 class="mt-7 max-w-2xl text-5xl font-black leading-[1.08] tracking-[-0.04em] text-slate-950 sm:text-6xl lg:text-7xl">好东西，值得被<br><span class="text-brand-600">简单地发现。</span></h1>
            <p class="mt-6 max-w-xl text-lg leading-8 text-slate-500">从热门单品到每日新选，为你整理更清晰的商品信息、更真实的价格和更轻松的购物体验。</p>
            <div class="mt-9 flex flex-wrap gap-3">
                <a class="shop-button" href="{{ url('/products') }}">开始逛逛 <span class="ml-2">→</span></a>
                <a class="shop-button-secondary" href="{{ url('/coupon_templates') }}">领取优惠</a>
            </div>
            <dl class="mt-12 grid max-w-lg grid-cols-3 gap-6 border-t border-slate-200 pt-7">
                <div><dt class="text-2xl font-black">{{ $categories->count() }}+</dt><dd class="mt-1 text-xs text-slate-500">精选分类</dd></div>
                <div><dt class="text-2xl font-black">{{ $latestProducts->count() }}+</dt><dd class="mt-1 text-xs text-slate-500">本期上新</dd></div>
                <div><dt class="text-2xl font-black">{{ $users->count() }}+</dt><dd class="mt-1 text-xs text-slate-500">活跃用户</dd></div>
            </dl>
        </div>

        <div class="relative mx-auto w-full max-w-xl">
            <div class="absolute -left-12 top-10 size-40 rounded-full bg-brand-100 blur-3xl"></div>
            <div class="absolute -right-12 bottom-0 size-48 rounded-full bg-amber-100 blur-3xl"></div>
            @php($hero = $hotProducts->first())
            <a href="{{ $hero ? url('/products/'.$hero->uuid) : url('/products') }}" class="group relative block overflow-hidden rounded-[2.5rem] bg-slate-100 shadow-2xl shadow-slate-300/50">
                <div class="aspect-[4/5] overflow-hidden">
                    <img src="{{ $hero->thumb ?? asset('images/404.jpg') }}" alt="{{ $hero->name ?? '本周精选商品' }}" class="h-full w-full object-cover transition duration-700 group-hover:scale-105">
                </div>
                <div class="absolute inset-x-4 bottom-4 rounded-3xl bg-white/90 p-5 shadow-lg backdrop-blur-xl">
                    <div class="flex items-end justify-between gap-4">
                        <div><p class="text-xs font-bold uppercase tracking-[0.18em] text-brand-600">本周热门</p><h2 class="mt-2 text-xl font-black">{{ $hero->name ?? '发现更多精选好物' }}</h2></div>
                        @if($hero)<strong class="whitespace-nowrap text-xl">¥{{ number_format($hero->price, 2) }}</strong>@endif
                    </div>
                </div>
            </a>
        </div>
    </div>
</section>

<section class="shop-container py-16">
    <div class="flex items-end justify-between gap-6">
        <div><p class="text-xs font-bold uppercase tracking-[0.2em] text-brand-600">Browse by category</p><h2 class="mt-3 text-3xl font-black tracking-tight">按分类探索</h2></div>
        <a href="{{ url('/categories') }}" class="text-sm font-bold text-slate-600 hover:text-brand-600">查看全部 →</a>
    </div>
    <div class="mt-8 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6">
        @foreach($categories->take(6) as $category)
            <a href="{{ url('/categories/'.$category->id) }}" class="group rounded-3xl border border-slate-200 bg-white p-5 transition hover:-translate-y-1 hover:border-brand-200 hover:shadow-lg">
                <span class="grid size-11 place-items-center rounded-2xl bg-slate-100 text-lg font-black text-slate-700 transition group-hover:bg-brand-500 group-hover:text-white">{{ mb_substr($category->title, 0, 1) }}</span>
                <strong class="mt-5 block text-sm">{{ $category->title }}</strong>
                <span class="mt-1 block text-xs text-slate-400">{{ $category->products_count }} 件商品</span>
            </a>
        @endforeach
    </div>
</section>

@if($isOpenSeckill && $secKills->isNotEmpty())
<section class="shop-container py-8">
    <div class="overflow-hidden rounded-[2rem] bg-slate-950 px-6 py-10 text-white sm:px-10">
        <div class="flex flex-col justify-between gap-8 md:flex-row md:items-center">
            <div><p class="text-xs font-bold uppercase tracking-[0.2em] text-brand-500">Limited offer</p><h2 class="mt-3 text-3xl font-black">限时秒杀正在进行</h2><p class="mt-3 text-sm text-slate-400">库存有限，售完即止。</p></div>
            <div class="flex gap-3 overflow-x-auto pb-2">
                @foreach($secKills->take(3) as $seckill)
                    <a href="{{ url('/seckills/'.$seckill->id) }}" class="min-w-48 rounded-2xl bg-white/10 p-4 transition hover:bg-white/15"><strong class="block truncate">{{ $seckill->name ?? '秒杀商品' }}</strong><span class="mt-2 block text-sm text-brand-500">立即抢购 →</span></a>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

<section class="shop-container py-16">
    <div class="flex items-end justify-between gap-6">
        <div><p class="text-xs font-bold uppercase tracking-[0.2em] text-brand-600">Just arrived</p><h2 class="mt-3 text-3xl font-black tracking-tight">最新上架</h2></div>
        <a href="{{ url('/products') }}" class="text-sm font-bold text-slate-600 hover:text-brand-600">更多商品 →</a>
    </div>
    <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach($latestProducts as $product)
            <article class="shop-card overflow-hidden">
                <a href="{{ url('/products/'.$product->uuid) }}" class="group block aspect-[4/3] overflow-hidden bg-slate-100"><img src="{{ $product->thumb }}" alt="{{ $product->name }}" loading="lazy" class="h-full w-full object-cover transition duration-500 group-hover:scale-105"></a>
                <div class="p-6">
                    <div class="flex items-center justify-between text-xs font-medium text-slate-400"><span>已售 {{ $product->sale_count ?? 0 }}</span><span>{{ $product->users_count }} 人收藏</span></div>
                    <h3 class="mt-3 line-clamp-1 text-lg font-black"><a href="{{ url('/products/'.$product->uuid) }}">{{ $product->name }}</a></h3>
                    <p class="mt-2 line-clamp-2 min-h-10 text-sm leading-5 text-slate-500">{{ strip_tags($product->title) }}</p>
                    <div class="mt-5 flex items-end justify-between"><div><span class="text-2xl font-black">¥{{ number_format($product->price, 2) }}</span><del class="ml-2 text-xs text-slate-400">¥{{ number_format($product->original_price, 2) }}</del></div><span class="grid size-10 place-items-center rounded-full bg-slate-950 text-white">→</span></div>
                </div>
            </article>
        @endforeach
    </div>
</section>

<section class="shop-container pb-8 pt-12">
    <div class="rounded-[2.5rem] bg-brand-600 px-6 py-14 text-center text-white sm:px-12">
        <p class="text-xs font-bold uppercase tracking-[0.2em] text-brand-100">Weekly inspiration</p>
        <h2 class="mt-4 text-3xl font-black sm:text-4xl">每周一封，发现值得买的好东西</h2>
        <p class="mx-auto mt-4 max-w-xl text-sm leading-6 text-brand-100">新品、热卖与限时优惠，克制地发送到你的邮箱。</p>
        @auth
            <form id="subscribe-form" class="mx-auto mt-7 flex max-w-lg flex-col gap-3 sm:flex-row">
                <input id="subscribe-email" type="email" value="{{ $loginUser->subscribe->email ?? $loginUser->email }}" class="min-w-0 flex-1 rounded-full border-0 bg-white px-5 py-3 text-sm text-slate-900 outline-none ring-4 ring-white/10" required>
                <button class="rounded-full bg-slate-950 px-6 py-3 text-sm font-bold" type="submit">{{ $loginUser->subscribe ? '取消订阅' : '立即订阅' }}</button>
            </form>
            <p id="subscribe-message" class="mt-3 text-sm text-brand-100" aria-live="polite"></p>
        @else
            <a href="{{ url('/login') }}" class="mt-7 inline-flex rounded-full bg-slate-950 px-6 py-3 text-sm font-bold">登录后订阅</a>
        @endauth
    </div>
</section>
@endsection

@auth
@push('scripts')
<script>
document.querySelector('#subscribe-form')?.addEventListener('submit', async (event) => {
    event.preventDefault();
    const button = event.currentTarget.querySelector('button');
    const message = document.querySelector('#subscribe-message');
    button.disabled = true;
    try {
        const { data } = await window.axios.put('{{ url('/user/subscribe') }}', { email: document.querySelector('#subscribe-email').value });
        message.textContent = data.msg;
        button.textContent = data.code === 201 ? '取消订阅' : '立即订阅';
    } catch (error) {
        message.textContent = error.response?.data?.msg ?? '操作失败，请稍后重试';
    } finally {
        button.disabled = false;
    }
});
</script>
@endpush
@endauth
