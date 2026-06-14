@extends('layouts.account')

@section('title', '修改密码 - Monday Shop')

@section('account')
<div><span class="shop-kicker">Security</span><h1 class="mt-2 text-3xl font-black">修改密码</h1><p class="mt-2 text-sm text-slate-500">建议使用至少 8 位、包含字母与数字的独立密码。</p></div>
@include('hint.status') @include('hint.validate_errors')
<section class="shop-card mt-7 max-w-2xl p-6 lg:p-8"><form action="{{ url('/user/password') }}" method="post" class="grid gap-5">@csrf
    @unless($user->is_init_password)<label class="grid gap-2 text-sm font-bold">当前密码<input class="shop-input" type="password" name="old_password" autocomplete="current-password" required></label>@endunless
    <label class="grid gap-2 text-sm font-bold">新密码<input class="shop-input" type="password" name="password" autocomplete="new-password" minlength="6" required></label>
    <label class="grid gap-2 text-sm font-bold">确认新密码<input class="shop-input" type="password" name="password_confirmation" autocomplete="new-password" minlength="6" required></label>
    <div><button class="shop-button-primary">更新密码</button></div>
</form></section>
@endsection
