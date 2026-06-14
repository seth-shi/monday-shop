<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Monday Shop，精选好物与限时优惠。">
    <title>@yield('title', 'Monday Shop')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="min-h-screen">
    <div class="border-b border-slate-200 bg-slate-950 py-2 text-center text-xs font-medium text-white">
        新用户注册即享专属优惠，满额订单免运费
    </div>

    <header class="sticky top-0 z-50 border-b border-slate-200/80 bg-white/90 backdrop-blur-xl">
        <div class="shop-container flex h-18 items-center justify-between gap-6">
            <a href="{{ url('/') }}" class="flex items-center gap-3" aria-label="Monday Shop 首页">
                <span class="grid size-10 place-items-center rounded-2xl bg-slate-950 text-lg font-black text-white">M</span>
                <span>
                    <strong class="block text-base leading-none tracking-tight">Monday Shop</strong>
                    <small class="mt-1 block text-[10px] font-semibold uppercase tracking-[0.24em] text-brand-600">Good day, good choice</small>
                </span>
            </a>

            <nav class="hidden items-center gap-8 text-sm font-semibold text-slate-600 md:flex">
                <a class="transition hover:text-brand-600" href="{{ url('/products') }}">全部商品</a>
                <a class="transition hover:text-brand-600" href="{{ url('/categories') }}">商品分类</a>
                <a class="transition hover:text-brand-600" href="{{ url('/coupon_templates') }}">优惠中心</a>
            </nav>

            <div class="flex items-center gap-2">
                <a href="{{ url('/products/search') }}" class="grid size-10 place-items-center rounded-full text-slate-600 transition hover:bg-slate-100" aria-label="搜索">
                    <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
                </a>
                <a href="{{ url('/cars') }}" class="relative grid size-10 place-items-center rounded-full text-slate-600 transition hover:bg-slate-100" aria-label="购物车">
                    <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3h2l2.2 10.2a2 2 0 0 0 2 1.6h7.7a2 2 0 0 0 2-1.6L20 7H6"/><circle cx="10" cy="20" r="1"/><circle cx="18" cy="20" r="1"/></svg>
                    @if (!empty($carSum))<span class="absolute right-0 top-0 min-w-4 rounded-full bg-brand-500 px-1 text-center text-[10px] font-bold text-white">{{ $carSum }}</span>@endif
                </a>
                @auth
                    <a href="{{ url('/user') }}" class="shop-button hidden sm:inline-flex">个人中心</a>
                @else
                    <a href="{{ url('/login') }}" class="shop-button hidden sm:inline-flex">登录</a>
                @endauth
                <button class="grid size-10 place-items-center rounded-full text-slate-700 md:hidden" data-menu-toggle="#mobile-menu" aria-expanded="false" aria-label="打开菜单">
                    <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
                </button>
            </div>
        </div>
        <div id="mobile-menu" class="hidden border-t border-slate-100 bg-white md:hidden">
            <nav class="shop-container grid gap-1 py-4 text-sm font-semibold">
                <a class="rounded-xl px-3 py-3 hover:bg-slate-50" href="{{ url('/products') }}">全部商品</a>
                <a class="rounded-xl px-3 py-3 hover:bg-slate-50" href="{{ url('/categories') }}">商品分类</a>
                <a class="rounded-xl px-3 py-3 hover:bg-slate-50" href="{{ url('/coupon_templates') }}">优惠中心</a>
            </nav>
        </div>
    </header>

    @if (session('status'))
        <div class="shop-container pt-4"><div class="rounded-2xl bg-brand-50 px-4 py-3 text-sm font-medium text-brand-700">{{ session('status') }}</div></div>
    @endif

    <main>@yield('main')</main>

    <footer class="mt-24 border-t border-slate-200 bg-white">
        <div class="shop-container grid gap-10 py-14 md:grid-cols-[1.4fr_1fr_1fr]">
            <div>
                <div class="flex items-center gap-3"><span class="grid size-10 place-items-center rounded-2xl bg-slate-950 font-black text-white">M</span><strong>Monday Shop</strong></div>
                <p class="mt-4 max-w-md text-sm leading-7 text-slate-500">认真挑选每一件商品，让日常消费更简单、更透明，也更有一点期待。</p>
            </div>
            <div><h2 class="text-sm font-bold">购物服务</h2><div class="mt-4 grid gap-3 text-sm text-slate-500"><a href="{{ url('/products') }}">商品列表</a><a href="{{ url('/coupon_templates') }}">优惠券</a><a href="{{ url('/user/orders') }}">我的订单</a></div></div>
            <div><h2 class="text-sm font-bold">账户</h2><div class="mt-4 grid gap-3 text-sm text-slate-500"><a href="{{ url('/user') }}">个人中心</a><a href="{{ url('/user/addresses') }}">收货地址</a><a href="{{ url('/user/notifications') }}">消息通知</a></div></div>
        </div>
        <div class="border-t border-slate-100 py-6 text-center text-xs text-slate-400">© {{ date('Y') }} Monday Shop. All rights reserved.</div>
    </footer>
    @stack('scripts')
</body>
</html>
