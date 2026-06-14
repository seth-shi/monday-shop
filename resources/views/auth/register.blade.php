@extends('layouts.modern')

@section('title', '注册 · Monday Shop')

@section('main')
<section class="shop-container py-14"><div class="mx-auto max-w-xl rounded-[2.5rem] border border-slate-200 bg-white p-6 shadow-xl shadow-slate-200/40 sm:p-10"><p class="text-xs font-bold uppercase tracking-[0.2em] text-brand-600">Create account</p><h1 class="mt-3 text-4xl font-black">创建你的账户</h1><p class="mt-3 text-sm text-slate-500">已有账户？<a href="{{ route('login') }}" class="font-bold text-brand-700">直接登录</a></p>
    <form class="mt-8 grid gap-5" method="post" action="{{ route('register') }}">@csrf
        <label class="grid gap-2 text-sm font-bold">用户名<input name="name" value="{{ old('name') }}" required autofocus autocomplete="username" class="rounded-2xl border border-slate-300 px-4 py-3 font-normal outline-none focus:border-brand-500 focus:ring-4 focus:ring-brand-50">@error('name')<span class="text-xs text-rose-600">{{ $message }}</span>@enderror</label>
        <label class="grid gap-2 text-sm font-bold">邮箱<input type="email" name="email" value="{{ old('email') }}" required autocomplete="email" class="rounded-2xl border border-slate-300 px-4 py-3 font-normal outline-none focus:border-brand-500 focus:ring-4 focus:ring-brand-50">@error('email')<span class="text-xs text-rose-600">{{ $message }}</span>@enderror</label>
        <fieldset><legend class="text-sm font-bold">性别</legend><div class="mt-3 flex gap-5 text-sm text-slate-600"><label class="flex items-center gap-2"><input type="radio" name="sex" value="1" @checked(old('sex', 1) == 1)>男</label><label class="flex items-center gap-2"><input type="radio" name="sex" value="2" @checked(old('sex') == 2)>女</label></div>@error('sex')<span class="mt-2 block text-xs text-rose-600">{{ $message }}</span>@enderror</fieldset>
        <div class="grid gap-5 sm:grid-cols-2"><label class="grid gap-2 text-sm font-bold">密码<input type="password" name="password" required autocomplete="new-password" class="rounded-2xl border border-slate-300 px-4 py-3 font-normal outline-none focus:border-brand-500 focus:ring-4 focus:ring-brand-50">@error('password')<span class="text-xs text-rose-600">{{ $message }}</span>@enderror</label><label class="grid gap-2 text-sm font-bold">确认密码<input type="password" name="password_confirmation" required autocomplete="new-password" class="rounded-2xl border border-slate-300 px-4 py-3 font-normal outline-none focus:border-brand-500 focus:ring-4 focus:ring-brand-50"></label></div>
        <label class="grid gap-2 text-sm font-bold">验证码<div class="flex overflow-hidden rounded-2xl border border-slate-300 focus-within:border-brand-500 focus-within:ring-4 focus-within:ring-brand-50"><input name="captcha" maxlength="4" required class="min-w-0 flex-1 border-0 px-4 py-3 font-normal outline-none"><img src="{{ url('/captcha') }}" onclick="this.src='{{ url('/captcha') }}?'+Math.random()" alt="刷新验证码" class="h-12 w-36 cursor-pointer object-cover"></div>@error('captcha')<span class="text-xs text-rose-600">{{ $message }}</span>@enderror</label>
        <label class="flex items-start gap-3 text-sm leading-6 text-slate-500"><input type="checkbox" required class="mt-1 size-4 rounded border-slate-300">我已阅读并同意 Monday Shop 的服务条款与隐私说明。</label>
        <button class="shop-button w-full" type="submit">创建账户</button>
    </form>
    <div class="my-7 flex items-center gap-3 text-xs text-slate-400"><span class="h-px flex-1 bg-slate-200"></span>快捷注册<span class="h-px flex-1 bg-slate-200"></span></div>@include('auth.oauth')
</div></section>
@endsection
