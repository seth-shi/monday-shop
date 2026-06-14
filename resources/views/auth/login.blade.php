@extends('layouts.modern')

@section('title', '登录 · Monday Shop')

@section('main')
<section class="shop-container grid min-h-[680px] items-center gap-10 py-14 lg:grid-cols-2">
    <div class="hidden overflow-hidden rounded-[2.5rem] bg-slate-950 p-12 text-white lg:block"><p class="text-xs font-bold uppercase tracking-[0.2em] text-brand-500">Welcome back</p><h1 class="mt-5 text-5xl font-black leading-tight">继续发现<br>值得买的好东西。</h1><p class="mt-6 max-w-md leading-7 text-slate-400">登录后同步购物车、收藏与订单，享受完整的购物体验。</p><div class="mt-24 grid grid-cols-3 gap-4 text-center"><div class="rounded-2xl bg-white/5 p-4"><strong class="block text-2xl">安全</strong><span class="mt-1 text-xs text-slate-400">账户保护</span></div><div class="rounded-2xl bg-white/5 p-4"><strong class="block text-2xl">快捷</strong><span class="mt-1 text-xs text-slate-400">订单同步</span></div><div class="rounded-2xl bg-white/5 p-4"><strong class="block text-2xl">专属</strong><span class="mt-1 text-xs text-slate-400">会员优惠</span></div></div></div>
    <div class="mx-auto w-full max-w-md">
        <p class="text-xs font-bold uppercase tracking-[0.2em] text-brand-600">Account</p><h1 class="mt-3 text-4xl font-black">欢迎回来</h1><p class="mt-3 text-sm text-slate-500">还没有账户？<a href="{{ route('register') }}" class="font-bold text-brand-700">立即注册</a></p>
        @if(session('status'))<div class="mt-6 rounded-2xl bg-brand-50 px-4 py-3 text-sm text-brand-700">{{ session('status') }}</div>@endif
        <form class="mt-8 grid gap-5" method="post" action="{{ route('login') }}">@csrf
            <label class="grid gap-2 text-sm font-bold">用户名或邮箱<input name="account" value="{{ old('account') }}" autocomplete="username" autofocus required class="rounded-2xl border border-slate-300 bg-white px-4 py-3 font-normal outline-none transition focus:border-brand-500 focus:ring-4 focus:ring-brand-50">@error('account')<span class="text-xs font-medium text-rose-600">{!! $message !!}</span>@enderror</label>
            <label class="grid gap-2 text-sm font-bold">密码<input type="password" name="password" autocomplete="current-password" required class="rounded-2xl border border-slate-300 bg-white px-4 py-3 font-normal outline-none transition focus:border-brand-500 focus:ring-4 focus:ring-brand-50">@error('password')<span class="text-xs font-medium text-rose-600">{{ $message }}</span>@enderror</label>
            <div class="flex items-center justify-between text-sm"><label class="flex items-center gap-2 text-slate-600"><input type="checkbox" name="remember" class="size-4 rounded border-slate-300 text-brand-600">保持登录</label><a href="{{ route('password.request') }}" class="font-bold text-brand-700">忘记密码？</a></div>
            <button class="shop-button w-full" type="submit">登录</button>
        </form>
        <div class="my-7 flex items-center gap-3 text-xs text-slate-400"><span class="h-px flex-1 bg-slate-200"></span>或使用其他账户<span class="h-px flex-1 bg-slate-200"></span></div>
        @include('auth.oauth')
    </div>
</section>
@endsection
